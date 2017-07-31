<?php

class UserController extends Controller
{
  /**
   * Application landing page. Show the checkin for and handle input.
   */
  public function actionIndex()
  {
    $checkinForm = new CheckinForm();

    if (isset($_POST['ajax']) && $_POST['ajax'] === 'checkin-form')
    {
      echo CActiveForm::validate($checkinForm);
      Yii::app()->end();
    }

    if (isset($_POST['CheckinForm'])) 
    {
      $checkinForm->attributes = $_POST['CheckinForm'];
      if ($checkinForm->validate()) 
      {
        // find user with phone number
        $user = User::model()->find('phone=:phone', array(':phone' => $checkinForm->phone));

        // phone not found, redirect to register
        if (!$user) {
          Yii::app()->user->setFlash('warning', 'You must register before you can check in.');
          $this->redirect(array('user/register'));
        }

        // save user ID to the session
        Yii::app()->session['user_id'] = $user->id;

        // find checkins in the last 5 minutes, if there is one, redirect to the list
        $recentCheckin = Checkin::model()->find('user_id = ' . $user->id . ' AND created_at > \'' . date('Y-m-d H:i:s', strtotime('-5 minutes')) . '\'');
        if ($recentCheckin) {
          Yii::app()->user->setFlash('warning', 'It\'s too soon. Please wait a bit before checking in again.');
          $this->redirect(array('user/checkins'));
        }

        // add a 20 point checkin for the user
        $checkin = new Checkin;
        $checkin->user_id = $user->id;
        $checkin->num_points = 20;
        if (!$checkin->save()) {
          Yii::app()->user->setFlash('error', 'Failed saving check in. Please try again.');
          $this->refresh();
        }

        $this->sendEmail($user);

        // redirect to checkins
        Yii::app()->user->setFlash('success', 'Saved a new check in for 20 points.');
        $this->redirect(array('user/checkins'));
      }
    }

    $this->render('index', array(
      'model' => $checkinForm
    ));
  }
  
  /**
   * Allow new users to create an account.
   */
  public function actionRegister()
  {
    $user = new User('register');

    // uncomment the following code to enable ajax-based validation
    if(isset($_POST['ajax']) && $_POST['ajax'] === 'user-register-form')
    {
      echo CActiveForm::validate($user);
      Yii::app()->end();
    }

    // handle form submission
    if(isset($_POST['User']))
    {
      $user->attributes = $_POST['User'];
      if($user->validate())
      {
        // form inputs are valid, create the user
        if (!$user->save()) {
          Yii::app()->user->setFlash('error', 'Failed saving user. Please try again.');
          $this->refresh();
        }

        // add a 50 point first checkin for the user
        $checkin = new Checkin;
        $checkin->user_id = $user->id;
        $checkin->num_points = 50;
        if (!$checkin->save()) {
          Yii::app()->user->setFlash('error', 'Failed saving check in. Please try again.');
          $this->refresh();
        }

        // save user ID to the session
        Yii::app()->session['user_id'] = $user->id;

        $this->sendEmail($user);

        // redirect to the checkin list
        Yii::app()->user->setFlash('success', 'Your account has been created and you were awarded 50 points.');
        $this->redirect(array('user/checkins'));
      }
    }

    $this->render('register', array('model' => $user));
  }

  /**
   * Show the current user's list of checkins.
   */
  public function actionCheckins()
  {
    // get user id from session, or redirect to checkin
    $userId = Yii::app()->session['user_id'];
    if (!$userId) 
    {
      Yii::app()->user->setFlash('warning', 'You must check in before you can view your points.');
      $this->redirect(array('user/index'));
      $this->redirect('/');
    }

    $checkinMetrics = Yii::app()->db->createCommand()
      ->select('COUNT(*) AS total_checkins, SUM(num_points) AS total_points')
      ->from('checkins')
      ->where("user_id=$userId")
      ->queryRow();

    // get checkins for user
    $this->render('checkins', array(
      'checkinMetrics' => $checkinMetrics
    ));
  }

  /**
   * Send email to a user with their total points.
   * @param UserModel $user The user get points for and send mail to.
   */
  protected function sendEmail($user)
  {
    $checkinCount = Yii::app()->db->createCommand()
      ->select('COUNT(*) AS total_checkins')
      ->from('checkins')
      ->where("user_id={$user->id}")
      ->queryRow();

    $message = "Thanks for checking in! You new point total is {$checkinCount['total_checkins']} points.";
    $headers = "From: Checkin App <checkinapp@example.com>\r\n".
      "Reply-To: checkinapp@example.com\r\n".
      "MIME-Version: 1.0\r\n".
      "Content-Type: text/plain; charset=UTF-8";

    mail($user->email, 'Thanks for checking in!', $message , $headers);
  }
}
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
          $this->redirect(array('user/register'));
        }

        // save user ID to the session
        Yii::app()->session['user_id'] = $user->id;

        // find checkins in the last 5 minutes, if there is one, redirect to the list
        $recentCheckin = Checkin::model()->find('user_id = ' . $user->id . ' AND created_at > \'' . date('Y-m-d H:i:s', strtotime('-5 minutes')) . '\'');
        if ($recentCheckin) {
          $this->redirect(array('user/checkins'));
        }

        // add a 20 point checkin for the user
        $checkin = new Checkin;
        $checkin->user_id = $user->id;
        $checkin->num_points = 20;
        if (!$checkin->save()) {
          // failed saving checkin!
          die('failed saving checkin');
        }

        $this->sendEmail($user);

        // redirect to checkins
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
          // failed saving user!
          die('failed saving user');
        }

        // add a 50 point first checkin for the user
        $checkin = new Checkin;
        $checkin->user_id = $user->id;
        $checkin->num_points = 50;
        if (!$checkin->save()) {
          // failed saving checkin!
          die('failed saving checkin');
        }

        // save user ID to the session
        Yii::app()->session['user_id'] = $user->id;

        $this->sendEmail($user);

        // redirect to the checkin list
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
      $this->redirect(array('user'));
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
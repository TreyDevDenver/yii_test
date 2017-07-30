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

        // send email

        // redirect to checkins
        if ($recentCheckin) {
          $this->redirect(array('user/checkins'));
        }
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

  // Uncomment the following methods and override them if needed
  /*
  public function filters()
  {
    // return the filter configuration for this controller, e.g.:
    return array(
      'inlineFilterName',
      array(
        'class'=>'path.to.FilterClass',
        'propertyName'=>'propertyValue',
      ),
    );
  }

  public function actions()
  {
    // return external action classes, e.g.:
    return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
        'class'=>'path.to.AnotherActionClass',
        'propertyName'=>'propertyValue',
      ),
    );
  }
  */
}
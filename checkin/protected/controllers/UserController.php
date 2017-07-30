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
      if ($checkinForm->validates()) 
      {
        // find user with phone number
        // maybe add new checkin
        // send email
        // save user id to session
        // redirect to checkins
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
    // get user id from session
    // get checkins for user
    $this->render('checkins');
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
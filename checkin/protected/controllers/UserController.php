<?php

class UserController extends Controller
{
	/**
	 * Application landing page. Show the checkin for and handle input.
	 */
	public function actionIndex()
	{
		$model = new CheckinForm();

		if(isset($_POST['ajax']) && $_POST['ajax']==='checkin-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }

		$this->render('index', array(
			'model' => $model
		));
	}
	
	/**
	 * Allow new users to create an account.
	 */
	public function actionRegister()
	{
		$model=new User('register');

    // uncomment the following code to enable ajax-based validation
    if(isset($_POST['ajax']) && $_POST['ajax']==='user-register-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }

    if(isset($_POST['User']))
    {
        $model->attributes=$_POST['User'];
        if($model->validate())
        {
            // form inputs are valid, do something here
            return;
        }
    }
    $this->render('register',array('model'=>$model));
	}

	/**
	 * Show the current user's list of checkins.
	 */
	public function actionCheckins()
	{
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
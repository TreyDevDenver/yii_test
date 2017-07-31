<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Register';
?>

<div class="jumbotron">
	<h1>Register</h1>
	<p>Complete the form below to earn 50 points.</p>
</div>

<?php
$this->widget('application.components.FlashWidget');
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-register-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
	'errorMessageCssClass' => 'alert alert-warning',
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name', array(
			'class' => 'form-control'
		)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name', array(
			'class' => 'form-control'
		)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->emailField($model,'email', array(
			'class' => 'form-control',
		)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->telField($model,'phone', array(
			'class' => 'form-control'
		)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>
	
	<?php echo CHtml::submitButton('Submit', array(
		'class' => 'btn btn-default'
	)); ?>

<?php $this->endWidget(); ?>
<?php
/* @var $this UserController */

$this->pageTitle=Yii::app()->name . ' - Check In';
?>

<div class="jumbotron">
	<h1>Check In</h1>
	<p>Please enter your phone number below to check in and receive more points.</p>
</div>

<div class="well">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'checkin-form',
	'enableAjaxValidation' => true,
	'errorMessageCssClass' => 'alert alert-warning',
)); ?>

  <div class="form-group">
		<?php echo $form->labelEx($model, 'phone'); ?>
		<?php echo $form->telField($model, 'phone', array(
			'class' => 'form-control'
		)); ?>
		<?php echo $form->error($model, 'phone'); ?>
	</div>

	<?php echo CHtml::submitButton('Submit', array(
		'class' => 'btn btn-default'
	)); ?>

<?php $this->endWidget(); ?>

</div>
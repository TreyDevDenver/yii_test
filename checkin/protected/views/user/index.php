<?php
?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'checkin-form',
	'enableAjaxValidation' => true,
)); ?>

  <div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone'); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
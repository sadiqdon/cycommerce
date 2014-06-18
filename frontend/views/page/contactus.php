
<div class="section_head_general">Contact Us</div>
<div class="section_body_general">
<div class="inner_wrapper">
<p>Please fill out the following form and we will get back to you shortly:</p>

<?php echo CHtml::errorSummary($model); ?>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'contactus-form',
	'enableAjaxValidation' => true,
	/*'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),*/
)); ?>
	<div class="row-fluid">
		<?php echo $form->label($model, 'name');?>
		<?php echo $form->textField($model, 'name'); ?>
		<?php echo $form->error($model, 'name');?>
	</div>
	<br/>
	<div class="row-fluid">
		<?php echo $form->label($model, 'email');?>
		<?php echo $form->textField($model, 'email'); ?>
		<?php echo $form->error($model, 'email');?>
	</div>
	<br/>
	<div class="row-fluid">
		<?php echo $form->label($model, 'subject');?>
		<?php echo $form->textField($model, 'subject'); ?>
		<?php echo $form->error($model, 'subject');?>
	</div>
	<br/>
	<div class="row-fluid">
		<?php echo $form->label($model, 'comment');?>
		<?php echo $form->textArea($model, 'comment', array('row'=>8,'col'=>10)); ?>
		<?php echo $form->error($model, 'comment');?>
	</div>
	<br/>
	<div class="row-fluid">
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model, 'verifyCode'); ?>
	</div>
	<br/>
	<div class="row-fluid actions">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div>
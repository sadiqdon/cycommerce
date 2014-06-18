<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model, $description)); ?>

	<div class="row">
		<?php echo $form->labelEx($description,'name'); ?>
		<?php echo $form->textField($description,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($description,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($description,'description'); ?>
		<?php $this->widget('yiiwheels.widgets.redactor.WhRedactor', array(
			'model' => $description,
			'attribute' => 'description',
			'pluginOptions' => array(
				'lang' => Yii::app()->getLanguage(),
			)
		));?>
		<?php echo $form->error($description,'description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($description,'meta_description'); ?>
		<?php echo $form->textField($description,'meta_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($description,'meta_description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($description,'meta_keyword'); ?>
		<?php echo $form->textField($description,'meta_keyword',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($description,'meta_keyword'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($description,'tag'); ?>
		<?php echo $form->textArea($description,'tag',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($description,'tag'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

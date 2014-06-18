<?php
/* @var $this CountryController */
/* @var $model Country */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'country-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iso_code_2'); ?>
		<?php echo $form->textField($model,'iso_code_2',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'iso_code_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'iso_code_3'); ?>
		<?php echo $form->textField($model,'iso_code_3',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'iso_code_3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address_format'); ?>
		<?php echo $form->textArea($model,'address_format',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address_format'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'postcode_required'); ?>
		<?php echo $form->textField($model,'postcode_required'); ?>
		<?php echo $form->error($model,'postcode_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('country/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
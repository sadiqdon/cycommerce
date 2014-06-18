<?php
/* @var $this SpecialOrderController */
/* @var $model SpecialOrder */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'special-order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'product_name'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'product_quantity'); ?>
		<?php echo $form->textField($model,'product_quantity',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'product_quantity'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'product_colour'); ?>
		<?php echo $form->textField($model,'product_colour',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'product_colour'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'specification'); ?>
		<?php echo $form->textArea($model,'specification',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'specification'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row-fluid buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Submit Order') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('site')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
/* @var $this TaxRateController */
/* @var $model TaxRate */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tax-rate-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, $description); ?>

	<div class="row">
		<?php echo $form->labelEx($description,'name'); ?>
		<?php echo $form->textField($description,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($description,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($description,'type'); ?>
		<?php echo $form->textField($description,'type',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($description,'type'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'geo_zone_id'); ?>
		<?php echo $form->textField($model,'geo_zone_id'); ?>
		<?php echo $form->error($model,'geo_zone_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rate'); ?>
		<?php echo $form->textField($model,'rate',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'rate'); ?>
	</div>

	<!--<div class="row">-->
		<?php //echo $form->labelEx($model,'date_added'); ?>
		<?php //echo $form->textField($model,'date_added'); ?>
		<?php //echo $form->error($model,'date_added'); ?>
	<!--</div>-->

	<!--<div class="row">-->
		<?php //echo $form->labelEx($model,'date_modified'); ?>
		<?php //echo $form->textField($model,'date_modified'); ?>
		<?php //echo $form->error($model,'date_modified'); ?>
	<!--</div>-->

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('taxrate/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
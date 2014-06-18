<?php
/* @var $this WeightClassController */
/* @var $model WeightClass */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'weight-class-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, $description); ?>

	<div class="row">
		<?php echo $form->labelEx($description,'name'); ?>
		<?php echo $form->textField($description,'name',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($description,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($description,'unit'); ?>
		<?php echo $form->textField($description,'unit',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($description,'unit'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('weightclass/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
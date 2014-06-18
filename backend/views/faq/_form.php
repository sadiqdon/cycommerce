<?php
/* @var $this FaqController */
/* @var $model Faq */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model,$description)); ?>
	
	<div class="row">
		
	<div class="row">
		<?php echo $form->labelEx($description,'title'); ?>
		<?php echo $form->textField($description, 'title'); ?>
		<?php echo $form->error($description,'title'); ?>
	</div><!-- row -->
	
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
	
	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('faq/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
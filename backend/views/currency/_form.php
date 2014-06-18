<?php
/* @var $this CurrencyController */
/* @var $model Currency */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'currency-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'symbol_left'); ?>
		<?php echo $form->textField($model,'symbol_left',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'symbol_left'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'symbol_right'); ?>
		<?php echo $form->textField($model,'symbol_right',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'symbol_right'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'decimal_place'); ?>
		<?php echo $form->textField($model,'decimal_place',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'decimal_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_modified'); ?>
		<?php echo $form->textField($model,'date_modified'); ?>
		<?php echo $form->error($model,'date_modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('currency/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
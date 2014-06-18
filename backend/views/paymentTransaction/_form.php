<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'payment-transaction-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	
	<div class="row">
		<?php echo $form->labelEx($model,'transaction_date'); ?>
		<?php echo $form->textField($model,'transaction_date',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'transaction_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reference_number'); ?>
		<?php echo $form->textField($model,'reference_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'reference_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_reference'); ?>
		<?php echo $form->textField($model,'payment_reference',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'payment_reference'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approved_amount'); ?>
		<?php echo $form->textField($model,'approved_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'approved_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'response_description'); ?>
		<?php echo $form->textField($model,'response_description',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'response_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'response_code'); ?>
		<?php echo $form->textField($model,'response_code',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'response_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_amount'); ?>
		<?php echo $form->textField($model,'transaction_amount',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'transaction_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_name'); ?>
		<?php echo $form->textField($model,'customer_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'customer_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'query_date'); ?>
		<?php echo $form->textField($model,'query_date'); ?>
		<?php echo $form->error($model,'query_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('paymenttransaction/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
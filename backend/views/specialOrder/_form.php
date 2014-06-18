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

	
	<div class="row">
		<?php echo $form->labelEx($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'product_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_quantity'); ?>
		<?php echo $form->textField($model,'product_quantity',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'product_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_colour'); ?>
		<?php echo $form->textField($model,'product_colour',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'product_colour'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'specification'); ?>
		<?php echo $form->textArea($model,'specification',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'specification'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_status_id'); ?>
		<?php echo $form->dropDownList($model,'order_status_id', CHtml::listData(OrderStatus::model()->findAll(), 'id', function($data){return $data->getName();})); ?>
		<?php echo $form->error($model,'order_status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address_1'); ?>
		<?php echo $form->textField($model,'address_1',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'address_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address_2'); ?>
		<?php echo $form->textField($model,'address_2',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'address_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'postal_code'); ?>
		<?php echo $form->textField($model,'postal_code',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'postal_code'); ?>
	</div>
<!--
	<div class="row">
		<?php //echo $form->labelEx($model,'country_id'); ?>
		<?php //echo $form->textField($model,'country_id'); ?>
		<?php //echo $form->error($model,'country_id'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->labelEx($model,'zone_id'); ?>
		<?php echo $form->dropDownList($model,'zone_id', CHtml::listData(Zone::model()->findAll('country_id=:c_id',array(':c_id'=>156)), 'id','name')); ?>
		<?php echo $form->error($model,'zone_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('specialorder/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
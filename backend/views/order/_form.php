<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?><div class="form aform">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary(array($model, $description)); ?>

	<div class="row">
		<?php echo $form->labelEx($description,'comment'); ?>
		<?php echo $form->textArea($description,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($description,'comment'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'invoice_no'); ?>
		<?php echo $form->textField($model,'invoice_no'); ?>
		<?php echo $form->error($model,'invoice_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_prefix'); ?>
		<?php echo $form->textField($model,'invoice_prefix',array('size'=>26,'maxlength'=>26)); ?>
		<?php echo $form->error($model,'invoice_prefix'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_id'); ?>
		<?php echo $form->textField($model,'store_id'); ?>
		<?php echo $form->error($model,'store_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_name'); ?>
		<?php echo $form->textField($model,'store_name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'store_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'store_url'); ?>
		<?php echo $form->textField($model,'store_url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'store_url'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_group_id'); ?>
		<?php echo $form->textField($model,'customer_group_id'); ?>
		<?php echo $form->error($model,'customer_group_id'); ?>
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
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>96)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model,'fax',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'fax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_firstname'); ?>
		<?php echo $form->textField($model,'payment_firstname',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'payment_firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_lastname'); ?>
		<?php echo $form->textField($model,'payment_lastname',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'payment_lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_company'); ?>
		<?php echo $form->textField($model,'payment_company',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'payment_company'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_company_id'); ?>
		<?php echo $form->textField($model,'payment_company_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'payment_company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_tax_id'); ?>
		<?php echo $form->textField($model,'payment_tax_id',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'payment_tax_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_address_1'); ?>
		<?php echo $form->textField($model,'payment_address_1',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_address_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_address_2'); ?>
		<?php echo $form->textField($model,'payment_address_2',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_address_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_city'); ?>
		<?php echo $form->textField($model,'payment_city',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_postcode'); ?>
		<?php echo $form->textField($model,'payment_postcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'payment_postcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_country'); ?>
		<?php echo $form->textField($model,'payment_country',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_country_id'); ?>
		<?php echo $form->textField($model,'payment_country_id'); ?>
		<?php echo $form->error($model,'payment_country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_zone'); ?>
		<?php echo $form->textField($model,'payment_zone',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_zone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_zone_id'); ?>
		<?php echo $form->textField($model,'payment_zone_id'); ?>
		<?php echo $form->error($model,'payment_zone_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_address_format'); ?>
		<?php echo $form->textArea($model,'payment_address_format',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'payment_address_format'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_method'); ?>
		<?php echo $form->textField($model,'payment_method',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_code'); ?>
		<?php echo $form->textField($model,'payment_code',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'payment_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_firstname'); ?>
		<?php echo $form->textField($model,'shipping_firstname',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'shipping_firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_lastname'); ?>
		<?php echo $form->textField($model,'shipping_lastname',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'shipping_lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_company'); ?>
		<?php echo $form->textField($model,'shipping_company',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'shipping_company'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_address_1'); ?>
		<?php echo $form->textField($model,'shipping_address_1',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'shipping_address_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_address_2'); ?>
		<?php echo $form->textField($model,'shipping_address_2',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'shipping_address_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_city'); ?>
		<?php echo $form->textField($model,'shipping_city',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'shipping_city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_postcode'); ?>
		<?php echo $form->textField($model,'shipping_postcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'shipping_postcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_country'); ?>
		<?php echo $form->textField($model,'shipping_country',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'shipping_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_country_id'); ?>
		<?php echo $form->textField($model,'shipping_country_id'); ?>
		<?php echo $form->error($model,'shipping_country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_zone'); ?>
		<?php echo $form->textField($model,'shipping_zone',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'shipping_zone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_zone_id'); ?>
		<?php echo $form->textField($model,'shipping_zone_id'); ?>
		<?php echo $form->error($model,'shipping_zone_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_address_format'); ?>
		<?php echo $form->textArea($model,'shipping_address_format',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'shipping_address_format'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_method'); ?>
		<?php echo $form->textField($model,'shipping_method',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'shipping_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_code'); ?>
		<?php echo $form->textField($model,'shipping_code',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'shipping_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_status_id'); ?>
		<?php echo $form->textField($model,'order_status_id'); ?>
		<?php echo $form->error($model,'order_status_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_id'); ?>
		<?php echo $form->textField($model,'currency_id'); ?>
		<?php echo $form->error($model,'currency_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_code'); ?>
		<?php echo $form->textField($model,'currency_code',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'currency_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_value'); ?>
		<?php echo $form->textField($model,'currency_value',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'currency_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'forwarded_ip'); ?>
		<?php echo $form->textField($model,'forwarded_ip',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'forwarded_ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_agent'); ?>
		<?php echo $form->textField($model,'user_agent',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'user_agent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accept_language'); ?>
		<?php echo $form->textField($model,'accept_language',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'accept_language'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_added'); ?>
		<?php echo $form->textField($model,'date_added'); ?>
		<?php echo $form->error($model,'date_added'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_modified'); ?>
		<?php echo $form->textField($model,'date_modified'); ?>
		<?php echo $form->error($model,'date_modified'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
		<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('order/admin')));?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>

<div class="aform form">


<?php $form = $this->beginWidget('TbActiveForm', array(
	'id' => 'payment-address-form',
	'enableAjaxValidation' => false,
));
?>

	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo $form->errorSummary($model); ?>

		
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_firstname"); ?>
		<?php echo $form->textField($model,"shipping_firstname", array('maxlength' => 32)); ?>
		<?php echo $form->error($model,"shipping_firstname"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_lastname"); ?>
		<?php echo $form->textField($model,"shipping_lastname", array('maxlength' => 32)); ?>
		<?php echo $form->error($model,"shipping_lastname"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_company"); ?>
		<?php echo $form->textField($model,"shipping_company", array('maxlength' => 32)); ?>
		<?php echo $form->error($model,"shipping_company"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_address_1"); ?>
		<?php echo $form->textField($model,"shipping_address_1", array('maxlength' => 128)); ?>
		<?php echo $form->error($model,"shipping_address_1"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_address_2"); ?>
		<?php echo $form->textField($model,"shipping_address_2", array('maxlength' => 128)); ?>
		<?php echo $form->error($model,"shipping_address_2"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_city"); ?>
		<?php echo $form->textField($model,"shipping_city", array('maxlength' => 128)); ?>
		<?php echo $form->error($model,"shipping_city"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_postcode"); ?>
		<?php echo $form->textField($model,"shipping_postcode", array('maxlength' => 10)); ?>
		<?php echo $form->error($model,"shipping_postcode"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_country_id"); ?>
		<?php echo $form->dropDownList($model,"shipping_country_id", CHtml::listData(Country::model()->findAll(), 'id','name'),
		array(
			'ajax' => array(
			'type'=>'POST', //request type
			'url'=>$this->createUrl('zones'), //url to call.
			'update'=>'#Order_shipping_zone_id',
		)));?>
		<?php echo $form->error($model,"shipping_country_id"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"shipping_zone_id"); ?>
		<?php echo $form->dropDownList($model,"shipping_zone_id", array()); ?>
		<?php echo $form->error($model,"shipping_zone_id"); ?>
		</div><!-- row -->


<?php
$this->endWidget();
?>
</div><!-- form -->

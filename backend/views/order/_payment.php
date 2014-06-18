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
		<?php echo $form->labelEx($model,"payment_firstname"); ?>
		<?php echo $form->textField($model,"payment_firstname", array('maxlength' => 32)); ?>
		<?php echo $form->error($model,"payment_firstname"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_lastname"); ?>
		<?php echo $form->textField($model,"payment_lastname", array('maxlength' => 32)); ?>
		<?php echo $form->error($model,"payment_lastname"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_company"); ?>
		<?php echo $form->textField($model,"payment_company", array('maxlength' => 32)); ?>
		<?php echo $form->error($model,"payment_company"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_tax_id"); ?>
		<?php echo $form->textField($model,"payment_tax_id", array('maxlength' => 32)); ?>
		<?php echo $form->error($model,"payment_tax_id"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_address_1"); ?>
		<?php echo $form->textField($model,"payment_address_1", array('maxlength' => 128)); ?>
		<?php echo $form->error($model,"payment_address_1"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_address_2"); ?>
		<?php echo $form->textField($model,"payment_address_2", array('maxlength' => 128)); ?>
		<?php echo $form->error($model,"payment_address_2"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_city"); ?>
		<?php echo $form->textField($model,"payment_city", array('maxlength' => 128)); ?>
		<?php echo $form->error($model,"payment_city"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_postcode"); ?>
		<?php echo $form->textField($model,"payment_postcode", array('maxlength' => 10)); ?>
		<?php echo $form->error($model,"payment_postcode"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_country_id"); ?>
		<?php echo $form->dropDownList($model,"payment_country_id", CHtml::listData(Country::model()->findAll(), 'id','name'),
		array(
			'ajax' => array(
			'type'=>'POST', //request type
			'url'=>$this->createUrl('zones'), //url to call.
			'update'=>'#Order_payment_zone_id',
		)));?>
		<?php echo $form->error($model,"payment_country_id"); ?>
		</div><!-- row -->
		<div class="row">
		<?php echo $form->labelEx($model,"payment_zone_id"); ?>
		<?php echo $form->dropDownList($model,"payment_zone_id", array()); ?>
		<?php echo $form->error($model,"payment_zone_id"); ?>
		</div><!-- row -->


<?php
$this->endWidget();
?>
</div><!-- form -->

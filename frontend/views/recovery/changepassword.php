<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");

?>

<h1><?php echo UserModule::t("Change password"); ?></h1>
<div class="section_head_general"><?php echo UserModule::t("Change password"); ?></div>
<div class="section_body_general">

<div class="inner_wrapper">

<div class="form">
<?php echo TbHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo TbHtml::errorSummary($form); ?>
	
	<div class="row-fluid">
	<?php echo TbHtml::activeLabelEx($form,'password'); ?>
	<?php echo TbHtml::activePasswordField($form,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 8 characters."); ?>
	</p>
	</div>
	
	<div class="row-fluid">
	<?php echo TbHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo TbHtml::activePasswordField($form,'verifyPassword'); ?>
	</div>
	
	
	<div class="row-fluid submit">
	<?php echo TbHtml::button(UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'submit'=>'')); ?>
	</div>

<?php echo TbHtml::endForm(); ?>
</div><!-- form -->
</div>
</div>
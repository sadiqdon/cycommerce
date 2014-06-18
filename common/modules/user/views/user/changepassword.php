<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Change password"),
);
?>

<h1><?php echo UserModule::t("Change password"); ?></h1>


<div class="form">
<?php echo TbHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo TbHtml::errorSummary($form); ?>
	
	<div class="row">
	<?php echo TbHtml::activeLabelEx($form,'password'); ?>
	<?php echo TbHtml::activePasswordField($form,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo TbHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo TbHtml::activePasswordField($form,'verifyPassword'); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo TbHtml::button(UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'submit'=>'')); ?>
	</div>

<?php echo TbHtml::endForm(); ?>
</div><!-- form -->
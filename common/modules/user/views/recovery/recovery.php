<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<h1><?php echo UserModule::t("Restore"); ?></h1>

<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo TbHtml::beginForm(); ?>

	<?php echo TbHtml::errorSummary($form); ?>
	
	<div class="row">
		<?php echo TbHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo TbHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
	</div>
	
	<div class="row submit">
		<?php echo TbHtml::button(UserModule::t('Restore'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'submit'=>'')); ?>
	</div>

<?php echo TbHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>
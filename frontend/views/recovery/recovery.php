<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<div class="section_head_general"><?php echo UserModule::t("Restore"); ?></div>
<div class="section_body_general">
<div class="inner_wrapper">
<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php else: ?>

<div class="form">
<?php echo TbHtml::beginForm(); ?>

	<?php echo TbHtml::errorSummary($form); ?>
	
	<div class="row-fluid">
		<?php echo TbHtml::activeLabel($form,'login_or_email'); ?>
		<?php echo TbHtml::activeTextField($form,'login_or_email') ?>
		<p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
	</div>
	
	<div class="row-fluid submit">
		<?php echo TbHtml::button(UserModule::t('Restore'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'submit'=>'')); ?>
	</div>

<?php echo TbHtml::endForm(); ?>
</div><!-- form -->
<?php endif; ?>
</div>
</div>
<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");

$this->menu=array(
	array('label'=>UserModule::t('Order History'), 'url'=>array('/order/history'), 'active'=>Yii::app()->controller->id == 'order' && Yii::app()->controller->action->id == 'history'),
	array('label'=>UserModule::t('Profile'), 'url'=>array('/customer'), 'active'=>Yii::app()->controller->id == 'customer' && Yii::app()->controller->action->id == 'view'),
    array('label'=>UserModule::t('Edit'), 'url'=>array('/customer/update'), 'active'=>Yii::app()->controller->id == 'customer' && Yii::app()->controller->action->id == 'update'),
    array('label'=>UserModule::t('Change password'), 'url'=>array('/user/profile/changepassword'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword'),
    //array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>

<div class="section_head_general"><?php echo UserModule::t("Change password"); ?></div>
<div class="section_body_general">
<div class="inner_wrapper">
<?php if(isset($this->menu)):?>
<?php $this->widget('bootstrap.widgets.TbNav', array(
	'type'=>TbHtml::NAV_TYPE_PILLS, // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false,
	'items'=>$this->menu,
)); ?>
<?php endif?><!-- second secondary menu -->
<div class="form">
<?php echo TbHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo TbHtml::errorSummary($form); ?>
	
	<div class="row-fluid">
	<?php echo TbHtml::activeLabelEx($form,'password'); ?>
	<?php echo TbHtml::activePasswordField($form,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
	</p>
	</div>
	
	<div class="row-fluid">
	<?php echo TbHtml::activeLabelEx($form,'verifyPassword'); ?>
	<?php echo TbHtml::activePasswordField($form,'verifyPassword'); ?>
	</div>
	
	
	<div class="row-fluid submit">
	<?php echo TbHtml::button(UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY, 'submit'=>'')); ?>
	</div>

<?php echo TbHtml::endForm(); ?>
</div><!-- form -->
</div>
</div>
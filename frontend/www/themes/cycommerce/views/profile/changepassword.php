<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change password"),
);
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
<?php if(Yii::app()->user->hasFlash('notice')): ?>

<div class="alert alert-warning">
<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo Yii::app()->user->getFlash('notice'); ?>
</div>
<?php endif; ?>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id'=>'changepassword-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
	<?php echo $form->labelEx($model,'oldPassword'); ?>
	<?php echo $form->passwordField($model,'oldPassword'); ?>
	<?php echo $form->error($model,'oldPassword'); ?>
	</div>
	
	<div class="row-fluid">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 8 characters."); ?>
	</p>
	</div>
	
	<div class="row-fluid">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>
	
	<br/>
	<div class="row-fluid submit">
	<?php echo TbHtml::button(UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'submit'=>''));
	?>
	<?php echo TbHtml::linkButton(UserModule::t('Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->request->getUrlReferrer()));
		?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>
</div>
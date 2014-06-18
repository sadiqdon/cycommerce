<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change password"),
);
$this->menu=array(
	array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'admin', 'visible'=>Yii::app()->user->checkAccess('editUser')),
    array('label'=>UserModule::t('List Users'), 'url'=>array('/user'), 'active'=>Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'index', 'visible'=>Yii::app()->user->checkAccess('viewUser')),
	array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'profile'),
    //array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword'),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>

<h1><?php echo UserModule::t("Change password"); ?></h1>

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
	
	<div class="row">
	<?php echo $form->labelEx($model,'oldPassword'); ?>
	<?php echo $form->passwordField($model,'oldPassword'); ?>
	<?php echo $form->error($model,'oldPassword'); ?>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'password'); ?>
	<?php echo $form->passwordField($model,'password'); ?>
	<?php echo $form->error($model,'password'); ?>
	<p class="hint">
	<?php echo UserModule::t("Minimal password length 8 characters."); ?>
	</p>
	</div>
	
	<div class="row">
	<?php echo $form->labelEx($model,'verifyPassword'); ?>
	<?php echo $form->passwordField($model,'verifyPassword'); ?>
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>
	
	
	<div class="row submit">
	<?php echo TbHtml::button(UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'submit'=>''));
	?>
	<?php echo TbHtml::linkButton(UserModule::t('Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->request->getUrlReferrer()));
		?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
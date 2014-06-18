<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<div class="section_head_general"><?php echo UserModule::t("Login"); ?></div>
<div class="section_body_general">
<div class="inner_wrapper">
<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>
<?php elseif(Yii::app()->user->hasFlash('recoveryMessage')): ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
</div>
<?php elseif(Yii::app()->user->hasFlash('activateMessage')): ?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php echo Yii::app()->user->getFlash('activateMessage'); ?>
</div>
<?php endif; ?>

<p><?php echo UserModule::t("Please fill out the following form with your login credentials:"); ?></p>

<div class="form">
<?php echo TbHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields withs <span class="required">*</span> are required.'); ?></p>
	
	<?php echo TbHtml::errorSummary($model); ?>
	
	<div class="row-fluid">
		<?php echo TbHtml::activeLabelEx($model,'username'); ?>
		<?php echo TbHtml::activeTextField($model,'username') ?>
	</div>
	
	<div class="row-fluid">
		<?php echo TbHtml::activeLabelEx($model,'password'); ?>
		<?php echo TbHtml::activePasswordField($model,'password') ?>
	</div>
	
	<div class="row-fluid">
		<p class="hint">
		<?php echo TbHtml::link(UserModule::t("Register"),Yii::app()->getModule('user')->registrationUrl); ?><br/><?php echo TbHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
		</p>
	</div>
	<!--
	<div class="row-fluid rememberMe">
		<?php echo TbHtml::activeCheckBox($model,'rememberMe'); ?>
		<?php echo TbHtml::activeLabelEx($model,'rememberMe'); ?>
	</div> -->

	<div class="row-fluid submit">
		<?php echo TbHtml::submitButton(UserModule::t("Login"),
				array('color' => TbHtml::BUTTON_COLOR_PRIMARY,'submit'=>''));
		 ?>
	</div>
	
<?php echo TbHtml::endForm(); ?>
</div><!-- form -->


<?php

$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>
</div>
</div>
<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
$this->menu=array(
	array('label'=>UserModule::t('Order History'), 'url'=>array('/order/history'), 'active'=>Yii::app()->controller->id == 'order' && Yii::app()->controller->action->id == 'history'),
	array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'profile'),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'edit'),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword'),
    //array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>
<div class="section_head_general"><?php echo UserModule::t('Edit profile'); ?></div>
<div class="section_body_general">
<div class="inner_wrapper">
<?php if(isset($this->menu)):?>
<?php $this->widget('bootstrap.widgets.TbNav', array(
	'type'=>TbHtml::NAV_TYPE_PILLS, // '', 'tabs', 'pills' (or 'list')
	'stacked'=>false,
	'items'=>$this->menu,
)); ?>
<?php endif?><!-- second secondary menu -->
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id'=>'profile-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

<?php 
		$profileFields=Profile::getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				if($field->varname != 'branch_id'){
			?>
			
	<div class="row-fluid">
		<?php echo $form->labelEx($profile,$field->varname);
		
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		echo $form->error($profile,$field->varname); ?>
	</div>	
			<?php
			}}
		}
?>
	<div class="row-fluid">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row-fluid">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<br/>
	<div class="row-fluid buttons">
		<?php echo TbHtml::button(UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'submit'=>''));
		?>
		<?php echo TbHtml::linkButton(UserModule::t('Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->request->getUrlReferrer()));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</div>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p><br/>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<div class="row">
		<strong><?php echo TbHtml::encode($model->getAttributeLabel('username')); ?>:</strong>
		<?php echo TbHtml::encode($model->username); ?>
	</div>
	<br/>

	<div class="row">
		<strong><?php echo TbHtml::encode($model->getAttributeLabel('email')); ?>:</strong>
		<?php echo TbHtml::encode($model->email); ?>
	</div>
	<br/>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	<br/>
	
	<div class="row">
		
        <?php //$gprofile = Profile::model()->with('groups')->findbyPk($model->id); ?>
		<?php echo $form->labelEx($profile,'group_id'); ?>		
        <?php echo TbHtml::activeListBox($profile,'group_id', TbHtml::listData(Group::model()->findAll(), 'id', 'name'), array('multiple' => 'multiple')); ?>
        <?php echo $form->error($profile,'group_id'); ?>
    </div>
	<br/>
<?php 

	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			if($field->varname == 'branch_id'){  ?>
			<div class="row">
				<?php echo $form->labelEx($profile,$field->varname); ?>
			
			<?php 
				if ($widgetEdit = $field->widgetEdit($profile)) {
					echo $widgetEdit;
				} elseif ($field->range) {
					echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
				}
			?>
			<?php echo $form->error($profile,$field->varname); ?>
			</div>
			<br/>
			<?php
			}else{
			?>
			
			<div class="row">
					<strong><?php echo TbHtml::encode(UserModule::t($field->title)); ?>:</strong>
					<?php echo TbHtml::encode((($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname)))); ?>
			</div>
			<br/>
		<?php
			}
		}
	}
	
?>
	<div class="row buttons">
		<?php echo TbHtml::button(UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'submit'=>'')); ?>
		<?php echo TbHtml::linkButton(UserModule::t('Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->request->getUrlReferrer())); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
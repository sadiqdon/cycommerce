<div class="form">

<?php echo TbHtml::beginForm(); ?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo TbHtml::errorSummary($model); ?>
	
	<div class="row varname">
		<?php echo TbHtml::activeLabelEx($model,'varname'); ?>
		<?php echo (($model->id)?TbHtml::activeTextField($model,'varname',array('size'=>60,'maxlength'=>50,'readonly'=>true)):TbHtml::activeTextField($model,'varname',array('size'=>60,'maxlength'=>50))); ?>
		<?php echo TbHtml::error($model,'varname'); ?>
		<p class="hint"><?php echo UserModule::t("Allowed lowercase letters and digits."); ?></p>
	</div>

	<div class="row title">
		<?php echo TbHtml::activeLabelEx($model,'title'); ?>
		<?php echo TbHtml::activeTextField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::error($model,'title'); ?>
		<p class="hint"><?php echo UserModule::t('Field name on the language of "sourceLanguage".'); ?></p>
	</div>

	<div class="row field_type">
		<?php echo TbHtml::activeLabelEx($model,'field_type'); ?>
		<?php echo (($model->id)?TbHtml::activeTextField($model,'field_type',array('size'=>60,'maxlength'=>50,'readonly'=>true,'id'=>'field_type')):TbHtml::activeDropDownList($model,'field_type',ProfileField::itemAlias('field_type'),array('id'=>'field_type'))); ?>
		<?php echo TbHtml::error($model,'field_type'); ?>
		<p class="hint"><?php echo UserModule::t('Field type column in the database.'); ?></p>
	</div>

	<div class="row field_size">
		<?php echo TbHtml::activeLabelEx($model,'field_size'); ?>
		<?php echo (($model->id)?TbHtml::activeTextField($model,'field_size',array('readonly'=>true)):TbHtml::activeTextField($model,'field_size')); ?>
		<?php echo TbHtml::error($model,'field_size'); ?>
		<p class="hint"><?php echo UserModule::t('Field size column in the database.'); ?></p>
	</div>

	<div class="row field_size_min">
		<?php echo TbHtml::activeLabelEx($model,'field_size_min'); ?>
		<?php echo TbHtml::activeTextField($model,'field_size_min'); ?>
		<?php echo TbHtml::error($model,'field_size_min'); ?>
		<p class="hint"><?php echo UserModule::t('The minimum value of the field (form validator).'); ?></p>
	</div>

	<div class="row required">
		<?php echo TbHtml::activeLabelEx($model,'required'); ?>
		<?php echo TbHtml::activeDropDownList($model,'required',ProfileField::itemAlias('required')); ?>
		<?php echo TbHtml::error($model,'required'); ?>
		<p class="hint"><?php echo UserModule::t('Required field (form validator).'); ?></p>
	</div>

	<div class="row match">
		<?php echo TbHtml::activeLabelEx($model,'match'); ?>
		<?php echo TbHtml::activeTextField($model,'match',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::error($model,'match'); ?>
		<p class="hint"><?php echo UserModule::t("Regular expression (example: '/^[A-Za-z0-9\s,]+$/u')."); ?></p>
	</div>

	<div class="row range">
		<?php echo TbHtml::activeLabelEx($model,'range'); ?>
		<?php echo TbHtml::activeTextField($model,'range',array('size'=>60,'maxlength'=>5000)); ?>
		<?php echo TbHtml::error($model,'range'); ?>
		<p class="hint"><?php echo UserModule::t('Predefined values (example: 1;2;3;4;5 or 1==One;2==Two;3==Three;4==Four;5==Five).'); ?></p>
	</div>

	<div class="row error_message">
		<?php echo TbHtml::activeLabelEx($model,'error_message'); ?>
		<?php echo TbHtml::activeTextField($model,'error_message',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::error($model,'error_message'); ?>
		<p class="hint"><?php echo UserModule::t('Error message when you validate the form.'); ?></p>
	</div>

	<div class="row other_validator">
		<?php echo TbHtml::activeLabelEx($model,'other_validator'); ?>
		<?php echo TbHtml::activeTextField($model,'other_validator',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::error($model,'other_validator'); ?>
		<p class="hint"><?php echo UserModule::t('JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('file'=>array('types'=>'jpg, gif, png'))))); ?></p>
	</div>

	<div class="row default">
		<?php echo TbHtml::activeLabelEx($model,'default'); ?>
		<?php echo (($model->id)?TbHtml::activeTextField($model,'default',array('size'=>60,'maxlength'=>255,'readonly'=>true)):TbHtml::activeTextField($model,'default',array('size'=>60,'maxlength'=>255))); ?>
		<?php echo TbHtml::error($model,'default'); ?>
		<p class="hint"><?php echo UserModule::t('The value of the default field (database).'); ?></p>
	</div>

	<div class="row widget">
		<?php echo TbHtml::activeLabelEx($model,'widget'); ?>
		<?php 
		list($widgetsList) = ProfileFieldController::getWidgets($model->field_type);
		echo TbHtml::activeDropDownList($model,'widget',$widgetsList,array('id'=>'widgetlist'));
		//echo TbHtml::activeTextField($model,'widget',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo TbHtml::error($model,'widget'); ?>
		<p class="hint"><?php echo UserModule::t('Widget name.'); ?></p>
	</div>

	<div class="row widgetparams">
		<?php echo TbHtml::activeLabelEx($model,'widgetparams'); ?>
		<?php echo TbHtml::activeTextField($model,'widgetparams',array('size'=>60,'maxlength'=>5000,'id'=>'widgetparams')); ?>
		<?php echo TbHtml::error($model,'widgetparams'); ?>
		<p class="hint"><?php echo UserModule::t('JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('param1'=>array('val1','val2'),'param2'=>array('k1'=>'v1','k2'=>'v2'))))); ?></p>
	</div>

	<div class="row position">
		<?php echo TbHtml::activeLabelEx($model,'position'); ?>
		<?php echo TbHtml::activeTextField($model,'position'); ?>
		<?php echo TbHtml::error($model,'position'); ?>
		<p class="hint"><?php echo UserModule::t('Display order of fields.'); ?></p>
	</div>

	<div class="row visible">
		<?php echo TbHtml::activeLabelEx($model,'visible'); ?>
		<?php echo TbHtml::activeDropDownList($model,'visible',ProfileField::itemAlias('visible')); ?>
		<?php echo TbHtml::error($model,'visible'); ?>
	</div>

	<div class="row buttons">
		<?php echo TbHtml::button($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS, 'submit'=>'')); ?>
	</div>

<?php echo TbHtml::endForm(); ?>

</div><!-- form -->
<div id="dialog-form" title="<?php echo UserModule::t('Widget parameters'); ?>">
	<form>
	<fieldset>
		<label for="name">Name</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
		<label for="value">Value</label>
		<input type="text" name="value" id="value" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>

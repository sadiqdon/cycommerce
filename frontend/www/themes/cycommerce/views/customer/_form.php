<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>

<div class='form'>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id'=>'customer-form',
	//enableAjaxValidation'=>true,
	/*'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),*/
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class='note'><?php echo UserModule::t('Fields with <span class=\"required\">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>

	<div class='row-fluid'>
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class='row-fluid'>
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
<!--
	<div class='row-fluid'>
		<?php //echo $form->labelEx($model,'c_group_id'); ?>		
        <?php //echo TbHtml::activeListBox($model,'c_group_id', TbHtml::listData(CGroup::model()->findAll(), 'id', 'name'), array('multiple' => 'multiple')); ?>
        <?php //echo $form->error($model,'c_group_id'); ?>
    </div>-->
<?php 
		$profileFields=Profile::getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				if($field->varname != 'branch_id'){
			?>
	<div class='row-fluid'>
		<?php echo $form->labelEx($profile,$field->varname); ?>
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=='TEXT') {
			echo TbHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); ?>
	</div>
			<?php
			}}
		}
?>
<?php $this->endWidget(); ?>

</div><!-- form -->
<div id="pageinfo" class="hide">
	<div id="createAdd"><?php echo $this->createUrl('createaddress'); ?></div>
	<div id="labelAdd"><?php echo Yii::t('label', 'Address'); ?></div>
</div>

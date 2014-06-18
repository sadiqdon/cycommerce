<?php
/* @var $this OrderController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>
<div class='aform form'>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id'=>'customer-form',
	//'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class='note'><?php echo Yii::t('info','Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'store_id'); ?>		
        <?php echo $form->dropDownList($model,'store_id', CHtml::listData(Store::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model,'store_id'); ?>
    </div>
	
	<div class='row'>
		<?php echo $form->labelEx($model,'customer_group_id'); ?>		
        <?php echo $form->dropDownList($model,'customer_group_id', CHtml::listData(CGroup::model()->findAll(), 'id', 'name')); ?>
        <?php echo $form->error($model,'customer_group_id'); ?>
    </div>
	
	<div class='row'>
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('maxlength'=>32)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>
	
	<div class='row'>
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('maxlength'=>32)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class='row'>
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('maxlength'=>96)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	
	<div class='row'>
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('maxlength'=>32)); ?>
		<?php echo $form->error($model,'telephone'); ?>
	</div>
	
	<div class='row'>
		<?php echo $form->labelEx($model,'fax'); ?>
		<?php echo $form->textField($model,'fax',array('maxlength'=>32)); ?>
		<?php echo $form->error($model,'fax'); ?>
	</div>
	

<?php $this->endWidget(); ?>

</div><!-- form -->

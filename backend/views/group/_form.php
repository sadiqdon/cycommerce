<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->textField($model,'name',array('maxlength'=>50)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'branches'); ?>		
        <?php echo CHtml::activeListBox($model,'branches', CHtml::listData(Branch::model()->findAll(), 'id', 'branchCode'), array('multiple' => 'multiple')); ?>
        <?php echo $form->error($model,'branches'); ?>
    </div>

	<div class="row buttons">
		<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('main','Create') : Yii::t('main','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS));
		?>
		<?php echo TbHtml::linkButton(Yii::t('main','Cancel'), array('color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>array('index'))); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
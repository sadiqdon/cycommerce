<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textField($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textField($model,'name',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		<?php echo TbHtml::submitButton(Yii::t('main','Search'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

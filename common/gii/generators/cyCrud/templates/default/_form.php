<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form CActiveForm */
?>
<?php  echo "<?php \$this->widget('bootstrap.widgets.TbAlert'); ?>" ?>
<div class="form aform">

<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
	$desciptions = $this->getDescriptions($this->modelClass);
	if(empty($desciptions))
		echo "<?php echo \$form->errorSummary(\$model); ?>\n"; 
	else
		echo "<?php echo \$form->errorSummary(\$model, \$description); ?>\n"; 
	?>

<?php 
foreach ($desciptions as $column)
{
?>
	<div class="row">
		<?php echo "<?php echo ".$this->generateDescriptionActiveLabel('description',$column)."; ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateDescriptionActiveField('description',$column)."; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$description,'{$column->name}'); ?>\n"; ?>
	</div>
<?php
}
?>
	
<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
	<div class="row">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
	</div>

<?php
}
?>
	<div class="row buttons">
		<?php echo "<?php echo TbHtml::submitButton(\$model->isNewRecord ? Yii::t('label','Create') : Yii::t('label','Save'), array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>\n"; ?>
		<?php echo "<?php echo TbHtml::linkButton(Yii::t('label','Cancel'), array('class'=>'cancelButton','color' => TbHtml::BUTTON_COLOR_DANGER, 'url'=>Yii::app()->createUrl('".strtolower($this->modelClass)."/admin')));?>\n"; ?>
	</div>
	

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->
<div class="hlinks hide">
<div class="uid"><?php echo '<?php echo $model->id; ?>' ?></div>
</div>
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

<div class="wide form">

<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<div class="row">
		<?php echo "<?php echo \$form->label(\$model,'{$column->name}'); ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
	</div>

<?php endforeach; ?>
<?php 
$descrip = $this->getDescriptions($this->modelClass);
if(!empty($descrip)){ ?>
	<div class="row">
		<?php echo "<?php echo \$form->label(\$model,'name'); ?>\n"; ?>
		<?php echo "<?php echo \$form->textField(\$model,'name'); ?>\n"; ?>
	</div>

<?php } ?>
	<div class="row buttons">
		<?php echo "<?php echo TbHtml::submitButton(Yii::t('label','Search'), array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- search-form -->
<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \$this->widget('bootstrap.widgets.TbAlert'); ?>"; ?>
<div class="aform form">

<?php $ajax = ($this->enable_ajax_validation) ? 'true' : 'false'; ?>

<?php echo '<?php '; ?>
$form = $this->beginWidget('GxActiveForm', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-form',
	'enableAjaxValidation' => <?php echo $ajax; ?>,
));
<?php echo '?>'; ?>


	<p class="note">
		Fields with <span class="required">*</span> are required.
	</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php foreach ($this->tableSchema->columns as $column): ?>
<?php if (!$column->autoIncrement && $column->name != 'lastedit_at' && $column->name != 'create_at'): ?>
		<div class="row">
		<?php echo "<?php echo " . $this->generateActiveLabel($this->modelClass, $column) . "; ?>\n"; ?>
		<?php echo "<?php " . $this->generateActiveField($this->modelClass, $column) . "; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
		</div><!-- row -->
<?php endif; ?>
<?php endforeach; ?>

<?php foreach ($this->getRelations($this->modelClass) as $relation): ?>
<?php if ($relation[1] == GxActiveRecord::HAS_MANY || $relation[1] == GxActiveRecord::MANY_MANY): ?>
		<label><?php echo '<?php'; ?> echo GxHtml::encode($model->getRelationLabel('<?php echo $relation[0]; ?>')); ?></label>
		<?php echo '<?php ' . $this->generateActiveRelationField($this->modelClass, $relation) . "; ?>\n"; ?>
<?php endif; ?>
<?php endforeach; ?>

<?php echo "<?php
echo GxHtml::submitButton('Save');
\$this->endWidget();
?>\n"; ?>
</div><!-- form -->
<div class="uid hide"><a href="<?php echo "<?php " ?>echo $this->createUrl('delete', array('id' => $model-><?php echo $this->tableSchema->primaryKey; ?>)) ?>" class="del-link"></a><a href="<?php echo "<?php " ?>echo $this->createUrl('update', array('id' => $model-><?php echo $this->tableSchema->primaryKey; ?>)) ?>" class="up-link"></a></div>
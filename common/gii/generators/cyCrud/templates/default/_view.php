<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo '<?php'; ?> $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php echo '<?php'; ?> $this->widget('bootstrap.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
<?php
$descrip = $this->getDescriptions($this->modelClass);
if(!empty($descrip)){
echo "\t\tarray(
			'name'=>'name', 
			'header'=>'Name',
			'value'=>\$model->getName(), 
		),\n";
}
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
<div class="hlinks hide">
<div class="uid"><?php echo '<?php echo $model->id; ?>' ?></div>
</div>
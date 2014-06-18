<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	GxHtml::valueEx($model),
);

$this->menu=array(
	array('label'=>'List' . ' ' . $model->label(2), 'url'=>array('index')),
	array('label'=>'Create' . ' ' . $model->label(), 'url'=>array('create')),
	array('label'=>'Update' . ' ' . $model->label(), 'url'=>array('update', 'id' => $model->id)),
	array('label'=>'Delete' . ' ' . $model->label(), 'url'=>'#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage' . ' ' . $model->label(2), 'url'=>array('admin')),
);
?>

<h1><?php echo 'View' . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
'id',
'name',
array(
			'name' => 'parent',
			'type' => 'raw',
			'value' => $model->parent !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->parent)), array('companyStructure/view', 'id' => GxActiveRecord::extractPkValue($model->parent, true))) : null,
			),
array(
			'name' => 'type',
			'type' => 'raw',
			'value' => $model->type !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->type)), array('companyStructureType/view', 'id' => GxActiveRecord::extractPkValue($model->type, true))) : null,
			),
array(
			'name' => 'location',
			'type' => 'raw',
			'value' => $model->location !== null ? GxHtml::link(GxHtml::encode(GxHtml::valueEx($model->location)), array('location/view', 'id' => GxActiveRecord::extractPkValue($model->location, true))) : null,
			),
'create_at',
'lastedit_at',
	),
)); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('companyStructures')); ?></h2>
<?php
	echo GxHtml::openTag('ul');
	foreach($model->companyStructures as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('companyStructure/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
?>
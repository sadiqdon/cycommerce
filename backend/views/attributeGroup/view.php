<?php
/* @var $this AttributeGroupController */
/* @var $model AttributeGroup */

$this->breadcrumbs=array(
	'Attribute Groups'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' AttributeGroup', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' AttributeGroup', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' AttributeGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' AttributeGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' AttributeGroup', 'url'=>array('admin')),
);
?>

<h1>View AttributeGroup #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

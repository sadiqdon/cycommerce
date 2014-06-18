<?php
/* @var $this GeoZoneController */
/* @var $model GeoZone */

$this->breadcrumbs=array(
	'Geo Zones'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' GeoZone', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' GeoZone', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' GeoZone', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' GeoZone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' GeoZone', 'url'=>array('admin')),
);
?>

<h1>View GeoZone #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

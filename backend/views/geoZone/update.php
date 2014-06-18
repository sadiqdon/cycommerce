<?php
/* @var $this GeoZoneController */
/* @var $model GeoZone */

$this->breadcrumbs=array(
	'Geo Zones'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' GeoZone', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' GeoZone', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' GeoZone', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' GeoZone', 'url'=>array('admin')),
);
?>

<h1>Update GeoZone <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this GeoZoneController */
/* @var $model GeoZone */

$this->breadcrumbs=array(
	'Geo Zones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' GeoZone', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' GeoZone', 'url'=>array('admin')),
);
?>

<h1>Create GeoZone</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
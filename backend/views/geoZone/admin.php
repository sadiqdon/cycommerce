<?php

$this->breadcrumbs = array(
	'Geo Zones' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' GeoZone', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' GeoZone', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Geo Zones</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
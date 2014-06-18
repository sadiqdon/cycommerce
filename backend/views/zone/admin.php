<?php

$this->breadcrumbs = array(
	'Zones' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Zone', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Zone', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Zones</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
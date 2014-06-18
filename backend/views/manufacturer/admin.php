<?php

$this->breadcrumbs = array(
	'Manufacturers' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Manufacturer', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Manufacturer', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Manufacturers</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
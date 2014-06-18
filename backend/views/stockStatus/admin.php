<?php

$this->breadcrumbs = array(
	'Stock Statuses' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' StockStatus', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' StockStatus', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Stock Statuses</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
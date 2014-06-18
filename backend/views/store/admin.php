<?php

$this->breadcrumbs = array(
	'Stores' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Store', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Store', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Stores</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
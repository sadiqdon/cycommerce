<?php

$this->breadcrumbs = array(
	'Categories' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Category', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Category', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Categories</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
<?php

$this->breadcrumbs = array(
	'Products' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Product', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Product', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Products</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
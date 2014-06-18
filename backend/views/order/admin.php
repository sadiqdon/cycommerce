<?php

$this->breadcrumbs = array(
	'Orders' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Order', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Order', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Orders</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
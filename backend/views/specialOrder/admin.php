<?php

$this->breadcrumbs = array(
	'Special Orders' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' SpecialOrder', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' SpecialOrder', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Special Orders</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
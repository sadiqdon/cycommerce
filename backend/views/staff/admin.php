<?php

$this->breadcrumbs = array(
	'Staffs' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Staff', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Staff', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Staffs</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
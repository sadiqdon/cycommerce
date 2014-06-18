<?php

$this->breadcrumbs = array(
	'Currencies' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Currency', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Currency', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Currencies</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
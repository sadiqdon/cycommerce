<?php

$this->breadcrumbs = array(
	'Options' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Option', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Option', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Options</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
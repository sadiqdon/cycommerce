<?php

$this->breadcrumbs = array(
	'Newsletters' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Newsletter', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Newsletter', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Newsletters</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
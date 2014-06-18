<?php

$this->breadcrumbs = array(
	'Cgroups' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' CGroup', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' CGroup', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Cgroups</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
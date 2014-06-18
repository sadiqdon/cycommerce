<?php

$this->breadcrumbs = array(
	'Attribute Groups' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' AttributeGroup', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' AttributeGroup', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Attribute Groups</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
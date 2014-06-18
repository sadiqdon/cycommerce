<?php

$this->breadcrumbs = array(
	'Attributes' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Attribute', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Attribute', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Attributes</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
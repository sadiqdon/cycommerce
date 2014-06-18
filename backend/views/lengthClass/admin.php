<?php

$this->breadcrumbs = array(
	'Length Classes' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' LengthClass', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' LengthClass', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Length Classes</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
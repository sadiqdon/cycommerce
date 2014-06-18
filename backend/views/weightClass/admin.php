<?php

$this->breadcrumbs = array(
	'Weight Classes' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' WeightClass', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' WeightClass', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Weight Classes</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
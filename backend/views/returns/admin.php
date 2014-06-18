<?php

$this->breadcrumbs = array(
	'Returns' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Returns', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Returns', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Returns</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
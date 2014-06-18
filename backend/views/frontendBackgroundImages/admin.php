<?php

$this->breadcrumbs = array(
	'Frontend Background Images' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' FrontendBackgroundImages', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' FrontendBackgroundImages', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Frontend Background Images</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
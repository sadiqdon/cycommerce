<?php

$this->breadcrumbs = array(
	'Frontend Background Images' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' FrontendSliderImages', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' FrontendSliderImages', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Frontend Slider Images</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
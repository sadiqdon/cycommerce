<?php

$this->breadcrumbs = array(
	'Themes' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Theme', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Theme', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Themes</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
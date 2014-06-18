<?php

$this->breadcrumbs = array(
	'Pages' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Page', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Page', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Pages</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
<?php

$this->breadcrumbs = array(
	'Countries' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' Country', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' Country', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Countries</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
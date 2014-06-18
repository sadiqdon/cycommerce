<?php

$this->breadcrumbs = array(
	'Tax Classes' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' TaxClass', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' TaxClass', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Tax Classes</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
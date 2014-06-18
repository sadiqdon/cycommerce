<?php

$this->breadcrumbs = array(
	'Payment Sources' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' PaymentSource', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' PaymentSource', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Payment Sources</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
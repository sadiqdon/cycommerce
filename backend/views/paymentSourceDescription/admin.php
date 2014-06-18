<?php

$this->breadcrumbs = array(
	'Payment Source Descriptions' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' PaymentSourceDescription', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' PaymentSourceDescription', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Payment Source Descriptions</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
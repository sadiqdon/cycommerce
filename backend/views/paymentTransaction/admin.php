<?php

$this->breadcrumbs = array(
	'Payment Transactions' => array('index'),
	'Manage',
);

$this->menu = array(
		array('label'=>Yii::t('label','List').' PaymentTransaction', 'url'=>array('index')),
		array('label'=>Yii::t('label','Create').' PaymentTransaction', 'url'=>array('create')),
	);

?>

<h1><?php Yii::t('label','Manage'); ?> Payment Transactions</h1>

<?php echo $this->renderPartial('_manage', array('model'=>$model)); ?>
<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->breadcrumbs=array(
	'Payment Transactions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentTransaction', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' PaymentTransaction', 'url'=>array('admin')),
);
?>

<h1>Create PaymentTransaction</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
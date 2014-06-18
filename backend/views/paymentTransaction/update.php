<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->breadcrumbs=array(
	'Payment Transactions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentTransaction', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' PaymentTransaction', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' PaymentTransaction', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' PaymentTransaction', 'url'=>array('admin')),
);
?>

<h1>Update PaymentTransaction <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this PaymentTransactionController */
/* @var $model PaymentTransaction */

$this->breadcrumbs=array(
	'Payment Transactions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentTransaction', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' PaymentTransaction', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' PaymentTransaction', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' PaymentTransaction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' PaymentTransaction', 'url'=>array('admin')),
);
?>

<h1>View PaymentTransaction #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

<?php
/* @var $this PaymentSourceController */
/* @var $model PaymentSource */

$this->breadcrumbs=array(
	'Payment Sources'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentSource', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' PaymentSource', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' PaymentSource', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' PaymentSource', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' PaymentSource', 'url'=>array('admin')),
);
?>

<h1>View PaymentSource #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

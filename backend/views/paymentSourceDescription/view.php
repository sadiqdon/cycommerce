<?php
/* @var $this PaymentSourceDescriptionController */
/* @var $model PaymentSourceDescription */

$this->breadcrumbs=array(
	'Payment Source Descriptions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentSourceDescription', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' PaymentSourceDescription', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' PaymentSourceDescription', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' PaymentSourceDescription', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' PaymentSourceDescription', 'url'=>array('admin')),
);
?>

<h1>View PaymentSourceDescription #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

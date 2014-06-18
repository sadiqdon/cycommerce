<?php
/* @var $this PaymentSourceDescriptionController */
/* @var $model PaymentSourceDescription */

$this->breadcrumbs=array(
	'Payment Source Descriptions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentSourceDescription', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' PaymentSourceDescription', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' PaymentSourceDescription', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' PaymentSourceDescription', 'url'=>array('admin')),
);
?>

<h1>Update PaymentSourceDescription <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this PaymentSourceController */
/* @var $model PaymentSource */

$this->breadcrumbs=array(
	'Payment Sources'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentSource', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' PaymentSource', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' PaymentSource', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' PaymentSource', 'url'=>array('admin')),
);
?>

<h1>Update PaymentSource <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this PaymentSourceDescriptionController */
/* @var $model PaymentSourceDescription */

$this->breadcrumbs=array(
	'Payment Source Descriptions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentSourceDescription', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' PaymentSourceDescription', 'url'=>array('admin')),
);
?>

<h1>Create PaymentSourceDescription</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
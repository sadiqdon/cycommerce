<?php
/* @var $this PaymentSourceController */
/* @var $model PaymentSource */

$this->breadcrumbs=array(
	'Payment Sources'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' PaymentSource', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' PaymentSource', 'url'=>array('admin')),
);
?>

<h1>Create PaymentSource</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
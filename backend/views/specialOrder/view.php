<?php
/* @var $this SpecialOrderController */
/* @var $model SpecialOrder */

$this->breadcrumbs=array(
	'Special Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' SpecialOrder', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' SpecialOrder', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' SpecialOrder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' SpecialOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' SpecialOrder', 'url'=>array('admin')),
);
?>

<h1>View SpecialOrder #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

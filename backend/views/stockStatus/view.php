<?php
/* @var $this StockStatusController */
/* @var $model StockStatus */

$this->breadcrumbs=array(
	'Stock Statuses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' StockStatus', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' StockStatus', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' StockStatus', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' StockStatus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' StockStatus', 'url'=>array('admin')),
);
?>

<h1>View StockStatus #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

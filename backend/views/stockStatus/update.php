<?php
/* @var $this StockStatusController */
/* @var $model StockStatus */

$this->breadcrumbs=array(
	'Stock Statuses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' StockStatus', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' StockStatus', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' StockStatus', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' StockStatus', 'url'=>array('admin')),
);
?>

<h1>Update StockStatus <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
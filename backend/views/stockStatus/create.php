<?php
/* @var $this StockStatusController */
/* @var $model StockStatus */

$this->breadcrumbs=array(
	'Stock Statuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' StockStatus', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' StockStatus', 'url'=>array('admin')),
);
?>

<h1>Create StockStatus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
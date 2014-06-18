<?php
/* @var $this TaxRateController */
/* @var $model TaxRate */

$this->breadcrumbs=array(
	'Tax Rates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' TaxRate', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' TaxRate', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' TaxRate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' TaxRate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' TaxRate', 'url'=>array('admin')),
);
?>

<h1>View TaxRate #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

<?php
/* @var $this TaxRateController */
/* @var $model TaxRate */

$this->breadcrumbs=array(
	'Tax Rates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' TaxRate', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' TaxRate', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' TaxRate', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' TaxRate', 'url'=>array('admin')),
);
?>

<h1>Update TaxRate <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
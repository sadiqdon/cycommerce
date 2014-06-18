<?php
/* @var $this TaxClassController */
/* @var $model TaxClass */

$this->breadcrumbs=array(
	'Tax Classes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' TaxClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' TaxClass', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' TaxClass', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' TaxClass', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' TaxClass', 'url'=>array('admin')),
);
?>

<h1>View TaxClass #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

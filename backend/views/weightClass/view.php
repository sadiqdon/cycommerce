<?php
/* @var $this WeightClassController */
/* @var $model WeightClass */

$this->breadcrumbs=array(
	'Weight Classes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' WeightClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' WeightClass', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' WeightClass', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' WeightClass', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' WeightClass', 'url'=>array('admin')),
);
?>

<h1>View WeightClass #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

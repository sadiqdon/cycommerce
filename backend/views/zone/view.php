<?php
/* @var $this ZoneController */
/* @var $model Zone */

$this->breadcrumbs=array(
	'Zones'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Zone', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Zone', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' Zone', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' Zone', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' Zone', 'url'=>array('admin')),
);
?>

<h1>View Zone #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

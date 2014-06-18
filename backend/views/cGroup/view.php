<?php
/* @var $this CGroupController */
/* @var $model CGroup */

$this->breadcrumbs=array(
	'Cgroups'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' CGroup', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' CGroup', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' CGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' CGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' CGroup', 'url'=>array('admin')),
);
?>

<h1>View CGroup #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

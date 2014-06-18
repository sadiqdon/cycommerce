<?php
/* @var $this ReturnsController */
/* @var $model Returns */

$this->breadcrumbs=array(
	'Returns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Returns', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Returns', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' Returns', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' Returns', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' Returns', 'url'=>array('admin')),
);
?>

<h1>View Returns #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

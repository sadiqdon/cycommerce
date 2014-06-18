<?php
/* @var $this LengthClassController */
/* @var $model LengthClass */

$this->breadcrumbs=array(
	'Length Classes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' LengthClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' LengthClass', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' LengthClass', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' LengthClass', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' LengthClass', 'url'=>array('admin')),
);
?>

<h1>View LengthClass #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

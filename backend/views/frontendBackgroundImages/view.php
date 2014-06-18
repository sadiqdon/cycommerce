<?php
/* @var $this FrontendBackgroundImagesController */
/* @var $model FrontendBackgroundImages */

$this->breadcrumbs=array(
	'Frontend Background Images'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' FrontendBackgroundImages', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' FrontendBackgroundImages', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' FrontendBackgroundImages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' FrontendBackgroundImages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' FrontendBackgroundImages', 'url'=>array('admin')),
);
?>

<h1>View FrontendBackgroundImages #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

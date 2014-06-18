<?php
/* @var $this FrontendBackgroundImagesController */
/* @var $model FrontendSliderImages */

$this->breadcrumbs=array(
	'Frontend Background Images'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' FrontendSliderImages', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' FrontendSliderImages', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' FrontendSliderImages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' FrontendSliderImages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' FrontendSliderImages', 'url'=>array('admin')),
);
?>

<h1>View FrontendSliderImages #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

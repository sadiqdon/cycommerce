<?php
/* @var $this FrontendBackgroundImagesController */
/* @var $model FrontendSliderImages */

$this->breadcrumbs=array(
	'Frontend Background Images'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' FrontendSliderImages', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' FrontendSliderImages', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' FrontendSliderImages', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' FrontendSliderImages', 'url'=>array('admin')),
);
?>

<h1>Update FrontendSliderImages <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
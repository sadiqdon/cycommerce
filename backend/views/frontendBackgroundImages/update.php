<?php
/* @var $this FrontendBackgroundImagesController */
/* @var $model FrontendBackgroundImages */

$this->breadcrumbs=array(
	'Frontend Background Images'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' FrontendBackgroundImages', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' FrontendBackgroundImages', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' FrontendBackgroundImages', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' FrontendBackgroundImages', 'url'=>array('admin')),
);
?>

<h1>Update FrontendBackgroundImages <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
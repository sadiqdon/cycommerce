<?php
/* @var $this CGroupController */
/* @var $model CGroup */

$this->breadcrumbs=array(
	'Cgroups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' CGroup', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' CGroup', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' CGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' CGroup', 'url'=>array('admin')),
);
?>

<h1>Update CGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
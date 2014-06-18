<?php
/* @var $this CGroupController */
/* @var $model CGroup */

$this->breadcrumbs=array(
	'Cgroups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' CGroup', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' CGroup', 'url'=>array('admin')),
);
?>

<h1>Create CGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
<?php
/* @var $this FrontendBackgroundImagesController */
/* @var $model FrontendBackgroundImages */

$this->breadcrumbs=array(
	'Frontend Background Images'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' FrontendBackgroundImages', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' FrontendBackgroundImages', 'url'=>array('admin')),
);
?>

<h1>Create FrontendBackgroundImages</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
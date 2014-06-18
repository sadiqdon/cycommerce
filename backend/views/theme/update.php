<?php
/* @var $this ThemeController */
/* @var $model Theme */

$this->breadcrumbs=array(
	'Themes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Theme', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Theme', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Theme', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Theme', 'url'=>array('admin')),
);
?>

<h1>Update Theme <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
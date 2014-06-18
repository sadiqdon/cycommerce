<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Page', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Page', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Page', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Page', 'url'=>array('admin')),
);
?>

<h1>Update Page <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
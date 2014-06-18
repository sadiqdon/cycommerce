<?php
/* @var $this ReturnsController */
/* @var $model Returns */

$this->breadcrumbs=array(
	'Returns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Returns', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Returns', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Returns', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Returns', 'url'=>array('admin')),
);
?>

<h1>Update Returns <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
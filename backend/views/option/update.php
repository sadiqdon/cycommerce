<?php
/* @var $this OptionController */
/* @var $model Option */

$this->breadcrumbs=array(
	'Options'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Option', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Option', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Option', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Option', 'url'=>array('admin')),
);
?>

<h1>Update Option <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
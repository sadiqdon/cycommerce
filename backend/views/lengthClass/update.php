<?php
/* @var $this LengthClassController */
/* @var $model LengthClass */

$this->breadcrumbs=array(
	'Length Classes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' LengthClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' LengthClass', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' LengthClass', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' LengthClass', 'url'=>array('admin')),
);
?>

<h1>Update LengthClass <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
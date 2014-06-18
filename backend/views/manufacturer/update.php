<?php
/* @var $this ManufacturerController */
/* @var $model Manufacturer */

$this->breadcrumbs=array(
	'Manufacturers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Manufacturer', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Manufacturer', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Manufacturer', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Manufacturer', 'url'=>array('admin')),
);
?>

<h1>Update Manufacturer <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
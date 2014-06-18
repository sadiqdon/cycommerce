<?php
/* @var $this ManufacturerController */
/* @var $model Manufacturer */

$this->breadcrumbs=array(
	'Manufacturers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Manufacturer', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' Manufacturer', 'url'=>array('admin')),
);
?>

<h1>Create Manufacturer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
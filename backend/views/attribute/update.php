<?php
/* @var $this AttributeController */
/* @var $model Attribute */

$this->breadcrumbs=array(
	'Attributes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Attribute', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Attribute', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Attribute', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Attribute', 'url'=>array('admin')),
);
?>

<h1>Update Attribute <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
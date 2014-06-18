<?php
/* @var $this AttributeController */
/* @var $model Attribute */

$this->breadcrumbs=array(
	'Attributes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Attribute', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' Attribute', 'url'=>array('admin')),
);
?>

<h1>Create Attribute</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
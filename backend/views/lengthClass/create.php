<?php
/* @var $this LengthClassController */
/* @var $model LengthClass */

$this->breadcrumbs=array(
	'Length Classes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' LengthClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' LengthClass', 'url'=>array('admin')),
);
?>

<h1>Create LengthClass</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
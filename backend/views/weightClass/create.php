<?php
/* @var $this WeightClassController */
/* @var $model WeightClass */

$this->breadcrumbs=array(
	'Weight Classes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' WeightClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' WeightClass', 'url'=>array('admin')),
);
?>

<h1>Create WeightClass</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
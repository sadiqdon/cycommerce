<?php
/* @var $this WeightClassController */
/* @var $model WeightClass */

$this->breadcrumbs=array(
	'Weight Classes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' WeightClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' WeightClass', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' WeightClass', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' WeightClass', 'url'=>array('admin')),
);
?>

<h1>Update WeightClass <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
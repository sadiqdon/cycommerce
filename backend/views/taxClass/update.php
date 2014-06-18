<?php
/* @var $this TaxClassController */
/* @var $model TaxClass */

$this->breadcrumbs=array(
	'Tax Classes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' TaxClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' TaxClass', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' TaxClass', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' TaxClass', 'url'=>array('admin')),
);
?>

<h1>Update TaxClass <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
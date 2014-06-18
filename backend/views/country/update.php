<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Country', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Country', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Country', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Country', 'url'=>array('admin')),
);
?>

<h1>Update Country <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
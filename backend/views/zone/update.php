<?php
/* @var $this ZoneController */
/* @var $model Zone */

$this->breadcrumbs=array(
	'Zones'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Zone', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Zone', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Zone', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Zone', 'url'=>array('admin')),
);
?>

<h1>Update Zone <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
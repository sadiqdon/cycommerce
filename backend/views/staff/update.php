<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Staffs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Staff', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Staff', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Staff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Staff', 'url'=>array('admin')),
);
?>

<h1>Update Staff <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this SpecialOrderController */
/* @var $model SpecialOrder */

$this->breadcrumbs=array(
	'Special Orders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' SpecialOrder', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' SpecialOrder', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' SpecialOrder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' SpecialOrder', 'url'=>array('admin')),
);
?>

<h1>Update SpecialOrder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
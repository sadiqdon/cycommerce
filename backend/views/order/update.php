<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Order', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Order', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Order', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Order', 'url'=>array('admin')),
);
?>

<h1>Update Order <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
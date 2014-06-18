<?php
/* @var $this AttributeGroupController */
/* @var $model AttributeGroup */

$this->breadcrumbs=array(
	'Attribute Groups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' AttributeGroup', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' AttributeGroup', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' AttributeGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' AttributeGroup', 'url'=>array('admin')),
);
?>

<h1>Update AttributeGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
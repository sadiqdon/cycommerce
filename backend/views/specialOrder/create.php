<?php
/* @var $this SpecialOrderController */
/* @var $model SpecialOrder */

$this->breadcrumbs=array(
	'Special Orders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' SpecialOrder', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' SpecialOrder', 'url'=>array('admin')),
);
?>

<h1>Create SpecialOrder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
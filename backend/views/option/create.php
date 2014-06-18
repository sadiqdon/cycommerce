<?php
/* @var $this OptionController */
/* @var $model Option */

$this->breadcrumbs=array(
	'Options'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Option', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' Option', 'url'=>array('admin')),
);
?>

<h1>Create Option</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
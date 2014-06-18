<?php
/* @var $this ZoneController */
/* @var $model Zone */

$this->breadcrumbs=array(
	'Zones'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Zone', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' Zone', 'url'=>array('admin')),
);
?>

<h1>Create Zone</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
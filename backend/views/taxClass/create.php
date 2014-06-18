<?php
/* @var $this TaxClassController */
/* @var $model TaxClass */

$this->breadcrumbs=array(
	'Tax Classes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' TaxClass', 'url'=>array('index')),
	array('label'=>Yii::t('label','Manage').' TaxClass', 'url'=>array('admin')),
);
?>

<h1>Create TaxClass</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'description'=>$description)); ?>
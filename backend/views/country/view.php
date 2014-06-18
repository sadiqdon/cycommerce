<?php
/* @var $this CountryController */
/* @var $model Country */

$this->breadcrumbs=array(
	'Countries'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Country', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Country', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' Country', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' Country', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' Country', 'url'=>array('admin')),
);
?>

<h1>View Country #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

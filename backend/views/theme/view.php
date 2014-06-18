<?php
/* @var $this ThemeController */
/* @var $model Theme */

$this->breadcrumbs=array(
	'Themes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Theme', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Theme', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' Theme', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' Theme', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' Theme', 'url'=>array('admin')),
);
?>

<h1>View Theme #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

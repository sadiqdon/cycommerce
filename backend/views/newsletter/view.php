<?php
/* @var $this NewsletterController */
/* @var $model Newsletter */

$this->breadcrumbs=array(
	'Newsletters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Newsletter', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Newsletter', 'url'=>array('create')),
	array('label'=>Yii::t('label','Update').' Newsletter', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Delete').' Newsletter', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('label','Are you sure you want to delete this item?'))),
	array('label'=>Yii::t('label','Manage').' Newsletter', 'url'=>array('admin')),
);
?>

<h1>View Newsletter #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_view', array(
	'model' => $model,
)); ?>

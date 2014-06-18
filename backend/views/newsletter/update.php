<?php
/* @var $this NewsletterController */
/* @var $model Newsletter */

$this->breadcrumbs=array(
	'Newsletters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('label','List').' Newsletter', 'url'=>array('index')),
	array('label'=>Yii::t('label','Create').' Newsletter', 'url'=>array('create')),
	array('label'=>Yii::t('label','View').' Newsletter', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('label','Manage').' Newsletter', 'url'=>array('admin')),
);
?>

<h1>Update Newsletter <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
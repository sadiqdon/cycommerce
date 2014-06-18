<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
$this->tab=array(   
	array('label'=>Yii::t('group','Users'), 'url'=>array('/user/admin'), 'active'=>false),
    array('label'=>Yii::t('group','Groups'), 'url'=>array('/group/admin'), 'active'=>true),
);
$this->menu=array(
	array('label'=>'Create Group', 'url'=>array('/group/create'), 'active'=>Yii::app()->controller->action->id == 'create'),
	array('label'=>'Update Group', 'url'=>array('/group/update', 'id'=>$model->id), 'active'=>Yii::app()->controller->action->id == 'update'),	
	array('label'=>'View Group', 'url'=>array('view', 'id'=>$model->id), 'active'=>Yii::app()->controller->action->id == 'view'),
	array('label'=>'Manage Groups', 'url'=>array('/group/admin'), 'active'=>Yii::app()->controller->action->id == 'admin'),
	array('label'=>'List Group', 'url'=>array('/group/index'), 'active'=>Yii::app()->controller->action->id == 'index'),
);
?>

<h1>Update Group <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
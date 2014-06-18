<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);
$this->tab=array(   
	array('label'=>Yii::t('group','Users'), 'url'=>array('/user/admin'), 'active'=>false),
    array('label'=>Yii::t('group','Groups'), 'url'=>array('/group/admin'), 'active'=>true),
);
$this->menu=array(
	array('label'=>'Create Group', 'url'=>array('/group/create'), 'active'=>Yii::app()->controller->action->id == 'create'),
	array('label'=>'Manage Groups', 'url'=>array('/group/admin'), 'active'=>Yii::app()->controller->action->id == 'admin'),
	array('label'=>'List Group', 'url'=>array('/group/index'), 'active'=>Yii::app()->controller->action->id == 'index'),
);
?>

<h1>Create Group</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
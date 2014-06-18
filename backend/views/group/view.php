<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name,
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

<h1>View Group #<?php echo $model->id; ?></h1>

<?php 
	$pgroups = Group::model()->with('branches')->findByPk($model->id);
	$gvalue = '';
	foreach($pgroups->branches as $group){
		$gvalue .= $group->name.', ';
	}
	if(!empty($gvalue)){
		$gvalue = substr($gvalue, 0, strlen($gvalue)-2);
	}
	
	$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array(
			'label' => 'Branch(es)',
			'name' => 'branches',
			'value' => $gvalue,
		),
	),
)); ?>

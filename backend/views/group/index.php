<?php
$this->breadcrumbs=array(
	'Groups',
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

<h1>Groups</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type' => array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'name',
	),

)); ?>

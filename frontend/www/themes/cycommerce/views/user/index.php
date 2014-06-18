<?php
$this->breadcrumbs=array(
	UserModule::t("Users"),
);

$this->layout='//layouts/column1';
$this->tab=array(   
	array('label'=>UserModule::t('Users'), 'url'=>array('/user/admin'), 'active'=>true),
    array('label'=>UserModule::t('Groups'), 'url'=>array('/group/admin'), 'active'=>false),
);

$this->menu=array(
	array('label'=>UserModule::t('Create User'), 'url'=>array('/user/admin/create'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'create'),
	array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'admin'),
	array('label'=>UserModule::t('List Users'), 'url'=>array('/user'), 'active'=>Yii::app()->controller->id == 'default' && Yii::app()->controller->action->id == 'index'),
);


?>

<h1><?php echo UserModule::t("List Users"); ?></h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>array(TbHtml::GRID_TYPE_STRIPED, TbHtml::GRID_TYPE_BORDERED, TbHtml::GRID_TYPE_CONDENSED),
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
		),
		'create_at',
		'lastvisit_at',
	),
)); ?>

<?php
$this->breadcrumbs=array(
	(UserModule::t('Users'))=>array('admin'),
	$model->username=>array('view','id'=>$model->id),
	(UserModule::t('Update')),
);
$this->tab=array(   
	array('label'=>UserModule::t('Users'), 'url'=>array('/user/admin'), 'active'=>true),
    array('label'=>UserModule::t('Groups'), 'url'=>array('/group/admin'), 'active'=>false),
);
$this->menu=array(
	array('label'=>UserModule::t('Create User'), 'url'=>array('create'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'create'),
	array('label'=>UserModule::t('Update User'), 'url'=>array('update','id'=>$model->id), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'update'),
	array('label'=>UserModule::t('View User'), 'url'=>array('view','id'=>$model->id), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'view'),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'admin'),
    array('label'=>UserModule::t('List Users'), 'url'=>array('/user'), 'active'=>Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'index'),
);
?>

<h1><?php echo  UserModule::t('Update User')." ".$model->id; ?></h1>

<?php
	echo $this->renderPartial('_update', array('model'=>$model,'profile'=>$profile));
?>
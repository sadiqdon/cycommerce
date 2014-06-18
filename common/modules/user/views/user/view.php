<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('index'),
	$model->username,
);
$this->layout='//layouts/column1';
$this->tab=array(   
	array('label'=>UserModule::t('Users'), 'url'=>array('/user/admin'), 'active'=>true),
    array('label'=>UserModule::t('Groups'), 'url'=>array('/group/admin'), 'active'=>false),
);
$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('/user/admin/create'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'create'),
	array('label'=>UserModule::t('Update User'), 'url'=>array('/user/admin/update','id'=>$model->id), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'update'),
	//array('label'=>UserModule::t('Delete User'), 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>UserModule::t('Are you sure to delete this item?'))),
	array('label'=>UserModule::t('View User'), 'url'=>array('view','id'=>$model->id), 'active'=>Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'view'),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'), 'active'=>Yii::app()->controller->id == 'admin' && Yii::app()->controller->action->id == 'admin'),
    array('label'=>UserModule::t('List Users'), 'url'=>array('/user'), 'active'=>Yii::app()->controller->id == 'default' && Yii::app()->controller->action->id == 'index'),
);

?>
<h1><?php echo UserModule::t('View User').' "'.$model->username.'"'; ?></h1>
<?php 

	//get groups
	$pgroups = Profile::model()->with('groups')->findByPk($model->id);
	$gvalue = '';
	foreach($pgroups->groups as $group){
		$gvalue .= $group->name.', ';
	}
	if(!empty($gvalue)){
		$gvalue = substr($gvalue, 0, strlen($gvalue)-2);
	}

// For all users
	$attributes = array(
			'username',
	);
	
	$profileFields=ProfileField::model()->forAll()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => UserModule::t($field->title),
					'name' => $field->varname,
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),

				));
		}
	}
	array_push($attributes,
		'create_at',
		array(
			'label' => 'Group(s)',
			'name' => 'groups',
			'value' => $gvalue,
		),
		array(
			'name' => 'lastvisit_at',
			'value' => (($model->lastvisit_at!='0000-00-00 00:00:00')?$model->lastvisit_at:UserModule::t('Not visited')),
		)
	);
			
	$this->widget('bootstrap.widgets.TbDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));

?>

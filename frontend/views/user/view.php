<?php
$this->menu=array(
	array('label'=>UserModule::t('Order History'), 'url'=>array('/order/history')),
	array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'profile'),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword'), 'active'=>Yii::app()->controller->id == 'profile' && Yii::app()->controller->action->id == 'changepassword'),
    //array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>
<div class="section_head_general"><?php echo UserModule::t('View User').' "'.$model->username.'"'; ?></div>
<div class="section_body_general">
<div class="inner_wrapper">
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
</div>
</div>
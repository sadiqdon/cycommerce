<?php $this->widget('bootstrap.widgets.TbAlert'); ?> 
<?php 
	$pgroups = Profile::model()->with('groups')->findByPk($model->id);
	$gvalue = '';
	foreach($pgroups->groups as $group){
		$gvalue .= $group->name.', ';
	}
	if(!empty($gvalue)){
		$gvalue = substr($gvalue, 0, strlen($gvalue)-2);
	}

	$attributes = array(
		'id',
		'username',
	);
	
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => UserModule::t($field->title),
					'name' => $field->varname,
					'type'=>'raw',
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
				));
		}
	}
	
	array_push($attributes,
		'email',
		'create_at',
		'lastvisit_at',
		array(
			'label' => 'Group(s)',
			'name' => 'groups',
			'value' => $gvalue,
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
	
	$this->widget('bootstrap.widgets.TbDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
 ?>
<div class="hlinks hide">
<div class="uid"><?php echo $model->id; ?></div>
</div>
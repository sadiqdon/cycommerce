<?php

Yii::import('common.models._base.BaseGroup');

class Group extends BaseGroup
{
	public $branch_id;
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function behaviors()
	{
		return array(
			// Classname => path to Class
			'LoggableBehavior'=>
				'common.extensions.behaviors.LoggableBehavior',
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'profiles' => array(self::MANY_MANY, 'Profiles', 'user_group(group_id, profile_id)'),
			'branches'=>array(self::MANY_MANY, 'Branch', 'branch_group(group_id, branch_id)'),
		);
	}
}
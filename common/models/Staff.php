<?php

class Staff extends User {
    static function model($className=__CLASS__) {
        return parent::model($className);
    }
 
    function defaultScope(){
        return array(
            'condition'=>"type=0",
        );
    }
	
	public static function label($n = 1) {
		return Yii::t('app', 'Staff|Staffs', $n);
	}
	
	public function relations()
	{
		return array(
			'branches' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'c_group_id' => Yii::t('label','Customer Group(s)'),
		);
	}
}

?>
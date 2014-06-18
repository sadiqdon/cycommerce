<?php

class Customer extends User {
	
	public $c_group_id;
	
    static function model($className=__CLASS__) {
        return parent::model($className);
    }
 
    function defaultScope(){
        return array(
            'condition'=>"type=1",
        );
    }
	
	public static function label($n = 1) {
		return Yii::t('app', 'Customer|Customers', $n);
	}
	
	public function relations()
	{
		return array(
			'addresses' => array(self::HAS_MANY, 'Address', 'address_id'),
			'groups' => array(self::MANY_MANY, 'CGroup', 'customer_c_group(user_id, c_group_id)'),
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
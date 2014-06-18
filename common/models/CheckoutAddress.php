<?php

class CheckoutAddress extends Address
{
	
	public function rules() {
		return array(
			array('email, telephone, firstname, lastname, address_1, city, country_id, zone_id', 'required'),
			array('user_id, country_id, zone_id', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname, telephone, company, tax_id', 'length', 'max'=>32),
			array('address_1, address_2, city', 'length', 'max'=>128),
			array('postal_code', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, firstname, lastname, telephone, company, tax_id, address_1, address_2, city, postal_code, country_id, zone_id', 'safe', 'on'=>'search'),
		);
	}
}
<?php

Yii::import('common.models._base.BaseShippingMethod');

class ShippingMethod extends BaseShippingMethod
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
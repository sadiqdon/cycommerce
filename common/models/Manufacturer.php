<?php

Yii::import('common.models._base.BaseManufacturer');

class Manufacturer extends BaseManufacturer
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
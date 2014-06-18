<?php

Yii::import('common.models._base.BaseOrderHistory');

class OrderHistory extends BaseOrderHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
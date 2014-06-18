<?php

Yii::import('common.models._base.BaseOrderTotal');

class OrderTotal extends BaseOrderTotal
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
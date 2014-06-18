<?php

Yii::import('common.models._base.BaseStore');

class Store extends BaseStore
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
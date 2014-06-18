<?php

Yii::import('common.models._base.BaseProductStore');

class ProductStore extends BaseProductStore
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
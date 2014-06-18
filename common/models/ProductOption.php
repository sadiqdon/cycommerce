<?php

Yii::import('common.models._base.BaseProductOption');

class ProductOption extends BaseProductOption
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
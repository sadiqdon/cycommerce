<?php

Yii::import('common.models._base.BaseProductAttribute');

class ProductAttribute extends BaseProductAttribute
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
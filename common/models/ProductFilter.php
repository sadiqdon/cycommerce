<?php

Yii::import('common.models._base.BaseProductFilter');

class ProductFilter extends BaseProductFilter
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
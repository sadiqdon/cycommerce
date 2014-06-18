<?php

Yii::import('common.models._base.BaseProductCategory');

class ProductCategory extends BaseProductCategory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
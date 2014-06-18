<?php

Yii::import('common.models._base.BaseProductRelated');

class ProductRelated extends BaseProductRelated
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
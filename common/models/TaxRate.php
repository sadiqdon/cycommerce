<?php

Yii::import('common.models._base.BaseTaxRate');

class TaxRate extends BaseTaxRate
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
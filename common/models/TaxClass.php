<?php

Yii::import('common.models._base.BaseTaxClass');

class TaxClass extends BaseTaxClass
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
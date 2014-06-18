<?php

Yii::import('common.models._base.BaseTaxRule');

class TaxRule extends BaseTaxRule
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
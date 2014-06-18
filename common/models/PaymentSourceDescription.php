<?php

Yii::import('common.models._base.BasePaymentSourceDescription');

class PaymentSourceDescription extends BasePaymentSourceDescription
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
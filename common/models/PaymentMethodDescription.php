<?php

Yii::import('common.models._base.BasePaymentMethodDescription');

class PaymentMethodDescription extends BasePaymentMethodDescription
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
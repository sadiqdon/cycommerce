<?php

Yii::import('common.models._base.BasePaymentTransaction');

class PaymentTransaction extends BasePaymentTransaction
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
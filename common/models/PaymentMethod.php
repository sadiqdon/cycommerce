<?php

Yii::import('common.models._base.BasePaymentMethod');

class PaymentMethod extends BasePaymentMethod
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
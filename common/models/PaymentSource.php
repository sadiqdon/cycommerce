<?php

Yii::import('common.models._base.BasePaymentSource');

class PaymentSource extends BasePaymentSource
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
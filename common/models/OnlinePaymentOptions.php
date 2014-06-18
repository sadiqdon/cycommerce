<?php

Yii::import('common.models._base.BaseOnlinePaymentOptions');

class OnlinePaymentOptions extends BaseOnlinePaymentOptions
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
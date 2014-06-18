<?php

Yii::import('common.models._base.BaseOnlinePaymentSettings');

class OnlinePaymentSettings extends BaseOnlinePaymentSettings
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
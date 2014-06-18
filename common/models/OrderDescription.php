<?php

Yii::import('common.models._base.BaseOrderDescription');

class OrderDescription extends BaseOrderDescription
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
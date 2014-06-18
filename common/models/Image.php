<?php

Yii::import('common.models._base.BaseImage');

class Image extends BaseImage
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
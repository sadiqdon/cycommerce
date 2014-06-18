<?php

Yii::import('common.models._base.BaseProduct');

class Product extends BaseProduct
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function relations() {
		$map = new CMap (parent::relations());
		$nrelation = array(
			'thumbs' => array(self::HAS_MANY, 'Image', 'model_id', 'condition' => 'thumbs.model_name = \'Product\''),
		);
		$map->mergeWith ($nrelation);
		return $map;
	}
}
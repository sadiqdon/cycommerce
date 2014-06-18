<?php

Yii::import('common.models._base.BaseFrontendSliderImages');

class FrontendSliderImages extends BaseFrontendSliderImages
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function relations() {
		$map = new CMap (parent::relations());
		$nrelation = array(
			'images' => array(self::HAS_MANY, 'Image', 'model_id', 'condition' => 'images.model_name = \'FrontendSliderImages\''),
		);
		$map->mergeWith ($nrelation);
		return $map;
	}
}
<?php

Yii::import('common.models._base.BaseFrontendBackgroundImages');

class FrontendBackgroundImages extends BaseFrontendBackgroundImages
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function relations() {
		$map = new CMap (parent::relations());
		$nrelation = array(
			'images' => array(self::HAS_MANY, 'Image', 'model_id', 'condition' => 'images.model_name = \'FrontendBackgroundImages\''),
		);
		$map->mergeWith ($nrelation);
		return $map;
	}
}
<?php

Yii::import('common.models._base.BaseOrderOption');

class OrderOption extends BaseOrderOption
{
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function compare($other) {
		if(!is_object($other))
			return false;

		if(get_class($this) !== get_class($other))
			return false;

		$diff = array();
		$match = true;
		foreach($this->attributes as $key => $value) {
			if($this->tableSchema->primaryKey != $key && $this->$key != $other->$key){
				$diff[$key] = array( 'old' => $this->$key, 'new' => $other->$key);
				$match = false;
			}
		}
		/*Yii::log( "OrderCreateActionoption: ".CVarDumper::dumpAsString( $diff),
						CLogger::LEVEL_ERROR, "order.actions.create" 
					);*/
		return $match;
	}
}
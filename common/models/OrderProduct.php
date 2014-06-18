<?php

Yii::import('common.models._base.BaseOrderProduct');

class OrderProduct extends BaseOrderProduct
{
	public $order_options;
	
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
			if($this->tableSchema->primaryKey != $key && $key != 'order_options' && $key != 'total' && $key != 'quantity' && $this->$key != $other->$key){
				$diff[$key] = array( 'old' => $this->$key, 'new' => $other->$key);
				$match = false;
			}
		}
		Yii::log( "OrderCreateActiondiff: ".CVarDumper::dumpAsString( $diff),
						CLogger::LEVEL_ERROR, "order.actions.create" 
					);
		
		$match2 = true;
		if($match){
			if(!empty($this->order_options) && !empty($other->order_options)){
				$flag = true;
				foreach($this->order_options as $cartorderoption){				
					foreach($other->order_options as $orderoption){
						if($orderoption->product_option_id == $cartorderoption->product_option_id){
							if(!$orderoption->compare($cartorderoption)){
								$match2 = false;
								
							}
							break;
						}
					}
					if(!$match2)
						break;
				}
			}else if(!empty($this->order_options) || !empty($other->order_options))
				$match2 = false;
		}
		
		return $match && $match2;
	}
}
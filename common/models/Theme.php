<?php

Yii::import('common.models._base.BaseTheme');

class Theme extends BaseTheme{

	//public $zip;
	/*
	public function rules(){
        return array(
            array('zip', 'file', 'types'=>'zip,application/octet-stream,application/zip   
					application/x-zip,
					application/octet-stream,
					application/x-zip-compressed'),
        );
    }*/
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
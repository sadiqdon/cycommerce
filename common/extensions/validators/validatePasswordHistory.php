<?php

class validatePasswordHistory extends CValidator
{
 
    public $history;
	
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel $object the object being validated
	 * @param string $attribute the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		if(isset(Yii::app()->user->id) && (Yii::app()->user->id > 0)){
			$phis = new PasswordHistory();
			$passes = $phis->getHistory(Yii::app()->user->id);
			if(!empty($passes) && !empty($object->$attribute)){
					$value=$object->$attribute;					
					//Yii::log('CODE '.print_r($passes), CLogger::LEVEL_ERROR, 'Instrument');
					//if(is_array($passes)){
						foreach($passes as $pass){						
							if(PasswordHelper::verifyPassword($value,$pass->password)){
								$this->addError($object,$attribute,'You can not use a password which you have used previously.');
								break;
							}
						}
					/*}else{
						if(PasswordHelper::verifyPassword($value,$passes->password))
							$this->addError($object,$attribute,'You can not use a password which you have used.');
					}*/
				
			}
		}
	}
	
	/**
	 * Returns the JavaScript needed for performing client-side validation.
	 * @param CModel $object the data object being validated
	 * @param string $attribute the name of the attribute to be validated.
	 * @return string the client-side validation script.
	 * @see CActiveForm::enableClientValidation
	 */
	public function clientValidateAttribute($object,$attribute)
	{
	 
		$phis = new PasswordHistory();
		$passes = $phis->getHistory(Yii::app()->user->id);
		$condition="1==2";
		foreach($passes as $pass){
			$value=$object->$attribute;
			if(PasswordHelper::verifyPassword($value,$pass->password)){
				$condition="1==1";
				$this->addError($object,$attribute,'You can not use a password which you have already used!');
				break;
			}
		}
			 
		return "
	if(".$condition.") {
		messages.push(".CJSON::encode('your password is too weak, you fool!').");
	}
	";
	}
}

?>
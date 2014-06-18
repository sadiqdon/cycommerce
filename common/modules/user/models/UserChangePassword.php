<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends CFormModel {
	public $oldPassword;
	public $password;
	public $verifyPassword;
	
	public function rules() {
		return Yii::app()->controller->id == 'recovery' ? array(
			array('password, verifyPassword', 'required'),
			array('password, verifyPassword', 'length', 'max'=>256, 'min' => 8,'message' => UserModule::t("Incorrect password (minimal length 8 symbols).")),
			array('password', 'common.extensions.validators.validatePasswordHistory', 'history'=>5),
			array('password', 'match', 'pattern'=>
'/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).*$/', 'message'=>'Must have at least one uppercase, one lowercase, one digit, one special character and at least 8 characters long!'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
		) : array(
			array('oldPassword, password, verifyPassword', 'required'),
			array('password, verifyPassword', 'length', 'max'=>256, 'min' => 8,'message' => UserModule::t("Incorrect password (minimal length 8 symbols).")),
			array('password', 'common.extensions.validators.validatePasswordHistory', 'history'=>5),
			array('password', 'match', 'pattern'=>
'/^.*(?=.{6,})(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\W]).*$/', 'message'=>'Must have at least one uppercase, one lowercase, one digit, one special character and at least 8 characters long!'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			array('oldPassword', 'verifyOldPassword','skipOnError'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'oldPassword'=>UserModule::t("Old Password"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
		);
	}
	
	/**
	 * Verify Old Password
	 */
	 public function verifyOldPassword($attribute, $params)
	 {
		 if (!PasswordHelper::verifyPassword($this->$attribute, User::model()->notsafe()->findByPk(Yii::app()->user->id)->password ))
			 $this->addError($attribute, UserModule::t("Old Password is incorrect."));
			 
	 }
}
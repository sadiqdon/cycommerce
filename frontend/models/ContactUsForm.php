<?php
/**
 * ContactUs.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 8:37 PM
 */

class ContactUsForm extends CFormModel {

	// maximum number of login attempts before display captcha
	const MAX_LOGIN_ATTEMPTS = 3;

	public $name;
	public $email;
	public $subject;
	public $comment;
	public $verifyCode;

	/**
	 * Model rules
	 * @return array
	 */
	public function rules() {
		return array(
			array('name, email, subject, comment', 'required'),
			array('verifyCode', 'validateCaptcha'),
		);
	}

	/**
	 * Returns attribute labels
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('label', 'Name'),
			'email' => Yii::t('label', 'Email'),
			'subject' => Yii::t('label', 'Subject'),
			'comment' => Yii::t('label', 'Comment'),
		);
	}

	/**
	 * Validates captcha code
	 * @param $attribute
	 * @param $params
	 */
	public function validateCaptcha($attribute, $params) {
			CValidator::createValidator('captcha', $this, $attribute, $params)->validate($this);
	}

}

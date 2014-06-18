<?php

class PageController extends Controller
{
	public $modelName = 'Page';
	public $action = 'view';
	
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}
	
	public function actionView($name) {
		//$model = $this->loadModel($id, $this->modelName);
		$model = Page::model()->findByAttributes(array('name'=>$name));
		$this->render('view',array('model'=>$model));
	}
	public function actionFaq() {
		//$model = $this->loadModel($id, $this->modelName);
		$models = Faq::model()->findAll();
		$this->render('faq',array('faqs'=>$models));
	}
	public function actionContactUs() {
		$model = new ContactUsForm;
		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'contactus-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if (isset($_POST['ContactUsForm'])) {
			$model->attributes = $_POST['ContactUsForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate()){
				UtilityHelper::sendMail($model->email, UtilityHelper::yiiparam('salesEmail'), 'Contact Us Request - '.$model->subject, $model->comment);
				$this->render('thankyou', array('model' => $model));
			}
		}
		// display the login form
		$this->render('contactus', array('model' => $model));
	}
}
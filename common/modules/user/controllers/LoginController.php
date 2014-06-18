<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					$url = Yii::app()->controller->module->returnUrl;
					$this->redirect($url);
					//print_r($url);
				}
			}
			// display the login form
			if(isset($this->location))
				$this->render('frontend.views.user.login',array('model'=>$model));
			else
				$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->user->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}

}
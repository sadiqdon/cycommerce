<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	//public $layout='//layouts/column1';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$view = 'profile';
		if(isset($this->location))
			$view = 'frontend.views.profile.profile';
			
		$model = $this->loadUser();
	    $this->render($view,array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		$view = 'edit';
		if(isset($this->location))
			$view = 'frontend.views.profile.edit';
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}

		$this->render($view,array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	 
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			//$phis = new PasswordHistory();
			//$passes = $phis->getHistory(Yii::app()->user->id);
			//CVarDumper::dump($passes);
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = PasswordHelper::hashPassword($model->password);
						$new_password->activkey=PasswordHelper::hashPassword(microtime().$model->password);
						$new_password->password_update_time = date('Y-m-d H:i:s');
						$new_password->save();
						$passwordHistory = new PasswordHistory;
						$passwordHistory->profile_id = $new_password->id;
						$passwordHistory->password = $new_password->password;
						$passwordHistory->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			if(isset($this->location))
				$this->render('frontend.views.profile.changepassword',array('model'=>$model));
			else
				$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}
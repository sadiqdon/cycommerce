<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	//public $layout='//layouts/column1';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 *
	public function accessRules()
	{
		return array(
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		$profile=new Profile;
		
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$realp = PasswordHelper::generateStrongPassword();
				$model->password = $realp;
				$model->activkey=PasswordHelper::hashPassword(microtime().$model->password);
				$model->password=PasswordHelper::hashPassword($model->password);
				$model->status = 0;
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
					if(!empty($_POST['Profile']['group_id'])){
						foreach ($_POST['Profile']['group_id'] as $groupid){
							$userGroup = new UserGroup;
							$userGroup->profile_id = $model->id;
							$userGroup->group_id = $groupid;
							$userGroup->save();
						}
					}
					$passwordHistory = new PasswordHistory;
					$passwordHistory->profile_id = $model->id;
					$passwordHistory->password = $model->password;
					$passwordHistory->save();
					if (Yii::app()->controller->module->sendActivationMail) {
						$activation_url = $this->createAbsoluteUrl('/user/activation',array("activkey" => $model->activkey, "email" => $model->email));
						UserModule::sendMail($model->email,UserModule::t("Your {site_name} account has been created",array('{site_name}'=>Yii::app()->name)),UserModule::t("To activate your account, go to <a href='{activation_url}'>{activation_url}</a>.<br/><br/>Username: ".$model->username."<br/>Password: ".$realp."<br/>",array('{activation_url}'=>$activation_url)));
					}
					$this->redirect(array('view','id'=>$model->id));
				}else{
					Yii::app()->user->setFlash('error', 'An error occured while trying to create new user, please try again.');
					$this->render('create',array(
						'model'=>$model,
						'profile'=>$profile,
					));
				}
				
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$gprofile = Profile::model()->with('groups')->findbyPk($model->id);
		$profile->group_id = $gprofile->groups;
		
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			//$model->attributes=$_POST['User'];
			
			$model->status = $_POST['User']['status'];
			
			//$profile->attributes=$_POST['Profile'];
			
			$profile->branch_id = $_POST['Profile']['branch_id'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				/*if ($old_password->password!=$model->password) {
					$model->password=PasswordHelper::hashPassword($model->password);
					$model->activkey=PasswordHelper::hashPassword(microtime().$model->password);
				}*/
				$model->save();
				$profile->save();
				
				$criteria=new CDbCriteria;
				$criteria->condition='profile_id=:profile_id';
				$criteria->params=array(':profile_id'=>$model->id);
				UserGroup::model()->deleteAll($criteria);
				
				foreach ($_POST['Profile']['group_id'] as $groupid){
					$userGroup = new UserGroup;
					$userGroup->profile_id = $model->id;
					$userGroup->group_id = $groupid;
					$userGroup->save();
				}
				
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			
			$criteria=new CDbCriteria;
			$criteria->condition='profile_id=:profile_id';
			$criteria->params=array(':profile_id'=>$model->id);
			UserGroup::model()->deleteAll($criteria);
			
			// Make sure profile exists
			if ($profile)
				$profile->delete();

			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	*/
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
}

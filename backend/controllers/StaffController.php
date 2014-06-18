<?php

class StaffController extends CrudController
{
	public $modelName = 'Staff';
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new Staff;
		$profile=new Profile;
		
		$this->performAjaxValidation(array($model,$profile),'staff-form');
		if(isset($_POST['Staff']))
		{
			$model->attributes=$_POST['Staff'];
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
					if (Yii::app()->getModule('user')->sendActivationMail) {
						$activation_url = $this->createAbsoluteUrl('/user/activation',array("activkey" => $model->activkey, "email" => $model->email));
						UserModule::sendMail($model->email,UserModule::t("Your {site_name} account has been created",array('{site_name}'=>Yii::app()->name)),UserModule::t("To activate your account, go to <a href='{activation_url}'>{activation_url}</a>.<br/><br/>Username: ".$model->username."<br/>Password: ".$realp."<br/>",array('{activation_url}'=>$activation_url)));
					}
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'profile'=>$profile), false, true);
						Yii::app()->end();
					}
					$this->redirect(array('view','id'=>$model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, 'An error occured while trying to create new user, please try again.');
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_form', array('model' => $model, 'profile'=>$profile), false, true);
						Yii::app()->end();
					}
					$this->render('create',array(
						'model'=>$model,
						'profile'=>$profile,
					));
				}
				
			} else $profile->validate();
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form', array('model' => $model, 'profile'=>$profile), false, true);
			Yii::app()->end();
		}
		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		//$model=$this->loadModel();
		$profile=$model->profile;
		$gprofile = Profile::model()->with('groups')->findbyPk($model->id);
		$profile->group_id = $gprofile->groups;
		
		$this->performAjaxValidation(array($model,$profile),'staff-form');
		if(isset($_POST['Staff']))
		{
			//$model->attributes=$_POST['Staff'];
			
			$model->status = $_POST['Staff']['status'];
			
			//$profile->attributes=$_POST['Profile'];
			
			$profile->branch_id = $_POST['Profile']['branch_id'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = Staff::model()->notsafe()->findByPk($model->id);
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
				if(!empty($_POST['Profile']['group_id']))
					foreach ($_POST['Profile']['group_id'] as $groupid){
						$userGroup = new UserGroup;
						$userGroup->profile_id = $model->id;
						$userGroup->group_id = $groupid;
						$userGroup->save();
					}
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					$this->renderPartial('_view', array('model' => $model, 'profile'=>$profile), false, true);
					Yii::app()->end();
				}
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_update', array('model' => $model, 'profile'=>$profile), false, true);
			Yii::app()->end();
		}
		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	public function actionDelete($id) {
			parent::delete($id, $this->modelName);
			}
	
	public function actionBatchDelete() {
			parent::batchDelete($this->modelName);
		}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'username',
		'password',
		'email',
		'activkey',
		'superuser',
		'status',
		'type',
		'create_at',
		'lastvisit_at',
		'password_update_time',
		);
		 		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'username',
		'password',
		'email',
		'activkey',
		'superuser',
		'status',
		'type',
		'create_at',
		'lastvisit_at',
		'password_update_time',
		);
		
		parent::exportAll($this->modelName, $criteriaWith, $exportfield);
	}

	public function actionIndex() {
		$dorder = '';
		$modelName = $this->modelName;
		if($modelName::model()->hasAttribute('sort_order'))
			$dorder = 't.sort_order ASC';
		else if($modelName::model()->hasAttribute('id'))
			$dorder = 't.id DESC';
		$criteriaWith = $attr = array();
		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new Staff('search');
		parent::admin($model, $this->modelName);	
	}
}

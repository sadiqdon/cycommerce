<?php

class CustomerController extends CrudController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	private $_model;
	
	private $_address = array();
	
	public $modelName = 'Customer';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	*/
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id, $this->modelName);
		$profile=$model->profile;
		$this->loadAddress($model->id);
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_view', array('model' => $model, 'profile'=>$profile, 'address'=>$this->_address), false, true);	
			Yii::app()->end();
		}
		$this->render('view', array(
			'model' => $model,
		));
	}

		/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Customer;
		$profile=new Profile;
		$address=new CheckoutAddress;
		//Yii::app()->session['cid'] = '';
		$this->performAjaxValidation(array($model,$profile), 'customer-form');
		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			$profile->attributes=$_POST['Profile'];
			
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()&&$this->validateAddress()) {
				$realp = PasswordHelper::generateStrongPassword();
				$model->password = $realp;
				$model->activkey=PasswordHelper::hashPassword(microtime().$model->password);
				$model->password=PasswordHelper::hashPassword($model->password);
				$model->status = 0;
				$model->type = 1;
				if($model->save()) {
					Yii::app()->session['cid'] = $model->id;
					$profile->user_id=$model->id;
					$profile->save();
					if(!empty($_POST['Customer']['c_group_id'])){
						foreach ($_POST['Customer']['c_group_id'] as $groupid){
							$customerGroup = new CustomerCGroup;
							$customerGroup->user_id = $model->id;
							$customerGroup->c_group_id = $groupid;
							$customerGroup->save();
						}
					}
					$passwordHistory = new PasswordHistory;
					$passwordHistory->profile_id = $model->id;
					$passwordHistory->password = $model->password;
					$passwordHistory->save();
					
					foreach($this->_address as $address){
						$address->user_id = $model->id;
						$address->save();
					}
					if (Yii::app()->getModule('user')->sendActivationMail) {
						$activation_url = $this->createAbsoluteUrl('/user/activation',array("activkey" => $model->activkey, "email" => $model->email));
						UserModule::sendMail($model->email,UserModule::t("Your {site_name} account has been created",array('{site_name}'=>Yii::app()->name)),UserModule::t("To activate your account, go to <a href='{activation_url}'>{activation_url}</a>.<br/><br/>Username: ".$model->username."<br/>Password: ".$realp."<br/>",array('{activation_url}'=>$activation_url)));
					}
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,Yii::t('info','Customer was successfully created'));

					$this->renderPartial('_view', array('model' => $model,'profile'=>$profile,'address'=>$this->_address), false, true);
					Yii::app()->end();
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('info','An error occurred while trying to create new customer, please try again.'));
					/*$this->render('create',array(
						'model'=>$model,
						'profile'=>$profile,
					));*/
				}
				
			} else{ 
				$profile->validate();
				$this->validateAddress();
				//echo GxActiveForm::validateMultiple(array($model,$profile,$address));
				
				//Yii::app()->end();
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form_address', array('model' => $model,'profile'=>$profile,'address'=>$this->_address), false, true);
			Yii::app()->end();
		}
		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
			'address'=>$this->_address,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id, 'Customer');
		$profile=Profile::model()->findbyPk($model->id);
		$model->c_group_id = $model->groups;
		$this->loadAddress($model->id);
		
		$this->performAjaxValidation(array($model,$profile), 'customer-form');
		
		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			
			//$model->status = $_POST['Customer']['status'];
			
			$profile->attributes=$_POST['Profile'];
			
			//$profile->branch_id = $_POST['Profile']['branch_id'];
			
			if($model->validate()&&$profile->validate()&&$this->validateAddress()) {
				$old_password = Customer::model()->notsafe()->findByPk($model->id);
				/*if ($old_password->password!=$model->password) {
					$model->password=PasswordHelper::hashPassword($model->password);
					$model->activkey=PasswordHelper::hashPassword(microtime().$model->password);
				}*/
				$model->save();
				$profile->save();
				
				$criteria=new CDbCriteria;
				$criteria->condition='user_id=:user_id';
				$criteria->params=array(':user_id'=>$model->id);
				CustomerCGroup::model()->deleteAll($criteria);
				if(!empty($_POST['Customer']['c_group_id'])){
					
					foreach ($_POST['Customer']['c_group_id'] as $groupid){
						$userGroup = new CustomerCGroup;
						$userGroup->user_id = $model->id;
						$userGroup->c_group_id = $groupid;
						$userGroup->save();
					}
				}
				//$data = CheckoutAddress::model()->findAll('user_id=:user_id', array(':user_id'=>$model->id));
				CheckoutAddress::model()->deleteAll('user_id=:user_id', array(':user_id'=>$model->id));
				foreach($this->_address as $address){
					$address->user_id = $model->id;
					$address->save();
				}
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,Yii::t('info','Customer was successfully updated'));
				$this->renderPartial('_view', array('model' => $model,'profile'=>$profile,'address'=>$this->_address), false, true);
				Yii::app()->end();
			}else{ 
				$profile->validate();
				$this->validateAddress();
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form_address', array('model' => $model,'profile'=>$profile,'address'=>$this->_address), false, true);
			Yii::app()->end();
		}
		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
			'address'=>$this->_address,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel($id, 'Customer');
			$profile = Profile::model()->findByPk($model->id);
			Yii::app()->session['cid'] = $model->id;
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

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dorder = '';
		$modelName = $this->modelName;
		if($modelName::model()->hasAttribute('sort_order'))
			$dorder = 't.sort_order ASC';
		else if($modelName::model()->hasAttribute('id'))
			$dorder = 't.id DESC';
		$criteriaWith = $attr = array();
		
		//$attr['name'] = array('asc' => 'optionDescriptions.name ASC', 'desc' => 'optionDescriptions.name DESC');
		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}
	
	public function actionCreateAddress(){
		$model = new CheckoutAddress;
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			
			$this->performAjaxValidationTabular($model, 'address-form');
		
			if (isset($_POST['CheckoutAddress'])) {
				$model->setAttributes($_POST['CheckoutAddress']);
				$suc = Yii::t('info','The record was successfully created');
				$err = Yii::t('info','The record could not be created');
				$noc = Yii::t('info','You have to create customer information by using the general tab on the left, before you can attach an address.');
				if(!empty(Yii::app()->session['cid'])){
					$model->user_id = Yii::app()->session['cid'];
					if ($model->save()) {
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
						$this->renderPartial('_address', array('model' => $model), false, true);
						Yii::app()->end();
					}else{
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
					}
				}
				else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$noc);
					$model->validate();
				}
			}
			$marr = array('model' => $model);
			if(isset($_POST['id'])){
				$marr['id'] = $_POST['id'];
			}
			$this->renderPartial('_address', $marr, false, true);
			Yii::app()->end();
			
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalidu.'));
	}
	
	public function actionUpdateAddress($id){
		$model=$this->loadModel($id, 'CheckoutAddress');
		
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			
			$this->performAjaxValidationTabular($model, 'address-form');
		
			if (isset($_POST['CheckoutAddress'])) {
				$model->setAttributes($_POST['CheckoutAddress']);
				$suc = Yii::t('info','The record was successfully updated');
				$err = Yii::t('info','The record could not be updated');
				if ($model->save()) {
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					$this->renderPartial('_address', array('model' => $model), false, true);
					Yii::app()->end();
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}
			}
			$this->renderPartial('_address', array('model' => $model), false, true);
			Yii::app()->end();
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Customer('search');
		parent::admin($model, 'Customer');
	}
	
	public function actionZones($id)
	{
		//echo 'post is'.$id;
		if (Yii::app()->getRequest()->getIsAjaxRequest() && isset($id)){
			$data = Zone::model()->findAll('country_id=:country_id', 
					  array(':country_id'=>(int)$_POST['CheckoutAddress'][$id]['country_id']));
			$data=CHtml::listData($data,'id','name');
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option',
						   array('value'=>$value),CHtml::encode($name),true);
			}
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadCustomer($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=Customer::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	public function loadAddress($id){
		$data = CheckoutAddress::model()->findAll('user_id=:user_id', array(':user_id'=>$id));
		$this->_address = $data;
	}
	
	public function validateAddress(){
		if(isset($_POST['CheckoutAddress']))
		{
			$valid=true;
			
			foreach($_POST['CheckoutAddress'] as $i=>$item)
			{
				$model = new CheckoutAddress;
				if(isset($_POST['CheckoutAddress'][$i])){
					$model->attributes=$_POST['CheckoutAddress'][$i];
					$model->user_id=0;
					$valid=$model->validate() && $valid;
					$this->_address[$i] = $model;
				}
			}
			if(!$valid)
				return false;
		}
		return true;
	}
	
	protected function performAjaxValidationTabular($model, $form = null) {
		if (Yii::app()->getRequest()->getIsAjaxRequest() && (($form === null) || (isset($_POST['ajax']) && parent::startsWith($_POST['ajax'], $form)))) {
			echo GxActiveForm::validateMultiple($model);
			Yii::app()->end();
		}
	}
	
	
}

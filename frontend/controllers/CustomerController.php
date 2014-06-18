<?php

class CustomerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column3';
	
	private $_model;
	
	private $_address = array();
	
	public $modelName = 'Customer';
	
	public $defaultAction = 'view';

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
	public function actionView()
	{
		$model=$this->loadUser();
		$profile=$model->profile;
		$this->loadAddress($model->id);
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_view', array('model' => $model, 'profile'=>$profile, 'address'=>$this->_address), false, true);	
			Yii::app()->end();
		}
		$this->render('view', array(
			'model' => $model,
			'profile'=>$profile,
			'address'=>$this->_address,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadUser();
		$profile=$model->profile;
		//$model->c_group_id = $model->groups;
		$this->loadAddress($model->id);
		
		//$this->performAjaxValidation(array($model,$profile), 'customer-form');
		
		if(isset($_POST['Customer']) || isset($_POST['Staff']))
		{
			if(isset($_POST['Customer']))
				$model->attributes=$_POST['Customer'];
			else
				$model->attributes=$_POST['Staff'];
			
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
				/*CustomerCGroup::model()->deleteAll($criteria);
				if(!empty($_POST['Customer']['c_group_id'])){
					
					foreach ($_POST['Customer']['c_group_id'] as $groupid){
						$userGroup = new CustomerCGroup;
						$userGroup->user_id = $model->id;
						$userGroup->c_group_id = $groupid;
						$userGroup->save();
					}
				}*/
				//$data = CheckoutAddress::model()->findAll('user_id=:user_id', array(':user_id'=>$model->id));
				CheckoutAddress::model()->deleteAll('user_id=:user_id', array(':user_id'=>$model->id));
				foreach($this->_address as $address){
					$address->user_id = $model->id;
					$address->save();
				}
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,Yii::t('info','Your Profile was successfully updated'));
				//$this->renderPartial('view', array('model' => $model,'profile'=>$profile,'address'=>$this->_address), false, true);
				echo json_encode(array('redirect'=>$this->createUrl('view')));
				Yii::app()->end();
			}else{ 
				$profile->validate();
				$this->validateAddress();
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('update', array('model' => $model,'profile'=>$profile,'address'=>$this->_address), false, true);
			Yii::app()->end();
		}
		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
			'address'=>$this->_address,
		));
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
				$this->_model=Yii::app()->getModule('user')->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->getModule('user')->loginUrl);
		}
		return $this->_model;
	}
	
	protected function performAjaxValidationTabular($model, $form = null) {
		if (Yii::app()->getRequest()->getIsAjaxRequest() && (($form === null) || (isset($_POST['ajax']) && parent::startsWith($_POST['ajax'], $form)))) {
			echo GxActiveForm::validateMultiple($model);
			Yii::app()->end();
		}
	}
}

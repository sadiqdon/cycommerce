<?php

class OrderController extends CrudController
{
	public $modelName = 'Order';
	
	private $_orderoption = array();
	
	private $_ordercustomer = array();
	
	private $_orderprofile = array();
	
	private $_orderproduct = array();
	
	public function actionView($id) {
		$model = $this->loadModel($id, $this->modelName);
		if(!empty($model->orderDescriptions))
			$description = $model->orderDescriptions[0];
		else
			$description = new orderDescription;
		foreach($model->orderProducts as $product){
			$orderproduct = $product;
			$orderproduct->order_options = $product->orderOptions;
			$this->_orderproduct[] = $orderproduct;
		}
		/*Yii::log( "OrderViewActionvaliid: ".CVarDumper::dumpAsString($model->payment_firstname ),
						CLogger::LEVEL_ERROR, "order.actions.view" 
					);*/
		
		
		
		
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_view', array( 'model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct), false, true);	
			Yii::app()->end();
		}
		$this->render('view', array(
			'model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct
		));
	}

	public function actionCreate() {		
		$model = new Order;
		$description = new OrderDescription;

		if(!isset($_POST[$this->modelName]))
			Yii::app()->user->setState('order_product', NULL );
		//$order_option_value = new OrderOptionValue;
		
		//$this->performAjaxValidation(array($model,$description), 'order-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			//$customer->setAttributes($_POST['Customer']);
			$suc = Yii::t('info','Order was successfully created');
			$err = Yii::t('info','Could not create Order');
			$description->order_id = 0;
			$description->locale_code = Yii::app()->getLanguage();
			
			if(isset($model->store_id) && $model->store_id > 0){
				$store = Store::model()->findByPk($model->store_id);
				$model->store_name = $store->name;
				$model->store_url = $store->url;
				$model->ip = Yii::app()->request->userHostAddress;
				$model->user_agent = Yii::app()->request->userAgent;
			}
			if(isset($model->payment_country_id) && $model->payment_country_id > 0)
				$model->payment_country = Country::model()->findByPk($model->payment_country_id)->name;
			if(isset($model->payment_zone_id) && $model->payment_zone_id > 0)
				$model->payment_zone = Zone::model()->findByPk($model->payment_zone_id)->name;
			if(isset($model->shipping_country_id) && $model->shipping_country_id > 0)
				$model->shipping_country = Country::model()->findByPk($model->shipping_country_id)->name;
			if(isset($model->shipping_zone_id) && $model->shipping_zone_id > 0)
				$model->shipping_zone = Zone::model()->findByPk($model->shipping_zone_id)->name;
			if(!empty($this->_orderproduct)){
				$total = 0;
				foreach($this->_orderproduct as $oproduct){
					$total += $oproduct->total;
				}
				$model->total = $total;
			}
			
			$model->payment_code = uniqid().rand(1, 9);
			
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description->order_id = $model->id;
					$description->save();
					$this->orderSave($model);
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description, 'orderProduct' => $this->_orderproduct), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}				
			}else
				$description->validate();
			
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form_order', array('model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		if(!empty($model->orderDescriptions))
			$description = $model->orderDescriptions[0];
		else
			$description = new orderDescription;
		foreach($model->orderProducts as $product){
			$orderproduct = $product;
			$orderproduct->order_options = $product->orderOptions;
			$this->_orderproduct[] = $orderproduct;
		}
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$description->locale_code = Yii::app()->getLanguage();
			//$customer->setAttributes($_POST['Customer']);
			$suc = Yii::t('info','Order was successfully created');
			$err = Yii::t('info','Could not create Order');
			if ($model->validate() && $description->validate()){
				if ($model->save()) {
					$description->order_id = $model->id;
					$description->save();
					//$this->orderSave($model);
					if(!$model->check && in_array($model->order_status_id, array(2,3,5))){
						UtilityHelper::subtractOrder($model->id);
						$model->check = 1;
						$model->save();
					}
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					/*foreach($model->orderProducts as $product){
						$orderproduct = $product;
						$orderproduct->order_options = $product->orderOptions;
						$this->_orderproduct[] = $orderproduct;
					}*/
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}				
			}else
				$description->validate();
			
		}
		/*Yii::log( "OrderViewActionvaliid: ".CVarDumper::dumpAsString($model->payment_firstname ),
						CLogger::LEVEL_ERROR, "order.actions.view" 
					);*/
		
		
		
		
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_update', array( 'model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct), false, true);	
			Yii::app()->end();
		}
		$this->render('update', array(
			'model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct
		));
		
	}
		
	public function actionZones()
	{
		if(isset($_POST['Order']['shipping_country_id']))
			$id = (int)$_POST['Order']['shipping_country_id'];
		else if(isset($_POST['Order']['payment_country_id']))
			$id = (int)$_POST['Order']['payment_country_id'];
		if (Yii::app()->getRequest()->getIsAjaxRequest() && isset($id)){
			$data = Zone::model()->findAll('country_id=:country_id', 
					  array(':country_id'=>$id));
			$data=CHtml::listData($data,'id','name');
			foreach($data as $value=>$name)
			{
				echo CHtml::tag('option',
						   array('value'=>$value),CHtml::encode($name),true);
			}
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));
	}
	
	public function loadProductOption($id){
		$_productoption = array();
		$data = ProductOption::model()->findAll('product_id=:product_id', array(':product_id'=>$id));
		if(!empty($data))
			foreach($data as $productoption){
				$value = ProductOptionValue::model()->findAll('product_option_id=:product_option_id', array(':product_option_id'=>$productoption->id));
				$_productoption[] = array($productoption, $value);
			}
		return $_productoption;
	}
	
	public function actionGetProductOption(){
		$id = 0;
		if(isset($_POST['id']))
			$id = $_POST['id'];
		else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.'));
		$options = $this->loadProductOption($id);
		$this->renderPartial('_product_option', array('options' => $options), false, true);
	}
	
	public function optionDataColumn($data, $row){
		$op = ""; 
		if(!empty($data->order_options)) 
			foreach($data->order_options as $i=>$option){
				//$op += "<span class=\'option\'><span class=\'label\'>{$option->name}</span><span class=\'text\'>";
				$op += $option->name.': ';
				if($option->type == "select" || $option->type == "radio" || $option->type =="checkbox"){
					$optval = OptionValue::model()->findByPk($option->product_option_value_id);
					if(!empty($optval)){
						$op += $optval->getName();
						if(isset($option[$i+1]) && ($option[$i+1]->product_option_id == $option[$i]->product_option_id)){ 
							$op += ", ";
						}
					}
				}
				else{
					$op += $option->value;
				}
				$op += "\n";
			}
		return $op;
	}
	public function actionRefreshDetails(){
		$model = new Order;
		$description = new OrderDescription;
		$sess = Yii::app()->user->getState('order_product');
		$model->setAttributes($_POST[$this->modelName]);
		$description->setAttributes($_POST[$this->modelName.'Description']);
		$this->renderPartial('_details', array('orderproduct' => $sess, 'model'=>$model, 'description'=>$description), false, true);
		Yii::app()->end();
	}
	public function actionRemoveProduct($id){
		$sess = Yii::app()->user->getState('order_product');
		$stat = 'error';
		$mesg = 'The product was not found';
		if(!empty($sess)){
			foreach($sess as $i=>$cart){
				if($i == $id){
					unset($sess[$i]);
					$sess = array_values($sess);
					$stat = 'success';
					$mesg = 'Product removed successfully';
					break;
				}
			}
			Yii::app()->user->setState('order_product', $sess );			
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest())
			echo json_encode(array($stat => $mesg));
	}
	public function actionAddProduct(){
		$sess = Yii::app()->user->getState('order_product');
		if(!empty($_POST['OrderProduct']['id']) && !empty($_POST['OrderProduct']['quantity'])){
			$product = Product::model()->findByPk($_POST['OrderProduct']['id']);
			$orderproduct = new OrderProduct;
			$orderproduct->order_id = 0;
			$orderproduct->product_id = $product->id;
			$orderproduct->name = $product->getName();
			$orderproduct->model = $product->model;
			$orderproduct->quantity = $_POST['OrderProduct']['quantity'];
			$orderproduct->price = $product->price;
			$orderproduct->total = $orderproduct->quantity * $product->price;
			$orderproduct->tax = 0;
			
			if($this->addProductOption($product->id) && $orderproduct->validate()){
				$orderproduct->order_options = $this->_orderoption;
				$orderoptions = $this->_orderoption;
				
				if(!empty($sess)){
					$addnew = true;
					foreach($sess as $i=>$cart){
						$match = $match2 = false;
						$diff = $orderproduct->compare($cart);
						if($diff){
							$sess[$i]->quantity += $_POST['OrderProduct']['quantity'];
							$addnew = false;
							break;
						}							
					}
					if($addnew)
						$sess[] = $orderproduct;				
				}
				else{
					$sess = array($orderproduct);
				}
				
				Yii::app()->user->setState('order_product', $sess );

				$this->renderPartial('_products', array('orderproduct' => $sess), false, true);
				Yii::app()->end();
			}
			else{				
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,Yii::t('info','Please fill out all required fields for product options'));
				Yii::log( "OrderCreateActionvaliid: ".CVarDumper::dumpAsString( $orderproduct->getErrors()),
						CLogger::LEVEL_ERROR, "order.actions.create" 
					);
			}
			
		}
		else{				
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,Yii::t('info','Please fill out all required fields'));
		}
		
		if(empty($sess)){ $sess = array();}
		$norderopt = array();
		if(isset($_POST['OrderProduct']['id']))
			$norderopt = $this->loadProductOption($_POST['OrderProduct']['id']);
		$this->renderPartial('_products', array('orderproduct' => $sess, 'orderoption' => $norderopt));
		
	}
	
	public function addProductOption($id){
		$valid = true;
		$validReal = true;
		$orderoptions = $optionids = array();
		if(!empty($_POST['OrderOption'])) {			
			foreach($_POST['OrderOption'] as $option){
				if(isset($option['product_option_value_id']) && is_array($option['product_option_value_id']))
					foreach($option['product_option_value_id'] as $value_id){
						$orderoption = new OrderOption;
						$orderoption->attributes = $option;
						$orderoption->product_option_value_id = $value_id;
						$valid = $valid && $this->validateProductOption($orderoption);
						$orderoptions[] = $orderoption;
						$optionids[] = $orderoption->product_option_id;
					}
				else{
					$orderoption = new OrderOption;
					$orderoption->attributes = $option;
					$valid = $valid && $this->validateProductOption($orderoption);
					$orderoptions[] = $orderoption;
					$optionids[] = $orderoption->product_option_id;
				}
			}
			
		}
		$chkoptions = $this->loadProductOption($id);
		if(!empty($chkoptions))
			foreach($chkoptions as $realoption){
				if($realoption[0]->required && !in_array($realoption[0]->id, $optionids)){
					$validReal = false;
					
					break;
				}
			}
		/*Yii::log( "OrderCreateActionaappP: ".$validReal.' - '.$valid.'---',
						CLogger::LEVEL_ERROR, "order.actions.create" 
					);*/
		$this->_orderoption = $orderoptions;
		return $valid && $validReal;
	}
	
	public function validateProductOption($option){
		$valid = true;
		$option->order_id = 0;
		$popt = ProductOption::model()->findByPk($option->product_option_id);
		if($option->type == 'select' || $option->type == 'radio' || $option->type =='checkbox'){
			if($popt->required && (empty($option->product_option_value_id) || !is_numeric($option->product_option_value_id)))
				$valid =  false;
		}else{
			$option->product_option_value_id = 0;
			if($popt->required && empty($option->value))
				$valid =  false;
		}
		$valid = $valid && $option->validate();
		/*Yii::log( "OrderCreateActionvaliid: ".$option->name.' - '.$valid.'---'.CVarDumper::dumpAsString( $option->getErrors()),
						CLogger::LEVEL_ERROR, "order.actions.create" 
					);*/
		return $valid;
	}
	
	public function validateCustomer(){
		if(isset($_POST['Customer']))
		{			
			$customer = new Customer;
			$profile = new Profile;
			$customer->attributes = $_POST['Customer'];
			$profile->attributes=$_POST['Profile'];
			$valid = $customer->validate();
			$valid = $profile->validate() && $valid;
			$this->_ordercustomer = $customer;
			$this->_orderprofile = $profile;

			if(!$valid){
				return false;
			}
			
		}
		return true;
	}
	
	protected function orderSave($model){
		$id = $model->id;
		
		$orderproducts = Yii::app()->user->getState('order_product');
		if(!empty($orderproducts))
			foreach($orderproducts as $orderproduct){
				$orderoptions = $orderproduct->order_options;
				$orderproduct->order_id = $id;
				$orderproduct->save();
				foreach($orderoptions as $orderoption){
					$orderoption->order_id = $id;
					$orderoption->order_product_id = $orderproduct->id;
					$orderoption->save();
				}
			}	
		/*if(!empty($this->_ordercustomer)){
			$customer = $this->_ordercustomer;
			$profile = $this->_orderprofile;
			$customer->save();
			$profile->user_id=$customer->id;
			$profile->save();
		}*/
	}
	
	/*public function validateOrder(&$model, &$description)
	{
		$error = '';
		$ordercustomer = $this->validateCustomer();
		
		if(!$ordercustomer)
			$error .= Yii::t('info','Please fill in all required fields for Customer').'<br/>';

		return $model->validate() && $description->validate() && $customer->ordercustomer;
	}*/
	

	
	public function actionDelete($id) {
			parent::delete($id, $this->modelName, array('orderDescriptions','orderHistories','orderOptions','orderProducts','orderTotals'));
	}
	
	public function actionBatchDelete() {
			parent::batchDelete($this->modelName, array('orderDescriptions','orderHistories','orderOptions','orderProducts','orderTotals'));
	}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'invoice_no',
		'invoice_prefix',
		'store_id',
		'store_name',
		'store_url',
		'customer_id',
		'customer_group_id',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'fax',
		'payment_firstname',
		'payment_lastname',
		'payment_company',
		'payment_company_id',
		'payment_tax_id',
		'payment_address_1',
		'payment_address_2',
		'payment_city',
		'payment_postcode',
		'payment_country',
		'payment_country_id',
		'payment_zone',
		'payment_zone_id',
		'payment_address_format',
		'payment_method',
		'payment_code',
		'shipping_firstname',
		'shipping_lastname',
		'shipping_company',
		'shipping_address_1',
		'shipping_address_2',
		'shipping_city',
		'shipping_postcode',
		'shipping_country',
		'shipping_country_id',
		'shipping_zone',
		'shipping_zone_id',
		'shipping_address_format',
		'shipping_method',
		'shipping_code',
		'total',
		'order_status_id',
		'currency_id',
		'currency_code',
		'currency_value',
		'ip',
		'forwarded_ip',
		'user_agent',
		'accept_language',
		'date_added',
		'date_modified',
		);
		 		$criteriaWith = array(
			'orderDescriptions'=>array(
                          'together'=>true
                     ),
		);
		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'invoice_no',
		'invoice_prefix',
		'store_id',
		'store_name',
		'store_url',
		'customer_id',
		'customer_group_id',
		'firstname',
		'lastname',
		'email',
		'telephone',
		'fax',
		'payment_firstname',
		'payment_lastname',
		'payment_company',
		'payment_company_id',
		'payment_tax_id',
		'payment_address_1',
		'payment_address_2',
		'payment_city',
		'payment_postcode',
		'payment_country',
		'payment_country_id',
		'payment_zone',
		'payment_zone_id',
		'payment_address_format',
		'payment_method',
		'payment_code',
		'shipping_firstname',
		'shipping_lastname',
		'shipping_company',
		'shipping_address_1',
		'shipping_address_2',
		'shipping_city',
		'shipping_postcode',
		'shipping_country',
		'shipping_country_id',
		'shipping_zone',
		'shipping_zone_id',
		'shipping_address_format',
		'shipping_method',
		'shipping_code',
		'total',
		'order_status_id',
		'currency_id',
		'currency_code',
		'currency_value',
		'ip',
		'forwarded_ip',
		'user_agent',
		'accept_language',
		'date_added',
		'date_modified',
		);
		$criteriaWith = array(
			'orderDescriptions'=>array(
                          'together'=>true
                     ),
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
		/*$criteriaWith = array(
			'orderDescriptions'=>array(
                          'together'=>true
                     ),
		);
		$attr['name'] = array('asc' => 'orderDescriptions.name ASC', 'desc' => 'orderDescriptions.name DESC');*/
		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new Order('search');
		parent::admin($model, $this->modelName);	
	}
}

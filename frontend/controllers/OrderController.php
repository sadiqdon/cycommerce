<?php

class OrderController extends Controller
{
	public $modelName = 'Order';
	
	private $_orderoption = array();
	
	private $_ordercustomer = array();
	
	private $_orderproduct = array();

	public function actionView($id) {
		$model = $this->loadModel($id, 'Order');
		$this->loadOrder($model);
	}
	
	public function actionOrderStatus() {
		Yii::app()->getClientScript()->registerCoreScript('yii');
		if(isset($_POST['trans_id'])){
			$order = Order::model()->findByAttributes(array('payment_code'=>$_POST['trans_id']));
			if(!empty($order)){
				$this->loadOrder($order);
			}
			Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,'Transaction Reference was not found, Please enter a valid transaction reference number');
		}
		$this->render('orderstatus');
		
	}
	public function loadOrder($model) {
		$description = array();
		if(!empty($model->orderDescriptions))
			$description = $model->orderDescriptions[0];
		$orderproduct = array();
		foreach($model->orderProducts as $product){
			$orderproduct = $product;
			$orderproduct->order_options = $product->orderOptions;
			$this->_orderproduct[] = $orderproduct;
		}
		/*Yii::log( "OrderViewActionvaliid: ".CVarDumper::dumpAsString($model->payment_firstname ),
						CLogger::LEVEL_ERROR, "order.actions.view" 
					);*/
		$this->render('view', array(
			'model' => $model, 'description' => $description, 'orderproduct' => $this->_orderproduct
		));
		Yii::app()->end();
	}
	public function getOrderStatus($order_status_id){
		$status = OrderStatus::model()->findByPk($order_status_id);
		if(!empty($status))
			return $status->getName();
		return null;
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

	public function actionCreate() {		
		$model = new Order;
		$description = new OrderDescription;

		//$order_option_value = new OrderOptionValue;
		
		$this->performAjaxValidation(array($model,$description), 'order-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','Order was successfully created');
			$err = Yii::t('info','Could not create Order');
			$description->order_id = 0;
			$description->locale_code = Yii::app()->getLanguage();
			
			
			if ($this->validateOrder($model, $description)){
				if ($model->save()) {
					$description->order_id = $model->id;
					$description->save();
					$this->orderSave($model);
					
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $model, 'description' => $description, 'customer'=> $this->_ordercustomer, 'orderProduct' => $this->_orderproduct), false, true);					
						Yii::app()->end();
					}else
						$this->redirect(array('view', 'id' => $model->id));
				}else{
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
				}				
			}
			
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form_order', array('model' => $model, 'description' => $description, 'customer'=> $this->_ordercustomer, 'orderproduct' => $this->_orderproduct), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model, 'description' => $description, 'customer'=> $this->_ordercustomer, 'orderproduct' => $this->_orderproduct));
	}
	
	public function actionHistory() {
		if(!empty(Yii::app()->user->id)){
			$orders = Order::model()->findAll('customer_id=:cus_id', array(':cus_id'=>Yii::app()->user->id));
			$this->render('history',array('orders'=>$orders));
		}
		else
			$this->render('history');
	}
	
	public function loadProductOption($id){
		$data = ProductOption::model()->findAll('product_id=:product_id', array(':product_id'=>$id));
		foreach($data as $productoption){
			$value = ProductOptionValue::model()->findAll('product_option_id=:product_option_id', array(':product_option_id'=>$productoption->id));
			$_productoption = array($productoption, $value);
		}
		return $_productoption;
	}
	
	public function getProductOption($id){
		$options = $this->loadProductOption($id);
		$this->renderPartial('_product_option', array('options' => $options), false, true);
	}
	
	public function addProduct(){
		$sess = Yii::app()->user->getState('order_product');
		if(isset($_POST['OrderProduct']['id'])) {
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
		
			if($this->addProductOption($product->id)){
				$orderproduct->order_options = $this->_orderoption;
				$orderoptions = $this->_orderoption;
				if(!empty($sess)){
					$addnew = false;
					foreach($sess as $i=>$cart){
						$match = $match2 = false;
						$diff = $orderproduct->compare($cart);
						if($diff){
							$sess[$i]->quantity += $_POST['OrderProduct']['quantity'];
							$addnew = true;
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
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,Yii::t('info','Please fill out all required fields for product options'));
				$this->renderPartial('_form_order', array('orderproduct' => $sess), false, true);
				Yii::app()->end();
			}
			else{				
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,Yii::t('info','Please fill out all required fields for product options'));
			}
			
		}
		if(empty($sess)){ $sess = array();}
		$norderopt = array();
		if(isset($_POST['OrderProduct']['id']))
			$norderopt = $this->loadProductOption(isset($_POST['OrderProduct']['id']));
		$this->renderPartial('_form_order', array('orderproduct' => $sess, 'orderoption' => $norderopt), false, true);
	}
	
	public function addProductOption($id){
		$valid = true;
		$validReal = true;
		$orderoptions = $optionids = array();
		if(isset($_POST['OrderOption'])) {			
			foreach($_POST['OrderOption'] as $option){
				if(is_array($option['product_option_value_id']))
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
		$productC = new ProductController;
		$chkoptions = $productC->loadProductOption($id);
		if(!empty($chkoptions))
			foreach($chkoptions as $realoption){
				if(!in_array($realoption->product_option_id, $optionids)){
					$validReal = false;
					break;
				}
			}
		$this->_orderoption = $orderoptions;
		return $valid && $validReal;
	}
	
	function validateProductOption($option){
		$valid = true;
		$option->order_id = 0;
		if($option->type == 'select' || $option->type == 'radio' || $option->type =='checkbox'){
			if(empty($option->product_option_value_id) || !is_integer($option->product_option_value_id))
				$valid =  false;
		}else{
			$option->product_option_value_id = 0;
			if(empty($option->value))
				$valid =  false;
		}
		$valid = $valid && $option->validate();
	}
	
	protected function orderSave($model){
		$id = $model->id;

		/*if(!empty($this->_orderoption))
			foreach($this->_orderoption as $orderoption){
				$optionModel = $orderoption[0];
				$valueModel = $orderoption[1];
				$optionModel->order_id = $id;					
				$optionModel->save();
				foreach($valueModel as $value){
					$value->order_option_id = $optionModel->id;
					$value->order_id = $id;
					$value->option_id = $optionModel->option_id;
					$value->save();
				}
			}
		if(!empty($this->_orderattribute))
			foreach($this->_orderattribute as $orderattribute){
				$orderattribute->order_id = $id;
				$orderattribute->save();
			}*/
	
	}
	
	public function validateOrder(&$model, &$description)
	{/*
		$error = '';
		$ordercustomer = $this->validateCustomer();
		$orderproduct = $this->validateProduct();
		$orderoption = $this->validateProductOption();
		
		if(!$ordercustomer)
			$error .= Yii::t('info','Please fill in all values for Order Customer').'<br/>';
		if(!$orderproduct)
			$error .= Yii::t('info','Please fill in all values for Order Products').'<br/>';
		if(!$orderoption)
			$error .= Yii::t('info','Please fill in all values for Order Options').'<br/>';

		if(!empty($error))	
			Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$error);
			
		return $model->validate() && $description->validate() && $ordercustomer && $orderproduct && $orderoption;*/
	}
	
	public function validateCustomer(){
		if(isset($_POST['Customer']))
		{
			$valid=true;
			$this->_productattribute = array();
				/*Yii::log( "ProductCreateAction: ".CVarDumper::dumpAsString( $_POST['ProductOption'] ),
						CLogger::LEVEL_ERROR, "product.actions.create" 
					);*/
			$customer = new Customer;
			$customer->attributes = $_POST['Customer'];
			$valid=$customer->validate() && $valid;
			$this->_ordercustomer = $customer;


			if(!$valid){
				return false;
			}
			
		}
		return true;
	}
}
?>

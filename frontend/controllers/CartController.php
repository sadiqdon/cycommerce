<?php
/**
 * CartController.php
 *
 */
class CartController extends Controller {
	
	public $layout='//layouts/column3';
	
	public $categoryID = 0;	
	
	public $_orderoption = array();
	
	public $defaultAction = 'cart';
	
	private $modelName = 'Cart';
	
	public function accessRules() {
		return array(
			// not logged in users should be able to login and view captcha images as well as errors
			array('allow', 'actions' => array('index', 'default', 'captcha', 'login', 'error', 'KK')),
			// logged in users can do whatever they want to
			array('allow', 'users' => array('@')),
			// not logged in users can't do anything except above
			array('deny'),
		);
	}

	/**
	 * Declares class-based actions.
	 * @return array
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	/* open on startup */
	public function actionIndex() {
		$this->render('index');
	}
	
	/*public function actionAjaxAddToCart($id) {
		
		$cart = $this->getCart();
		if(!empty($cart['items'][$i])){
			$product = Product::model()->findByPk($cart['items'][$i]['product_id']);
			if(!empty($product)){
			$cart['items'][$i]['quantity'] += $order['quantity'];
			$cart['items'][$i]['total'] += $order['total'];
			Yii::app()->user->setState('user_cart', $cart);
		}
		
	}*/
	
	public function getOnlinePaymentOptions(){
		$paymentHelper = new PaymentGatewayHelper();
		$paymentHelper->fetchPaymentOptionsForm();  // this echo the online payment options and their forms for the cart/payment page
	}
	
	private function getOnlinePaymentValues($sql){
		$command = Yii::app()->db->createCommand();
		$resultSet = $command->setText($sql)->query();
		$rows=$resultSet->readAll();
		return $rows;
	}
	
	public function prepareOnlinePayment($order,$paymentClass,$ref,$total,$orderID = 0){
			$settings = array(); // This will contain a settings
			$settingFields = array(); // This contains the fields for the payment method 
			$sql="SELECT * FROM settings where category = '" . $paymentClass->getPaymentName() .  "' ORDER BY 'key' ";
			$setting = $this->getOnlinePaymentValues($sql); // This get the values from the settings table
	
			foreach($setting as $data){
				static $counter = 1;
				$value = $data['value'];
				do{
					$pos = strpos($data['value'], ':');
					$value = substr($value, $pos + 5);  
					$counter++;
				}while($counter <= 2);
				
				$c = array("\"", "'",";");
				$value = str_replace($c, "", $value);
				  
				$settings[$data['key']] = $value;
			}

			$settings['ref'] = $ref;
			$settings['total'] = $total;
			$settings['orderID'] = $orderID;
						
			$paymentClass->setOrderObj($order);
			$paymentClass->setUserSettings($settings);
			$paymentClass->preSubmit();
		echo '<form action=" ' . $paymentClass->getGatewayUrl() . '" method="' . $paymentClass->formMethod . '">';
			$paymentClass->prepareSubmit();
			$paymentClass->postSubmit();
		echo '
					</div>
			</div>
			<div class="section_foot_general">
				<a href=" ' . Yii::app()->createUrl('category') . '" class="f_left btn btn-warning">Continue Shopping</a>
				';
				if($paymentClass->showingPaymentButton == true){
					echo '<button class="pull-right btn btn-success btn-lg" type="submit">Pay With Card</button>';
				}
				echo '<div class="clearfix"></div>
			</div><br/>
			</form>
		';	
	}

	public function actionAddToCart($id) {
			//Yii::app()->user->setState('user_cart', NULL);
			if(isset($id) && isset($_REQUEST['quantity']) && is_numeric($id) && is_numeric($_REQUEST['quantity']) && ($id*$_REQUEST['quantity'] > 0 )){
				
				$cart = $this->getCart();
				$product = Product::model()->findByPk($id);
				if(!empty($product)){
					$match = false;
					
					$ops = $product->productOptions;
					$price = $product->price;
					
					$order = array('product_id'=>$id,'name'=>$product->getName(),'model'=>$product->model,'quantity'=>intval($_REQUEST['quantity']),'stock'=>$product->quantity,'price'=>$price,'total'=>intval($_REQUEST['quantity'])*$price);
					if(!empty($ops)){
						if(isset($_REQUEST['quick']))
							$this->redirect(array_merge(array('/product/view'),UtilityHelper::productLink($id)));
							//$this->redirect('product/view', array('category'=>$_GET['category'],'subcategory'=>$_GET['subcategory'],'product'=>$product->getLink()));
						$stock = 0;
						if($this->addProductOption($product->id, intval($_REQUEST['quantity']), $price, $stock)){
							
						}else{							
							Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,'Please fill out all required options');

							$this->redirect(Yii::app()->request->urlReferrer);
						}
						$order['price'] = $price;
						$order['stock'] = $stock;
						$order['total'] = $order['quantity']*$order['price'];
						$order['option'] = $this->_orderoption;
					}
					if($order['stock'] >= $order['quantity']){
						if(empty($cart))
							$cart['items'] = array($order);
						else{
							foreach($cart['items'] as $i=>$porder){
								if(!empty($porder['option']) && !empty($order['option'])){
									if($this->orderCompare($order['option'],$porder['option'])){
										if(isset($_REQUEST['cart'])){
											$cart['items'][$i]['quantity'] = $order['quantity'];
											$cart['items'][$i]['total'] = $order['total'];
										}
										else{
											$cart['items'][$i]['quantity'] += $order['quantity'];
											$cart['items'][$i]['total'] += $order['total'];
										}								
										$match = true;
										break;
									}							
								}
								elseif($porder['product_id'] == $order['product_id']){
									if(isset($_REQUEST['cart'])){
										$cart['items'][$i]['quantity'] = $order['quantity'];
										$cart['items'][$i]['total'] = $order['total'];
									}
									else{
										$cart['items'][$i]['quantity'] += $order['quantity'];
										$cart['items'][$i]['total'] += $order['total'];
									}
									$match = true;
									break;
								}
							}
							if(!$match)
								$cart['items'][] = $order;
						}
					}
					else{
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,'The quantity you chose exceeds the quantity in stock.');
					}
					/*Yii::log( "OrderCreateActionvaliid: ".CVarDumper::dumpAsString( $cart),
						CLogger::LEVEL_ERROR, "order.actions.create" 
					);*/
					Yii::app()->user->setState('user_cart', $cart);
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_cart', array('cart' => $cart['items']), false, true);
						Yii::app()->end();
					}
					$this->render('cart', array('cart' => $cart['items']));
				}
				
			}
	}
	
	public function actionRemoveFromCart($id) {
		$cart = $this->getCart();
		if(isset($cart['items'][$id])){
			unset($cart['items'][$id]);
			Yii::app()->user->setState('user_cart', $cart);
		}
		$this->render('cart', array('cart' => $cart['items']));
	}
	
	public function actionCart() {
		$cart = $this->getCart();
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_cart', array('cart' => $cart['items']), false, true);
			Yii::app()->end();
		}
		$this->render('cart', array('cart' => $cart['items']));
	}
	
	
	public function getCartTotal() {
		$cart = $this->getCart();
		$total = 0;
		if(!empty($cart['items'])){
			foreach($cart['items'] as $porder){
				$total += $porder['total'];
			}
		}
		return $total;
	}
	
	public function getCartSubTotal(){
		return $this->getCartTotal() - $this->getDelivery() - $this->getVAT();
	}
	
	public function getDelivery(){
		return 0;
	}
	
	public function getVAT(){
		return $this->getCartTotal() * 0.05;
	}
	
	public function actionCheckout() {
		$cart = $this->getCart();
		if(!empty($cart)){
			$user = Yii::app()->user;
			$address = array();
			//$address = Address::model()->findAll('id=:id', array(':id'=>41));
			
			if(!$user->isGuest)
				$address = Address::model()->findAll('user_id=:id AND country_id=:c_id', array(':id'=>$user->id,':c_id'=>156));

			if((!empty($_GET['golp']) && is_numeric($_GET['golp']))){
				$id=0;
				$id = $_GET['golp'];
				$naddress = Address::model()->findAll('user_id=:user_id AND id=:id', array(':user_id'=>$user->id,':id'=>$id));
				$model = CheckoutAddress::model()->findByPk($id);
				if(empty($naddress)){
					Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,'The address you selected is invalid');
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_shipping', array('model'=>$model,'address' => $address), false, true);
						Yii::app()->end();
					}
					$this->render('_shipping', array('model'=>$model,'address' => $address));
					Yii::app()->end();
				}
				Yii::app()->user->setState('user_cart', $cart);				
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					$this->renderPartial('_payment', array('app' => $model), false, true);
					Yii::app()->end();
				}else
					$this->redirect( array('payment','id' => $model->id));
				
			}else{
				$model = new CheckoutAddress;
			}
			if(isset($_POST['Address']))
				$_POST['CheckoutAddress'] = $_POST['Address'];
			if(isset($_POST['CheckoutAddress'])){
				$model->attributes = $_POST['CheckoutAddress'];
				$model->user_id = 0;
				if(!empty($user->id))
					$model->user_id = $user->id;
				$model->country_id = 156;
				if($model->save()){
					/*
					$cart['shipping']['email'] = $model->email;
					$cart['shipping']['telephone'] = $model->telephone;
					$cart['shipping']['firstname'] = $model->firstname;
					$cart['shipping']['lastname'] = $model->lastname;
					$cart['shipping']['address_1'] = $model->address_1;
					$cart['shipping']['address_2'] = $model->address_2;
					$cart['shipping']['city'] = $model->city;
					$cart['shipping']['postal_code'] = $model->postal_code;
					$cart['shipping']['country_id'] = 156;
					$cart['shipping']['zone_id'] = $model->zone_id;
					*/
					Yii::app()->user->setState('user_cart', $cart);
					
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_payment', array('app' => $model), false, true);
						Yii::app()->end();
					}else
						$this->redirect( array('payment','id' => $model->id));
					
				}
			}
			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->renderPartial('_shipping', array('model'=>$model,'address' => $address), false, true);
				Yii::app()->end();
			}
			$this->render('_shipping', array('model'=>$model,'address' => $address));
			Yii::app()->end();
		}
		$this->redirect(array('cart'));
	}
	
	public function actionPayment($id) {
		$cart = $this->getCart();
		$add = CheckoutAddress::model()->findByPk($id);
		$link; 
		$onlinePaymentMethodName ; 
		$extrapObj = array(); 
		$orderArray = array();  
		$classArray = array();
		
		if(!empty($add) && !empty($cart['items'])){
			if(isset($_POST['Payment']['payment_method'])){
				$pay_method = $_POST['Payment']['payment_method'];
				$cart['payment'] = ($pay_method == 4) ? 2 : $pay_method;
				$paymentType =  is_numeric($pay_method) ? 'others' : 'online'; 
				
				$order = new Order;			
				
				$order->order_status_id = 1;
				$order->total = $this->getCartTotal();
				$order->ip = Yii::app()->request->userHostAddress;
				$order->user_agent = Yii::app()->request->userAgent;
				$order->firstname = $add->firstname;
				$order->lastname = $add->lastname;
				$order->email = $add->email;
				$order->telephone = $add->telephone;
				$order->payment_firstname = $add->firstname;
				$order->payment_lastname = $add->lastname;
				$order->payment_company = '';
				$order->payment_tax_id = 0;
				$order->payment_address_1 = $add->address_1;
				$order->payment_address_2 = $add->address_2;
				$order->payment_city = $add->city;
				$order->payment_postcode = $add->postal_code;
				$order->payment_country_id = $add->country_id;
				$order->payment_zone_id = $add->zone_id;
				$order->payment_method = $cart['payment'];
				$order->payment_code = uniqid().rand(1,9);
				$order->shipping_firstname = $add->firstname;
				$order->shipping_lastname = $add->lastname;
				$order->shipping_company = '';
				$order->shipping_address_1 = $add->address_1;
				$order->shipping_address_2 = $add->address_2;
				$order->shipping_city = $add->city;
				$order->shipping_postcode = $add->postal_code;
				$order->shipping_country_id = $add->country_id;
				$order->shipping_zone_id = $add->zone_id;
				$order->shipping_method = 2;
				if($add->zone_id == 2412)
					$order->shipping_method = 1;
				
				$storeid = UtilityHelper::yiiparam('storeID');
				$store = Store::model()->findByPk($storeid);
				$order->store_id = $storeid;
				$order->store_name = $store->name;
				$order->store_url = $store->url;
				
				$order->payment_country = Country::model()->findByPk($order->payment_country_id)->name;
				$order->payment_zone = Zone::model()->findByPk($order->payment_zone_id)->name;
				$order->shipping_country = $order->payment_country;
				$order->shipping_zone = $order->payment_zone;
				
				if($order->save()){
					foreach($cart['items'] as $product){
						$orderproduct = new OrderProduct;
						$orderproduct->order_id = $order->id;
						$orderproduct->product_id = $product['product_id'];
						$orderproduct->name = $product['name'];
						$orderproduct->model = $product['model'];
						$orderproduct->quantity = $product['quantity'];
						$orderproduct->price = $product['price'];
						$orderproduct->total = $product['total'];
						$orderproduct->tax = 0;
						if($orderproduct->save()){
							if(!empty($product['option'])){
								foreach($product['option'] as $orderoption){
									$orderoption->order_id = $order->id;
									$orderoption->order_product_id = $orderproduct->id;
									$orderoption->save();
								}
							}
						}else{
							Yii::log( "CartPaymentOrderProductErrors: ".CVarDumper::dumpAsString( $orderproduct->getErrors()),
									CLogger::LEVEL_ERROR, "cart.actions.payment" 
								);
						}
					}
					//Yii::app()->user->setState('user_cart', NULL);
					$extrap = array();
					
					//
					
					switch($paymentType){
						case 'others':
						// Will need to loop through the ids for non online payment to do this properly
						if($pay_method == 1){
							$link = '_cash';
							$extrap = array('orderID'=>$order->id,'total'=>$order->total);
							UtilityHelper::changeOrderStatus($order->id);
						}else if($pay_method == 3){
							$link = '_bank';
							$extrap = array('orderID'=>$order->id,'total'=>$order->total);
						}
						break;
						case 'online':
							$subClasses = new PaymentGatewayHelper();
							$subClassesArray = $subClasses->getSubClasses();
							foreach($subClassesArray as $class => $payOption){
								$$class = new $class();
								$onlinePaymentMethodName = $$class->getPaymentName();
								if($pay_method == $onlinePaymentMethodName){
									$link = $$class->getViewLink();
									$$class->setOrderObj($order);
									$extrapObj = $$class->getOrderObj(); 
									foreach( $extrapObj as $field => $value){
										$orderArray[$field] = $value;
									}
									$link = $$class->getViewLink();
									$extrap = array('orderID'=>$orderArray['id'],'total'=>$orderArray['total']);
									$$class->regPaymentTransaction($order);
									$classArray['pay_method'] = $pay_method;
								}else{
									continue;
								}
							}
						break;
						default :
							break;
					}
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial($link, array_merge(array('ref'=>$order->payment_code),$extrap,$classArray), false, true);	
						Yii::app()->end();
					}
					$this->render($link, array_merge(array('ref'=>$order->payment_code),$extrap,$classArray));
					Yii::app()->end();
				}else{
				Yii::log( "CartPaymentErrors: ".CVarDumper::dumpAsString( $order->getErrors()),
						CLogger::LEVEL_ERROR, "cart.actions.payment" 
					);
				}
			}
			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->renderPartial('_payment', array('app' => $add), false, true);	
				Yii::app()->end();
			}
			$this->render('payment', array('app' => $add));
			Yii::app()->end();
		}
		$this->redirect(array('cart'));
	}
	
	public function addProductOption($id, $q, &$price, &$stock){
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
						$pvalue = ProductOptionValue::model()->findByPk($value_id);
						if(!empty($pvalue)){
							if($pvalue->quantity < $q){
								Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,'The option you selected is out of stock');
								return false;
							}
							$stock = $pvalue->quantity;
							if($pvalue->subtract)
								$price -= $pvalue->price;
							else
								$price += $pvalue->price;
						}
						$valid = $valid && $this->validateProductOption($orderoption);
						$orderoptions[] = $orderoption;
						$optionids[] = $orderoption->product_option_id;
					}
				else{
					$orderoption = new OrderOption;
					$orderoption->attributes = $option;
					if(isset($option['product_option_value_id'])){
						$pvalue = ProductOptionValue::model()->findByPk($option['product_option_value_id']);
						if(!empty($pvalue)){
							if($pvalue->quantity < $q){
								Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,'The option you selected is out of stock');
								return false;
							}
							$stock = $pvalue->quantity;
							if($pvalue->subtract)
								$price -= $pvalue->price;
							else
								$price += $pvalue->price;
						}
					}
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
		/*Yii::log( "OrderCreateActionaappP: ".CVarDumper::dumpAsString($optionids).'---'.$validReal.' - '.$valid.'---',
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
		Yii::log( "OrderOptionCreateActionvaliid: ".$option->name.' - '.$valid.'---'.CVarDumper::dumpAsString( $option->getErrors()),
						CLogger::LEVEL_ERROR, "order.actions.create" 
					);
		return $valid;
	}
	
	public function orderCompare($optionA, $optionB){
		$match2 = true;
		if(!empty($optionA) && !empty($optionB)){
			foreach($optionA as $cartorderoption){				
				foreach($optionB as $orderoption){
					if($orderoption->product_option_id == $cartorderoption->product_option_id){
						if(!$orderoption->compare($cartorderoption)){
							$match2 = false;							
						}
						break;
					}
				}
				if(!$match2)
					break;
			}
		}else if(!empty($optionA) || !empty($optionB))
			$match2 = false;
		return $match2;
	}
}
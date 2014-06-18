<?php

class SpecialOrderController extends Controller{

	//custom
	public $defaultAction = 'create';
	public $layout='//layouts/column3';
	//end custom

	private $modelName = 'SpecialOrder';

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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SpecialOrder;
		$address = new CheckoutAddress;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SpecialOrder']))
		{
			$model->attributes=$_POST['SpecialOrder'];
			$order['product_name'] = $model->product_name;
			$order['product_quantity'] = $model->product_quantity;
			$order['product_colour'] = $model->product_colour;
			$order['specification'] = $model->specification;
			$order['comment'] = $model->comment;
			Yii::app()->user->setState('special_order', $order);
			if($model->validate())
				$this->render('/cart/_shipping',array('model'=>$address));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
		public function actionCheckout() {
		$cart = Yii::app()->user->getState('special_order');
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
						$this->renderPartial('/cart/_shipping', array('model'=>$model,'address' => $address), false, true);
						Yii::app()->end();
					}
					$this->render('/cart/_shipping', array('model'=>$model,'address' => $address));
					Yii::app()->end();
				}
				//Yii::app()->user->setState('user_cart', $cart);				
				if (Yii::app()->getRequest()->getIsAjaxRequest()){
					$this->renderPartial('_view', array('model' => $order), false, true);
					
				}else
					$this->render( 'view',array('model' => $order));
				Yii::app()->end();
				
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
				
					$order=new SpecialOrder;
					
					
					$order->product_name = $cart['product_name'];
					$order->product_quantity = $cart['product_quantity'];
					$order->product_colour = $cart['product_colour'];
					$order->specification = $cart['specification'];
					$order->comment = $cart['comment'];
					
					$order->email = $model->email;
					$order->telephone = $model->telephone;
					$order->firstname = $model->firstname;
					$order->lastname = $model->lastname;
					$order->address_1 = $model->address_1;
					$order->address_2 = $model->address_2;
					$order->city = $model->city;
					$order->postal_code = $model->postal_code;
					$order->country_id = 156;
					$order->zone_id = $model->zone_id;
					$order->ip = Yii::app()->request->userHostAddress;
					$order->user_agent = Yii::app()->request->userAgent;
					$order->order_status_id = 1;
					$order->payment_code = uniqid().rand(1,9);
					
					$order->save();
					
					//Yii::app()->user->setState('user_cart', $cart);
					
					if (Yii::app()->getRequest()->getIsAjaxRequest()){
						$this->renderPartial('_view', array('model' => $order), false, true);
						
					}else
						$this->render( 'view',array('model' => $order));
					Yii::app()->end();
				}
			}
			if (Yii::app()->getRequest()->getIsAjaxRequest()){
				$this->renderPartial('/cart/_shipping', array('model'=>$model,'address' => $address), false, true);
				Yii::app()->end();
			}
			$this->render('/cart/_shipping', array('model'=>$model,'address' => $address));
			Yii::app()->end();
		}
		$this->redirect(array('specialorder'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SpecialOrder');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SpecialOrder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SpecialOrder']))
			$model->attributes=$_GET['SpecialOrder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SpeacialOrder the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SpecialOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


}

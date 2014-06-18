<?php
/**
 * CategoryController.php
 *
 */
class PaymentController extends Controller {
	
	public $layout='//layouts/column3';
		
	public $defaultAction = 'view2';
	
	
	public function accessRules() {
		return array(
			// not logged in users should be able to login and view captcha images as well as errors
			array('allow', 'actions' => array('index', 'view', 'captcha', 'login', 'error', 'KK')),
			// logged in users can do whatever they want to
			array('allow', 'users' => array('@')),
			// not logged in users can't do anything except above
			array('deny'),
		);
	}
	public function actionView2(){
		//$client->soap_defencoding = 'UTF-8';
		if(isset($_GET["txnref"])){
			
				//$trans_pay_status = $pay->response_code;
				$trans =  array();
				$order = UtilityHelper::callGlobalPay($_GET["txnref"],$trans);
			if(!$order)
				$this->render('view2',array('response'=>"Error occured please try again later", 'error'=>1));
				//empty the user cart
			else{
				Yii::app()->user->setState('user_cart', NULL);
				$this->render('view2',array('response'=>$trans, 'error'=>0, 'order'=>$order));
			}		
			
		}
	
	}
	
	public function actionView() {
		//if(!empty($_GET['txnref']) || !empty($_GET['payRef']) || !empty($_GET['retRef'])){
		//exit($_GET['payment']);
		$json = array();
		$ref = isset($_POST['txnref']) ? $_POST['txnref'] : null;
		$returnPayment = $_GET['payment'];
		$subClasses = new PaymentGatewayHelper();
		$subClassesArray = $subClasses->getSubClasses();
		foreach($subClassesArray as $class => $payOption){
			$$class = new $class();
			$$class->getPaymentName() == $returnPayment;
			
		}
		Yii::app()->user->setState('user_cart', NULL);
		$this->render('view',array('response'=>$json, 'ref'=>$ref));
		//exit($_GET['payment']);
		/*if(!empty($_POST['txnref']) || !empty($_POST['payRef']) || !empty($_POST['retRef'])){
			$json = array();
			$ref = $_POST['txnref'];
			$order = UtilityHelper::callInterswitch($ref,$json);
			$message = "Error call";
			//UtilityHelper::sendToLog($ref);
			
			Yii::app()->user->setState('user_cart', NULL);
			$this->render('view',array('response'=>$json, 'ref'=>$ref));
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.')); 
			*/
		
	}

}
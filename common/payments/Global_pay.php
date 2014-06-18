<?php

class Global_pay extends PaymentGateway {

	const NAME = "Global_pay";
	const DISPLAY_NAME = "Global pay";
	const PAYMENT_IMAGE = "global_pay.png";
	public $formMethod = "POST";
	public $fields = array('gatewayUrl','merchantid','currency','currencyText','site_redirect_url');
		
	public $settingsArray = array(
		'title'=>'Global_Pay Settings',
        'elements'=>array(
				array(
					'type'=>'text',
					'name'=>'gatewayUrl',
					'label'=>'Gateway Url',
					'value'=>'https://www.globalpay.com.ng/Paymentgatewaycapture.aspx',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
                array(
					'type'=>'text',
					'name'=>'merchantid',
					'label'=>'Merchant Id',
					'value'=>'174',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
                array(
					'type'=>'text',
					'name'=>'currency',
					'label'=>'Currency',
					'value'=>'NGN',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
                array(
					'type'=>'text',
					'name'=>'currencyText',
					'label'=>'Currency Text',
					'value'=>'NGN',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
				 array(
					'type'=>'text',
					'name'=>'site_redirect_url',
					'label'=>'Site Redirect Url',
					'value'=>"http://localhost/SITE/cycommerce_demo/frontend/www/payment/view/?payment=Global_pay",
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
		)
	);

		
    public function __construct() {
		parent::__construct();
        $this->setPaymentName(self::NAME);
		$this->setDisplayName(self::DISPLAY_NAME) ;
		$this->setPaymentImage(self::PAYMENT_IMAGE) ;
        $this->setTestMode(FALSE);
		$this->setTermAndConditions("Only works with verve");
		$this->setViewLink('_online');

    }

    public function enableTestMode($gatewayUrl) {
        $this->setTestMode(TRUE);
        $this->setGatewayUrl($gatewayUrl);
    }

    protected function validateIpn() {
        
    }

    public function preSubmit() {
        $this->setGatewayUrl($this->settings['gatewayUrl']);
		$this->addField("merch_txnref", $this->settings['ref']);
		$this->addField("merchantid", $this->settings['merchantid']);
		$this->addField("names", $this->getOrderObj()->firstname.' '.$this->getOrderObj()->lastname);
		$this->addField("email_address", $this->getOrderObj()->email);
		$this->addField("amount", $this->settings['total']);
		$this->addField("site_redirect_url", $this->settings['site_redirect_url']);
		$this->addField("phone_number", $this->getOrderObj()->telephone);
		$this->addField("currency", $this->settings['currencyText']);
    }

    public function postSubmit() {
	
    }
	
		
	public function checkResponse($response){
		if(isset($response['pmt_status']) && $response['pmt_status'] == 'successful'){
		$this->callGlobalPay();
			$this->onSuccess($response,$ref);
		}else{
			$this->onfailure($response);
		}
	}
	
    public function prepareSubmit() {
		 $this->submitPayment();
    }

    protected function onSuccess($response){
        return "<h1>Successfull {$this->getPaymentName()} Transaction</h1>
                <p>Thank you!</p>
                <p>We have received your order and have started processing it. We will let you know as soon as it is being confirmed by {$this->getPaymentName()}.</p>
                ";
    }

    protected function onfailure($response){
			if(isset($response['pmt_status'])){
        return "
             <h1>Unsuccessfull {$this->getPaymentName()} Transaction </h1>
             <p>We're sorry!</p>
             <p>Your payment has not been processed due to error. Please try again in a couple of minutes.</p><br/>
			 			<h5>Name : {$response['merch_name']}</h5>
			<h5>Phone number : {$response['merch_phoneno']}</h5>
			<h5>Transaction Amount : {$response['merch_amt']}</h5>
			<h5>Debited Amount : {$response['amount']}</h5>
			<h5>Transaction Date : {$response['txn_date']}</h5>
			<h5>Payment Method : {$response['pmt_method']}</h5>
			<h5>Payment Status : {$response['pmt_status']}</h5>
			<h5>Transaction Reference Number : {$response['pmt_txnref']}</h5>
			<h5>Currency : {$response['currency']}</h5>
			<h5>Transaction Status : {$response['trans_status']}</h5>
        ";
		}
    }
	
		
	public function regPaymentTransaction($order){
		$pay = new PaymentTransaction;
		$pay->type = self::NAME;
		$pay->transaction_date = date('Y-m-d H:i:s');
		$pay->reference_number = $order['payment_code'];
		$pay->response_description = '';
		$pay->response_code = 'pending';
		$pay->transaction_amount = $order['total'];
		//$pay->transaction_currency = UtilityHelper::yiiparam('currencyText'); NEED TO WORK AROUND THIS
		$pay->transaction_currency = 'NGN';
		$pay->customer_name = $order['firstname'] . ' '. $order['lastname'] ;
		$pay->order_id = $order['id'];
		$pay->save();	
	}
	
	protected function completePaymentTransaction($param){
	
	}
	
	
		public static function callGlobalPay($txnref, &$trans){
		//$txnref = $_GET["txnref"];
		$client=new SoapClient('https://www.globalpay.com.ng/globalpaywebservice/service.asmx?wsdl',array('exceptions' => 0,'encoding'=>'UTF-8'));
		
		$soapaction = "https://www.eazypaynigeria.com/globalpay/getTransactions";
		$namespace = "https://www.eazypaynigeria.com/globalpay/";
		
		$order = Order::model()->findByAttributes(array('payment_code'=>$txnref));
		$pay = PaymentTransaction::model()->findByAttributes(array('reference_number'=>$txnref));
	
		$merch_txnref=$txnref; 
		$channel=""; 
		//change the merchantid to the one sent to you
		$merchantID="174"; 
		$start_date=""; 
		$end_date=""; 
		//change the uid and pwd to the one sent to you
		$uid="yl_ws_user"; 
		$pwd="yl_ws_password"; 
		$payment_status="" ; 
	/*
		$err = $client->getError();
	
		if ($err) {
			$this->render('view2',array('response'=>$err, 'error'=>1));
		}*/
		// Doc/lit parameters get wrapped
		$MethodToCall= "getTransactions";
		//$MethodToCall= "Checkcenter";
		
		$param = array(
			'merch_txnref' => $merch_txnref, 
			'channel' => $channel,
			'merchantID' => $merchantID,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'uid' => $uid,
			'pwd' => $pwd,
			'payment_status' => $payment_status
		);

		$result = $client->__soapCall(
			$MethodToCall, 
			array('parameters' => $param), 
			array('uri'=>$namespace, 
			'soapaction'=>$soapaction)
		);

		// Check for a fault
		if (is_soap_fault($result)) {
			//"SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})";
			return false;
		} 
		else {			
			//This gives getTransactionsResult
			$WebResult=$MethodToCall."Result";
			// Pass the result into XML
			if(is_object($result))
				$xresult = $result->$WebResult;
			else
				$xresult = $result[$WebResult];
			$xml = simplexml_load_string($xresult);
			
			
			//self::sendToLog($xml);
			//$trans = array();
			$trans['amount'] = $xml->record->amount;
			$trans['txn_date'] = $xml->record->payment_date;
			$trans['pmt_method'] = $xml->record->channel;
			$trans['pmt_status'] = $xml->record->payment_status;
			$trans['pmt_txnref'] = $xml->record->txnref;
			$trans['currency'] = $xml->record->field_values->field_values->field[2]->currency;
		   // $pnr = 'PNR';
			$trans['trans_status'] = $xml->record->payment_status_description;
			
			$trans['merch_name'] = $pay->customer_name;
			$trans['merch_phoneno']  = $order->telephone;
			$trans['merch_amt'] = $pay->transaction_amount;
		
			
			//$pay = new PaymentTransaction;
			$pay->transaction_date = $trans['txn_date'];
			//$pay->reference_number = ;
			$pay->payment_reference = $trans['pmt_txnref'];
			if($trans['amount'] != $trans['merch_amt']){
				$trans['pmt_status'] .= " ( Amount does not match and no service will be rendered)";
				$pay->response_code = $trans['pmt_status'];
			}
			else
				$pay->response_code = $trans['pmt_status'];
			$pay->response_description = $trans['trans_status'];
			$pay->approved_amount = $trans['amount'];
			//$pay->transaction_amount = $trans['merch_amt'];
			$pay->transaction_currency = $trans['currency'];
			//$pay->customer_name = $trans['merch_name'];
			$pay->save();
			if(empty($order->check)){
				$message = "Dear {$order->firstname} {$order->lastname},<br/><br/>You have just attempted making payment for order #{$order->id} on {$order->store_url}. Find the details below.<br/><br/>Name : {$order->firstname} {$order->lastname} <br/><br/>Phone number : {$order->telephone} <br/><br/>Amount : ".UtilityHelper::formatPrice($trans['amount'])." <br/><br/>Transaction Date : {$trans['txn_date']} <br/><br/>Payment Method : {$trans['pmt_method']} <br/><br/>Payment Status : {$pay->response_code} <br/><br/>Transaction Reference Number : {$trans['pmt_txnref']} <br/><br/>Currency : {$trans['currency']} <br/><br/>Transaction Status : {$trans['trans_status']} <br/><br/>";
				if($trans['pmt_status'] == 'successful' && $trans['amount'] == $trans['merch_amt']){
					UtilityHelper::sendMail(UtilityHelper::yiiparam('salesEmail'),$order->email, 'Successful Payment Notification',$message);
					//UtilityHelper::changeOrderStatus($order->id);
					$order->order_status_id = 2;
					$order->check = 1;
					$order->save();
					UtilityHelper::subtractOrder($order->id);
				}
				else if($trans['pmt_status'] == 'pending'){
				}
				else{
					UtilityHelper::sendMail(UtilityHelper::yiiparam('salesEmail'),$order->email, 'Failed Payment Notification',$message);
					//UtilityHelper::changeOrderStatus($order->id,10);
					$order->order_status_id = 10;
					$order->check = 1;
					$order->save();
				}
				
			}
			return $order;
		}
		return false;
	}
	
	

}

?>
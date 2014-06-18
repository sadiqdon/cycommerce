<?php

class Interswitch extends PaymentGateway {

    const NAME = "Interswitch";
	const DISPLAY_NAME = "Interswitch";
	const PAYMENT_IMAGE = "interswitch.gif";
	public $formMethod = "POST";
	public $fields = array('interswitchProductID','interswitchItemID','site_name','site_redirect_url','currency',
	'MAC_key','interswitchURL');

	public $settingsArray = array(
		'title'=>'Interswitch Settings',
        'elements'=>array(
				array(
					'type'=>'text',
					'name'=>'interswitchProductID',
					'label'=>'interswitch Product ID',
					'value'=>'4651',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
                array(
					'type'=>'text',
					'name'=>'interswitchItemID',
					'label'=>'interswitch Item ID',
					'value'=>'101',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
                array(
					'type'=>'text',
					'name'=>'site_name',
					'label'=>'Site Name',
					'value'=>'http://www.cycommerce.com',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
				 array(
					'type'=>'text',
					'name'=>'site_redirect_url',
					'label'=>'Site Redirect Url',
					'value'=>"http://localhost/SITE/cycommerce_demo/frontend/www/payment/view?payment=Interswitch",
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
				array(
					'type'=>'text',
					'name'=>'currency',
					'label'=>'Currency',
					'value'=>"566",
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
				array(
					'type'=>'text',
					'name'=>'MAC_key',
					'label'=>'MAC Key',
					'value'=>'3E1C2A5B95CE28589222F974264D77897253547F451C9374CD809F036649B53BECB192CCCFF3C8205DCB458A0032D67B0443',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
				array(
					'type'=>'text',
					'name'=>'interswitchURL',
					'label'=>'Interswitch URL',
					'value'=>'https://webpay.interswitchng.com/paydirect/pay' ,
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
		)
	);
	
	
    public function __construct() {
        parent::__construct();
		$this->requried_fields = array('interswitchProductID','interswitchItemID','site_redirect_url','MAC_key');
        $this->setPaymentName(self::NAME);
		$this->setDisplayName(self::DISPLAY_NAME) ;
		$this->setPaymentImage(self::PAYMENT_IMAGE) ;
        $this->setTestMode(FALSE);
		$this->setTermAndConditions("Only works with visa");
		$this->setViewLink('_online');
    }

    public function enableTestMode($gatewayUrl) {
        $this->setTestMode(TRUE);
        $this->setGatewayUrl($gatewayUrl);
    }

    protected function validateIpn() {
        
    }

    public function preSubmit() {
		//exit(print_r($this->settings));
		$hash = hash('sha512', $this->settings['ref'].$this->settings['interswitchProductID'].$this->settings['interswitchItemID'].($this->settings['total']*100).$this->settings['site_redirect_url'].$this->settings['MAC_key']);
		//$this->setGatewayUrl($hash);
		$this->addField("txn_ref", $this->settings['ref']);
		$this->addField("product_id", $this->settings['interswitchProductID']);
		$this->addField("pay_item_id", $this->settings['interswitchItemID']);			
		$this->addField("cust_id", $this->settings['orderID']);
		//$this->addField("cust_id_desc", $this->getOrderObj()->firstname.' '.$this->getOrderObj()->lastname);
		$this->addField("cust_name", $this->getOrderObj()->firstname.' '.$this->getOrderObj()->lastname);
		$this->addField("amount", $this->settings['total']*100);
		$this->addField("site_name", $this->settings['site_name']);
		$this->addField("site_redirect_url", $this->settings['site_redirect_url']);
		$this->addField("hash", $hash);
		$this->addField("currency", $this->settings['currency']);		
		$this->setGatewayUrl($this->settings['interswitchURL']);		
    }

    public function postSubmit() {
        //$fields = $this->getFields();
        //echo("<script type='text/javascript' src='{$fields['src']}'></script>");
    }

    public function prepareSubmit() {
        $this->submitPayment();
    }
	
	public function checkResponse($response){
	$ref = isset($response['txnref']) ? $response['txnref'] : NULL;
	$json = array();
	//$this->callInterswitch($ref, $json);
		if(isset($json['ResponseCode']) && $json['ResponseCode'] == '00'){
			$this->onSuccess($json);
		}else{
			$this->onfailure($response);
		}
	}
	
    protected function onSuccess($response) {
        if(isset($response['ResponseCode'])){
			return "
				<div class='checkout_head_general'>
					<span class='checkout_title'>Thank You!</span>
					<div class='clearfix'></div>
				</div>
			<div class='section_body_general'>
				<div class='checkout_wrapper'>
						<h2>Payment Processed successfully</h2>
					<h5>Transaction Reference '#': {$ref} </h5>
					<h5>Payment Status Description: {$response['ResponseDescription']}</h5>
					<h5>Amount: ". UtilityHelper::formatPrice($response['Amount']/100) . " </h5>
					<h5>Payment Reference '#': {$response['PaymentReference']} </h5>
				</div>
			</div> ";
		}
    }

    protected function onfailure($response) {
	        if(isset($response['ResponseCode'])){
        return "
			<div class='checkout_head_general'>
	<span class='checkout_title'>Payment Status</span>
	<div class='clearfix'></div>
</div>
<div class='section_body_general'>
	<div class='checkout_wrapper'><h2>Payment Failed</h2>
		<h5>Transaction Reference '#': {$ref}</h5>
		<h5>Payment Status Description: {$response['ResponseDescription']}</h5>
		<h5>Amount: " . UtilityHelper::formatPrice($response['Amount']/100) ."</h5>
		<h5>Payment Reference '#': {$response['PaymentReference']}</h5>
	</div>
</div>
		";
		}
    }
	
		
	public function regPaymentTransaction($param){
		
	}
	
	public static function callInterswitch($ref, &$json) {
		//$ref = $_POST['txnref'];
		$order = Order::model()->findByAttributes(array('payment_code'=>$ref));
		$pay = PaymentTransaction::model()->findByAttributes(array('reference_number'=>$ref));
		$url = UtilityHelper::yiiparam('interswitchGet').'?productid='.UtilityHelper::yiiparam('interswitchProductID').'&transactionreference='.$ref.'&amount='.($order->total*100);
		//self::sendToLog($url);
		try{
			$cURL = curl_init();

			curl_setopt($cURL, CURLOPT_URL, $url);
			curl_setopt($cURL, CURLOPT_HTTPGET, true);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Accept: application/json',
				'Hash: '.hash('sha512', UtilityHelper::yiiparam('interswitchProductID').$ref.UtilityHelper::yiiparam('MAC_key'))
			));
			$result = curl_exec($cURL);
			if (FALSE === $result)
			throw new Exception(curl_error($cURL), curl_errno($cURL));
			//self::sendToLog($result,"Json things!!!");
			curl_close($cURL);
		} catch(Exception $e) {
			self::sendToLog(sprintf(
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage()), "CURL Interswitch Error");
			return false;
		}
		$json = json_decode($result, true);
		
		//$pay->transaction_date = $json['TransactionDate'];
		//$pay->reference_number = $ref;
		$pay->payment_reference = $json['PaymentReference'];
		$pay->response_description = $json['ResponseDescription'];
		$pay->response_code = $json['ResponseCode'];
		$pay->approved_amount = $json['Amount']/100;
		//$pay->customer_name = ;
		$pay->save();
		$json['CustomerName'] = $pay->customer_name;
		
		$total = UtilityHelper::formatPrice($order->total);
		$siteurl = UtilityHelper::yiiparam('siteUrl');
		if(empty($order->check)){
			$messg = "Dear {$order->firstname} {$order->lastname},<br/><br/>You have just attempted making payment for order #{$order->id} on {$order->store_url}. Find the details below.<br/><br/>Amount: $total<br/><br/>Response Description: {$json['ResponseDescription']}<br/><br/>Response Code: {$json['ResponseCode']}<br/><br/>Transaction Ref No: {$ref}<br/><br/>Payment Reference: {$json['PaymentReference']}<br/><br/>Transaction Date: {$json['TransactionDate']}<br/>";
			if($json['ResponseCode'] == '09'){}
			else if($json['ResponseCode'] == '00'){
				UtilityHelper::sendMail(UtilityHelper::yiiparam('salesEmail'), $order->email, 'Successful Payment Notification',$messg);
				//UtilityHelper::changeOrderStatus($order->id);
				$order->order_status_id = 2;
				$order->check = 1;
				$order->save();
				UtilityHelper::subtractOrder($order->id);
			}
			else{
				UtilityHelper::sendMail(UtilityHelper::yiiparam('salesEmail'), $order->email, 'Failed Payment Notification',$messg);
				//UtilityHelper::changeOrderStatus($order->id,10);
				$order->order_status_id = 10;
				$order->check = 1;
				$order->save();
			}
			
		}
		//return $order;
	}
	
	protected function completePaymentTransaction($param){
	
	}

	
	

}

?>
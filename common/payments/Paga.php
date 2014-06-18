<?php

class Paga extends PaymentGateway {

    const NAME = "Paga";
    const DISPLAY_NAME = "Paga";
    const PAYMENT_IMAGE = "paga.png";
    public $formMethod = "POST";
	public $fields = array('description','merchantKey','currency','src','return_url');

	
	public $settingsArray = array(
		'title'=>'Paga Settings',
        'elements'=>array(
				array(
					'type'=>'text',
					'name'=>'description',
					'label'=>'Description',
					'value'=>'',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
                array(
					'type'=>'text',
					'name'=>'merchantKey',
					'label'=>'Merchant Key',
					'value'=>'',
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
					'name'=>'src',
					'label'=>'SRC',
					'value'=>'',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                ),
				 array(
					'type'=>'text',
					'name'=>'return_url',
					'label'=>'return_url',
					'value'=>'',
					'items'=>array(),
					'htmlOptions'=>array(),                   
                )
		)
	);

    public function __construct() {
        parent::__construct();
		$this->showPaymentButton(false);
        $this->setPaymentName(self::NAME);
        $this->setDisplayName(self::DISPLAY_NAME);
        $this->setPaymentImage(self::PAYMENT_IMAGE);
        $this->setTestMode(FALSE);
        $this->setTermAndConditions("Only works with visa , mastercard ");
        $this->setViewLink('_online');
    }

    public function enableTestMode($gatewayUrl) {
        $this->setTestMode(TRUE);
        $this->setGatewayUrl($gatewayUrl);
    }

    protected function validateIpn() {
        
    }

    public function preSubmit() {
        $this->addField("return_url", $this->settings['return_url']);
        $this->addField("description", $this->settings['description']);
        $this->addField("currency", $this->settings['currency']);
        $this->addField("subtotal", $this->settings['total']);
        $this->addField("src", $this->settings['src']);
        $this->addField("invoice", $this->settings['ref']);
        $this->setGatewayUrl($this->settings['src']);
    }

    public function postSubmit() {
        echo("<script type='text/javascript' src=' " . $this->settings['src'] . "'></script>");
    }

    public function checkResponse($response) {
        if (isset($response['status']) && $response['status'] == 'SUCCESS') {
            echo $this->onSuccess($response);
        } elseif (isset($response['status'])) {
            echo $this->onfailure($response);
        }
    }

    public function prepareSubmit() {
        $this->submitPayment();
    }

    protected function onSuccess($response) {
        $this->completePaymentTransaction($response);
        return "<h1>Successfull {$this->getPaymentName()} Transaction</h1>
                <p>Thank you!</p>
                <p>We have received your order and have started processing it. We will let you know as soon as it is being confirmed by " . $this->getPaymentName() . "</p>
                
				<div class='alert-info' style='padding: 10px;'>
                <h2>Transaction Status : " . $response['status'] . " </h2><br/>
                <p>Reference Number :  " . $response['reference'] . " </p>
				<p>Transaction Id :  " . $response['transaction_id'] . " </p>
				<p>Invoice :  " . $response['invoice'] . " </p>
                <p>Message : " . $response['message'] . "</p>
                <p>Total :  " . UtilityHelper::formatPrice($response['total']) . " </p>
            </div><br/>
				
				";
    }

    protected function onfailure($response) {
        $this->completePaymentTransaction($response);
        return "
             <h1>Unsuccessfull {$this->getPaymentName()} Transaction </h1>
             <p>We're sorry!</p>
             <p>Your payment has not been processed due to error. Please try again in a couple of minutes.</p>
			 <div class='alert-danger' style='padding: 10px;'>
                <h2>Transaction Status : " . $response['status'] . " </h2><br/>
                <p>Reference Number :  " . $response['reference'] . " </p>
				<p>Transaction Id :  " . $response['transaction_id'] . " </p>
				<p>Invoice :  " . $response['invoice'] . " </p>
                <p>Message : " . $response['message'] . "</p>
                <p>Total :  " . UtilityHelper::formatPrice($response['total']) . " </p>
            </div><br/>
        ";
    }

    public function regPaymentTransaction($order) {
        $onlinePaymentOptions = OnlinePaymentOptions::model()->findByAttributes(array('name' => $this->getPaymentName()));
        $resultSet = OnlinePaymentSettings::model()->findAllByAttributes(array('online_payment_options_id' => $onlinePaymentOptions->id));
        foreach ($resultSet as $result) {
            $settings[$result->field] = $result->value;
        }
        $pay = new PaymentTransaction;
        $pay->type = $pay->type = self::NAME;
        $pay->transaction_date = date('Y-m-d H:i:s');
        $pay->reference_number = $order['payment_code'];
        $pay->response_code = 'pending';
        $pay->transaction_amount = $order['total'];
        //$pay->transaction_currency = UtilityHelper::yiiparam('currencyText'); NEED TO WORK AROUND THIS
        $pay->transaction_currency = $settings['currency'];
        $pay->customer_name = $order['firstname'] . ' ' . $order['lastname'];
        $pay->order_id = $order['id'];
        $pay->save();
    }

    protected function completePaymentTransaction($response) {
        $order = Order::model()->findByAttributes(array('payment_code' => $response['invoice']));
        $pay = PaymentTransaction::model()->findByAttributes(array('reference_number' => $response['invoice']));
        $pay->query_code = $response['process_code'];
        $pay->response_description = $response['message'];
        $pay->response_code = $response['status'];
        $pay->approved_amount = $response['total'];
        $pay->save();

        $total = UtilityHelper::formatPrice($order->total);
        $siteurl = UtilityHelper::yiiparam('siteUrl');
        if (empty($order->check)) {
            $messg = "Dear {$order->firstname} {$order->lastname},<br/><br/>You have just attempted making payment for order #{$order->id} on {$order->store_url}. Find the details below.<br/><br/>Amount: $total<br/><br/>Response Description: {$response['message']}<br/><br/>Response Code: {$response['process_code']}<br/><br/>Transaction Ref No: {$response['invoice']}<br/><br/>Payment Reference: {$response['transaction_id']}<br/><br/>Transaction Date: " . date("D/M/Y") . "<br/>";
        } else if ($response['status'] == 'SUCCESS') {
            UtilityHelper::sendMail(UtilityHelper::yiiparam('salesEmail'), $order->email, 'Successful Payment Notification', $messg);
            $order->order_status_id = 2;
            $order->check = 1;
            $order->save();
            UtilityHelper::subtractOrder($order->id);
        } else {
            UtilityHelper::sendMail(UtilityHelper::yiiparam('salesEmail'), $order->email, 'Failed Payment Notification', $messg);
            $order->order_status_id = 10;
            $order->check = 1;
            $order->save();
        }
        $this->logResults($response['status']);
    }

}

?>
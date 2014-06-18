<?php
class PaymentCommand extends CConsoleCommand{
	public function actionIndex() {
		$globalpay = PaymentTransaction::model()->findAllByAttributes('response_code = :rescode', array(':rescode'=>'pending'));
		$interswitch = PaymentTransaction::model()->findAllByAttributes('response_code = :rescode', array(':rescode'=>'09'));
		if(!empty($globalpay )){
			foreach($globalpay as $payment){
				$client=new SoapClient('https://demo.globalpay.com.ng/GlobalpayWebService_demo/service.asmx?wsdl', true);
		
				$soapaction = "http://www.eazypaynigeria.com/globalpay_demo/getTransactions";
				$namespace = "http://www.eazypaynigeria.com/globalpay_demo/";
				$client->soap_defencoding = 'UTF-8';
				if(isset($payment->reference_number)){
					$txnref = $payment->reference_number;
					$order = Order::model()->findByAttributes(array('payment_code'=>$txnref));
				
					$merch_txnref=$txnref; 
					$channel=""; 
					//change the merchantid to the one sent to you
					$merchantID="3344"; 
					$start_date=""; 
					$end_date=""; 
					//change the uid and pwd to the one sent to you
					$uid="yl_ws_user"; 
					$pwd="yl_ws_password"; 
					$payment_status="" ; 
				
					$err = $client->getError();
				
					if ($err) {
						Yii::log( "PaymentComamndAction: ".CVarDumper::dumpAsString($err),
							CLogger::LEVEL_ERROR, "Payment.command.index" 
						);
					}
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

					$result = $client->call(
						'getTransactions', 
						array('parameters' => $param), 
						'http://www.eazypaynigeria.com/globalpay_demo/', 
						'http://www.eazypaynigeria.com/globalpay_demo/getTransactions', 
						false,  
						true
					);

					// Check for a fault
					if ($client->fault) {
						Yii::log( "PaymentComamndAction: ".CVarDumper::dumpAsString($result),
							CLogger::LEVEL_ERROR, "Payment.command.index" 
						);
					} 
					else {
						// Check for errors
						$err = $client->getError();
						if ($err) {
							// Display the error
							//echo '<h2>Error</h2><pre>' . $err . '</pre>';
							Yii::log( "PaymentComamndAction: ".CVarDumper::dumpAsString($err),
							CLogger::LEVEL_ERROR, "Payment.command.index" 
						);
						} 
						else {
							//This gives getTransactionsResult
							$WebResult=$MethodToCall."Result";
							// Pass the result into XML
							$xml = simplexml_load_string($result[$WebResult]);
							
							
							//echo $xml;
							$trans = array();
							$trans['amount'] = $xml->record->amount;
							$trans['txn_date'] = $xml->record->payment_date;
							$trans['pmt_method'] = $xml->record->channel;
							$trans['pmt_status'] = $xml->record->payment_status;
							$trans['pmt_txnref'] = $xml->record->txnref;
							$trans['currency'] = $xml->record->field_values->field_values->field[2]->currency;
						   // $pnr = 'PNR';
							$trans['trans_status'] = $xml->record->payment_status_description;
							
							$merch_name = "{$order->firstname} {$order->lastname}";
							$merch_phoneno  = $order->phone;
							$merch_amt = $order->total;
						
							if($trans['amount'] != $payment->transaction_amount)
								$trans['pmt_status'] .= " ( Amount does not match and no service will be rendered)";
							
							$payment = new PaymentTransaction;
							$payment->query_date = date();
							$payment->response_description = $trans['trans_status'];
							$payment->response_code = $trans['pmt_status'];
							$payment->approved_amount = $trans['amount'];
							$payment->save();
						} 
						
					 
						//$trans_pay_status = $trans['pmt_status'];
						
							
						$message = "Dear {$payment->customer_name},<br/><br/>You have just attempted making payment for order #{$order->id} on {$order->store_url}. Find the details below.<br/>Name : {$payment->customer_name} <br/><br/>Amount : {$trans['amount']} <br/><br/>Transaction Date : {$trans['txn_date']} <br/><br/>Payment Method : {$trans['pmt_method']} <br/><br/>Payment Status : {$trans['pmt_status']} <br/><br/>Transaction Reference Number : {$trans['pmt_txnref']} <br/><br/>Currency : {$trans['currency']} <br/><br/>Transaction Status : {$trans['$trans_status']} <br/><br/>";
						if($trans['pmt_status'] == 'successful' && $trans['amount'] == $payment->transaction_amount)
							UtilityHelper::sendMail('',$order->email,UtilityHelper::yiiparam('salesEmail'), 'Successful Payment Notification',$message);
						else if($trans['pmt_status'] == 'pending'){
						}
						else
							UtilityHelper::sendMail('',$order->email,UtilityHelper::yiiparam('salesEmail'), 'Failed Payment Notification',$message);
							
					}
				}
			}
		}
		if(!empty($interswitch)){
			foreach($interswitch as $payment){
					$order = Order::model()->findByAttributes(array('payment_code'=>$payment->reference_number));
					$url = UtilityHelper::yiiparam('interswitchGet').'?productid='.$order->id.'&transactionreference='.$payment->reference_number.'&amount='.$payment->transaction_amount;
					$cURL = curl_init();

					curl_setopt($cURL, CURLOPT_URL, $url);
					curl_setopt($cURL, CURLOPT_HTTPGET, true);

					curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Accept: application/json',
						'Hash: '.hash_hmac('sha512', $order->id.$payment->reference_number);
					));
					$result = curl_exec($cURL);
					curl_close($cURL);
					$json = json_decode($result, true);
					if($payment->response_code != $json['ResponseCode']){
						$payment->response_description = $json['ResponseDescription'];
						$payment->response_code = $json['ResponseCode'];
						$payment->save();
					}
					
					$total = UtilityHelper::formatPrice($order->total);
					$siteurl = UtilityHelper::yiiparam('siteUrl');
					if($payment->response_code == '00')
						UtilityHelper::sendMail('',$order->email,UtilityHelper::yiiparam('salesEmail'), 'Successful Payment Notification',"Dear {$payment->customer_name},<br/><br/>You have attempted to make payment for order #{$order->id} on {$order->store_url}. Find the details below.<br/>Name: {$payment->customer_name}<br/><br/>Response Description: {$json['ResponseDescription']}<br/><br/>Amount: $total<br/><br/>Response Code: {$json['ResponseCode']}<br/><br/>Transaction Ref No: {$ref}<br/>");
					else if($payment->response_code == '09'){
					}
					else
						UtilityHelper::sendMail('',$order->email,UtilityHelper::yiiparam('salesEmail'), 'Failed Payment Notification',"Dear {$payment->customer_name},<br/><br/>You have attempted to make payment for order #{$order->id} on {$order->store_url}. Find the details below.<br/>Name: {$payment->customer_name}<br/><br/>Response Description: {$json['ResponseDescription']}<br/><br/>Amount: $total<br/><br/>Response Code: {$json['ResponseCode']}<br/><br/>Transaction Ref No: {$ref}<br/>");


			}
		}
	}
}
?>
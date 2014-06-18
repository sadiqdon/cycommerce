<?php

class UtilityHelper
{

	public static function changePassword($find,$mesg='Message')
	{

	}
	
	public static function yiiparam($name, $default = null)
	{
		if ( isset(Yii::app()->params[$name]) )
			return Yii::app()->params[$name];
		else
			return $default;
	}
	
		/**
	 * Send to user mail
	 */
	public static function sendMail($from='',$to,$subject,$message) {
    	 if (!$from) $from = Yii::app()->params['adminEmail'];
	    $headers = "MIME-Version: 1.0\r\nFrom: $from\r\nReply-To: $from\r\nContent-Type: text/html; charset=utf-8";
	    $message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
	    return mail($to,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}

    /**
     * Send to user mail
     */
    public function sendMailToUser($user_id,$subject,$message,$from='') {
        $user = User::model()->findbyPk($user_id);
        if (!$from) $from = Yii::app()->params['adminEmail'];
        $headers="From: ".$from."\r\nReply-To: ".Yii::app()->params['adminEmail'];
        return mail($user->email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
    }
	
	public static function formatPrice($price){
		$f = new CNumberFormatter(Yii::app()->language);
		return '&#8358;'.Yii::app()->numberFormatter->format("#,##0.##",$price);
	}
	
	public static function getCurrency(){
		return '&#8358;';
	}
	
	public static function productLink($id) {
		$arry = array();
		$product = Product::model()->findByPk($id);
		if(!empty($product)){
			$arry['product'] = $product->getLink();
			$category = $product->categories;
			$parent = $category[0]->parent;
			if(!empty($parent)){
				$arry['subcategory'] = $category[0]->getLink();
				$arry['category'] = $category[0]->parent->getLink();
			}
			else{
				$arry['category'] = $category[0]->getLink();
			}
		}
		
		return $arry;
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
	public static function changeOrderStatus($id,$st = 2){
		$order = Order::model()->findByPk($id);
		$order->order_status_id = $st; //set the order, default value is 'processing'
		$order->save();
	}
	public static function subtractOrder($id){
		$porders = OrderProduct::model()->findAll('order_id=:id',array(':id'=>$id));
		if(!empty($porders)){
			foreach($porders as $porder){
				$option = OrderOption::model()->find('order_id='.$id.' AND order_product_id='.$porder->id);
				if(!empty($option)){
					$pvalue = ProductOptionValue::model()->findByPk($option->product_option_value_id);
					if(!empty($pvalue)){
						$pvalue->quantity -= $porder->quantity;
						$pvalue->save();
					}
				}else{
					$pvalue = Product::model()->findByPk($porder->product_id);
					if(!empty($pvalue)){
						$pvalue->quantity -= $porder->quantity;
						$pvalue->save();
					}
				}
			}
		}
	}
	
	public static function enumItem($model,$attribute)
	{
			$attr=$attribute;
			CHtml::resolveName($model,$attr);
			preg_match('/\((.*)\)/',$model->tableSchema->columns[$attr]->dbType,$matches);
			foreach(explode(',', $matches[1]) as $value)
			{
					$value=str_replace("'",null,$value);
					$values[$value]=Yii::t('label',$value);
			}
			
			return $values;
	}  

   public static function enumDropDownList($model, $attribute, $htmlOptions=array())
   {
	  return CHtml::activeDropDownList( $model, $attribute,self::enumItem($model,  $attribute), $htmlOptions);
   
   
   }
	public static function getPublishPath($path){
		$rpath = realpath(UtilityHelper::yiiparam('frontPath').'/www'.$path);
		if(!empty($rpath)){
			$url = Yii::app()->assetManager->publish($rpath);
			return $url;
		}
		return null;
	}
	
	/*public static function sendToLog($dump,$message="Error Dump"){
		Yii::log( "$message:\n".$dump , CLogger::LEVEL_ERROR );
	}*/
	public static function sendToLog($dump,$message="Error Dump"){
		Yii::log( "$message:\n".CVarDumper::dumpAsString( 
								$dump ), CLogger::LEVEL_ERROR );
	}
}

?>
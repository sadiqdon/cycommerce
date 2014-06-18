<?php
	$paymentName = 'Global_pay'; // ALL OTHER PROCESSING WILL BE DONE HERE 
  	$paymentClass = new $paymentName();
 
 ?>
<div class="checkout_head_general">
	<span class="checkout_title">Pay Online</span>
	<div class="clear"></div>
</div>
<?php echo CHtml::beginForm($paymentClass->getGatewayUrl(), 'POST'); ?>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/payment_images/'. $paymentClass->getPaymentImage()); ?>
		<?php $order = Order::model()->findByPk($orderID);
		if(!empty($order)){?>		
			<h5>Transaction ID:  <?php echo $ref; ?></h5>
			<h5>Name:  <?php echo $order->firstname.' '.$order->lastname; ?></h5>
			<h5>Total Amount Due:  <?php echo UtilityHelper::formatPrice($total); ?></h5>
			<h5>Email:  <?php echo $order->email; ?></h5>
			<h5>Phone:  <?php echo $order->telephone; ?></h5>		
			<br/>
			<span>Please take note of your transaction id, you may be required to present it in future.</span>
			<?php 
			echo CHtml::hiddenField('merch_txnref',$ref);
			echo CHtml::hiddenField('merchantid',"174");
			echo CHtml::hiddenField('names',$order->firstname.' '.$order->lastname); //$orderID);
			echo CHtml::hiddenField('email_address',$order->email);
			echo CHtml::hiddenField('amount',"$total");
			//echo CHtml::hiddenField('site_redirect_url', UtilityHelper::yiiparam('site_redirect_url'));
			echo CHtml::hiddenField('phone_number', $order->telephone);
			echo CHtml::hiddenField('currency', UtilityHelper::yiiparam('currencyText'));
			?>
		<?php }
		?>
	</div>
</div>
<div class="section_foot_general">
	<input type="submit" class="f_right_checkout" value="" />
	<div class="clear"></div>
</div>
<?php echo CHtml::endForm(); ?>
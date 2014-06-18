<?php	$paymentClass = new $pay_method(); ?>
<div class="checkout_head_general">
	<span class="checkout_title">Pay Online</span>
	<div class="clear"></div>
</div>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<div class="pull-left col-md-12"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/payment_images/'. $paymentClass->getPaymentImage()); ?></div>
		<div class="clearfix"></div><br/>
		<?php $order = Order::model()->findByPk($orderID);
		if(!empty($order)){?>
			<h5>Name:  <?php echo $order->firstname.' '.$order->lastname; ?></h5>
		<?php }
		?>
		<h5>Transaction ID:  <?php echo $ref; ?></h5>
		<h5>Total Amount Due:  <?php echo UtilityHelper::formatPrice($total); ?></h5>		
		<br/>
		<span>Please take note of your transaction id, you may be required to present it in future.</span>
		<?php $this->prepareOnlinePayment($order,$paymentClass,$ref,$total,$orderID); ?>
	
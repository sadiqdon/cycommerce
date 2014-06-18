<div class="checkout_head_general">
	<span class="checkout_title">Pay Online</span>
	<div class="clear"></div>
</div>
<?php echo CHtml::beginForm(UtilityHelper::yiiparam('interswitchURL'), 'POST'); ?>
<div class="section_body_general">
	<div class="checkout_wrapper">
		

		<?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/Interswitch_Verve_Mastercard.gif'); ?>
		<?php $order = Order::model()->findByPk($orderID);
		if(!empty($order)){?>
			<h5>Name:  <?php echo $order->firstname.' '.$order->lastname; ?></h5>
		<?php }
		?>
		<h5>Transaction ID:  <?php echo $ref; ?></h5>
		<h5>Total Amount Due:  <?php echo UtilityHelper::formatPrice($total); ?></h5>		
		<br/>
		<span>Please take note of your transaction id, you may be required to present it in future.</span>
		<?php 
		$hash = hash('sha512', $ref.UtilityHelper::yiiparam('interswitchProductID').UtilityHelper::yiiparam('interswitchItemID').($total*100).UtilityHelper::yiiparam('site_redirect_url').UtilityHelper::yiiparam('MAC_key'));
		echo CHtml::hiddenField('txn_ref',$ref);
		echo CHtml::hiddenField('product_id',UtilityHelper::yiiparam('interswitchProductID')); //$orderID);
		echo CHtml::hiddenField('pay_item_id',UtilityHelper::yiiparam('interswitchItemID'));
		echo CHtml::hiddenField('cust_id',$orderID);
		//echo CHtml::hiddenField('cust_id_desc',$order->firstname.' '.$order->lastname);
		echo CHtml::hiddenField('cust_name',$order->firstname.' '.$order->lastname);
		echo CHtml::hiddenField('amount',$total*100);
		echo CHtml::hiddenField('site_name', UtilityHelper::yiiparam('site_name'));
		echo CHtml::hiddenField('site_redirect_url', UtilityHelper::yiiparam('site_redirect_url'));
		echo CHtml::hiddenField('hash', $hash);
		echo CHtml::hiddenField('currency', UtilityHelper::yiiparam('currency'));
		?>
	</div>
</div>
<div class="section_foot_general">
	<a href="#" class="f_left"><?php echo CHtml::image(Yii::app()->request->baseUrl.'/img/checkout_shopping.png'); ?></a>
	<input type="submit" class="f_right_checkout" value="" />
	<div class="clear"></div>
</div>
<?php echo CHtml::endForm(); ?>
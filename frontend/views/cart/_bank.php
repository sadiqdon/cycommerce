<div class="checkout_head_general">
	<span class="checkout_title">Thank You!</span>
	<div class="clear"></div>
</div>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<h2>Reference #: <?php echo $ref; ?></h2>
		<p>Thank you for your order, please note that your order will not be processed until payment is received.</p>
		<p><strong>Total Amount Due:  <?php echo UtilityHelper::formatPrice($total); ?></strong><br/><br/>
		You can pay into the bank account listed below with the following details:</p>
		<p><strong>Depositor Name: <?php echo $ref; ?></strong><br/>
		<strong>Amount:  <?php echo UtilityHelper::formatPrice($total); ?></strong><br/>
		<strong>Account Name: Yorshop Links Ltd</strong><br/>
		<strong>Account Number: 1013681378</strong><br/>
		<strong>Bank Name: Zenith bank Plc</strong><br/></p>	
	</div>
</div>
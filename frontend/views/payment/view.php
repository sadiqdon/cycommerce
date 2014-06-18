<div class="checkout_head_general">
	<span class="checkout_title"><?php if($response['ResponseCode'] == '00')
			echo 'Thank You!';
		else echo 'Payment Status';?></span>
	<div class="clear"></div>
</div>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<?php if($response['ResponseCode'] == '00')
			echo '<h2>Payment Processed successfully</h2>';
		else
			echo '<h2>Payment Failed</h2>';?>
		<h5>Name : <?php echo $response['CustomerName']; ?></h5>
		<h5>Transaction Reference #: <?php echo $ref; ?></h5>
		<h5>Payment Reference: <?php echo $response['PaymentReference']; ?></h5>
		<h5>Payment Status Description: <?php echo $response['ResponseDescription']; ?></h5>
		<h5>Payment Response Code: <?php echo $response['ResponseCode']; ?></h5>
		<h5>Amount: <?php echo UtilityHelper::formatPrice($response['Amount']/100); ?></h5>
		<h5>Transaction Date : <?php echo $response['TransactionDate']; ?></h5>
	</div>
</div>
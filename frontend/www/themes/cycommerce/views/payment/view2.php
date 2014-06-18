<div class="checkout_head_general">
	<span class="checkout_title"><?php if($response['pmt_status'] == 'successful')
			echo 'Thank You!';
		else echo 'Payment Status';?></span>
	<div class="clear"></div>
</div>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<?php if($response['pmt_status'] == 'successful')
			echo '<h2>Payment Processed successfully</h2>';
		else if($response['pmt_status'] == 'pending')
			echo '<h2>Payment Pending</h2>';?>
			echo 'An email will be sent to you once the transaction status is confirmed.'
		else
			echo '<h2>Payment Failed</h2>';?>
	
			<h5>Name : <?php echo $response['merch_name']; ?></h5>
			<h5>Phone number : <?php echo $response['merch_phoneno']; ?></h5>
			<h5>Transaction Amount : <?php echo $response['merch_amt']; ?></h5>
			<h5>Debited Amount : <?php echo $response['amount']; ?></h5>
			<h5>Transaction Date : <?php echo $response['txn_date']; ?></h5>
			<h5>Payment Method : <?php echo $response['pmt_method']; ?></h5>
			<h5>Payment Status : <?php echo $response['pmt_status']; ?></h5>
			<h5>Transaction Reference Number : <?php echo $response['pmt_txnref']; ?></h5>
			<h5>Currency : <?php echo $response['currency']; ?></h5>
			<h5>Transaction Status : <?php echo $response['trans_status']; ?></h5>
			
	</div>
</div>
<div class="checkout_head_general">
	<div class="clearfix"></div>
</div>
<div class="section_body_general">
	<div class="checkout_wrapper">
		<?php
			//exit(print_r($_POST));
			$returnPayment = $_GET['payment'];
			$subClasses = new PaymentGatewayHelper();
			$subClassesArray = $subClasses->getSubClasses();
			foreach($subClassesArray as $class => $payOption){
				$$class = new $class();
				$$class->getPaymentName() == $returnPayment;
				$$class->checkResponse($_POST,$ref);
			}
			
		?>
	</div>
</div>
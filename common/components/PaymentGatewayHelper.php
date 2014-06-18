
<?php

class PaymentGatewayHelper {

    public function __construct() {
        
    }

    public function getSubClasses() {
        $paymentArray = array();
        $buildPath = realpath('.');
        $path = $buildPath . '/common/payments';// config


        foreach (new DirectoryIterator("{$path}") as $fileInfo) {
            if ($fileInfo->isDot())
                continue;
            //echo $fileInfo->getFilename() . "<br>\n";
            $className = str_replace(".php", "", $fileInfo->getFilename());
            $paymentArray[$className] = $fileInfo->getFilename();
        }

        return $paymentArray;
    }

    public function fetchPaymentOptionsForm() {
        foreach ($this->getSubClasses() as $key => $value) {
            $class = new ReflectionClass($key);
            if ($class->isSubclassOf('PaymentGateway')) {
                $paymentObj = new $key();
                $baseUrl = Yii::app()->request->baseUrl; // move to the view
                echo('
				 <div class="radio">
                    <label>Pay with ' . $paymentObj->getDisplayName() . ' 
					<input type="radio" name="Payment[payment_method]" value="' . $paymentObj->getPaymentName() . '">
					<br/><span class="text-muted"> ' . $paymentObj->getTermAndConditions() . '</span>
					</label>
				</div>
				<img src="' . $baseUrl . '/img/payment_images/' . $paymentObj->getPaymentImage() . '" alt="" title="" class="img-responsive" />
				<div class="clearfix"></div>
				<hr/>
				');
            }
        }
    }

}

?>
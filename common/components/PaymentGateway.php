
<?php

abstract class PaymentGateway {

    abstract public function enableTestMode($gatewayUrl);

    abstract protected function preSubmit();

    abstract public function prepareSubmit();

    abstract protected function postSubmit();

    abstract protected function validateIpn();

    abstract public function checkResponse($response);

    abstract protected function onSuccess($response);

    abstract protected function onfailure($response);

    public abstract function regPaymentTransaction($order);

    abstract protected function completePaymentTransaction($response);

    const error_string = "Unable to convert to string. String needed for function parameter";
    const error_boolean = "Unable to convert to boolean. boolean needed for function parameter";
    const error_object = "Parameter not an object";

    protected $paymentName; // name of the payment gateway
    protected $testMode; // true indicated test mode is on and vice versa
    public $fields = array(); // fields need for the payment gateway
    protected $gatewayUrl; // gateway url
    protected $lastErrorMessage;   // Holds the last error message encountered
    protected $ipnLogFile; // ipn log file (if $logIpn is TRUE response will be log in this file)
    protected $logIpn; // Do we need to log IPN results TRUE means yes and vice versa
    protected $ipnResponse; // current ipn response
    protected $ipnData = array();
    protected $termAndConditions;
    protected $viewLink;
    protected $orderObj;
    protected $displayName;
    protected $paymentImage;
    protected $settings = array();
	public $showingPaymentButton = true;
	public $requried_fields = array();

    /* START private methods */

    private function checkType($param, $type, $error) {
        if (settype($param, $type)) {
            return $param;
        } else {
            throw new Exception($error);
        }
        return FALSE;
    }

    private function checkObject($param, $error) {
        if (is_object($param)) {
            return $param;
        } else {
            throw new Exception($error);
        }
        return FALSE;
    }

    /* END private methods */

    /* START getters and setters methods */

    public function getPaymentName() {
        return isset($this->paymentName) ? $this->paymentName : FALSE;
    }

    protected function setPaymentName($name) {
        try {
            $this->paymentName = $this->checkType($name, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getTestMode() {
        return isset($this->testMode) ? $this->testMode : FALSE;
    }

    protected final function setTestMode($bool) {
        try {
            $this->testMode = $this->checkType($bool, "boolean", self::error_boolean);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getFields() {
        return isset($this->fields) ? $this->fields : FALSE;
    }

    public function getGatewayUrl() {
        return isset($this->gatewayUrl) ? $this->gatewayUrl : FALSE;
    }

    protected function setGatewayUrl($gatewayUrl) {
        try {
            $this->gatewayUrl = $this->checkType($gatewayUrl, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getLastErrorMessage() {
        return $this->lastErrorMessage ? isset($this->lastErrorMessage) : FALSE;
    }

    public function setLastErrorMessage($error) {
        try {
            $this->lastErrorMessage = $this->checkType($error, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            return $ex->getTrace();
        }
    }

    public function getIpnLogFile() {
        return isset($this->ipnLogFile) ? $this->ipnLogFile : FALSE;
    }

    protected function setIpnLogFile($ipnLogFile) {
        try {
            $this->ipnLogFile = $this->checkType($ipnLogFile, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getLogIpn() {
        return isset($this->logIpn) ? $this->logIpn : FALSE;
    }

    protected function setLogIpn($bool) {
        try {
            $this->logIpn = $this->checkType($bool, "boolean", self::error_boolean);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getIpnResponse() {
        return isset($this->ipnResponse) ? $this->ipnResponse : FALSE;
    }

    protected function setIpnResponse($ipnResponse) {
        try {
            $this->ipnResponse = $this->checkType($ipnResponse, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getIpnData() {
        return isset($this->ipnData) ? $this->ipnData : FALSE;
    }

    public function setIpnData($key, $value) {
        try {
            if (is_string($key)) {
                $this->ipnData["{$key}"] = $value;
            } else {
                if (settype($key, "string")) {
                    $this->ipnData["{$key}"] = $value;
                } else {
                    throw new Exception("Method needs parameter one to be a string.");
                }
            }
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getTermAndConditions() {
        return isset($this->termAndConditions) ? $this->termAndConditions : FALSE;
    }

    protected function setTermAndConditions($terms) {
        try {
            $this->termAndConditions = $this->checkType($terms, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getViewLink() {
        return isset($this->viewLink) ? $this->viewLink : FALSE;
    }

    protected function setViewLink($viewLink) {
        try {
            $this->viewLink = $this->checkType($viewLink, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getOrderObj() {
        return isset($this->orderObj) ? $this->orderObj : FALSE;
    }

    public function setOrderObj($orderObj) {
        try {
            $this->orderObj = $this->checkObject($orderObj, self::error_object);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getDisplayName() {
        return isset($this->displayName) ? $this->displayName : FALSE;
    }

    protected function setDisplayName($displayName) {
        try {
            $this->displayName = $this->checkType($displayName, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function getPaymentImage() {
        return isset($this->paymentImage) ? $this->paymentImage : FALSE;
    }

    protected function setPaymentImage($paymentImage) {
        try {
            $this->paymentImage = $this->checkType($paymentImage, "string", self::error_string);
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    /* END getters and setters methods */

    //////////////////////////////////////////////////////////////

    public function __construct() {
        $this->setIpnLogFile("paymentGatewayLog.txt");
        $this->logIpn = TRUE;
    }

    public function addField($field, $value) {
        try {
            if (is_string($field)) {
                $this->fields["$field"] = $value;
            } else {
                if ($field = settype($field, "string")) {
                    $this->fields["$field"] = $value;
                } else {
                    throw new Exception(self::error_string);
                }
            }
            return TRUE;
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    protected function submitPayment() {
        try {
            foreach ($this->getFields() as $name => $value) {
                echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
            }
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function logResults($status) {
        try {
            $logIpnStatus = $this->getLogIpn();
            if (isset($logIpnStatus)) {
                // Timestamp
                $text = '[' . date('m/d/Y g:i A') . '] - ';

                // Success or failure being logged?
                $text .= ($status) ? "SUCCESS!\n" : 'FAIL: ' . $this->getLastErrorMessage() . "\n";

                // Log the POST variables
                $text .= "IPN POST Vars from gateway:\n";
                foreach ($this->getIpnData() as $key => $value) {
                    $text .= "$key=$value, ";
                }

                // Log the response from the paypal server
                $text .= "\nIPN Response from {$this->getPaymentName()} Server:\n " . $this->getIpnResponse();

                // Write to log
                $fp = fopen($this->getIpnLogFile(), 'a');
                fwrite($fp, $text . "\n\n");
                fclose($fp);
            } else {
                return FALSE;
            }
        } catch (Exception $ex) {
            $this->setLastErrorMessage($ex->Message());
            return $ex->getTrace();
        }
    }

    public function setUserSettings($settings) {
        foreach ($settings as $key => $value) {
            $this->settings[$key] = $value;
        }
    }
	
	public function showPaymentButton($bool){
		if(isset($bool) && is_bool($bool)){
			$this->showingPaymentButton = $bool;
			return $this->showingPaymentButton;
		}
		return $this->showingPaymentButton;
	}

}

?>
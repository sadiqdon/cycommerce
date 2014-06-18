<?php
class OnlinePaymentSettingsForm  extends CFormModel
{
 
   public $allPaymentClassesArray = array();
   
	
	public function __construct(){
	    $paymentClasses = new PaymentGatewayHelper();
		$allPaymentClassesArray= $paymentClasses->getSubClasses();
		//$this->allPaymentClassesArray= $paymentClasses->getSubClasses();
		foreach($allPaymentClassesArray as $key => $value){
			//echo $key . ' ' . $value . '<br/>';
			$paymentClass = new $key();
			array_push($this->allPaymentClassesArray,$paymentClass->settingsArray);
			//print_r($paymentClass->settingsArray);
			echo '<br/><br/>';
		}
		print_r($this->allPaymentClassesArray);
		//exit('End');
	}
	
 
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function getAttributesLabels($key)
    {
        $keys = array(
            'googleAPIKey' => 'Google API Key',
            'numSearchResults' => 'Number of search results at one page',
            'mainTitle' => 'Main Page Title',
            'mainKwrds' => 'Default Keywords (Meta Tag)',
            'mainDescr' => 'Default Description (Meta Tag)',
        );
 
        if(array_key_exists($key, $keys))
            return $keys[$key];
 
        $label = trim(strtolower(str_replace(array('-', '_'), ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $key))));
        $label = preg_replace('/\s+/', ' ', $label);
 
        if (strcasecmp(substr($label, -3), ' id') === 0)
            $label = substr($label, 0, -3);
 
        return ucwords($label);
    }
 
    /**
     * Sets attribues values
     * @param array $values
     * @param boolean $safeOnly
     */
    public function setAttributes($values,$safeOnly=true) 
    { 
        if(!is_array($values)) 
            return; 
 
        foreach($values as $category=>$values) 
        { 
            if(isset($this->$category)) {
                $cat = $this->$category;
                foreach ($values as $key => $value) {
                    if(isset($cat[$key])){
                        $cat[$key] = $value;
                    }
                }
                $this->$category = $cat;
            }
        } 
    }
}
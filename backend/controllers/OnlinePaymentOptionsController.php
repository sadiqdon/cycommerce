<?php
class OnlinePaymentOptionsController extends Controller
{
 
    public function actionIndex()
    {
        $settings = app()->settings;
		$config = array();
		$paymentClasses = new PaymentGatewayHelper();
		$allPaymentClassesArray= $paymentClasses->getSubClasses();
		foreach($allPaymentClassesArray as $key => $value){
			$paymentClass = new $key();
			$config['elements'][$paymentClass->getPaymentName()] = $paymentClass->settingsArray;
		}
        if (isset($_POST['SettingsForm'])) {
			//print_r($_POST['SettingsForm']);
            $settings->deleteCache();
            foreach($_POST['SettingsForm'] as $category => $values){
                $settings->set($category, $values);
            }
            user()->setFlash('success', 'Site settings were updated.');
            $this->refresh();
        }
		
		foreach($config['elements'] as $category => &$attributes){			
			foreach($attributes['elements'] as &$attribute){
                $attribute['value'] = $settings->get($category, $attribute['name']);
            }
		}
		$this->render('index', array('config' => $config));
    }
 
}
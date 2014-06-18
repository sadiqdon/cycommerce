<?php
class SettingsController extends Controller
{
 
    public function actionIndex()
    {
        $settings = Yii::app()->settings;
 
		$config=require(Yii::getPathOfAlias('backend.views.settings.settingsForm').'.php');
		
		//echo UtilityHelper::getSettings('messages','accountactivatedsubject');
		//echo UtilityHelper::getSettings('messages','accountactivated');
        if (isset($_POST['SettingsForm'])) {
			//print_r($_POST['SettingsForm']);
            //$model->setAttributes($_POST['SettingsForm']);
            $settings->deleteCache();
            foreach($_POST['SettingsForm'] as $category => $values){
                $settings->set($category, $values);
            }
			file_put_contents(UtilityHelper::yiiparam('frontPath')."/config/main-settings.php", $this->getConfigTemplate(
				$settings->get('site', 'name'),
				$settings->get('site', 'siteRedirectUrl'),
				$settings->get('site', 'noreplyEmail'),
				$settings->get('site', 'salesEmail'),
				$settings->get('site', 'sitePhone'),
				$settings->get('site', 'currency')
			));	
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
	
		private function getConfigTemplate($siteName,$siteRedirectUrl,$noreplyEmail, $salesEmail,$sitePhone, $currency){
		return 	"<?php
	return  array(
			'storeID'      => 1,
			'site_name' => '{$siteName}',
			'site_redirect_url' => '{$siteRedirectUrl}',
			'noreplyEmail' => '{$noreplyEmail}',
			'salesEmail' => '{$salesEmail}',
			'sitePhone' => '{$sitePhone}',
			'currency' => '{$currency}',

		)
 ?>";
	
	}
 
}
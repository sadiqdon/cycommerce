<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	
	public $tab;
	
	private $_assetsBase;
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function getAssetsBase()
	{
			if ($this->_assetsBase === null) {
					$this->_assetsBase = Yii::app()->assetManager->publish(
							Yii::getPathOfAlias('application.assets'),
							false,
							-1,
							defined('YII_DEBUG') && YII_DEBUG
					);
			}
			return $this->_assetsBase;
	}
	
	public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'changePassword - error, login, logout, password, passwordVerify, recovery, changepassword',
        );
    }
	
	/**
     * Creates a rule to validate user's password freshness.
     * @return array the array of rules to validate against
     */
    public function changePasswordRules()
    {
        return array(
            'days' => 30,
        );
    }
 
    /**
     * Runs the Password filter
     * @param type $filterChain 
     */
    public function filterChangePassword($filterChain)
    {
        $filter = new ChangePasswordFilter();
        $filter->setRules($this->changePasswordRules());
        $filter->filter($filterChain);
    }
	
	public function behaviors()
    {
        return array(
            'eexcelview'=>array(
                'class'=>'ext.eexcelview.EExcelBehavior',
            ),
        );
    }
	
	public function accessRules()
    {
        return array(
			/*array('allow',
				'actions'=>array('index','admin','view','update','delete'),
				'controllers'=>array(''),
                'roles'=>array(''),
            ),*/
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('specialOrder',),
                'roles'=>array('viewSpecialOrder'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('customer','customerGroup'),
                'roles'=>array('viewSale'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('returns'),
                'roles'=>array('viewReturns'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','update','delete'),
				'controllers'=>array('orderReport','taxReport','shippingReport','returnReport', 'productViewReport','productPurchasedReport','customersOnReport','customersOrderReport'),
                'roles'=>array('viewReport'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete','upload'),
				'controllers'=>array('product'),
                'roles'=>array('viewProduct'),
            ),
			array('allow',
				'actions'=>array('create'),
				'controllers'=>array('authItem','role'),
                'roles'=>array('createPrivilege'),
            ),
			array('allow',
				'actions'=>array('update','admin','revoke','removeChild','addChild'),
				'controllers'=>array('authItem','role','assignment'),
                'roles'=>array('editPrivilege'),
            ),
			array('allow',
				'actions'=>array('view', 'index'),
				'controllers'=>array('assignment','authItem','role'),
                'roles'=>array('viewPrivilege'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','update','delete'),
				'controllers'=>array('paymentTransaction'),
                'roles'=>array('viewPaymentTransaction'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('order'),
                'roles'=>array('viewOrder'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('option'),
                'roles'=>array('viewOption'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('newsletter'),
                'roles'=>array('viewNewsletter'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('manufacturer'),
                'roles'=>array('viewManufacturer'),
            ),
			array('allow',
				'actions'=>array('index','download','view'),
				'controllers'=>array('log'),
                'roles'=>array('viewLog'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('language','currency','country','taxClass','taxRate','zones','geozones','length','weight'),
                'roles'=>array('viewLocalization'),
            ),array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('faq'),
                'roles'=>array('viewFaq'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('employee'),
                'roles'=>array('viewEmployee'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete','upload'),
				'controllers'=>array('category'),
                'roles'=>array('viewCategory'),
            ),array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('frontendSliderImages'),
                'roles'=>array('viewFrontendSliderImage'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('frontendBackgroundImages'),
                'roles'=>array('viewFrontendBackgroundImage'),
            ),
			array('allow',
				'actions'=>array('index','admin','view'),
				'controllers'=>array('auditTrail'),
                'roles'=>array('viewAuditTrail'),
            ),
			array('allow',
				'actions'=>array('index','admin','view','create','update','delete'),
				'controllers'=>array('attribute','attributeGroup'),
                'roles'=>array('viewAttribute'),
            ),
			array('allow',
				'actions'=>array('error','index'),
				'controllers'=>array('site'),
                'users'=>array('*'),
            ),
			array('allow',
				'actions'=>array('recovery','changepassword'),
				'controllers'=>array('recovery'),
                'users'=>array('*'),
            ),	
			array('allow',
				'actions'=>array('changepassword'),
				'controllers'=>array('profile'),
                'users'=>array('*'),
            ),
			/*array('allow',
				'actions'=>array('changepassword'),
				'controllers'=>array('profile'),
                'roles'=>array('updatePassword'),
            ),*/	
			array('allow',
				'actions'=>array('view','profile'),
				'controllers'=>array('profile'),
                'users'=>array('*'),
            ),
			array('allow',
				'controllers'=>array('logout', 'login', 'activation'),
                'users'=>array('*'),
            ),
			array('allow',
                'users'=>array('admin'),
            ),			
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
	
	public function startsWith($haystack, $needle)
	{
		return !strncmp($haystack, $needle, strlen($needle));
	}

	public function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}

		return (substr($haystack, -$length) === $needle);
	}
}
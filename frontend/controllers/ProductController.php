<?php
/**
 * CategoryController.php
 *
 */
class ProductController extends Controller {
	
	public $layout='//layouts/column3';
		
	public $defaultAction = 'view';
	
	private $modelName = 'Product';
	
	public function accessRules() {
		return array(
			// not logged in users should be able to login and view captcha images as well as errors
			array('allow', 'actions' => array('index', 'view', 'captcha', 'login', 'error', 'KK')),
			// logged in users can do whatever they want to
			array('allow', 'users' => array('@')),
			// not logged in users can't do anything except above
			array('deny'),
		);
	}

	/**
	 * Declares class-based actions.
	 * @return array
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	/* open on startup */
	public function actionView() {
		if(!empty($_GET['subcategory']) || !empty($_GET['category'])){
			$product = Product::model()->with('productDescriptions')->find('productDescriptions.link=:link',array(':link'=>$_GET['product']));
			$this->render('product',array('product'=>$product, 'options'=>$this->loadProductOption($product->id)));
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.')); 
		
	}
	
	
	
	
	public function actionAll() {
		if(empty($_GET['category']) || $_GET['category'] == 'all')
				$this->paginate();
		else if(!empty($_GET['subcategory'])){
			$this->paginate($_GET['subcategory']);
		}else if(!empty($_GET['category'])){
			$this->paginate($_GET['category']);
		}else
			throw new CHttpException(400, Yii::t('info', 'Your request is invalid.')); 
		
		
	}
	

}
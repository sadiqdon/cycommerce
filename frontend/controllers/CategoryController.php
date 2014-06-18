<?php
/**
 * CategoryController.php
 *
 */
class CategoryController extends Controller {
	
	public $layout='//layouts/column3';
	
	public $categoryID = 0;	
	
	public $defaultAction = 'all';
	
	private $modelName = 'Category';
	
	public function accessRules() {
		return array(
			// not logged in users should be able to login and view captcha images as well as errors
			array('allow', 'actions' => array('index', 'list', 'captcha', 'login', 'error', 'KK')),
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
	public function actionIndex() {
		$this->render('index');
	}

	public function actionDefault() {
		/*if (isset($_POST[$this->modelName])) {
			$cats = $_POST[$this->modelName]['Categories'];
			$brands = $_POST[$this->modelName]['Brands'];
			$criteria = new CDbCriteria();
			$criteria->with('categories');
			if(!empty($cats))
				$criteria->addInCondition('categories.id', $cats);
			if(!empty($brands))
				$criteria->addInCondition('manufacturer.id', $brands);
			$criteria->order = 't.id DESC';
			//$criteria->params = array (':id'=>$id);
			   
			$item_count = Product::model()->count($criteria);
					
			$pages = new CPagination($item_count);
			//$pages->setPageSize(Yii::app()->params['listPerPage']);
			$pages->setPageSize(12);
			$pages->applyLimit($criteria);  // the trick is here!
			
			$this->render('default',array(
						'products'=> Product::model()->findAll($criteria), // must be the same as $item_count
						'item_count'=>$item_count,
						//'page_size'=>Yii::app()->params['listPerPage'],
						'page_size'=>12,
						'items_count'=>$item_count,
						'pages'=>$pages,
			));
			Yii::app()->end();
		}*/
		
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
	
	public function paginate($link = null) {
		$criteria = new CDbCriteria();
		//$params= array();
		$with = array('categories', 'categories.categoryDescriptions' ,'categories.parent' => array('alias' => 'd1'), 'categories.parent.categoryDescriptions' => array('alias' => 'd2'));
		$criteria->order = 't.date_modified DESC';
		if(isset($_GET['sort'])){
			if($_GET['sort'] == 'lprice')
				$criteria->order = 't.price ASC';
			if($_GET['sort'] == 'hprice')
				$criteria->order = 't.price DESC';
			if($_GET['sort'] == 'arrival')
				$criteria->order = 't.date_added DESC';
			if($_GET['sort'] == 'name')
				$criteria->order = 'categoryDescriptions.name ASC';
			if($_GET['sort'] == 'brand'){
				$with[] = 'brand';				
				$criteria->order = 'brand.name ASC';
			}
		}
			
		
		if(!empty($link)){						
			$criteria->condition = 'categoryDescriptions.link = :link OR d2.link = :link2';			
			$criteria->params[':link'] = $link;	
			$criteria->params[':link2'] = $link;	
		}
		
		if(isset($_GET['type'])){
			if($_GET['type'] == 'arrival'){
				$criteria->addCondition('t.date_added > :twowks');
				$criteria->params[':twowks'] = date( "Y-m-d h:m:s", strtotime( "-1 month"));
			}
			else if($_GET['type'] == 'on_sale'){
				$with[] = 'productSpecials';	
				$cgroups = array(3,2,1);
				//$cgroups[] = 1;
				/*
				$groups = Yii::app()->user->groups;
				foreach($groups as $group)
					$cgroups[] = $group->id;
				*/
				$criteria->addInCondition('productSpecials.c_group_id', $cgroups);
			}
			else if($_GET['type'] == 'top_seller'){
				$with[] = 'orderCount';
				$criteria->order = 'qsum DESC';
			}
		}
		
		/*if(!empty($params)){
			$criteria->params = $params;	
		}*/
		if(isset($_GET['search'])){
			$with[] = 'productDescriptions';		
			$criteria->addSearchCondition('productDescriptions.name', $_GET['search']);
		}
		if(isset($_GET['brand'])){
			if(!in_array('brand',$with))
				$with[] = 'brand';		
			$criteria->addSearchCondition('brand.name', $_GET['brand']);
		}
		
		if(isset($_GET['minValue']) && isset($_GET['maxValue']) && is_numeric($_GET['minValue']) && is_numeric($_GET['maxValue'])){
			$criteria->addCondition('t.price <= :maxValue');
			$criteria->addCondition('t.price >= :minValue');
				$criteria->params[':minValue'] = $_GET['minValue'];
				$criteria->params[':maxValue'] = $_GET['maxValue'];
		}
		//exclude products that are out of stock
		$criteria->addCondition('t.quantity > 0');
		
		if(!empty($with)){
			$criteria->with = $with;
			$criteria->together = true;
		}
		$criteria->distinct  = true;
		$criteria->group='t.id';
        $item_count = Product::model()->count($criteria);

		$pages = new CPagination($item_count);
		//$pages->setPageSize(Yii::app()->params['listPerPage']);
		$pages->pageSize = 12;
		
		$pages->applyLimit($criteria);
		$products = Product::model()->findAll($criteria);
		$this->render('default',array(
					'products'=> $products, // must be the same as $item_count
					'pages'=>$pages,
		));
	}
}
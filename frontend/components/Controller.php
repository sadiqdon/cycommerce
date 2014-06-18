<?php
/**
 * Controller.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:55 AM
 */
class Controller extends CController {

	public $layout='//layouts/column3';

	public $breadcrumbs = array();
	public $menu = array();
	public $location = 'frontend';
	
	// Sets the path alias of the current theme directory
	public function init(){
		if(isset(Yii::app()->theme->basePath))
			Yii::SetPathOfAlias('themealias', Yii::app()->theme->basePath);
	}
	
	public function getCurrentCategoryLink(){
		if(empty($_GET['category']) || $_GET['category'] == 'all')
				return 'all';
		else if(!empty($_GET['subcategory']))
			return $_GET['subcategory'];
		else if(!empty($_GET['category']))
			return $_GET['category'];
		return null;
	}
	
	public function getCurrentCategory(){
		$link = $this->getCurrentCategoryLink();
		$cat = Category::model()->with('categoryDescriptions')->find('categoryDescriptions.link=:link',array(':link'=>$link));
		return $cat;
	}
	
	public static function getCategoryParams(){
		$params = array();
		if(empty($_GET['category']) || $_GET['category'] == 'all')
				$params['category'] = 'all';
		else if(!empty($_GET['subcategory'])){
			$params = array('category'=>$_GET['category'],'subcategory'=>$_GET['subcategory']);
		}else if(!empty($_GET['category'])){
			$params['category'] = $_GET['category'];
		}
		return $params;
	}
	public function productImageThumb($id) {
		$p = Product::model()->findByPk($id);
		if(!empty($p)){
			$imgs = $p->images;
			if(isset($imgs[0]->source))
				return $imgs[0]->source;
		}
		return;
	}
	
	
	
	public function loadProductOption($id){
		$_productoption = array();
		$data = ProductOption::model()->findAll('product_id=:product_id', array(':product_id'=>$id));
		if(!empty($data))
			foreach($data as $productoption){
				$value = ProductOptionValue::model()->findAll('product_option_id=:product_option_id', array(':product_option_id'=>$productoption->id));
				$_productoption[] = array($productoption, $value);
			}
		return $_productoption;
	}
	
	public function getCart() {
		return Yii::app()->user->getState('user_cart');
	}
	
	public function getCartItems() {
		$cart = $this->getCart();
		if(!empty($cart['items']))
			return $cart['items'];
		return;
	}
	
	public function getCartCount() {
		$cart = $this->getCart();
		if(!empty($cart['items']))
			return count($cart['items']);
		return 0;
	}
	
	public function getSort(){
		if(isset($_GET['sort']))
			return $_GET['sort'];
		return;
	}
	
}

<?php
class CategoryNavigation extends CWidget {
	//public $categoryID;
	public $current = 'all';
	
	
    public function run() {
		$inn = false;
		$cat = Category::model()->with('categoryDescriptions')->find('categoryDescriptions.link=:link',array(':link'=>$this->current));
		if(!empty($cat)){
		$catName = $cat->getName();
		$categories = $cat->categories;
		if(empty($categories)){
			$categories = array($cat);
			$inn = true;
		}
		//echo print_r($categories);
		}
		else{
			$catName = 'All';
			$categories = Category::model()->findAll();
		}
		$products = array();
		$nbrands = $brands= array();
		foreach($categories as $category)
			$products = array_merge($products, $category->products);
		foreach($products as $product)
			$nbrands[] = $product->manufacturer_id;

		$nbrands = array_unique($nbrands,SORT_NUMERIC);
		foreach($nbrands as $nbrand){
			$manu = Manufacturer::model()->findByPk($nbrand);
			if(!empty($manu))
				$brands[$nbrand] = $manu->name;
		}
		//$brands = asort($brands);
		 
        $this->render('category_navigation',array('inn'=>$inn, 'cat'=>$cat, 'name'=>$catName, 'categories'=>$categories, 'products'=>$products, 'brands'=>$brands, 'current'=>$this->current));
		
    }
 
}
?>
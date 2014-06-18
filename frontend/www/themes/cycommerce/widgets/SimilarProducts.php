<?php
class SimilarProducts extends CWidget {
	public $product_id;
	
    public function run() {
		if(!empty($this->product_id)){
			$product = Product::model()->findByPk($this->product_id);		
			$products = $product->relatedA;
			//echo count($products);
			if(empty($products)){
				//$products = array();
				$categories = $product->categories;
				foreach($categories as $category)
					$products = array_merge($products, $category->products);
				$products = $categories[0]->products;
			}
			$this->render('similar_products',array('products'=>$products));
		}
    }
 
}
?>
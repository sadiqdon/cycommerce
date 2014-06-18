<?php
class RelatedBlock extends CWidget {
	public $cart;
	
    public function run() {
		if(!empty($this->cart)){
			shuffle($this->cart);
			$product = Product::model()->findByPk($this->cart[0]['product_id']);		
			$products = $product->relatedA;
			//echo count($products);
			if(empty($products)){
				//$products = array();
				$categories = $product->categories;
				foreach($categories as $category)
					$products = array_merge($products, $category->products);
				$products = $categories[0]->products;
			}
			$this->render('related_block',array('products'=>$products));
		}
        else
			$this->render('column2_home');
    }
 
}
?>
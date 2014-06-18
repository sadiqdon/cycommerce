<?php
class ProductBlock extends CWidget {
	
    public function run() {
		$cats = Category::model()->findAllByAttributes(array(),'top=1');
		$products = array();
		shuffle($cats);
		foreach($cats as $cat){
			$products = $cat->products;
			if(!empty($products))
				break;
		}
        $this->render('productblock',array('products'=>$products, 'category'=>$cat));
    }
 
}
?>
<?php
class SearchBlock extends CWidget {
	public $current;
	public $currentLink = 'all';
	
    public function run() {
		$models = Category::model()->findAll();
        $this->render('search_block',array('current'=>$this->current, 'currentLink'=>$this->currentLink, 'categories'=>Category::model()->with('categoryDescriptions')->findAll(array('order'=>'categoryDescriptions.name', 'condition'=>'t.top = 1'))));
    }
 
}
?>
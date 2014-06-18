<?php
class LeftNavigation extends CWidget {
	public $current = 'all';
	
    public function run() {
		$models = Category::model()->findAll();
        $this->render('leftNavigation',array('models'=>$models, 'current'=>$this->current));
    }
 
}
?>
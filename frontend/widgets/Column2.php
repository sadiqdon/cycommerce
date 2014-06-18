<?php
class Column2 extends CWidget {
	public $state = '';
	
    public function run() {
		$models = Category::model()->findAll();
		if(strtolower($this->state) == 'home')
			$this->render('column2_home');
		else if(strtolower($this->state) == 'category')
			$this->render('column2_category');
		else if(strtolower($this->state) == 'checkout')
			$this->render('column2_checkout');
		else if(strtolower($this->state) == 'information')
			$this->render('column2_information');
    }
 
}
?>
<?php
class Footer extends CWidget {
	
    public function run() {
		$models = Page::model()->findAll();
        $this->render('footer',array('models'=>$models));
    }
 
}
?>
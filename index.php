<?php
	ob_start();
	
	if(!file_exists('common/config/main-env.php')){
		header("Location: backend/www/install");
		exit();
	}else{
		header("Location: backend/www/");
		exit();
	}
	

	ob_end_flush();
?>
<?php
	require_once('VIEWS/confirm.php');
	require_once('install.php');
	
	$install = new Install();
	$install->readyConfigFile($_POST['host'],$_POST['name'],$_POST['username'],$_POST['password'],$_POST['db_type']);

?>
<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="cycommerce">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Install cyCommerce</title>
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
  </head>
  <body>
    <noscript>
		<h1>This page needs javascript to work properly.</h1>
  </noscript>
    <div class="container">
<?php	
	if(file_exists('../../../common/config/main-env.php')){
	echo '<div class="col-md-4">
	</div>
	<div class="col-md-4">';
	require_once('VIEWS/success.php');
	echo '</div>	
	<div class="col-md-4">
	</div>';
	}else if(isset($_POST['submit'])){
		$_SESSION['db_type'] = $_POST['db_type'];
		$_SESSION['host'] = $_POST['host'];
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		
		require_once('VIEWS/confirm.php');
	}else if(isset($_GET['message'])){
				echo('<div class="alert alert-warning" style="width: 200px;">
					<p> ' .  $_GET['message'] . ' </p><br/>
					<a class="btn btn-primary" href="index.php">Back</a>
				</div>');
	}else{
		header("Location: index.php");
		exit();
	}
?>
  </div>
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		$('#database_type').tooltip('toggle')
	</script>
  </body>
</html>
<?php ob_end_flush(); ?>

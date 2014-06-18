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
				if(file_exists('install.php') || file_exists('setup.php') || file_exists('VIEWS/install-form.php')){
					unlink("install.php");
					unlink("setup.php");
					unlink("VIEWS/install_form.php");
					unlink("VIEWS/confirm.php");
				}
			}else{
				if(file_exists('VIEWS/install_form.php')){
					require_once('VIEWS/install_form.php');
				}else{
					echo("
					<div class='col-md-12'>
						<div class='alert alert-danger'>
							<p>Error : The main-env.php file is missing. You might have deleted this file. Please restore this file and if the problem persist delete this copy of cycommerce and reinstall using the same database credentials </p>
						</div>
					</div>	
						");
				}
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

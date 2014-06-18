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
    <div class="container" style="padding-top: 1.5%;">
		<div class="form-signin2 alert alert-warning">
			<blockquote id="ajaxBox">
				<h2>Confirm details.</h2><br/>
				<p>Database System : <span id='db_type'><?php echo $_SESSION['db_type']; ?></span></p>
				<p>Database Host : <span id='host'><?php echo $_SESSION['host']; ?></span></p>
				<p>Database Name : <span id='name'><?php echo $_SESSION['name']; ?></span></p>
				<p>Database Username: <span id='username'><?php echo $_SESSION['username']; ?></span></p>
				<p>Database Password  : <span id='password'><?php echo $_SESSION['password']; ?></span></p>
				<br/>
				<a class='btn btn-primary pull-left' href='index.php'>Back</a>
				<a class='btn btn-success pull-right' href='#' onclick='startCounter()'>Proceed</a>
				<div class='clearfix'></div>
			<br/><div class="progress progress-striped">
				<div id="countCon" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" >
					<span id="count"> </span>
					
				</div>
			</div>			</blockquote>
		</div>
  </div>
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
  </body>
</html>

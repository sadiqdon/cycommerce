      <form action="ready.php" method="post" class="form-signin alert-success">
        <h2 class="form-signin-heading"><img class='img-responsive img-thumbnail' src='img/logo.png' alt='cyCommerce' title='Installation' /></h2>
		<?php 
			if(isset($_GET['message'])){
				echo('<div class="alert alert-warning">
					<p> ' .  $_GET['message'] . ' </p>
				</div>');
			}
		?>
		<select class="form-control" required name="db_type" id="database_type"  data-toggle="tooltip" data-placement="right" title="Please choose verified options. Others database system have not been tested.">
			<option value="">Select a database type</option>
			<option value="MySQL">MySQL : verified</option>
			<option value="PostgreSQL">PostgreSQL</option>
			<option value="SQL Server">SQL Server</option>
			<option value="Oracle">Oracle</option>
		</select>
		<br/>
		<input type="text" name="host" class="form-control" placeholder="Database Host" autofocus required><br/>
		<input type="text" name="name" class="form-control" placeholder="Database Name" required><br/>
		<input type="text" name="username" class="form-control" placeholder="Database Username" required><br/>
		<input type="password" name="password" class="form-control" placeholder="Database Password" required><br/>
        <button name="submit" class="btn btn-lg btn-warning btn-block" type="submit" id="wait">Install</button>
      </form>
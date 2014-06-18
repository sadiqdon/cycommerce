<?php

class Install{
	
	private $configDir = '../../../common/config/';
	private $configFile = 'main-env.php';
	private $dbDriver_mysql = 'mysql:host';
	private $dbDriver_oracle = 'OCI:dbname=';
	private $returnPage = 'index.php';
	private $errorPage = 'ready.php';
	private $databaseDriver ;
	public $port = 5432 ;
	private $handle;
	private $content;
	const MYSQLDATA = 'data/mysql.sql';
	const MS_SQLDATA = 'data/ms_sql.sql';
	const ORACLEATA = 'data/oracle.sql';
	const POSTGREDATA = 'data/postgre.sql';
	
	public function __construct() {
		ob_start();
    }
	
	
	public function readyConfigFile($host,$dbName,$username, $password ,$dbType){
		try{
			set_time_limit (300);
			$insertTables;
			$file = $this->configDir . $this->configFile;
			switch($dbType){
				case 'MySQL';
					$insertTables = new PDO("{$this->dbDriver_mysql}={$host};dbname={$dbName}", $username, $password);
					$insertTables->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->databaseDriver = "mysql:host{$host}=;dbname={$dbName}";
					$this->handle = fopen(self::MYSQLDATA, "r");
					$this->content = fread($this->handle, filesize(self::MYSQLDATA));
					break;
				case 'Oracle';
					$insertTables =  new PDO("{$this->dbDriver_oracle}{$dbName};charset=UTF-8", "{$username}", "{$password}");
					$insertTables->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->databaseDriver = "oci:dbname=//{$host}/{$dbName}";
					$this->handle = fopen(self::ORACLEDATA, "r");
					$this->content = fread($this->handle, filesize(self::ORACLEDATA));
					break;
				case 'PostgreSQL';
					$insertTables = new PDO("pgsql:dbname={$dbName};host={$host}", "{$username}", "{$password}" );
					$insertTables->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->databaseDriver = "pgsql:host={$host};port={$this->port};dbname={$dbName}";
					$this->handle = fopen(self::POSTGREDATA, "r");
					$this->content = fread($this->handle, filesize(self::POSTGREDATA));
					break;
				case 'SQL Server';
					$insertTables = new PDO ("dblib:host={$host}:{$this->port};dbname={$dbName}","{$username}","{$password}");
					$insertTables->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->databaseDriver = "mssql:host=localhost;dbname=testdb";
					$this->handle = fopen(self::MS_SQLDATA, "r");
					$this->content = fread($this->handle, filesize(self::MS_SQLDATA));
					break;
				default;
					header("Location: {$this->errorPage}?message=Database Type not supported");
					exit();
			}
			
			$insertTables->beginTransaction();
			$checkDatabaseParam = $insertTables->quote($dbName);
			if($query = $insertTables->query("SELECT COUNT(DISTINCT table_name) AS count FROM information_schema.columns WHERE table_schema = {$checkDatabaseParam} ")){
				foreach($query as $result){
					$count = $result['count'];
				}
				
				if($count != 0){
					header("Location: {$this->errorPage}?message=The database {$dbName} is not empty. Cycommerce needs an empty database");
					exit();
				}
				if($count == 0 && $insertTables->query($this->content)){
					$insertTables->commit();
					$_SESSION['db_type'] =  null;
					$_SESSION['host'] =  null;
					$_SESSION['name'] =  null;
					$_SESSION['username'] =  null;
					$_SESSION['password'] =  null;
					file_put_contents($file, $this->getConfigTemplate($host,$dbName,$username,$password));
					echo '
						<script>
							location.replace("index.php");	
						</script>
					';
					//header("Location: {$this->returnPage}");
					//exit();
				}else{
					$insertTables->rollback();
					header("Location: {$this->errorPage}?message=Unable to insert tables.");
					exit();
				}
			}
			$insertTables = null;
		}catch(Exception $e){
			header("Location: {$this->errorPage}?message={$e->getMessage()}");
			exit();
		}
	}
	
	
	private function getConfigTemplate($host,$dbName,$username,$password){
		return 	"
<?php

		
/**
 * prod.php
 * Created " . Date('d/m/y') ."
 * Common parameters for the application on production
 */
return array(
	'components' => array(
		// DB connection configurations. Set proper credentials for you application
		'db' => array(
			'connectionString' => '{$this->databaseDriver}',
			'username' => '{$username}',
			'password' => '{$password}',
		)
	),
	'params' => array(
		'env.code' => 'prod'
	)
);

?>
" ;
	
	}
	
	public function __destruct() {
		fclose($this->handle);
		ob_end_flush();
    }

}

	
?>
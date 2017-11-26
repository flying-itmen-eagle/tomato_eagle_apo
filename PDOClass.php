<?php 

require_once __DIR__ . "/dataBaseConfig.php";

class db {
	use Config;

	
	private static $dbType = 'mysql';
	private $dbHost = '';
	private $dbPort = '';	
	private $dbName = '';
	private $dbUser = '';
	private $dbPassword = '';

	public $pdo;
	

	function __construct(){
		
		$this->dbHost = $this->conn['dbHost'];
		$this->dbName = $this->conn['dbName'];
		$this->dbUser = $this->conn['dbUser'];
		$this->dbPassword = $this->conn['dbPassword'];	

		$this->combineDSN($this->dbHost, $this->dbName, $this->dbUser, $this->dbPassword);
	}

	private function combineDSN($dbHost, $dbName, $dbUser, $dbPassword){

		$dsn = self::$dbType.':host='.$dbHost.';dbname='.$dbName;
		$this->conn($dsn,$dbUser,$dbPassword);
	}

	private function conn($dsn, $user, $password) {
	    
	    try{
	    	$this->pdo = new PDO($dsn, $user, $password, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));	    

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	    }catch(PDOException $ex){
	    	print_r($ex);
	    }
	}


	public function Init($query, $parameters = ""){

		# Prepare query
        $this->sQuery = $this->pdo->prepare($query);
        
        # Add parameters to the parameter array	
        $this->bindMore($parameters);

	}

}


$POD = New db();
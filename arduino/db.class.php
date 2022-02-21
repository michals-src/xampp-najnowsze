<?php
/*
 * Class DBConnection
 * Create a database connection using PDO
 * @author jonahlyn@unm.edu
 *
 * Instructions for use:
 *
 * require_once('settings.config.php');          // Define db configuration arrays here
 * require_once('DBConnection.php');             // Include this file
 *
 * $database = new DBConnection($dbconfig);      // Create new connection by passing in your configuration array
 *
 * $sqlSelect = "select * from .....";           // Select Statements:
 * $rows = $database->getQuery($sqlSelect);      // Use this method to run select statements
 *
 * foreach($rows as $row){
 * 		echo $row["column"] . "<br/>";
 * }
 *
 * $sqlInsert = "insert into ....";              // Insert/Update/Delete Statements:
 * $count = $database->runQuery($sqlInsert);     // Use this method to run inserts/updates/deletes
 * echo "number of records inserted: " . $count;
 *
 * $name = "jonahlyn";                          // Prepared Statements:
 * $stmt = $database->dbc->prepare("insert into test (name) values (?)");
 * $stmt->execute(array($name));
 *
 */
Class dbh {
    
	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $charset;
	private $error;

	public function __construct(){

		$this->error = false;

		$this->servername = "localhost";
		$this->username = "root";
		$this->password = "";
		$this->dbname = "esp8266";
		$this->charset = "utf8mb4";

	}

	public function Exception(){
		return $this->error;
	}

	public function getConnection(){
		try{
			$dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname . ";charset=" . $this->charset . ";";
			$pdo = new PDO( $dsn, $this->username, $this->password );
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}catch( PDOException $e ){
			$this->error = true;
		}
	}


}
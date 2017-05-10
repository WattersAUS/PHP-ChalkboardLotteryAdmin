<?php
//
// Module: connect.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
// 2017-05-10 v0.01   Use mySqli not PDO
//
class Connect {
    private $hostname = "";
    private $username = "";
    private $password = "";
    private $database = "";

    public  $dbConnection;

    public function createConnection() {
	$this->dbConnection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($this->dbConnection->connect_error) {
            die('Connection Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
        }
        return $this->dbConnection;
    }
}
?>

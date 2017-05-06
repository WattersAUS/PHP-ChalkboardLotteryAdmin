<?php
//
// Module: connect.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
//
class Connect {

    // specify your own database credentials
    private $hostname      = "";
    private $databasename  = "";
    private $username      = "";
    private $password      = "";
    public  $dbConnection;

    public function newConnection() {
        $this->dbConnection = null;
        try {
            $this->dbConnection = new PDO("mysql:host=".$this->hostname.";dbname=".$this->databasename, $this->username, $this->password);
            $this->dbConnection->exec("set names utf8");
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->dbConnection;
    }
}
?>

<?php
//
// Module: lottery_read_all.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
// 2017-05-10 v0.02   Simply return results from lottery class (JSON)
// 2017-05-16 v0.03   Change allow method to GET
//
header("Content-Type: application/json; charset=UTF-8");

include_once './config/connect.php';
include_once './lottery.php';

$connect = new Connect();
$dbconn  = $connect->createConnection();
$lottery = new Lottery($dbconn);
echo($lottery->readAll());
?>

<?php
//
// Module: lottery_enable.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
// 2017-05-15 v0.02   Updated code to support JSON import
//
header("Content-Type: application/json; charset=UTF-8");

include_once './config/connect.php';
include_once './lottery.php';

$connect = new Connect();
$dbconn  = $connect->createConnection();
$lottery = new Lottery($dbconn);
$id      = isset($_GET['id']) ? $_GET['id'] : die();
echo($lottery->enable($id));
?>

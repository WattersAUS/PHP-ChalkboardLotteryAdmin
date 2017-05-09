<?php
//
// Module: disable_lottery.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
//
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './config/connect.php';
include_once './lottery.php';

$connect        = new Connect();
$lottery        = new Lottery($connect->newConnection());
$data           = json_decode(file_get_contents("php://input"));
$lottery->ident = $data->ident;

if ($lottery->disable()) {
    echo '{';
    echo '"message": "Lottery has been disabled!"';
    echo '}';
} else {
    echo '{';
    echo '"message": "Lottery was not disabled!"';
    echo '}';
}
?>

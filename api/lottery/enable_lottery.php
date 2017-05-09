<?php
//
// Module: enable_lottery.php (2017-05-06) G.J. Watson
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

include_once '../config/database.php';
include_once '../objects/lottery.php';

$database       = new Database();
$db             = $database->getConnection();
$lottery        = new Lottery($db);
$data           = json_decode(file_get_contents("php://input"));
$lottery->ident = $data->ident;

if ($lottery->enable()) {
    echo '{';
    echo '"message": "User was enabled."';
    echo '}';
} else {
    echo '{';
    echo '"message": "User was not enabled."';
    echo '}';
}
?>

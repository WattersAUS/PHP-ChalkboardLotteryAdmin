<?php
//
// Module: read_lottery.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
//
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/user.php';

$database       = new Database();
$dbConnection   = $database->newConnection();
$user           = new LotteryDraw($db);
$lottery->ident = isset($_GET['id']) ? $_GET['id'] : die();

$user->readLottery();

// create array
$user_arr = array(
    "id"            => $user->id,
    "first_name"    => $user->first_name,
    "last_name"     => $user->last_name,
    "start_date"    => $user->start_date,
    "end_date"      => $user->end_date,
    "email_address" => $user->email_address,
    "password"      => $user->password
);

// make it json format
print_r(json_encode($user_arr));
?>

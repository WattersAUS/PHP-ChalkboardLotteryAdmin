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

include_once './config/database.php';
include_once './lottery.php';

$database       = new Database();
$dbConnection   = $database->newConnection();
$lottery        = new Lottery($db);
$lottery->ident = isset($_GET['id']) ? $_GET['id'] : die();
$lottery->readLottery();

$lottery_arr = array(
    "ident"        => $ident,
    "description"  => $description,
    "draw"         => $draw,
    "numbers"      => $numbers,
    "upperNumber"  => $upperNumber,
    "numbersTag"   => $numbersTag,
    "specials"     => $specials,
    "upperSpecial" => $upperSpecial,
    "specialsTag"  => $specialsTag,
    "isBonus"      => $isBonus,
    "baseUrl"      => $baseUrl,
    "lastModified" => $lastModified,
    "endDate"      => $endDate
);

print_r(json_encode($lottery_arr));
?>

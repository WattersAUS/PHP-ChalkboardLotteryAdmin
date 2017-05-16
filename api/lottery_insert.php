<?php
//
// Module: lottery_insert.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
// 2017-05-15 v0.02   Renamed from lottery_create.php
//
header("Content-Type: application/json; charset=UTF-8");

include_once './config/connect.php';
include_once './lottery.php';

$connect = new Connect();
$dbconn  = $connect->createConnection();
$lottery = new Lottery($dbconn);
$data    = json_decode(file_get_contents("php://input"));

$lottery->$description  = $data->description;
$lottery->$draw         = $data->draw;
$lottery->$numbers      = $data->numbers;
$lottery->$upperNumber  = $data->upperNumber;
$lottery->$numbersTag   = $data->numbersTag;
$lottery->$specials     = $data->specials;
$lottery->$upperSpecial = $data->upperSpecial;
$lottery->$specialsTag  = $data->specialsTag;
$lottery->$isBonus      = $data->isBonus;
$lottery->$baseUrl      = $data->baseUrl;
echo($lottery->insert());
?>

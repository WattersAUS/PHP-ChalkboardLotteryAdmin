<?php
//
// Module: read_all_lottery.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
//
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once './config/connect.php';
include_once './lottery.php';

$connect  = new Connect();
$lottery  = new Lottery($connect->newConnection());
$stmt     = $lottery->readAll();
$num      = $stmt->rowCount();
if ($num > 0) {
    $lottery_arr            = array();
    $lottery_arr["records"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $lottery_item=array(
            "ident"        => $ident,
            "description"  => $description,
            "draw"         => $draw,
            "numbers"      => $numbers,
            "upperNumber"  => $upper_number,
            "numbersTag"   => $numbers_tag,
            "specials"     => $specials,
            "upperSpecial" => $upper_special,
            "specialsTag"  => $specials_tag,
            "isBonus"      => $is_bonus,
            "baseUrl"      => $base_url,
            "lastModified" => $last_modified,
            "endDate"      => $end_date
        );
        array_push($lottery_arr["records"], $lottery_item);
    }
    echo json_encode($lottery_arr);
} else {
    echo json_encode(array("message" => "No lottery data found!"));
}
?>

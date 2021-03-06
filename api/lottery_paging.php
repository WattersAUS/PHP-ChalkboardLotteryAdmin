<?php
//
// Module: paging_lottery.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
//
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once './config/connect.php';
include_once './lottery.php';

$connect  = new Connect();
$lottery  = new Lottery($connect->newConnection());
$stmt     = $lottery->readPaging($from_record_num, $records_per_page);
$num      = $stmt->rowCount();

if ($num > 0) {
    $lottery_arr            = array();
    $lottery_arr["records"] = array();
    $lottery_arr["paging"]  = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $lottery_item = array(
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
        array_push($lottery_arr["records"], $lottery_item);
    }

    // paging
    $util                  = new Utilities();
    $lottery_arr["paging"] = $utils->getPaging($page, $lottery->count(), $records_per_page, "{$home_url}lottery/read_paging.php?");
    echo json_encode($lottery_arr);
} else {
    echo json_encode( array("message" => "No lottery records found!"));
}
?>

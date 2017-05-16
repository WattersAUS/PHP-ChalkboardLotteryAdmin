<?php
//
// Module: test_lottery.php (2017-05-06) G.J. Watson
//
// Purpose: test harness for lottery class.
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-10 v0.01   First cut of code
//
include_once '../api/config/connect.php';
include_once '../api/lottery.php';

function decodeCountMessage($json) {
    $data = json_decode($json, true);
    if ($data['success'] != "Ok") {
        echo("Failed to complete SQL call...\n\n");
        exit();
    }
    echo("Success: ".$data['count']." returned count...\n");
    return;
}

function decodeReadMessage($json) {
    $data = json_decode($json, true);
    if ($data['success'] != "Ok") {
        echo("Failed to complete SQL call...\n\n");
        exit();
    }
    echo("Success: ".$data['count']." affected records...\n");
    $records = $data['records'];
    foreach ($records as $rec) {
        $row = "Row:";
        foreach ($rec as $key => $value) {
            $row .= "\n\t".$key." : ".$value;
        }
        echo($row."\n");
    }
    return;
}

function decodeInsertMessage($json) {
    $data = json_decode($json, true);
    if ($data['success'] != "Ok") {
        echo("Failed to complete SQL call...\n\n");
        exit();
    }
    echo("Success: ".$data['count']." affected record, new Id ".$data['recordId']." added to table...\n");
    return $data['recordId'];
}

function decodeGenericMessage($json) {
    $data = json_decode($json, true);
    if ($data['success'] != "Ok") {
        echo("Failed to complete SQL call...\n\n");
        exit();
    }
    echo("Success: ".$data['count']." affected record...\n");
    return;
}

$connect = new Connect();
$dbconn  = $connect->createConnection();
$lottery = new Lottery($dbconn);

echo ("Calling: count()\n");
$json = $lottery->count();
decodeCountMessage($json);
echo("\n");

echo ("Calling: readAll\n");
$json = $lottery->readAll();
decodeReadMessage($json);
echo("\n");

echo ("Calling: read(1)\n");
$json = $lottery->read(1);
decodeReadMessage($json);
echo("\n");

echo ("Calling: search(o)\n");
$json = $lottery->search("o");
decodeReadMessage($json);
echo("\n");

echo ("Calling: readPage(0,3)\n");
$json = $lottery->readPage(0,3);
decodeReadMessage($json);
echo("\n");

echo ("Calling: readPage(1,3)\n");
$json = $lottery->readPage(1,3);
decodeReadMessage($json);
echo("\n");

echo ("Calling: readPage(2,3)\n");
$json = $lottery->readPage(2,3);
decodeReadMessage($json);
echo("\n");

/*

echo ("Calling: insert()\n");
$lottery->description   = "Testing";
$lottery->draw          = 999;
$lottery->numbers       = 6;
$lottery->upperNumber   = 99;
$lottery->numbersTag    = "number";
$lottery->specials      = 3;
$lottery->upperSpecial  = 9;
$lottery->specialsTag   = "special";
$lottery->isBonus       = 0;
$lottery->baseUrl       = "http://www.testing.co.uk/? = something";
$json = $lottery->insert();
$recId = decodeInsertMessage($json);
if ($recId == -1) {
    exit();
}
echo("\n");

echo ("Calling: disable(".$recId.")\n");
$json = $lottery->disable($recId);
decodeGenericMessage($json);
echo("\n");

echo ("Calling: read(".$recId.")\n");
$json = $lottery->read($recId);
decodeReadMessage($json);
echo("\n");

echo ("Calling: enable(".$recId.")\n");
$json = $lottery->enable($recId);
decodeGenericMessage($json);
echo("\n");

echo ("Calling: read(".$recId.")\n");
$json = $lottery->read($recId);
decodeReadMessage($json);
echo("\n");

echo ("Calling: update(".$recId.")\n");
$lottery->description   = "Test Updated";
$lottery->draw          = 1001;
$lottery->numbers       = 9;
$lottery->upperNumber   = 200;
$lottery->numbersTag    = "numberss";
$lottery->specials      = 5;
$lottery->upperSpecial  = 20;
$lottery->specialsTag   = "specialss";
$lottery->isBonus       = 0;
$lottery->baseUrl       = "https://www.test.co.uk/?=updated";
$json = $lottery->update($recId);
decodeGenericMessage($json);
echo("\n");

echo ("Calling: read(".$recId.")\n");
$json = $lottery->read($recId);
decodeReadMessage($json);
echo("\n");

echo ("Calling: delete(".$recId.")\n");
$json = $lottery->delete($recId);
decodeGenericMessage($json);
echo("\n");

*/

?>

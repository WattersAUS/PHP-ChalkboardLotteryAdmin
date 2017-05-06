<?php
//
// Module: search_lottery.php (2017-05-06) G.J. Watson
//
// Purpose: class to support lottery_draws table
//
// Date       Version Note
// ========== ======= ================================================
// 2017-05-06 v0.01   First cut of code
//
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

// instantiate database and product object
$database = new Database();
$db       = $database->getConnection();
$user     = new User($db);

// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query products
$stmt = $user->search($keywords);
$num  = $stmt->rowCount();
if ($num > 0) {
    $users_arr            = array();
    $users_arr["records"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $user_item=array(
            "id"            => $id,
            "first_name"    => $first_name,
            "last_name"     => $last_name,
            "start_date"    => $start_date,
            "end_date"      => $end_date,
            "email_address" => $email_address,
            "password"      => $password
        );
        array_push($users_arr["records"], $user_item);
    }
    echo json_encode($users_arr);
} else {
    echo json_encode(array("message" => "No users found."));
}
?>

<?php

/*      ~/api/item/insert.php      */

header("Access-Control-Allow-Origin: *");
header("Content-Type: Application/json; charset=UTF-8");

include_once "../config/dbclass.php";
include_once "../classes/item.php";

$conn = DBClass::getInstance();

//$_POST = json_decode(file_get_contents('php://input'), true);

$item = new Item($conn);

echo json_encode(
    array(
        "result" => $item->insert($_POST['cat_id'],$_POST['item_id'],$_POST['item_name'],$_POST['qty'],$_POST['cost'])
    )
);

?>
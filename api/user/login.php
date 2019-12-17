<?php

/*     ~/api/user/register.php     */

header("Access-Control-Allow-Origin: *");
header("Content-Type: Application/json; charset=UTF-8");

include_once "../config/dbclass.php";
include_once "../classes/user.php";

$conn = DBClass::getInstance();

$_POST = json_decode(file_get_contents('php://input'), true);

$user = new user($conn);

echo json_encode(
    array(
        "result" => $user->login($_POST['username'], $_POST['password'])
        )
    );

?>
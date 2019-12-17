<?php

/*      ~/api/item/read.php      */

header("Access-Control-Allow-Origin: *");
header("Content-Type: Application/json; charset=UTF-8");

include_once "../config/dbclass.php";
include_once "../classes/item.php";

$conn = DBClass::getInstance();

$_POST = json_decode(file_get_contents('php://input'), true);

//echo json_encode(array('$_POST' => $_POST));

$item = new Item($conn);

if($_POST['func'] == 1 || $_POST == null)
{
    $result = $item->list_all();
    $num = $result->num_rows;

}
else if($_POST['func'] == 2)
{
    $result = $item->search_by_value($_POST['rows'], $_POST['values']);
    $num = $result->num_rows;
}

if($num > 0)
{
	$item_array = array();
	$item_array["records"] = array();

	while($row = $result->fetch_assoc())
	{
		extract($row);

		$item_record = array(
			"cat_id" => $cat_id,
			"item_id" => $item_id,
            "item_name" => $item_name,
			"qty" => $qty,
			"cost" => $cost
		);

		array_push($item_array["records"], $item_record);
	}

	http_response_code(200);

	echo json_encode($item_array);
}
else
{
	//http_response_code(404);

	echo json_encode(array("message" => "No items found. "));
}


/**/

?>
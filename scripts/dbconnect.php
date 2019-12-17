<?php

function connect(&$con)
{
    $con = mysqli_connect("sql312.epizy.com", "epiz_24527158", "v21LRFqXdNWE", "epiz_24527158_spotsale");

    if(mysqli_connect_errno())
    {
        //echo json_encode(array("message" => "Failed to connect to MySQL: " . mysqli_connect_error());
    }
    else
    {
        //echo json_encode(array("message" => "Connected successfully !!!!!!"));
    }
}

?>
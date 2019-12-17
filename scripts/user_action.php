<?php

function login(&$con)
{
    $uname = $_GET["username"];

    //echo "select * from User where user_name='$uname'";

    $sql = $con->prepare("select * from User where user_name=?");
    $sql->bind_param("s", $uname);
    $sql->execute();

    $result = $sql->get_result();

	//header('Content-Type:Application/json');

    while($row = mysqli_fetch_assoc($result))
    {
        //$array[] = $row;
        echo json_encode($row);
    }

    //echo json_encode($array);
}

function register(&$con)
{
    $email = $_GET["email"];

    $sql = "insert into User(email) values('$email')";

    if($con->query($sql) === TRUE)
    {
        echo "Inserted Successfully !!";
    }
    else
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>
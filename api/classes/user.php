<?php

class User
{
	//Connection Instance
	private $connection;

	//Table Name
	private $table_name = "User";

	//Table Columns
	public $user_id;
	public $user_name;
	public $f_name;
	public $l_name;
	public $e_mail;
	public $address1;
	public $address2;
	public $address3;

	//Constructor
	public function __construct($connection)
	{
		$this->connection = $connection;
	}

	public function register($username, $fname, $lname, $email, $pass)
    {
        $pass = trim(password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 10]));

        $sql = "INSERT INTO " . $this->table_name . "(user_name, f_name, l_name, email, password) VALUES(?,?,?,?,?)";

        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("sssss", $username, $fname, $lname, $email, $pass);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
        
    }

	public function login($username, $pass)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE user_name=?";

        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        $hash = $row['password'];
        
        $stmt->close();

        $hash = substr( $hash, 0, 60 );

        $result = password_verify($pass, $hash);

        if($result)
        {
            return $row;
        }

        return $result;
    }

	public function update() {}

	public function delete() {}

}

?>
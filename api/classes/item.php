<?php

class Item
{
	//Connection Instance
	private $connection;

	//Table Name
	private $table_name = "Item";

	//Table Columns
	public $cat_id;
	public $item_id;
	public $qty;
	public $cost;

	//Constructor
	public function __construct($connection)
	{
		$this->connection = $connection;
	}

	public function insert($cat_id,$item_id,$item_name,$qty,$cost)
    {
        /*if($_POST[qty] === "" && $_POST[cost] === "")
            $sql = "INSERT INTO " . $this->table_name . "(cat_id, item_id, item_name) VALUES($_POST[cat_id], $_POST[item_id], '$_POST[item_name]')";
        
        else if($_POST[qty] === "")
            $sql = "INSERT INTO " . $this->table_name . "(cat_id, item_id, item_name, cost) VALUES($_POST[cat_id], $_POST[item_id], '$_POST[item_name]', $_POST[cost])";
        
        else if($_POST[cost] === "")
            $sql = "INSERT INTO " . $this->table_name . "(cat_id, item_id, item_name, qty) VALUES($_POST[cat_id], $_POST[item_id], '$_POST[item_name]', $_POST[qty])";
        
        else
            $sql = "INSERT INTO " . $this->table_name . "(cat_id, item_id, item_name, qty, cost) VALUES($_POST[cat_id], $_POST[item_id], '$_POST[item_name]', $_POST[qty], $_POST[cost])";*/
        
        $sql="INSERT INTO " .$this->table_name . "(cat_id, item_id, item_name, qty, cost) VALUES($cat_id,$item_id,'$item_name',$qty,$cost)";
        //return $sql;

        /*if (!$sql) {
            alert('Invalid query!');
        }
        else{ echo "Success"; }*/
        $result = $this->connection->query($sql);
        return $result;
/*
        if($result === true)
            return $result;
        else
            return "Error: [$sql] : $this->connection->errno";*/
    }

	public function list_all()
	{
		$sql = "SELECT * FROM " . $this->table_name . " ORDER BY item_id ASC";

		$stmt = $this->connection->prepare($sql);

		$stmt->execute();

        $result = $stmt->get_result();

        return $result;
	}

    public function search_by_value($col, $val)
    {
        $i = 0;
        $params = $col[0] . "=?";
        $args = "i";
        for($i=1; $i<count($col); $i++) {
            $params = $params . " and " . $col[$i] . "=?";
            $args = $args . "i";
        }

        $sql = "SELECT * FROM " . $this->table_name . " WHERE " . $params;

        $stmt = $this->connection->prepare($sql);

        for($i=0; $i<count($col); $i++) {
            $stmt->bind_param($args, ...$val);
        }

        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

	public function update($cat_id,$item_id,$item_name,$qty,$cost)
    {
        $sql="UPDATE " .$this->table_name . " SET item_name=?, qty=?, cost=? WHERE cat_id=? AND item_id=?";
        
        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param('siiii', $item_name, $qty, $cost, $cat_id, $item_id);

        $result = $stmt->execute();

        return $result;
    }

	public function delete($cat_id, $item_id)
    {
        $sql = "DELETE FROM " . $this->table_name . " WHERE cat_id=? AND item_id=?";

        $stmt = $this->connection->prepare($sql);

        $stmt->bind_param('ii', $cat_id, $item_id);

        $result = $stmt->execute();

        return $result;
    }

}
 
?>
<?php
class Manufacture{
	function __construct() {
		
	}
	public function insert_manufacturer($params){
		$conn = new Database();
		$sql = $conn->insert_man($params);
		return $sql;
	}
	public function fetch_manufacturer(){
		$conn = new Database();
		$sql = $conn->fetch_man();
		return $sql;
	}
}
?>

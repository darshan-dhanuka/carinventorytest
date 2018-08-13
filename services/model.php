<?php
class Model{
	function __construct() {
		
	}
	public function insert_model($params){
		$conn = new Database();
		$sql = $conn->insert_model($params);
		return $sql;
	}
	public function upload_pics($params){
		$conn = new Database();
		$sql = $conn->upload_pics($params);
		return $sql;
	}
	public function get_model(){
		$conn = new Database();
		$sql = $conn->get_model();
		return $sql;
	}
	public function get_model_details($params){
		$conn = new Database();
		$sql = $conn->get_model_details($params);
		return $sql;
	}
	public function sold_model($params){
		$conn = new Database();
		$sql = $conn->sold_model($params);
		return $sql;
	}
	public function dwn_img($params){
		$conn = new Database();
		$sql = $conn->dwn_img($params);
		return $sql;
	}
}
?>

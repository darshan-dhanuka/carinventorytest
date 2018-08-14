<?php
class Database {
	private $servername;
	private $username;
	private $password;
	private $dbname;
	
	public function __construct(){
		
	}
	public function connect(){
		$this->servername = "localhost";
		$this->username = "root";
		$this->password = "";
		$this->dbname = "db_car";
		
		$conn = @mysqli_connect($this->servername,$this->username,$this->password,$this->dbname);
		return $conn;
	}
	public function insert_man($params){
		$qryObj = $this->connect();
	 	$check_man = "SELECT * FROM tbl_manufacturer_details WHERE manufacture_name = '".$params['man_name']."' ";
		$con_check = mysqli_query($qryObj,$check_man);
		if(mysqli_num_rows($con_check) > 0){
			$resp['msg'] = "This Manufacturer Already exists";
			$resp['errorCode'] = 1;
			return json_encode($resp);
		}
 		$ins_qry = "INSERT INTO tbl_manufacturer_details (manufacture_name) VALUES ('".$params['man_name']."')";
		$con_ins = mysqli_query($qryObj,$ins_qry);
		$resp = array();
		if($con_ins){
			$resp['msg'] = "Manufacturer inserted successfully";
			$resp['errorCode'] = 0;
		}else{
			$resp['msg'] = "Something went wrong .Please try again later";
			$resp['errorCode'] = 1;
		}
		return json_encode($resp);
	}
	public function fetch_man(){
		$qryObj = $this->connect();
		$fetch_qry = "SELECT * FROM tbl_manufacturer_details";
		$con_ins = mysqli_query($qryObj,$fetch_qry);
		$resp = array();
		if(mysqli_num_rows($con_ins) > 0){
			while($row = mysqli_fetch_array($con_ins,MYSQLI_ASSOC)){
				$resp['data'][] = $row;
			}
			$resp['errorCode'] = 0;
		}else{
			$resp['errorCode'] = 1;
			$resp['msg'] = "No Data Found";
		}
		return json_encode($resp);
	}
	public function upload_pics($params){
		$qryObj = $this->connect();
		$resp = array();
		if(isset($_FILES)){
			$destination = '../images/';
			if(!is_dir($destination)){
				mkdir($destination,0777);
			}
			$num = rand(1,9999);
			$destination .= $num.'_'.$_FILES['file']['name'];
			if(move_uploaded_file($_FILES['file']['tmp_name'],$destination)){
				$ins_file = "INSERT INTO tbl_image_store (model_id,img_path) VALUES ('".$params['model_id']."','".$destination."')";
				$con_ins = mysqli_query($qryObj,$ins_file);
				if($con_ins){
					$resp['msg'] = "Image uploaded successfully";
					$resp['path'] = $destination;
					$resp['errorCode'] = 0;
				}else{
					$resp['msg'] = "Something went wrong .Please try again later";
					$resp['errorCode'] = 1;
				}
			}else{
				$resp['msg'] = "Something went wrong .Please try again later";
				$resp['errorCode'] = 1;
			}
		}else{
			$resp['msg'] = "Something went wrong .Please try again later";
			$resp['errorCode'] = 1;
		}
		return json_encode($resp);
	}
	public function insert_model($params){
		$qryObj = $this->connect();
	 	
 		$ins_qry = "INSERT INTO tbl_model_details (model_name,manufacture_id,color,manufacture_year,registration_number,add_details) VALUES ('".$params['model_name']."','".$params['selectedModelName']."','".$params['color_name']."','".$params['man_year']."','".$params['reg_num']."','".$params['note_details']."')";
		$con_ins = mysqli_query($qryObj,$ins_qry);
		$resp = array();
		if($con_ins){
			$resp['msg'] = "Model inserted successfully";
			$resp['errorCode'] = 0;
		}else{
			$resp['msg'] = "Something went wrong .Please try again later";
			$resp['errorCode'] = 1;
		}
		return json_encode($resp);
	}
	public function get_model(){
		$qryObj = $this->connect();
		$fetch_qry = "SELECT *,Count(*) AS cnt FROM tbl_model_details WHERE display_flag = 1 GROUP BY model_name,manufacture_id";
		$con_fetch_qry = mysqli_query($qryObj,$fetch_qry);
		$resp = array();
		if(mysqli_num_rows($con_fetch_qry) > 0){
			while($row = mysqli_fetch_array($con_fetch_qry,MYSQLI_ASSOC)){
				$select_man = "SELECT manufacture_name FROM tbl_manufacturer_details WHERE id = '".$row['manufacture_id']."'";
				$con_select_man = mysqli_query($qryObj,$select_man);
				$man_arr = mysqli_fetch_array($con_select_man,MYSQLI_ASSOC);
				$row['manufacture_name'] = $man_arr['manufacture_name'];
				$resp['data'][] = $row;
			}
			$resp['errorCode'] = 0;
		}else{
			$resp['errorCode'] = 1;
			$resp['msg'] = "No Data Found";
		}
		return json_encode($resp);
	}
	public function get_model_details($params){
		$qryObj = $this->connect();
		$fetch_qry = "SELECT * FROM tbl_model_details WHERE display_flag = 1 AND model_name = '".$params['model_name']."' AND manufacture_id = '".$params['manufacture_id']."' ";
		$con_fetch_qry = mysqli_query($qryObj,$fetch_qry);
		$resp = array();
		if(mysqli_num_rows($con_fetch_qry) > 0){
			$select_man = "SELECT manufacture_name FROM tbl_manufacturer_details WHERE id = '".$params['manufacture_id']."'";
			$con_select_man = mysqli_query($qryObj,$select_man);
			$man_arr = mysqli_fetch_array($con_select_man,MYSQLI_ASSOC);
			while($row = mysqli_fetch_array($con_fetch_qry,MYSQLI_ASSOC)){
				$row['manufacture_name'] = $man_arr['manufacture_name'];
				$resp['data'][] = $row;
			}
			$resp['errorCode'] = 0;
		}else{
			$resp['errorCode'] = 1;
			$resp['msg'] = "No Data Found";
		}
		return json_encode($resp);
	}
	public function sold_model($params){
		$qryObj = $this->connect();
		$update_qry = "UPDATE tbl_model_details SET display_flag = 0 WHERE display_flag = 1 AND id = '".$params['sold_id']."' ";
		$con_fetch_qry = mysqli_query($qryObj,$update_qry);
		$resp = array();
		if($con_fetch_qry){
			$resp['errorCode'] = 0;
			$resp['msg'] = "Updated Successfully";
		}else{
			$resp['errorCode'] = 1;
			$resp['msg'] = "Something went wrong .Please try again later";
		}
		return json_encode($resp);
	}
	public function dwn_img($params){
		$qryObj = $this->connect();
		$update_qry = "SELECT * FROM  tbl_image_store  WHERE model_id = '".$params['registration_number']."' ";
		$con_fetch_qry = mysqli_query($qryObj,$update_qry);
		$num_fetch_qry = mysqli_num_rows($con_fetch_qry);
		$resp = array();
		if($num_fetch_qry > 0){
			$resp['errorCode'] = 0;
			while($row = mysqli_fetch_array($con_fetch_qry,MYSQLI_ASSOC)){
				$img_array[] = $row['img_path'];
			}
			$tmpFile = tempnam('../images', '');
			$zip = new ZipArchive;
			$zip->open($tmpFile, ZipArchive::CREATE);
			foreach ($img_array as $img) {
				// download file
				$fileContent = file_get_contents($img);

				$zip->addFromString(basename($img), $fileContent);
			}
			$zip->close();

			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename=file.zip');
			header('Content-Length: ' . filesize($tmpFile));
			readfile($tmpFile);

			unlink($tmpFile);
			//$resp['msg'] = "Updated Successfully";
		}else{
			$resp['errorCode'] = 1;
			$resp['msg'] = "Something went wrong .Please try again later";
		}
		//return json_encode($resp);
	}
}

?>

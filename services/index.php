<?php
include('database.php');
include('manufacture.php');
include('model.php');
error_reporting(0);
//ini_set('display_errors',1);
$params	=	json_decode(file_get_contents('php://input'),true);
if(is_array($params) == false){
	$params = array();
}
$paramsSend = array_merge($params,$_GET,$_POST);
if(isset($paramsSend)){
	$manObj = new Manufacture();
	$modelObj = new Model();
	if($paramsSend['task'] == 'insert_man'){
		$con = $manObj->insert_manufacturer($paramsSend);
		echo $con;
	}
	if($paramsSend['task'] == 'fetch_man'){
		$con = $manObj->fetch_manufacturer();
		echo $con;
	}
	if($paramsSend['task'] == 'upload_file'){
		$con = $modelObj->upload_pics($paramsSend);
		echo $con;
	}
	if($paramsSend['task'] == 'insert_model'){
		$con = $modelObj->insert_model($paramsSend);
		echo $con;
	}
	if($paramsSend['task'] == 'get_model'){
		$con = $modelObj->get_model();
		echo $con;
	}
	if($paramsSend['task'] == 'get_model_details'){
		$con = $modelObj->get_model_details($paramsSend);
		echo $con;
	}
	if($paramsSend['task'] == 'sold_model'){
		$con = $modelObj->sold_model($paramsSend);
		echo $con;
	}
	if($paramsSend['task'] == 'dwn_img'){
		$con = $modelObj->dwn_img($paramsSend);
		echo $con;
	}
	if($paramsSend['task'] == ''){
		echo "No input available";
	}
}else{
	echo "No input available";
}

?>

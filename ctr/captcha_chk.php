<?
session_start();
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";

if($_SESSION['authnum_session'] == $_POST['captcha_no']){
	echo json_encode(array("error"=>true));
}else{
	echo json_encode(array("error"=>false));
}

?>
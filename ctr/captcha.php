<?php
session_start();

include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";

$_SESSION['authnum_session'] = str_rand(6,"0123456789");

echo json_encode(array("code"=>$_SESSION['authnum_session']));
 ?>
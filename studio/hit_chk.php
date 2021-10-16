<?
session_start();
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";
$type		=	"studio";
$table		=	"studio";
$no		=	addslashes($_POST['no']);
$num = $no."1|";

if($M_login['user_id'] != ''){
	$ip_address = $M_login["user_id"];
}else{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip_address = $_SERVER['REMOTE_ADDR'];
	}
}

$k = 0;

$tag = $ip_address.$table;

if(strstr($tag,".") !== false){
	$tag = str_replace(".","",$tag);
}

if($_COOKIE[$tag] != ''){
	if(!strstr($_COOKIE[$tag],$num)){
		$_COOKIE[$tag]  .= $num;
		$hit = $db->query("update ".$table." set hit=hit+1 where ".$type."_no=$no");
	}
}else{
	$_COOKIE[$tag]  .= $num;
	$hit = $db->query("update ".$table." set hit=hit+1 where ".$type."_no=$no");
}

$date = date("Y-m-d")."23:59:59";
setcookie($tag,$_COOKIE[$tag],strtotime($date));


?>
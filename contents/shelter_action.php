<?
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";
include $_SERVER['DOCUMENT_ROOT']."/_library/function_shelter.php";
//=>	테이블명을 설정합니다.
$VAL		=	$_POST;
$save_dir		= $_SERVER['DOCUMENT_ROOT'].'/upload/shelter';

if ($VAL['mode'] == 'insert'){
	$VAL['shelter_no']	=	$db->get_data_one("SELECT MAX(shelter_no) as shelter_no FROM shelter") + 1;
}else{
	$info = F_shelter(array("mode"=>"read", "shelter_no"=>$VAL['shelter_no']));
}

$VAL['city_no'] = $VAL['city'];
$VAL['area_no'] = $VAL['area'];

$city = $db->get_data("SELECT * FROM city WHERE city_no='".$VAL['city_no']."'");
$area = $db->get_data("SELECT * FROM area WHERE area_no='".$VAL['area_no']."'");

$VAL['addr'] = $city["name"]." ".$area["name"]." ".$VAL["other_addr"];

F_shelter($VAL);

meta_go("./shelter.html");
?>
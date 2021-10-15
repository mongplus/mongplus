<?
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";
include $_SERVER['DOCUMENT_ROOT']."/_library/function_navigation.php";
//=>	테이블명을 설정합니다.
$VAL		=	$_POST;
$save_dir		= $_SERVER['DOCUMENT_ROOT'].'/upload/navigation';

if($VAL['c_number'] == ''){
	alert_print("사업자번호를 입력해 주세요.");
	history.go();
	exit;
}

if(strstr($VAL['c_number'],"-") !== False){
	$VAL['c_number'] = str_replace("-","",$VAL['c_number']);
}

if ($VAL['mode'] == 'insert'){
	$VAL['navi_no']	=	$db->get_data_one("SELECT MAX(navi_no) as navi_no FROM navigation") + 1;

	$data = $db->get_data("SELECT COUNT(*) AS cnt FROM navigation WHERE c_number='".$VAL['c_number']."'");

	if($data['cnt'] > 0){
		alert_print("이미 등록된 네비게이션입니다.");
		history.go();
		exit;
	}
}else{
	$info = F_navigation(array("mode"=>"read", "navi_no"=>$VAL['navi_no']));
}

$VAL['tel'] = $VAL['tel1']."-".$VAL['tel2']."-".$VAL['tel3'];

$VAL['city_no'] = $VAL['city'];
$VAL['area_no'] = $VAL['area'];
$VAL['dong_no'] = $VAL['dong'];

if($VAL['area'] == '' && $VAL['dong']){
	$area = $db->get_data("SELECT * FROM dong WHERE dong_no='".$VAL['dong']."'");
	$VAL['area_no'] = $area['area_no'];
}

$city = $db->get_data("SELECT * FROM city WHERE city_no='".$VAL['city_no']."'");
$area = $db->get_data("SELECT * FROM area WHERE area_no='".$VAL['area_no']."'");
$dong = $db->get_data("SELECT * FROM dong WHERE dong_no='".$VAL['dong_no']."'");

$VAL['addr'] = $city["name"]." ".$area["name"]." ".$dong["name"]." ".$VAL["other_addr"];

F_navigation($VAL);

meta_go("./navi.html");
?>
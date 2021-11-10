<?
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";
include $_SERVER['DOCUMENT_ROOT']."/_library/function_help.php";
include $_SERVER['DOCUMENT_ROOT']."/_library/function_order_payment.php";
include $_SERVER['DOCUMENT_ROOT']."/_library/function_push_log.php";

$VAL		=	$_POST;
$save_dir		= $_SERVER['DOCUMENT_ROOT'].'/upload/help';

if($M_login['level'] < 1){
	alert_print("회원 전용페이지입니다.");
	meta_go('/member/login.html');
	exit;
}

if(!$VAL['mode']){
	$VAL['mode'] = 'insert';
}

if($VAL["animal_no"] != ''){
	$animal = $db->get_data("SELECT * FROM animal WHERE animal_no='".$VAL['animal_no']."'");
}

$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

if ($VAL['mode'] == 'insert'){
	$VAL['help_no']	=	$db->get_data_one("SELECT MAX(help_no) as help_no FROM help") + 1;
}else{
	$info = F_help(array("mode"=>"read", "help_no"=>$VAL['help_no']));
}

for ($i = 1; $i < 6; $i++){
	$f			=	'up_file'.$i;
	$fn			=	'up_file'.$i.'_name';
	$fs			=	'up_file'.$i.'_size';
	$year_mon		=	date("Y-m");

	$uniq = $VAL['help_no'];
	$pre_file	=	$info['file'.$i];
	if ($$fn != '' || $mode == 'delete'){
		$R_info[$i]	=	F_file_upload(array(
							'mode'			=>	$mode,
							'del_file_path'	=>	$save_dir.'/'.$pre_file,
							'save_dir'		=>	$save_dir,
							'f'				=>	$$f,
							'year_mon'		=>	$year_mon,
							'fn'			=>	$$fn,
							'fs'			=>	$$fs,
							'uniq'			=>	$uniq,
							'idx'			=>	$i,
							'max_size'		=>	3000000,
							'thumnail'		=>	true,
							'thum_width'	=>	132,
							'thum_height'	=>	96,
							'thum_path'		=>	'',
							'pre_file'		=>	'',
							'file_type'		=>	'',
						));

		$VAL['file'.$i]				=	$R_info[$i]['real'];
		$VAL['real_filename'.$i]		=	$R_info[$i]['down'];
	}else{
		$VAL['file'.$i]				=	$info['file'.$i];
		$VAL['real_filename'.$i]		=	$info['real_filename'.$i];
	}
}

$VAL["keyword"] = '';
if($VAL["animal_option"] != ''){
	$fil = $db->get_data("SELECT * FROM filter_option WHERE option_no IN ('".$VAL["animal_option"]."')");

	if($VAL["keyword"] != ''){
		$VAL["keyword"] .= ", ";
	}

	$VAL["keyword"] .= $fil['c_name'];
}

if($animal_gubun2_op[$VAL['gubun']] != ''){

	if($VAL["keyword"] != ''){
		$VAL["keyword"] .= ", ";
	}

	$VAL["keyword"] .= $animal_gubun2_op[$VAL['gubun']];
}

if($animal["name"] == '' && $_POST['animal_name'] != ''){
	$animal["name"] = $_POST['animal_name'];
}

$VAL['member_no'] = $member_info["member_no"];
$VAL['name'] = $member_info["name"];
$VAL['nickname'] = $member_info["nickname"];
$VAL['title_option'] = $VAL['animal_title'];
$VAL['option'] = $VAL['animal_option'];
$VAL['animal_name'] = $animal["name"];
$VAL['gubun'] = $VAL["animal_type"];
$VAL['sex'] = $VAL["animal_sex"];
$VAL['birth'] = $VAL["animal_birth"];
$VAL['disappear_date'] = $VAL["disappear_date"];
$VAL['keyword'] = $VAL["keyword"];
$VAL['status'] = "Y";
$VAL['seq'] = 0;

F_help($VAL);

if($VAL['mode'] != 'update'){
	$savings = $db->get_data("SELECT * FROM savings WHERE 1");

	if($savings['gubun'] == 'Y'){
		if($savings['review_mem'] != ''){
			$db->query("UPDATE member SET point=point+'".$savings['contents_mem']."' WHERE member_no='".$member_info['member_no']."'");

			$order_payment = array();
			$order_payment['payment_no']= $db->get_data_one("SELECT MAX(payment_no) as payment_no FROM `order_payment`") + 1;
			$order_payment['mode']		= "insert";
			$order_payment['order_no']	= 0;
			$order_payment['member_no']	= $member_info['member_no'];
			$order_payment['point']		= $savings['contents_mem'];
			$order_payment['title']		= "콘텐츠 업로드";
			$order_payment['status']	= "P";
			$order_payment['type']		= "Y";

			F_order_payment($order_payment);
		}
	}

	$data = $db->get_data("SELECT COUNT(*) AS cnt FROM story WHERE member_no='".$member_info['member_no']."'");
	$data2 = $db->get_data("SELECT COUNT(*) AS cnt FROM etalk WHERE member_no='".$member_info['member_no']."'");

	if($data['cnt'] <= 0 && $data2['cnt'] <= 0){
		/*쿠폰발급 push알림*/
		$msg = $db->get_data("SELECT * FROM push_set WHERE 1");

		if($msg['b_type'] == 'Y' && $msg['b_content'] != ''){

			for($i=0;$i<count($push_substr_op);$i++){
				if(strstr($msg['b_content'],$push_substr_op[$i]) !== 'false'){
					$name = '';
					switch ($push_substr_op[$i]){
						case "{memberNm}":
							$name = $member_info['name'];
						break;
						case "{nickName}":
							$name = $member_info['nickname'];
						break;
						case "{shopName}":
							$data = $db->get_data("SELECT * FROM reg_conf WHERE 1");
							$name = $data['company'];
						break;
					}
					$msg['b_content'] = str_replace($push_substr_op[$i],"",$msg['b_content']);
				}
			}

			$push_log = array();
			$push_log['member_no'] = $member_info['member_no'];
			$push_log['gubun'] = $push_gubun_op[6];
			$push_log['content'] = $msg["b_content"];
			$push_log['status'] = "N";
			$push_log['mode'] = "insert";

			F_push_log($push_log);
			if($member_info['pushCode'] != ''){
				$message_status = send_notification($member_info['pushCode'],$push_gubun_name_op[6],$msg["b_content"]);
			}
		}

	}

	$data = $db->get_list("SELECT * FROM member_channel WHERE member_no='".$member_info["member_no"]."'");

	for($s=0;$s<count($data['channel_no']);$s++){
		$mem = $db->get_data("SELECT * FROM member WHERE member_no='".$data['members_no'][$s]."' AND is_use='Y'");

		if($mem['member_no'] != ''){
			/*구독자한테 push알림*/

			$push_log = array();
			$push_log['member_no']	= $data['members_no'][$s];
			$push_log['gubun']		= $push_gubun_op[12];
			$push_log['content']	= $member_info['nickname']."님이 새로운 찾습니다를 올렸어요.";
			$push_log['from']		= $member_info['member_no'];
			$push_log['status']		= "N";
			$push_log['mode']		= "insert";

			F_push_log($push_log);
			if($data['pushCode'][$s] != ''){
				$message_status = send_notification($data['pushCode'][$s],$push_gubun_name_op[12],$push_log['content']);
			}
		}
	}
}

meta_go("/story/mongCare/?type=find");
?>
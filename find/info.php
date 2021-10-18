<?
include $DOCUMENT_ROOT."/_common/config.php";

$VAL = $_POST;

if($VAL['mode'] == 'area_read'){
	$html = F_get_option("SELECT area_no, name FROM area WHERE city_no='".$VAL['city_no']."'",$VAL['area_no']);

	echo json_encode(array("error"=>true,"html"=>$html));
}else if($VAL['mode'] == 'read_filter_option2'){
	$html = '';
	$i=0;
	foreach($filter_expert_op as $k => $v){
		if($i == 0){ $class=''; }else{ $class="mt15"; }
		$html .= '<select class="join_seleect '.$class.'" name="option'.$k.'">';
		$html .= '<option value="">'.$v.'</option>';
		$html .= F_get_option("SELECT option_no,title FROM filter_option WHERE gubun='F' AND d_option='".$k."' ORDER BY title ASC",$VAL['option_no']);
		$html .= '</select>';
		$i++;
	}

	echo json_encode(array('error'=>true,'html'=>$html));
}else if($VAL['mode'] == 'member_channel_in'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_member_channel.php";


	if($VAL['member_no'] != '' && $M_login['user_id'] != ''){
		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		if($member_info['member_no'] == ''){
			echo json_encode(array("msg"=>"로그인을 해주세요."));
			exit;
		}

		$channel = $db->get_data("SELECT * FROM member_channel WHERE member_no='".$VAL['member_no']."' AND members_no='".$member_info['member_no']."'");

		if($channel['channel_no'] != ''){
			F_member_channel(array("mode"=>"delete","channel_no"=>$channel['channel_no']));
			$msg = "구독취소하였습니다.";
		}else{
			if($VAL['member_no'] == $member_info['member_no']){
				echo json_encode(array("msg"=>"구독할수 없습니다."));
				exit;
			}

			$ch = array();
			$ch['mode'] = "insert";
			$ch['member_no'] = $VAL['member_no'];
			$ch['members_no'] = $member_info['member_no'];
			F_member_channel($ch);

			/*쿠폰발급 push알림*/
			$msg = $db->get_data("SELECT * FROM push_set WHERE 1");
			$members = $db->get_data("SELECT * FROM member WHERE member_no='".$VAL['member_no']."'");

			if($msg['ch_type'] == 'Y' && $msg['ch_content'] != '' && $members['member_no'] != ''){
				include $_SERVER['DOCUMENT_ROOT']."/_library/function_push_log.php";

				for($i=0;$i<count($push_substr_op);$i++){
					if(strstr($msg['ch_content'],$push_substr_op[$i]) !== 'false'){
						$name = '';
						switch ($push_substr_op[$i]){
							case "{memberNm}":
								$name = $members['name'];
							break;
							case "{nickName}":
								$name = $members['nickname'];
							break;
							case "{shopName}":
								$data = $db->get_data("SELECT * FROM reg_conf WHERE 1");
								$name = $data['company'];
							break;
						}
						$msg['ch_content'] = str_replace($push_substr_op[$i],$name,$msg['ch_content']);
					}
				}

				$push_log = array();
				$push_log['member_no'] = $members['member_no'];
				$push_log['gubun'] = $push_gubun_op[7];
				$push_log['content'] = $msg["ch_content"];
				$push_log['status'] = "N";
				$push_log['mode'] = "insert";

				F_push_log($push_log);
				if($members['pushCode'] != ''){
					$message_status = send_notification($members['pushCode'],$push_gubun_name_op[7],$msg["ch_content"]);
				}
			}

			$msg = "구독하였습니다.";
		}
	}else{
		$msg = "구독실패하였습니다.";
	}

	echo json_encode(array("msg"=>$msg));
}
?>
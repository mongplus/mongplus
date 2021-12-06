<?
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";

$VAL		=	$_POST;

if($VAL['mode'] == 'etalk_comment_insert'){
	if($VAL['etalk_no'] != '' && trim($VAL['text']) != ''){
		include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk_comment.php";

		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		$data['etalk_no'] = $VAL['etalk_no'];
		$data['member_no'] = $member_info['member_no'];
		$data['up_num'] = 0;
		$data['down_num'] = 0;
		$data['mode'] = "insert";
		$data['content'] = $VAL['text'];

		F_etalk_comment($data);

		/*쿠폰발급 push알림*/
		$msg = $db->get_data("SELECT * FROM push_set WHERE 1");
		$member_no = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$VAL['etalk_no']."'");
		$members = $db->get_data("SELECT * FROM member WHERE member_no='".$member_no['member_no']."'");

		if($msg['cm_type'] == 'Y' && $msg['cm_content'] != '' && $members['member_no'] != ''){
			include $_SERVER['DOCUMENT_ROOT']."/_library/function_push_log.php";

			for($i=0;$i<count($push_substr_op);$i++){
				if(strstr($msg['cm_content'],$push_substr_op[$i]) !== 'false'){
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
					$msg['cm_content'] = str_replace($push_substr_op[$i],$name,$msg['cm_content']);
				}
			}

			$push_log = array();
			$push_log['member_no'] = $members['member_no'];
			$push_log['gubun'] = $push_gubun_op[8];
			$push_log['content'] = $msg["cm_content"];
			$push_log['status'] = "N";
			$push_log['mode'] = "insert";

			F_push_log($push_log);
			if($members['pushCode'] != ''){
				$message_status = send_notification($members['pushCode'],$push_gubun_name_op[8],$msg["cm_content"]);
			}
		}
	}

	echo json_encode(array("error"=>true));
}else if($VAL['mode'] == 'etalk_comment_paging'){
	$html = '';
	if($VAL['etalk_no'] != '' && $VAL['page'] != ''){
		include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk_comment.php";

		$comment_condition = array(
				"row"			=>	2,
				"page"			=>	$VAL['page'],
				"order"			=>	" reg_date DESC",
				"find_text"		=>	$find_text,
				"find_object"	=>	$find_object,
				"add_query"		=>	" AND etalk_no='".$VAL['etalk_no']."'",
			);

		$etalk_comment	=	F_etalk_comment_list($comment_condition);

		$member_info_me = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		for($i=0;$i<count($etalk_comment['comment_no']);$i++){
			$mems = $db->get_data("SELECT * FROM animal WHERE member_no='".$etalk_comment['member_no'][$i]."' AND file2 != ''");
			$mems2 = $db->get_data("SELECT * FROM member WHERE member_no='".$etalk_comment['member_no'][$i]."'");

			$minute=floor((strtotime('now')-strtotime($etalk_comment["reg_date"][$i]))%86400/60);

			if($minute >= 60){
				$hour=floor((strtotime('now')-strtotime($etalk_comment["reg_date"][$i]))%86400/3600);

				if($hour >= 24){
					$date=floor((strtotime('now')-strtotime($etalk_comment["reg_date"][$i]))/86400);
					$dateTm = '<span class="comment_up_time">'.$date.'</span><span>일</span>';
				}else{
					$dateTm = '<span class="comment_up_time">'.$hour.'</span><span>시간전</span>';
				}
			}else{
				$dateTm = "방금";
			}

			$html .= '<li>							
			
				<div class="comment_list_btn">
					<a class="good_btn" data-no="'.$etalk_comment["comment_no"][$i].'">
						'.$etalk_comment["up_num"][$i].'
					</a>
					<a class="not_good_btn"  data-no="'.$etalk_comment["comment_no"][$i].'">
						'.$etalk_comment["down_num"][$i].'
					</a>';

			if($etalk_comment["member_no"][$i] == $member_info_me['member_no']){
				$html .= '<a class="del_good_btn" data-no="'.$etalk_comment["comment_no"][$i].'">
					삭제
				</a>';
			}

			$html .= '</div>
				<div class="comment_Profile">
					<span class="certification01"><!-- 01일반인증 02전문가인증 03인증없음 -->
					</span>

					<div class="Img">
					<img src="/upload/member/'.$mems2['file2'].'" onclick="location.href=\'#\'">	
					</div>					
				</div>
				<div class="comment_ProfileTxt">
				<span class="name">
					<a onclick="location.href=\'#\'">
						'.$mems2['nickname'].'
					</a>
					'.$dateTm.'
				</span>
				
				<span class="comment_text">
					'.$etalk_comment["content"][$i].'
				</span>
				
				
				</div>
				
			</li>';
		}

		$page_info['cur']		=	$comment_condition['page'];
		$page_info['row']		=	$comment_condition['row'];
		$page_info['total']		=	$etalk_comment['total'];
		$page_string = print_page_num10($page_info);
	}

	echo json_encode(array("error"=>true,"html"=>$html,"page"=>$page_string));
}else if($VAL['mode'] == 'etalk_comment_good'){
	$num = 0;
	if($VAL['comment_no'] != ''){
		include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk_good.php";

		$etalk = $db->get_data("SELECT * FROM etalk_comment WHERE comment_no='".$VAL['comment_no']."'");
		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		if($VAL['type'] == 'Y'){
			$num = $etalk['up_num'];
		}else{
			$num = $etalk['down_num'];	
		}

		$info = $db->get_data("SELECT * FROM etalk_good WHERE comment_no='".$VAL['comment_no']."'");

		if($info['good_no'] == ""){
			$good = array();
			$good['comment_no'] = $VAL['comment_no'];
			$good['etalk_no'] = $etalk['etalk_no'];
			$good['member_no'] = $member_info['member_no'];
			$good['type'] = $VAL['type'];
			$good['mode'] = "insert";

			F_etalk_good($good);

			if($VAL['type'] == 'Y'){
				$num = $etalk['up_num']+1;
				$db->query("UPDATE etalk_comment SET up_num='".$num."' WHERE comment_no='".$VAL['comment_no']."'");
			}else{
				$num = $etalk['down_num']+1;	
				$db->query("UPDATE etalk_comment SET down_num='".$num."' WHERE comment_no='".$VAL['comment_no']."'");
			}
		}else{
			if($info['type'] == $VAL['type']){
				F_etalk_good(array("mode"=>"delete","good_no"=>$info['good_no']));

				if($VAL['type'] == 'Y'){
					$num = $etalk['up_num']-1;
					$db->query("UPDATE etalk_comment SET up_num='".$num."' WHERE comment_no='".$VAL['comment_no']."'");
				}else{
					$num = $etalk['down_num']-1;	
					$db->query("UPDATE etalk_comment SET down_num='".$num."' WHERE comment_no='".$VAL['comment_no']."'");
				}
			}
		}
	}

	echo json_encode(array("num"=>$num));
}else if($VAL['mode'] == 'etalk_comment_del'){
	if($VAL['comment_no'] != ''){
		include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk_comment.php";

		$etalk = $db->get_data("SELECT * FROM etalk_comment WHERE comment_no='".$VAL['comment_no']."'");
		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		if($etalk['member_no'] == $member_info['member_no']){
			F_etalk_comment(array("mode"=>"delete","comment_no"=>$etalk['comment_no']));
		}
	}

	echo json_encode(array("error"=>true));

}else if($VAL['mode'] == 'member_channel_in'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_member_channel.php";


	if($VAL['etalk_no'] != ''){
		$member_no = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$VAL['etalk_no']."'");

		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		if($member_info['member_no'] == ''){
			echo json_encode(array("msg"=>"로그인을 해주세요."));
			exit;
		}

		$channel = $db->get_data("SELECT * FROM member_channel WHERE member_no='".$member_no['member_no']."' AND members_no='".$member_info['member_no']."'");

		if($channel['channel_no'] != ''){
			F_member_channel(array("mode"=>"delete","channel_no"=>$channel['channel_no']));
			$msg = "구독취소하였습니다.";
		}else{
			if($member_no['member_no'] == $member_info['member_no']){
				echo json_encode(array("msg"=>"구독할수 없습니다."));
				exit;
			}

			$ch = array();
			$ch['mode'] = "insert";
			$ch['member_no'] = $member_no['member_no'];
			$ch['members_no'] = $member_info['member_no'];
			F_member_channel($ch);

			/*쿠폰발급 push알림*/
			$msg = $db->get_data("SELECT * FROM push_set WHERE 1");
			$members = $db->get_data("SELECT * FROM member WHERE member_no='".$member_no['member_no']."'");

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
}else if($VAL['mode'] == 'talk_goods'){
	$num = 0;
	if($VAL['etalk_no'] != ''){
		include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk_goods.php";

		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		if($member_info['member_no'] == ''){
			echo json_encode(array("num"=>"err","chk"=>false));
			exit;
		}

		$info = $db->get_data("SELECT * FROM etalk_goods WHERE etalk_no='".$VAL['etalk_no']."' AND member_no='".$member_info['member_no']."'");

		if($info['good_no'] == ""){
			$goods = array();
			$goods['etalk_no'] = $VAL['etalk_no'];
			$goods['member_no'] = $member_info['member_no'];
			$goods['mode'] = "insert";

			F_etalk_goods($goods);

			$db->query("UPDATE etalk SET good=good+'1' WHERE etalk_no='".$VAL['etalk_no']."'");
			$chk = true;
		}else{
			$goods = array();
			$goods['good_no'] = $info['good_no'];
			$goods['mode'] = "delete";

			F_etalk_goods($goods);

			$db->query("UPDATE etalk SET good=good-'1' WHERE etalk_no='".$VAL['etalk_no']."'");
			$chk = false;
		}

		$etalk = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$VAL['etalk_no']."'");
		$num = $etalk['good'];
	}

	echo json_encode(array("num"=>$num,"chk"=>$chk));
}else if($VAL['mode'] == 'filter_option_h'){
	$listH = $db->get_list("SELECT * FROM filter_option WHERE gubun='H' ORDER BY title ASC");

		$html = '<input type="checkbox" id="filter_check_id_0" class="filter_check_input" name="filhAll" value="all" />
				<label for="filter_check_id_0" class="f12 filter_check fil_h_all_chk">전체</label>';

	$k = 0;
	for($i=0;$i<count($listH['option_no']);$i++){
		$k++;
		$html .= '<input type="checkbox" id="filter_check_id_'.$k.'" class="filter_check_input" name="filh[]" value="'.$listH['option_no'][$i].'" />
				<label for="filter_check_id_'.$k.'" class="f12 filter_check fil_h_chk">'.$listH['title'][$i].'</label>';
	}

	echo json_encode(array("html"=>$html));
}else if($VAL['mode'] == 'filter_option_i'){
	$listH = $db->get_list("SELECT * FROM filter_option WHERE gubun='I' ORDER BY title ASC");

		$html = '<input type="checkbox" id="filter_check_id_0" class="filter_check_input" name="filiAll" value="all" />
				<label for="filter_check_id_0" class="f12 filter_check fil_i_all_chk">전체</label>';

	$k = 0;
	for($i=0;$i<count($listH['option_no']);$i++){
		$k++;
		$html .= '<input type="checkbox" id="filter_check_id_'.$k.'" class="filter_check_input" name="fili[]" value="'.$listH['option_no'][$i].'" />
				<label for="filter_check_id_'.$k.'" class="f12 filter_check fil_i_chk">'.$listH['title'][$i].'</label>';
	}

	echo json_encode(array("html"=>$html));
}else if($VAL['mode'] == 'etalk_collect'){
	$num = 0;
	if($VAL['etalk_no'] != ''){
		include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk_collect.php";

		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");

		if($member_info['member_no'] == ''){
			echo json_encode(array("num"=>"err","chk"=>false));
			exit;
		}

		$info = $db->get_data("SELECT * FROM etalk_collect WHERE etalk_no='".$VAL['etalk_no']."' AND member_no='".$member_info['member_no']."'");

		if($info['collect_no'] == ""){
			$collect = array();
			$collect['etalk_no'] = $VAL['etalk_no'];
			$collect['member_no'] = $member_info['member_no'];
			$collect['mode'] = "insert";

			F_etalk_collect($collect);

			$db->query("UPDATE etalk SET collect=collect+'1' WHERE etalk_no='".$VAL['etalk_no']."'");
			$chk = true;

			/*쿠폰발급 push알림*/
			$msg = $db->get_data("SELECT * FROM push_set WHERE 1");
			$member = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$VAL['etalk_no']."'");
			$members = $db->get_data("SELECT * FROM member WHERE member_no='".$member['member_no']."'");

			if($msg['s_type'] == 'Y' && $msg['s_content'] != '' && $members['member_no'] != ''){
				include $_SERVER['DOCUMENT_ROOT']."/_library/function_push_log.php";

				for($i=0;$i<count($push_substr_op);$i++){
					if(strstr($msg['s_content'],$push_substr_op[$i]) !== 'false'){
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
						$msg['s_content'] = str_replace($push_substr_op[$i],$name,$msg['s_content']);
					}
				}

				$push_log = array();
				$push_log['member_no'] = $members['member_no'];
				$push_log['gubun'] = $push_gubun_op[10];
				$push_log['content'] = $msg["s_content"];
				$push_log['status'] = "N";
				$push_log['mode'] = "insert";

				F_push_log($push_log);
				if($members['pushCode'] != ''){
					$message_status = send_notification($members['pushCode'],$push_gubun_name_op[10],$msg["s_content"]);
				}
			}
		}else{
			$collect = array();
			$collect['collect_no'] = $info['collect_no'];
			$collect['mode'] = "delete";

			F_etalk_collect($collect);

			$db->query("UPDATE etalk SET collect=collect-'1' WHERE etalk_no='".$VAL['etalk_no']."'");
			$chk = false;
		}

		$etalk = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$VAL['etalk_no']."'");
		$num = $etalk['collect'];
	}

	echo json_encode(array("num"=>$num,"chk"=>$chk));
}else if($VAL['mode'] == 'share_in'){
	if($VAL['no'] != ''){
		$info = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$VAL['no']."'");

		$share = $info['share'] + 1;

		$db->query("UPDATE etalk SET share='".$share."' WHERE etalk_no='".$VAL['no']."'");
	}else{
		$share = '';
	}

	echo json_encode(array("num"=>$share));
}else if($VAL['mode'] == "del_story_chk"){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk.php";

	if($M_login['user_id']){
		$member_info = $db->get_data("SELECT * FROM member WHERE user_id='".$M_login['user_id']."'");
	}else{
		echo json_encode(array("error"=>false,"msg"=>"로그인을 하세요."));
		exit;
	}

	$info = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$VAL['no']."'");

	if($info['member_no'] != $member_info['member_no']){
		echo json_encode(array("error"=>false,"msg"=>"소유하신 게시글이 아닙니다."));
		exit;
	}

	F_etalk(array("mode"=>"delete","etalk_no"=>$VAL['no']));

	if($VAL['no'] != ''){
		$db->query("DELETE FROM story WHERE type='etalk' AND no='".$VAL['no']."' AND member_no='".$member_info['member_no']."'");
		$db->query("DELETE FROM etalk_detail WHERE etalk_no = '".$VAL['no']."' ");
		$db->query("DELETE FROM etalk_good WHERE etalk_no = '".$VAL['no']."' ");
		$db->query("DELETE FROM etalk_goods WHERE etalk_no = '".$VAL['no']."' ");
		$db->query("DELETE FROM etalk_comment WHERE etalk_no = '".$VAL['no']."' ");
	}

	echo json_encode(array("error"=>true,"msg"=>"삭제하였습니다."));
	exit;
}
?>
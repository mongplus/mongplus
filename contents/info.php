<?
include $DOCUMENT_ROOT."/_common/config.php";

$VAL = $_POST;

if($VAL['mode'] == 'area_read'){
	$html = F_get_option("SELECT area_no, name FROM area WHERE city_no='".$VAL['city_no']."'","");

	echo json_encode(array("error"=>true,"html"=>$html));
}else if($VAL['mode'] == 'dong_read'){
	$html = F_get_option("SELECT dong_no, name FROM dong WHERE area_no='".$VAL['area_no']."'","");

	echo json_encode(array("error"=>true,"html"=>$html));
}else if($VAL['mode'] == 'all_navi_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_navigation.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			$VAL = array("mode"=>"delete","navi_no"=>$chk_no[$i]);
			
			F_navigation($VAL);
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_navi_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_navigation.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE navigation SET status='".$VAL['status']."' WHERE navi_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'info_read'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_navigation.php";

	$info = F_navigation(array("mode"=>"read", "navi_no"=>$VAL['navi_no']));

	if($info['navi_no'] != ''){
		if(strstr($info['tel'],"-") !== False){
			$detail = explode("-",$info['tel']);
			$info['tel1'] = $detail[0];
			$info['tel2'] = $detail[1];
			$info['tel3'] = $detail[2];
		}else{
			$info['tel1'] = '';
			$info['tel2'] = '';
			$info['tel3'] = '';
		}

		$info['area_html'] = F_get_option("SELECT area_no, name FROM area WHERE city_no='".$info['city_no']."'",$info['area_no']);
		$info['dong_html'] = F_get_option("SELECT dong_no, name FROM dong WHERE area_no='".$info['area_no']."'",$info['dong_no']);

		$info['error'] = 1;

		echo json_encode($info);
	}else{
		echo json_encode(array("error"=>0,"data"=>"정보가 없습니다."));
	}
}else if($VAL['mode'] == 'all_shelter_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_shelter.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			$VAL = array("mode"=>"delete","shelter_no"=>$chk_no[$i]);
			
			F_shelter($VAL);
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_shelter_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_shelter.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE shelter SET status='".$VAL['status']."' WHERE shelter_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'info_read_shelter'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_shelter.php";

	$info = F_shelter(array("mode"=>"read", "shelter_no"=>$VAL['shelter_no']));

	if($info['shelter_no'] != ''){
		if(strstr($info['tel'],"-") !== False){
			$detail = explode("-",$info['tel']);
			$info['tel1'] = $detail[0];
			$info['tel2'] = $detail[1];
			$info['tel3'] = $detail[2];
		}else{
			$info['tel1'] = '';
			$info['tel2'] = '';
			$info['tel3'] = '';
		}

		$info['area_html'] = F_get_option("SELECT area_no, name FROM area WHERE city_no='".$info['city_no']."'",$info['area_no']);
		$info['dong_html'] = F_get_option("SELECT dong_no, name FROM dong WHERE area_no='".$info['area_no']."'",$info['dong_no']);

		$info['error'] = 1;

		echo json_encode($info);
	}else{
		echo json_encode(array("error"=>0,"data"=>"정보가 없습니다."));
	}
}else if($VAL['mode'] == 'read_filter_option'){
	$html = F_get_option("SELECT option_no , title FROM filter_option WHERE gubun='A' AND type='".$VAL['gubun']."' AND d_option='".$VAL['size']."' ORDER BY title ASC","");

	echo json_encode(array("error"=>1,"html"=>$html));
}else if($VAL['mode'] == 'shelter_read_select'){
	$info = $db->get_data("SELECT tel, addr FROM shelter WHERE shelter_no='".$VAL['shelter_no']."'");

	echo json_encode($info);
}else if($VAL['mode'] == 'all_adopt_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_adopt.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			$VAL = array("mode"=>"delete","adopt_no"=>$chk_no[$i]);
			
			F_adopt($VAL);
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_adopt_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_adopt.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE adopt SET status='".$VAL['status']."' WHERE adopt_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'info_read_adopt'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_adopt.php";

	$info = F_adopt(array("mode"=>"read", "adopt_no"=>$VAL['adopt_no']));

	if($info['adopt_no'] != ''){
		$info['area_html'] = F_get_option("SELECT area_no, name FROM area WHERE city_no='".$info['city_no']."'",$info['area_no']);
		$info['dong_html'] = F_get_option("SELECT dong_no, name FROM dong WHERE area_no='".$info['area_no']."'",$info['dong_no']);

		$info['filter_html'] = F_get_option("SELECT option_no , title FROM filter_option WHERE gubun='A' AND type='".$info['gubun']."' AND d_option='".$info['size']."' ORDER BY title ASC",$info['option_no']);

		$info['imgHtml'] = '';
		for($s=1;$s<6;$s++){
			if($info['file'.$s] == ''){ continue; }

			$info['imgHtml'] .= '<li class="prNb imgUl_li plusImgRead" data-no="'.$s.'">
							<img class="pr w100_hAtuo" src="/upload/adopt/'.$info['file'.$s].'" '.$height.' />
							<span class="pa remove removeImgBtn">
								x
							</span>
						</li>';
		}

		$info['error'] = 1;

		echo json_encode($info);
	}else{
		echo json_encode(array("error"=>0,"data"=>"정보가 없습니다."));
	}
}else if($VAL['mode'] == 'all_talk_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_talk.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE talk SET status='".$VAL['status']."' WHERE talk_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_talk_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_talk.php";
	if(count($chk_no) > 0){
		if($VAL['type'] == 'listTable'){
			for($i=0;$i<count($chk_no);$i++){
				$info = $db->get_data("SELECT * FROM talk WHERE talk_no='".$chk_no[$i]."'");
				$link = $_SERVER['DOCUMENT_ROOT']."/upload/talk/".$info['file1'];
				@unlink($link);

				$list = $db->get_list("SELECT * FROM talk_detail WHERE talk_no='".$chk_no[$i]."' AND type='image'");
				for($e=0;$e<count($list['detail_no']);$e++){
					$link = $_SERVER['DOCUMENT_ROOT']."/upload/talk_detail/".$list['file1'][$e];
					@unlink($link);
				}

				$db->query("DELETE FROM talk_detail WHERE talk_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM talk_good WHERE talk_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM talk_goods WHERE talk_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM talk_comment WHERE talk_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM story WHERE no = '".$chk_no[$i]."' AND type='talk'");

				$VAL = array("mode"=>"delete","talk_no"=>$chk_no[$i]);
				
				F_talk($VAL);
			}
		}else{
			for($i=0;$i<count($chk_no);$i++){
				$db->query("UPDATE talk SET is_main=NULL , is_main_order='0' WHERE talk_no = '".$chk_no[$i]."' ");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'main_list_in_talk'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_talk.php";
	if(count($chk_no) > 0){
		$info = $db->get_data("SELECT COUNT(*) AS cnt FROM talk WHERE is_main='Y'");
		$num = $info['cnt'] + count($chk_no);

		if($num > 1){
			echo json_encode(array("error"=>0,"msg"=>"지정노출은 최대로 1개까지 가능합니다."));
			exit;
		}

		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE talk SET is_main_order='0',is_main='Y' WHERE talk_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"지정노출하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"지정노출할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'main_order_save_talk'){
	for($i=0;$i<count($talk_no);$i++){
		if($talk_no[$i] != ''){
			if($order[$i] == ''){
				$order[$i] = 0;
			}

			$db->query("UPDATE talk SET is_main_order='".$order[$i]."' WHERE talk_no='".$talk_no[$i]."'");
		}
	}

	echo json_encode(array("error"=>1,"msg"=>"저장하였습니다."));
}else if($VAL['mode'] == 'read_talk'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_talk.php";
	$data = array();
	$data['error'] = false;

	if($VAL['talk_no'] != ''){
		$info = F_talk(array("mode"=>"read", "talk_no"=>$VAL['talk_no']));
		$member_info = $db->get_data("SELECT * FROM member WHERE member_no='".$info['member_no']."'");

		if($info["animal_no"] != ''){
			$animal = $db->get_data("SELECT * FROM animal WHERE animal_no='".$info["animal_no"]."'");
			$filter_info = $db->get_data("SELECT * FROM filter_option WHERE option_no='".$animal['fillter_no']."'");
		}

		$memo = $db->get_list("SELECT * FROM talk_admin_memo WHERE talk_no='".$info['talk_no']."'");

		$data['error'] = true;
		$data['talk_no'] = $info['talk_no'];
		$data['talk_status'] = $info['status'];
		$data['talk_title'] = $info["title"].' <a href="/story/talk/detail.html?talk_no='.$info['talk_no'].'" class="aBlue" style="font-size: 12px;">[자세히보기]</a>';
		$data['talk_reg_date'] = $info['reg_date'];
		$data['talk_animal'] = $animal["name"]."/".$animal_gubun_op[$filter_info["type"]]."/".trim($filter_info["title"])." <a href='/admin/member/companion_animal.html?animal_no=".$animal['animal_no']."' class='aBlue'>[회원정보보기]</a>";

		$data['talk_member'] = $member_info['nickname']."/".$member_info['user_id']."/".$member_level_op[$member_info['level']]." <a href='/admin/member/member.html?member_no=".$member_info['member_no']."' class='aBlue'>[회견정보보기]</a>";

		if($info['type'] != ''){
			$filterC = $db->get_list("SELECT * FROM filter_option WHERE gubun='C' AND option_no IN (".$info['type'].") ORDER BY order_num ASC");

			for($i=0;$i<count($filterC['option_no']);$i++){
				if($i == 0){
					$data['talk_type'] = $filterC['title'][$i];
				}else{
					$data['talk_type'] .= "/".$filterC['title'][$i];
				}
			}
		}else{
			$data['talk_type'] = '';
		}

		$data['memo'] = '';

		for($i=0;$i<count($memo['memo_no']);$i++){
			$data['memo'] .= '<span class="pr">'.$memo['reg_date'][$i].'</span>
								<span class="pr">'.$memo['content'][$i].'</span>';
		}
	}

	echo json_encode($data);
}else if($VAL['mode'] == 'talk_memo_insert'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_talk_admin_memo.php";

	if($VAL['talk_no'] != '' && $VAL['memo'] != ''){
		$admin = $db->get_data("SELECT * FROM staff WHERE user_id='".$S_login['user_id']."'");

		$arr = array();
		$arr['mode'] = 'insert';
		$arr['talk_no'] = $VAL['talk_no'];
		$arr['admin_no'] = $admin['no'];
		$arr['admin_name'] = $admin['name'];
		$arr['content'] = $VAL['memo'];

		F_talk_admin_memo($arr);

	}

	echo json_encode(array("error"=>true));
}else if($VAL['mode'] == 'all_reviews_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_reviews.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE reviews SET status='".$VAL['status']."' WHERE reviews_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_reviews_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_reviews.php";
	if(count($chk_no) > 0){
		if($VAL['type'] == 'listTable'){
			for($i=0;$i<count($chk_no);$i++){
				$info = $db->get_data("SELECT * FROM reviews WHERE reviews_no='".$chk_no[$i]."'");
				$link = $_SERVER['DOCUMENT_ROOT']."/upload/reviews/".$info['file1'];
				@unlink($link);

				$list = $db->get_list("SELECT * FROM reviews_detail WHERE reviews_no='".$chk_no[$i]."' AND type='image'");
				for($e=0;$e<count($list['detail_no']);$e++){
					$link = $_SERVER['DOCUMENT_ROOT']."/upload/reviews_detail/".$list['file1'][$e];
					@unlink($link);
				}

				$db->query("DELETE FROM reviews_detail WHERE reviews_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM reviews_good WHERE reviews_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM reviews_goods WHERE reviews_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM reviews_comment WHERE reviews_no = '".$chk_no[$i]."' ");
				$db->query("DELETE FROM story WHERE no = '".$chk_no[$i]."' AND type='reviews'");

				$VAL = array("mode"=>"delete","reviews_no"=>$chk_no[$i]);
				
				F_reviews($VAL);
			}
		}else{
			for($i=0;$i<count($chk_no);$i++){
				$db->query("UPDATE reviews SET is_main=NULL , is_main_order='0' WHERE reviews_no = '".$chk_no[$i]."' ");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'main_list_in_reviews'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_reviews.php";
	if(count($chk_no) > 0){
		$info = $db->get_data("SELECT COUNT(*) AS cnt FROM reviews WHERE is_main='Y'");
		$num = $info['cnt'] + count($chk_no);

		if($num > 4){
			echo json_encode(array("error"=>0,"msg"=>"지정노출은 최대로 4개까지 가능합니다."));
			exit;
		}

		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE reviews SET is_main_order='0',is_main='Y' WHERE reviews_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"지정노출하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"지정노출할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'main_order_save_reviews'){
	for($i=0;$i<count($reviews_no);$i++){
		if($reviews_no[$i] != ''){
			if($order[$i] == ''){
				$order[$i] = 0;
			}

			$db->query("UPDATE reviews SET is_main_order='".$order[$i]."' WHERE reviews_no='".$reviews_no[$i]."'");
		}
	}

	echo json_encode(array("error"=>1,"msg"=>"저장하였습니다."));
}else if($VAL['mode'] == 'read_reviews'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_reviews.php";
	$data = array();
	$data['error'] = false;

	if($VAL['reviews_no'] != ''){
		$info = F_reviews(array("mode"=>"read", "reviews_no"=>$VAL['reviews_no']));
		$member_info = $db->get_data("SELECT * FROM member WHERE member_no='".$info['member_no']."'");

		if($info["animal_no"] != ''){
			$animal = $db->get_data("SELECT * FROM animal WHERE animal_no='".$info["animal_no"]."'");
			$filter_info = $db->get_data("SELECT * FROM filter_option WHERE option_no='".$animal['fillter_no']."'");
		}

		$memo = $db->get_list("SELECT * FROM reviews_admin_memo WHERE reviews_no='".$info['reviews_no']."'");

		$data['error'] = true;
		$data['reviews_no'] = $info['reviews_no'];
		$data['reviews_status'] = $info['status'];
		$data['reviews_title'] = $info["stitle"].' <a href="/story/review/detail.html?reviews_no='.$info['reviews_no'].'" class="aBlue" style="font-size: 12px;">[자세히보기]</a>';
		$data['reviews_titles'] = $info["title"];
		$data['reviews_reg_date'] = $info['reg_date'];
		$data['reviews_animal'] = $animal["name"]."/".$animal_gubun_op[$filter_info["type"]]."/".trim($filter_info["title"])." <a href='/admin/member/companion_animal.html?animal_no=".$animal['animal_no']."' class='aBlue'>[회원정보보기]</a>";

		$data['reviews_member'] = $member_info['nickname']."/".$member_info['user_id']."/".$member_level_op[$member_info['level']]." <a href='/admin/member/member.html?member_no=".$member_info['member_no']."' class='aBlue'>[회견정보보기]</a>";

		$data['reviews_type'] = $filter_liview_op[$info['review_option']];
		$data['reviews_grade'] = $info['grade']."점";

		$data['memo'] = '';

		for($i=0;$i<count($memo['memo_no']);$i++){
			$data['memo'] .= '<span class="pr">'.$memo['reg_date'][$i].'</span>
								<span class="pr">'.$memo['content'][$i].'</span>';
		}
	}

	echo json_encode($data);
}else if($VAL['mode'] == 'reviews_memo_insert'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_reviews_admin_memo.php";

	if($VAL['reviews_no'] != '' && $VAL['memo'] != ''){
		$admin = $db->get_data("SELECT * FROM staff WHERE user_id='".$S_login['user_id']."'");

		$arr = array();
		$arr['mode'] = 'insert';
		$arr['reviews_no'] = $VAL['reviews_no'];
		$arr['admin_no'] = $admin['no'];
		$arr['admin_name'] = $admin['name'];
		$arr['content'] = $VAL['memo'];

		F_reviews_admin_memo($arr);

	}

	echo json_encode(array("error"=>true));
}else if($VAL['mode'] == 'all_studio_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_studio.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE studio SET status='".$VAL['status']."' WHERE studio_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_studio_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_studio.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			$info = $db->get_data("SELECT * FROM studio WHERE studio_no='".$chk_no[$i]."'");
			$link = $_SERVER['DOCUMENT_ROOT']."/upload/studio/".$info['file1'];
			@unlink($link);

			$list = $db->get_list("SELECT * FROM studio_detail WHERE studio_no='".$chk_no[$i]."' AND type='image'");
			for($e=0;$e<count($list['detail_no']);$e++){
				$link = $_SERVER['DOCUMENT_ROOT']."/upload/studio_detail/".$list['file1'][$e];
				@unlink($link);
			}

			$db->query("DELETE FROM studio_detail WHERE studio_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM studio_good WHERE studio_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM studio_goods WHERE studio_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM studio_comment WHERE studio_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM story WHERE no = '".$chk_no[$i]."' AND type='studio'");

			$VAL = array("mode"=>"delete","studio_no"=>$chk_no[$i]);
			
			F_studio($VAL);
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'read_studio'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_studio.php";
	$data = array();
	$data['error'] = false;

	if($VAL['studio_no'] != ''){
		$info = F_studio(array("mode"=>"read", "studio_no"=>$VAL['studio_no']));
		$member_info = $db->get_data("SELECT * FROM member WHERE member_no='".$info['member_no']."'");

		if($info["animal_no"] != ''){
			$animal = $db->get_data("SELECT * FROM animal WHERE animal_no='".$info["animal_no"]."'");
			$filter_info = $db->get_data("SELECT * FROM filter_option WHERE option_no='".$animal['fillter_no']."'");
		}

		$memo = $db->get_list("SELECT * FROM studio_admin_memo WHERE studio_no='".$info['studio_no']."'");

		$data['error'] = true;
		$data['studio_no'] = $info['studio_no'];
		$data['studio_status'] = $info['status'];
		$data['studio_title'] = $info["title"].' <a href="/story/studio/detail.html?studio_no='.$info['studio_no'].'" class="aBlue" style="font-size: 12px;">[자세히보기]</a>';
		$data['studio_reg_date'] = $info['reg_date'];
		$data['studio_animal'] = $animal["name"]."/".$animal_gubun_op[$filter_info["type"]]."/".trim($filter_info["title"])." <a href='/admin/member/companion_animal.html?animal_no=".$animal['animal_no']."' class='aBlue'>[회원정보보기]</a>";

		$data['studio_member'] = $member_info['nickname']."/".$member_info['user_id']."/".$member_level_op[$member_info['level']]." <a href='/admin/member/member.html?member_no=".$member_info['member_no']."' class='aBlue'>[회견정보보기]</a>";

		if($info['type'] != ''){
			$filterC = $db->get_list("SELECT * FROM filter_option WHERE gubun='C' AND option_no IN (".$info['type'].") ORDER BY order_num ASC");

			for($i=0;$i<count($filterC['option_no']);$i++){
				if($i == 0){
					$data['studio_type'] = $filterC['title'][$i];
				}else{
					$data['studio_type'] .= "/".$filterC['title'][$i];
				}
			}
		}else{
			$data['studio_type'] = '';
		}

		$data['memo'] = '';

		for($i=0;$i<count($memo['memo_no']);$i++){
			$data['memo'] .= '<span class="pr">'.$memo['reg_date'][$i].'</span>
								<span class="pr">'.$memo['content'][$i].'</span>';
		}
	}

	echo json_encode($data);
}else if($VAL['mode'] == 'studio_memo_insert'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_studio_admin_memo.php";

	if($VAL['studio_no'] != '' && $VAL['memo'] != ''){
		$admin = $db->get_data("SELECT * FROM staff WHERE user_id='".$S_login['user_id']."'");

		$arr = array();
		$arr['mode'] = 'insert';
		$arr['studio_no'] = $VAL['studio_no'];
		$arr['admin_no'] = $admin['no'];
		$arr['admin_name'] = $admin['name'];
		$arr['content'] = $VAL['memo'];

		F_studio_admin_memo($arr);

	}

	echo json_encode(array("error"=>true));
}else if($VAL['mode'] == 'all_help_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_help.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE help SET status='".$VAL['status']."' WHERE help_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_help_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_help.php";
	
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			$info = $db->get_data("SELECT * FROM help WHERE help_no='".$chk_no[$i]."'");

			for($e=1;$e<6;$e++){
				if($info['file'.$e] == ''){ continue; }
				$link = $_SERVER['DOCUMENT_ROOT']."/upload/help/".$info['file'.$e];
				@unlink($link);
			}

			$db->query("DELETE FROM help_good WHERE help_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM help_comment WHERE help_no = '".$chk_no[$i]."' ");

			$VALS = array("mode"=>"delete","help_no"=>$chk_no[$i]);
			
			F_help($VALS);
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'read_help'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_help.php";
	$data = array();
	$data['error'] = false;

	if($VAL['help_no'] != ''){
		$info = F_help(array("mode"=>"read", "help_no"=>$VAL['help_no']));
		$member_info = $db->get_data("SELECT * FROM member WHERE member_no='".$info['member_no']."'");

		$filter_info = $db->get_data("SELECT * FROM filter_option WHERE option_no='".$info['title_option']."'");

		$data['help_animal'] = $info["animal_name"]."/".$animal_gubun_op[$filter_info["type"]]."/".trim($filter_info["title"]);

		if($info["animal_no"] != ''){
			$data['help_animal'] .= " <a href='/admin/member/companion_animal.html?animal_no=".$info['animal_no']."' class='aBlue'>[회원정보보기]</a>";
		}

		$memo = $db->get_list("SELECT * FROM help_admin_memo WHERE help_no='".$info['help_no']."'");

		$data['error'] = true;
		$data['help_no'] = $info['help_no'];
		$data['help_status'] = $info['status'];
		$data['disappear_date'] = $info['disappear_date'];
		$data['coat_colour'] = $info['coat_colour'];
		$data['disappear_addr'] = $info['disappear_addr'];
		$data['help_content'] = $info['content'];
		$data['help_title'] = $info["title"].' <a href="/story/help/detail.html?help_no='.$info['help_no'].'" class="aBlue" style="font-size: 12px;">[자세히보기]</a>';

		$data['help_reg_date'] = $info['reg_date'];
		$data['help_member'] = $member_info['nickname']."/".$member_info['user_id']."/".$member_level_op[$member_info['level']]." <a href='/admin/member/member.html?member_no=".$member_info['member_no']."' class='aBlue'>[회견정보보기]</a>";

		$data['memo'] = '';

		for($i=0;$i<count($memo['memo_no']);$i++){
			$data['memo'] .= '<span class="pr">'.$memo['reg_date'][$i].'</span>
								<span class="pr">'.$memo['content'][$i].'</span>';
		}
	}

	echo json_encode($data);
}else if($VAL['mode'] == 'help_memo_insert'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_help_admin_memo.php";

	if($VAL['help_no'] != '' && $VAL['memo'] != ''){
		$admin = $db->get_data("SELECT * FROM staff WHERE user_id='".$S_login['user_id']."'");

		$arr = array();
		$arr['mode'] = 'insert';
		$arr['help_no'] = $VAL['help_no'];
		$arr['admin_no'] = $admin['no'];
		$arr['admin_name'] = $admin['name'];
		$arr['content'] = $VAL['memo'];

		F_help_admin_memo($arr);

	}

	echo json_encode(array("error"=>true));
}else if($VAL['mode'] == 'all_etalk_del'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			$info = $db->get_data("SELECT * FROM etalk WHERE etalk_no='".$chk_no[$i]."'");
			$link = $_SERVER['DOCUMENT_ROOT']."/upload/etalk/".$info['file1'];
			@unlink($link);

			$list = $db->get_list("SELECT * FROM etalk_detail WHERE etalk_no='".$chk_no[$i]."' AND type='image'");
			for($e=0;$e<count($list['detail_no']);$e++){
				$link = $_SERVER['DOCUMENT_ROOT']."/upload/etalk_detail/".$list['file1'][$e];
				@unlink($link);
			}

			$db->query("DELETE FROM etalk_detail WHERE etalk_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM etalk_good WHERE etalk_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM etalk_goods WHERE etalk_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM etalk_comment WHERE etalk_no = '".$chk_no[$i]."' ");
			$db->query("DELETE FROM story WHERE no = '".$chk_no[$i]."' AND type='etalk'");

			$VAL = array("mode"=>"delete","etalk_no"=>$chk_no[$i]);
			
			F_etalk($VAL);
		}

		echo json_encode(array("error"=>1,"msg"=>"삭제하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"삭제할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'all_etalk_stat'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk.php";
	if(count($chk_no) > 0){
		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE etalk SET status='".$VAL['status']."' WHERE etalk_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"변경하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"변경할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'main_order_save_etalk'){
	for($i=0;$i<count($etalk_no);$i++){
		if($etalk_no[$i] != ''){
			if($order[$i] == ''){
				$order[$i] = 0;
			}

			$db->query("UPDATE etalk SET is_main_order='".$order[$i]."' WHERE etalk_no='".$etalk_no[$i]."'");
		}
	}

	echo json_encode(array("error"=>1,"msg"=>"저장하였습니다."));
}else if($VAL['mode'] == 'main_list_in_etalk'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk.php";
	if(count($chk_no) > 0){
		$info = $db->get_data("SELECT COUNT(*) AS cnt FROM etalk WHERE is_main='Y'");
		$num = $info['cnt'] + count($chk_no);

		if($num > 1){
			echo json_encode(array("error"=>0,"msg"=>"지정노출은 최대로 1개까지 가능합니다."));
			exit;
		}

		for($i=0;$i<count($chk_no);$i++){
			if($chk_no[$i] != ''){
				$db->query("UPDATE etalk SET is_main_order='0',is_main='Y' WHERE etalk_no='".$chk_no[$i]."'");
			}
		}

		echo json_encode(array("error"=>1,"msg"=>"지정노출하였습니다."));
	}else{
		echo json_encode(array("error"=>0,"msg"=>"지정노출할 항목이 없습니다."));
	}
}else if($VAL['mode'] == 'read_etalk'){
	include $_SERVER['DOCUMENT_ROOT']."/_library/function_etalk.php";
	$data = array();
	$data['error'] = false;

	if($VAL['etalk_no'] != ''){
		$info = F_etalk(array("mode"=>"read", "etalk_no"=>$VAL['etalk_no']));
		$member_info = $db->get_data("SELECT * FROM member WHERE member_no='".$info['member_no']."'");

		$memo = $db->get_list("SELECT * FROM etalk_admin_memo WHERE etalk_no='".$info['etalk_no']."'");

		$data['error'] = true;
		$data['etalk_no'] = $info['etalk_no'];
		$data['etalk_status'] = $info['status'];
		$data['etalk_title'] = $info["title"].' <a href="/story/etalk/detail.html?etalk_no='.$info['etalk_no'].'" class="aBlue" style="font-size: 12px;">[자세히보기]</a>';
		$data['etalk_reg_date'] = $info['reg_date'];

		if($member_info['option_data'] != ''){
			$data['etalk_animal'] = $member_info['option_data'];
		}else{
			$filter_info = $db->get_data("SELECT * FROM filter_option WHERE option_no='".$member_info['option_no']."'");
			$data['etalk_animal'] = $filter_info['title'];
		}

		$data['etalk_member'] = $member_info['nickname']."/".$member_info['user_id']."/".$member_level_op[$member_info['level']]." <a href='/admin/member/member.html?member_no=".$member_info['member_no']."' class='aBlue'>[회견정보보기]</a>";

		if($info['type'] != ''){
			$filterC = $db->get_list("SELECT * FROM filter_option WHERE gubun='C' AND option_no IN (".$info['type'].") ORDER BY order_num ASC");

			for($i=0;$i<count($filterC['option_no']);$i++){
				if($i == 0){
					$data['etalk_type'] = $filterC['title'][$i];
				}else{
					$data['etalk_type'] .= "/".$filterC['title'][$i];
				}
			}
		}else{
			$data['etalk_type'] = '';
		}

		$data['memo'] = '';

		for($i=0;$i<count($memo['memo_no']);$i++){
			$data['memo'] .= '<span class="pr">'.$memo['reg_date'][$i].'</span>
								<span class="pr">'.$memo['content'][$i].'</span>';
		}
	}

	echo json_encode($data);
}
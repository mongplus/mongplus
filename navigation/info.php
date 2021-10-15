<?
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";

$VAL		=	$_POST;

if($VAL['mode'] == 'city_list'){
	$error = array("error"=>false,"html"=>"");
	$list = $db->get_list("SELECT * FROM area WHERE city_no='".$VAL['no']."'");

	if(count($list['area_no']) > 0){
		$error['error'] = true;
		$html = '';

		for($i=0;$i<count($list['area_no']);$i++){
			$num = '';
			$data = $db->get_data("SELECT COUNT(*) AS cnt FROM navigation WHERE area_no='".$list['area_no'][$i]."'");
			$html .= '<li><a class="area_a areaBtn" data-no="'.$list['area_no'][$i].'">'.$list['name'][$i].'('.$data['cnt'].')</a></li>';
		}
		$error['html'] = $html;
	}

	echo json_encode($error);
	exit;
}else if($VAL['mode'] == 'area_list'){
	$error = array("error"=>false,"html"=>"");
	$list = $db->get_list("SELECT * FROM dong WHERE area_no='".$VAL['no']."'");

	if(count($list['dong_no']) > 0){
		$error['error'] = true;
		$html = '';

		for($i=0;$i<count($list['dong_no']);$i++){
			$num = '';
			$data = $db->get_data("SELECT COUNT(*) AS cnt FROM navigation WHERE dong_no='".$list['dong_no'][$i]."'");
			$html .= '<li><a class="area_a dongBtn" data-no="'.$list['dong_no'][$i].'">'.$list['name'][$i].'('.$data['cnt'].')</a></li>';
		}
		$error['html'] = $html;
	}

	echo json_encode($error);
	exit;
}else if($VAL['mode'] == 'read_list'){
	$data = array();
	if($VAL['gubun'] == 'top'){
		$list = $db->get_list("SELECT * FROM navigation WHERE addr LIKE '%".$VAL['navit']."%' OR company='".$VAL['navit']."'");
	}else if($VAL['gubun'] == 'left'){
		$add_query = '';
		if($VAL['filter'] != ''){
			$add_query .= ' AND company="'.$VAL['filter'].'"';
		}

		if($VAL['citys'] != ''){
			$add_query .= ' AND city_no="'.$VAL['citys'].'"';
		}

		if($VAL['areas'] != ''){
			$add_query .= ' AND area_no="'.$VAL['areas'].'"';
		}

		if($VAL['dongs'] != ''){
			$add_query .= ' AND dong_no="'.$VAL['dongs'].'"';
		}

		$list = $db->get_list("SELECT * FROM navigation WHERE 1 ".$add_query);
	}

	for($i=0;$i<count($list['navi_no']);$i++){
		$dat = $db->get_data("SELECT * FROM filter_option WHERE gubun='G' AND option_no='".$list['filter_no'][$i]."'");

		if(strstr($list['url'][$i],"http://") !== false || strstr($list['url'][$i],"https://") !== false){
			$url = $list['url'][$i];
		}else{
			$url = "http://".$list['url'][$i];
		}

		if($list['csy_x'][$i] != '' && $list['csy_y'][$i] != ''){
			$km = getDistance($VAL['lat1'],  $VAL['lng1'],  $list['csy_x'][$i],  $list['csy_y'][$i]);
			$km = round($km,2);
		}else{
			$km = 0;
		}

		$html = '<div class="map_point_info">
					<div class="m_point_name">
						<h3>'.$list['company'][$i].'</h3>
						<a class="m_point_close" onclick="closeBtn()">닫기</a>
					</div>
					<div class="m_point_info_box">
						<div class="m_point_info_box_inner">
							<p>'.$dat['title'].'</p>
							<p>'.$list['addr'][$i].'</p>
							<!--<p class="address2"> 지번 주소(구) 지번 l 경기도 용인시 기흥구 영덕동 1-1</p>-->
							<p><!-- 연락처  -->'.$list['tel'][$i].'</p>
							<a target="_blank" href="'.$url.'">'.$list['url'][$i].'</a>
						</div>
					</div>
					<div class="m_point_btns">
						<a class="m_p_print_btn" onclick="printBtn(\''.$list['csy_x'][$i].'\',\''.$list['csy_y'][$i].'\',\''.$list['navi_no'][$i].'\')" alt="프린트(출력)" title="프린트(출력)">프린트(출력)</a>
						<a class="m_p_share_btn" onclick="shareBtn(\''.$list['csy_x'][$i].'\',\''.$list['csy_y'][$i].'\')" alt="공유하기" title="공유하기">공유하기</a>
					</div>
				</div>';

		$html2 = '<div class="result_list" data-cax="'.$list['csy_x'][$i].'"  data-cay="'.$list['csy_y'][$i].'">
			<ul>
		
				<li>
					<span class="result_title">
					'.$list['company'][$i].'
					</span>
				</li>
				<li>
					<span>
						'.$list['addr'][$i].'
					</span>
				</li>
				<li>
					<span>
						'.$list['tel'][$i].'
					</span>l '.$dat['title'].'
					<span>
						l
					</span>
					<span>
						'.$dat['title'].'
					</span>
				</li>
			</ul>									
		</div>';
		$data[$km][$list['company'][$i]] = array($list['csy_x'][$i],$list['csy_y'][$i],$html,$html2);
	}

	ksort($data);

	echo json_encode($data);
}
?>
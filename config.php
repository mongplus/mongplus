<?
session_start();
//Header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

header("Content-Type: text/html; charset=UTF-8");

$src_root		=	$_SERVER['DOCUMENT_ROOT'];
$save_dir		=	$_SERVER['DOCUMENT_ROOT'].'/_goods_img';
$web_upload_dir	=	"/_goods_img";

//=>  DB 연결계정
$Database_Host			=	"localhost";
$Database_Name			=	"mongplus";
$Database_User			=	"mongplus";
$Database_Password		=	"monG!@#1";

$server_domain = "m.mongplus.com";

$uuid_key		= "mongplus";
$uuid_len		= 24;
$story_uuid		= "ef4b32d53cc64f9e8d220bf0cba1ceda";


if ($double_load != 1){
	include $src_root.'/_common/db_class.php';
	include $src_root.'/_common/common.php';
}
$double_load		=	1;



$SET_INFO['title']	=	"관리자페이지";

$sms_host_id = "mongplus";
$sms_host_key = "*V033H#MXI";
$sms_from_tel = "028638291";

$sms_to_tel = array(
	'01091020190',
	'01091578291'
);

$level_op = array(
	'1'=>'일반회원',
    '3'=>'플러스패밀리회원',
	'2'=>'전문가회원',
	'8'=>'직원',
	'9'=>'관리자',
);

$staff_level_op = array(
    '8'=>'직원'		,
    '9'=>'관리자'	,
);

$member_level_op = array(
    '1'=>'일반회원',
    '3'=>'플러스패밀리회원'	,
	'2'=>'전문가회원'
);

$email_op = array(
	''				=>	'직접입력',
	'hotmail.com'		=>	'hotmail.com',
	'hanmail.net'		=>	'hanmail.net',
	'naver.com'			=>	'naver.com',
	'nate.com'			=>	'nate.com',
	'empal.com'			=>	'empal.com',
	'korea.com'			=>	'korea.com',
);


$yn_op = array(
	'Y'=>	'Y',
	'N'=>	'N',
);


for ($i = 2015; $i <= date("Y")+1; $i++){
	$year_op[$i]		=	$i;
}

for ($i = 1; $i <= 31; $i++){
	$night_op[$i]		=	$i."박".($i+1)."일";
}

for ($i = 3; $i <= 9; $i++){
	$night2_op[$i]		=	$i."박".($i+1)."일";
}
$mon_op = array(
	'01'=>'01',
	'02'=>'02',
	'03'=>'03',
	'04'=>'04',
	'05'=>'05',
	'06'=>'06',
	'07'=>'07',
	'08'=>'08',
	'09'=>'09',
	'10'=>'10',
	'11'=>'11',
	'12'=>'12'
);


$week_op = array(
	'0'=>'일',
	'1'=>'월',
	'2'=>'화',
	'3'=>'수',
	'4'=>'목',
	'5'=>'금',
	'6'=>'토',
);


$week2_op = array(
	'0'=>'<FONT COLOR=red>일</FONT>',
	'1'=>'월',
	'2'=>'화',
	'3'=>'수',
	'4'=>'목',
	'5'=>'금',
	'6'=>'<FONT COLOR=blue>토</fond>',
);

$day_op = array(
	'01'=>'01',
	'02'=>'02',
	'03'=>'03',
	'04'=>'04',
	'05'=>'05',
	'06'=>'06',
	'07'=>'07',
	'08'=>'08',
	'09'=>'09',
	'10'=>'10',
	'11'=>'11',
	'12'=>'12',
	'13'=>'13',
	'14'=>'14',
	'15'=>'15',
	'16'=>'16',
	'17'=>'17',
	'18'=>'18',
	'19'=>'19',
	'20'=>'20',
	'21'=>'21',
	'22'=>'22',
	'23'=>'23',
	'24'=>'24',
	'25'=>'25',
	'26'=>'26',
	'27'=>'27',
	'28'=>'28',
	'29'=>'29',
	'30'=>'30',
	'31'=>'31',
);


$hour_op = array(
	'00'=>'00',
	'01'=>'01',
	'02'=>'02',
	'03'=>'03',
	'04'=>'04',
	'05'=>'05',
	'06'=>'06',
	'07'=>'07',
	'08'=>'08',
	'09'=>'09',
	'10'=>'10',
	'11'=>'11',
	'12'=>'12',
	'13'=>'13',
	'14'=>'14',
	'15'=>'15',
	'16'=>'16',
	'17'=>'17',
	'18'=>'18',
	'19'=>'19',
	'20'=>'20',
	'21'=>'21',
	'22'=>'22',
	'23'=>'23',
);

$min_op = array(
	'00'=>'00',
	'10'=>'10',
	'20'=>'20',
	'30'=>'30',
	'40'=>'40',
	'50'=>'50',
);


$cnt_op = array(
	'1'=>'1',
	'2'=>'2',
	'3'=>'3',
	'4'=>'4',
	'5'=>'5',
	'6'=>'6',
	'7'=>'7',
	'8'=>'8',
	'9'=>'9',
	'10'=>'10',
	'11'=>'11',
	'12'=>'12',
	'13'=>'13',
	'14'=>'14',
	'15'=>'15',
);
//=>	성별
$sex_op = array(
	'9'=>'무관',
	'1'=>'남성',
	'2'=>'여성',
);

$sex2_op = array(
	'1'=>'남',
	'2'=>'여',
);

$sex3_op = array(
	'B'=>'남아',
	'G'=>'여아',
);

$sex_anim_op = array(
	'1'=>'수컷',
	'2'=>'암컷',
);

$sex_anim_op2 = array(
	'1'=>'남아',
	'2'=>'여아',
);


$tel_op	= array(
				'02'=>'02',
				'031'=>'031',
				'032'=>'032',
				'033'=>'033',
				'041'=>'041',
				'042'=>'042',
				'043'=>'043',
				'051'=>'051',
				'052'=>'052',
				'053'=>'053',
				'054'=>'054',
				'055'=>'055',
				'061'=>'061',
				'062'=>'062',
				'063'=>'063',
				'064'=>'064',
				'070'=>'070',
				'080'=>'080',
				'1544'=>'1544',
				'1588'=>'1588',
				'1666'=>'1666',
				'1644'=>'1644',
);


$hp_op	= array(
				'010'=>'010',
				'011'=>'011',
				'013'=>'013',
				'016'=>'016',
				'017'=>'017',
				'018'=>'018',
				'019'=>'019',
);


$job_op = array(
			"무직"				=>	"무직",
			"학생"				=>	"학생",
			"컴퓨터/인터넷"		=>	"컴퓨터/인터넷",
			"언론"				=>	"언론",
			"공무원"			=>	"공무원",
			"군인"				=>	"군인",
			"서비스업"			=>	"서비스업",
			"교육"				=>	"교육",
			"금융/증권/보험업"	=>	"금융/증권/보험업",
			"유통업"			=>	"유통업",
			"예술"				=>	"예술",
			"의료"				=>	"의료",
			"법률"				=>	"법률",
			"건설업"			=>	"건설업",
			"제조업"			=>	"제조업",
			"부동산업"			=>	"부동산업",
			"운송업"			=>	"운송업",
			"농/수/임업"		=>	"농/수/임업",
			"광산업"			=>	"광산업",
			"가사"				=>	"가사",
			"기타"				=>	"기타",
);

$city_str_op = array(
	"Y" => "있음",
	"N" => "없음"
);

$yn_str_op = array(
	"Y" => "확인",
	"N" => "미확인"
);

$exYN_op = array(
	"Y" => "노출",
	"N" => "노출안함"
);

$exYN_two_op = array(
	"Y" => "노출",
	"N" => "숨김"
);

$use_op = array(
	"Y" => "사용함",
	"N" => "사용안함"
);

$neutr_str_op = array(
	"Y" => "예",
	"N" => "아니오"
);

$use_two_op = array(
	"N" => "사용안함",
	"Y" => "사용함"
);

$pop_op = array(
	"T" => "텍스트",
	"I" => "이미지"
);

$pop_op2 = array(
	"Y" => "노출",
	"N" => "강제종료"
);

$hour_op2 = array(
	'00'=>'00 시',
	'01'=>'01 시',
	'02'=>'02 시',
	'03'=>'03 시',
	'04'=>'04 시',
	'05'=>'05 시',
	'06'=>'06 시',
	'07'=>'07 시',
	'08'=>'08 시',
	'09'=>'09 시',
	'10'=>'10 시',
	'11'=>'11 시',
	'12'=>'12 시',
	'13'=>'13 시',
	'14'=>'14 시',
	'15'=>'15 시',
	'16'=>'16 시',
	'17'=>'17 시',
	'18'=>'18 시',
	'19'=>'19 시',
	'20'=>'20 시',
	'21'=>'21 시',
	'22'=>'22 시',
	'23'=>'23 시',
);

$animal_gubun_op = array(
	"D" => "강아지",
	"C" => "고양이",
	"O" => "기타반려동물"
);

$animal_code_gubun_op = array(
	"D" => "1",
	"C" => "2",
	"O" => "3"
);

$animal_gubun2_op = array(
	"D" => "강아지",
	"C" => "고양이",
	"O" => "기타"
);

$p_status_op = array(
	"S" => "판매대기",
	"Y" => "판매중",
	"N" => "판매중지",
	"D" => "품절",
);

$p_category_op = array(
	"M" => "몽마켓",
	"K" => "큐레이션",
);

$show_op = array(
	"Y" => "전체",
	"P" => "PC",
	"A" => "APP"
);

$display_op = array(
	"P" => "PC",
	"A" => "APP"
);

$product_status_op = array(
	"S" => "판매대기",
	"Y" => "판매중",
	"N" => "판매중지",
	"D" => "품절"
);

$basic_op = array(
	"Y" => "기본설정",
	"N" => "개별설정"
);

$payment_pay_op = array(
	"B" => "무통장입금",
	"C" => "신용카드",
	"E" => "간편결제"
);

$payment_pay2_op = array(
	"B" => "SC0040",
	"C" => "SC0010",
	"E" => "SC0010"
);

$payment_easy_pay_op = array(
	"P" => "페이코",
	"K" => "카카오페이"
);

$payment_easy_pay2_op = array(
	"P" => "PAYCO",
	"K" => "KAKAOPAY"
);

/*$benefits_mem_op = array(
	"A" => "전체(비회원포함)",
	"M" => "회원전용(비회원제외)",
	"V" => "특정회원등급"
);*/
$benefits_mem_op = array(
	"M" => "전체",//회원전용(비회원제외)
	"V" => "특정회원등급"
);

$benefits2_chk_op = array(
	"N" => "상품 적립금 적립 제외"
);

$brand_gubun_op = array(
	"D" => "강아지",
	"C" => "고양이",
	"O" => "기타",
	"A" => "전체"
);

$staff_op = array(
	"Y" => "정상",
	"N" => "사용중지"
);

$staff_master_op = array(
	"Y" => "정상",
	"N" => "사용중지"
);

$staff_master_op = array(
    '7'=>'담당자',
    '8'=>'관리자',
    '9'=>'최고관리자'
);

$filter_op = array(
    'A'=>'반려동물종류',
    'B'=>'연령대',
    'C'=>'콘텐츠유형',
    'D'=>'리뷰유형',
    'E'=>'기념일',
    'F'=>'전문가활동분야',
    'G'=>'네비업종',
    'H'=>'전문가톡톡유형',
    'I'=>'전문가톡톡태그',
);

$filter_D_op = array(
	'S' => '소형견',
	'M' => '중형견',
	'B' => '대형견',
);

$filter_C_op = array(
	'S' => '단모종',
	'L' => '장모종'
);

$filter_O_op = array(
	'K' => '종류'
);

$filter_liview_op = array(
	'P' => '제품리뷰',
	'S' => '서비스리뷰',
);

$filter_expert_op = array(
	'M' => '의료서비스',
	'E' => '교육훈련/치유',
	'S' => '서비스/문화',
	'F' => '사료/간식',
	'O' => '기타'
);

$season_op = array(
	'A' => '봄',
	'B' => '여름',
	'C' => '가을',
	'D' => '겨울'
);

$benefits_chk_op = array(
	"Y" => "기본설정",
	"N" => "개별설정",
);

$pro_op_stoc_op = array(
	"Y" => "정상",
	"N" => "품절",
);

$product_search_op = array(
	"product_name" => "상품명",
	"product_code" => "상품코드",
	"n_goods"	   => "모델명",
	"brand"		   => "브랜드",
);

$product_search2_op = array(
	"product_name" => "상품명",
	"product_code" => "상품코드",
	//"n_goods"	   => "모델명",
	"brand"		   => "브랜드",
	"keword"	   => "검색키워드",
);

$pro_search_order_op = array(
	"reg_date ASC" => "등록일순",
	"reg_date DESC" => "등록일역순",
	"s_price ASC" => "판매가순",
	"s_price DESC" => "판매가역순",
	"product_name ASC" => "가나다순",
	"product_name DESC" => "가나다역순",
	"hit ASC" => "조회수순",
	"hit DESC" => "조회수역순",
);

$pro_search_limit_op = array(
	"20" => "20개씩",
	"40" => "40개씩",
	"60" => "60개씩",
	"80" => "80개씩",
	"100" => "100개씩",
	"150" => "150개씩",
	"200" => "200개씩",
);


$pro_fil_op = array(
	"Y" => "설정",
	"N" => "설정안함",
);

$minute_op = array();
for($i=0;$i<60;$i++){
	$m = $i;

	if($m < 10){
		$m = "0".$m;
	}

	$minute_op[$m] = $m." 분";
}

$coupon_gubun_op = array(
	//"P" => "상품쿠폰",
	"O" => "주문서쿠폰",
);

$coupon_gubun2_op = array(
	"A" => "전체",
	"P" => "상품쿠폰",
	"O" => "주문서쿠폰",
);

$coupon_overlap_op = array(
	"N" => "제한없음",
	"C" => "쿠폰만 사용",
	"M" => "회원등급할인만 사용",
);

$cnt2_op = array();
for($i=1;$i<=10;$i++){
	$cnt2_op[$i]=$i;
}

$coupon_restore_op = array(
	"Y" => "복원함",
	"N" => "복원불가",
);

$coupon_sale_op = array(
	"A" => "할인금액",
	"B" => "할인율",
	"C" => "적립금액",
	"D" => "적립율"
);

$coupon_mem_op = array(
	"10" => "모든회원",
	"1" => "일반회원",
	"2" => "전문가회원",
	"3" => "플러스패밀리회원"
);

$coupon_terms_op = array(
	"A" => "회원가입시",
	"B" => "플러스패밀리회원전환시",
	"C" => "앱설치시",
	"D" => "배송완료시",
	"E" => "첫구매고객",
	"F" => "반려동물생일"
);

$coupon_product_op = array(
	"A" => "모든상품",
	"C" => "특정카테고리",
	"B" => "특정브랜드",
	"P" => "특정상품",
);

$coupon_search1_op = array(
	"coupon_name" => "쿠폰명",
	"code"		  => "쿠폰번호"
);

$coupon_issue_op = array(
	"L" => "전체",
	"A" => "대상자 지정발급",
	"B" => "조건부 자동발급",
	"C" => "고객 다운로드",
);

$cou_search_order_op = array(
	"issue_date ASC, issue_hour ASC, issue_minute ASC"		=> "쿠폰발급일순",
	"issue_date DESC, issue_hour DESC, issue_minute DESC"	=> "쿠폰발급일역순"
);

$coupon_status_op = array(
	"N" => "발급대기",
	"Y" => "발급중",
	"D" => "발급중지",
	"S" => "기간초과",
);

$navi_stat_op = array(
	"Y" => "발행중",
	"N" => "발행중지"
);

$navi_search_order_op = array(
	"reg_date ASC" => "등록일순",
	"reg_date DESC" => "등록일역순"
);

$navi_search2_op = array(
	"company" => "상호",
	"tel" => "전화번호",
	"addr" => "주소",
);

$navi_license_type_op = array(
	"F" => "프리랜서",
	"I" => "개인사업자",
	"C" => "법인사업자",
);

$shelter_search2_op = array(
	"name" => "보호소명",
	"tel" => "연락처",
	"addr" => "주소",
);
 
$adopt_neutral_op = array(
	"Y" => "유",
	"N" => "무"
);

$qna_search_order_op = array(
	"reg_date DESC" => "등록일순",
	"reg_date ASC" => "등록일역순"
);

$adopt_search2_op = array(
	"shname" => "보호소명",
	"name" => "반려동물이름",
	"shtel" => "연락처",
);

$adopt_search_order_op = array(
	"reg_date ASC" => "등록일순",
	"reg_date DESC" => "등록일역순",
	"hit ASC" => "조회수순",
	"hit DESC" => "조회수역순"
);

$marketing_display_op = array(
	"Y" => "전시",
	"N" => "숨김"
);

$marketing_cate_op = array(
	"T" => "스토리",
	"S" => "SHOP",
	"H" => "전문가"
);

$marketing_page_op = array(
	"M" => "메인",
	"S" => "상세페이지"
);

$market_T_M_position_op = array(
	"S" => "스튜디오 하단",
	"R" => "우측 이벤트 하단",
	"V" => "리뷰 하단",
	"M" => "몽마켓 하단",
);

$market_T_S_position_op = array(
	"C" => "댓글 하단"
);

$market_S_M_position_op = array(
	"P" => "기획전 하단",
	"T" => "인기상품 상단",
	"B" => "인기상품 하단"
);

$market_S_S_position_op = array(
	"C" => "댓글 하단"
);

$market_H_M_position_op = array(
	"M" => "지도 하단",
	"R" => "추천전문가 상단",
	"E" => "우측 이벤트 하단",
	"H" => "전문가톡톡 하단",
);

$market_H_S_position_op = array(
	"C" => "댓글 하단"
);

$member_search_op = array(
	"user_id" => "아이디",
	"name" => "이름",
	"nickname" => "닉네임",
	"tel" => "전화번호",
);

$member_search_find_op = array(
	"0" => "전체",
	"1" => "일반회원",
	"3" => "플러스 패밀리용"
);

$member_search2_find_op = array(
	"0" => "전체",
	"1" => "일반회원",
	"3" => "플러스 패밀리용",
	"2" => "전문가회원"
);

$member_search_order_op = array(
	"reg_date DESC" => "가입일순",
	"reg_date ASC" => "가입일역순",
	"name ASC" => "이름가나다순",
	"name DESC" => "이름가나다역순"
);

$member_search2_order_op = array(
	"del_date DESC" => "탈퇴일순",
	"del_date ASC" => "탈퇴일역순",
	"name ASC" => "이름가나다순",
	"name DESC" => "이름가나다역순"
);

$animal_search_order_op = array(
	"reg_date ASC" => "등록일순",
	"reg_date DESC" => "등록일역순",
	"name ASC" => "이름가나다순",
	"name DESC" => "이름가나다역순"
);

$member_read_op = array(
	"1" => "일반회원",
	"3" => "플러스 패밀리용"
);

$member_use_op = array(
	"Y" => "인증",
	"N" => "인증거부"
);

$member_use_expert_op = array(
	"Y" => "인증완료",
	"N" => "인증대기"
);

$member_is_mail_op = array(
	"Y" => "동의",
	"N" => "미동의"
);

$animal_search_find_op = array(
	"name" => "반려동물이름",
	"member_name" => "등록자닉네임",
	"serial" => "시리얼번호",
);

$animal_search_gubun_op = array(
	"A" => "전체",
	"D" => "강아지",
	"C" => "고양이",
	"O" => "기타반려동물",
);

$icon_info_op = array(
	"A" => "SALE",
	"B" => "초특가",
	"C" => "기획전",
	"D" => "신상품",
	"E" => "BEST",
	"F" => "무료배송",
);

$icon_thum_img_op = array(
	"A" => "thumb-icon-01",
	"B" => "thumb-icon-02",
	"C" => "thumb-icon-03",
	"D" => "thumb-icon-04",
	"E" => "thumb-icon-05",
	"F" => "thumb-icon-06",
);

$shop_mong_search_op = array(
	"popularity" => "인기순",
	"recommend"  => "추천순",
	"appraisal"  => "상품평순",
	"new"		 => "최신순",
	"minPrice"	 => "낮은 가격순",
	"maxPrice"	 => "높은 가격순",
);

$payment_type_op = array(
	"N" => "입금대기",
	"P" => "결제완료",
	"A" => "배송준비",
	"B" => "배송중",
	"Y" => "배송완료",
	"D" => "취소접수",
	//"H" => "취소철회",
	"C" => "취소완료",
	"E" => "교환접수",
	//"I" => "교환철회",
	"F" => "교환완료",
	"G" => "환불접수",
	//"J" => "환불철회",
	"R" => "환불완료",
);

$order_search_paytype_op = array(
	"N" => "입금대기",
	"P" => "결제완료",
	"A" => "배송준비",
	"B" => "배송중",
	"Y" => "배송완료",
	"C" => "취소",
	"F" => "교환",
	"R" => "환불",
);

$order_search_paytype_op2 = array(
	"D" => "취소접수",
	//"H" => "취소철회",
	"C" => "취소완료",
	"N" => "입금대기",
	"P" => "결제완료",
	"A" => "배송준비",
	"B" => "배송중",
	"Y" => "배송완료",
);

$order_search_paytype_op3 = array(
	"E" => "교환접수",
	//"I" => "교환철회",
	"F" => "교환완료",
	"N" => "입금대기",
	"P" => "결제완료",
	"A" => "배송준비",
	"B" => "배송중",
	"Y" => "배송완료",
);

$order_search_paytype_op4 = array(
	"G" => "환불접수",
	//"J" => "환불철회",
	"R" => "환불완료",
	"N" => "입금대기",
	"P" => "결제완료",
	"A" => "배송준비",
	"B" => "배송중",
	"Y" => "배송완료",
);

$order_search_op = array(
	"order_code"	 => "주문번호",
	"invoice_no"	 => "송장번호",
	"product_name"	 => "상품명",
	"product_code"	 => "상품코드",
	"or_name"		 => "주문자명",
	"or_id"			 => "주문자아이디",
	"or_nickname"	 => "주문자닉네임",
	"or_tel"		 => "주문자연락처",
	"or_email"		 => "주문자이메일",
);

$order_order_search_op = array(
	"reg_date ASC" => "주문일순",
	"reg_date DESC" => "주문일역순",
	"true_price ASC" => "총결제금액순",
	"true_price DESC" => "총결제금액역순",
);

$order_order_search_op3 = array(
	"cancel_date ASC" => "취소접수일순",
	"cancel_date DESC" => "취소접수일역순",
	"reg_date ASC" => "주문일순",
	"reg_date DESC" => "주문일역순",
	"true_price ASC" => "총결제금액순",
	"true_price DESC" => "총결제금액역순",
);

$order_order_search_op4 = array(
	"cancel_date ASC" => "교환접수일순",
	"cancel_date DESC" => "교환접수일역순",
	"reg_date ASC" => "주문일순",
	"reg_date DESC" => "주문일역순",
	"true_price ASC" => "총결제금액순",
	"true_price DESC" => "총결제금액역순",
);

$order_order_search_op5 = array(
	"cancel_date ASC" => "환불접수일순",
	"cancel_date DESC" => "환불접수일역순",
	"reg_date ASC" => "주문일순",
	"reg_date DESC" => "주문일역순",
	"true_price ASC" => "총결제금액순",
	"true_price DESC" => "총결제금액역순",
);

$order_order_search_op2 = array(
	"reg_date ASC" => "주문일순",
	"reg_date DESC" => "주문일역순",
	"pay_date ASC" => "결제일순",
	"pay_date DESC" => "결제일역순",
	"true_price ASC" => "총결제금액순",
	"true_price DESC" => "총결제금액역순",
);

$order_cancel_op = array(
	"A" => "단순변심",
	"B" => "상품품절",
	"C" => "배송지연",
	"D" => "배송불가지역",
	"E" => "중복주문",
	"F" => "시스템오류",
	"G" => "누락배송",
	"H" => "택배분실",
	"I" => "상품불량",
	"J" => "포장불량",
	"K" => "상품정보상이",
	"L" => "서비스불만족",
	"M" => "기타"
);

$bank_op = array(
	"A" => "스탠다드차타드은행",
	"B" => "BNK경남은행",
	"C" => "광주은행",
	"D" => "KB국민은행",
	"E" => "IBK기업은행",
	"F" => "NHBank",
	"G" => "대구은행",
	"H" => "BNK부산은행",
	"I" => "KDB산업은행",
	"J" => "MG새마을금고",
	"K" => "SH수협은행",
	"L" => "신협은행",
	"M" => "KEB하나은행",
	"N" => "우리은행",
	"O" => "인터넷우체국",
	"P" => "전북은행",
	"Q" => "제주은행",
	"R" => "한국씨티은행",
);

$coupon_issue_search_op = array(
	"user_id" => "아이디",
	"name" => "이름"
);

$coupon_issue_status_op = array(
	"Y" => "사용",
	"N" => "미사용"
);

$coupon_search_order_op = array(
	" ci.use_date ASC" => "쿠폰사용일순",
	" ci.use_date DESC" => "쿠폰사용일역순",
);

$pro_question_op = array(
	"A" => "상품",
	"B" => "배송",
	"C" => "반품/교환/환불",
	"D" => "기타",
);

$pro_question_object_op = array(
	"product_name" => "상품명",
	"name" => "이름",
	"nickname" => "닉네임",
	"content" => "문의내용",
);

$birth_fillter_op = array(
	"A" => "8년 이상",
	"B" => "24개월~8년",
	"C" => "12~24개월",
	"D" => "6~12개월",
	"E" => "6개월 미만",
);

$birth_fillters_op = array(
	"A" => 108,
	"B" => 96,//8년
	"C" => 24,
	"D" => 12,
	"E" => 5
);

$pro_search_curation_op = array(
	"hit DESC" => "인기순",
	"recommend DESC" => "추천순",
	"grade DESC" => "상품평순",
	"reg_date DESC" => "최신순",
	"s_price ASC" => "낮은가격순",
	"s_price DESC" => "높은가격순",
	
);

$seachr_hangle_op = array(
	"A" => "ㄱ",
	"B" => "ㄴ",
	"C" => "ㄷ",
	"D" => "ㄹ",
	"E" => "ㅁ",
	"F" => "ㅂ",
	"G" => "ㅅ",
	"H" => "ㅇ",
	"I" => "ㅈ",
	"J" => "ㅊ",
	"K" => "ㅋ",
	"L" => "ㅌ",
	"M" => "ㅎ"
);

$seachr_hangle_op2 = array(
	"A" => array("가","나"),
	"B" => array("나","다"),
	"C" => array("다","라"),
	"D" => array("라","마"),
	"E" => array("마","바"),
	"F" => array("바","사"),
	"G" => array("사","아"),
	"H" => array("아","자"),
	"I" => array("자","차"),
	"J" => array("차","카"),
	"K" => array("카","타"),
	"L" => array("타","하"),
	"M" => array("하","")
);

$talk_search_op = array(
	"reg_date DESC" => "최신순",
	"hit DESC" => "인기순",
	"good DESC" => "추천순"
);

$talk_admin_search_op = array(
	"title" => "제목",
	"nickname" => "작성자닉네임",
	"animal_name" => "반려동물이름"
);

$help_admin_search_op = array(
	"name" => "작성자",
	"nickname" => "닉네임",
	"animal_name" => "반려동물이름",
	"tel" => "연락처",
);

$qna_search_op = array(
	"name" => "이름",
	"email" => "이메일",
	"tel" => "전화번호"
);

$sms_id_link = array(
	"F" => "페이스북",
	"I" => "인스타그램",
	"T" => "트위터",
	"N" => "네이버블로그",
	"Y" => "유튜브",
	"K" => "카카오스토리"
);

$faq_type_op = array(
	"A" => "주문결제",
	"B" => "배송문의",
	"C" => "반품/교환/환불",
	"D" => "증빙서류발급",
	"E" => "회원서비스",
	"F" => "기타",
);

if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	$ip_address = $_SERVER['HTTP_CLIENT_IP'];
}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{
	$ip_address = $_SERVER['REMOTE_ADDR'];
}

/*
"주문접수" => "order",
"입금확인" => "payok",
"입금요청" => "payr",
"주문취소" => "cancel",
"환불완료" => "refund",
"쿠폰발행" => "coupon",
"첫게시글알림" => "fboard",
"구독신청" => "channel",
"댓글등록" => "comment",
"쪽지알림" => "message",
"스크랩" => "scrap",
"상품문의답변알림" => "pcomment",
"채널공지" => "channeln",
추가는 아래로 추가하고 순서는 변경불가
*/
$push_gubun_op = array(
	"0" => "order",
	"1" => "payok",
	"2" => "payr",
	"3" => "cancel",
	"4" => "refund",
	"5" => "coupon",
	"6" => "fboard",
	"7" => "channel",
	"8" => "comment",
	"9" => "message",
	"10" => "scrap",
	"11" => "pcomment",
	"12" => "channeln"
);

$push_gubun_name_op = array(
	"0" => "주문접수",
	"1" => "입금확인",
	"2" => "입금요청",
	"3" => "주문취소",
	"4" => "환불완료",
	"5" => "쿠폰발행",
	"6" => "첫 게시글 알림",
	"7" => "구독신청",
	"8" => "댓글알림",
	"9" => "쪽지알림",
	"10" => "스크랩",
	"11" => "상품문의 답변알림"
);

$push_substr_op = array(
	"{shopName}", 
	"{orderNo}", 
	"{settlePrice}", 
	"{orderName}", 
	"{memberNm}", 
	"{account}", 
	"{nickName}", 
	"{couponNm}"
);

$sms_substr_op = array(
	"{shopName}", 
	"{orderNo}", 
	"{settlePrice}", 
	"{orderName}", 
	"{memberNm}", 
	"{account}"
);

$mongpay_bank_op = array(
	"001" => "한국은행",
	"002" => "KDB산업은행",
	"003" => "IBK기업은행",
	"004" => "KB국민은행",
	"007" => "SH수협은행",
	"008" => "한국수출입은행",
	"011" => "NH농협은행",
	"020" => "우리은행",
	"023" => "SC제일은행",
	"027" => "한국씨티은행",
	"031" => "대구은행",
	"032" => "부산은행",
	"034" => "광주은행",
	"035" => "제주은행",
	"037" => "전북은행",
	"039" => "경남은행",
	"045" => "새마을금고",
	"048" => "신용협동조합",
	"081" => "KEB하나은행",
	"088" => "신한은행",
	"089" => "케이뱅크",
	"090" => "카카오뱅크",
	"071" => "우체국"
);

$order_review_op = array(
	"orderNo" => "주문번호",
	"invoice_no" => "송장번호",
	"pro_name" => "상품명",
	"pro_code" => "상품코드",
	"o_name" => "주문자명",
	"o_id" => "주문자아이디",
	"o_nickname" => "주문자닉네임",
	"o_tel" => "주문자연락처",
	"o_email" => "주문자이메일"
);

$order_review_order_op = array(
	"r.reg_date DESC" => "리뷰등록일순",
	"r.reg_date ASC" => "리뷰등록일역순"
);

$order_o_add_status_op = array(
	"A" => "APP",
	"P" => "PC",
	"H" => "수기등록",
);

$city_name_op = array(
	"seoul" => "서울",
	"gangwon" => "강원",
	"incheon" => "인천",
	"gyunggi" => "경기",
	"chungnam" => "충남",
	"chungbuk" => "충북",
	"gyeongbuk" => "경북",
	"sejong" => "세종",
	"jeonbuk" => "전북",
	"daegu" => "대구",
	"ulsan" => "울산",
	"gwangju" => "광주",
	"gyeongnam" => "경남",
	"busan" => "부산",
	"jeonnam" => "전남",
	"jeju" => "제주"
	//"daejeon" => "대전광역시",
);

$message_line = "---------------------------------------------------";
?>

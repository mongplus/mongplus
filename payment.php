<?
//=>	정보 처리
function F_payment($_L){
	global $db;
	$add_query		=	"";
	$_L['price']			=	preg_replace("/[^0-9\-]/","", $_L['price']);
	if ($_L['mode'] == 'read'){
		$info		=	$db->get_data("
									SELECT 
										*
									FROM 
									payment 
									WHERE 
										payment_no		=	'".$_L['payment_no']."' 
									");
	$info				=	F_strip_slashes($info);
	return	$info;
	}

	$_L					=	F_add_slashes($_L);
	if ($_L['mode'] == 'insert'){
		$query		=	"INSERT INTO payment(										
										payment_no,
										options,
										easy_option,
										detail,
										bank1,
										bank2,
										bank3,
										bank4,
										bank5										
									)
							VALUES(									
										'".$_L['payment_no']."',
										'".$_L['options']."',
										'".$_L['easy_option']."',
										'".$_L['detail']."',
										'".$_L['bank1']."',
										'".$_L['bank2']."',
										'".$_L['bank3']."',
										'".$_L['bank4']."',
										'".$_L['bank5']."'
									)
						";
	}
	if ($_L['mode'] == 'update'){
		if ($_L['file1'])	$add_query			.=	"file1		=	'".$_L['file1']."',";
		$query		=	"UPDATE payment SET
										".$add_query."										
										options			=	'".$_L['options']."',
										easy_option		=	'".$_L['easy_option']."',
										detail			=	'".$_L['detail']."',
										bank1			=	'".$_L['bank1']."',
										bank2			=	'".$_L['bank2']."',
										bank3			=	'".$_L['bank3']."',
										bank4			=	'".$_L['bank4']."',
										bank5			=	'".$_L['bank5']."'
									WHERE
									payment_no			=	'".$_L['payment_no']."'
						";
	}

	if ($_L['mode'] == 'delete'){
		$query		=	"DELETE FROM payment
									WHERE
									payment_no				=	'".$_L['payment_no']."'
						";
	}

	$db->query($query);

}



//=>	 목록 불러오기
function F_payment_list($_L){
	global $db;
	$add_query		=	"";
	$wheres				 =  $_L['wheres'];
	$_L					=	F_add_slashes($_L);
	if ($_L['find_object'] != null && $_L['find_text'] != null){
		$add_query		.=	" AND ".$_L['find_object']." LIKE  '%".$_L['find_text']."%' ";
	}
	if ($_L['add_query']){
		$add_query		.=	stripslashes($_L['add_query']);
	}
	if ($_L['s_area']){
		$add_query		.=	" AND area = '".$_L['s_area']."' ";
	}
	if ($wheres){
		$add_query		.=	$wheres;
	}

	//=>	정렬기준
	if ($_L['order'] != null){
		$order_query		=	" ORDER BY ".$_L['order']." ";
	}
	else{
		$order_query		=	" ORDER BY payment_no DESC ";
	}
	if (sub_eregi("DESC", $order_query)){
		$order_query_2		=	str_replace(" DESC", " ASC", $order_query);
	}
	else{
		$order_query_2		=	str_replace(" ASC", " DESC", $order_query);
	}

	//=>	페이지 네비게이션 표시
	if (!$_L['page']){
		$_L['page'] = 1;
	}
	if ($add_query){
		$querylen			=	strlen($add_query);
		$where_query		=	" WHERE ".substr($add_query, 4, $querylen-4);
	}
	$page_info['cur']		=	$_L['page'];
	$page_info['row']		=	$_L['row'];
	$count_now				=	$page_info['row']*($page_info['cur'] - 1); 
	$top_rows				=	$_L['page'] * $_L['row'];
	$page_info['total']		=	$db->get_data_one("SELECT 
													count(*)
													FROM
													payment 
													$where_query
													");

	//=>	위의 조건에 따라 목록 가져오기
	$query		=	"
					SELECT
						*
					FROM
						payment
					$where_query
					$order_query
						LIMIT ".$count_now.",".$page_info['row']."
						";

	$list						=	$db->get_list($query);

	$list['page_string']		=	print_page_num($page_info);		//페이지 번호 출력하는 
	$list['total']				=	$page_info['total'];
	$list['row']				=	$_L['row'];
	$list['count']				=	count($list['payment_no']);
	return $list;
}


?>

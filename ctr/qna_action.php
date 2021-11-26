<?
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";
include $_SERVER['DOCUMENT_ROOT']."/_library/function_qna.php";
//=>	테이블명을 설정합니다.
$VAL		=	$_POST;
$S_table_name			=	"qna";
$save_dir		= $_SERVER['DOCUMENT_ROOT'].'/upload/qna';

//=>	첨부파일 삭제기능
if ($mode == 'file_delete'){
	F_file_delete(array(
		"table_name"=>	$S_table_name,
		"qna_no"		=>	$qna_no,
		'idx'		=>	$idx,
	));
	history_go();
	exit;
}

if ($mode == 'insert'){
	$VAL['qna_no']				=	$db->get_data_one("SELECT MAX(qna_no) FROM ".$S_table_name."") + 1;
}else{
	$info				=	$db->get_data("SELECT * FROM ".$S_table_name." WHERE qna_no='".$VAL['qna_no']."'");
}

$VAL['content']	= stripslashes($VAL['content']);

F_qna($VAL);

//meta_go("./list.html?qna_no=".$VAL['qna_no']);
meta_go("./center_ad.html");

function F_file_delete($_L){
	global $db, $save_dir;
	$info				=	$db->get_data("SELECT * FROM ".$_L['table_name']." WHERE qna_no='".$_L['qna_no']."'");
	$files				=	'file'.$_L['idx'];
	$real_files			=	'real_filename'.$_L['idx'];
	$pre_file			=	$save_dir."/".$info[$files];
	$pre_file2			=	$save_dir."/".str_replace(".",'_thum.', $info[$files]);
	@unlink($pre_file);
	@unlink($pre_file2);

	$query				=	"UPDATE ".$_L['table_name']." SET ".$files." = '', ".$real_files." = '' WHERE qna_no ='".$_L['qna_no']."'";
	$db->query($query);
}
?>
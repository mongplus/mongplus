<?
include $_SERVER['DOCUMENT_ROOT']."/_common/config.php";
include $_SERVER['DOCUMENT_ROOT']."/_library/function_adopt.php";
//=>	테이블명을 설정합니다.
$VAL		=	$_POST;
$save_dir		= $_SERVER['DOCUMENT_ROOT'].'/upload/adopt';

if ($VAL['mode'] == 'insert'){
	$VAL['adopt_no']	=	$db->get_data_one("SELECT MAX(adopt_no) as adopt_no FROM adopt") + 1;
}else{
	$info = F_adopt(array("mode"=>"read", "adopt_no"=>$VAL['adopt_no']));
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
							'thumnail'		=>	false,
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

F_adopt($VAL);

meta_go("./adopt.html");
?>
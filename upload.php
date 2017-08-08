<?php
	$convname = $_FILES['file']['name'];
	$convfile = $_FILES['file']['tmp_name'];
	$ext = substr($convname, strrpos($convname, '.') + 1);
	do{
		$convname = uniqid(). '.'. $ext;
	}while(file_exists($convname));
	if(stripos($ext, 'txt') !== false){
		$convcode = `nkf -g $convfile`;
		if(strpos($convcode, 'Shift_JIS') !== false || strpos($convcode, 'SJIS') !== false){
			$convcode = 'SJIS-win';
		}
		$buf = @file_get_contents($convfile);
		if(!$buf){
			echo 'false';
			return;
		}
		$text = mb_convert_encoding($buf, 'UTF-8', $convcode);
		`rm $convname`;
		$fp = fopen('./files/'. $convname, 'wb');
		if(!$fp){
			echo 'false';
			return;
		}
		fwrite($fp, $text);
		fclose($fp);
		echo 'true,'. $convname;
	}else{
		if(move_uploaded_file($convfile, './files/'. $convname)){
			echo 'true,'. $convname;
		}else{
			echo 'false';
		}
	}
?>

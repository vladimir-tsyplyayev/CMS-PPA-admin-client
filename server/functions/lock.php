<?
set_time_limit(0);
ini_set ('display_errors', false);
ini_set("memory_limit","16M");
if(file_exists('../operator/timeout.txt')){	$time_out = file_get_contents('../operator/timeout.txt');
}else{	$time_out = 1800;}

if(isset($_GET['lock'])){	if($_GET['lock']==1){		// закрепить заявку за оператором
		if(isset($_GET['id'])){			$filename = urldecode($_GET['id']).'/file_access_locker.txt';
			$file_access_locker = file_get_contents($filename);
			if(strcmp($file_access_locker,'0')==0 || strcmp($file_access_locker,$_COOKIE["user_id"])==0 || (time()-filemtime($filename)>$time_out)){
				$file = fopen($filename,"w");
				fputs ($file, $_COOKIE["user_id"]);
				fclose($file);
				print('ok');
			}else{				print('locked:');
				$hours_delay = (int)(($time_out - (time()-filemtime($filename)))/60/60);
				if($hours_delay>0){print($hours_delay.' часов ');}

                print((int)(($time_out - (time()-filemtime($filename)))/60).' минут'
				);			}
		}else{			print('error_noid');		}
	}else{    	// освободить заявку
		if(isset($_GET['id'])){
			$filename = urldecode($_GET['id']).'/file_access_locker.txt';
			$file_access_locker = trim(file_get_contents($filename))*1;
			if($file_access_locker==$_COOKIE["user_id"]){
				$file = fopen($filename,"w");
				fputs ($file, '0');
				fclose($file);
				print('free');
			}else{
				print('wrong_user');
			}
		}else{
			print('error_noid');
		}	}
}else{
		print('error_noaction');
}
?>
<?
$user_founded=0;
$user_name='';
if(isset($_POST["user"]) && isset($_POST["pass"])){
	$user = $_POST["user"];
	$pass = $_POST["pass"];

	if ($user && $pass){		$files = GLOB('../operators_data/*.txt');
		$users = array();
        foreach($files as $i => $v){        	$data = file($v);
        	if($user==trim($data[1]) && $pass==trim($data[2])){
				$user_founded=1;
				$valid_user = $i;
				setcookie("user_id",trim($data[1]).trim($data[2]));
			}        }
	}
}else{
	if(isset($_COOKIE["user_id"])){
		if($_COOKIE["user_id"]!='0'){
			$files = GLOB('../operators_data/*.txt');
			$users = array();
	        foreach($files as $i => $v){
	        	$data = file($v);
	        	if($_COOKIE["user_id"]==trim($data[1]).trim($data[2])){
					$user_founded=1;
					$valid_user = $i;
				}
	        }
		}
	}else{		setcookie("user_id",'0');	}
}
?>
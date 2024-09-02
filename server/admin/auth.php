<?
$user_founded=0;
$user_name='';
if(isset($_POST["user"]) && isset($_POST["pass"])){
	$user = $_POST["user"];
	$pass = $_POST["pass"];

	if ($user && $pass){       	$data = file('auth.txt');
       	if($user==trim($data[0]) && $pass==trim($data[1])){
			$user_founded=1;
			$valid_user = $i;
			setcookie("user_id",trim($data[0]).trim($data[1]));
		}	}
}else{
	if(isset($_COOKIE["user_id"])){
		if($_COOKIE["user_id"]!='0'){
        	$data = file('auth.txt');
        	if($_COOKIE["user_id"]==trim($data[0]).trim($data[1])){
				$user_founded=1;
				$valid_user = $i;
			}
		}
	}else{		setcookie("user_id",'0');	}
}
?>
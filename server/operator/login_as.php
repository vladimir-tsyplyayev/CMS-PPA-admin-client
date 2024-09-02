<?
$go_back=0;
if(isset($_GET["id"])){
	$files = GLOB('../operators_data/*.txt');
	if(file_exists($files[$_GET["id"]])){
	   	$data = file($files[$_GET["id"]]);
		$user_founded=1;
		$valid_user = $_GET["id"]-1;
		setcookie("user_id",trim($data[1]).trim($data[2]));
	 	print('<script>
		window.location.replace("index.php?a=1");
		</script>');
	}else{$go_back=1;}
}else{$go_back=1;}
if($go_back==1){ 	print('<script>
	window.location.replace("../admin/index.php");
	</script>');}
?>

<?
// Пароль для доступа к XML генератору, который указан в настройках кампании
$pass = file_get_contents('password.txt');

set_time_limit(0);
ini_set ('display_errors', false);
ini_set("memory_limit","16M");

if($_POST['pass']!=md5($pass)){
	die('<?xml version="1.0"?><error>no confirm pass</error>');
}
// Подключение к БД
require('../functions/read_data.php');
$data = read_data('1-1-2010','1-1-2050',0);
$res='';
preg_match_all("/<item>(.*)<\/item>/Uis",$_POST['xml'],$items);
foreach($items[1] as $APID){
	foreach($data as $i => $v){
	 	if(strcmp(trim($v["id"]),trim($APID))==0){

	$res.="
		<item>
			<id>".$APID."</id>
			<status>".$v["status"]."</status>
			<price>0</price>
		</item>";
		}
	}
}
$res='<?xml version="1.0"?><items>'.$res.'</items>';
echo $res;
?>

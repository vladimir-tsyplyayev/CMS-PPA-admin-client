<?
set_time_limit(0);
ini_set ('display_errors', false);
ini_set("memory_limit","16M");
$name = $_GET["name"];
$content = file_get_contents($name);
header("Content-disposition: filename=".$name);
header("Content-type: application/octetstream");
header("Content-Length: ".strlen($content));
header("Pragma: no-cache");
header("Expires: 0");
echo($content);
?>

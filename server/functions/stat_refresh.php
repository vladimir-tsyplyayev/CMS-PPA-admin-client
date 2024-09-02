<?
set_time_limit(0);
ini_set ('display_errors', false);
ini_set("memory_limit","16M");
require('read_data.php');
$operators = GLOB('../operators_data/*.txt');
$data_to_save_day = array();
$data_to_save_month = array();
$data_to_save_all = array();
foreach($operators as $i => $v){	$data_to_save_day[$i] = array();
	$data_to_save_month[$i] = array();
	$data_to_save_all[$i] = array();}



// Day

$data = read_data(date("d-m-Y"),date("d-m-Y"),0);
foreach($data as $i => $v){	if($v["status"]>0){
	 	if(isset($v['operator'])){	 		$data_to_save_day[$v['operator']][$v["status"]]++;
	 	}
	}
}

// Month

$data = read_data(date("d-").(date("m")-1).date("-Y"),date("d-m-Y"),0);
foreach($data as $i => $v){	if($v["status"]>0){
	 	if(isset($v['operator'])){
 			$data_to_save_month[$v['operator']][$v["status"]]++;
	 	}
	}
}

// All time

$data = read_data('1-01-2010','1-01-2111',0);
foreach($data as $i => $v){
	if($v["status"]>0){
	 	if(isset($v['operator'])){
 			$data_to_save_all[$v['operator']][$v["status"]]++;
	 	}
	}
}


for($i=1;$i<=count($operators);$i++){
	$file = fopen('../operator/stat/'.$i.'.txt',"w");
	fputs ($file, 'сегодня: '.($data_to_save_day[$i][1]+0).'/'.($data_to_save_day[$i][2]+0).'/'.($data_to_save_day[$i][3]+0).'/<b>'.($data_to_save_day[$i][1]+$data_to_save_day[$i][2]+$data_to_save_day[$i][3]+0).'</b><br>
за мес: &nbsp;&nbsp;&nbsp;'.($data_to_save_month[$i][1]+0).'/'.($data_to_save_month[$i][2]+0).'/'.($data_to_save_month[$i][3]+0).'/<b>'.($data_to_save_month[$i][1]+$data_to_save_month[$i][2]+$data_to_save_month[$i][3]+0).'</b><br>
всего: &nbsp;&nbsp;&nbsp;&nbsp;'.($data_to_save_all[$i][1]+0).'/'.($data_to_save_all[$i][2]+0).'/'.($data_to_save_all[$i][3]+0).'/<b>'.($data_to_save_all[$i][1]+$data_to_save_all[$i][2]+$data_to_save_all[$i][3]+0).'</b><br>');
	fclose($file);
}

print('<script>
	window.location.replace("../admin/index.php?a=2");
	</script>');

?>

<?
// http://127.0.0.1/ppa/server/post.php

// читаем параметры формы - шаблон
function read_form_template(){
	$form_items = file('admin/form/form_items.txt');
	$form_items_to_fill = array();
	foreach($form_items as $form_items_i => $form_items_v){
		$form_items_to_fill[$form_items_i] = explode('||',trim($form_items_v));
	}
	return $form_items_to_fill;
}



// получаем данные заполненной формы с удаленного сервера и сохраняем в базу данных
	$form_items = read_form_template();

    $landings_files = GLOB('landings/*.txt');
	foreach($landings_files as $i => $v){
		$landings_data[$i] = file($v);
	}

	$counter = file_get_contents('data/counter.txt')*1;
	$counter ++;
	$file = fopen('data/counter.txt',"w");
	$step_timeout = 0;
	while(!flock($file, LOCK_EX) && $step_timeout<1000){		$step_timeout++;
	}
	fputs ($file, $counter);
	flock($file, LOCK_UN);
	fclose($file);

	$YY = date("Y");
    $mm = date("m");
    $dd = date("d");

	if(!file_exists('data/'.$YY)){
		mkdir('data/'.$YY);
	}
	if(!file_exists('data/'.$YY.'/'.$mm)){
		mkdir('data/'.$YY.'/'.$mm);
	}
	if(!file_exists('data/'.$YY.'/'.$mm.'/'.$dd)){
		mkdir('data/'.$YY.'/'.$mm.'/'.$dd);
	}
	if(!file_exists('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter)){
		mkdir('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter);
	}

	foreach($form_items as $i => $v){
		$file = fopen('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter.'/'.trim($v[1]).'.txt',"w");
		fputs ($file, trim($_POST[$v[1]]));
		fclose($file);
	}

		$file = fopen('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter.'/status.txt',"w");
		fputs ($file, 0);
		fclose($file);

		$file = fopen('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter.'/comments.txt',"a");
		fputs ($file, '');
		fclose($file);

		$landing_to_save = '';
		//$post_landing = explode('/',str_replace('http://','',str_replace('https://','',str_replace('www.','',trim($_POST['landing'])))));
		foreach($landings_data as $i => $v){
			//if(strcmp(str_replace('http://','',str_replace('https://','',str_replace('www.','',trim($v[0])))),$post_landing[0])==0){			if(strcmp(trim($v[0]),trim($_POST['landing']))==0){				//print('<script>alert("'.$_POST['landing'].' '.$i.' '.$v.'");</script>');				$landing_to_save = $i;			}
		}

		$file = fopen('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter.'/file_access_locker.txt',"w");
		fputs ($file, '0');
		fclose($file);

		foreach($_POST as $i => $v){
			$file = fopen('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter.'/'.$i.'.txt',"w");
			fputs ($file, trim($v));
		fclose($file);
		}

		$file = fopen('data/'.$YY.'/'.$mm.'/'.$dd.'/'.$counter.'/landing.txt',"w");
		fputs ($file, ($landing_to_save+1));
		fclose($file);

print($counter);

?>
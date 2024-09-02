<?
set_time_limit(0);
ini_set ('display_errors', false);
ini_set("memory_limit","16M");

$post_send_url = file_get_contents("Server_API_URL.txt");

// читаем параметры формы - шаблон

function read_form_template(){
	global $post_send_url;
	$form_items = file($post_send_url.'/form/form_items.txt');
	$form_titles = file($post_send_url.'/form/form_titles.txt');
	$form_items_to_fill = array();
	foreach($form_items as $form_items_i => $form_items_v){
		$form_items_to_fill[$form_items_i] = explode('||',trim($form_items_v));
	}
	return $form_items_to_fill;
}

	// получаем данные отправленной формы

	$form_items = read_form_template();
	$errors = 0;
	$form_value = array();
	$errors_data = array();
	$post_data = array();
	//$post_data['landing'] = $_SERVER['HTTP_HOST'];

	// проверяем ошибки

	foreach($form_items as $i => $v){		if(isset($_GET[trim($v[1])])){			if(strlen(trim($_GET[trim($v[1])]))==0){ // Поле не заполненно
				$errors_data[$i] = 'Заполните ';
				$errors ++;
			}else{
				$post_data[trim($v[1])] = iconv("UTF-8", "WINDOWS-1251",$_GET[trim($v[1])]);
				$form_value[$i] = $_GET[trim($v[1])];
				if(strlen($v[2])>0){ // Если список
	            	if(strcmp('FALSE',$_GET[trim($v[1])])==0 || strcmp(trim($v[0]),iconv("UTF-8", "WINDOWS-1251",$_GET[trim($v[1])]))==0 || strcmp('undefined',$_GET[trim($v[1])])==0){
	            		$errors_data[$i] = 'Выберите из списка ';
	                	$errors ++;
	                	$form_value[$i] = false;
	            	}
				}else{
			    	if(strlen($v[3])>0){ // Если есть шаблон для проверки
			    		if(!preg_match($v[3],$_GET[trim($v[1])])){
			    			$errors_data[$i] = 'Заполните правильно ';
		                	$errors ++;
		    			}
			        }else{			        	if(!isset($_GET[trim($v[1])])) {			        		$errors_data[$i] = 'Заполните ';
		                	$errors ++;			        	}			        }
			    }
			}
        }
	}

    if($errors>0){    	foreach($form_items as $i => $v){    		if(strlen(trim($errors_data[$i]))>0){    		print($errors_data[$i].' '.$v[0].'. <font color="red">'.$v[4].'</font><br>
');
 			}    	}
	}else{		if($_GET['complete']==1){   			// отсылаем на сервер данные
		   	$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $post_send_url.'/post.php');
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
			$r = curl_exec($curl);		}else{			print('all_right');
		}	}

?>
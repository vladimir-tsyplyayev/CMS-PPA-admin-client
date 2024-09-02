<?
// http://127.0.0.1/ppa/server/admin/
if(isset($_GET['a'])){
	if(strcmp($_GET['a'],'logout')==0){
		setcookie("user_id",'0');
		$user_founded=0;
		print('<script>
		window.location.replace("index.php");
		</script>');
	}
}else{
	$_GET['a']=0;
}
require ('auth.php');

print('<head>
<title>Интерфейс Администратора</title><link href="stat/ico.jpg" rel="icon" /><style>
body{font-family:tahoma, Helvetica, sans-serif;font-size:11px;color: #283033; background-image:url(images/bg.jpg); background-position:top left; background-repeat:no-repeat;}
td{font-family:tahoma, Helvetica, sans-serif;font-size:11px;color: #283033;padding-left:15px;padding-top:5px;padding-right:10px;padding-bottom:5px;border: 1px solid #aaaaaa;}
td.menuon { background-color: #000000; color: #FFFFFF; }
td.menuoff { background-color: #FFFFFF; color: #000000; }
a{color: #0066FF;text-decoration:underline;}
a:hover{color: #aaaaaa;text-decoration:underline;}
a:active{color: #283033;}
.loginform1{font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #000000;background-color: #F1F1F1;border: 1px solid #000000;}
.loginformbutton1{font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #000000;background-color: #F1F1F1;border: 1px solid #000000;}
.okbutton{font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #ffffff; font-weight: bold;background-color: #128100;border: 1px solid #000000;}
.pendingbutton{font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #ffffff; font-weight: bold;background-color: #FF8A00;border: 1px solid #000000;}
.badbutton{font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #ffffff; font-weight: bold;background-color: #E90000;border: 1px solid #000000;}
.robutton{font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #ffffff; font-weight: bold;background-color: #000000;border: 1px solid #000000;}
</style>
<link rel="shortcut icon" type="image/gif" href="images/fav.jpg"/>
<link rel="icon" type="image/gif" href="images/fav.jpg"/>
<link rel="stylesheet" type="text/css" media="all" href="../js/calendar-blue.css" title="win2k-cold-1" />
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" src="../js/calendar-en.js"></script>
<script type="text/javascript" src="../js/calendar-setup.js"></script>
</head>');

if($user_founded!=1){
print ('<center><h1>Интерфейс Администратора</h1>
	<form method="post">
	  <table width="200"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="15%">Логин:</td>
          <td><input type="text" id="user" name="user"></td>
        </tr>
        <tr>
          <td width="15%">Пароль:</td>
          <td><input type="password" name="pass" id="pass"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" class="loginformbutton1" value="  Войти  "></td>
        </tr>
      </table>
	  </form></center>');
}else{

print ('<body style="margin:0px;">
<center>
<h1>Интерфейс Администратора</h1>
<b>
<a href="?a=0">Заявки</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?a=1">Лендинги</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?a=2">Операторы</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?a=3">Настройки</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?a=logout">Выход</a>
</b>
<br><br>
');

if(isset($_GET['a'])){
	if($_GET['a']==0){
    // Заявки

	if(isset($_POST['result'])){
		if(isset($_POST['data_path'])){

			$file = fopen($_POST['data_path'].'/status.txt',"w");
			fputs ($file, $_POST['result']);
			fclose($file);

			$file = fopen($_POST['data_path'].'/comments.txt',"a");
			fputs ($file, 'Admin ('.date("H:i d.m.Y").'): '.$_POST['comment'].'
');
			fclose($file);

			print('<script>
			window.location.replace("index.php?a='.$_GET['a'].'");
			</script>');
		}
	}


    require('../functions/read_data.php');

if(isset($_GET['start_date']) && strlen($_GET['start_date'])>0){$min_date = $_GET['start_date'];}else{$min_date = '1'.date("-m-Y");}
if(isset($_GET['end_date']) && strlen($_GET['end_date'])>0){$max_date = $_GET['end_date'];}else{$max_date = date("d-m-Y");}

$data = read_data($min_date,$max_date,0);

print('

<form method="get">
Фильтр по дате от: <input name="start_date" type="text" class="loginform1" id="startdate">
до:<input name="end_date" type="text" class="loginform1" id="enddate"><br><br>
Лендинг: <select name="landing"><option value="0">все</option>');
	$files_landings = GLOB('../landings/*.txt');
	foreach($files_landings as $i => $v){
		$data_landings[$i] = file($v);
	}
foreach($files_landings as $i => $v){
	print('<option value="'.($i+1).'">'.$data_landings[$i][0].' ('.$data_landings[$i][1].')</option>');
}
print('</select>
&nbsp;&nbsp;Оператор: <select name="operator"><option value="0">все</option>');
	$files_operators = GLOB('../operators_data/*.txt');
$data_operators = array();
foreach($files_operators as $io => $vo){
	$data_operators[($io+1)] = file($vo);
	print('<option value="'.($io+1).'">'.trim($data_operators[($io+1)][1]).'</option>');
}
print('</select><br><br>
Результат прозвона:
<input type="checkbox" name="cb1" id="cb1" /> Хорошо
<input type="checkbox" name="cb2" id="cb2" /> Ожидание
<input type="checkbox" name="cb3" id="cb3" /> Плохо
&nbsp;&nbsp;&nbsp;<input type="submit" class="loginformbutton1" value="Показать">
<input type="hidden" name="a" id="a" value="0" />
</form>

<script type="text/javascript" src="../js/js.js"></script>

<iframe id="myIframe" style="position:absolute; display: none;"></iframe>

<div id="popup_name" style="position:absolute; display: none;width:500px;height:30%;margin: 5% auto;top:-50px; left: 0;right: 0;background: #fff;padding: 20px;border: 20px solid #ddd;float: left;position: fixed;z-index: 99999;-webkit-box-shadow: 0px 0px 20px #000;-moz-box-shadow: 0px 0px 20px #000;box-shadow: 0px 0px 20px #000;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;">
<a href="#" onclick="close_popup();" class="close"><img src="../js/images/close_pop.png" style="float: right;margin: -55px -55px 0 0;border:0;" title="Close Window" alt="Close" /></a><div id="popup_title" style="font-weight:bold;"></div><div id="popup_text"></div>
</div>

<div id="popup_bg" style="display: none;position: fixed;width: 100%;opacity: .80;top:0px;margin:0px;min-height:200px;height:100%;z-index: 9990;background: #000;font-size: 20px;text-align: center;">
<a href="#" onclick="close_popup();" class="close"><img src="../js/images/close_pop.png" style="float: right;margin: -55px -55px 0 0;border:0;" title="Close Window" alt="Close" /></a><h2 id="popup_title"></h2><p id="popup_text"></p>
</div>

<script type="text/javascript">
Calendar.setup({inputField:"startdate",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});
Calendar.setup({inputField:"enddate",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});
</script>


<table border=0 cellpadding=0 cellspacing=0 style="margin-top:-15px;">
<tr align=right style="border: 0px solid #ffffff;">
<td colspan="9" style="border: 0px solid #ffffff;">
<a href="?csv=1&start_date='.$_GET['start_date'].'&end_date='.$_GET['end_date'].'&landing='.$_GET['landing'].'&operator='.$_GET['operator'].'&cb1='.$_GET['cb1'].'&cb2='.$_GET['cb2'].'&cb3='.$_GET['cb3'].'&a='.$_GET['a'].'">Экспорт в (.CSV) файл для Excel</a>
</td>
</tr>
<tr align=center bgcolor="#E6E6E6" style="font-weight:bold">
<td>ID</td>
<td>Лендинг</td>
<td>Дата</td>
<td>Имя</td>
<td>Телефон</td>
<td>E-mail</td>
<td>Результат</td>
<td>Оператор</td>
<td>Действие</td>
</tr>');

$country = file('../form/country.txt');

if(isset($_GET['csv'])){
	$csv_file = "../csv/log_".date("m_d_y").".csv";
}

foreach($data as $i => $v){

	if(isset($_GET['cb1']) || isset($_GET['cb2']) || isset($_GET['cb3'])){
		if(!isset($_GET['csv'])){
			$show_me=1;
		}
	}else{$show_me=0;}

 	if(isset($_GET['operator'])){if($_GET['operator']>0){if($_GET['operator']!=$v[operator]){$show_me=1;}}}
 	if(isset($_GET['landing'])){if($_GET['landing']>0){if($_GET['landing']!=$v[landing]){$show_me=1;}}}
 	if(isset($_GET['cb1'])){if($_GET['cb1']=='on'){if($v["status"]==1){$show_me=0;}}}
    if(isset($_GET['cb2'])){if($_GET['cb2']=='on'){if($v["status"]==2){$show_me=0;}}}
    if(isset($_GET['cb3'])){if($_GET['cb3']=='on'){if($v["status"]==3){$show_me=0;}}}
	if($show_me==0){
		if(isset($_GET['csv'])){
			if($v["status"]==0){$status_csv='';}
			if($v["status"]==1){$status_csv='OK';}
			if($v["status"]==2){$status_csv='Wait List';}
			if($v["status"]==3){$status_csv='Bad';}
			$handle = fopen ($csv_file, 'a');

			$csv_str = trim($v["id"]).';'.str_replace('http://','',trim($data_landings[($v["landing"]-1)][0])).' '.trim($data_landings[($v["landing"]-1)][1]).';'.trim($v["date"]).';'.trim($v["name"]).' '.trim($v["surname"]).';'.trim($v['phone']).';'.trim($v["email"]).';'.trim($status_csv).';'.trim($data_operators[trim($v["operator"])*1][1]).';';
			foreach($v as $iv => $vv){
		    	if(!strcmp($iv,'id')==0 &&
		    	!strcmp($iv,'file_access_locker')==0 &&
		    	!strcmp($iv,'phone')==0 &&
		    	!strcmp($iv,'status')==0 &&
		    	!strcmp($iv,'surname')==0 &&
		    	!strcmp($iv,'name')==0 &&
		    	!strcmp($iv,'country')==0 &&
		    	!strcmp($iv,'date')==0 &&
		    	!strcmp($iv,'agree')==0 &&
		    	!strcmp($iv,'operator')==0 &&
		    	!strcmp($iv,'landing')==0 &&
		    	!strcmp($iv,'comments')==0 &&
		    	!strcmp($iv,'email')==0 &&
		    	!strcmp($iv,'data_path')==0 &&
		    	strlen(trim($v))>0){
				    $csv_str .= $vv.';';
				}
		    }

			fwrite($handle, $csv_str.';
');
			fclose($handle);
		}
	print('<tr align=center>
	<td>'.$v["id"].'</td>
	<td align=left>'.$data_landings[($v["landing"]-1)][0].' '.$data_landings[($v["landing"]-1)][1].'&nbsp;</td>
	<td>'.$v["date"].'&nbsp;</td>
	<td align=left>'.substr($v["name"].' '.$v["surname"],0,25).'&nbsp;</td>
	<td class="menuoff" onmouseover="className=\'menuon\';" onmouseout="className=\'menuoff\';"><b>'.substr($v['phone'],0,2).'-'.substr($v['phone'],2,1).'-'.substr($v['phone'],3,3).'- '.substr($v['phone'],6,3).' '.substr($v['phone'],9,2).' '.substr($v['phone'],11,2).'</b>&nbsp;</td>
	<td><a href="mailto:'.trim($v["email"]).'">'.substr(trim($v["email"]),0,25).'</a>&nbsp;</td>
	<td');
	if($v["status"]==0){print('>&nbsp;');}
	if($v["status"]==1){print(' bgcolor="#00ff00">Хорошо');}
	if($v["status"]==2){print(' bgcolor="yellow">Ожидание');}
	if($v["status"]==3){print(' bgcolor="#999999">Плохо');}
	print('&nbsp;</td>
	<td>'.$data_operators[trim($v["operator"])*1][1].'&nbsp;</td>
	<td><input type="button" value="  Редакт.  " onclick="sub(\''.$v["data_path"].'\','.$_GET['a'].', 1);" class="pendingbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'pendingbutton\';">
    </td>

	</tr>');
	}
}
print('
</table>
<br><br><br><br>
</body>
');
if(isset($_GET['csv'])){
print('<iframe frameborder="0" src="../functions/csv.php?name='.$csv_file.'"></iframe>');
}

}
if($_GET['a']==1){
	//Лендинги

	if(isset($_POST['id'])){
    	$file = fopen('../landings/'.$_POST['id'].'.txt',"w");
		fputs ($file, $_POST['url'].'
'.$_POST['desc']);
		fclose($file);
	}

	if(isset($_GET['id'])){
    	$file = fopen('../landings/'.$_GET['id'].'.txt',"a");
		fputs ($file, '
1');
		fclose($file);
	}

	$files = GLOB('../landings/*.txt');
	print('

	<div id="popup2" style=" visibility:hidden; position:absolute; left:32%; top:10%; width:500px; height:70px; background-color:#ffffff; border: 1px solid #000000; padding:10px;" align="center">
<b id="question">Изменить лендинг?</b><br><br>
<form method="post">
<input type="hidden" name="id" id="id" value="" />
<input name="url" type="text" class="loginform1" id="url" onclick="if(this.value==\'ID\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'ID\';}" value="ID">
<input name="desc" type="text" class="loginform1" id="desc" onclick="if(this.value==\'Описание\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'Описание\';}" value="Описание">
<input type="submit" value="  Сохранить  " /> &nbsp;&nbsp;<input type="button" value="  Отмена  "  onclick="document.getElementById(\'popup2\').style.visibility = \'hidden\';" />
</form>
</div>

	<script type="text/javascript">
function popup(k, p, d1, d2){
	document.getElementById("popup2").style.visibility = "visible";
	document.getElementById("url").value = d1;
	document.getElementById("desc").value = d2;
	document.getElementById("id").value = p;
}
</script>
	<br><form method="post">
	<input type="hidden" name="id" id="id" value="'.(count($files)+1).'" />
Новый лендинг: <input name="url" type="text" class="loginform1" id="startdate" onclick="if(this.value==\'ID\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'ID\';}" value="ID">
<input name="desc" type="text" class="loginform1" id="enddate" onclick="if(this.value==\'Описание\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'Описание\';}" value="Описание">
<input name="daystat" type="submit" class="loginformbutton1" value=" Добавить ">
</form>

<table border=0 cellpadding=0 cellspacing=0>
<tr align=center bgcolor="#E6E6E6" style="font-weight:bold">
<td>#</td>
<td>URL</td>
<td>Описание</td>
<td>Действия</td>
</tr>');
$q = 0;
foreach($files as $i => $v){
	$data = file($v);
	$id = str_replace('../landings/','',str_replace('.txt','',$v));
	if(!trim($data[2])*1==1){
	$q++;
	print('<tr align=center>
	<td>'.$q.'</td>
	<td align="left"><a href="'.trim($data[0]).'" target="blank">'.trim($data[0]).'</a></td>
	<td align="left">'.trim($data[1]).'</td>
	<td>
	<input type="button" value="   Редакт.   " onclick="popup(1, '.$id.', \''.trim($data[0]).'\' ,\''.trim($data[1]).'\');" class="pendingbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'pendingbutton\';">
	<input type="button" value="  Удалить  " onclick="if(confirm(\'Точно удалить?\')){window.location.replace(\'index.php?a=1&id='.$id.'&delete=1\');};" class="badbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'badbutton\';"></td>
	</tr>');
	}
}
print('</table>


	');
}




if($_GET['a']==2){
	//Операторы

	$files_landings = GLOB('../landings/*.txt');
	foreach($files_landings as $i => $v){
		$data_landings[$i] = file($v);
	}

	if(isset($_POST['id'])){
		if(file_exists('../operators_data/'.$_POST['id'].'.txt')){
			$data_tmp = file('../operators_data/'.$_POST['id'].'.txt');
		}

		if(isset($_POST['landing'])){

			$file = fopen('../operators_data/'.trim($_POST['id']).'.txt',"a");
			$exists = 0;
			for($j=3; $j<=count($data_tmp); $j++){
				if(trim($data_tmp[$j])*1==trim($_POST['landing'])*1){
					$exists = 1;
				}
			}

			if($exists == 0){
				fputs ($file, trim($_POST['landing']).'
');
			}

		}else{
			$file = fopen('../operators_data/'.$_POST['id'].'.txt',"w");
			fputs ($file, '0
'.$_POST['url'].'
'.$_POST['desc'].'
');
			if(count($data_tmp)>2){
				for($j=3; $j<=count($data_tmp); $j++){
					fputs ($file, $data_tmp[$j]);
				}
			}
		}
		fclose($file);
	}

	if(isset($_GET['id'])){
		if(isset($_GET['delete'])){
			if(file_exists('../operators_data/'.$_GET['id'].'.txt')){
				$data_tmp = file('../operators_data/'.$_GET['id'].'.txt');
			}
	    	$file = fopen('../operators_data/'.$_GET['id'].'.txt',"w");
	    	foreach($data_tmp as $j => $v){
	    		if($j==0){$v='1';}
				fputs ($file, trim($v).'
');
			}
			fclose($file);
		}

		if(isset($_GET['delete_landing'])){
			if(file_exists('../operators_data/'.$_GET['id'].'.txt')){
				$data_tmp = file('../operators_data/'.$_GET['id'].'.txt');
			}
	    	$file = fopen('../operators_data/'.$_GET['id'].'.txt',"w");
	    	foreach($data_tmp as $j => $v){
	    		if($j!==trim($_GET['delete_landing'])*1){
					fputs ($file, trim($v).'
');
				}
			}
			fclose($file);
			print('<script>
			window.location.replace("index.php?a=2");
			</script>');
		}
	}

	$files = GLOB('../operators_data/*.txt');

	print('

<div id="popup2" style=" visibility:hidden; position:absolute; left:32%; top:10%; width:500px; height:70px; background-color:#ffffff; border: 1px solid #000000; padding:10px;" align="center">
<b id="question">Изменить параметры доступа оператора</b><br><br>
<form method="post">
<input type="hidden" name="id" id="id" value="" />
<input name="url" type="text" class="loginform1" id="url" onclick="if(this.value==\'URL\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'URL\';}" value="URL">
<input name="desc" type="text" class="loginform1" id="desc" onclick="if(this.value==\'Описание\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'Описание\';}" value="Описание">
<input type="submit" value="  Сохранить  " /> &nbsp;&nbsp;<input type="button" value="  Отмена  "  onclick="document.getElementById(\'popup2\').style.visibility = \'hidden\';" />
</form>
</div>

<div id="popup3" style=" visibility:hidden; position:absolute; left:32%; top:10%; width:500px; height:100px; background-color:#ffffff; border: 1px solid #000000; padding:10px;" align="center">
<b id="question">Добавить лендинг к учетной записи оператора</b><br><br>
<form method="post">
<input type="hidden" name="id" id="id2" value="" />
<select name="landing">');
foreach($files_landings as $i => $v){
	print('<option value="'.($i+1).'">'.$data_landings[$i][0].' ('.$data_landings[$i][1].')</option>');
}
print('</select>
<input type="submit" value="  Добавить  " /> &nbsp;&nbsp;<input type="button" value="  Отмена  "  onclick="document.getElementById(\'popup3\').style.visibility = \'hidden\';" />
</form>
</div>

<script type="text/javascript">
function popup(k, p, d1, d2){
	document.getElementById("popup2").style.visibility = "visible";
	document.getElementById("url").value = d1;
	document.getElementById("desc").value = d2;
	document.getElementById("id").value = p;
}
function popup2(p){
	document.getElementById("popup3").style.visibility = "visible";
	document.getElementById("id2").value = p;
}
</script>
	<br><form method="post">
	<input type="hidden" name="id" id="id" value="'.(count($files)+1).'" />
Новый оператор: <input name="url" type="text" class="loginform1" id="startdate" onclick="if(this.value==\'Логин\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'Логин\';}" value="Логин">
<input name="desc" type="text" class="loginform1" id="enddate" onclick="if(this.value==\'Пароль\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'Пароль\';}" value="Пароль">
<input name="daystat" type="submit" class="loginformbutton1" value=" Добавить ">
</form>

<table border=0 cellpadding=0 cellspacing=0>
<tr align=center bgcolor="#E6E6E6" style="font-weight:bold">
<td>#</td>
<td>Логин</td>
<td>Пароль</td>
<td>Доступные лендинги</td>
<td>Статистика (ok/wl/bad/всего) <a href="../functions/stat_refresh.php">Обновить</a></td>
<td>Действия</td>
</tr>');
$q = 0;
foreach($files as $i => $v){
	$data = file($v);
	$id = str_replace('../operators_data/','',str_replace('.txt','',$v));
	if(!trim($data[0])*1==1){
	$q++;
	print('<tr align=center>
	<td>'.$q.'</td>
	<td><a href="../operator/login_as.php?id='.$i.'" target="blank">'.trim($data[1]).'</a></td>
	<td>'.trim($data[2]).'</td>
	<td align="left">');
	for($j=3; $j<=count($data); $j++){
		if(!trim($data_landings[(trim($data[$j])*1-1)][2])==1 && strlen(trim($data[$j]))>0){
			print(trim($data_landings[(trim($data[$j])*1-1)][0]).' ('.trim($data_landings[(trim($data[$j])*1-1)][1]).') &nbsp;&nbsp;&nbsp;<a href="#" style="text-decoration:none; color:red;" onclick="if(confirm(\'Точно удалить лендинг '.str_replace('http://','',trim($data_landings[(trim($data[$j])*1-1)][0])).' ('.trim($data_landings[(trim($data[$j])*1-1)][1]).') из доступа '.trim($data[1]).'?\')){window.location.replace(\'index.php?a=2&id='.$id.'&delete_landing='.$j.'\');};"><b>X</b></a><br>');
		}
	}
	$stat_data = 'сегодня: 0/0/0/<b>0</b><br>
	за мес: &nbsp;&nbsp;&nbsp;0/0/0/<b>0</b><br>
	всего: &nbsp;&nbsp;&nbsp;&nbsp;0/0/0/<b>0</b>';
	if(file_exists('../operator/stat/'.$id.'.txt')){$stat_data = file_get_contents('../operator/stat/'.$id.'.txt');}
	print('<br><div align="right"><a href="#" onclick="popup2('.$id.');">+ добавить</a></div></td>
	<td align="left">'.$stat_data.'</td>
	<td>
	<input type="button" value="   Редакт.   " onclick="popup(1, '.$id.', \''.trim($data[1]).'\' ,\''.trim($data[2]).'\');" class="pendingbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'pendingbutton\';">
	<input type="button" value="  Удалить  " onclick="if(confirm(\'Точно удалить оператора '.trim($data[1]).'?\')){window.location.replace(\'index.php?a=2&id='.$id.'&delete=1\');};" class="badbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'badbutton\';"></td>
	</tr>');
	}
}
print('</table>


	');
}
if($_GET['a']==3){
	//Настройки

	if(isset($_POST['passnew'])){
		$data = file('auth.txt');
		$user_to_save = trim($data[0]);
		$pass_to_save = trim($data[1]);
		if(strlen($_POST['passnew'])>0){
			$pass_to_save = $_POST['passnew'];
		}
		if(strlen($_POST['usernew'])>0){
			$user_to_save = $_POST['usernew'];
		}
		$file = fopen('auth.txt',"w");
		fputs ($file, $user_to_save.'
'.$pass_to_save);
		fclose($file);
	}

	if(isset($_POST['timeout'])){
		if(is_numeric($_POST['timeout'])){
			$file = fopen('../operator/timeout.txt',"w");
			fputs ($file, ($_POST['timeout']*60));
			fclose($file);
		}
	}


    if(isset($_GET['default'])){
    	if(file_exists('../form/default_form_items.txt')){
	    	copy('../form/default_form_items.txt','../form/form_items.txt');
	    }
    }

	if(isset($_POST['f-0-0'])){
		$form_items = file('../form/form_items.txt');
		$file = fopen('../form/form_items.txt',"w");
		for($i=0; $i<=count($form_items)+1; $i++){
			$v = $form_items[$i];
			if($v==''){
				$items = explode('||',$form_items[($i-1)]);
				foreach($items as $j => $w){
					$items[$j] = '';
				}
			}else{
        		$items = explode('||',$v);
	        }
        	$str = '';
        	$new_empty = 0;
		    foreach($items as $j => $w){
		    	if(strlen(trim($_POST['f-'.$i.'-'.$j]))>0){
					$new_empty = 1;
				}
		    	$str .= $_POST['f-'.$i.'-'.$j];
		    	if($j<(count($items)-1)){
		    		$str .= '||';
		    	}
		    }
		    if($new_empty == 1){
		    	fputs ($file, str_replace(trim("\\\ "),trim("\\ "),$str).'
');
			}
		}
		fclose($file);
	}

	print('<center><br><br><b>Изменить логин и пароль Администратора</b><br><br>
	<form method="post">
	  <table width="300"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="35%">Новый Логин:</td>
          <td><input type="text" id="usernew" name="usernew"></td>
        </tr>
        <tr>
          <td width="35%">Новый Пароль:</td>
          <td><input type="text" name="passnew" id="passnew"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" class="loginformbutton1" value="  Изменить  "></td>
        </tr>
      </table>
	  </form>');

$timeout = file_get_contents('../operator/timeout.txt');
print('<br><br><br><b>Максимальное время обработки заявки оператором, минут:</b><br><br>
	<form method="post">
	  <table width="300"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><input type="text" id="timeout" size="5" name="timeout" value="'.((int)$timeout/60).'">&nbsp;&nbsp;&nbsp;<input type="submit" class="loginformbutton1" value="  Изменить  "></td>
        </tr>
      </table>
	  </form>
      <font style="color:gray">(В течении этого времени никакой другой оператор не может<br>
взять в работу выбранную заявку, администратор может.)</font>');

$form_items = file('../form/form_items.txt');

print('<br><br><br><br><br><b>Настройки проверки форм<br>(<a href="?a=3&default">Восстановить по умолчанию</a>)</b><br><br>
	<form method="post">
	  <table width="300"  border="0" cellspacing="0" cellpadding="0">
	  <tr style="font-weight:bold;">
	  <td>Текстовое описание возле поля</td>
	  <td>Параметр name</td>
	  <td>Выпадающий список</td>
	  <td>Паттерн проверки</td>
	  <td>Текст подсказка во всплывающем окошке</td>
	  </tr>');
        for($i=0; $i<=count($form_items); $i++){
			$v = $form_items[$i];
			if($v==''){
				$items = explode('||',$form_items[($i-1)]);
				foreach($items as $j => $w){
					$items[$j] = '';
				}
			}else{
        		$items = explode('||',$v);
	        }
	        print('<tr>');
	        foreach($items as $j => $w){
	        	print('<td><input type="text" name="f-'.$i.'-'.$j.'" value="'.trim($w).'"></td>');
	        }
	        print('</tr>');
		}
      print('</table><br>
      <input type="submit" class="loginformbutton1" value="  Изменить  ">
	  </form>
      <br><br>
 </center>');
}






}
}
?>

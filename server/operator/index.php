<?
set_time_limit(0);
ini_set ('display_errors', false);
ini_set("memory_limit","16M");

if(isset($_GET['a'])){	if(strcmp($_GET['a'],'logout')==0){
		setcookie("user_id",'0');
		$user_founded=0;
		print('<script>
		window.location.replace("index.php");
		</script>');
	}
}
require ('auth.php');
print('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html><head>
<title>Интерфейс Оператора</title><link href="stat/ico.jpg" rel="icon" /><style>
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
<link rel="shortcut icon" type="image/gif" href="images/fav.png"/>
<link rel="icon" type="image/gif" href="images/fav.png"/>
<link rel="stylesheet" type="text/css" media="all" href="../js/calendar-blue.css" title="win2k-cold-1" />
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" src="../js/calendar-en.js"></script>
<script type="text/javascript" src="../js/calendar-setup.js"></script>
</head>');

if($user_founded!=1){print ('<center><h1>Интерфейс Оператора</h1>
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
}else{$user_data = file('../operators_data/'.($valid_user+1).'.txt');
	if(isset($_POST['result'])){		if(isset($_POST['data_path'])){
			$file = fopen($_POST['data_path'].'/status.txt',"w");
			fputs ($file, $_POST['result']);
			fclose($file);

			$file = fopen($_POST['data_path'].'/comments.txt',"a");
			fputs ($file, trim($user_data[1]).' ('.date("H:i d.m.Y").'): '.$_POST['comment'].'
');
			fclose($file);

			$file = fopen($_POST['data_path'].'/operator.txt',"w");
			fputs ($file, ($valid_user+1));
			fclose($file);

			print('<script>
				window.location.replace("index.php?a='.$_GET['a'].'");
			</script>');		}
	}else{

		require('../functions/read_data.php');

		if(isset($_GET['start_date']) && strlen($_GET['start_date'])>0){$min_date = $_GET['start_date'];}else{$min_date = '1'.date("-m-Y");}
		if(isset($_GET['end_date']) && strlen($_GET['end_date'])>0){$max_date = $_GET['end_date'];}else{$max_date = date("d-m-Y");}
		$sort_page = array();
		$sort_page[$_GET['a']]=1;
		if($_GET['a']==1){$sort_page[3]=1;}
		$data = read_data($min_date,$max_date,1,$sort_page,($valid_user+1));

print('
<body style="margin:0px; height: 100%;">
<center>
<h1>Интерфейс Оператора</h1><b>
<a href="?a=0">Новые заявки</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?a=2">Ожидание</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="?a=1">Обработанные заявки</a>&nbsp;&nbsp;&nbsp;&nbsp;
['.trim($user_data[1]).'] <a href="?a=logout">Выход</a>
</b>
<br><br>
<form method="get">
<input type="hidden" name="a" value="'.$_GET['a'].'">
Фильтр по дате от: <input name="start_date" type="text" class="loginform1" id="startdate">
до:<input name="end_date" type="text" class="loginform1" id="enddate">
<input type="submit" class="loginformbutton1" value="Показать">
</form>
	<script type="text/javascript" src="../js/js.js"></script>

<iframe id="myIframe" style="position:absolute; display: none;"></iframe>

<!--[if IE]>
<div style="position:absolute;  left:0px;">
<form method="post" id="actionie">
    <input type="hidden" name="data_path" id="data_path_ie" value="" />
	<input type="hidden" name="result" id="resultie" value="" />
	<textarea style="position:absolute; display: none;" name="comment" id="comment_ie"></textarea>
</form>
</div>
<![endif]-->


<div id="popup_name" style="position:absolute; display: none;width:500px;height:30%;margin: 5% auto;top:-50px; left: 0;right: 0;background: #fff;padding: 20px;border: 20px solid #ddd;float: center;z-index: 99999;-webkit-box-shadow: 0px 0px 20px #000;-moz-box-shadow: 0px 0px 20px #000;box-shadow: 0px 0px 20px #000;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;">
<a href="#" onclick="close_popup();" class="close"><img src="../js/images/close_pop.png" style="float: right;margin: -55px -55px 0 0;border:0;" title="Close Window" alt="Close" /></a><div id="popup_title" style="font-weight:bold;"></div><div id="popup_text"></div>
</div>

<div id="popup_bg" style="display: none;position: fixed;width: 100%; filter: alpha(opacity=80); opacity: .80;top:0px;margin:0px;min-height:200px;height:100%;z-index: 9990;background: #000;font-size: 20px;text-align: center;"></div>


<script type="text/javascript">
Calendar.setup({inputField:"startdate",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});
Calendar.setup({inputField:"enddate",ifFormat:"%d-%m-%Y",showsTime:false,timeFormat:"24"});
</script>
<br>
<table border=0 cellpadding=0 cellspacing=0>
<tr align=center bgcolor="#E6E6E6" style="font-weight:bold">
<td>ID</td>
<td>Тема</td>
<td>Дата</td>
<td>Имя</td>
<td>Телефон</td>
<td>E-mail</td>
<td>Результат прозвона</td>
</tr>');

$country = file('../form/country.txt');
$landings_files = GLOB('../landings/*.txt');
foreach($landings_files as $i => $v){	$landings_data[$i] = file($v);
}
foreach($data as $i => $v){	for($j=3; $j<=count($user_data); $j++){		if(strlen(trim($user_data[$j]))>0){			if($v['landing']==1*trim($user_data[$j])){				print('<tr align=center>
				<td>'.$v["id"].'&nbsp;</td>
				<td align=left>'.$landings_data[($v["landing"]-1)*1][1].'&nbsp;</td>
				<td>'.$v["date"].'&nbsp;</td>
				<td align=left>'.substr($v["name"].' '.$v["surname"],0,25).'&nbsp;</td>
				<td class="menuoff" onmouseover="className=\'menuon\';" onmouseout="className=\'menuoff\';"><b>'.substr($v['phone'],0,2).'-'.substr($v['phone'],2,1).'-'.substr($v['phone'],3,3).'- '.substr($v['phone'],6,3).' '.substr($v['phone'],9,2).' '.substr($v['phone'],11,2).'</b>&nbsp;</td>
				<td><a href="mailto:'.trim($v["email"]).'">'.substr(trim($v["email"]),0,25).'</a>&nbsp;</td>
				<td');
				if($_GET['a']==1){					if($v["status"]==1){
                    	print(' bgcolor="#00ff00" >Хорошо');
					}
					if($v["status"]==3){
                    	print(' bgcolor="#777777" >Плохо');
					}				}
				print('>');
				if($_GET['a']!=1){
					print('<input type="button" value="  Взять в работу  " onclick="sub(\''.$v["data_path"].'\','.$_GET['a'].');" class="badbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'badbutton\';">');
				}
				print('</td></tr>');
			}
		}
	}
}
print('</table>

</body>
</html>
');

}

}
?>
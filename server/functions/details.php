<?
set_time_limit(0);
ini_set ('display_errors', false);
ini_set("memory_limit","16M");
if(isset($_GET['id'])){	$dirs_project_files = GLOB($_GET['id'].'/*.txt');
	foreach($dirs_project_files as $i => $v){
		$data[str_replace('.txt','',str_replace($_GET['id'].'/','',$v))] = file_get_contents($v);
		$expl = explode('/',$_GET['id']);
		$data['id'] = $expl[5];
		$data['date'] = $expl[4].'.'.$expl[3].'.'.$expl[4];
		$data['comments'] = file_get_contents($_GET['id'].'/comments.txt');
    }

	$country = file('../form/country.txt');
    $landings_files = GLOB('../landings/*.txt');
	foreach($landings_files as $i => $v){
		$landings_data[$i] = file($v);
	}

    print('
    <textarea style="position:absolute; display: none;" name="data_path" id="data_paths">'.$_GET['id'].'</textarea>
    <div><form method="post" id="action">
    <input type="hidden" name="data_path" id="data_path" value="'.$_GET['id'].'" />
	<input type="hidden" name="result" id="result" value="" />
	<b>Заявка № '.$data['id'].'</b>
    <table style="padding:10px;">');
    print('<tr><td style="padding:5px;">Тел:</td><td style="padding:5px;"><b>'.substr($data['phone'],0,2).substr($data['phone'],2,1).' ('.substr($data['phone'],3,3).') '.substr($data['phone'],6,3).'-'.substr($data['phone'],9,2).'-'.substr($data['phone'],11,2).'</b></td></tr>');
    if(strlen(trim($data["name"]))>0 || strlen(trim($data["surname"]))>0){print('<tr><td style="padding:5px;">Ф.И.О.</td><td style="padding:5px;"><b>'.$data['name'].' '.$data['surname'].'</b></td></tr>');}
    print('<tr><td style="padding:5px;">Тема</td><td style="padding:5px;"><b>'.$landings_data[($data["landing"]-1)*1][1].'</b></td></tr>');
    print('<tr><td style="padding:5px;">Дата</td><td style="padding:5px;">'.$data['date'].'</td></tr>');
    if(strlen(trim($data["email"]))>0){print('<tr><td style="padding:5px;">E-amil</td><td style="padding:5px;"><a href="mailto:'.trim($data["email"]).'">'.trim($data["email"]).'</a></td></tr>');}
    foreach($data as $i => $v){    	if(!strcmp($i,'id')==0 &&
    	!strcmp($i,'file_access_locker')==0 &&
    	!strcmp($i,'phone')==0 &&
    	!strcmp($i,'status')==0 &&
    	!strcmp($i,'surname')==0 &&
    	!strcmp($i,'name')==0 &&
    	!strcmp($i,'country')==0 &&
    	!strcmp($i,'date')==0 &&
    	!strcmp($i,'agree')==0 &&
    	!strcmp($i,'operator')==0 &&
    	!strcmp($i,'landing')==0 &&
    	!strcmp($i,'comments')==0 &&
    	!strcmp($i,'email')==0 &&
    	strlen(trim($v))>0){
		    print('<tr><td style="padding:5px;">'.$i.'</td><td style="padding:5px;">'.$v.'</td></tr>');
		}
    }
    if(strlen(trim($data["country"]))>0){print('<tr><td style="padding:5px;">Страна</td><td style="padding:5px;">'.trim($country[$data["country"]*1]).'</td></tr>');}
    print('<tr><td style="padding:5px;" colspan="2">');
    if(strlen(trim($data['comments']))>0){    	print('<textarea onload="this.doScroll(\'pageDown\');" style="border: 1px solid #aaaaaa;background-color:white; width:400px; height:100px;" disabled="disabled">'.trim($data['comments']).'</textarea><br>');
    }
    print('<b>Результат прозвона:</b><br><textarea style="border: 1px solid #aaaaaa; width:400px; height:100px;" name="comment" id="comment"></textarea></td></tr>');
    print('</table>');

    if($_GET['a']=='admin'){$this_is_admin = 1;}else{$this_is_admin = 0;}

    if($_GET['a']!=1){    	if($_GET['a']=='admin'){    		print('<input type="button" value=" Новый " onclick="submitform(0,'.$this_is_admin.');" class="badbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'badbutton\';">
    &nbsp;&nbsp;&nbsp;&nbsp;');    	}
	    print('<input type="button" value="   Положительно   " onclick="submitform(1,'.$this_is_admin.');" class="okbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'okbutton\';">
    &nbsp;&nbsp;&nbsp;&nbsp;');
   		print('<input type="button" value="Ожидание" onclick="submitform(2,'.$this_is_admin.');" class="pendingbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'pendingbutton\';">');
	    print('&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" value="  Плохо  " onclick="submitform(3,'.$this_is_admin.');" class="badbutton" onmouseover="className=\'robutton\';" onmouseout="className=\'badbutton\';">');
   	}
	print('</form>
    </div>');
}else{
	print('error_noid');
}
?>
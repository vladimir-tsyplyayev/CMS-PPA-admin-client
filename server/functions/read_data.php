<?
function read_data($min_date,$max_date,$admin,$sort_array = array(),$operator_number='Null'){
	$min_date_p = explode('-',$min_date);
	$max_date_p = explode('-',$max_date);
	$data = array();
	$k=0;
	$dirs_years = GLOB('../data/*',GLOB_ONLYDIR);
	foreach($dirs_years as $i => $v){
		if($min_date_p[2]<=str_replace('../data/','',$v) && $max_date_p[2]>=str_replace('../data/','',$v)){
			$dirs_month[$i] = GLOB($v.'/*',GLOB_ONLYDIR);
			foreach($dirs_month[$i] as $j => $w){
				if(
				($min_date_p[2]==$max_date_p[2] && $min_date_p[1]<=str_replace($v.'/','',$w) && $max_date_p[1]>=str_replace($v.'/','',$w))||
				($min_date_p[2]!=$max_date_p[2] && $min_date_p[2]==str_replace('../data/','',$v) && $min_date_p[1]<=str_replace($v.'/','',$w))||
				($min_date_p[2]!=$max_date_p[2] && $max_date_p[2]==str_replace('../data/','',$v) && $max_date_p[1]>=str_replace($v.'/','',$w))||
				($min_date_p[2]<str_replace('../data/','',$v) && $max_date_p[2]>str_replace('../data/','',$v))
				){
					$dirs_days[$i][$j] = GLOB($w.'/*',GLOB_ONLYDIR);
					foreach($dirs_days[$i][$j] as $ji => $wv){
						if(
						($min_date_p[1]==$max_date_p[1] && $min_date_p[0]<=str_replace($w.'/','',$wv) && $max_date_p[0]>=str_replace($w.'/','',$wv))||
						($min_date_p[1]!=$max_date_p[1] && $min_date_p[1]==str_replace($v.'/','',$w) && $min_date_p[0]<=str_replace($w.'/','',$wv))||
						($min_date_p[1]!=$max_date_p[1] && $max_date_p[1]==str_replace($v.'/','',$w) && $max_date_p[0]>=str_replace($w.'/','',$wv))||
						($min_date_p[1]<str_replace($v.'/','',$w) && $max_date_p[1]>str_replace($v.'/','',$w))||
						($min_date_p[2]<str_replace('../data/','',$v) && $max_date_p[2]>str_replace('../data/','',$v))
						){
							$dirs_projects[$i][$j][$ji] = GLOB($wv.'/*',GLOB_ONLYDIR);
							foreach($dirs_projects[$i][$j][$ji] as $jij => $wvw){
								$dirs_project_files[$i][$j][$ji][$jij] = GLOB($wvw.'/*.txt');
								$status = trim(file_get_contents($wvw.'/status.txt'))*1;
								if(file_exists($wvw.'/operator.txt')){$operator = trim(file_get_contents($wvw.'/operator.txt'));}
								$file_access_locker = trim(file_get_contents($wvw.'/file_access_locker.txt'));
								if($admin==0 ||
								(
								($file_access_locker==0 && $sort_array[0]==1 && $status==0) ||
								($operator_number==$operator && $sort_array[1]==1 && ($status==1 || $status==3)) ||
								($file_access_locker==0 && $sort_array[2]==1 && $status==2)
								)
								){
									foreach($dirs_project_files[$i][$j][$ji][$jij] as $jiji => $wvwv){
										$data[$k][str_replace('.txt','',str_replace($wvw.'/','',$wvwv))] = file_get_contents($wvwv);
										$data[$k]['id'] = str_replace($wv.'/','',$wvw);
										$data[$k]['date'] = str_replace($w.'/','',$wv).'.'.str_replace($v.'/','',$w).'.'.str_replace('../data/','',$v);
										$data[$k]['data_path'] = $wvw;
										$data[$k]['comments'] = file_get_contents($wvw.'/comments.txt');
										$data[$k]['status'] = $status;
		    	                	}
		    	                	$k ++;
	    	                	}
	                    	}
						}
					}
				}
			}
		}
	}
	return $data;
}
?>

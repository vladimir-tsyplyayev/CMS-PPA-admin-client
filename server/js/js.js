function sub(id, a, admin){	window.id = id;
	window.a = a;
	window.admin = admin;if(admin==undefined){
	str = "";
    show_popup('','<br><br><br><br><br><center><img src="../js/images/loading.gif" /></center><br><br><br><br><br>');
	document.getElementById("myIframe").src = "../functions/lock.php?lock=1&id=" + window.id;
	if(navigator.userAgent.search(/msie/i)!= -1) {
		function loadfirst(id, a){			var myIFrame = document.getElementById("myIframe");
   			var content = myIFrame.contentWindow.document.body.innerHTML;	   		if(content=='error_noid' || window.admin==1){
	        	show_popup('Ошибка!','Выберите заявку.');
	   		}else{
		   		if(content=='ok'){
	   				document.getElementById("myIframe").src = "../functions/details.php?a="+window.a+"&id=" + window.id;
                    document.getElementById("myIframe").attachEvent("onload", loadsecond);
		   		}else{
		   			if(content.substring(0,6)=='locked'){
				   		show_popup('Внимание!','Заявка взята в работу другим оператором.<br><br>Освободится через: '+content.substring(7));
				   	}
			   	}
			}		}
		function loadsecond(id, a){
			var myIFrame = document.getElementById("myIframe");
			var myid = myIFrame.contentWindow.document.body.innerHTML;
		   	show_popup('',myid);
		}
		document.getElementById("myIframe").attachEvent("onload", loadfirst);

	}else{		document.getElementById("myIframe").onload = function(){
		var myIFrame = document.getElementById("myIframe");
   		var content = myIFrame.contentWindow.document.body.innerHTML;
   		if(content=='error_noid' || admin==1){        	show_popup('Ошибка!','Выберите заявку.');   		}else{
	   		if(content=='ok'){   				document.getElementById("myIframe").src = "../functions/details.php?a="+a+"&id=" + id;
				document.getElementById("myIframe").onload = function(){					var myIFrame = document.getElementById("myIframe");
			   		var myid = myIFrame.contentWindow.document.body.innerHTML;
	   				show_popup('',myid);
	   			}
	   		}else{	   			if(content.substring(0,6)=='locked'){
			   		show_popup('Внимание!','Заявка взята в работу другим оператором.<br><br>Освободится через: '+content.substring(7));
			   	}
		   	}
		}
	}
	}
}else{	document.getElementById("myIframe").src = "../functions/details.php?a=admin&id=" + id;
	if(navigator.userAgent.search(/msie/i)!= -1) {		function aloadfirst(id, a){
			var myIFrame = document.getElementById("myIframe");
			var myid = myIFrame.contentWindow.document.body.innerHTML;
		   	show_popup('',myid);
		}
		document.getElementById("myIframe").attachEvent("onload", aloadfirst);
	}else{
		document.getElementById("myIframe").onload = function(){
			var myIFrame = document.getElementById("myIframe");
	   		var myid = myIFrame.contentWindow.document.body.innerHTML;
			show_popup('',myid);
		}
	}}
}

function show_popup(title, text){
	document.getElementById("popup_title").innerHTML = title;
	document.getElementById("popup_text").innerHTML = text;
	document.getElementById("popup_name").style.height = "auto";
	document.getElementById("popup_name").style.display = "block";
	document.getElementById("popup_bg").style.display = "block";
}

function close_popup(){
	document.getElementById("popup_name").style.display = "none";
	document.getElementById("popup_bg").style.display = "none";
}

function submitform(k,a){	if(document.getElementById("comment").value.length<3 && a==0){
		alert('Заполните данные о результате прозвона!');	}else{			document.getElementById("result").value = k;
			document.getElementById("action").submit();
	}
}
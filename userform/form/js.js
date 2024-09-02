function start(){ 	var iframe = document.createElement("iframe");
	iframe.id = "myIframe";
	iframe.style.position = "absolute";
	iframe.style.display = "none";
	window.document.body.appendChild(iframe);
 	var iframe = document.createElement("div");
 	iframe.setAttribute('style', 'display: none;width:500px;height:30%;margin: 5% auto;left: 0;right: 0;background: #fff;padding: 20px;border: 20px solid #ddd;float: left;position: fixed;z-index: 99999;-webkit-box-shadow: 0px 0px 20px #000;-moz-box-shadow: 0px 0px 20px #000;box-shadow: 0px 0px 20px #000;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;');
	iframe.id = "popup_name";
	iframe.innerHTML = '<a href="#" onclick="close_popup();" class="close"><img src="form/images/close_pop.png" style="float: right;margin: -55px -55px 0 0;border:0;" title="Close Window" alt="Close" /></a><h2 id="popup_title"></h2><div id="popup_text"></div>';
	window.document.body.appendChild(iframe);
 	var iframe = document.createElement("div");
	iframe.id = "popup_bg";
	iframe.setAttribute('style', 'display: none;position: fixed;width: 100%; filter: alpha(opacity=80);opacity: .80;top:0px;margin:0px;min-height:200px;height:100%;z-index: 9990;background: #000;font-size: 20px;text-align: center;');
	window.document.body.appendChild(iframe);
}

function sub(action){	window.action = action;
	str = "";
	ok_str = "<br><br><table style='padding:10px;'>";
	for (var i=0; i<document.forms[FormName].length; i++){
		var obj = document.forms[FormName].elements[i].name;
		if(obj!=""){
			elem = document.getElementsByName(obj);
			str += obj + "=" + encodeURIComponent(elem[0].value) + "&";
			if(elem[0].type!="hidden" && elem[0].type!="checkbox" && elem[0].type!="button" && elem[0].type!="submit"){
				ok_str += "<tr><td style='padding:5px;'>" + obj.substr(0, 1).toUpperCase() + obj.substr(1) + "<td style='padding:5px;'><b>" + elem[0].value + "</b></td></tr>";
			}
		}
	}
    show_popup('','<br><br><br><br><br><center><img src="form/images/loading.gif" /></center><br><br><br><br><br>');
	ok_str += "<tr><td style='padding:5px; padding-top:30px;'><input type='button' value='  << Редактировать  ' OnClick='close_popup();'><input type='hidden' name='complete' value='1'></td><td style='padding:5px; padding-top:30px;'><input type='button' onclick='sub(1);' value='  Все правильно, отправить >>  '></td></tr></table>";
	document.getElementById("myIframe").src = "form/check.php?" + str;

	if(navigator.userAgent.search(/msie/i)!= -1) {        window.str = str;
        window.ok_str = ok_str;
        window.action = action;

		if(action==1){
			function loadsecond(){
        		var myIFrame = document.getElementById("myIframe");
				var myid = myIFrame.contentWindow.document.body.innerHTML;
				show_popup('Ваша заявка принята!','<br><br>Наш оператор свяжется с Вами в скором времени. <br><br><br><br><br><br><br><br><br><br><img src="http://n.actionpay.ru/ok/123.png?apid=' + myid + '" width="1" height="1" />');
			}

		   	document.getElementById("myIframe").src = "form/check.php?complete=1&" + str;
			document.getElementById("myIframe").attachEvent("onload", loadsecond);
		}else{
			function loadfirst(){
				var myIFrame = document.getElementById("myIframe");
	   			var content = myIFrame.contentWindow.document.body.innerHTML;
		   		if(window.action==1){		   			show_popup('Ваша заявка принята!','<br><br>Наш оператор свяжется с Вами в скором времени. <br><br><br><br><br><br><br><br><br><br><img src="http://n.actionpay.ru/ok/123.png?apid=' + content + '" width="1" height="1" />');
				}else{
			   		if(content=="all_right"){
		       			show_popup('Проверьте, правильно ли введены данные?',window.ok_str);
			   		}else{				   		show_popup('Внимание!',content);
				   	}
				}
	        }
			document.getElementById("myIframe").attachEvent("onload", loadfirst);
		}

	}else{

		document.getElementById("myIframe").onload = function(){
			var myIFrame = document.getElementById("myIframe");
	   		var content = myIFrame.contentWindow.document.body.innerHTML;
	   		if(content=="all_right"){	   			if(action==1){	   				document.getElementById("myIframe").src = "form/check.php?complete=1&" + str;
					document.getElementById("myIframe").onload = function(){						var myIFrame = document.getElementById("myIframe");
				   		var myid = myIFrame.contentWindow.document.body.innerHTML;
		   				show_popup('Ваша заявка принята!','<br><br>Наш оператор свяжется с Вами в скором времени. <br><br><br><br><br><br><br><br><br><br><img src="http://n.actionpay.ru/ok/123.png?apid=' + myid + '" width="1" height="1" />');
		   			}
		   		}else{
	       			show_popup('Проверьте, правильно ли введены данные?',ok_str);		   		}	   		}else{
		   		show_popup('Внимание!',content);
		   	}
		}
	}
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
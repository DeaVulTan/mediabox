var onlineTimer;
function logInUser(){
	userOnlineNow(true);
}

function logOutUser(){
	userOnlineNow(false);
}
function userOnlineNow(isLogged){
	if(!isLogged && window.screenTop!=undefined && window.screenTop<9999){
		return;
	}
	pars = 'u=' + siteUserId + '&';
	pars += (isLogged)?'login=1':'logout=1';
	url = cfg_site_url + 'online.php';
	if(isLogged)
		$Jq.ajax({type: "POST", url: url, data: pars});
	else
		postViaNormalAjax(url, pars);
}

function updatedFunction(resp){
	rep = resp.responseText;
	if(rep.indexOf('rror')>0){
		if(typeof onlineTimer==='number'){
			clearInterval(onlineTimer);
		}
		onlineTimer = null;
		return false;
	}

}

function postViaNormalAjax(url, pars){
	  var req = null;
		if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
			 if (req.overrideMimeType) {
					// req.overrideMimeType('text/xml');
			 }
		} else if (window.ActiveXObject) {
			req = new ActiveXObject("Microsoft.XMLHTTP");
		}
		if(req!=null){
			req.open("POST", url, true);
			try{
			req.onreadystatechange = function(){
				if (req.readyState==4){
					if(req.status==200){
						if(req.responseText){
						}
					}
				}
			}
			}
			catch(e){}
			req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			req.setRequestHeader("Content-length",pars.length);
			req.send(pars);
		}
}

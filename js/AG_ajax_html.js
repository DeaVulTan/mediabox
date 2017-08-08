/**
 * @version $Id Ag_gmap.js
 * @version $Revision 1.0$ 2005-12-30
 * @version Basic Ajax Functionality Page
 * @author vijayanand_39ag05
 * 
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */

function AG_xml(url, cmd)
{
	if(url.length<=0 || cmd.length<=0){
		alert("Error: Unable to Found the URL");return false;
	}
	this.url = url;
	this.cmd = cmd;
	this.result = "";
    this.req = null;
	 if (window.XMLHttpRequest) {
			var req = new XMLHttpRequest();
			 if (req.overrideMimeType) {
					 req.overrideMimeType('text/html');
			 }
		} else if (window.ActiveXObject) {
			req = new ActiveXObject("Microsoft.XMLHTTP");
		}
    this.req = req;
return true;
}
function AG_ajax(url,cmd, xml){
var sendResponseXml = (arguments.length==3 && arguments[2]=='xml')?true:false;
this.output = "NoRecords";

	var x = new AG_xml(url,cmd);
	x.opens();	
	try{
	x.req.onreadystatechange = function(){
		if (x.req.readyState==4){
			if(x.req.status==200){
				if(x.req.responseText){
						if(sendResponseXml){
							x.result = x.req.responseXML;
						}
						else{
							x.result = escape(x.req.responseText);
						}
					x.getOp();
					
				}
			}
		}		
	}
	}
	catch(e){}
	x.sends();

}
AG_xml.prototype.opens = function(){
	this.req.open("GET", this.url, true);
}

AG_xml.prototype.sends = function(){
	this.req.send(null);
}

AG_xml.prototype.getOp=function(){
	eval(this.cmd+"(\""+this.result+"\")");
}

AG_xml.prototype.popen = function(){
	this.req.open("POST", this.url, true);
}

AG_xml.prototype.psend = function(p){
	this.req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
	this.req.setRequestHeader("Content-length",p.length); 
	this.req.send(unescape(p));
}

function AG_ajax_post(url,cmd, fieldValues){
this.output = "NoRecords";
	var x = new AG_xml(url,cmd);
	x.popen();	
	try{
	x.req.onreadystatechange = function(){
		if (x.req.readyState==4){
			if(x.req.status==200){
				if(x.req.responseText){
					x.result = escape(x.req.responseText);
					x.getOp();
				}
			}
		}		
	}
	}
	catch(e){}
	x.psend(AG_getURI(fieldValues));
return true;
}

function AG_getURI(fieldValueArray){
	var uri = "";
	for(var i in fieldValueArray){
		uri += i+"="+fieldValueArray[i]+"&";
	}
	if(uri.length>1){
		uri = uri.substr(0, uri.length-1);
	}
	return uri;
}

function AG_request()
{	
    var req = null;
	 if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
			 if (req.overrideMimeType) {
					 req.overrideMimeType('text/xml');
			 }
		} else if (window.ActiveXObject) {
			req = new ActiveXObject("Microsoft.XMLHTTP");
		}
return req;
}


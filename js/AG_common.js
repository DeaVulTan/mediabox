//Browser Details 
function isset(ov){
	return (typeof ov !='undefined')
}
function AG_dge(ids){
var obj = document.getElementById(ids);
	this.o = obj;
	this.isObj = (obj!=null);
	this.val = (this.isObj && (isset(obj.value)))?obj.value:"";
	this.id = (this.isObj && (isset(obj.id)))?obj.id:"";
	this.name = (this.isObj && (isset(obj.name)))?obj.name:"";
	this.disable = (this.isObj && (isset(obj.disabled)))?obj.disabled:"";
	this.disp = (this.isObj && (isset(obj.style.display)))?obj.style.display:"";
	this.cls = (this.isObj && (isset(obj.className)))?obj.className:"";
	this.w = (this.isObj && (isset(obj.style.width)))?obj.style.width:"";
	this.h = (this.isObj && (isset(obj.style.height)))?obj.style.height:"";
	this.inh = (this.isObj && (isset(obj.innerHTML)))?obj.innerHTML:"";	
	this.sa  = function(at,val){
		if(this.isObj)
			this.o.setAttribute(at, val);
	};
	this.ga = function(at){
		if(this.isObj)
			return this.o.getAttribute(at);
	};
	this.cls = function(){
		if(this.isObj){
			for(var i=this.o.childNodes.length-1;i>=0;i--){
					this.o.removeChild(this.o.childNodes[i]);
			}
		}
	}
	this.ac = function(c){
		if(this.isObj)
			this.o.appendChild(c);
	}
	this.cl = function(c){
		if(this.isObj)
			this.o.className = c;
	}
	this.si = function(c){
		if(this.isObj)
			this.o.innerHTML = c;
	}
	this.dA = function(){
		if(this.isObj)
			this.o.disabled=true;
	}
	this.eA = function(){
		if(this.isObj)
			this.o.disabled=false;
	}
	this.hide = function(){
		if(this.isObj)
			this.o.style.display = 'none';
	}
	this.show = function(){
		if(this.isObj)
			this.o.style.display = 'block';
	}
	this.stStl = function(st,vl){
		if(this.isObj)
			this.o.style[st] = vl;
	}
}

function AG_msgbox(id, txt){
var m = new AG_dge(id);
m.cls();
m.ac(document.createTextNode(txt));
return true;
}

function AG_report(id, txt, clear){
var m = new AG_dge(id);
	if(arguments.length>2)
		m.si(txt);
	else
		m.si(m.inh + txt);
return true;
}
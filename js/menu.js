<!--
//window.onload=montreHideMenu;
function montre(id) {
	var d = null;
	var curr_dt= null;
	if(id.length > 0 ){
		d = document.getElementById(id);
	}
	for (var i = 1; i<=14; i++) {
		if (document.getElementById('smenu'+i))
			{
				document.getElementById('smenu'+i).style.display='none';
				if(document.getElementById('dtmenu'+i).className != 'clsSubMenu clsActiveHeaderMainLink clsCurrentHeaderMainLink')
					document.getElementById('dtmenu'+i).className='clsSubMenu';
			}
		if(id=='smenu'+i)
			curr_dt='dtmenu'+i;
	}
	if (d != null) {
		d.style.display='block';
		if(document.getElementById(curr_dt).className != 'clsSubMenu clsActiveHeaderMainLink clsCurrentHeaderMainLink')
			document.getElementById(curr_dt).className+=' clsActiveHeaderMainLink';
	}
}

function montreShowDefault(id) {
	var d = null;
	if(id.length > 0 ){
		d = document.getElementById(id);
	}
	for (var i = 1; i<=14; i++)
	{
		if (document.getElementById('smenu'+i))
			{
				if(document.getElementById('smenu'+i).className=='clsActiveHeaderMainLink clsCurrentHeaderMainLink')
					{
						document.getElementById('smenu'+i).style.display='block';
						document.getElementById('dtmenu'+i).className='clsSubMenu clsActiveHeaderMainLink clsCurrentHeaderMainLink';
					}
					else
						{
							document.getElementById('smenu'+i).style.display='none';
							document.getElementById('dtmenu'+i).className='clsSubMenu';
						}
			}
	}
}

// Copyright 2006-2007 javascript-array.com

var timeout	= 100;
var closetimer	= 0;
var ddmenuitem	= 0;

// open hidden layer
function mopen(id)
{
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	if(ddmenuitem)
		ddmenuitem.style.visibility = 'visible';

}
function mopentoggle(id)
{
	// cancel close timer
	mcancelclosetime();
	// close old layer
	//if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	if(ddmenuitem.style.display == 'none')
	{
		ddmenuitem.style.visibility = 'visible';
		ddmenuitem.style.display = 'block';
	}
		else
			{
			ddmenuitem.style.visibility = 'hidden';
			ddmenuitem.style.display = 'none';
			}
}


// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

function mopenUserMenu(e,inputId)
{
	//if(dhtmlgoodies_slideInProgress)return;
	//dhtmlgoodies_slideInProgress = true;
	if(!inputId)inputId = this.id;
	inputId = inputId + '';
	quest_id=document.getElementById(inputId);
	var numericId = inputId.replace(/[^0-9]/g,'');
	var answerDiv = document.getElementById('usermenu_' + numericId);
	mopen('usermenu_' + numericId);
}

function initUserMenus()
{
	var divs = document.getElementsByTagName('P');
	var divCounter = 1;
	for(var no=0;no<divs.length;no++)
	{
		if(divs[no].className=='clsUserMenuContainer' || divs[no].className=='clsUserMenuContainerIndex')
			{
				var contentDiv=divs[no].nextSibling;
				if(contentDiv.className=='clsMenuSearch' || contentDiv.className=='clsCoolMemberActive')
					{
						contentDiv.id = 'usermenu_'+divCounter;
						divs[no].id = 'usermenu_container_'+divCounter;
						divs[no].onmouseover = mopenUserMenu;
						divs[no].onmouseout = mclosetime;
						contentDiv.onmouseover = mopenUserMenu;
						contentDiv.onmouseout = mclosetime;
						divCounter++;
					}
			}
	}

	for (var i = 1; i<=12; i++)
		{
			if (document.getElementById('smenu'+i))
				{
					if(document.getElementById('smenu'+i).className=='clsActiveHeaderMainLink clsCurrentHeaderMainLink')
						{
							document.getElementById('smenu'+i).style.display='block';
						}
						else
							document.getElementById('smenu'+i).style.display='none';
				}
		}
	initializeCheckAllUnChecked();
}

function initializeCheckAllUnChecked()
	{
		var divs = document.getElementsByTagName('input');
		for(var no=0;no<divs.length;no++)
			{
				if(divs[no].type=='checkbox' && (!(divs[no].onclick) || (divs[no].onclick=='undefined')))
					{
						divs[no].onclick = makeCheckBoxUnChecked;
					}
			}
	}

function makeCheckBoxUnChecked()
	{
		var inputs = document.getElementsByTagName('input');
		for(var no=0;no<inputs.length;no++)
			{
				var str=inputs[no].onclick;
				if((inputs[no].type=='checkbox') && (inputs[no].name=='checkall' || inputs[no].name=='check_all'))
					{
						inputs[no].checked=false;
						//divs[no].onclick = makeCheckBoxUnChecked;
					}
			}
	}

initUserMenus();
// close layer when click-out
//document.onclick = mclose;

//-->
/************************************************************************************************************
(C) www.dhtmlgoodies.com, November 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/

var dhtmlgoodies_slideSpeed = 50;	// Higher value = faster
var dhtmlgoodies_timer = 1;	// Lower value = faster

var objectIdToSlideDown = false;
var dhtmlgoodies_activeId = false;
var dhtmlgoodies_slideInProgress = false;
function showHideContent(e,inputId)
{
	//if(dhtmlgoodies_slideInProgress)return;
	//dhtmlgoodies_slideInProgress = true;
	if(!inputId)inputId = this.id;
	inputId = inputId + '';
	quest_id=document.getElementById(inputId);
	var numericId = inputId.replace(/[^0-9]/g,'');
	var answerDiv = document.getElementById('dhtmlgoodies_a' + numericId);
	
		
	objectIdToSlideDown = false;

	if(answerDiv.style.display=='none')
	{
		answerDiv.style.display='';
		if(showHideDiv = quest_id.getElementsByTagName('SPAN')[0])
			   showHideDiv.className='clsSidebarInActive';

		//if(quest_id)
			//quest_id.className='clsSideBarLeft clsSideBarLeftActive';
	}
	else
		{
			answerDiv.style.display='none';	
			//if(quest_id)
			//	quest_id.className='clsSideBarLeft';
			if(showHideDiv = quest_id.getElementsByTagName('SPAN')[0])
				   showHideDiv.className='clsSideBarLeftClose';
		}
				
	/*if(!answerDiv.style.display || answerDiv.style.display=='none'){		
		if(dhtmlgoodies_activeId &&  dhtmlgoodies_activeId!=numericId){			
			objectIdToSlideDown = numericId;
			slideContent(dhtmlgoodies_activeId,(dhtmlgoodies_slideSpeed*-1));
		}else{
			
			answerDiv.style.display='block';
			answerDiv.style.visibility = 'visible';
			
			slideContent(numericId,dhtmlgoodies_slideSpeed);
		}
	}else{
		slideContent(numericId,(dhtmlgoodies_slideSpeed*-1));
		dhtmlgoodies_activeId = false;
	}*/	
}

function slideContent(inputId,direction)
{
	
	var obj =document.getElementById('dhtmlgoodies_a' + inputId);
	var contentObj = document.getElementById('dhtmlgoodies_ac' + inputId);
	height = obj.clientHeight;
	if(height==0)height = obj.offsetHeight;
	height = height + direction;
	rerunFunction = true;
	if(height>contentObj.offsetHeight){
		height = contentObj.offsetHeight;
		rerunFunction = false;
	}
	if(height<=1){
		height = 1;
		rerunFunction = false;
	}

	obj.style.height = height + 'px';
	var topPos = height - contentObj.offsetHeight;
	if(topPos>0)topPos=0;
	contentObj.style.top = topPos + 'px';
	if(rerunFunction){
		setTimeout('slideContent(' + inputId + ',' + direction + ')',dhtmlgoodies_timer);
	}else{
		if(height<=1){
			obj.style.display='none'; 
			if(objectIdToSlideDown && objectIdToSlideDown!=inputId){
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.display='block';
				document.getElementById('dhtmlgoodies_a' + objectIdToSlideDown).style.visibility='visible';
				slideContent(objectIdToSlideDown,dhtmlgoodies_slideSpeed);				
			}else{
				dhtmlgoodies_slideInProgress = false;
			}
		}else{
			dhtmlgoodies_activeId = inputId;
			dhtmlgoodies_slideInProgress = false;
		}
	}
}



function initShowHideDivs()
{
	var divs = document.getElementsByTagName('DIV');
	var divCounter = 1;
	for(var no=0;no<divs.length;no++){
		if(divs[no].className=='clsSideBarLeft')
			{
				divs[no].onclick = showHideContent;
				divs[no].id = 'dhtmlgoodies_q'+divCounter;
				
				var show_hide_span='';
				if(show_hide_span=divs[no].getElementsByTagName('SPAN')[0])
					show_hide_span.className='clsSidebarInActive';
					
				var answer = divs[no].nextSibling;
				while(answer && answer.tagName!='DIV')
				{
					answer = answer.nextSibling;
				}
				answer.id = 'dhtmlgoodies_a'+divCounter;	
				if(contentDiv = answer.getElementsByTagName('DIV')[0])
					{
						//contentDiv.style.top = 0 - contentDiv.offsetHeight + 'px'; 	
						contentDiv.className='clsSideBarContent';
						contentDiv.id = 'dhtmlgoodies_ac' + divCounter;
						//answer.style.display='none';
						//answer.style.height='1px';
						divCounter++;
					}	
		}		
	}	
}
//window.onload = initShowHideDivs;
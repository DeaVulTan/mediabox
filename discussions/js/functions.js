function getAjaxGetCode(path, delLink,formName,getCode)
{

	getCodeFormName=formName;
	delLink_value = delLink;
	code=getCode;

	new jquery_ajax(path, '', 'getdisplayCode');
	return false;
}

/**
 *
 * @access public
 * @return void
 **/
function in_arry(arrayval,val)
{
	l = arrayval.length;
	for(var i = 0; i < l; i++)
	{
		if(arrayval[i] == val)
		{
			return true;
		}
	}
	return false;
}

// AJAX FUNCTION TO CALL SHARE VIDEO
function showShareDiv(url){
	import_contacts_link = true;
	pars='';
	jquery_ajax(url, pars, 'ajaxResultShare');
}

// FUCNTION TO DISPLAY SHARE VIDEO AJAX OUTPUT
function ajaxResultShare(data){
	$Jq('#selSharePhotoContent').html(data);
	import_contacts_link = true;
	Confirmation('selSharePhotoContent', 'formEmailList', Array(), Array(), Array());
}


//Rating related
var img_src = new Array();
function ratingBoardMouseOver(count, type)
	{
		if(type == 'slidelist')
			{
				var hoverimage_name = 'icon-slidelistratehover.gif';
				var image_name = 'icon-slidelistrate.gif'
			}
		else if(type == 'board')
			{
				var hoverimage_name = 'icon-boardratehover.gif';
				var image_name = 'icon-boardrate.gif'
			}
		else if(type == 'solution')
			{
				var hoverimage_name = 'icon-solutionratehover.gif';
				var image_name = 'icon-solutionrate.gif'
			}
		for(var i=1; i<=count; i++)
			{
				var obj = document.getElementById('img'+i);
				img_src[i] = obj.src;
				obj.src = photo_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+hoverimage_name;
			}
		for(; i<=total_rating_images; i++)
			{
				var obj = document.getElementById('img'+i);
				img_src[i] = obj.src;
				obj.src = photo_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+image_name;
			}
	}

function ratingBoardMouseOut(count)
	{
		for(var i=1; i<=total_rating_images; i++)
			{
				var obj = document.getElementById('img'+i);
				obj.src = img_src[i];
			}
	}
function ratingSolutionMouseOver(count, type,solution_id)
	{

		if(type == 'slidelist')
			{
				var hoverimage_name = 'icon-slidelistratehover.gif';
				var image_name = 'icon-slidelistrate.gif'
			}
		else if(type == 'board')
			{
				var hoverimage_name = 'icon-boardratehover.gif';
				var image_name = 'icon-boardrate.gif'
			}
		else if(type == 'solution')
			{
				var hoverimage_name = 'icon-solutionratehover.gif';
				var image_name = 'icon-solutionrate.gif'
			}
		for(var i=1; i<=count; i++)
			{
				var obj = document.getElementById('img'+i+'_'+solution_id);
				img_src[i] = obj.src;
				obj.src = photo_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+hoverimage_name;
			}
		for(; i<=total_rating_images; i++)
			{
				var obj = document.getElementById('img'+i+'_'+solution_id);
				img_src[i] = obj.src;
				obj.src = photo_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+image_name;
			}
	}

function ratingSolutionMouseOut(count,solution_id)
	{
		for(var i=1; i<=total_rating_images; i++)
			{
				var obj = document.getElementById('img'+i+'_'+solution_id);
				obj.src = img_src[i];
			}
	}





function callDiscuzzAjaxRate(path, div_id, updateDiv_id)
	{
		result_div  = div_id;
		updateDivId = updateDiv_id;
		jquery_ajax(path, '','ajaxDiscuzzResultRate');
		//setTimeout('changeRatingStatus()',2000);
		return false;
	}
function ajaxDiscuzzResultRate(data)
	{
		
		data  = unescape(data);
		$Jq('#'+result_div).css('display', 'block');

		if(data.indexOf('ERR~')>=1)
		{
			data = data.replace('ERR~','');
			alert_manual(data);
		}
		else
		{
			data = data.split('@');
			$Jq('#'+result_div).html( data[0]);
			$Jq('#'+updateDivId).html(data[1]);
			$Jq('#'+result_div).css('top', getAbsoluteOffsetTopConfirmation(document.getElementById('dAltMulti')) + 'px');
		}
	}
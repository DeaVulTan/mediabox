function showHideMenu(anchor_div_name, open_div_name, open_div_id, total_div_count, current_menu_id)
{
	if($Jq('#'+open_div_name+open_div_id).css('display') == 'none')
	{
		$Jq('#'+open_div_name+open_div_id).show();
		$Jq('#'+current_menu_id+open_div_id).removeClass('clsShowSubmenuLinks');
		$Jq('#'+current_menu_id+open_div_id).addClass('clsHideSubmenuLinks');

	}
	else if($Jq('#'+open_div_name+open_div_id).css('display',''))
	{
		$Jq('#'+open_div_name+open_div_id).hide();
		$Jq('#'+current_menu_id+open_div_id).removeClass('clsHideSubmenuLinks');
		$Jq('#'+current_menu_id+open_div_id).addClass('clsShowSubmenuLinks');
	}

}
//Rating related
var img_src = new Array();
function ratingPostMouseOver(count, type)
{
	if(type == 'blog')
		{
			var hoverimage_name = 'icon-blogratehover.gif';
			var image_name = 'icon-blograte.gif'
		}
	for(var i=1; i<=count; i++)
		{
			var obj = document.getElementById('img'+i);
			img_src[i] = obj.src;
			obj.src = blog_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+hoverimage_name;
		}
	for(; i<=total_rating_images; i++)
		{
			var obj = document.getElementById('img'+i);
			img_src[i] = obj.src;
			obj.src = blog_site_url+'design/templates/'+template_default+'/root/images/'+stylesheet_screen_default+'/'+image_name;
		}
}
function ratingPostMouseOut(count)
{
	for(var i=1; i<=total_rating_images; i++)
		{
			var obj = document.getElementById('img'+i);
			obj.src = img_src[i];
		}
}
function callAjaxRate(path, div_id, updateDiv_id)
	{
		result_div  = div_id;
		updateDivId = updateDiv_id;
		jquery_ajax(path,'', 'ajaxResultRate');
		return false;
	}
function ajaxResultRate(data)
	{
		data = unescape(data);
		var obj = $Jq('#' + result_div);
		$Jq('#' + result_div).css('display','inline');
		$Jq('#selRatingBlog').addClass('clsPostRating');
		if(data)
		{
			data = data.split('@');
		$Jq('#' + result_div).html(data[0]);
		$Jq('#' + updateDivId).html(data[1]);
			//$Jq('#selRatingBlog').css('top', getAbsoluteOffsetTopConfirmation(document.getElementById('dAltMulti')) + 'px');
		}




	}
function getAbsoluteOffsetTopConfirmation(obj){
	if(obj)
	{
	    var top = obj.offsetTop;
	    var parent = obj.offsetParent;
	    while (parent != document.body)
			{
		        top += parent.offsetTop;
		        parent = parent.offsetParent;
		    }
	    return top;
	}
	}
function tabChange(div_id, option)
{

	if(option == 'over')
		$Jq('#'+div_id).addClass('clsPostMenuOver');
	else if(option == 'out')
		$Jq('#'+div_id).removeClass('clsPostMenuOver');
}
function memberBlockLoginConfirmation(msg,url)
{
	document.msgConfirmformMulti1.action = url;
	return Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(msg), Array('innerHTML'));
}

function addFlagContent(url)
	{

		view_photo_content_id = 'Flag';
		var flag=$Jq('#flag').val();
		var comment=$Jq('#flag_comment').val();
		if(comment)
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').removeClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').removeClass('clsSuccessMessage');
				$Jq('#flag_submitted').html(view_post_ajax_page_loading);
				//$Jq('#flag_loader_row').show();
				pars = "&flag="+flag+"&flag_comment="+comment;
				url += pars;
				jquery_ajax(url, '', 'insertFlagContent');
			}
		else
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').addClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').html(viewpost_mandatory_fields);
			}
		return false;
	}


function insertFlagContent(resp)
	{

		data=resp;
		if(data.indexOf('ERR~')>=1)
		{
			data = data.replace('ERR~','');
		}
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').html(data);
		return false;
	}

// Index Blog Activity Related Function //
var display_activity_div = '';
function loadActivitySetting(divName)
{
	var temp = '';
	for(knc=0;knc<blog_activity_array.length;knc++)
	{
		head_div_id = 'sel'+blog_activity_array[knc]+'Activity_Head';
		content_div_id = 'sel'+blog_activity_array[knc]+'Activity_Content';
		if(blog_activity_array[knc] == divName)
		{
			$Jq('#'+head_div_id).addClass('clsIndexActivitiesActiveMenu');
			$Jq('#'+content_div_id).show();
			var pars = '?ajax_page=true&activity_type='+blog_activity_array[knc];
			var temp = content_div_id;
		}
		else
		{
			$Jq('#'+head_div_id).removeClass('clsIndexActivitiesActiveMenu');
			$Jq('#'+content_div_id).hide();
		}
	}
	// DISPLAY CONTENT //
	var div_content = $Jq('#'+temp).html();
	if(div_content == '')
		getActivityContent(blog_index_ajax_url, pars, temp);
	else
		return false;
}

function getActivityContent(url, pars, divname)
{

	display_activity_div = divname;
		$Jq.ajax({
					type: "POST",
					url: url,
					data: pars,
					//beforeSend:displayLoadingImage(),
					success: displayBlogIndexActivity
		 		});
		return false;
}

function displayBlogIndexActivity(request)
{

		data = unescape(request);
		$Jq('#'+display_activity_div).html(data);
}

function hidingBlocks()
{

	if(obj = $Jq('#selMsgLoginConfirmMulti').get(0))
	$Jq('#selMsgLoginConfirmMulti').css('display', 'none');
	if(obj = $Jq('#hideScreen').get(0))
	$Jq('#hideScreen').css('display','none');
	if(obj = $Jq('#selAjaxWindow').get(0))
	$Jq('#selAjaxWindow').css('display','none');
	if(obj = $Jq('#selAjaxWindowInnerDiv').get(0))
	$Jq('#selAjaxWindowInnerDiv').html('');
	$Jq("#selMsgLoginConfirmMulti").dialog('close');
	return false;
}


function showShareDiv(url){
	import_contacts_link = true;
	pars='';
	jquery_ajax(url, pars, 'ajaxResultBlogShare');
}

function ajaxResultBlogShare(data){
	$Jq('#shareDiv').html(data);
	import_contacts_link = true;
	Confirmation('shareDiv', 'formEmailList', Array(), Array(), Array());
}
// END //

var SlideShowQuickMixPopupWindow = null;
var slideShowSlideListWindow = null;
var checkbox_new_array= '';
var curr_quick_mix_photo_id;
var quick_mix_photo_id;
var playlist_photo_id_arr = new Array();

//the following variables used by fancy box modification usage.
var managePhotoCommentsPage = false;
var photoslidelistmanage = false;
var createmoviemaker = false;
//CAROSEL JS START//
var populatedTabs = new Array();
var populatedData = new Array();
function showHidePhotoTabs(div_id, tabs)
{
	if(tabs == 'photoCarosel')
	{
		div_class = 'clsActive';
		div_array = photo_tabs_divid_array;
	}
	else if(tabs == 'topChartCarosel')
	{
		div_class = 'clsIndexActivitiesActiveMenu';
		div_array = topChart_array;
	}
// Process start //
	for(inc=0;inc<div_array.length;inc++)
	{
		if(div_array[inc] == div_id)
			continue;
		$Jq('#'+div_array[inc]+'_Content').html(photo_ajax_page_loading);
		$Jq('#'+div_array[inc]).hide();
		$Jq('#'+div_array[inc]+'_Head').removeClass(div_class);
		$Jq('#'+div_array[inc]+'_Content').hide();
	}
	$Jq('#'+div_id).show();
    $Jq('#'+div_id+'_Head').addClass(div_class);
    $Jq('#'+div_id+'_Content').show();
    $Jq('#sel'+div_id+'Process').html(photo_ajax_page_loading);

	if(tabs == 'photoCarosel')
	{
		sel_carousel_div_content_name = div_id+'_Content';
		populateTabIndex = jQuery.inArray(sel_carousel_div_content_name, populatedTabs);
		if (populateTabIndex == -1)
		{
			new jquery_ajax(photo_index_ajax_url, 'block='+div_id ,'displayPhotoContent');
		}
		else
		{
			$Jq('#'+sel_carousel_div_content_name).html(populatedData[populateTabIndex]);
		}
	}
	else if(tabs == 'topChartCarosel')
	{
		sel_carousel_top_chart_div_content_name = div_id+'_Content';
		populateTabIndex = jQuery.inArray(sel_carousel_top_chart_div_content_name, populatedTabs);
		if (populateTabIndex == -1)
		{
			new jquery_ajax(photo_index_ajax_url, 'topChart='+div_id ,'displayPhotoTopChartContent');
		}
		else
		{
			$Jq('#'+sel_carousel_top_chart_div_content_name).html(populatedData[populateTabIndex]);
		}
	}

	return true;
}

function displayPhotoContent(data)
{
	data = unescape(data);
	$Jq('#'+sel_carousel_div_content_name).html(data);
	populatedTabs[populatedTabs.length] = sel_carousel_div_content_name;
	populatedData[populatedData.length] = data;
}
function displayPhotoTopChartContent(data)
{
	data = unescape(data);
	$Jq('#'+sel_carousel_top_chart_div_content_name).html(data);
	populatedTabs[populatedTabs.length] = sel_carousel_top_chart_div_content_name;
	populatedData[populatedData.length] = data;
}
//CAUROSEL JS END//
// PHOTO ACTIVITY RELATED FUNTION //
var display_activity_div = '';
function loadActivitySetting(divName)
{
	var temp = '';
	for(knc=0;knc<photo_activity_array.length;knc++)
	{
		head_div_id = 'sel'+photo_activity_array[knc]+'Activity_Head';
		content_div_id = 'sel'+photo_activity_array[knc]+'Activity_Content';
		if(photo_activity_array[knc] == divName)
		{
			$Jq('#'+head_div_id).addClass('clsIndexActivitiesActiveMenu');
			$Jq('#'+content_div_id).show();
			var pars = '?ajax_page=true&activity_type='+photo_activity_array[knc];
			var temp = content_div_id;
		}
		else
		{
			$Jq('#'+head_div_id).removeClass('clsIndexActivitiesActiveMenu');
			$Jq('#'+content_div_id).hide();
		}
	}
	// DISPLAY CONTENT //
	var div_content =  $Jq('#'+temp).html();
	if(div_content == '')
		getActivityContent(photo_index_ajax_url, pars, temp);
	else
		return false;
}

function getActivityContent(url, pars, divname)
{
	display_activity_div = divname;
	jquery_ajax(url, pars, 'displayPhotoIndexActivity');
}

function displayPhotoIndexActivity(request)
{
	data = unescape(request);
	if(data)
	{
		data= $Jq.trim(data);
		//data = data.split('***--***!!!');
		$Jq('#'+display_activity_div).html(data);
	}
}
// END //
function getAjaxGetCode(path, delLink,formName,getCode)
{

	getCodeFormName=formName;
	delLink_value = delLink;
	code=getCode;

	new jquery_ajax(path, '', 'getdisplayCode');
	return false;
}

function getdisplayCode(data)
{
	data = unescape(data);
	var obj = document.getElementById(getCodeFormName);

/*	if(data.indexOf(session_check)>=1)
		data = data.replace(session_check_replace,'');
	else
		return; */
	data = data.strip();
	$Jq('#'+getCodeFormName).html('<div id="selDisplayWidth" width="900" >'+data+'</div>');
	Confirmation(getCodeFormName, 'msgConfirmform', Array(getCodeFormName), Array('<div id="selDisplayWidth">'+data+'</div>'), Array('html()'), -100, -550,code);
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
/**
 *
 * @access public
 * @return void
 **/
function addPhotoIdToCheckBoxArray(photo_id_val)
{
	var obj = $Jq('#selCheckBox').get(0);
	var checkbox_val = obj.value;
	var checkbox_arr =[];
	checkbox_arr=checkbox_val.split(',');
	if(!in_arry(checkbox_arr,photo_id_val))
	{
		checkbox_arr.push(photo_id_val);
		var count_val = checkbox_arr.length;
		var checkbox_new_array= '';
		for(i=0;i<count_val;i++)
		{
			if(checkbox_new_array =='')
				checkbox_new_array = checkbox_arr[i];
			else
				checkbox_new_array = checkbox_new_array+','+checkbox_arr[i];
		}
		obj.val(checkbox_new_array);
	}
	else if(in_arry(checkbox_arr,photo_id_val))
	{
		var count_val = checkbox_arr.length;
		var checkbox_new_array= '';
		for(i=0;i<count_val;i++)
		{
			if(checkbox_arr[i]!=photo_id_val)
			{
				if(checkbox_new_array =='')
					checkbox_new_array = checkbox_arr[i];
				else
					checkbox_new_array = checkbox_new_array+','+checkbox_arr[i];
			}
		}
		obj.val(checkbox_new_array);
	}
	var objslide = $Jq('#selCheckBoxForSlideList').get(0);
	var checkbox_val_slide = objslide.value;
	var checkbox_slide_arr =[];
	checkbox_slide_arr=checkbox_val_slide.split(',');
	if(!in_arry(checkbox_slide_arr,photo_id_val))
	{
		checkbox_slide_arr.push(photo_id_val);
		var count_val = checkbox_slide_arr.length;
		var checkbox_slide_new_array= '';
		for(i=0;i<count_val;i++)
		{
			if(checkbox_slide_new_array =='')
				checkbox_slide_new_array = checkbox_slide_arr[i];
			else
				checkbox_slide_new_array = checkbox_slide_new_array+','+checkbox_slide_arr[i];
		}
		objslide.val(checkbox_slide_new_array);
	}
	else if(in_arry(checkbox_slide_arr,photo_id_val))
	{
		var count_val = checkbox_slide_arr.length;
		var checkbox_slide_new_array= '';
		for(i=0;i<count_val;i++)
		{
			if(checkbox_slide_arr[i]!=photo_id_val)
			{
				if(checkbox_slide_new_array =='')
					checkbox_slide_new_array = checkbox_slide_arr[i];
				else
					checkbox_slide_new_array = checkbox_slide_new_array+','+checkbox_slide_arr[i];
			}
		}
		objslide.val(checkbox_slide_new_array);
	}
}
/**
 *
 * @access public
 * @return void
 **/
function removePhotoIdToCheckBoxArray(photo_id_val)
{
	var obj = $Jq('#selCheckBox').get(0);
	var checkbox_val = obj.value;
	var checkbox_arr =[];
	checkbox_arr=checkbox_val.split(',');
	var count_val = checkbox_arr.length;
	var checkbox_new_array= '';
	for(i=0;i<count_val;i++)
	{
		if(checkbox_arr[i]!=photo_id_val)
		{
			if(checkbox_new_array =='')
				checkbox_new_array = checkbox_arr[i];
			else
				checkbox_new_array = checkbox_new_array+','+checkbox_arr[i];
		}
	}
	checkbox_arr = checkbox_new_array;
	var add_id = 'anchor_add_checkbox_'+photo_id_val;
	var remove_id = 'anchor_remove_checkbox_'+photo_id_val;
	$Jq(add_id).css('display','block');
	$Jq(remove_id).css('display','none');
	obj.val(checkbox_arr);
}
/* To get photo ids for quickMix
   form_name, check_all_name, alert_value, place
 */
var quickMixmultiCheckValue = '';
var getMultiCheckBoxValueForQuickMixOld = function()
{
	var form_name = arguments[0];
	var ids=$Jq('#'+arguments[1]).value;
	if(arguments.length>2)
	{
		var alert_value = arguments[2];
	}
	if(ids)
	{
		quickMixmultiCheckValue =ids;
		return true;
	}

	if(arguments.length>2)
	{
		alert_manual(alert_value);
	}
	return false;
}


/* To get photo ids for quickMix
   form_name, check_all_name, alert_value, place
 */
var quickMixmultiCheckValue = '';
var getMultiCheckBoxValueForQuickMix = function()
{
	var form_name = arguments[0];
	var check_all_name = arguments[1];
	if(arguments.length>2)
	{
		var alert_value = arguments[2];
	}
	var frm = eval('document.'+form_name);
	var ids = '';
	quickMixmultiCheckValue = '';
	var quick_mix_added = false;
	for(var i=0;i<frm.elements.length;i++)
	{
		var e=frm.elements[i];
		//extra condition added for quickmix cheking
		if ((e.name != check_all_name) && (e.type=='checkbox') && e.checked)
		{
			if($Jq('#quick_mix_added_'+e.value).css('display') == 'none')
				ids += e.value+',';
			else
				quick_mix_added = true;
		}
	}
	if(ids)
	{
		quickMixmultiCheckValue =ids.substring(0,ids.length-1);
		return true;
	}
	if(quick_mix_added)
	{
		alert_manual(qucikmix_added_already);
		return false;
	}
	if(arguments.length>2)
	{
		alert_manual(alert_value);
	}
	return false;
}

//To update QuickMixs
function updatePhotosQuickMixCount(photo_id)
{
	quick_mix_photo_id_arr.push(photo_id);
	curr_quick_mix_photo_id = photo_id;
	toggleQLStackBtn(addToStack,quick_mix_photo_id_arr);
	var url = cfg_site_url+'photo/photoUpdateQuickMix.php';
	var pars = '?photo_id='+photo_id;
	var path = url+pars;
	jquery_ajax(path, '','getSlideShowCode');

}

//After updating QuickMix
function getSlideShowCode(data)
{
	if(data.indexOf('ERR~')>=1)
		{
			$Jq('#quick_mix_saving_' + photo_id).css('display','none');
			$Jq('#quick_mix_' + photo_id).css('display','block');
			data = data.replace('ERR~','');
			alert_manual(data);
		}
	else
		{
			if(curr_quick_mix_photo_id.indexOf(',') != -1)
			{
				var multi_quick_mix_photo_id_arr = curr_quick_mix_photo_id.split(',');
				for(var i=0;i<multi_quick_mix_photo_id_arr.length;i++)
				{
					if($Jq('#quick_mix_'+multi_quick_mix_photo_id_arr[i]) && $Jq('#quick_mix_added_'+multi_quick_mix_photo_id_arr[i]))
					{
						$Jq('#quick_mix_'+multi_quick_mix_photo_id_arr[i]).hide();
						$Jq('#quick_mix_added_'+multi_quick_mix_photo_id_arr[i]).show();
					}
				}
			}
			else
			{
				$Jq('#quick_mix_saving_' + curr_quick_mix_photo_id).css('display','none');
				$Jq('#quick_mix_'+curr_quick_mix_photo_id).hide();
				$Jq('#quick_mix_added_'+curr_quick_mix_photo_id).show();
			}
		}
	//listenBaloon_divAgain();
//	quickMixPlayer(curr_quick_mix_photo_id);
	return false;
}

//To Remove Photo id from QuickMixs
function removePhotosQuickMixCount(photo_id)
{
    var tmpArr = quick_mix_photo_id_arr.toString();
    quick_mix_photo_id_arr =tmpArr.split(',');
    /*if(tmpArr.indexOf(',') == -1)
    {
      clearAllQuickSlideConfirmation();
      if(!$Jq('quick_slide_clear_act').value)
      return;
    }*/
	removeElementInArray(quick_mix_photo_id_arr,photo_id);

	curr_quick_mix_photo_id = photo_id;
	toggleQLStackBtn(removeFromStack,quick_mix_photo_id_arr);
	var url = cfg_site_url+'photo/photoUpdateQuickMix.php';
	var pars = '?remove_it=true&photo_id='+photo_id;
	var path = url+pars;
	jquery_ajax(path, '', 'removePhotosQuickMixAjax');


}
function removePhotosQuickMixAjax(data)
{
	if(data.indexOf('ERR~')>=1)
		{
			$Jq('#quick_mix_saving_' + photo_id).css('display','none');
			$Jq('#quick_mix_added_' + photo_id).css('display','block');
			data = data.replace('ERR~','');
			alert_manual(data);
		}
	else
		{
			$Jq('#quick_mix_saving_' + curr_quick_mix_photo_id).css('display','none');
			$Jq('#quick_mix_'+curr_quick_mix_photo_id).show();
			$Jq('#quick_mix_added_'+curr_quick_mix_photo_id).hide();
		}
	return false;
}

function removeElementInArray(arrayName,arrayElement)
 {
    for(var i=0; i<arrayName.length;i++ )
     {
        if(arrayName[i]==arrayElement)
            arrayName.splice(i,1);
      }
  }
var curr_quick_mix_photo_ids;
function clearAllQuickSlideConfirmation(){
$Jq('#quick_slide_clear_act').val('');
Confirmation('selQuickslideMsgConfirm','quickSlideMsgConfirmform',Array('quickSlideMsgConfirmText'),Array(photo_stack_confirmation_msg),Array('html'), -100, -300);
	return false;

}
function hideQuickSlideBlock(){
	hideAllBlocks();
	$Jq('#quick_slide_clear_act').val('');
	$Jq('#selQuickslideMsgConfirm').css('display', 'none');
	$Jq('#selQuickslideMsgConfirm').dialog('close');
}
function clearAllQuickSlide(){
    curr_quick_mix_photo_ids = quick_mix_photo_id_arr;
    curr_quick_mix_photo_ids=curr_quick_mix_photo_ids.toString();
    quick_mix_photo_id_arr=new Array();
    toggleQLStackBtn(removeFromStack,quick_mix_photo_id_arr);
    var url = cfg_site_url+'photo/photoUpdateQuickMix.php';
	var pars = '?clear_quickmix_all=true';
	var path = url+pars;
	jquery_ajax(path, '', 'clearAllQuickSlideAjax');
	hideQuickSlideBlock();
	$Jq('#quick_slide_clear_act').val(1);
	if(SlideShowQuickMixPopupWindow)
	  SlideShowQuickMixPopupWindow.close();
}
function clearAllQuickSlideAjax(data)
{

   if(curr_quick_mix_photo_ids.indexOf(',') != -1)
	{
		var multi_quick_mix_photo_id_arr = curr_quick_mix_photo_ids.split(',');
		for(var i=0;i<multi_quick_mix_photo_id_arr.length;i++)
		{
			if($Jq('#quick_mix_'+multi_quick_mix_photo_id_arr[i]) && $Jq('#quick_mix_added_'+multi_quick_mix_photo_id_arr[i]))
			{
				$Jq('#quick_mix_'+multi_quick_mix_photo_id_arr[i]).show();
				$Jq('#quick_mix_added_'+multi_quick_mix_photo_id_arr[i]).hide();
			}
		}
	}
	else
	{
	   if($Jq('#quick_mix_'+curr_quick_mix_photo_ids) && $Jq('#quick_mix_added_'+curr_quick_mix_photo_ids))
		{
			$Jq('#quick_mix_'+curr_quick_mix_photo_ids).show();
			$Jq('#quick_mix_added_'+curr_quick_mix_photo_ids).hide();
		}
	}
  return false;
}
//quickMixPlayer - To open slide show player in popup window
var quickMixPlayer =  function()
{
   if(quick_mix_photo_id_arr.length>0)
   {
      if($Jq('#photo_stack').css('display') == 'none')
       toggleQLStackBtn(addToStack,quick_mix_photo_id_arr);
   }
   else
   {
      alert_manual(photos_no_stack_msg);
   }
}

var openSlideShowPlayer =  function()
{
   if(quick_mix_photo_id_arr.length>0)
   {
		if(arguments[0])
		{
			var photo_id = arguments[0];
		}
		url = play_quickMix_url;
		if(SlideShowQuickMixPopupWindow && quick_mix_photo_id_arr.length==1)
			SlideShowQuickMixPopupWindow.close();

		if(!SlideShowQuickMixPopupWindow || SlideShowQuickMixPopupWindow.closed)
		{

			SlideShowQuickMixPopupWindow = window.open(url, 'slideShowQuickMixWindow', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=yes');
			SlideShowQuickMixPopupWindow.focus();
		}
	}
}


//To get QuickMIX photo  - parameters - url, photo_id
var getQuickMIXphotoDetails = function()
	{
		var photo_id = arguments[0];
		var update_photo_url = update_photos_to_Slide_url+'?photo_id='+photo_id;
		//update_photos_to_Slide_url += '?photo_id='+photo_id;
		quick_mix_photo_id_arr.push(photo_id);
		if(SlideShowQuickMixPopupWindow == null || SlideShowQuickMixPopupWindow.closed)
			{
				quickMixPlayer(photo_id);
			}
		else
			{
				quick_mix_photo_id = photo_id;
				jquery_ajax(update_photo_url, '', 'appendQuickMixPhoto')
			}
	}

//To append QuickMIX photo to slide show player
function appendQuickMixPhoto(data)
	{
		data = unescape(data);
		/*if(data.indexOf(session_check)>=1)
			{
				data = data.split(session_check_replace);
				data = data[1].strip();
			}*/
		var photo_src=data.substring(0,data.indexOf('.')+4);
		photo_src =cfg_site_url+photos_file_url+photo_src;
        var photo_title = data.substring(data.indexOf('.')+4,data.length);

		SlideShowQuickMixPopupWindow.window.document.getElementById('supersize').html()+='<a><img src="'+photo_src+'" title="'+photo_title+'" /></a>';
		SlideShowQuickMixPopupWindow.window.$Jq('#slidecounter .totalslides').html(SlideShowQuickMixPopupWindow.window.$Jq("#supersize > *").size());
		SlideShowQuickMixPopupWindow.focus();
	}


var multiCheckValue = '';
var getMultiCheckBoxValueForSlideList = function()
{
	var form_name = arguments[0];
	var ids=$Jq('#'+arguments[1]).value;
	if(arguments.length>2)
	{
		var alert_value = arguments[2];
	}
	if(ids)
	{
		multiCheckValue =ids;
		return true;
	}

	if(arguments.length>2)
	{
		alert_manual(alert_value);
	}
	return false;
}
// SlideList FUNCTIONALITY START //
function  manageSlideList(multiCheckValue, url, litle_window_title)// managePlaylist(photo_id, url, litle_window_title)
{
	url = url+'&photo_id='+multiCheckValue;
	/*$Jq.fancybox({
		'width'				: '30%',
		'height'			: '30%',
		'autoScale'     	: false,
		'href'				: url,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'title'				: litle_window_title,
		'type'				: 'iframe'
	});*/
	$Jq.fancybox({
        'width'				: 500,
        'height'			: 300,
        'autoScale'     	: false,
        'href'              : url,
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'type'				: 'iframe',
        'title'				: litle_window_title,
        'centerOnScroll'	: true,
		'titleShow'			: false
    });

}

// SlideList FUNCTIONALITY END //

function memberBlockLoginConfirmation(msg,url)
{
	document.msgConfirmformMulti1.action = url;
	return Confirmation('selMsgLoginConfirmMulti', 'msgConfirmformMulti1', Array('selAlertLoginMessage'), Array(msg), Array('html'));
}
function scrollDiv(){
	var container=$Jq('#scrollbar_content');
	container.jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
}

function hidingBlocks()
{
	$Jq("#selMsgLoginConfirmMulti").dialog('close');
	if(obj = $Jq('#selMsgLoginConfirmMulti'))
	obj.css('display', 'none');
	if(obj = $Jq('#hideScreen'))
	obj.css('display','none');
	if(obj = $Jq('#selAjaxWindow'))
	obj.css('display','none');
	if(obj = $Jq('#selAjaxWindowInnerDiv'))
	obj.html('');
	return false;
}
function showHideMenu(anchor_div_name, open_div_name, open_div_id, total_div_count, current_menu_id)
{

	if(!$Jq('#'+open_div_name+open_div_id).is(":visible"))
	{
		//$Jq(anchor_div_name+open_div_id).addClass('clsActiveLink');
		$Jq('#'+open_div_name+open_div_id).show();
		$Jq('#'+current_menu_id+open_div_id).removeClass('clsShowSubmenuLinks');
		$Jq('#'+current_menu_id+open_div_id).addClass('clsHideSubmenuLinks');
	}
	else
	{
		//$Jq(anchor_div_name+open_div_id).removeClass('clsActiveLink');
		$Jq('#'+open_div_name+open_div_id).hide();
		$Jq('#'+current_menu_id+open_div_id).removeClass('clsHideSubmenuLinks');
		$Jq('#'+current_menu_id+open_div_id).addClass('clsShowSubmenuLinks');
	}
}
function addPhotoQuickMixRedirect(url)
{
	self.close();
}

//VIEW ALBUM PAGING START
function photoAlbumAjaxPaging(query_string, action)
{
	if(action == "")
	{
		start = 0;
	}
	else
	{
		startvalue = $Jq('start').value;
		if(action == 'perv')
			start = parseInt(startvalue) - parseInt(pageing_limit);
		else
			 start = parseInt(startvalue) + parseInt(pageing_limit);
		$Jq('#start').val(start);
	}
	$Jq('#albumInPhotoList').html($Jq('#loaderPhotos').html());
	var pars = query_string+'&start='+start;
	ajaxpageing_url = relatedUrl+pars;
	jquery_ajax(ajaxpageing_url, '', 'albumPhotolistBlock');
	return false;
}

function albumPhotolistBlock(request)
{
	data = request;
	/*if(data.indexOf(session_check)>=1)
		data = data.replace(session_check_replace,''); */
	if(data.indexOf('~!###!~')>=1)
		data = data.split('~!###!~');

	$Jq('#albumInPhotoList').html(data);
}
//VIEW ALBUM PAGING END//

function moreInformation(div_id)
{
	var ahref_id = div_id.split('_');
	var temp_id = ahref_id[0]+'_ahref_'+ahref_id[1];
	if($Jq('#'+div_id).css('display', 'none'))
	{
		$Jq('#'+temp_id).addClass('clsActive');
		$Jq('#'+div_id).show();
	}
	else
	{
		$Jq('#'+temp_id).removeClass('clsActive');
		$Jq('#'+div_id).hide();
	}
}

function manageSlidelistReorder(slidelist_id)
{
	slidelist_url=photo_site_url+'organizeSlidelist.php?photo_slidelist_id='+slidelist_id;
	$Jq.fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'     	: false,
		'href'				: slidelist_url,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	return false;
}
function slidelistPopupWindowClose()
{
	self.close();
}

function deletePlaylistPhotosInPlayer(playlist_id,photo_id,delete_id)
{
	playlist_photo_id_arr.push(photo_id);
	playlist_photo_id = photo_id;
	var url = photo_site_url+'organizeSlidelist.php';
	var pars = '?delete_photo_playlist_id='+playlist_id+'&photo_id='+photo_id;
	var path = url+pars;
	$Jq.ajax({
			type: "GET",
			url: url,
			data: pars,
			beforeSend:playlistDeleteLoadedFunc,
			success: playlistDeleteSuccessFunc
		 });
}

function playlistDeleteSuccessFunc(response)
{

	if(obj = $Jq('#playlist_delete').get(0))
	obj.css('display', 'none');
	if(obj = $Jq('#delete_'+playlist_photo_id).get(0))
	obj.css('display', 'none');

}
function playlistDeleteLoadedFunc(response)
{
	if(obj = $Jq('#playlist_delete').get(0))
	obj.css('display', 'block');
}

function getRelatedPhoto(related)
	{
		var pars='type='+related+'&photo_id='+photo_id+'&ajax_page=true&relatedPhoto=true';
		$Jq('#relatedPhotoContent').html('');
		$Jq('#loaderPhotos').removeClass('clsDisplayNone');
		$Jq.ajax({
			type: "GET",
			url: relatedUrl,
			data: pars,
			success: ajaxRelatedResult
		 });
		$Jq('#selHeaderPhotoUser').removeClass('clsActive');
		$Jq('#selHeaderPhotoRel').removeClass('clsActive');

		if(related=='user')
			{
				$Jq('#selHeaderPhotoUser').addClass('clsActive');
				//$Jq('#selHeaderPhotoUser').stopObserving('mouseout', '');
				$Jq('#selHeaderPhotoUser').unbind('mouseout', '');
			}
		if(related=='tag')
			{
				$Jq('#selHeaderPhotoRel').addClass('clsActive');
				//document.getElementById('selHeaderPhotoRel').stopObserving('mouseout', '');
				$Jq('#selHeaderPhotoRel').unbind('mouseout', '')
			}
}
function ajaxRelatedResult(data){
	$Jq('#loaderPhotos').addClass('clsDisplayNone');
	$Jq('#relatedPhotoContent').html(data);
	$Jq('#selNextPrev_top').html($Jq('#selNextPrev').html());
	$Jq('#relatedPhotoContent').jScrollPane({showArrows:true,scrollbarWidth:10, scrollbarMargin:10});
}
/**
 *
 * @access public
 * @return void
 **/
function showCaption(divid)
{
	$Jq('#'+divid).css('display', 'inline');
}
/**
 *
 * @access public
 * @return void
 **/
function hideCaption(divid)
{
	$Jq('#'+divid).css('display','none');
}
function tabChange(div_id, option)
{
	if(option == 'over')
		$Jq('#'+div_id).addClass('clsPhotoMenuOver');
	else if(option == 'out')
		$Jq('#'+div_id).removeClass('clsPhotoMenuOver');
}

// AJAX FUCNTION TO STORE FLAG CONTENT
function addFlagContent(url){
	var flag=$Jq('#flag').val();
	var comment=encodeURIComponent($Jq('#flag_comment').val());
	if(comment){
		$Jq('#clsMsgDisplayFlagDiv').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplayFlagDiv').html('');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').html(view_photo_ajax_page_loading);
		pars="flag="+flag+"&flag_comment="+comment;
		hideAllBlocks();
		openAjaxWindow('true', 'ajaxupdate', 'jquery_ajax', url, pars, 'addFlagContentresponse');
	}
	else{
		$Jq('#clsMsgDisplayFlagDiv').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplayFlagDiv').html(viewphoto_mandatory_fields);
	}
	return false;
}

/*function addFlagContent(url)
	{
		view_photo_content_id = 'Flag';
		var flag=$Jq('#flag').val();
		var comment=encodeURIComponent($Jq('#flag_comment').val());
		if(comment)
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').removeClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').removeClass('clsSuccessMessage');
				$Jq('#flag_submitted').html(view_photo_ajax_page_loading);
				$Jq('#flag_loader_row').show();
				pars = "&flag="+flag+"&flag_comment="+comment;
				url += pars;
				jquery_ajax(url, '','insertFlagContent');
			}
		else
			{
				$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
				$Jq('#clsMsgDisplay_flag').addClass('clsErrorMessage');
				$Jq('#clsMsgDisplay_flag').html(viewphoto_mandatory_fields);
				///scrollbar.recalculateLayout();
				scrollDiv();
			}
		return false;
	}*/

function insertFlagContent(resp)
	{
		data=resp;

		document.flagfrm.reset();
		//$Jq('flagFrm').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').addClass('clsSuccessMessage');

		if($Jq('#flag_loader_row'))
			$Jq('#flag_loader_row').hide();

		$Jq('#clsMsgDisplay_flag').html(data);
		//scrollbar.recalculateLayout();
		scrollDiv();
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


// AJAX FUCNTION TO STORE FLAG CONTENT
function addPhotoFlagContentAjax(url){
	var flag=$Jq('#flag').val();
	var comment=$Jq('#flag_comment').val();

	if($Jq.trim(comment) == '')
	{
		$Jq('#clsMsgDisplayFlagDiv').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplayFlagDiv').html(viewphoto_mandatory_fields);
	}
	else
	{
		comment=encodeURIComponent($Jq('#flag_comment').val());
		$Jq('#clsMsgDisplayFlagDiv').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplayFlagDiv').html('');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').html(photo_ajax_page_loading);
		pars="flag="+flag+"&flag_comment="+comment;
		hideAllBlocks();
		openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, pars, 'addFlagContentresponse');
	}
	return false;
}

function addFlagContentresponse(html){
	if(html.indexOf('ERR~')>=1)
	{
		html = html.replace('ERR~','');
	}
	document.flagfrm.reset();
	$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
	$Jq('#clsMsgDisplay_flag').html(html);
}


function chkPlaylist(obj)
{
	if($Jq('#'+obj).val()=="#new#")
	{
		$Jq('#createNewPlaylist').show();
	}
	else
	{
		$Jq('#createNewPlaylist').hide();
	}
}
// AJAX FUNCTION TO SEND THE PLAYSIT DETAILS BOTH CREATION AND SELECTION

function createPlayList(url, photo_id, playlist){
	//$Jq('#clsMsgDisplay_playlist').addClass('clsDisplayNone');
	//playlist=$Jq('#playlist').val();
	$Jq('#clsMsgDisplay_playlist_success').addClass('clsDisplayNone');
	$Jq('#clsMsgDisplay_playlist_failure').addClass('clsDisplayNone');
	var pars='';
	if(playlist=="#new#"){
		title = $Jq('#playlistTitle').val();
		var encode_title =encodeURIComponent($Jq('#playlistTitle').val());
		var desc = encodeURIComponent($Jq('#playlistDesc').val());
		var access =$Jq('#.playlistAccess');
		var accessValue=$Jq('#playlist_access_type').val();
		if($Jq.trim(title) == ''){
			$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
			$Jq('#clsMsgDisplay_playlist_failure').html(invalidPlaylist);
			return false;
		}
		else{
			$Jq('#clsMsgDisplay_playlist_failure').addClass('clsDisplayNone');
			$Jq('#clsMsgDisplay_playlist_failure').html('');
		}
		playlistTitle=title;
		pars='playlist_name='+encode_title+'&playlist_description='+desc+'&playlist_access_type='+accessValue+'&photo_id='+photo_id;
	}
	if(playlist!="#new#" && playlist){
		pars='playlist='+playlist+'&photo_id='+photo_id;
		playlistId=playlist;
	}
	if(pars){
		$Jq('#clsMsgDisplay_playlist_success').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_success').html(photo_ajax_page_loading);
		return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, pars, 'createPlayListResponse');
	}
	else{
		$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_failure').html(selectionError);
	}
}
function createPlayListResponse(data){
	playlistId='';
	if(data.indexOf('ERR~')>=1)
	{
		hideAllBlocks();
		data = data.replace('ERR~','');
		$Jq('#clsMsgDisplay_playlist_success').html(data);
		$Jq('#clsMsgDisplay_playlist_success').show();
		return false;
	}
	if(data.indexOf('#$#')>=1){
		var dataTemp=data.split('#$#');
		data = dataTemp[0];
		playlistId=dataTemp[1];
	}
	if(playlistId){
		hideAllBlocks();
		if($Jq('#photoListForm').length > 0)
		{
			document.photoListForm.reset();
		}
		$Jq('#clsMsgDisplay_playlist_failure').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_success').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_success').html(data);
	}
	else{
		$Jq('#clsMsgDisplay_playlist_success').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_failure').html(data);
	}
}
//Rating related
var img_src = new Array();
function ratingPhotoMouseOver(count, type)
	{
		if(type == 'slidelist')
			{
				var hoverimage_name = 'icon-slidelistratehover.gif';
				var image_name = 'icon-slidelistrate.gif'
			}
		else if(type == 'photo')
			{
				var hoverimage_name = 'icon-photoratehover.gif';
				var image_name = 'icon-photorate.gif'
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

function ratingPhotoMouseOut(count)
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
		jquery_ajax(path, '','ajaxResultRate');
		//setTimeout('changeRatingStatus()',2000);
		return false;
	}
function ajaxResultRate(data)
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
	function addslashes(str)
	{
		str=str.replace(/\\/g,'\\\\');
		str=str.replace(/\'/g,'\\\'');
		str=str.replace(/\"/g,'\\"');
		str=str.replace(/\0/g,'\\0');
		return str;
	}

	function stripslashes(str)
	{
		str=str.replace(/\\'/g,'\'');
		str=str.replace(/\\"/g,'"');
		str=str.replace(/\\0/g,'\0');
		str=str.replace(/\\\\/g,'\\');
		return str;
	}
	function zoom(divid,imgsrc,title){
		var did = '#'+divid;
		var imgid = '#image_'+divid;
		title = stripslashes(title);
		$Jq.fancybox({
			'orig' : $Jq(imgid),
			'padding' : 0,
			 'href' : imgsrc,
			 'title' : title,
			 'transitionIn' : 'elastic',
			 'transitionOut' : 'elastic'
		 });
	}
	/**
	 *
	 * @access public
	 * @return void
	 **/
	function showPhotoSidebarTab(activateDiv,disableDiv){
		$Jq('#'+activateDiv+'Header').addClass('clsActive');
		$Jq('#'+disableDiv+'Header').removeClass('clsActive');

		$Jq('#'+activateDiv+'Content').css('display','block');
		$Jq('#'+disableDiv+'Content').css('display','none');
	}
	/**
	 *
	 * @access public
	 * @return void
	 **/
	function openSlodeListShow(url)
	{
		if(slideShowSlideListWindow)
			slideShowSlideListWindow.close();
		slideShowSlideListWindow = window.open(url, 'slideShowSlideListWindow', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=yes');
		slideShowSlideListWindow.focus();
	}
	function logoutConfirmation(url){
	if(quick_mix_photo_id_arr.length>0)
	{
		Confirmation('selLogoutMsgConfirm','logoutMsgConfirmform',Array(),Array(),Array(), -100, -300);
		return false;
	 }
	 else
	 {
	 	window.location=url;
	 }
}
function hideLogoutBlock(){
hideAllBlocks();
$Jq('selLogoutMsgConfirm').css('display','none');
}
function doLogout(url){
window.location=url;
}

// ---------------------  Movie Maker related Fuction stars -------------------------------//
var curr_movie_queue_photo_id;
var movieQueueMultiCheckValue = '';
var getMultiCheckBoxValueForMovieQueue = function()
{
	var form_name = arguments[0];
	var check_all_name = arguments[1];
	if(arguments.length>2)
	{
		var alert_value = arguments[2];
	}
	var frm = eval('document.'+form_name);
	var ids = '';
	movieQueueMultiCheckValue = '';
	var movie_queue_added = false;
	for(var i=0;i<frm.elements.length;i++)
	{
		var e=frm.elements[i];
		//extra condition added for quickmix cheking
		if ((e.name != check_all_name) && (e.type=='checkbox') && e.checked)
		{
			if($Jq('#movie_queue_added_'+e.value).css('display') =='none')
				ids += e.value+',';
			else
				movie_queue_added = true;
		}
	}
	if(ids)
	{
		movieQueueMultiCheckValue =ids.substring(0,ids.length-1);
		return true;
	}
	if(movie_queue_added)
	{
		alert_manual(movie_queue_added_already);
		return false;
	}
	if(arguments.length>2)
	{
		alert_manual(alert_value);
	}
	return false;
}

//To update movieQueue
function updatePhotosMovieQueueCount(photo_id)
{
	movie_queue_photo_id_arr.push(photo_id);
	curr_movie_queue_photo_id = photo_id;
	var url = cfg_site_url+'photo/queueMoviePhoto.php';
	var pars = '?photo_id='+photo_id;
	var path = url+pars;
	new jquery_ajax(path, '','updateMovieMakerResult');

}
//After updating movieQueue
function updateMovieMakerResult(data)
{
	if(curr_movie_queue_photo_id.indexOf(',') != -1)
	{
		var multi_movie_queue_photo_id_arr = curr_movie_queue_photo_id.split(',');
		for(var i=0;i<multi_movie_queue_photo_id_arr.length;i++)
		{
			if($Jq('#movie_queue_'+multi_movie_queue_photo_id_arr[i]) && $Jq('#movie_queue_added_'+multi_movie_queue_photo_id_arr[i]))
			{
				$Jq('#movie_queue_'+multi_movie_queue_photo_id_arr[i]).hide();
				$Jq('#movie_queue_added_'+multi_movie_queue_photo_id_arr[i]).show();
			}
		}
	}
	else
	{
	  if($Jq('#movie_queue_'+curr_movie_queue_photo_id) && $Jq('#movie_queue_added_'+curr_movie_queue_photo_id))
	  {
		$Jq('#movie_queue_'+curr_movie_queue_photo_id).hide();
		$Jq('#movie_queue_added_'+curr_movie_queue_photo_id).show();
	  }
	}
	alert_manual(movie_queue_added_success_msg);
	return false;
}

//To Remove Photo id from movieQueue
function removePhotosMovieQueueCount(photo_id)
{
	removeElementInArray(movie_queue_photo_id_arr,photo_id);
	curr_movie_queue_photo_id = photo_id;
	var url = cfg_site_url+'photo/queueMoviePhoto.php';
	var pars = '?remove_it=true&photo_id='+photo_id;
	var path = url+pars;
	jquery_ajax(path, '', 'removePhotosMovieQueueAjax');

}
function removePhotosMovieQueueAjax(data)
{
$Jq('#movie_queue_'+curr_movie_queue_photo_id).show();
$Jq('#movie_queue_added_'+curr_movie_queue_photo_id).hide();
return false;
}
function createPhotoMovie(multiCheckValue, url, litle_window_title)
{
	url = url+'&photo_id='+multiCheckValue;
	javascript: myLightWindow.activateWindow( {type:'external',href:url,title:litle_window_title,width:500,height:420});
}
function updateBulkMovieQueueCount(photo_ids)
{
	var photo_ids=photo_ids.toString();
	var ids = '';
	if(photo_ids.indexOf(',') != -1)
	  {
	    photo_ids_arr=photo_ids.split(',');
	    for(var i=0;i<photo_ids_arr.length;i++)
		{
			if(!chkElementInArray(movie_queue_photo_id_arr,photo_ids_arr[i]))
			  {
			  ids += photo_ids_arr[i]+',';
			  movie_queue_photo_id_arr.push(photo_ids_arr[i]);
			  }

		}
		ids = ids.substring(0,ids.length-1);
	  }
	 else
	  {
	  	if(!chkElementInArray(movie_queue_photo_id_arr,photo_ids))
	 	    {
			 ids = photo_ids;
			 movie_queue_photo_id_arr.push(photo_ids);
			}
	  }
	if(ids)
	{
	curr_movie_queue_photo_id = ids;
	var url = cfg_site_url+'photo/queueMoviePhoto.php';
	var pars = '?photo_id='+ids;
	var path = url+pars;
	new jquery_ajax(path, '', 'updateMovieMakerResult');
	}

}
function chkElementInArray(arrayName,arrayElement)
 {
    for(var i=0; i<arrayName.length;i++ )
     {
        if(arrayName[i]==arrayElement)
          {
		  return true;
		  }
      }
    return false;
  }
// ---------------------  Movie Maker related Fuction end -------------------------------//

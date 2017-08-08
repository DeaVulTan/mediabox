//Slider related
//Video Handing Scripts

var disPrevButton = 'disabledPrevButton';
var disNextButton = 'disabledNextButton';

function setClassName(id, class_name)
	{
		if($(id))
			$(id).className=class_name;
	}

//Show Hide related
function showIndexTabs(id_to_fetch)
	{

	   	//$('name_block').value=id_to_fetch;
	   	$('nav_recentlyviewedvideo').style.display='none';
	   	$('nav_recommendedvideo').style.display='none';
	   	$('nav_newvideo').style.display='none';
	   	$('nav_topratedvideo').style.display='none';
	   	$('nav_'+id_to_fetch).style.display='block';

		var videoBaseIndex='selIndex_';
		var liBase='li_';
		var spBase='sp_';



		var liActiveClass='clsActiveIndexLink';
		var liFirstActiveClass='clsActiveFirstLink';
		var spActiveClass='clsActiveVideoLinkRight';

		var thisparent=$(videoBaseIndex+id_to_fetch).parentNode;
		//var someNodeList = thisparent.getElementsByTagName('li');

		//var nodes = $A(someNodeList);

		var nodes = $$('.videoBlockMenu li');
		nodes.each(function(node)
			{
				if($(node.id).hasClassName('clsFirstLink'))
					$(node.id).removeClassName(liFirstActiveClass);
				else
					setClassName(node.id,'');
			});


		var someNodeList = thisparent.getElementsByTagName('DIV');
		var nodes = $A(someNodeList);
		nodes.each(function(node)
			{
				if(node.id.substring(0,9)==videoBaseIndex)
					hide(node.id);
			});

		if($(liBase+id_to_fetch).hasClassName('clsFirstLink'))
			setClassName(liBase+id_to_fetch, 'clsFirstLink '+liFirstActiveClass);
		else
			setClassName(liBase+id_to_fetch, liActiveClass);
		//setClassName(spBase+id_to_fetch,'clsActiveVideoLinkRight');
		show(videoBaseIndex+id_to_fetch);


	}



	function recentViewedSlideShowRepeat()
		{
			var pars1='get_list=';
			/*var myAjax = new Ajax.Updater(
								'selRandomVideosList',
								homeUrlRecentlyViewed,
								{
									method: 'post',
									parameters: pars1,evalScripts:true
								});*/
			new Ajax.Request(homeUrlRecentlyViewed, {method:'post',parameters:pars1, onComplete:refreshVideosBlock});
			recentViewedSlideShow();
		}

	function recentViewedSlideShow()
		{
			//setTimeout('recentViewedSlideShowRepeat()', 9000);

		}

//CAROSEL JS START//
var populatedTabs = new Array();
var populatedData = new Array();
function showHideVideoTabs(div_id,tabs)
{
	if(tabs == 'audioCarosel')
	{
		div_class = 'clsActive';
		div_array = video_tabs_divid_array;
	}

	if($Jq('#'+div_id+'_Head').hasClass(div_class) )
	{
		return true;
	}

	for(inc=0;inc<div_array.length;inc++)
	{
		if(div_array[inc] == div_id)
			continue;
		$Jq('#'+div_array[inc]+'_Content').html(loader_image);
		$Jq('#'+div_array[inc]).hide();
		$Jq('#'+div_array[inc]+'_Head').removeClass(div_class);
		$Jq('#'+div_array[inc]+'_Content').hide();
	}
	$Jq('#'+div_id).show();
    $Jq('#'+div_id+'_Head').addClass(div_class);
    $Jq('#'+div_id+'_Content').show();
    alert($Jq('#sel'+div_id+'Process').html());
    $Jq('#sel'+div_id+'Process').html('loader_image');

    if(tabs == 'audioCarosel')
	{
		sel_carousel_div_content_name = div_id+'_Content';
		populateTabIndex = jQuery.inArray(sel_carousel_div_content_name, populatedTabs);
		if (populateTabIndex == -1)
		{
			new jquery_ajax(video_index_ajax_url, 'module=video&block='+div_id ,'displayVideoContent');
		}
		else
		{
			$Jq('#'+sel_carousel_div_content_name).html(populatedData[populateTabIndex]);
		}
	}


	return true;
}
function displayVideoContent(data)
{
	data = unescape(data);
	alert(sel_carousel_div_content_name);
	$Jq('#'+sel_carousel_div_content_name).html(data);
	populatedTabs[populatedTabs.length] = sel_carousel_div_content_name;
	populatedData[populatedData.length] = data;
}
/* VIDEO FUNCTIONS */
var toggle = new Array();
var playlistId;
var playlistTitle='';
var favoriteFlag='';
var section=Array();
section['flagDiv']=false;
section['playlistDiv']=false;
section['shareDiv']=false;
toggle['video_details']=true;

var currentBlockShow='';
// FUCNTION TO SLIDE THE DIV
function slideDiv(id)
{
	//todo: need to implement this
	//Effect.toggle(id, 'blind', {});
/*	if($Jq("#"+id).is(':visible'))
		alert('visible');
	else
		alert('not visible');*/

	 $Jq("#"+id).slideToggle("slow");

}

// FUCNTION TO SWITCH OVER THE DIV FOR FLAG CONTNET , PLAYLIST & SHARE DIV
function showVideoSection(id,className,close)
{

	hideOpenSection(id);

	loadChangeClass('.clsVideoFeaturesList', 'li','clsActiveVideoLink');

	//$Jq('#'+id).removeClass(className);

	slideDiv(id);

	if(!close && currentBlockShow!=id)
	{
		if(id=='playlistDiv')
		{
			$Jq('#videoPlaylistLi').addClass('clsActiveVideoLink');
			$Jq('#videoPlaylistLi').unbind('mouseout', '');
			$Jq('#selMsgAddNewBlog').css('display', 'none');
			$Jq('#flagDiv').css('display', 'none');
			$Jq('#shareDiv').css('display', 'none');
		}
		else if(id=='flagDiv')
		{
			$Jq('#videoFlagLi').addClass('clsActiveVideoLink');
			$Jq('#videoFlagLi').unbind('mouseout', '');
			$Jq('#playlistDiv').css('display', 'none');
			$Jq('#selMsgAddNewBlog').css('display', 'none');
			$Jq('#shareDiv').css('display', 'none');
		}
		else if(id=='shareDiv')
		{
			$Jq('#slideVideoLi').addClass('clsActiveVideoLink');
			$Jq('#slideVideoLi').unbind('mouseout', '');
			$Jq('#selMsgAddNewBlog').css('display', 'none');
			$Jq('#flagDiv').css('display', 'none');
			$Jq('#playlistDiv').css('display', 'none');
		}
		else if(id=='blogDiv' || id=='selMsgAddNewBlog')
		{
			$Jq('#selAddBlogLink').addClass('clsActiveVideoLink');
			$Jq('#selAddBlogLink').unbind('mouseout', '');
			$Jq('#flagDiv').css('display', 'none');
			$Jq('#playlistDiv').css('display', 'none');
			$Jq('#shareDiv').css('display', 'none');
		}
	}
	if(currentBlockShow==id)
	{
		$Jq('#'+id).removeClass('clsActiveVideoLink');
		currentBlockShow='';
	}
	else if(!close)
	{
		currentBlockShow=id;
	}
	section[id]=true;
}

function hideOpenSection(id)
{


	$Jq('#videoPlaylistLi').removeClass('clsActiveVideoLink');
	$Jq('#videoFlagLi').removeClass('clsActiveVideoLink');
	$Jq('#slideVideoLi').removeClass('clsActiveVideoLink');
	$Jq('#favorite').removeClass('clsActiveVideoLink');
	if($Jq('#unfavorite').length)
	{
		$Jq('#unfavorite').removeClass('clsActiveVideoLink');
	}
	$Jq('#featured').removeClass('clsActiveVideoLink');
	if($Jq('#unfeatured'))
	{
		$Jq('#unfeatured').removeClass('clsActiveVideoLink');
	}
	$Jq('#selAddBlogLink').removeClass('clsActiveVideoLink');
	if(currentBlockShow)
		{
		    //slideDiv(currentBlockShow);
			$Jq('#'+currentBlockShow).removeClass('clsActiveVideoLink');
		}
	if($Jq('#clsMsgDisplay_playlist').length)
		$Jq('#clsMsgDisplay_playlist').addClass('clsDisplayNone');
	if($Jq('#clsMsgDisplay').length)
	$Jq('#clsMsgDisplay').addClass('clsDisplayNone');

	if(id=='playlistDiv')
	{
		$Jq('#clsMsgDisplay_playlist').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist').html('');
		$Jq('#playlistFrmDiv').removeClass('clsDisplayNone');
	}
	else if(id=='flagDiv')
	{
		$Jq('#clsMsgDisplay_flag').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').html('');
		$Jq('#flagFrm').removeClass('clsDisplayNone');
	}
	else if(id=='selMsgAddNewBlog')
	{
		$Jq('#selAddNewBlogContent').css('display', '');
		$Jq('#selAddNewBlogSuccess').css('display', 'none');
		$Jq('#formMsgAddNewBlog').removeClass('clsDisplayNone');
	}
}

function hideVideoSection(id,className)
{


$Jq('#videoPlaylistLi').removeClass('clsActiveVideoLink');
$Jq('#videoFlagLi').removeClass('clsActiveVideoLink');
$Jq('#slideVideoLi').removeClass('clsActiveVideoLink');
$Jq('#favorite').removeClass('clsActiveVideoLink');
if($Jq('#unfavorite').length)
{
	$Jq('#unfavorite').removeClass('clsActiveVideoLink');
}
$Jq('#featured').removeClass('clsActiveVideoLink');
if($Jq('#unfeatured').length)
{
	$Jq('#unfeatured').removeClass('clsActiveVideoLink');
}
$Jq('#selAddBlogLink').removeClass('clsActiveVideoLink');


if(id=='playlistDiv')
{
	$Jq('#clsMsgDisplay_playlist').addClass('clsDisplayNone');
	$Jq('#clsMsgDisplay_playlist').html('');
	$Jq('#playlistFrmDiv').removeClass('clsDisplayNone');
}
else if(id=='flagDiv')
{
	$Jq('#clsMsgDisplay_flag').addClass('clsDisplayNone');
	$Jq('#clsMsgDisplay_flag').html('');
	$Jq('#flagFrm').removeClass('clsDisplayNone');
}
else if(id=='selMsgAddNewBlog')
{
	$Jq('#selAddNewBlogContent').css('display', '');
	$Jq('#selAddNewBlogSuccess').css('display', 'none');
	$Jq('#formMsgAddNewBlog').removeClass('clsDisplayNone');
}
showVideoSection(id,'clsDisplayNone','true');
currentBlockShow='';
}
/* To check the Selection is th existing playlist Or to create new One. If the value of the selection is '#new#' then Playlist Creation form will be displayed */

function chkPlaylist(obj)
{

	if($Jq('#'+obj).val()=="#new#")
	{
		$Jq('#createNewPlaylist').show();
		/*playObj=$$('.createPlaylistSec');
		playObj.each(function(play)
		{
			play.removeClass('clsCreatePlaylist');
		});*/

	}
	else
	{
		$Jq('#createNewPlaylist').hide();
		/*playObj=$$('.createPlaylistSec');
		playObj.each(function(play)
		{
			play.addClass('clsCreatePlaylist');
		});*/
	}
}

// AJAX FUNCTION TO SEND THE PLAYSIT DETAILS BOTH CREATION AND SELECTION

function createPlayList(url){
	$Jq('#clsMsgDisplay_playlist').addClass('clsDisplayNone');
	playlist=$Jq('#playlist').val();
	var pars='';
	if(playlist=="#new#"){
		title = $Jq('#playlistTitle').val();
		var encode_title =encodeURIComponent($Jq('#playlistTitle').val());
		var desc = encodeURIComponent($Jq('#playlistDesc').val());
		var tags = encodeURIComponent($Jq('#playlistTags').val());
		var access =$Jq('#.playlistAccess');
		var accessValue=$Jq('#playlist_access_type').val();
		if(title=='' || tags=='' ){
			$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
			$Jq('#clsMsgDisplay_playlist_failure').html(invalidPlaylist);
			return false;
		}
		else{
			$Jq('#clsMsgDisplay_playlist_failure').addClass('clsDisplayNone');
			$Jq('#clsMsgDisplay_playlist_failure').html('');
		}
		playlistTitle=title;
		pars='playlist_name='+encode_title+'&playlist_description='+desc+'&playlist_tags='+tags+'&playlist_access_type='+accessValue+'&video_id='+video_id;
	}
	if(playlist!="#new#" && playlist){
		pars='playlist='+playlist+'&video_id='+video_id;
		playlistId=playlist;
	}
	if(pars){
		$Jq('#clsMsgDisplay_playlist_success').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_success').html(loading);
		return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', url, pars, 'createPlayListResponse');
	}
	else{
		$Jq('#clsMsgDisplay_playlist_failure').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist_failure').html(selectionError);
	}
}
function createPlayListResponse(data){
	playlistId='';
	if(data.indexOf('#$#')>=1){
		var dataTemp=data.split('#$#');
		data = dataTemp[0];
		playlistId=dataTemp[1];
	}
	if(playlistId){
		hideAllBlocks();
		document.playlistfrm.reset();
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

// FUCNTION TO DISPLAY THE PLAYLIST & FLAG CONTENT AJAX OUTPUT.
function ajaxResultPlaylist(data)
{

	/*data = unescape(data.responseText);

	if(data.indexOf(session_check)>=1)
	{
		data = data.replace(session_check_replace,'');
	}
	else
	{
		return;
	}*/

	playlistId='';
	if(data.indexOf('#$#')>=1)
	{
		var dataTemp=data.split('#$#');
		data = dataTemp[0];
		playlistId=dataTemp[1];

	}
	if(playlistTitle && playlistId)
	{
		if($Jq.browser.msie){
	    var optn = document.createElement("OPTION");
	    var el= $Jq('#playlist');

    	optn.text = playlistTitle;
	    optn.value =playlistId;
    	el.options.add(optn);
		}
		else
		{
			//$Jq('#playlist').insert('<option value="'+playlistId+'">'+playlistTitle+'</option>');
			$Jq('#playlist').val(playlistId);

		}
	playObj=$Jq('#.createPlaylistSec');
	playObj.each(function(play)
	{
		play.addClass('clsCreatePlaylist');
	});

	document.playlistfrm.reset();
	}


	if(section['flagDiv']==true)
	{
		document.flagfrm.reset();

		//$('flagFrm').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').html(data);
	}
	if(section['playlistDiv']==true)
	{
		if(playlistId)
		{
			$Jq('#playlistFrmDiv').addClass('clsDisplayNone');
		}
		else
		{
			$Jq('#clsMsgDisplay').addClass('clsDisplayNone');
			$Jq('#clsMsgDisplay').html(invalidPlaylist);
		}
		$Jq('#clsMsgDisplay_playlist').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_playlist').html(data);

	}
}
// AJAX FUNCTION TO CALL SHARE VIDEO
function showShareDiv(url){
	import_contacts_link = true;
	pars='';
	jquery_ajax(url, pars, 'ajaxResultShare');
}

// FUCNTION TO DISPLAY SHARE VIDEO AJAX OUTPUT
function ajaxResultShare(data){
	$Jq('#shareDiv').html(data);
	import_contacts_link = true;
	Confirmation('shareDiv', 'formEmailList', Array(), Array(), Array());
	//showVideoSection('shareDiv','clsDisplayNone');
}

// AJAX FUCNTION TO STORE FLAG CONTENT
function addFlagContent(url){
	var flag=$Jq('#flag').val();
	var comment=encodeURIComponent($Jq('#flag_comment').val());
	if(comment){
		$Jq('#clsMsgDisplayFlagDiv').addClass('clsDisplayNone');
		$Jq('#clsMsgDisplayFlagDiv').html('');
		$Jq('#clsMsgDisplay_flag').removeClass('clsDisplayNone');
		$Jq('#clsMsgDisplay_flag').html(loading);
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

function favorite()
{
	hideOpenSection();
	currentBlockShow = '';

	var pars ='favorite='+favorite_added+'&video_id='+video_id;
	jquery_ajax(favoriteUrl, pars, 'ajaxResultfavorite');
	/*new Ajax.Request(favoriteUrl,{method: 'post',
	  parameters: pars,
	  onComplete: ajaxResultfavorite
			});*/
	favorite_added='';
	$Jq('#unfavorite').addClass('clsActiveVideoLink');
	$Jq('#unfavorite').unbind('mouseout', '');
	$Jq('#favorite').css('display','none');
	$Jq('#unfavorite').css('display','inline');
	$Jq('#unfavorite').unbind('click');
	$Jq('#unfavorite').bind('click', unfavorite);
	return false;
}
function unfavorite()
{
	hideOpenSection();
	currentBlockShow = '';
	var pars='favorite=&video_id='+video_id;
	jquery_ajax(favoriteUrl, pars, 'ajaxResultfavorite');
	/*new Ajax.Request(favoriteUrl,{method: 'post',
	  parameters: pars,
	  onComplete: ajaxResultfavorite
			});*/
	favorite_added='1';
	$Jq('#favorite').addClass('clsActiveVideoLink');
	$Jq('#favorite').unbind('mouseout', '');
	$Jq('#unfavorite').css('display','none');
	$Jq('#favorite').css('display','inline');
	$Jq('#favorite').unbind('click');
	$Jq('#favorite').bind('click', favorite);
	return false;

}
function featured()
{
	hideOpenSection();
	currentBlockShow = '';

	if(featuredAlready)
	{
		if(!window.confirm(featuredDeleteConfirmation))
		{
			return false;
		}
	}
	var pars ='featured='+featured_added+'&video_id='+video_id;
	jquery_ajax(featuredUrl, pars, 'ajaxResultfavorite');
	/*new Ajax.Request(featuredUrl,{method: 'post',
	  parameters: pars,
	  onComplete: ajaxResultfavorite
			});*/
	featured_added='';
	$Jq('#unfeatured').addClass('clsActiveVideoLink');
	$Jq('#unfeatured').unbind('mouseout', '');
	$Jq('#featured').css('display','none');
	$Jq('#unfeatured').css('display','inline');
	$Jq('#unfeatured').unbind('click');
	$Jq('#unfeatured').bind('click', unfeatured);
	return false;
}

function unfeatured()
{
	hideOpenSection();
	currentBlockShow = '';

	var pars='featured=&video_id='+video_id;
	jquery_ajax(featuredUrl, pars, 'ajaxResultfavorite');
	/*new Ajax.Request(featuredUrl,{method: 'post',
	  parameters: pars,
	  onComplete: ajaxResultfavorite
			});*/
	featured_added='1';
	$Jq('#featured').addClass('clsActiveVideoLink');
	$Jq('#featured').unbind('mouseout', '');
	$Jq('#unfeatured').css('display','none');
	$Jq('#featured').css('display','inline');
	$Jq('#featured').unbind('click');
	$Jq('#featured').bind('click', featured);
	return false;
}
function ajaxResultfavorite(data)
{
	/*data = unescape(data.responseText);

	if(data.indexOf(session_check)>=1)
	{
		data = data.replace(session_check_replace,'');
	}
	else
	{
		return;
	}*/
	$Jq('#clsMsgDisplay').removeClass('clsDisplayNone');
	$Jq('#clsMsgDisplay').html(data);

}

/**
 *
 * @access public
 * @return void
 **/
/**
 *
 * @access public
 * @return void
 **/
function closeDownload(){
	$Jq('#downloadFormat').css('display','none');
	hideAllBlocks();
}

/**
 *
 * @access public
 * @return void
 **/
function getRelatedVideo(related){
var pars='type='+related+'&video_id='+video_id+'&ajax_page=true&relatedVideo=true';

	$Jq('#relatedVideoContent').html('');
	$Jq('#loaderVideos').removeClass('clsDisplayNone');
	$Jq.ajax({
			type: "GET",
			url: relatedUrl,
			data: pars,
			//beforeSend:displayLoadingImage(),
			success: ajaxRelatedResult
		 });
	/*new Ajax.Request(relatedUrl,{method: 'get',
	  parameters: pars,
	  onComplete: ajaxRelatedResult
	});*/
	$Jq('#selHeaderVideoUser').removeClass('clsActiveMoreVideos');
	$Jq('#selHeaderVideoRel').removeClass('clsActiveMoreVideos');
	$Jq('#selHeaderVideoTop').removeClass('clsActiveMoreVideos');
	loadChangeClass('.clsMoreVideosNav li','clsActiveMoreVideos');

	if(related=='user')
	{
		$Jq('#selHeaderVideoUser').addClass('clsActiveMoreVideos');
		$Jq('#selHeaderVideoUser').unbind('mouseout', '');

	}
	if(related=='tag')
	{
		$Jq('#selHeaderVideoRel').addClass('clsActiveMoreVideos');
		$Jq('#selHeaderVideoRel').unbind('mouseout', '');
	}
	if(related=='top')
	{
		$Jq('#selHeaderVideoTop').addClass('clsActiveMoreVideos');
		$Jq('#selHeaderVideoTop').unbind('mouseout', '');
	}
}

/**
 *
 * @access public
 * @return void
 **/
function ajaxRelatedResult(data){

$Jq('#loaderVideos').addClass('clsDisplayNone');
/*data = unescape(data.responseText);
	if(data.indexOf(session_check)>=1)
	{
		data = data.replace(session_check_replace,'');
	}
	else
	{
		return;
	}*/
	$Jq('#relatedVideoContent').html(data);
	$Jq('#selNextPrev_top').html($Jq('#selNextPrev').html());
	$Jq('#relatedVideoContent').jScrollPane({showArrows:true,scrollbarWidth:10, scrollbarMargin:10});
	//to do need to check the functionality and implement
	//listen_balloon_using_container('#relatedVideoContent a');
}
var img_src = new Array();
function ratingMouseOver(count)
	{
		for(var i=1; i<=count; i++)
			{
				var obj = document.getElementById('img'+i);
				img_src[i] = obj.src;
				obj.src = site_url+'video/design/templates/'+template_default+'/root/images/'+stylesheet_default+'/icon-viewvideoratehover.gif';
			}
		for(; i<=total_images; i++)
			{
				var obj = document.getElementById('img'+i);
				img_src[i] = obj.src;
				obj.src = site_url+'video/design/templates/'+template_default+'/root/images/'+stylesheet_default+'/icon-viewvideorate.gif';
			}
	}

function ratingMouseOut(count)
	{
		for(var i=1; i<=total_images; i++)
			{
				var obj = document.getElementById('img'+i);
				obj.src = img_src[i];
			}
	}
function removeMiniPlayer()
{
	$Jq('#slideShowBlock_user').html('');
}
function deleteVideoMultiCheck(check_atleast_one,anchor,delete_confirmation, formname, id, act)
	{
		if(getMultiCheckBoxValue(formname, 'check_all', check_atleast_one, anchor, -100, -500))
			{
				Confirmation('selMsgConfirmMulti', 'msgConfirmformMulti', Array(id, 'act', 'msgConfirmTextMulti'),
				Array(multiCheckValue, act, delete_confirmation), Array('value', 'value', 'innerHTML'), 0, 0);
			}
	}

var videoDetailBlock='';
var seq='';
var show_thumb = false;
var info_class = '';

function getBlockAndId(element)
	{
		videoDetailBlock	= element.id.substring(0,element.id.indexOf('_'));
		seq		 	= element.id.substring(element.id.lastIndexOf('_')+1,element.id.length);
		currentDisplayVideo=seq;
	}

function showInfo(element)
	{
		getBlockAndId(element);
		var info_id	 = videoDetailBlock+'_info_'+seq;
		$Jq('#'+info_id).removeClass('clsDisplayNone');
	}

function hideInfo(element)
	{
		getBlockAndId(element);
		var info_id	 = videoDetailBlock+'_info_'+seq;
		$Jq('#'+info_id).addClass(info_class);
		$Jq('#'+info_id).addClass('clsDisplayNone');
	}

function showVideoDetail(element)
	{
		if(show_thumb)
			{
				//$(element).hide();
				//hideInfo(element);
				getBlockAndId(element);
				var video_thumb_image	 = '#'+videoDetailBlock+'_video_thumb_image_'+seq;
				var thumb_image_container = '#'+videoDetailBlock+'_thumb_image_container_'+seq;
				var thumb_title_container = videoDetailBlock+'_video_title_'+seq;
				$Jq(thumb_image_container).stop().animate({top:'-130px'},{queue:false,duration:400});
				$Jq(thumb_title_container).addClass('clsThumbImageTitleActive');
			}
	}

function hideVideoDetail(element)
	{
		getBlockAndId(element);
		var video_thumb_image	 = '#'+videoDetailBlock+'_video_thumb_image_'+seq;
		var thumb_image_container = '#'+videoDetailBlock+'_thumb_image_container_'+seq;
		var thumb_title_container = videoDetailBlock+'_video_title_'+seq;
		$Jq(thumb_image_container).stop().animate({top:'0px'},{queue:false,duration:400});
		$Jq('#'+thumb_title_container).removeClass('clsThumbImageTitleActive');
		hideInfo(element);
	}
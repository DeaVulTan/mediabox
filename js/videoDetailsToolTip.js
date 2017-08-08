/**
 	Need to define the following vars whenever this page is used and assign the config var from CFG (config_styles or config_VAR_MODULE_styles)
		-> var popup_info_left_position
		-> var popup_info_top_position
*/
var videoThumb= $Jq('.clsThumbImageContainer img');
var currentDisplayVideo;
var detailBlock='';
var seq='';

function getBlockAndId(element){
	detailBlock	= element.id.substring(0,element.id.indexOf('_'));
	seq		 	= element.id.substring(element.id.lastIndexOf('_')+1,element.id.length);
	currentDisplayVideo=seq;
};

function removeLiClass(){
	var lielements  = $Jq('li.clsPopUpDiv');
//debugger;
	lielements.each(function(eli){
		$Jq(this).removeClass('clsPopUpDiv');
	});
};

function showInfo(element){
	removeLiClass();
	if(currentDisplayVideo && detailBlock) {

		var video_detail_id	 = detailBlock+'_selVideoDetails_'+currentDisplayVideo;
		$Jq("#"+video_detail_id).addClass('clsDisplayNone');

		container_detail_id	 = detailBlock+'_clsInfoPopUpContainerDiv_'+currentDisplayVideo;
		if($Jq("#"+container_detail_id)) {
			$Jq("#"+container_detail_id).addClass('clsDisplayNone');
		}
		info_id	 = detailBlock+'_info_'+currentDisplayVideo;
		$Jq("#"+info_id).addClass('clsDisplayNone');
		var videoli_id	 = detailBlock+'_videoli_'+currentDisplayVideo;
		$Jq("#"+videoli_id).removeClass('clsPopUpDiv');
	}
	getBlockAndId(element);
	var info_id	 = detailBlock+'_info_'+seq;

	var videoli_id	 = detailBlock+'_videoli_'+seq;
	$Jq("#"+videoli_id).addClass('clsPopUpDiv');
	$Jq("#"+info_id).removeClass('clsDisplayNone');
};

function showVideoDetail(element) {
	getBlockAndId(element);
	var video_detail_id	 = detailBlock+'_selVideoDetails_'+seq;
	$Jq("#"+video_detail_id).removeClass('clsDisplayNone');
	container_detail_id	 = detailBlock+'_clsInfoPopUpContainerDiv_'+seq;
	$Jq("#"+container_detail_id).removeClass('clsDisplayNone');
};

function hideVideoDetail(element) {
	getBlockAndId(element);
	currentDisplayVideo='';

	hideInfo(element);

	var videoli_id	 = detailBlock+'_videoli_'+seq;
	$Jq("#"+videoli_id).removeClass('clsPopUpDiv');

	var video_detail_id	 = detailBlock+'_selVideoDetails_'+seq;
	$Jq("#"+video_detail_id).addClass('clsDisplayNone');

	var container_detail_id	 = detailBlock+'_clsInfoPopUpContainerDiv_'+seq;
	$Jq("#"+container_detail_id).addClass('clsDisplayNone');
};

/**
 *
 * @access public
 * @return void
 **/
function hideInfo(element) {
	getBlockAndId(element);
	currentDisplayVideo = '';

	var info_id	 = detailBlock+'_info_'+seq;
	$Jq("#"+info_id).addClass('clsDisplayNone');
};

function showVideoDetail_home(element){
	getBlockAndId(element);
	var video_detail_id	 = detailBlock+'_selVideoDetails_'+seq;
	var displaySecId=detailBlock+'_DisplaySec';
	var sourceId= detailBlock+'_videoli_'+seq;
	$Jq("#"+displaySecId).removeClass('clsDisplayNone');
	var returnOffset = findPos($Jq("#"+sourceId));
	var left = returnOffset[0]+parseInt(popup_info_left_position);
	var top = returnOffset[1]+parseInt(popup_info_top_position);
	$Jq("#"+displaySecId).html($Jq("#"+video_detail_id).html());
	$Jq("#"+displaySecId).setStyle({width:'317px',height:'185px',margin:'-7px 0px 0px -7px',left:left+'px',top:top+'px'});
	var outerContainerDivId='outerContainerDiv_'+detailBlock;
	$Jq("#"+outerContainerDivId).removeClass('clsDisplayNone');
	$Jq("#"+outerContainerDivId).setStyle({margin:'-20px 0px 25px -20px',width:'340px',height:'220px',left:left+'px',top:top+'px'});
};

function hideVideoDetail_home(element){
	getBlockAndId(element);
	var video_detail_id	 = detailBlock+'_selVideoDetails_'+seq;
	var displaySecId=detailBlock+'_DisplaySec';
	var sourceId= detailBlock+'_videoli_'+seq;
	$Jq("#"+displaySecId).addClass('clsDisplayNone');
	$Jq("#"+displaySecId).html('');
	var outerContainerDivId='outerContainerDiv_'+detailBlock;
	$Jq("#"+outerContainerDivId).addClass('clsDisplayNone');
	currentDisplayVideo='';
	hideInfo(element);
};

function hideCurrentToolTip(){
	element=$Jq("#"+detailBlock+'_selVideoDetails_'+currentDisplayVideo);
	hideVideoDetail_home(element);
};

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curleft,curtop];
};
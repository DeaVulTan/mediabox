var musicThumb= $$('.clsThumbImageContainer img');
var currentDisplayMusic;
var musicmusicdetailBlock='';
var seq='';
/**
 *
 * @access public
 * @return void
 **/
function getMusicBlockAndId(element){
musicdetailBlock	= element.id.substring(0,element.id.indexOf('_'));
seq		 	= element.id.substring(element.id.lastIndexOf('_')+1,element.id.length);
currentDisplayMusic=seq;
}
/**
 *
 * @access public
 * @return void
 **/
function removeMusicLiClass(){
	var li=$$('.clsPopUpDiv');

	li.each(function(li){
	li.removeClassName('clsPopUpDiv');
	});
}
function showMusicInfo(element)
{

	removeMusicLiClass();
	if(currentDisplayMusic && musicmusicdetailBlock)
	{

		var music_detail_id	 = musicdetailBlock+'_selMusicDetails_'+currentDisplayMusic;
		$(music_detail_id).addClassName('clsMusicDisplayNone');

		container_detail_id	 = musicdetailBlock+'_clsInfoPopUpContainerDiv_'+currentDisplayMusic;
		if($(container_detail_id))
		{
			$(container_detail_id).addClassName('clsMusicDisplayNone');
		}
		info_id	 = musicdetailBlock+'_info_'+currentDisplayMusic;
		$(info_id).addClassName('clsMusicDisplayNone');
		var musicli_id	 = musicdetailBlock+'_musicli_'+currentDisplayMusic;
		$(musicli_id).removeClassName('clsPopUpDiv');
	}
	getMusicBlockAndId(element);
	var info_id	 = musicdetailBlock+'_info_'+seq;

	var musicli_id	 = musicdetailBlock+'_musicli_'+seq;
	$(musicli_id).addClassName('clsPopUpDiv');
	$(info_id).removeClassName('clsMusicDisplayNone');
}

function showMusicDetail(element)
{
	getMusicBlockAndId(element);
	var music_detail_id	 = musicdetailBlock+'_selMusicDetails_'+seq;
	$(music_detail_id).removeClassName('clsMusicDisplayNone');
	container_detail_id	 = musicdetailBlock+'_clsInfoPopUpContainerDiv_'+seq;
	$(container_detail_id).removeClassName('clsMusicDisplayNone');

}

function hideMusicDetail(element)
{
	getMusicBlockAndId(element);
	currentDisplayMusic='';

	hideMusicInfo(element);

	var musicli_id	 = musicdetailBlock+'_musicli_'+seq;
	$(musicli_id).removeClassName('clsPopUpDiv');

	var music_detail_id	 = musicdetailBlock+'_selMusicDetails_'+seq;
	$(music_detail_id).addClassName('clsMusicDisplayNone');

	var container_detail_id	 = musicdetailBlock+'_clsInfoPopUpContainerDiv_'+seq;
	$(container_detail_id).addClassName('clsMusicDisplayNone');

}

/**
 *
 * @access public
 * @return void
 **/
function hideMusicInfo(element)
{
	getMusicBlockAndId(element);
	currentDisplayMusic='';

	var info_id	 = musicdetailBlock+'_info_'+seq;
	$(info_id).addClassName('clsMusicDisplayNone');
}

function showMusicDetail_home(element){


	getMusicBlockAndId(element);
	var music_detail_id	 = musicdetailBlock+'_selMusicDetails_'+seq;
	var displaySecId=musicdetailBlock+'_DisplaySec';
	var sourceId= musicdetailBlock+'_musicli_'+seq;
	$(displaySecId).removeClassName('clsMusicDisplayNone');
	var returnOffset = findMusicPos($(sourceId));
	var left = returnOffset[0];
	var top = returnOffset[1];
	$(displaySecId).innerHTML=$(music_detail_id).innerHTML
	$(displaySecId).setStyle({width:'317px',height:'169px',margin:'-7px 0px 0px -7px',left:left+'px',top:top+'px'});
	var outerContainerDivId='outerContainerDiv_'+musicdetailBlock;
	$(outerContainerDivId).removeClassName('clsMusicDisplayNone');
	$(outerContainerDivId).setStyle({margin:'-20px 0px 25px -20px',width:'340px',height:'220px',left:left+'px',top:top+'px'});
}

function hideMusicDetail_home(element){

	getMusicBlockAndId(element);
	var music_detail_id	 = musicdetailBlock+'_selMusicDetails_'+seq;
	var displaySecId=musicdetailBlock+'_DisplaySec';
	var sourceId= musicdetailBlock+'_musicli_'+seq;
	$(displaySecId).addClassName('clsMusicDisplayNone');
	$(displaySecId).innerHTML='';
	var outerContainerDivId='outerContainerDiv_'+musicdetailBlock;
	$(outerContainerDivId).addClassName('clsMusicDisplayNone');
currentDisplayMusic='';
hideMusicInfo(element);
}
/**
 *
 * @access public
 * @return void
 **/
function hideCurrentMusicToolTip(){

	element=$(musicdetailBlock+'_selMusicDetails_'+currentDisplayMusic);
	hideMusicDetail_home(element);
}

function findMusicPos(obj) {
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
}




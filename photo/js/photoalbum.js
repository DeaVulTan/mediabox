
var msgTimeout=5000;
$Jq(document).ready(function(){
	if(serverVars.adminMode){
		MakeListEditable();
	}
});

function MakeListEditable(){
	var list=$Jq("#ulThumbnailList");
	list.sortable({opacity:0.7,revert:true,scroll:true,handle:$Jq(".imagecontainer")});
	$Jq(".photolistitem").hover(
		function(e)
		{
			$Jq(this).find(".deletethumbnail").show().bind("click",DeletePhotoFromSlidelist);
		},
		function(e){
			$Jq(this).find(".deletethumbnail").hide().unbind("click",DeletePhotoFromSlidelist);
		}
	);
}

/* --- commented this to show the alert in framework model instead of javascript --- */
/*
function DeletePhotoFromSlidelist(e)
{
alert(this);
var jItem=$Jq(this).parent();
var photo_id=this.id;
photo_id=photo_id.replace('del_','');
if(!confirm("Are you sure you want to delete"))
return;
var path_url=photo_site_url+'members/organizeSlidelist.php?photo_slidelist_id='+photo_slidelist_id;
new Ajax.Request(path_url, {method:'post',parameters:'&photo_id='+photo_id+'&ajax_page=1', onComplete:DeleteFromSlidelistAjax});
jItem.remove();
}
*/

function DeletePhotoFromSlidelist(e){
	var photo_id= this.id;
	photo_id=photo_id.replace('del_','');
	Confirmation('selOrganizeSlideMsgConfirm','organizeSlideMsgConfirmform',Array('organizeSlideMsgConfirmText', 'photo_id'),Array('Are you sure you want to remove the photo from slidelist', photo_id),Array('innerHTML', 'value'));
	$Jq('#selOrganizeSlideMsgConfirm').css('display', 'block');
	return false;
}

//function called on clicking yes to remove the image from the slide list
function removeImageFromSlidelist(){
	var jItem_id = $Jq('#photo_id').val();
	var obj_li = document.getElementById(jItem_id);
	var jItem=$Jq(obj_li);
	var photo_id = $Jq('#photo_id').val();
	var path_url=photo_site_url+'organizeSlidelist.php?photo_slidelist_id='+photo_slidelist_id;
	var pars = '&photo_id='+photo_id+'&ajax_page=1';
	new jquery_ajax(path_url, pars, 'DeleteFromSlidelistAjax');
	$Jq(obj_li).remove();
	hideAllBlocks();
	$Jq('#selOrganizeSlideMsgConfirm').css('display', 'none');
}



function hideConfirmDeleteSlideBlock(){
	hideAllBlocks();
	//$('quick_slide_clear_act').value='';
	$Jq('#selOrganizeSlideMsgConfirm').css('display', 'none');
}

/**
 *
 * @access public
 * @return void
 **/
function DeleteFromSlidelistAjax(resp){
	return;
}
var progressActive=false;

function ShowImagePopup(hashCode)
{var jImageDisplay=$Jq("#imgImage");jImageDisplay.stop().hide();var jImageContainer=$Jq("#ImageContainer");var jNotes=$Jq("#"+hashCode+"Notes");var jMsg=$Jq("#lblImageMessage");var jProgress=$Jq("#imgProgress");jImageContainer.css("opacity",0.01);progressActive=true;setTimeout(function(){if(progressActive)
jProgress.attr("src",jProgress.attr("src")).css("zIndex",400).show().centerInClient();},200);jImageContainer.modalDialog({backgroundOpacity:.65,overlayId:"OpaqueOverlay",zIndex:100});$Jq("#OpaqueOverlay").click(ClearImagePopup);var jImg=$Jq("#"+hashCode+"Img");var imgUrl=jImg.attr("src").replace("tb_","");jImageDisplay.attr("src",imgUrl);jMsg.text(jNotes.text());jImageDisplay.css({width:"auto",height:"auto"});jImageDisplay.bind("load",function(){$Jq(this).unbind("load");progressActive=false;jProgress.hide();var ctl=$Jq("#ImageContainer");ctl.show();jImageDisplay.show();var ht=this.height;var wd=this.width;var wht=$Jq(window).height()-120;if(ht>wht){jImageDisplay.css("height",wht);var newwd=(wht/ht*wd);jImageDisplay.width(newwd);jMsg.width(newwd-20);}
else
jMsg.width(wd-20);if($Jq.browser.msie)
$Jq("#OverlayImageHeader").width(this.width+8);ctl.centerInClient();jImageContainer.css("opacity",1).hide().fadeIn("slow");});}


function pageError(xhr,status)
{var msg=xhr.responseText;if(status=="timeout")
msg="Request timed out."
showStatus(msg,5000,true);}

function httpJson(method,data,success,error)
{var json=JSON.stringify(data);$Jq.ajax({url:+"pagename.php?Callback="+method+"&Admin=true;",data:json,type:"POST",contentType:"application/json",timeout:10000,success:success,error:error});}

function textFromHtml(html,fixCR)
{if(fixCR)
html=html.replace(/<br.*?>/g,"#CR#");html=$Jq("<div>"+html+"</div>").text();if(fixCR)
html=html.replace(/#CR#/g,"\r\n");return html;}

function htmlFromText(text,fixCR)
{return text.replace(/[\n]/ig,"<br/>");}

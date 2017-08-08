var ajaxWindowLink;

var getLangConfirmation = function(){
	anchorLink = arguments[0];
	newlg = arguments[1];
	act = arguments[2];
	confirmLangDeleteMsg = arguments[3];
	Confirmation('selMsgConfirm', 'formConfirm', Array('selMsgContent', 'newlg', 'confirm_act'), Array(confirmLangDeleteMsg, newlg, act), Array('innerHTML', 'value', 'value'));
	return false;
};
function startTranslate(newlg, count){
	var col_id = 'step_'+count;
	var action_id = 'action_'+count;
	var loadingContent='<p><img src="'+cfg_site_url + 'design/templates/'+cfg_html_template_default+'/root/images/'+cfg_html_stylesheet_screen_default+'/loader.gif" align="center" />&nbsp;Processing</p>';

	$Jq.ajax({
		type: "GET",
		url: reqResUrl,
		data: "newlg="+newlg+"&step=" + count,
		beforeSend: function(){
			$Jq('#selButtonRow').hide();
			$Jq('#selWaitMsg').show();
			$Jq('#'+col_id).html(loadingContent);
			$Jq('#'+col_id).addClass('clsNotTranslated');
		},
		success: function(originalRequest){
			$Jq('#'+col_id).html(completed);
			$Jq('#'+col_id).addClass("clsTranslateComplete");
			count++;
			if(count<total_folders_to_translate){
				startTranslate(newlg, count);
			}
			else{
				window.location.href = reqResUrl+'?msg=1';
			}
		}
 	});
	return false;
};
function startTranslateAll(newlg, count){
	var col_id = 'step_'+count;
	var action_id = 'action_'+count;
	var loadingContent='<p><img src="'+cfg_site_url + 'design/templates/'+cfg_html_template_default+'/root/images/'+cfg_html_stylesheet_screen_default+'/loader.gif" align="center" />&nbsp;Processing</p>';

	$Jq.ajax({
		type: "GET",
		url: reqResUrl,
		data: "newlg="+newlg+"&step=" + count,
		beforeSend: function(){
			$Jq('#selButtonRow').hide();
			$Jq('#selWaitMsg').show();
			$Jq('#'+col_id).html(loadingContent);
			$Jq('#'+action_id).html(processing);
		},
		success: function(originalRequest){
			$Jq('#'+col_id).html(completed);
			$Jq('#'+col_id).addClass("clsTranslateComplete");
			$Jq('#'+action_id).html(translated);
			$Jq('#'+action_id).addClass("clsTranslateComplete");
			count++;
			$Jq('#selButtonRow').show();
		}
 	});
	return false;
};
function startTranslateSingle(newlg, count, file, msg_block){
	var loadingContent='<p><img src="'+cfg_site_url + 'design/templates/'+cfg_html_template_default+'/root/images/'+cfg_html_stylesheet_screen_default+'/loader.gif" align="center" />&nbsp;Processing</p>';

	$Jq.ajax({
		type: "GET",
		url: reqResUrl,
		data: "newlg="+newlg+"&step=" + count +"&file="+file,
		beforeSend: function(){
			$Jq('#'+msg_block).html(loadingContent);
		},
		success: function(originalRequest){
			$Jq('#'+msg_block).html(originalRequest);
		}
 	});
	return false;
};
function expand(count){
	var but_id = 'expand_but_'+count;
	var col_id = 'expand_tab_'+count;
	if($Jq('#'+col_id).style.display == 'none'){
			$Jq('#'+col_id).show();
			$Jq('#'+but_id).value=collapse;
	}
	else{
		$Jq('#'+col_id).hide();
		$Jq('#'+but_id).value=expand;
	}
};
function setRefresh(){
	//hideAllBlocks();
	window.location.href = reqResUrl;
};
function testOpenAjaxWindow(linkid){
	ajaxWindowLink = linkid;
	linkobj = $Jq('#'+linkid);
	url = linkobj.attr('href');
	pars = '';
	br=getBrowser();

	$Jq.ajax({
		type: "GET",
		url: url,
		data: pars,
		success: function(data){
			Confirmation('selAjaxWindow', 'frmAjaxWindow', Array('selAjaxWindowInnerDiv'), Array(data), Array('innerHTML'));
			if ((catObj = $Jq('#category')) || (sub_catObj = $Jq('#sub_category'))){
				if (br[0] == 'msie' && getMajorVersion(br[1]) == '7'){
					if (catObj = $Jq('#category'))
						catObj.hide();
					if (sub_catObj = $Jq('#sub_category'))
						sub_catObj.hide();
				}
			}
		}
 	});
	return false;
};
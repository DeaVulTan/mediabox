<div id="selPhotoList"> 
    <h2><span>{$LANG.videoactivate_title}</span></h2>
    <div id="selMsgConfirmDelete" class="selMsgConfirm clsConfirmPopup" style="display:none;">
        <p id="confirmMsg"></p>
            <form name="confirmationForm" id="confirmationForm" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
                <input type="submit" class="clsSubmitButton" name="submit_button" id="submit_button" value="{$LANG.act_yes}"  tabindex="{smartyTabIndex}" />&nbsp;
                <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.act_no}"  tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="video_id" id="video_id" />
                {$myobj->populateHidden($myobj->hidden)}
            </form>
    </div>
    <!-- information div -->	
    
    {$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
    <!-- preview_block start-->
	{if $myobj->isShowPageBlock('preview_block')}
        <div id="selDeleteConfirm"> 
            <form name="video_delete_form" id="video_delete_form" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off"> 
                <table summary="{$LANG.videoactivate_tbl_summary}" class="clsMyPhotosTable"> 
                    <tr> 
                        <td colspan="3">
                        {if $myobj->checkIsExternalEmebedCode()}
                       		{$myobj->displayEmbededVideo()}
                        {/if}
                        {if !$myobj->checkIsExternalEmebedCode()}
                        	<script type="text/javascript" src="{$CFG.site.url}js/swfobject.js"></script>
                           	<div id="flashcontent2"></div>
					<script type="text/javascript">
                                var so1 = new SWFObject("{$myobj->preview_block.flv_player_url}", "flvplayer", "450", "370", "7",  null, true);
                                so1.addParam("wmode", "transparent");
                                so1.addParam("allowFullScreen", "true");
                                so1.addParam("allowSciptAccess", "always");
                                so1.addVariable("config", "{$myobj->preview_block.configXmlcode_url}");
                                so1.write("flashcontent2");
                            </script>	
                         {/if}		  	
                        </td> 
                    </tr> 
                    <tr>
                        <td>
                            <a href="#" id="{$myobj->preview_block.anchor}"></a>
                            <input type="button" class="clsSubmitButton" name="activate" id="activate" value="{$LANG.videoactivate_activate}" tabindex="{smartyTabIndex}" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('video_id', 'action', 'confirmMsg'), Array('{$myobj->getFormField('video_id')}', 'activate', '{$LANG.videoactivate_activate_confirmation}'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp; 
                            <input type="button" class="clsSubmitButton" name="delete" id="delete" value="{$LANG.videoactivate_delete}" tabindex="{smartyTabIndex}" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('video_id', 'action', 'confirmMsg'), Array('{$myobj->getFormField('video_id')}', 'delete', '{$LANG.videoactivate_delete_confirmation}'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp; 
                            <input type="submit" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.videoactivate_cancel}" tabindex="{smartyTabIndex}" /> 
                            {$myobj->populateHidden($myobj->preview_block.populateHidden)}					
                        </td>
                    </tr>
                </table>      
            </form> 
        </div>
	{/if}
	{if  $myobj->isShowPageBlock('list_videos_form')}
        <div id="selVideoList"> 
        	{if $myobj->isResultsFound()}
                <!-- top pagination start--> 
                {if $CFG.admin.navigation.top}
               		        
                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
                {/if}
                <!-- top pagination end-->
                <form name="videoListForm" id="videoListForm" action="{$myobj->getCurrentUrl()}" method="post">
                    <table summary="{$LANG.videoactivate_tbl_summary}"> 
                        <tr> 
                            <th><input type="checkbox" class="clsCheckRadio"  name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.videoListForm.name, document.videoListForm.check_all.name)" /></th>
                            <th>{$LANG.videoactivate_video_title}</th> 
                            <th>{$LANG.videoactivate_video_thumb}</th> 
                            <th>{$LANG.videoactivate_user_name}</th> 
                            <th>{$LANG.videoactivate_date_added}</th> 
                            <th>{$LANG.videoactivate_option}</th> 
                        </tr> 
                     	{foreach item=disValue from=$myobj->list_videos_form.displayVideoList.row}
                            <tr class="{$myobj->getCSSRowClass()}">
                            <td><input type="checkbox" class="clsCheckRadio" name="vid[]" id="vid" value="{$disValue.record.video_id}-{$disValue.record.user_id}" tabindex="{smartyTabIndex}" /></td>
                            <td>{$disValue.record.video_title}</td> 
                            <td class="clsHomeDispContents"><p id="selImageBorder">
                            
                             <a id="viewVideo_{$disValue.record.video_id}" href="videoPreview.php?video_id={$disValue.record.video_id}" title="{$disValue.record.video_title}"><img src="{$disValue.file_path}" alt="{$disValue.record.video_title}"{$disValue.DISP_IMAGE} /></a>
                            
                            {*<img src="{$disValue.img_src}" alt="{$disValue.record.video_title}"{$disValue.DISP_IMAGE} /> *}
                            
                            </p></td> 
                            <td>{$disValue.record.user_name}</td> 
                            <td>{$disValue.record.date_added}</td> 
                            <td><span id="preview"><a href="?action=preview&amp;video_id={$disValue.record.video_id}&amp;start={$myobj->getFormField('start')}">{$myobj->LANG.videoactivate_preview}</a></span></td> 
                            </tr> 
                    	{/foreach}
                        <tr>
                            <td colspan="6">
                            <a href="#" id="{$myobj->list_videos_form.anchor}"></a>
                            <input type="button" class="clsSubmitButton" name="activate_button" id="activate_button" value="{$LANG.videoactivate_activate}" onClick="{$myobj->list_videos_form.onclick_activate}"/>
                            <input type="button" class="clsSubmitButton" name="delete_button" id="delete_button" value="{$LANG.videoactivate_delete}" onClick="{$myobj->list_videos_form.onclick_delete}"/>
                            </td>
                        </tr>
                    </table>
                </form>
                <!-- bottom pagination start-->
                {if $CFG.admin.navigation.bottom}
                            
                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
                {/if}    
                <!-- bottom pagination end-->         
            {else}
                 <div id="selMsgAlert">
           		{$LANG.videoactivate_no_records_found}
                 </div>
            {/if}
        </div>
	{/if} 
</div>    



{* Added code to display fancy box for article admin comments and preview article *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isResultsFound()}
	{foreach item=dalValue from=$myobj->list_videos_form.displayVideoList.row}
	{literal}
	$Jq('#viewVideo_'+{/literal}{$dalValue.record.video_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});


	$Jq('#videoPreview_'+{/literal}{$dalValue.record.video_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	{/literal}
	{/foreach}
	{/if}
	{literal}
});
{/literal}
</script>
    	

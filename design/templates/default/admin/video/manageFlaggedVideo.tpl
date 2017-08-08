<!-- 
	Manage flagged video.
-->
<div id="selVideoList">
  <!-- heading start-->
  <h2><span>{$LANG.manageflagged_title}</span></h2>
  <!-- heading end-->
  <!-- Confirmation message block start-->
  <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(false)}">
			<table summary="">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="yes" id="yes" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsSubmitButton" name="no" id="no" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="video_ids" id="video_ids" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
	<!-- Confirmation message block end-->
<!-- information div -->	

{$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
<!-- flagged_details_form start-->
{if $myobj->isShowPageBlock('flagged_details_form')}
  <div id="selFlaggedDetails">
    {if $displayFlaggedList_arr.rs_PO_RecordCount}
        <table summary="{$LANG.manageflagged_tbl_summary}">
          <tr>
            <th>{$LANG.manageflagged_user_name}</th>
            <th>{$LANG.manageflagged_flaged_text}</th>
            <th>{$LANG.manageflagged_flag_comment}</th>            
            <th>{$LANG.manageflagged_date_added}</th>
          </tr>
        {foreach item=dflValue from=$displayFlaggedList_arr.row}
          <tr>
            <td>{$dflValue.name}</td>
            <td>{$dflValue.record.flag}</td>
            <td>{$dflValue.record.flag_comment}</td>
            <td>{$dflValue.record.date_added}</td>
          </tr>            
        {/foreach}
          <tr>
            <td colspan="4">
                <a href="#" id="dAltMlti"></a>
                <span id="unflag"><a href="#" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('video_id')}', 'Unflag', '{$LANG.unflag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);">{$LANG.manageflagged_activate}</a></span>
                <span id="flag"><a href="#" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('video_id')}', 'Flag', '{$LANG.flag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);">{$LANG.manageflagged_flag}</a></span>
                <span id="delete"><a href="#" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('video_id')}', 'Delete', '{$LANG.delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);">{$LANG.manageflagged_delete}</a></span>
                <span id="back"><a href="?action=back&amp;start={$myobj->getFormField('start')}">{$LANG.manageflagged_back}</a></span>
            </td>
          </tr>
        </table>                
    {/if}
  </div>
{/if}
<!-- flagged_details_form end-->
{if $myobj->isShowPageBlock('list_flagged_video_form')}
  <div id="selVideoList">
	{if $myobj->isResultsFound()}
   		 <!-- top pagination start--> 
		 {if $CFG.admin.navigation.top}
			        
            {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
         {/if}
         <!-- top pagination end-->
       <form name="flaggedForm" id="flaggedForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
	    <table summary="{$LANG.manageflagged_tbl_summary}">
	      <tr>
		  	<th class="clsAlignCenter">
				<input type="checkbox" class="clsCheckRadio" name="check_all" onclick = "CheckAll(document.flaggedForm.name, document.flaggedForm.check_all.name)" />
			</th>
			<th>{$LANG.manageflagged_video_title}</th>
	        <th>{$LANG.manageflagged_user_name}</th>
	        <th>{$LANG.manageflagged_total_flags}</th>
	        <th>{$LANG.manageflagged_option}</th>
	      </tr>

	{foreach item=dalValue from=$displayVideoList_arr}
            <tr class="{$myobj->getCSSRowClass()}">
              <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="video_ids[]" value="{$dalValue.record.video_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('flaggedForm');" {$dalValue.checked}/></td>
              <td> 
              
             {*<a href="#" onclick="return popupWindow('{$CFG.site.url}admin/video/videoPreview.php?video_id={$dalValue.record.video_id}')" title="Video Preview">{$dalValue.record.video_title}</a>*}
             
             
             <a id="videoPreview_{$dalValue.record.video_id}" href="{$CFG.site.url}admin/video/videoPreview.php?video_id={$dalValue.record.video_id}" title="Video Preview">{$dalValue.record.video_title}</a>
                                
             
              </td>
              <td>{$myobj->getUserName($dalValue.record.user_id)}</td>
              <td>{$myobj->getCountOfRequests($dalValue.record.video_id)}</td>
              <td><span id="detail"><a href="?action=detail&amp;video_id={$dalValue.record.video_id}&amp;start={$myobj->getFormField('start')}">{$LANG.manageflagged_detail}</a></span></td>
            </tr>
    {/foreach}
          
            <tr>
                <td colspan="5" class="{$myobj->getCSSFormFieldCellClass('video_submit')}">
                    <a href="#" id="dAltMlti"></a>
                    <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_delete}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.err_tip_select_video}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Delete', '{$LANG.delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
                    <input type="button" class="clsSubmitButton" name="flag_submit" id="flag_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_flag}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.err_tip_select_video}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Flag', '{$LANG.flag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
                    <input type="button" class="clsSubmitButton" name="unflag_submit" id="unflag_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_activate}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.err_tip_select_video}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Unflag', '{$LANG.unflag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
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
	        {$LANG.manageflagged_no_records_found}
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
	{foreach item=dalValue from=$displayVideoList_arr}
	{literal}


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
<div id="selphotoList">
	<!-- Confirmation message block start-->
  	<h2><span>{$LANG.manageflaggedphoto_title}</span></h2>
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(false)}">
			<table summary="">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="yes" id="yes" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsSubmitButton" name="no" id="no" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="photo_ids" id="photo_ids" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- Confirmation message block end-->

    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}
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

              <form name="flagphotoForm" id="flagphotoForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
              	<tr>
                	<td colspan="4">
                    	<a href="#" id="dAltMlti"></a>
                    	<input type="button" class="clsSubmitButton" name="" id="unflag" value="{$LANG.manageflagged_activate}" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('photo_id')}', 'Unflag', '{$LANG.unflag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    	<input type="button" class="clsSubmitButton" name="" id="flag" value="{$LANG.manageflagged_flag}" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('photo_id')}', 'Flag', '{$LANG.flag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    	<input type="button" class="clsSubmitButton" name="" id="delete" value="{$LANG.manageflagged_delete}" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('photo_id')}', 'Delete', '{$LANG.delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    	<input type="submit" class="clsSubmitButton" name="back_submit" id="back_submit" value="{$LANG.manageflagged_back}" />
                	</td>
              	</tr>
              </form>
            </table>
        {/if}
      </div>
    {/if}

    {if $myobj->isShowPageBlock('list_flagged_photo_form')}
     <div id="selPhotoList">
        {if $myobj->isResultsFound()}
	        {if $CFG.admin.navigation.top}
    	        {$myobj->setTemplateFolder('admin/')}
        	    {include file='pagination.tpl'}
         	{/if}
            <form name="flaggedForm" id="flaggedForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            	<table summary="{$LANG.manageflagged_tbl_summary}">
              		<tr>
                		<th class="clsAlignCenter">
                    		<input type="checkbox" class="clsCheckRadio" name="check_all" onclick = "CheckAll(document.flaggedForm.name, document.flaggedForm.check_all.name)" />
                		</th>
                        <th>{$LANG.manageflagged_Photo_title}</th>
                        <th>{$LANG.manageflagged_user_name}</th>
                        <th>{$LANG.manageflagged_total_flags}</th>
                        <th>{$LANG.manageflagged_option}</th>
                      </tr>
		              {foreach item=dalValue from=$displayPhotoList_arr}
                        <tr class="{$myobj->getCSSRowClass()}">
                          <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="photo_ids[]" value="{$dalValue.record.photo_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('flaggedForm');" {$dalValue.checked}/></td>
                          <td> {$dalValue.record.photo_title}</td>
                          <td>{$myobj->getUserName($dalValue.record.user_id)}</td>
                          <td>{$myobj->getCountOfRequests($dalValue.record.photo_id)}</td>
                          <td>
                          	<span id="detail">
                            	<a href="?action=detail&amp;photo_id={$dalValue.record.photo_id}&amp;start={$myobj->getFormField('start')}">{$LANG.manageflagged_detail}</a>
                            </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span id="preview">
                            	<a id="photoPreview_{$dalValue.record.photo_id}" href="{$dalValue.previewURL}">{$LANG.manageflagged_preview_option}</a>
                            </span>
                          </td>
                        </tr>
		              {/foreach}
                	  <tr>
                    	<td colspan="5" class="{$myobj->getCSSFormFieldCellClass('photo_submit')}">
                        	<a href="#" id="dAltMlti"></a>
                        	<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_delete}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.err_tip_select_Photo}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Delete', '{$LANG.delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
                        	<input type="button" class="clsSubmitButton" name="flag_submit" id="flag_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_flag}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.err_tip_select_Photo}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Flag', '{$LANG.flag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
                        	<input type="button" class="clsSubmitButton" name="unflag_submit" id="unflag_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_activate}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.err_tip_select_Photo}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Unflag', '{$LANG.unflag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
                    	</td>
                	  </tr>
            	</table>
          	</form>
            {if $CFG.admin.navigation.bottom}
                {$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}
        {else}
            <div id="selMsgAlert">
                {$LANG.manageflagged_no_records_found}
            </div>
    	{/if}
     </div>
    {/if}
</div>
{* Added code to display fancy box to preview selected photo *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isShowPageBlock('list_flagged_photo_form')}
		{if $myobj->isResultsFound()}
			{foreach item=dalValue from=$displayPhotoList_arr}
				{literal}
				$Jq('#photoPreview_'+{/literal}{$dalValue.record.photo_id}{literal}).fancybox({
					'width'				: 900,
					'height'			: 750,
					'padding'			:  0,
					'autoScale'     	: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none'
				});
				{/literal}
			{/foreach}
		{/if}
	{/if}
	{literal}
});
{/literal}
</script>
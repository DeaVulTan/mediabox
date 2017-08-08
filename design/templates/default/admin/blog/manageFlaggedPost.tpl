<div id="selFlaggedPostList">
  	<!-- Confirmation message block start-->
  	<h2><span>{$LANG.manageflagged_title}</span></h2>
  	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(false)}">
			<table summary="">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="yes" id="yes" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsSubmitButton" name="no" id="no" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="blog_post_ids" id="blog_post_ids" />
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

	        <form name="flagPostForm" id="flagPostForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
	          <tr>
	            <td colspan="4">
	                <a href="#" id="dAltMlti"></a>
	                <input type="button" class="clsSubmitButton" name="" id="unflag" value="{$LANG.manageflagged_activate}" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('blog_post_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('blog_post_id')}', 'Unflag', '{$LANG.manageflagged_unflag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
	                <input type="button" class="clsSubmitButton" name="" id="flag" value="{$LANG.manageflagged_flag}" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('blog_post_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('blog_post_id')}', 'Flag', '{$LANG.manageflagged_flag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    <input type="button" class="clsSubmitButton" name="" id="delete" value="{$LANG.manageflagged_delete}" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('blog_post_ids', 'action', 'confirmMessage'), Array('{$myobj->getFormField('blog_post_id')}', 'Delete', '{$LANG.manageflagged_delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    <input type="submit" class="clsSubmitButton" name="back_submit" id="back_submit" value="{$LANG.manageflagged_back}" />
	            </td>
	          </tr>
	         </form>
	        </table>
	    {/if}
	  </div>
	{/if}

	{if $myobj->isShowPageBlock('list_flagged_post_form')}
		<div id="selPostList">
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
					<th>{$LANG.manageflagged_post_title}</th>
			        <th>{$LANG.manageflagged_user_name}</th>
			        <th>{$LANG.manageflagged_total_flags}</th>
			        <th>{$LANG.manageflagged_option}</th>
			      </tr>

				  {foreach item=dalValue from=$displayPostList_arr}
	              	<tr class="{$myobj->getCSSRowClass()}">
		            	<td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="blog_post_ids[]" value="{$dalValue.record.blog_post_id}" tabindex="{smartyTabIndex}" 	{$dalValue.checked}/></td>
		              	<td> 
                 
                        
                        <a id="viewFlaggedPost_{$dalValue.record.blog_post_id}" href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}" class="lightwindow" title="{$LANG.manageflagged_post_preview}" >{$dalValue.record.blog_post_name}</a>
                        
                        
                        </td>
		              	<td>{$myobj->getUserName($dalValue.record.user_id)}</td>
		              	<td>{$myobj->getCountOfRequests($dalValue.record.blog_post_id)}</td>
		              	<td>
					  		<span id="detail">
					  			<a href="?action=detail&amp;blog_post_id={$dalValue.record.blog_post_id}&amp;start={$myobj->getFormField('start')}">{$LANG.manageflagged_detail}</a>
						 	</span>&nbsp;&nbsp;&nbsp;&nbsp;
		              		<span id="preview">
	                                   <a id="previewFlaggedPost_{$dalValue.record.blog_post_id}" href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}"  class="lightwindow" title="{$LANG.manageflagged_post_preview}">{$LANG.manageflagged_preview_option}</a>
	                    	</span>
					  	</td>
	            	</tr>
	    		  {/foreach}

		          <tr>
		          	<td colspan="5" class="{$myobj->getCSSFormFieldCellClass('post_submit')}">
		            	<a href="#" id="dAltMlti"></a>
	                    <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_delete}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.manageflagged_err_tip_select_post}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('blog_post_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Delete', '{$LANG.manageflagged_delete_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
	                    <input type="button" class="clsSubmitButton" name="flag_submit" id="flag_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_flag}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.manageflagged_err_tip_select_post}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('blog_post_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Flag', '{$LANG.manageflagged_flag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
	                    <input type="button" class="clsSubmitButton" name="unflag_submit" id="unflag_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageflagged_activate}" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '{$LANG.manageflagged_err_tip_select_post}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('blog_post_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Unflag', '{$LANG.manageflagged_unflag_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
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




{* Added code to display fancy box for article comments and preview article *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isResultsFound()}
	{foreach key=dalKey item=dalValue from=$displayPostList_arr}
	{literal}
	$Jq('#viewFlaggedPost_'+{/literal}{$dalValue.record.blog_post_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

	$Jq('#previewFlaggedPost_'+{/literal}{$dalValue.record.blog_post_id}{literal}).fancybox({
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
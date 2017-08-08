<div id="selPostActivate">
  	<h2><span>{$LANG.postactivate_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.postactivate_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.postactivate_confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.postactivate_cancel}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="post_categories" id="post_categories" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>

  {$myobj->setTemplateFolder('admin/')}
  {include file='information.tpl'}

	{if $myobj->isShowPageBlock('list_blog_form')}

	  		<div id="selPostList">

		{if $myobj->isResultsFound()}
	        <form name="post_manage_form2" id="post_manage_form2" method="post" action="{$myobj->getCurrentUrl()}">
	            {if $CFG.admin.navigation.top}
		            {$myobj->setTemplateFolder('admin/')}
	                {include file='pagination.tpl'}
	            {/if}
	            	<p><b>{$LANG.postactivate_post_note}</b>&nbsp;{$LANG.postactivate_post_preview_note}</p>
	                <table summary="{$LANG.postactivate_tbl_summary}">
						<tr>
							<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.post_manage_form2.name, document.post_manage_form2.check_all.name)"/></th>

							<th>{$LANG.postactivate_blog_post_name}</th>
							<th>{$LANG.postactivate_blog_category}</th>
							<th>{$LANG.postactivate_user_name}</th>
							<th>{$LANG.postactivate_date_added}</th>
							<th>{$LANG.postactivate_flagged}</th>
							<th>{$LANG.postactivate_option}</th>
						</tr>
					{foreach item=dalValue from=$displayPostList_arr}
	                    <tr>
	                        <td class="clsSelectAllItems"><input type="checkbox" name="checkbox[]" value="{$dalValue.record.blog_post_id}-{$dalValue.record.user_id}" /></td>
	                        <td>
                            
                            <a id="viewArticle_{$dalValue.record.blog_post_id}" href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postactivate_post_preview}"  class="lightwindow">{$dalValue.record.blog_post_name}</a>
                            
                            {*<a href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postactivate_post_preview}" class="lightwindow" params="lightwindow_type=external">{$dalValue.record.blog_post_name}</a>*}
                            
                            </td>
	                        <td>{$myobj->getBlogCategory($dalValue.record.blog_category_id)}</td>
	                        <td>{$dalValue.name}</td>
	                        <td>{$dalValue.record.date_added}</td>
	                        <td>{$dalValue.record.flagged_status}</td>
	                        <td>
	                            <span id="preview">		
                                <a id="previewArticle_{$dalValue.record.blog_post_id}" href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postactivate_post_preview}"  class="lightwindow">{$myobj->LANG.postactivate_preview}</a>				  			
						  			
                                    {*<a href="{$CFG.site.url}admin/blog/postPreview.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postactivate_post_preview}" class="lightwindow" params="lightwindow_type=external">{$myobj->LANG.postactivate_preview}</a>*}
							 	</span>&nbsp;&nbsp;&nbsp;&nbsp;
			              		<span id="adminComments">
		                    		
                                     <a id="viewArticleComment_{$dalValue.record.blog_post_id}" href="{$CFG.site.url}admin/blog/managePostComments.php?blog_post_id={$dalValue.record.blog_post_id}"  class="lightwindow" title="{$LANG.postactivate_admin_comments}">{$LANG.postactivate_admin_comments}</a>
                                    
                                    {*<a href="{$CFG.site.url}admin/blog/postAdminComment.php?blog_post_id={$dalValue.record.blog_post_id}" title="{$LANG.postactivate_post_add_comments}" class="lightwindow" params="lightwindow_type=external">{$LANG.postactivate_admin_comments}</a> *}
		                    	</span>			              		
	                        </td>
	                    </tr>
	                {/foreach}

						<tr>
							<td colspan="9">
								<a href="#" id="dAltMlti"></a>
								<input type="hidden" name="post_options" value="Ok" />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.postactivate_activate}" onClick="if(getMultiCheckBoxValue('post_manage_form2', 'check_all', '{$LANG.postactivate_err_tip_select_posts}')) {literal} { {/literal} getAction('Ok') {literal} } {/literal}" />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.postactivate_delete}" onClick="if(getMultiCheckBoxValue('post_manage_form2', 'check_all', '{$LANG.postactivate_err_tip_select_posts}')) {literal} { {/literal} getAction('Delete') {literal} } {/literal} " />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.postactivate_disapprove}" onClick="if(getMultiCheckBoxValue('post_manage_form2', 'check_all', '{$LANG.postactivate_err_tip_select_posts}')) {literal} { {/literal} getAction('NotApproved') {literal} } {/literal} " />
								&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
						</tr>
					</table>

	            {if $CFG.admin.navigation.bottom}
		            {$myobj->setTemplateFolder('admin/')}
	                {include file='pagination.tpl'}
	            {/if}

				{$myobj->populateHidden($myobj->list_blog_form.hidden_arr)}

	        </form>
		{else}
			<div id="selMsgAlert">
				{$LANG.postactivate_no_records_found}
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
	$Jq('#viewArticleComment_'+{/literal}{$dalValue.record.blog_post_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

	$Jq('#previewArticle_'+{/literal}{$dalValue.record.blog_post_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	
	$Jq('#viewArticle_'+{/literal}{$dalValue.record.blog_post_id}{literal}).fancybox({
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
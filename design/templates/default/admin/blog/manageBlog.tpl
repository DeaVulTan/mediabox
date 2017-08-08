<div id="selPostActivate">
  	<h2><span>{$LANG.manageblog_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.manageblog_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.manageblog_confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.manageblog_cancel}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />						
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
	                <table summary="{$LANG.manageblog_tbl_summary}">
						<tr>
							<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.post_manage_form2.name, document.post_manage_form2.check_all.name)"/></th>							
							<th>{$LANG.manageblog_blog_id}</th>
                            <th>{$LANG.manageblog_blog_name}</th>
                            <th>{$LANG.manageblog_blog_title}</th>							
							<th>{$LANG.manageblog_created_by}</th>
							<th>{$LANG.manageblog_date_added}</th>
                            <th>{$LANG.manageblog_status}</th>
                            <th>{$LANG.manageblog_total_post}</th>						
						</tr>
					{foreach item=dalValue from=$displayBlogList_arr}
	                    <tr>
	                        <td class="clsSelectAllItems"><input type="checkbox" name="checkbox[]" value="{$dalValue.record.blog_id}-{$dalValue.record.user_id}" /></td>
	                        <td>{$dalValue.record.blog_id}</td
                            ><td><p>{$dalValue.record.blog_name}</p>
                            {if $dalValue.blog_logo_src}<p><img src="{$dalValue.blog_logo_src}" alt="{$dalValue.record.blog_name}"  title="{$dalValue.record.blog_title}" width="150" height="90" /></p>{/if}
                            </td>
                            <td>{$dalValue.record.blog_title}</td>	                        
	                        <td>{$dalValue.name}</td>
	                        <td>{$dalValue.record.date_added}</td>
                            <td>{$dalValue.record.blog_status}</td>
                            <td>{$dalValue.total_post}</td>	                       
	                    </tr>
	                {/foreach}

						<tr>
							<td colspan="9">
								<a href="#" id="dAltMlti"></a>
								<input type="hidden" name="post_options" value="Ok" />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.manageblog_activate}" onClick="if(getMultiCheckBoxValue('post_manage_form2', 'check_all', '{$LANG.manageblog_err_tip_select_blogs}')) {literal} { {/literal} getAction('Active') {literal} } {/literal}" />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.manageblog_delete}" onClick="if(getMultiCheckBoxValue('post_manage_form2', 'check_all', '{$LANG.manageblog_err_tip_select_blogs}')) {literal} { {/literal} getAction('Delete') {literal} } {/literal} " />								
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
				{$LANG.manageblog_no_records_found}
			</div>
		{/if}
	  		</div>

	{/if}
</div>
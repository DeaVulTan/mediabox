{if !isAjaxPage()}
<div id="selProfileBlog">
{$myobj->setTemplateFolder('general/','music')}
{include file="box.tpl" opt="audioindex_top"}
	 <div class="clsAudioIndex"><h3 class="clsH3Heading">{$LANG.profileblog_title}</h3></div>
  	<div id="selLeftNavigation">
		{$myobj->setTemplateFolder('general/','music')}
 		{include file='information.tpl'}
{/if}
		{if $myobj->isShowPageBlock('block_blogger_list')}
		<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">		
  			<h3 id="act_confirmation_msg" class="clsPopUpHeading"></h3>
  			<form name="actForm" id="actForm" method="post" action="{$myobj->getCurrentUrl()}">       
				{$myobj->populateHidden($myobj->block_blogger_list.confirm_form_hidden_arr)}
           		<input type="hidden" name="bid" value="" />
				<input type="hidden" name="act" value="" />
				<p>
		   			<input type="submit" class="clsPopUpSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
          			&nbsp;
          			<input type="button" class="clsPopUpSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
		 		</p>
  			</form>			
		</div>
		<div id="selMsgAddNewBlog" class="selMsgConfirmWindow" style="display:none;">	

        <div class="clsIndexAudioHeading">
								<h3 id="confirmation_msg" class="clsPopUpHeading"></h3>
								<div class="clsHeadingClose"></div></div>
		  	<form name="formMsgAddNewBlog" id="formMsgAddNewBlog" method="post" action="{$myobj->getCurrentUrl()}">
				{$myobj->populateHidden($myobj->block_blogger_list.confirm_form_hidden_arr)}
		    	<div class="clsPopUpGreyTable" id="selAddNewBlogContent"></div>
		  	</form>

		</div>
            <div class="clsOverflow">
             <div class="clsProfileBlogHdLeft">
                 <p class="clsAddIcon">
                      <a href="javascript:void(0)" onclick="{$myobj->block_blogger_list.add_new_blog_onclick}">{$LANG.profileblog_add_new_blog}</a>
                  </p>
             </div>
             <div class="clsProfileBlogHdRight"> 
              {if $myobj->getFormField('music_id') != ''}
                    <p>
                        <a href="{$myobj->view_music_url}">{$LANG.profileblog_back}</a>
                    </p>        
              {/if}
             </div>
             </div>
			{if $myobj->block_blogger_list.populateBloggerList}
				<div class="clsDataTable clsBloggerTable">
                	<table>
				{foreach key=pblkey item=pblvalue from=$myobj->block_blogger_list.populateBloggerList.record}
					<tr>
						<td class="clsBlogName"><a href="{$myobj->block_blogger_list.populateBloggerList.link_url.$pblkey}">{$pblvalue.blog_title}</a></td>
						<td class="clsBlogger"><p class="{$myobj->block_blogger_list.populateBloggerList.class_name.$pblkey}">{$pblvalue.blog_site}</p></td>
						<td class="clsRemoveBlog"><a href="javascript:void(0)" onclick="{$myobj->block_blogger_list.populateBloggerList.remove_onclick.$pblkey}">{$LANG.profileblog_remove}</a></td>
						<td class="clsModifyBlog"><a href="javascript:void(0)" onclick="{$myobj->block_blogger_list.populateBloggerList.modify_onclick.$pblkey}">{$LANG.profileblog_modify}</a></td>
					</tr>
				{/foreach}
				</table>
                </div>
			{else}
				<div class="clsAlertNoRecords"><p class="clsBold">{$LANG.profileblog_no_blogs_added}</p></div>
			{/if}
		{/if}
		{if $myobj->isShowPageBlock('block_blog_site_list')}
			<input type="hidden" name="bid" id="" value="{$myobj->getFormField('bid')}" />
			<table class="clsProfileEditTbl">
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('blog_site')}">
						<label for="blog_site">{$LANG.profileblog_blog_site}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('blog_site')}">{$myobj->getFormFieldErrorTip('blog_site')}
						<select name="blog_site" id="blog_site" tabindex="{smartyTabIndex}" onchange="showBlogDetailForm()">
							<option value="">{$LANG.profileblog_select_blog}</option>
							{$myobj->generalPopulateArray($myobj->blog_site_list_arr, $myobj->getFormField('blog_site'))}
						</select>
	                </td>
			   	</tr>
				{if $myobj->isShowPageBlock('sub_block_blogger_form')}
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('blog_title')}">
						<label for="blog_title">{$LANG.profileblog_blog_title}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('blog_title')}">{$myobj->getFormFieldErrorTip('blog_title')}
						<input type="text" class="clsTextBox" name="blog_title" id="blog_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('blog_title')}" />
		            </td>
				</tr>
				{/if}
				{if $myobj->isShowPageBlock('sub_block_blogger_form')}
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('blog_user_name')}">
						<label for="blog_user_name">{$LANG.profileblog_blog_user_name}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('blog_user_name')}">{$myobj->getFormFieldErrorTip('blog_user_name')}
						<input type="text" class="clsTextBox" name="blog_user_name" id="blog_user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('blog_user_name')}" />
		            </td>
				</tr>
				{/if}
				{if $myobj->isShowPageBlock('sub_block_blogger_form')}
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('blog_password')}">
						<label for="blog_password">{$LANG.profileblog_blog_password}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('blog_password')}">{$myobj->getFormFieldErrorTip('blog_password')}
						<input type="password" class="clsTextBox" name="blog_password" id="blog_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('blog_password')}" />
		            </td>
				</tr>
				{/if}
				{if $myobj->isShowPageBlock('sub_block_blogger_form')}
				<tr>
					<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('submit')}">
						<input type="button" class="clsPopUpSubmitButton" name="add_blog_submit" id="add_blog_submit" tabindex="{smartyTabIndex}" value="{$LANG.profileblog_add_blog_submit}" onclick="addNewBlog()" />
					</td>
		   		</tr>
				{/if}
			</table>
		{/if}
		{if $myobj->isShowPageBlock('block_add_success')}
			{$myobj->setTemplateFolder('general/','music')}
			{include file='information.tpl'}
			<script language="javascript" type="text/javascript">
				{if $myobj->chkIsReffererUrl()}
					setTimeout("Redirect2URL('{$myobj->getCurrentUrl()}?act=redirect&backkey={$myobj->getFormField('backkey')}')", 9000);
				{else}
					setTimeout("Redirect2URL('{$myobj->getCurrentUrl()}')", 9000);
				{/if}
			</script>
            <br />
		{/if}
           <script language="javascript" type="text/javascript">
			{literal}
			function closeAddBlog()			
				{
					hideAllBlocks();
					Redirect2URL('{/literal}{$myobj->getCurrentUrl()}{literal}');				
				}			
			{/literal}
	     </script>
{if !isAjaxPage()}
	</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file="box.tpl" opt="audioindex_bottom"}   
</div>
{/if}
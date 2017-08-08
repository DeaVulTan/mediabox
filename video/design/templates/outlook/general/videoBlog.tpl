{if !isAjaxPage()}
<div id="option-tab-3" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div class="clsPopupContent clsSuccessMessage" id="selAddNewBlogSuccess" style="display:none"><p>{$LANG.viewvideo_posted_your_blog}</p></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	{if isMember()}
			<a href="{$myobj->getCurrentUrl(true)}" onclick="return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', '{$myobj->getCurrentUrl(true)}', 'action=popblogtitle', 'updateBlogTitle');">{$LANG.viewvideo_add_to_blog}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_blog_msg}', '{$myobj->notLoginVideoUrl}'); return false;">{$LANG.viewvideo_add_to_blog}</a>
            {/if}
		</div>
	</div>
</div>
{* <div id="blogDiv" class="clsDisplayNone">
	<div class="clsOverflow">
    	<div class="clsFlagTitle">
			{$LANG.viewvideo_add_to_blog}
		</div>
        <div class="clsCloseFlag"><a onclick="hideVideoSection('blogDiv','clsDisplayNone')">{$LANG.viewvideo_close}</a></div>
    </div>
    <div class="clsFlagTable">
        <table>
        	<tr>
        		<td><p>{$LANG.viewvideo_blog_post_info}</p></td>
        	</tr>
        </table>
    </div>
 </div> *}
<!---<div id="selMsgAddNewBlog" class="clsDisplayNone">-->
<div id="blogDiv" class="clsPopupConfirmation" style="display:none;">
    <form name="formMsgAddNewBlog" id="formMsgAddNewBlog" method="post" action="{$myobj->getCurrentUrl()}">

		<div class="clsOverflow"{$myobj->videos_form.no_blog_added}>
        	<div class="clsFlagTitle">{$LANG.viewvideo_no_blog_msg}</div>
    	</div>
		<div class="clsOverflow"{$myobj->videos_form.blog_added}>
        	<div class="clsFlagTitle">{$LANG.viewvideo_add_to_blog}</div>
    	</div>
		<div id="blogPostInfo" class="clsBlogCreate clsOverflow"{$myobj->videos_form.blog_added}>
			<p>{$myobj->LANG.viewvideo_blog_post_info}</p>
        </div>
        <div class="clsPopupContent clsErrorMessage" id="selAddNewBlogFailure" style="display:none"></div>
    	<div class="clsFlagTable" id="selAddNewBlogContent"{$myobj->videos_form.blog_added}>
			<table class="clsProfileEditTbl">
				<tr>
					<td>
						<label for="blog_title">{$LANG.viewvideo_blog_title}&nbsp;{$LANG.important}&nbsp;</label>
					</td>
					<td id="selBlogTitle">
{/if}
{if isAjaxPage()}
						{$myobj->getFormFieldErrorTip('blog_title')}
						<select name="blog_title" id="blog_title" tabindex="{smartyTabIndex}" onChange="showBlogDetailForm()">
							{$myobj->generalPopulateArray($myobj->videos_form.getBlogList, $myobj->getFormField('blog_title'))}
						</select>
{/if}
{if !isAjaxPage()}
	                </td>
			   	</tr>
				<tr>
					<td>
						<label for="blog_post_title">{$LANG.viewvideo_blog_post_title}&nbsp;{$LANG.important}&nbsp;</label>
					</td>
					<td>
						{$myobj->getFormFieldErrorTip('blog_post_title')}
						<input type="text" class="clsTextBox" name="blog_post_title" id="blog_post_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('blog_post_title')}" />
		            </td>
				</tr>
				<tr>
					<td>
						<label for="blog_post_text">{$LANG.viewvideo_blog_post_text}&nbsp;{$LANG.important}&nbsp;</label>
					</td>
					<td>
						{$myobj->getFormFieldErrorTip('blog_post_text')}
						<textarea name="blog_post_text" id="blog_post_text" tabindex="{smartyTabIndex}">{$myobj->getFormField('blog_post_text')}</textarea>
		            </td>
				</tr>
				<tr>
					<td>
						<div class="clsFlagButtonLeft"><div class="clsFlagButtonRight"><input type="button" class="clsSubmitButton" name="add_blog_submit" id="add_blog_submit" tabindex="{smartyTabIndex}" value="{$LANG.viewvideo_add_blog_submit}" onClick="postThisVideo()" /></div></div>
					</td>
		   		</tr>
			</table>
		</div>
  	</form>
</div>
{/if}
{if !isAjaxPage()}
<div id="listenMusicBlog" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div class="clsPopupContent clsSuccessMessage" id="selAddNewBlogSuccess" style="display:none"><p>{$LANG.viewmusic_posted_your_blog}</p></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	{if $myobj->isMember}
			<a href="{$myobj->getCurrentUrl(true)}" onclick="return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', load_blog_url, '', 'updateBlogTitle');" title="{$LANG.viewmusic_add_blog}" alt="{$LANG.viewmusic_add_blog}">{$LANG.viewmusic_add_blog}</a>
            {else}
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_blog_lyrics_err_msg}','{$myobj->memberviewMusicUrl}');return false;" title="{$LANG.viewmusic_add_blog}" alt="{$LANG.viewmusic_add_blog}">{$LANG.viewmusic_add_blog}</a>
            {/if}
		</div>
	</div>
</div>
<div id="blogDiv" class="clsPopupConfirmation" style="display:none;">
    <div class="clsUserActionMessage" id="no_blog"{$myobj->musics_form.add_new_blog_info}>
          {$myobj->LANG.viewmusic_no_blog}
    </div>    
    <div id="selMsgAddNewBlog"{$myobj->musics_form.post_to_blog}>
        <form name="formMsgAddNewBlog" id="formMsgAddNewBlog" method="post" action="{$myobj->getCurrentUrl()}">	
        <div class="clsPopupContent clsErrorMessage" id="selAddNewBlogFailure" style="display:none"></div>
        <div id="selAddNewBlogContent" class="clsInnerPlaylist" >
            <div id="blogPostInfo">
                  <p>{$myobj->LANG.viewmusic_blog_post_info}</p>
            </div>      
            <div class="clsCreatePlaylist">
                <div class="clsRow" id="selBlogTitle">
                    {/if}
                    {if isAjaxPage()}                  
                    <div class="clsTDLabel">
                          <label for="blog_title">{$LANG.viewmusic_blog_title}:&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span></label>
                    </div>
                    <div class="clsTDText">
                          <select name="blog_title" id="blog_title" tabindex="{smartyTabIndex}" onchange="showBlogDetailForm()">
                                {$myobj->generalPopulateArray($myobj->musics_form.getBlogList, $myobj->getFormField('blog_title'))}
                          </select>
                          {$myobj->getFormFieldErrorTip('blog_title')}
                    </div>                  
                    {/if}
                    {if !isAjaxPage()}
                </div>
                <div class="clsRow">
                    <div class="clsTDLabel">
                          <label for="blog_post_title">{$LANG.viewmusic_blog_post_title}:&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span></label>
                    </div>
                    <div class="clsTDText">
                          <input type="text" class="clsFields" name="blog_post_title" id="blog_post_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('blog_post_title')}" />
                          {$myobj->getFormFieldErrorTip('blog_post_title')}
                    </div>
                </div>
                <div class="clsRow">
                    <div class="clsTDLabel">
                          <label for="blog_post_text">{$LANG.viewmusic_blog_post_text}:&nbsp;<span class="clsMandatoryFieldIcon">{$LANG.common_music_mandatory}</span></label>
                    </div>
                    <div class="clsTDText">
                          <textarea class="clsFields" name="blog_post_text" id="blog_post_text" tabindex="{smartyTabIndex}" rows="3" cols="50">{$myobj->getFormField('blog_post_text')}</textarea>
                          {$myobj->getFormFieldErrorTip('blog_post_text')}
                    </div>
                </div>
                <div class="clsRow" style="display:none" id="blog_loader_row"> 
                    <div class="clsTDLabel"><!----></div>
                    <div class="clsTDText">
                        <div id="blog_submitted"></div>
                    </div>
                  </div>                  
                  <div class="clsRow">
                        <div class="clsTDLabel"><!----></div>
                        <div class="clsTDText">
                              <p class="clsButton"><span><input type="button" class="clsSubmitButton" name="add_blog_submit" id="add_blog_submit" tabindex="{smartyTabIndex}" value="{$LANG.viewmusic_add_blog_submit}" onclick="postThisMusic()" /></span></p>
                        </div>
                  </div>
            </div>
        </div>
        </form>
    </div>
</div>
{/if}
{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_top'}
    <div id="selindexPostList">
        <!--rounded corners-->
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        {$myobj->populateBlogListHidden($paging_arr)}
            <div class="clsOverflow">
                <div class="clsBlogListHeading">
                    <h2><span>
                            {$LANG.index_title|capitalize:true}
                        </span>
                    </h2>
                </div>
            </div>
        </form>
        <div id="selLeftNavigation">
        <!-- Delete Single Post -->
            <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
                <p id="msgConfirmText"></p>
                <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                    <div class="clsBlogListTable clsContentsDisplayTbl">
						<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />&nbsp;
						<input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
						<input type="hidden" name="act" id="act" />
						<input type="hidden" name="blog_post_id" id="blog_post_id" />
                    </div>
                </form>
            </div>
            <div id="selEditPostComments" class="clsPopupConfirmation" style="display:none;"></div>
                {if $myobj->isShowPageBlock('my_posts_form')}
                    <div id="selPostListDisplay" class="clsLeftSideDisplayTable">
                        {if $myobj->isResultsFound()}
                            {if $CFG.admin.navigation.top}
                                {$myobj->setTemplateFolder('general/','blog')}
                                {include file='pagination.tpl'}
                            {/if}
                            <form name="blogPostListForm" id="blogPostListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                                <p><a href="#" id="{$myobj->anchor}"></a></p>
                                <div id="selDisplayTable">
                                    {foreach key=salKey item=salValue from=$showindexPostList_arr.row}
                                        <div class="clsBlogListContent">
                                            <a href="#" id="{$salValue.anchor}"></a>
                                            {if $salValue.record.status =='Locked'}
                                                <div class="clsHomeDispContent">
                                                  <h3 class="clsTitleLink">{$salValue.row_blog_post_name_manual}</h3>
                                                  <p class="clsAddedDate">{$LANG.index_added}&nbsp;{$salValue.record.date_added}</p>
                                                </div>
                                            {else}
                                                <div class="clsHomeDispContent">
                                                    <div class="clsOverflow">
														<h3 class="clsTitleLink clsFloatLeft">
															<a href="{$salValue.view_blog_post_link}">{$salValue.row_blog_post_name_manual|capitalize}</a>&nbsp;&nbsp;
														</h3>
														<div class="clsBlogViewDetails clsFloatLeft">
																	<span class="clsGreyColor">
																	{if $salValue.record.status =='Ok'}
																		{$LANG.index_date_published_on}:&nbsp;
																		<span class="">{if $salValue.record.date_published!=''}{$salValue.record.date_published}{else}{$salValue.record.date_added}{/if}</span>
																	{else}
																		{$LANG.index_date_published_on} :&nbsp;
																		<span>{$salValue.record.date_added}</span>
																	{/if}
																	</span>
																	   {if isMember() && $salValue.record.user_id == $CFG.user.user_id}
																	 &nbsp;|&nbsp;
																	 <span><a href="{$salValue.blog_post_posting_url_ok}" class="clsBlogEditLinks" title="{$LANG.index_edit_blog_post}">{$LANG.index_edit_blog_post}</a></span>&nbsp;|&nbsp;
																<span><a href="#" class="clsBlogEditLinks" title="{$LANG.index_delete_submit}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','blog_post_id', 'msgConfirmText'), Array('delete','{$salValue.record.blog_post_id}','{$LANG.index_delete_confirmation}'), Array('value','value', 'innerHTML'), -100, -500);">{$LANG.index_delete_submit}</a></span>
																	 {/if}

															</div>
													</div>
                                                    <div class="clsBlogDetails">
                                                        <div class="clsOverflow">
																<p class="clsPostedName">({$LANG.index_post_list_added_in_blog_title}:&nbsp;<a href="{$salValue.view_blog_link}" title="{$salValue.record.blog_name}">{$salValue.record.blog_name}</a>)</p>
													</div>
														<div id="blogUserProfile_{$salValue.record.blog_post_id}" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$salValue.record.user_id}', 'blogUserProfile_{$salValue.record.blog_post_id}');" onmouseout="hideUserInfoPopup('blogUserProfile_{$salValue.record.blog_post_id}')"></div>
                                                        <div class="clsBlogContent">

                                                        {$salValue.message}
                                                        </div>
                                                         <div class="clsOverflow clsTagsCategory">
										  					 <div class="clsFloatLeft">
                                                             {assign var=blog_tags value=''}
                                                            <span class="clsTagBg">{$LANG.index_search_blogpost_tags} :</span>{if $salValue.record.blog_tags!=''} {$myobj->getBlogPostsTagsLinks($salValue.record.blog_tags, 13, $blog_tags)}{/if}
                                                           </div>
														   <div class="clsFloatRight">
																<span>{$LANG.index_blog_post_category_name} {$showindexPostList_arr.separator}</span>
																<span class="clsBlogValues">{$salValue.row_blog_category_name_manual}</span>
															</div>
                                                        </div>  </div>
														<div class="clsOverflow">
                                                        <div class="clsRatingLeft">
															<div class="clsRatingRight">
																<div class="clsRatingCenter">
																	<div class="clsFloatLeft clsUserImageBorder">
																	 by <a href="{$salValue.member_profile_url}">
																	 <img src="{$salValue.profileIcon.s_url}" title="{$salValue.name}" {$myobj->DISP_IMAGE(15, 15, $salValue.width, $salValue.height)}/>&nbsp;<span class="clsUserProfileImage" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}',
                                                                '{$salValue.record.user_id}', 'blogUserProfile_{$salValue.record.blog_post_id}');" onmouseout="hideUserInfoPopup('blogUserProfile_{$salValue.record.blog_post_id}')"></span></a>
																<a href="{$salValue.member_profile_url}">{$salValue.name|capitalize}</a>
																	</div>
																	<div class="clsFloatRight">
																					  <span class="clsBoldFont">{$salValue.record.total_comments}</span>
                                                                {if $salValue.record.total_comments > 1}{$LANG.index_comments}{else}{$LANG.index_comment}{/if}&nbsp;|&nbsp;
                                                                <span class="clsBoldFont">{$salValue.record.total_views}</span>
                                                                {if $salValue.record.total_views > 1}{$LANG.index_views}{else}{$LANG.index_view}{/if}&nbsp;|&nbsp;
                                                                <span class="clsBoldFont">{$salValue.record.total_favorites}</span>
                                                                {if $salValue.record.total_favorites > 1}{$LANG.index_favorites}{else}{$LANG.index_favorite}{/if}
																	&nbsp;|&nbsp;{if $myobj->populateRatingDetails($salValue.record.rating)}
																		{$myobj->populateBlogRatingImages($salValue.record.rating,'blog')}
																	{else}
																	   {$myobj->populateBlogRatingImages(0,'blog')}
																	{/if}
																	</div>
		                                                        </div>
															</div>
														</div>
														</div>
                                                    </div>

                                            {/if}
                                        </div>
                                    {/foreach}
                                    {if $showindexPostList_arr.extra_td_tr}
                                        <div>&nbsp;</div>
                                    {/if}
                                </div>
                             </form>
                            {if $CFG.admin.navigation.bottom}
                                {$myobj->setTemplateFolder('general/','blog')}
                                {include file='pagination.tpl'}
                            {/if}
                        {else}
                            <div id="selMsgAlert">
                                <p>{$LANG.index_no_records_found}</p>
                            </div>
                        {/if}
                    </div>
                {/if}
            <!--end of rounded corners-->
        </div>
    </div>
{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_bottom'}



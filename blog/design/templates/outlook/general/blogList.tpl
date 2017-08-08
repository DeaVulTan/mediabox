{$myobj->setTemplateFolder('general/','blog')}
{include file='information.tpl'}

{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_top'}
	<div id="selBlogList" class="clsBlogListIndex">
	<!--rounded corners-->
    <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		<input type="hidden" name="advanceFromSubmission" value="1"/>
        {$myobj->populateBlogListHidden($paging_arr)}
        <div class="clsOverflow">
        	<div class="clsBlogListHeading">
            	<h2><span>{$LANG.bloglist_title}</span></h2>
            </div>
        </div>
        <div id="advanced_search" class="clsAdvancedSearch">

      		<div class="clsAdvancedSearchBg">
      			<table class="clsAdvancedFilterTable">
        			<tr>
                    	<td class="clsSearchIcons">
                        	<input class="clsTextBox" type="text" name="blog_name_keywords" id="blog_name_keywords" value="{if $myobj->getFormField('blog_name_keywords') != ''}{$myobj->getFormField('blog_name_keywords')}{else}{$LANG.bloglist_keyword_field}{/if}" onblur="setOldValue('blog_name_keywords')" onfocus="clearValue('blog_name_keywords')"/>
							<input class="clsTextBox" type="text" name="post_owner" id="post_owner" value="{if $myobj->getFormField('post_owner') != ''}{$myobj->getFormField('post_owner')}{else}{$LANG.bloglist_post_created_by}{/if}" onblur="setOldValue('post_owner')"  onfocus="clearValue('post_owner')"/>
                        </td>
						<td class="clsSearchStrip">
							<div class="clsSearchButtonTd">
								<div class="clsAdvSearchButton clsOverflow">
                        	<div class="clsSubmitLeft">
                            	<span class="clsSubmitRight">
                                	<input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.bloglist_search_submit}" />
                               	</span>
                           	</div>
							</div>
								<div class="clsAdvCancelButton clsOverflow">
                            <div class="clsCancelLeft">
                            	<span class="clsCancelRight">
                      <input type="button" name="avd_reset" id="avd_reset" onclick="location.href='{$myobj->getUrl('bloglist', '', '', '', 'blog')}'" value="{$LANG.bloglist_reset_submit}" />
                                </span>
                            </div>
							</div>
							</div>
                        </td>
					</tr>
		        </table>
      		</div>

        </div>
    </form>

        {if $myobj->isShowPageBlock('block_blog_list_form')}
        		{if $myobj->isResultsFound()}
                    {if $CFG.admin.navigation.top}
                        {$myobj->setTemplateFolder('general/','blog')}
                        {include file='pagination.tpl'}
                     {/if}

                     <div id="selDisplayTable">
                           {foreach key=salKey item=salValue from=$showBlogList_arr}
                           <div class="clsBlogListContent">
                           		<div class="clsHomeDispContent">
								<div class="clsOverflow">
                                  <h3 class="clsTitleLink clsFloatLeft">
                                  <a href="{$salValue.view_blog_link}">{$salValue.blog_name}</a>
                                  </h3>
								  <div class="clsBlogViewDetails clsFloatLeft">
									  {if $salValue.post_added!=''}&nbsp;&nbsp;{$LANG.bloglist_post_post_posted_on}&nbsp;:&nbsp;<span>{$salValue.post_added}</span>&nbsp;|{/if}&nbsp;
									  {$LANG.bloglist_date_added}&nbsp;:&nbsp;<span>{$salValue.date_added}</span>
								</div>
								</div>
                                  <div class="clsBlogDetails">
                                    {if $salValue.postList_arr.record_count!=0}<div>{$LANG.bloglist_recent_post_title}</div>{/if}
                                     {if $salValue.postList_arr.record_count}
                                      <div class="clsPostContent">
                                     {$salValue.postList_arr.message}
                                      </div>
                                      <p></p>
									   <div class="clsOverflow clsTagsCategory">
										   <div class="clsFloatLeft">
											{assign var=blog_tags value=''}
											<span class="clsTagBg">{$LANG.blolist_blogpost_tags}:</span>{if $salValue.postList_arr.record.blog_tags!=''}
											{$myobj->getBlogPostsTagsLinks($salValue.postList_arr.record.blog_tags, 13, $blog_tags)}{/if}
											</div>
											<div class="clsFloatRight">
												{$LANG.bloglist_blogpost_category_name}: <span class="clsBlogValues">{$salValue.postList_arr.blog_category_name_manual}</span>
											</div>
	                                   </div>
									   </div>
									   </div>
									   <div class="clsOverflow">
											<div class="clsRatingLeft">
												<div class="clsRatingRight">
													<div class="clsRatingCenter">
														<div class="clsFloatLeft clsUserImageBorder">
														by  <a href="{$salValue.member_profile_url}"><img src="{$salValue.profileIcon.s_url}" title="{$salValue.name}" {$myobj->DISP_IMAGE(15, 15, $salValue.width, $salValue.height)}/> {$salValue.name}</a>
														</div>
											<div class="clsFloatRight">
											 <p class="clsRatingDisplay"> <span class="clsBoldFont">{$salValue.postList_arr.record.total_comments}</span>
                                      {if $salValue.postList_arr.record.total_comments > 1}{$LANG.bloglist_post_comments}{else}{$LANG.bloglist_post_comment}{/if}&nbsp;|&nbsp;
                                       <span class="clsBoldFont">{$salValue.postList_arr.record.total_views}</span>
                                       {if $salValue.postList_arr.record.total_views > 1}{$LANG.bloglist_post_views}{else}{$LANG.bloglist_post_view}{/if}&nbsp;|&nbsp;

                                        {if $myobj->populateRatingDetails($salValue.postList_arr.record.rating)}
                                            {$myobj->populateBlogRatingImages($salValue.postList_arr.record.rating,'blog')}
                                        {else}
                                           {$myobj->populateBlogRatingImages(0,'blog')}
                                        {/if}
                                      </p>
									 		</div>
		                                                        </div>
															</div>
														</div>
														</div>

                                      {else}
                                       <p class="clsNoPostFound">{$LANG.bloglist_no_post_found}</p>
                                      {/if}

                                  </div>
                                </div>
                             
                           {/foreach}


                     {if $CFG.admin.navigation.bottom}
                            {$myobj->setTemplateFolder('general/','blog')}
                            {include file='pagination.tpl'}
                      {/if}
                 {else}
                 	<div id="selMsgAlert">
                        	<p>{$LANG.bloglist_no_records_found}</p>
                     </div>
                 {/if}
        {/if}
</div>
{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_bottom'}

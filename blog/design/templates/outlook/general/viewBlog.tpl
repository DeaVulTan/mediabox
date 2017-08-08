	<div id="sideBar" class="clsViewPostRight">
			  <!--SIDEBAR1-->
			  <div class="sideBar1">

				 {* ---------------BLOG SEARCH BLOCK BEGINS ---------------------------------*}
				 {if $myobj->_currentPage!='blogtags'}
					   <div class="clsSearchBoxBgRight">
						 <form name="postSearch" id="postSearch" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
						 <input type="hidden" name="postSearchFromSubmission" value="1"/>
						 <input type="text" value="{if $myobj->getFormField('post_keyword') != ''}{$myobj->getFormField('post_keyword')}{else}{$LANG.common_search_text}{/if}" name="post_keyword" id="post_keyword" class="clsBlogSearchTextBox" onblur="setOldValue('post_keyword')"  onfocus="clearValue('post_keyword')"/>
						 <input type="submit" value="Go" name="" class="clsSearchButton" />
						 </form>
					   </div>
				 {/if}
				  {* ---------------BLOG SEARCH BLOCK ENDS ----------------------------------*}

				  {* ---------------BLOG USER INFO BLOCK BEGINS -----------------------------*}
						  {$myobj->getBlogDetails($myobj->getFormField('blog_id'))}
				  {* ---------------BLOG USER INFO BLOCK ENDS ------------------------------*}

				  {* ------------------ BLOG CATEGORY SECTION STARTS ---------------------- *}
						  {$myobj->populateBlogCategory($myobj->getFormField('blog_id'),$myobj->getFormField('blog_name'))}
				  {* -------------------BLOG CATEGORY SECTION ENDS -------------------------*}

				  {* ---------------BLOG ARCHIVE BLOCK BEGINS -----------------------------*}
					  {$myobj->getArchiveBlogYearDetails($myobj->getFormField('blog_id'),$myobj->getFormField('blog_name'))}
				  {* ----------------- ARCHIVE BLOCK ENDS ---------------------------------*}

				  {* ---------------BLOG TAGS BLOCK BEGINS -----------------------------*}
					  {$myobj->populateSidebarClouds('blog', 'blog_tags',$myobj->getFormField('blog_id'),$myobj->getFormField('blog_name'))}
				  {* --------------- BLOG TAGS BLOCK ENDS ------------------------------*}

			</div>
			</div>
	<div id="blogmain" class="clsViewPostLeft">
	    <div id="selViewBlog">
		   {$myobj->setTemplateFolder('general/','blog')}
			 {include file='box.tpl' opt='display_top'}
		 <div class="clsOverflow">
		 	<div class="clsPageHeading clsFloatLeft">
		 	<h2><span>{$LANG.viewblog_title}</span></h2>
			</div>
		 </div>
        {if $myobj->isShowPageBlock('blog_view_blog')}
       			 <div class="clsLeftSideDisplayTable">
                        {if $myobj->isResultsFound()}
                            {if $CFG.admin.navigation.top}
                                {$myobj->setTemplateFolder('general/','blog')}
                                {include file='pagination.tpl'}
                            {/if}
                            <div id="selDisplayTable">
                            <div class="clsPageHeading"></div>
                              {foreach key=salKey item=salValue from=$showBlogDetail_arr}
							  	<div class="clsOverflow">
									<div class="clsDateBlogBg">
										<p class="clsYear">{$salValue.year}</p>
										<p class="clsMonth">{$salValue.month}</p>
										<p class="clsDate">{$salValue.date}</p>
								</div>
                                	<div class="clsDetailsBlogListContent">
                                     <div class="clsOverflow">
                                       <h3 class="clsViewTitleLink clsFloatLeft">
                                         <a href="{$salValue.view_blog_post_link}">{$salValue.blog_post_name_manual|capitalize}</a>
                                       </h3>
                                       </div>
                                        <div class="clsPostContent">{$salValue.message}</div>
									</div>
								</div>
									<div class="clsBlogCategoryRate">
                                    <div class="clsOverflow clsTagsCategory">
											<div class="clsFloatLeft">
                                            <span class="clsBlogTagDetails clsBlogViewDetails">
                                                {if $myobj->getFormField('post_keyword') != ''}
                                                    {assign var=blog_tags value=$myobj->getFormField('post_keyword')}
                                                {elseif $myobj->getFormField('tags') != '' }
                                                    {assign var=blog_tags value=$myobj->getFormField('tags')}
                                                {else}
                                                    {assign var=blog_tags value=''}
                                                {/if}
                                                <span class="clsTagBg">{$LANG.viewblog_search_blogpost_tags}:&nbsp;</span>
                                                {if $salValue.record.blog_tags!=''} {$myobj->getBlogPostsTagsLinks($salValue.record.blog_tags, 13, $blog_tags)}{/if}
                                            </span>
											</div>
											<div class="clsFloatRight">
	                                            <span class="clsBlogViewDetails">
													<span class="">{$LANG.viewblog_blog_category_name}:&nbsp;</span>
													<span class="clsBlogValues"><a href="{$salValue.blog_category_url}">{$salValue.blog_category_name_manual}</a></span>
	                                            </span>
											</div>
                                        </div>
  								    <div class="clsOverflow">
                                                        <div class="clsRatingLeft">
															<div class="clsRatingRight">
																<div class="clsRatingCenter">
																	<div class="clsFloatLeft clsUserImageBorder">
																		by <a href="{$salValue.member_profile_url}"><img src="{$salValue.profileIcon.s_url}" title="{$salValue.name}" {$myobj->DISP_IMAGE(15, 15, $salValue.width, $salValue.height)}/>&nbsp;{$salValue.name|capitalize}</a
																	></div>
																	<div class="clsFloatRight">
										    <p class="clsRatingDisplay">
											 <span class="clsBoldFont"><a href="{$salValue.view_blog_post_link}">{$salValue.record.total_comments}</a></span>
                                               {if $salValue.record.total_comments > 1}{$LANG.viewblog_total_comments}{else}{$LANG.viewblog_total_comment}{/if}&nbsp;|&nbsp;
                                              <span class="clsBoldFont">{$salValue.record.total_views}</span>
                                               {if $salValue.record.total_views > 1}{$LANG.viewblog_total_views}{else}{$LANG.viewblog_total_view}{/if}&nbsp;|&nbsp;
                                                {if $myobj->populateRatingDetails($salValue.record.rating)}
                                                    {$myobj->populateBlogRatingImages($salValue.record.rating,'blog')}
                                                {else}
                                                   {$myobj->populateBlogRatingImages(0,'blog')}
                                                {/if}
												</p>
                                            </div>
											</div></div></div>
                                        </div>
									</div>
                              {/foreach}
                            </div>
                            {if $CFG.admin.navigation.bottom}
                                {$myobj->setTemplateFolder('general/','blog')}
                                {include file='pagination.tpl'}
                            {/if}
                        {else}
                        	<div class="clsPageHeading"><h2><span>{$LANG.viewblog_title}</span></h2></div>
                            <div id="selMsgAlert">
                                <p>{$LANG.viewblog_no_records_found}</p>
                            </div>
                        {/if}
                    </div>
        {/if}{* end of blog_view_blog condition *}

		   {$myobj->setTemplateFolder('general/','blog')}
			 {include file='box.tpl' opt='display_bottom'}
    </div>
    </div>

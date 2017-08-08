{$myobj->setTemplateFolder('general/','blog')}
{include file='information.tpl'}

{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_top'}  
	<div id="selBlogList">
	<!--rounded corners-->
        {if $myobj->isShowPageBlock('block_blog_list_form')}
        		{if $myobj->isResultsFound()}
                    {if $CFG.admin.navigation.top}
                        {$myobj->setTemplateFolder('general/','blog')}
                        {include file='pagination.tpl'}
                     {/if}
                     
                     <div id="selDisplayTable">
                           {foreach key=salKey item=salValue from=$showBlogSearchList_arr}
                           <div class="clsBlogListContent">
                           		<div class="clsHomeDispContent"> 
                                  <h3 class="clsTitleLink">
                                  <a href="{$salValue.view_blog_link}">{$salValue.blog_name}</a>&nbsp;&nbsp;	
                                  </h3>
                                  <div class="clsBlogDetails">
                                  	 <p class="clsBlogViewDetails">
                                     	<a class="clsViewBlogUser" href="{$salValue.member_profile_url}">{$salValue.name}</a>&nbsp;|&nbsp;
                                        {$LANG.bloglist_date_added}:&nbsp;
	                                    <span class="clsBoldFont">{$salValue.date_added}</span>
                                     </p>
                                     <div>{$LANG.bloglist_recent_post_title}</div>                                    
                                     {if $salValue.postList_arr.record_count}
                                      <div class="clsPostContent">
                                     {$salValue.postList_arr.message}
                                      &nbsp;<span><a href="{$salValue.postList_arr.view_blog_post_link}">{$LANG.bloglist_post_read_more}</a></span>
                                      </div>
                                      <p>
                                      {$LANG.bloglist_post_post_posted_on}:&nbsp;<span class="clsBoldFont">{$salValue.postList_arr.record.date_added}</span>&nbsp;|&nbsp;
                                      <span class="clsBlogValues">{$salValue.postList_arr.record.total_comments}</span>
                                      {if $salValue.postList_arr.record.total_comments > 1}{$LANG.bloglist_post_comments}{else}{$LANG.bloglist_post_comment}{/if}&nbsp;|&nbsp;
                                       <span class="clsBoldFont">{$salValue.postList_arr.record.total_views}</span>
                                       {if $salValue.postList_arr.record.total_views > 1}{$LANG.bloglist_post_views}{else}{$LANG.bloglist_post_view}{/if}&nbsp;
                                      </p>
                                      <p class="clsBlogTagDetails">                                   
                                        {assign var=blog_tags value=''}
                                        <span>{$LANG.blolist_blogpost_tags}:</span>{if $salValue.postList_arr.record.blog_tags!=''} 
                                        {$myobj->getBlogPostsTagsLinks($salValue.postList_arr.record.blog_tags, 13, $blog_tags)}{/if}
										&nbsp;|&nbsp;
                                        <span>{$LANG.bloglist_blogpost_category_name}: </span><span class="clsBlogValues">{$salValue.postList_arr.blog_category_name_manual}</span>
                                      </p>	                                    			
                                      <p class="clsRatingDisplay">
                                        {if $myobj->populateRatingDetails($salValue.postList_arr.record.rating)}
                                            {$myobj->populateBlogRatingImages($salValue.postList_arr.record.rating,'blog')}
                                        {else}
                                           {$myobj->populateBlogRatingImages(0,'blog')}
                                        {/if}
                                      </p>
                                      {else}
                                       <p class="clsNoPostFound">{$LANG.bloglist_no_post_found}</p> 
                                      {/if}
                                                                        
                                  </div>
                                </div>
                            </div>
                           {/foreach}
                     </div>     
                                     
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

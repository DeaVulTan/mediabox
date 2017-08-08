
    <div class="clsOtherBlocksContent">
        <div class="clsBlogContent">
		  <div class="clsIndexBlogContent">
            <h3>{$LANG.recent_blogs}</h3>
            {if isset($populateBlogRecentBlock_arr.row) && ($populateBlogRecentBlock_arr.row)}
                {foreach from=$populateBlogRecentBlock_arr.row item=detail key=caption}
                <div class="clsOtherBlockContentList">
                    <p class="clsTitle"><a href="{$detail.view_blog_post_link}">{$detail.record.blog_post_name}</a></p>
                    <p class="clsPostedName">({$LANG.in_blogs}: <a href="{$detail.view_blog_link}" title="{$detail.record.blog_name}">{$detail.record.blog_name}</a>)</p>
                    <div class="clsOtherBlockMainContent">{$detail.message}</div>
                    {include file="box.tpl" opt="othercontent_top"}
                        <div class="clsOverflow">
                            <div class="clsMembersName">by <img src="{$detail.member_icon.t_url}" alt="{$detail.name}" title="{$detail.name}" {$myobj->DISP_IMAGE(66, 66, $detail.member_icon.t_width, $detail.member_icon.t_height)} /> <a href="{$detail.member_profile_url}">{$detail.name}</a></div>
                            <div class="clsContentDetails">
                                <ul class="clsFloatRight">
                                	<li>{$detail.record.published_date}</li>
                                    <li><span>{$detail.record.total_comments}</span> {$LANG.common_comment}</li>
                                    <li><span>{$detail.record.total_views}</span>  {$LANG.common_views}</li>
                                    <li class="clsBackgroundNone"><span>{$detail.record.total_favorites}</span>  {$LANG.common_favourites}</li>
                                </ul>
                            </div>
                        </div>
                    {include file="box.tpl" opt="othercontent_bottom"}
                </div>
                {/foreach}
            {else}
            	<div class="clsNoRecordsFound">{$LANG.common_no_records_found}</div>
            {/if} 
			</div>
            {if isset($populateBlogRecentBlock_arr.row) && ($populateBlogRecentBlock_arr.row)}           
            	<div class="clsViewAll">
               		 <a href="{$populateBlogRecentBlock_arr.blog_url}">{$LANG.common_viewall_blogs}</a>
            	</div>
            {/if}
        </div>
    </div>

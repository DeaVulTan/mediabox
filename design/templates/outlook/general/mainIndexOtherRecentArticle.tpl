
    <div class="clsOtherBlocksContent">
        <div class="clsArticleContent">
		  <div class="clsIndexArticleContent">
            <h3>{$LANG.recent_articles}</h3>
            {if isset($populateCarousalarticleBlock_arr.row) && ($populateCarousalarticleBlock_arr.row)}
                 {foreach from=$populateCarousalarticleBlock_arr.row item=detail key=caption}
                <div class="clsOtherBlockContentList">
                    <p class="clsTitle"><a href="{$detail.view_article_link}">{$detail.record.article_title}</a></p>
                    <div class="clsOtherBlockMainContent">{$detail.record.article_summary}</div>
                    {include file="box.tpl" opt="othercontent_top"}
                        <div class="clsOverflow">
                            <div class="clsMembersName">by <img src="{$detail.member_icon.t_url}" alt="{$detail.name}" title="{$detail.name}" {$myobj->DISP_IMAGE(66, 66, $detail.member_icon.t_width, $detail.member_icon.t_height)} /> <a href="{$detail.member_profile_url}">{$detail.name}</a></div>
                            <div class="clsContentDetails">
                                <ul class="clsFloatRight">
                                	<li>{$detail.record.published_date}</li>
                                    <li><span>{$detail.record.total_comments}</span> {$LANG.common_comment}</li>
                                    <li><span>{$detail.record.total_views}</span>  {$LANG.common_views}</li>
                                    <li><span>{$detail.record.total_favorites}</span>  {$LANG.common_favourites}</li>
                                    <li class="clsBackgroundNone"><span>{$detail.record.total_downloads}</span> {$LANG.common_downloads}</li>
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
            {if isset($populateCarousalarticleBlock_arr.row) && ($populateCarousalarticleBlock_arr.row)}
            	<div class="clsViewAll">
                	<a href="{$populateCarousalarticleBlock_arr.view_all_articles_link}">{$LANG.common_viewall_articles}</a>
            	</div>
            {/if}
        </div>
    </div>

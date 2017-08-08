{if $myobj->isShowPageBlock('populate_related_article')}
    {if $populateRelatedArticle_arr.total_records}
        <div>
            {foreach key=rowKey item=rowValue from=$populateRelatedArticle_arr.row}
          <div class="clsMoreArticleDisplay">
                        <p class="clsMoreArticleTitle"><a href="{$rowValue.article_title_url}">{$rowValue.article_title}</a></p>
                        <p class="clsMoreArticleInfo">{$rowValue.article_summary}</p>
                        <p class="clsMoreArticleDetails">{$LANG.viewarticle_from}&nbsp;<a href="{$rowValue.memberProfileUrl}">{$rowValue.name}</a><span class="clsLinkSeperator">|</span><span>{$LANG.viewarticle_views}</span>&nbsp;{$rowValue.row_total_views}</p>
         </div>
            {/foreach}

            {if $populateRelatedArticle_arr.total_records == $CFG.admin.articles.total_related_article && $populateRelatedArticle_arr.pg!='tag'}
                <div class="clsMoreArticleLinks">
                  <a href="{$populateRelatedArticle_arr.more_link}">{$LANG.viewarticle_see_all_articles}</a>
                </div>
            {/if}
          </div>
    {else}
        <div class="clsNoArticlesFound">
               <p>{$LANG.viewarticle_no_related_articles_found}</p>
        </div>
    {/if}
{/if}
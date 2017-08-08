{if chkAllowedModule(array('article'))}
<div class="clsArticleInfoTable">
<table cellspacing="0" {$myobj->defaultTableBgColor}>
        <tr>
          <th {$myobj->defaultBlockTitle} >
          <div class="clsArticleInfoTitle">{$LANG.myprofile_shelf_articles}</div>
          {if !empty($article_list_arr)}
          		<div class="clsArticleInfoLink"><a href="{$userarticlelistURL}" >{$LANG.myprofile_link_view_articles}</a></div>
           {/if}
          </th>
        </tr>
        {if empty($article_list_arr)}
        <tr>
          <td><div id="profileCommentsResponse"><div class="clsProfileTableInfo"><div id="selMsgAlert" class="clsNoArticlesFound">
              <p>{$LANG.myprofile_articles_no_msg}</p>
            </div></div></div></td>
        </tr>
        {else}
        <tr>
          <td id="profileCommentsSection">
          		<div id="profileCommentsResponse">
                <table class="clsArticleInfo" id="{$CFG.profile_box_id.myarticles_list}">
                 {foreach key=item item=value from=$article_list_arr}
                  <tr>
                    <td id="selProfileComment">
                        <div class="clsArticleInfoContent">
                            <div class="clsArticleInfoThumbDetails">
                                <p>
                                    <a href="{$value.articleUrl}">{$value.wrap_article_title}
                                    </a>
                                </p>
                                <p><span>{$value.wrap_article_summary}</span></p>
                                <p>{$LANG.myprofile_article_date_published}:&nbsp;{$value.published_date}</p>
                                <p>
                                    {$value.total_comments}&nbsp;{if $value.total_comments > 1}{$LANG.myprofile_article_comments}{else}{$LANG.myprofile_article_comment}{/if}
                                    &nbsp;|&nbsp;{$value.total_views}&nbsp;{if $value.total_views > 1}{$LANG.myprofile_article_views}{else}{$LANG.myprofile_article_view}{/if}
                                    &nbsp;|&nbsp;{$value.total_favorites}&nbsp;{if $value.total_favorites > 1}{$LANG.myprofile_article_favorites}{else}{$LANG.myprofile_article_favorite}{/if}
                                    {if $value.article_attachment}&nbsp;|&nbsp;<span>{$value.total_downloads}</span>&nbsp;{if $value.total_downloads > 1}{$LANG.myprofile_article_downloads}{else}{$LANG.myprofile_article_download}{/if}{/if}
                                </p>
                            </div>
                        </div>
                    </td>
                  </tr>
                  {/foreach}
                </table>
                </div>
          </td>
        </tr>
        {/if}{* article_list_arr condition closed *}
 </table>
 </div>
 {/if}
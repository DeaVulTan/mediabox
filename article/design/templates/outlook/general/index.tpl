<!--rounded corners-->

{* ----------------------Index Article list Content Starts ---------------------- *}
{$myobj->setTemplateFolder('general/','article')}
{include file='box.tpl' opt='article_list_top'}
<form id="articleListIndexForm" name="articleListIndexForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
<input type="hidden" name="advanceFromSubmission" value="1"/>
<div class="clsOverflow clsIndexContainer">
  <div class="clsArticleListHeading">
    <h2>{$LANG.index_articlelist_title|capitalize:true}</h2>
  </div>
  <div class="clsArticleListHeadingRight">
    <input type="hidden" value="" />
    <select name="select" onchange="loadUrl(this)" id="articleselect">
      <option value="{php} echo getUrl('index','?pg=articlerecent','?pg=articlerecent','','article'){/php}" {if $myobj->getFormField('pg')==''} selected {/if}>{$LANG.sidebar_article_most_recent}</option>
      <option value="{php} echo getUrl('index','?pg=articletoprated','?pg=articletoprated','','article'){/php}" {if $myobj->getFormField('pg')=='articletoprated'} selected {/if}>{$LANG.sidebar_article_top_rated}</option>
      <option value="{php} echo getUrl('index','?pg=articlemostviewed','?pg=articlemostviewed','','article'){/php}" {if $myobj->getFormField('pg')=='articlemostviewed'} selected {/if} >{$LANG.sidebar_article_most_viewed}</option>
      <option value="{php} echo getUrl('index','?pg=articlemostdiscussed','?pg=articlemostdiscussed','','article'){/php}" {if $myobj->getFormField('pg')=='articlemostdiscussed'} selected {/if}>{$LANG.sidebar_article_most_discussed}</option>
      <option value="{php} echo getUrl('index','?pg=articlemostfavorite','?pg=articlemostfavorite','','article'){/php}" {if $myobj->getFormField('pg')=='articlemostfavorite'} selected {/if}>{$LANG.sidebar_article_most_favorite}</option>
    </select>
  </div>
</div>
<div id="selLeftNavigation">
  {if $populateCarousalarticleBlock_arr.row}
	  {foreach key=salKey item=salValue from=$populateCarousalarticleBlock_arr.row}
	  <div class="clsArticleListContent">
	    <div class="clsHomeDispContent">
	      <div class="clsOverflow clsArticleHeader">
              <h3 class="clsTitleLink"><a href="{$salValue.view_article_link}" title="{$salValue.wordWrap_mb_ManualWithSpace_article_title}">{$salValue.wordWrap_mb_ManualWithSpace_article_title}</a></h3>
          </div>
	      <div class="clsArticleDetails">
              <p>{$LANG.index_article_date_published}&nbsp;:&nbsp;<span>{$salValue.record.date_published}</span></p>
	      		<p>
	                <a href="{$salValue.member_profile_url}">
	                     <span class="clsUserProfileImage"></span>
	                </a>
	      		</p>
	            <p class="clsViewTagsLink">
	            	{$salValue.article_caption_manual}&nbsp;
                    {*
                    <a href="{$salValue.view_article_link}">{$LANG.index_article_view_full_article}</a>
                    *}
	            </p>
	            <p class="clsArticleIndexTagDetails">
	            	<span>
	                	{$LANG.index_article_tags}:
	                </span>
	                {if $salValue.record.article_tags!=''} {$myobj->getArticleTagsLinks($salValue.record.article_tags, 10)}{/if}
	            </p>
                <div class="clsArticleDetMiddle">
                	<div class="clsArticleDetLeft">
                    	<div class="clsArticleDetRight clsOverflow">
                        	<div class="clsArticleUser">
                                <p class="">
                                    {$LANG.index_by_label}&nbsp;
                                    <a href="{$salValue.member_profile_url}" class="cls15x15 clsImageBorder ClsImageContainer">
                                    <img src="{$salValue.member_icon.s_url}" border="0" alt="{$salValue.name}" title="{$salValue.name}"  {$myobj->DISP_IMAGE(15, 15, $salValue.member_icon.s_width, $salValue.member_icon.s_height)}/></a>
                                    <a href="{$salValue.member_profile_url}" title="{$salValue.name}">
									{$salValue.name}</a>
                                </p>
                            </div>
                            <div class="clsArticleListDetails">
                                <ul>
                                	{*{$LANG.index_article_date_published}&nbsp;:&nbsp;*}{*<span>{$salValue.record.date_published}</span>&nbsp;|&nbsp;*}
                                    <li>
                                        <span class="clsTotalComment">{$salValue.record.total_comments}</span>&nbsp;{if $salValue.record.total_comments > 1}{$LANG.index_article_comments}{else}{$LANG.index_article_comment}{/if}
                                    </li>
                                    <li>
                             	       <span>{$salValue.record.total_views}</span>&nbsp;{if $salValue.record.total_views > 1}{$LANG.index_article_views}{else}{$LANG.index_article_view}{/if}
                                    </li>
                                    <li>
                                        <span>{$salValue.record.total_favorites}</span>&nbsp;{if $salValue.record.total_favorites > 1}{$LANG.index_article_favorites}{else}{$LANG.index_article_favorite}{/if}
                                    </li>
                                    {if $salValue.record.article_attachment}
                                        <li>
                                            <span>{$salValue.record.total_downloads}</span>&nbsp;{if $salValue.record.total_downloads > 1}{$LANG.index_article_downloads}{else}{$LANG.index_article_download}{/if}
                                        </li>
                                    {/if}
                                    <li class="clsRatingDisplay">
                                        {if $myobj->populateRatingDetails($salValue.record.rating)}
                                            {$myobj->populateArticleRatingImages($salValue.record.rating,'article')}
                                        {else}
                                           {$myobj->populateArticleRatingImages(0,'article')}
                                        {/if}
                                        (<span>{$salValue.record.rating_count}</span>)
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
	      </div>
	    </div>
	  </div>
	  {/foreach}
	  	<div class="clsMoreLink"><h3 class=""><a href="{$populateCarousalarticleBlock_arr.view_all_articles_link}" title="{$LANG.index_article_see_all_articles}">{$LANG.index_article_see_all_articles}</a></h3></div>
  {else}
  	<div id="selMsgAlert" class="clsNoArticlesFound">
    	<p>{$LANG.index_article_no_articles_found}</p>
    </div>
  {/if}
</div>
</form>
{$myobj->setTemplateFolder('general/','article')}
{include file='box.tpl' opt='article_list_bottom'}

{* ----------------------Index Article List Content Ends ---------------------- *}

{*{$myobj->setTemplateFolder('general/','article')}
{include file='box.tpl' opt='article_list_top'}*}

{* ----------------------Activities Content Starts ---------------------- *}
{* {if $myobj->isShowPageBlock('sidebar_activity_block')}
{$myobj->setTemplateFolder('general/', 'article')}
<div class="clsIndexMainContainer">{include file="indexActivityHead.tpl"}</div>
{/if} *}
{* ----------------------Activities Content ends ---------------------- *}

{*{$myobj->setTemplateFolder('general/','article')}
{include file='box.tpl' opt='article_list_bottom'}*}
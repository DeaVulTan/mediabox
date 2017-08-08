{literal}
<script language="javascript" type="text/javascript">
	function toggleVideoPostCommentOption(){
		$Jq("#selEditMainComments").toggle('slow');
	}
	$Jq("#tabs").tabs();
</script>
{/literal}
{if $myobj->isShowPageBlock('articleMainBlock')}

    <div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
        <h3 id="confirmationMsg"></h3>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
            <input type="button" class="clsSubmitButton" name="confirm_action" id="confirm_action" onclick="deleteCommandOrReply();" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
            &nbsp;
            <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
            <input type="hidden" name="comment_id" id="comment_id" />
            <input type="hidden" name="maincomment_id" id="maincomment_id" />
            <input type="hidden" name="commentorreply" id="commentorreply" />
        </form>
    </div>
	<div class="clsViewArticlePage">
	    <div class="clsViewArticleContent">
            {if !isAjaxpage()}
                <div id="selViewArticle">
                   <div id="selLeftNavigation">
            {/if}
           {* <div class="clsArticlePagingContainer">
                <div class="clsGoBackIcon">{$myobj->getRefererUrl()}</div>
                <div class="clsPagingList">
                    <ul>
                       {$myobj->getPreviousLink()}
                       {$myobj->getNextLink()}
                    </ul>
                </div>
            </div>*}

        {$myobj->setTemplateFolder('general/','article')}
    	{include file='box.tpl' opt='articlecontent_top'}


        {if $myobj->isShowPageBlock('confirmation_flagged_form')}
            <div id="flaggedForm" class="clsFlaggedForm">
              <p>{$LANG.viewarticle_flagged_msg}</p>
              	<div class="clsSubmitLeft">
					<span class="clsSubmitRight">
                    	<a href="{$myobj->confirmation_flagged_form.viewarticle_url}" title="{$LANG.viewarticle_flagged}">{$LANG.viewarticle_flagged}</a>
                    </span>
                </div>
            </div>
        {/if}
	   {if $myobj->isShowPageBlock('confirmation_adult_form')}
        <div id="selAdultUserForm">
          <p>{$myobj->replaceAdultText($LANG.viewarticle_confirmation_alert_text)}</p>
          <p>
            <a href="{$confirmation_adult_form_arr.view_article_accept_url}" title="{$LANG.viewarticle_accept}">{$LANG.viewarticle_accept}</a>&nbsp;&nbsp;
            <a href="{$confirmation_adult_form_arr.view_article_view_url}" title="{$LANG.viewarticle_accept_this_page_only}">{$LANG.viewarticle_accept_this_page_only}</a>&nbsp;&nbsp;
            <a href="{$confirmation_adult_form_arr.view_article_reject_url}" title="{$LANG.viewarticle_reject}">{$LANG.viewarticle_reject}</a>&nbsp;&nbsp;
            <a href="{$myobj->getUrl('index')}" title="{$LANG.viewarticle_reject_this_page_only}">{$LANG.viewarticle_reject_this_page_only}</a>
          </p>
        </div>
	 {/if}

         {if $myobj->isShowPageBlock('articles_form') and $myobj->validate}
                <div id="selViewArticleFrm">
                   <div id="article_content">
<div id="selArticlePlayerCell">
            	<div class="clsOverflow">
                    <h3 class="clsViewArticleHeading">{$myobj->getFormField('article_title')}</h3>
                    <div class="clsViewArticleRanking">
                        {*{if $myobj->getFormField('allow_ratings') =='Yes'}*}
                          {if $myobj->chkAllowRating()}
                            <div id="ratingForm">
                                {assign var=tooltip value=""}
                                {if !isLoggedIn()}
                                    {$myobj->populateRatingImages($myobj->article_rating, 'article',$LANG.viewarticle_login_message, $myobj->memberviewArticleUrl, 'article')}
                                    {assign var=tooltip value=$LANG.viewarticle_login_message}
                                {else}
                                    <span id="selRatingArticle" class="clsArticle1Rating">
                                        {if isMember() and $myobj->rankUsersRayzz}
                                            {$myobj->populateRatingImagesForAjax($myobj->article_rating, 'article')}
                                        {else}
                                            {$myobj->populateRatingImages($myobj->article_rating, 'article', $LANG.viewarticle_rate_yourself, '#', 'article')}
                                            {assign var=tooltip value=$LANG.viewarticle_rate_yourself}
                                        {/if}
                                        <span>
                                            ({$myobj->getFormField('rating_count')})
                                            {*{if $myobj->getFormField('rating_count') > 1}{$LANG.viewarticle_total_ratings}
                                            {else}
                                            {$LANG.viewarticle_total_rating}{/if})*}
                                        </span>
                                    </span>
                                {/if}
                                <script type="text/javascript">
								  {literal}
								  $Jq(document).ready(function(){
								    $Jq('#ratingLink').attr('title','{/literal}{$tooltip}{literal}');
								  	$Jq('#ratingLink').tooltip({
															track: true,
															delay: 0,
															showURL: false,
															showBody: " - ",
															extraClass: "clsToolTip",
															top: -10
														});
										});
									{/literal}
                          		</script>
                            </div>
                        {/if}
                      </div>
                </div>
				<a id="dAltMulti" href="#"></a>


            </div><!-- end of div7 selArticlePlayerCell -->
          </div>


        {$myobj->setTemplateFolder('general/','article')}
        {include file='information.tpl'}
                     <div class="clsOverflow">
                            <div class="clsViewArticleContainer">
                                    <div>
                                        {if $myobj->getFormField('article_status') != 'Ok'}
                                            <p class="clsUnderPublished">{$LANG.viewarticle_preview_article_msg}</p>
                                        {/if}
                                    </div>
                                    <div class="clsOverflow clsArticleUserAction">
                                        <div class="clsAritcleInfo">
                                            <ul>
                                                <li>
                                                     <span>{$LANG.viewarticle_views}</span><span class="clsEmberRatingLeft"><span class="clsEmberRatingRight">{$myobj->getFormField('total_views')}</span></span>
                                                </li>
                                                <li>
                                                      <span>{$LANG.viewarticle_comments}</span><span class="clsEmberRatingLeft"><span class="clsEmberRatingRight">{$myobj->getFormField('comments')}</span></span>
                                                </li>
                                                <li>
                                                      <span>{$LANG.viewarticle_favorited}</span><span class="clsEmberRatingLeft"><span class="clsEmberRatingRight">{$myobj->getFormField('favorited')}</span></span>
                                                </li>
                                            </ul>
                                         </div>
                                         <div class="clsEditArticle">
                                            {*******Show edit Article link *}
                                            {if $displayArticle_arr.article_writing_url_ok}
                                              <a href="{$displayArticle_arr.article_writing_url_ok}" class="clsPhotoArticleEditLinks" title="{$LANG.viewarticle_edit_article}">{$LANG.viewarticle_edit_article}</a>
                                            {/if}
                                         </div>
                                     </div>

                                     {* content to be loaded via ajax starts here *}

                                      {if (!isAjaxPage()) }
                            				{$myobj->setTemplateFolder('general/', 'article')}
                            				{include file='viewArticleContent.tpl'}
                            		  {/if}

                                    {* content to be loaded via ajax starts here *}


                                    {* --No longer used-- *}
                                    {if $displayArticle_arr.read_more}
                                        <div align="right" style="padding-right:20px;">
                                            <p>
                                            <a href="{$displayArticle_arr.viewmore_link}" title="{$LANG.viewarticle_read_more}">{$LANG.viewarticle_read_more}</a>
                                            </p>
                                        </div><br />
                                   {/if}
                                   {* --No longer used-- *}

								{* Added condition to show article attchemnts to download if article status is set OK *}
								{if $myobj->getFormField('article_status') == 'Ok'}
                                   {if $displayArticle_arr.article_attachment}
                                        <div class="clsAttachmentArticle">
                                             <h3>{$LANG.viewarticle_attachments}</h3>
                                             <div id="attachments">
                                                {foreach key=gadKey item=gadValue from=$getAttachmentDetails.row}
                                                    <p>{$gadKey}. <a href="{$gadValue.download_url}" title="{$gadValue.record.file_name}">{$gadValue.record.file_name}</a></p>
                                                {/foreach}
                                             </div>
                                        </div>
                                   {/if}
                                {/if}
                                    <!-- COMMENTS BLOCK STARTED HERE-->
                                    {* Added condition to display comments block if article status is set OK *}
                                   	{if $myobj->getFormField('article_status') == 'Ok'}
                                    <div class="clsViewComments">
                                            <div class="clsCommentTitle">
                                                <h3>{$LANG.viewarticle_comments}
                                               		(<span class="clsCommentsCount" id="selVideoCommentsCount">{$myobj->getFormField('total_comments')}</span>)
                                                </h3>
                                            </div>
                                			{$myobj->setTemplateFolder('general/','article')}
                                			{include file='box.tpl' opt='viewcomments_top'}
                                            <div class="clsPostCommentHeading clsOverflow">
                                                {if $myobj->getFormField('allow_comments')=='Kinda' OR $myobj->getFormField('allow_comments')=='Yes'}
                                                    {if isMember()}
                                                            <p id="selViewPostComment" class="clsPostComment clsOverflow">
                                                                <a class="" id="selPostVideoComment" href="{$myobj->getCurrentUrl()}" onclick="toggleVideoPostCommentOption(); return false;" title="{$LANG.viewarticle_post_comment}">
                                                                <span>{$LANG.viewarticle_post_comment}</span>
                                                                </a>

                                                            </p>
                                                    {else}
                                                        <div class="clsOverflow">
                                                            <p id="selViewPostComment" class="clsPostComment">
                                                                <a class="" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_video_login_post_comment_msg}', '{$myobj->notLoginArticleUrl}')">
                                                                    <span>{$LANG.viewarticle_post_comment}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.approval}){/if}
                                                                </a>
                                                            </p>
                                                        </div>
                                                    {/if}
                                                    {include file='addComments.tpl'}
                                                {/if}
                                            </div>
                                        {if isMember()}
                                            {if $myobj->getFormField('allow_comments')=='Kinda'}
                                               <div class="clsOverflow"><div class="clsPostCommentHeading clsVideVideoHeadingRight">({$LANG.approval})</div></div>
                                            {/if}
                                        {/if}
                                        {*$myobj->populateCommentOfThisArticle()*}
                                        <div id="selMsgSuccess" style="display:none">
                                            <p id="kindaSelMsgSuccess"></p>
                                        </div>
                                        <div id="selCommentBlock" class="clsViewVideoDetailsContent">
                                            {$myobj->populateCommentOfThisArticle()}
                                        </div>
                                		{$myobj->setTemplateFolder('general/','article')}
                                		{include file='box.tpl' opt='viewcomments_bottom'}
                                    </div>
                                    {/if}
                                    <!-- COMMENTS BLOCK END HERE -->
                                </div>
                            <div class="clsViewArticleContentDet">
                                <div id="selArticleInfo">
                                  <!-- For rounded corners -->
                                    {$myobj->setTemplateFolder('general/','article')}
                                     {include file='box.tpl' opt='article_rank_top'}
                                          <div id="selArticleInfoDisplay" class="clsOverflow">
                                              <!--<div class="clsOverflow">-->
                                                 {* <div id="clsDownloadSection" class="clsArticleShare">
                                                      <!-- For rounded corners -->
                                                       {$myobj->setTemplateFolder('general/','article')}
                                                       {include file='box.tpl' opt='download_top'}
                                                          <div id="selDownloadContent">
                                                            {$myobj->populateBlogPost($displayArticle_arr.blog_post_url, $myobj->getFormField('article_title'), $LANG.viewarticle_post_article)}
                                                          </div>
                                                       {$myobj->setTemplateFolder('general/','article')}
                                                       {include file='box.tpl' opt='download_bottom'}
                                                      <!--end of rounded corners-->
                                                  </div>*}
                                             <!-- </div>-->
                                              <div class="clsOverflow">
                                              <div class="clsAritcleInfoMember">
                                                    <a href="{$displayArticle_arr.member_profile_url}" class="Cls45x45 ClsImageBorder2 ClsImageContainer">
                                                        <img src="{$displayArticle_arr.member_icon_url.s_url}" alt="{$myobj->getFormField('name')|truncate:5}" title="{$myobj->getFormField('name')}" {$myobj->DISP_IMAGE(45, 45, $displayArticle_arr.member_icon_url.s_width, $displayArticle_arr.member_icon_url.s_height)} />
                                                    </a>
                                               </div>
                                               <div class="clsAritcleInfoDet">
                                                  <p>
                                                   {$LANG.viewarticle_added_by}&nbsp;<a href="{$displayArticle_arr.member_profile_url}" title="{$myobj->getFormField('name')}">{$myobj->getFormField('name')}</a>
                                                   &nbsp;|
                                                   &nbsp;{if $myobj->getFormField('article_status') == 'Ok'}{$LANG.viewarticle_published_date}
                                                   &nbsp;<span>{$myobj->getFormField('date_of_publish')}</span>{else}{$LANG.viewarticle_added_date}
                                                   &nbsp;<span>{$myobj->getFormField('date_added')}</span>{/if}

                                                   {*
                                                   &nbsp;{$LANG.viewarticle_views}&nbsp;{$myobj->getFormField('total_views')}&nbsp;<span>|</span>
                                                   &nbsp;{$LANG.viewarticle_comments}&nbsp;{$myobj->getFormField('comments')}&nbsp;<span>|</span>
                                                   &nbsp;{$LANG.viewarticle_favorited}&nbsp;{$myobj->getFormField('favorited')}&nbsp;<span>|</span>
                                                   &nbsp;{$LANG.viewarticle_category}&nbsp;
                                                    {if $displayArticle_arr.getChannelOfThisArticle_arr}
                                                        <a href="{$displayArticle_arr.getChannelOfThisArticle_arr.channel_url}" title="{$displayArticle_arr.getChannelOfThisArticle_arr.article_category_name}">{$displayArticle_arr.getChannelOfThisArticle_arr.article_category_name}</a>
                                                    {/if} *}
                                                   <!-- &nbsp;<span>|</span>&nbsp;{$LANG.viewarticle_rating}:<span id="articleRating">{$myobj->article_rating}</span>-->
                                                  </p>

                                                  <p class="clsArticleUser">Article by this user: <span>{$displayArticle_arr.total_article}</span></p>
                                              </div>
                                              </div>
                                          </div>
                                        {* ****** Show Tags ******** *}
                                        <div class="clsArticleTags clsTagsLink">
                                            <p>{$LANG.viewarticle_tags}
                                                {foreach key=gtaKey item=gtaValue from=$displayArticle_arr.getTagsOfThisArticle_arr}
                                                    <a href="{$gtaValue.url}" title="{$gtaValue.tags}">{$gtaValue.tags}</a>
                                                {/foreach}
                                            </p>
                                        </div>
                                        {* ****** End of Show Tags ******** *}
                                     {$myobj->setTemplateFolder('general/','article')}
                                    {include file='box.tpl' opt='article_rank_bottom'}
                                  <!--end of rounded corners-->
                                </div>
                               {* ****** Article Pagination starts ******** *}

                                    {if $displayArticle_arr.page_break}
                                        <div class="clsArticleIndex">
                                            {$myobj->setTemplateFolder('general/','article')}
                                            {include file='box.tpl' opt='viewarticle_index_top'}
                                            	<div class="clsArticleIndexTitle">
                                                 	<h3>{$LANG.viewarticle_article_index}</h3>
                                                 </div>
                                                <div class="clsArticleIndexListing">
                                                    <ul>
                                                        <li id="show_1" class="clsAticleIndexActive"><a href="javascript:void(0)" onClick="return getArticleContent('{$displayArticle_arr.page_break_home}&page_title=0&ajax_page=true', '')" title={$LANG.viewarticle_article_home}>{$LANG.viewarticle_article_home}</a></li>
                                                        {foreach key=pageno item=page from=$displayArticle_arr.pagebreak_toc_title_arr}
                                                            <li id="show_{$pageno}"><a href="javascript:void(0)" onClick="return getArticleContent('{$displayArticle_arr.pagebreak_title_link}{$pageno}&page_title={$displayArticle_arr.pagebreak_title_arr.$pageno}&ajax_page=true', '')" title="{$page}">{$displayArticle_arr.pagebreak_toc_title_manual_arr.$pageno}</a></li>
                                                        {/foreach}
                                                        <li id="show_all"><a href="javascript:void(0)" onClick="return getArticleContent('{$displayArticle_arr.page_break_show_all}&page_title=0&ajax_page=true', '')" title="{$LANG.viewarticle_article_allpages}">{$LANG.viewarticle_article_allpages}</a></li>
                                                        {*<li><a href="{$displayArticle_arr.page_break_show_all}">{$LANG.viewarticle_article_allpages}</a></li>*}
                                                    </ul>
                                                </div>
                                            {$myobj->setTemplateFolder('general/','article')}
                                            {include file='box.tpl' opt='viewarticle_index_bottom'}
                                        </div>
                                    {/if}

                                    {* ****** Article Pagination div ends ******** *}



                                <!--CONTENT TAB -->
                                {* Added condition to display comments block if article status is set OK *}
                                {if $myobj->getFormField('article_status') == 'Ok'}
	                                <div class="clsArticleFeatured clsOverflow">
	                                    <ul id="selArticleDetails">
	                                         <li class="clsContentCell">
	                                            <p class="clsShare">
	                                                <a href="javascript:void(0)" onClick="showShareArticleDiv('{$displayArticle_arr.share_article_url}', 'email_content_tab')" title="{$LANG.viewarticle_email_to_friends}">
	                                            		<span>{$LANG.viewarticle_email_to_friends}</span>
	                                          		</a>
	                                            </p>
	                                        </li>
	                                        <li class="clsContentCell">
	                                            {if $myobj->getFormField('flagged_status') == 'No'}
	                                                {if isMember()}
	                                                  <p class="clsFlagContent">
	                                                  	 <a href="javascript:void(0)" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())" title="{$LANG.viewarticle_flag_content}"><span>{$LANG.viewarticle_flag_content}</span></a>
	                                                  </p>
	                                                {else}
	                                                  {*<p class="clsFlagContent"><a href="{$displayArticle_arr.flag_article_url}" title="{$LANG.viewarticle_login} {$LANG.viewarticle_to_flag}">{$LANG.viewarticle_flag_content}</a></p>*}
	                                                  <p class="clsFlagContent">
	                                                      <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_comment_flag_err_msg}','{$displayArticle_arr.flag_article_url}');return false;">
	                                                    	  <span>{$LANG.viewarticle_flag_content}</span>
	                                                      </a>
	                                                  </p>
	                                                {/if}
	                                             {/if}
	                                        </li>
	                                        <li class="clsContentCell">
	                                            {if isMember()}
	                                                <p id="selHeaderFavorites" class="clsFavourites">
	                                                    <div class="clsFavouriteContent" id="favorite"{if $myobj->favorite.added} style="display:none"{/if}>
	                                                        <a class="favorites" href="javascript:void(0);" onclick="getViewArticleMoreContent('Favorites');">
	                                                      		<span class="clsFavourites">{$LANG.viewarticle_favorites}</span>
	                                                        </a>
	                                                    </div>
	                                                    <div  class="clsFavouriteContent clsFavoured" id="unfavorite"{if !$myobj->favorite.added} style="display:none"{/if}>
	                                                        <a class="favorited" href="javascript:void(0);" onclick="getViewArticleMoreContent('Favorites','remove');">
	                                                        	<span class="clsFavourited">{$LANG.viewarticle_article_favorited}</span>
	                                                        </a>
	                                                    </div>
	                                                </p>
	                                            {else}
	                                                 <p id="selHeaderFavorites">
	                                                    <div class="clsFavouriteContent">
	                                                     {*<span><a class="favorites" href="{$displayArticle_arr.getFavoriteLink_arr.view_article_url}" title="{$LANG.viewarticle_login} {$LANG.viewarticle_to_favorite}"><span class="clsFavourites">{$LANG.viewarticle_favorites}</span></a></span>*}
	                                                        <a class="favorites" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_favorite_err_msg}','{$displayArticle_arr.getFavoriteLink_arr.view_article_url}');return false;">
	                                                       		<span class="clsFavourites">{$LANG.viewarticle_favorites}</span>
	                                                        </a>
	                                                    </div>
	                                                 </p>

	                                            {/if}
	                                            <p id="selHeaderFavorites">
	                                                    <div class="clsFavouriteContent" id="favorite_saving" style="display:none">
	                                                        <a class="favorites" href="javascript:void(0);"><span class="clsFavourites">Saving</span></a>
	                                                    </div>
	                                            </p>
	                                            <li  class="clsMusicfavorite" id="favorite_saving" style="display:none">
	                       							<a class="favorited"><span>{$LANG.viewmusic_saving}</span></a>
	                  							</li>


	                                             <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
												 	  <br />&nbsp;
												 </div>
												 {include file='articleFlag.tpl'}
	                                         </li>
	                                    </ul>
	                                </div>
                                {/if}

                                <div class="clsArticleFlag">
                                    {$myobj->setTemplateFolder('general/','article')}
                                     {include file='box.tpl' opt='articleflag_top'}
                                        <div id="flag_content_tab"></div>
                                        {* Code to display Favorite Article Success Message window starts here *}
                                            <div class="clsFlagDetails" id="selSlideContainer" style="display:none">
                                                <div class="clsOverflow clsFlagTitle">
                                                <h2>{$LANG.viewarticle_title_favorite}</h2>
                                                <div id="cancel"><a href="javascript:void(0);" onclick="closeShareSlider();" title="{$LANG.viewarticle_cancel}">{$LANG.viewarticle_cancel}</a></div>
                                                </div>
                                                <div class="clsFavouritesContent"><span id="selFavoritesContent" style="display:none"></span></div>
                                            </div>
                                        {* Code to display Favorite Article Success Message window ends here *}
                                        <div id="favorite_content_tab" class="selFavoriteMsgSuccess"></div>
                                        <div id="email_content_tab"></div>
                                    {$myobj->setTemplateFolder('general/','article')}
                                    {include file='box.tpl' opt='articleflag_bottom'}
                                </div>
                                <!--END OF CONTENT TAB -->
                                <div class="clsMoreArticleContent">
                                    <div class="clsAriclTitleContainer">
                                          <div class="clsOverflow">
                                                <div class="clsViewArticleTitle">
                                                        <h3>{$LANG.viewarticle_more_articles}</h3>
                                                </div>
                                                <div id="" class="clsMoreArticleNav">
                                                  <ul>
                                                    <li id="selHeaderArticleUser"><span><a class="" onClick="getMoreContent('{$displayArticle_arr.more_article_user_url}', 'selUserContent', 'selHeaderArticleUser'); return false;" title="{$LANG.viewarticle_more_articles_user}">{$LANG.viewarticle_more_articles_user}</a></span></li>
                                                    <li id="selHeaderArticleRel"><span><a class="" onClick="getMoreContent('{$displayArticle_arr.more_article_tag_url}', 'selRelatedContent', 'selHeaderArticleRel'); return false;" title="{$LANG.viewarticle_more_articles_related}">{$LANG.viewarticle_more_articles_related}</a></span></li>
                                                    <li id="selHeaderArticleTop"><span><a onClick="getMoreContent('{$displayArticle_arr.more_article_top_url}', 'selTopContent', 'selHeaderArticleTop'); return false;" title="{$LANG.viewarticle_more_articles_top}">{$LANG.viewarticle_more_articles_top}</a></span></li>
                                                  </ul>
                                                </div>
                                          </div>
                                        </div>
                                    {$myobj->setTemplateFolder('general/','article')}
                                    {include file='box.tpl' opt='morearticles_top'}
                                         <div id="more_article_{$myobj->getFormField('article_id')}">
                                                <div id="" class="clsMoreArticlesContent">
                                                  <div class="clsUserContent" id="selUserContent">
                                                    {$myobj->populateRelatedArticle('user')}
                                                  </div>
                                                  <div class="clsRelatedContent" id="selRelatedContent" style="display:none">
                                                    {$myobj->populateRelatedArticle('tag')}
                                                  </div>
                                                  <div class="clsTopContent" id="selTopContent" style="display:none">
                                                    {$myobj->populateRelatedArticle('top')}
                                                  </div>
                                                </div>
                                        </div>
                                    {$myobj->setTemplateFolder('general/','article')}
                                    {include file='box.tpl' opt='morearticles_bottom'}
                                </div>
                            </div>

                            {if isAjaxpage()}
                                ***--***!!!
                                {$myobj->captchaText}
                            {/if}
                      </div>
                </div>
         {/if}

    {$myobj->setTemplateFolder('general/','article')}
    {include file='box.tpl' opt='articlecontent_bottom'}

	  {if !isAjaxpage()}
          </div>
        </div>
	  {/if}
</div>
</div>

{/if}

{literal}
<script language="javascript" type="text/javascript">
	function toggleVideoPostCommentOption(){
		$Jq("#selEditMainComments").toggle('slow');
	}
	$Jq("#tabs").tabs();
</script>
{/literal}


<div id="sideBar" class="clsViewPostRight">

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
					<div class="clsOverflow">

			 {include file='postFlag.tpl'}

{* ---------------POST SHARE FLAG FAVORITE BLOCK BEGINS -----------------------------*}
                         {if $myobj->isShowPageBlock('share_fav_falg_block')}

             {if $myobj->chkPostStatus() && $CFG.admin.is_logged_in}
             <div class="clsPostShareContainer clsOverflow">
               <div class="clsOverflow">
                 <ul>
                     {if isMember()}
                       <li id="selHeaderFlag">
                          <span><a class="flag" href="javascript:void(0);" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())"><span class="clsFlag" title="{$LANG.viewpost_flag_content}">{$LANG.viewpost_flag_content}</span></a></span>
                      </li>
                      <li id="selHeaderFavorites"  onmouseover="tabChange('selHeaderFavorites', 'over')" onmouseout="tabChange('selHeaderFavorites', 'out')">
                            <div id="add_favorite"{if $myobj->favorite.added} style="display:none"{/if}>
                                 <span><a class="favorites" href="javascript:void(0);" onclick="getViewPostMoreContent('Favorites');"><span class="clsFavourites" title="{$LANG.viewpost_add_to_favorites}">{$LANG.viewpost_add_to_favorites}</span></a></span>
                            </div>
                             <div id="added_favorite"{if !$myobj->favorite.added} style="display:none"{/if}>
                                  <span><a class="favorited" href="javascript:void(0);" onclick="getViewPostMoreContent('Favorites','remove');"><span class="clsFavourited" title="{$LANG.viewpost_remove_favorites}">{$LANG.viewpost_remove_favorites}</span></a></span>
                             </div>
                      </li>
                        <li id="selHeaderSharePost" >
                               <span><a class="sharepost" href="javascript:void(0);" onclick="showShareDiv('{$myobj->share_url}');"><span class="clsEmailFriends" title="{$LANG.viewpost_email_to_friend}">{$LANG.viewpost_email_to_friend}</span></a></span>
                         </li>
                     {else}
                     	 <li id="selHeaderFlag" onmouseover="tabChange('selHeaderFlag', 'over')" onmouseout="tabChange('selHeaderFlag', 'out')">
                                        <span><a class="flag" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.common_sidebar_login_comment_flag_err_msg}','{$myobj->memberviewPostUrl}');return false;"><span class="clsFlag" title="{$LANG.viewpost_flag_content}">{$LANG.viewpost_flag_content}</span></a></span>
                         </li>
                         <li id="selHeaderFavorites" onmouseover="tabChange('selHeaderFavorites', 'over')" onmouseout="tabChange('selHeaderFavorites', 'out')">
                                        <span><a class="favorites" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('{$LANG.common_sidebar_login_favorite_err_msg}','{$myobj->memberviewPostUrl}');return false;"><span class="clsFavourites" title="{$LANG.viewpost_add_to_favorites}">{$LANG.viewpost_add_to_favorites}</span></a></span>
                          </li>
                            <li id="selHeaderSharePost" onmouseover="tabChange('selHeaderSharePost', 'over')" onmouseout="tabChange('selHeaderSSharePost', 'out')">
                                       <span><a class="sharepost" href="javascript:void(0);" onclick="getViewPostMoreContent('SharePost');"><span class="clsEmailFriends" title="{$LANG.viewpost_email_to_friend}">{$LANG.viewpost_email_to_friend}</span></a></span>
                            </li>
                     {/if}
                </ul>
               </div>
			   </div>
			    <div id="shareDiv" class="clsPopupConfirmation" style="display:none">
											 	  <br />&nbsp;
											 </div>
               <div class="clsPostCloseButtonOuter" id="closeViewPostMoreContent" style="display:none">
                <div class="clsPostCloseButton" onclick="hideViewPostMoreContent()"></div></div>
                <div id="selFavoritesContent" class="clsUserActionAdded" style="display:none"></div>
                <div id="selFeaturedContent" style="display:none"></div>
                <div id="selSharePostContent" style="display:none"></div>
            {/if}
            {/if}
             {* ---------------POST SHARE FLAG FAVORITE BLOCK ENDS -------------------------------*}


					</div>
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
			<div id="postmain" class="clsViewPostLeft">
   {$myobj->setTemplateFolder('general/','blog')}
			 {include file='box.tpl' opt='displayblog_top'}

    {if $myobj->getFormField('blog_post_id')!=''}
    <div class="clsOverflow clsViewPostHeading">
		 	<div class="clsPageHeading">
		 	<h2><span>{$myobj->getFormField('blog_post_name')}</span></h2>
			</div>
		 </div>
    {/if}
<div class="clsPostInfoInnerContainer clsOverflow">
{* ---------------POST INFO BLOCK BEGINS --------------------------------*}
	<div class="clsFloatLeft">
	  	<div class="clsPostInfoContainer clsMarginTop10">
            {* {$myobj->setTemplateFolder('general/','blog')}
            {include file='box.tpl' opt='postinfocontainer_top'}*}
              <div class="clsOverflow">
                        <ul class="clsViewBlogListHeader">
                            <li>
                                <span>{$LANG.viewpost_views}</span>
                                <span class="clsViewBlogListLeft"><span class="clsViewBlogListRight">{$myobj->getFormField('total_views')}</span></span>
                            </li>
                            <li>
                                <span>{$LANG.viewpost_toatl_comments}</span>
                                <span class="clsViewBlogListLeft"><span class="clsViewBlogListRight">{$myobj->getFormField('comments')}</span></span>
                            </li>
                            <li>
                                <span>{$LANG.viewpost_favorited}</span>
                                <span class="clsViewBlogListLeft"><span class="clsViewBlogListRight">{$myobj->getFormField('favorited')}</span></span>
                            </li>
                        </ul>

                 </div>
            {* {$myobj->setTemplateFolder('general/','blog')}
            {include file='box.tpl' opt='postinfocontainer_bottom'} *}
        </div>
	</div>
{* ---------------POST INFO BLOCK ENDS ----------------------------------*}
{* ---------------POST INFO RATING BEGINS --------------------------------*}
	<div class="clsFloatRight">
		<div class="clsRatingImage clsPostRightRating">
			   {* ---------------DISPLAYING RATING FORM BEGINS--------------------------*}
                {if $myobj->getFormField('allow_ratings') =='Yes' && $myobj->chkPostStatus() && $myobj->getFormField('status')=='Ok'}
                   <span id="ratingForm">
                        {assign var=tooltip value=""}
                        {if !isLoggedIn()}
                            {$myobj->populateRatingImages($myobj->post_rating, 'blog',$LANG.viewpost_login_message, $myobj->memberviewPostUrl, 'blog')}
                            {assign var=tooltip value=$LANG.viewpost_login_message}
                        {else}
                            <div id="selRatingBlog" class="clsPostRating">
                                {if isMember() and $myobj->rankUsersRayzz}
                                    {$myobj->populateRatingImagesForAjax($myobj->post_rating, 'blog')}
                                {else}
                                    <span class="clsRatingTitle">{$LANG.viewpost_rate_this}</span>
                                    {$myobj->populateRatingImages($myobj->post_rating, 'blog', $LANG.viewpost_rate_yourself, '#', 'blog')}
                                    {assign var=tooltip value=$LANG.viewpost_rate_yourself}
                                {/if}

                            &nbsp;(<span>{$myobj->getFormField('rating_count')}</span>)</div>
                {/if}
                    <div id="rating_tooltip" style="display:none; z-index:2;" class="clsToolTip">
                        {$tooltip}
                    </div>
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
                {/if}
               {* -------------- DISPLAYING RATING FORM ENDS------------------------*}
			</div>
    </div>
{* ---------------POST INFO RATING ENDS  --------------------------------*}
</div>

<div class="clsViewMemberDetails clsOverflow">
	<div class="clsFloatLeft">
    	<p>{$LANG.viewpost_post_added_by}: <span>{$myobj->date_added}</span>
    </div>
    <div class="clsFloatRight">
    	<p>{$LANG.viewpost_post_category_lbl}: <a href="{$myobj->category_link}">{$myobj->category}</a></p>
    </div>
</div>


    {if $myobj->isShowPageBlock('postMainBlock')}
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
    {/if}

     {*------ FLAGGED POST CONFIRMATION FORM START ---------*}
    {if $myobj->isShowPageBlock('confirmation_flagged_form')}
        <div id="flaggedForm" class="clsFlaggedForm">
            <p class="clsFlaggedForm">{$LANG.viewpost_flagged_msg}</p>
           <div class="clsOverflow">
            <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="{$myobj->flaggedPostUrl}">{$LANG.viewpost_flagged}</a></div></div>
           </div>
        </div>
    {/if}
    {*------ FLAGGED POST CONFIRMATION FORM END ---------*}

    {*------ ADULT POST CONFIRMATION FORM START ---------*}
        {if $myobj->isShowPageBlock('confirmation_adult_form')}
            <div id="selAdultUserForm">
                <p class="clsFlaggedForm">{$myobj->replaceAdultText($LANG.confirmation_alert_text)}</p>
             <div class="clsOverflow">
                <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="{$myobj->acceptAdultPostUrl}">{$LANG.viewpost_accept}</a></div></div>
                <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="{$myobj->acceptThisAdultPostUrl}">{$LANG.viewpost_accept_this_page_only}</a></div></div>
                <div class="clsDeleteButton-l"><div class="clsDeleteButton-r"><a href="{$myobj->rejectAdultPostUrl}">{$LANG.viewpost_reject}</a></div></div>
             </div>
            </div>
        {/if}
    {*------ ADULT POST CONFIRMATION FORM END ---------*}
  {if $myobj->isShowPageBlock('invalid_posts_block')}
        <div id="flaggedForm" class="clsFlaggedForm">
            <p class="clsFlaggedForm">{$LANG.viewpost_post_message_member}</p>
           <div class="clsOverflow">
           </div>
        </div>
    {/if}
    {if $myobj->isShowPageBlock('postMainBlock')}
       <div class="clsViewPostLeftSide">

       </div>
       <div class="clsViewPostRightSide">
             {* ---------------POST MESSAGE BLOCK BEGINS -----------------------------*}

					 <div class="clsPostMessageContainer">
						 <div class="clsMessageContent">{$displayPost_arr.message}</div>
					</div>

             {* ---------------POST MESSAGE BLOCK ENDS -------------------------------*}
        </div>
{if $myobj->chkPostStatus()}
              {* ---------------POST COMMENTS BLOCK BEGINS --------------------------------------------*}
			  {$myobj->setTemplateFolder('general/','blog')}
				{include file='box.tpl' opt='comments_top'}
				 {if $myobj->isShowPageBlock('blog_comments_block')}
					 <div class="clsPostCommentContainer">

                        <div >
                        	<div class="clsHeadingPostComment clsOverflow">
                              <div class="clsViewVideoDetailsHeading">
                                <h3 class="clsBlogPostComments">{$LANG.comments}&nbsp;(<span class="clsCommentsCount" id="selVideoCommentsCount">{$myobj->getFormField('total_comments')}</span>)</h3>
                              </div>
                              <div class="clsPostCommentHeading clsOverflow">
                                {if $myobj->getFormField('allow_comments')=='Kinda' OR $myobj->getFormField('allow_comments')=='Yes'}
                                    {if isMember()}
                                     <div class="clsOverflow">
                                        <span id="selViewPostComment" class="clsViewPostComment">
                                            <a class="" id="selPostVideoComment" href="{$myobj->getCurrentUrl()}" onclick="toggleVideoPostCommentOption(); return false;" title="{$LANG.viewpost_post_comment}"><span>{$LANG.viewpost_add_comment}</span></a>
                                        </span>
                                    </div>
                                    {else}
                                        <div class="clsOverflow">   <span id="selViewPostComment" class="clsViewPostComment">
                                            <a class="" href="javascript:void(0)" onclick="memberBlockLoginConfirmation('{$LANG.common_blog_login_post_comment_msg}', '{$myobj->commentUrl}')">
                                                <span>{$LANG.viewpost_post_comment}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.approval}){/if}
                                            </a>                         </span>
                                        </div>
                                    {/if}
                                    {include file='addComments.tpl'}
                                {/if}
                                </div>
                        	</div>


                        	 {if isMember()}
	                        	{if $myobj->getFormField('allow_comments')=='Kinda'}
	                               <div class="clsOverflow"><div class="clsPostCommentHeading clsVideVideoHeadingRight">({$LANG.approval})</div></div>
	                            {/if}
	                        {/if}

	                    	{$myobj->populateCommentOptionsPost()}
	                        <div id="selMsgSuccess" style="display:none">
	                        	<p id="kindaSelMsgSuccess"></p>
	                        </div>
	                        <div id="selCommentBlock" class="clsViewVideoDetailsContent">
	                            {$myobj->populateCommentOfThisPost()}
	                        </div>

                            	{*---unwanted previous code starts ------------------*}
{/if}




                      {* <div>
					 {if $myobj->getFormField('allow_comments')=='Kinda' OR $myobj->getFormField('allow_comments')=='Yes'}
							{if isMember() && $myobj->getFormField('status')=='Ok'}
								<div id="selEditMainComments"></div>
								<span id="selViewPostComment" class="clsViewPostComment clsListHeadingRight">
									<a href="javascript:void(0);" class="clsCommentBgLeft" onclick="showAddPostComment()"
											title="{$LANG.viewpost_post_comment}" id="add_comment"><span>{$LANG.viewpost_post_comment}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.viewpost_approval}){/if}</a>
                                     <a href="javascript:void(0);" class="clsCommentBgLeft" onclick="showCancelPostComment()"
                            title="{$LANG.viewpost_cancel_comments_label}" id="cancel_comment" style="display:none;"><span>{$LANG.viewpost_cancel_comments_label}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.viewpost_approval}){/if}</a>
								</span>
							{elseif $myobj->getFormField('status')=='Ok'}
								<span id="selViewPostComment" class="clsViewPostComment clsListHeadingRight">
									<a href="javascript:void(0);" class="clsCommentBgLeft" onclick="memberBlockLoginConfirmation('{$LANG.common_sidebar_login_comment_post_err_msg}','{$myobj->commentUrl}');return false;">
									   <span>{$LANG.viewpost_post_comment}</span> {if $myobj->getFormField('allow_comments')=='Kinda'}({$LANG.viewpost_approval}){/if}
									</a>
								</span>
							{/if}
					   {/if}
                     </div>*}

                     {*---unwanted previous code end ------------------*}

                      </div>

				{/if}

             {* ---------------POST COMMENTS BLOCK ENDS ------------------------------------------------*}



       </div>
     {/if}
	 	   {$myobj->setTemplateFolder('general/','blog')}
				{include file='box.tpl' opt='comments_bottom'}


   {$myobj->setTemplateFolder('general/','blog')}
			 {include file='box.tpl' opt='displayblog_bottom'}
</div>
{literal}
<script language="javascript" type="text/javascript">
	function toggleVideoPostCommentOption(){
		$Jq("#selEditMainComments").toggle('slow');
	}
	$Jq("#tabs").tabs();
</script>
{/literal}
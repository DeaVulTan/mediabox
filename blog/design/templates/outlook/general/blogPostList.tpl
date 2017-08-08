{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_top'}
<div id="selBlogPostList" class="clsOverflow">
<!--rounded corners-->
<form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
  <input type="hidden" name="advanceFromSubmission" value="1"/>
  {$myobj->populateBlogListHidden($paging_arr)}
  <div class="clsOverflow">
    <div class="clsBlogListHeading">
      <h2><span> {if $myobj->getFormField('pg')=='userblogpostlist'}
        {$LANG.blogpostlist_title}
        {else}
        {$LANG.blogpostlist_title|capitalize:true}
        {/if} </span> </h2>
    </div>
    {assign var=dispaly_select value=''}
    {if $myobj->getFormField('pg') == 'toactivate'|| $myobj->getFormField('pg') == 'notapproved' ||
    $myobj->getFormField('pg') == 'draftposts' || $myobj->getFormField('pg') == 'infutureposts'}
    {assign var=dispaly_select value='none'}
    {/if}
    <div class="clsBlogListHeadingRight" style="display:{$dispaly_select}">
      <input type="hidden" name="default" id="default" value="{$myobj->getFormField('default')}" />
      <select name="select" id="blogselect" onchange="loadUrl(this)">
        <option value="{php} echo getUrl('blogpostlist','?pg=postnew','postnew/','','blog'){/php}" {if $myobj->getFormField('pg')==''} selected {/if} >
        {$LANG.common_header_nav_blog_all} </option>
        <option value="{php} echo getUrl('blogpostlist','?pg=postrecent','postrecent/','','blog'){/php}"{if $myobj->getFormField('pg')=='postrecent'} selected {/if} >
        {$LANG.common_header_nav_blog_new} </option>
        <option value="{php} echo getUrl('blogpostlist','?pg=posttoprated','posttoprated/','','blog'){/php}" {if $myobj->getFormField('pg')=='posttoprated'} selected {/if} >
        {$LANG.common_header_nav_blog_top_rated} </option>
        <option value="{php} echo getUrl('blogpostlist','?pg=postmostviewed','postmostviewed/','','blog'){/php}"{if $myobj->getFormField('pg')=='postmostviewed'} selected {/if} >
        {$LANG.common_header_nav_blog_most_viewed} </option>
        <option value="{php} echo getUrl('blogpostlist','?pg=postmostdiscussed','postmostdiscussed/','','blog'){/php}" {if $myobj->getFormField('pg')=='postmostdiscussed'} selected {/if} >
        {$LANG.common_header_nav_blog_most_discussed} </option>
        <option value="{php} echo getUrl('blogpostlist','?pg=postmostfavorite','postmostfavorite/','','blog'){/php}" {if $myobj->getFormField('pg')=='postmostfavorite'} selected {/if} >
        {$LANG.common_header_nav_blog_most_favorite} </option>
      </select>
    </div>
  </div>
  <div id="advanced_search" class="clsAdvancedSearch">
    <div class="clsAdvancedSearchBg">
      <table class="clsAdvancedFilterTable">
        <tr>
          <td class="clsSearchIcons"><input class="clsTextBox" type="text" name="blog_post_keywords" id="blog_post_keywords" value="{if $myobj->getFormField('blog_post_keywords') != ''}{$myobj->getFormField('blog_post_keywords')}{else}{$LANG.blogpostlist_keyword_field}{/if}" onblur="setOldValue('blog_post_keywords')" onfocus="clearValue('blog_post_keywords')"/>
            {if $myobj->getFormField('pg') != 'myposts' && $myobj->getFormField('pg') != 'toactivate' && $myobj->getFormField('pg') != 'notapproved' &&
            $myobj->getFormField('pg') != 'draftposts' && $myobj->getFormField('pg') != 'infutureposts' && $myobj->getFormField('pg') != 'publishedposts'}
            <input class="clsTextBox" type="text" name="post_owner" id="post_owner" value="{if $myobj->getFormField('post_owner') != ''}{$myobj->getFormField('post_owner')}{else}{$LANG.blogpostlist_post_created_by}{/if}" onblur="setOldValue('post_owner')"  onfocus="clearValue('post_owner')"/></td>
          {/if}
          <td class="clsSearchStrip"><div class="clsSearchButtonTd">
              <div class="clsAdvSearchButton clsOverflow">
                <div class="clsSubmitLeft"> <span class="clsSubmitRight">
                  <input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.blogpostlist_search_categories_post_submit}" />
                  </span> </div>
              </div>
              <div class="clsAdvCancelButton clsOverflow">
                <div class="clsCancelLeft"> <span class="clsCancelRight"> {if $myobj->getFormField('pg') == 'postnew' && !$myobj->getFormField('cid') && !$myobj->getFormField('sid')}
                  <input type="button" name="avd_reset" id="avd_reset" onclick="location.href='{$myobj->getUrl('blogpostlist', '?pg=postnew', 'postnew/', '', 'blog')}'" value="{$LANG.blogpostlist_reset_submit}" />
                  {else}
                  <input type="submit" name="avd_reset" id="avd_reset" onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.blogpostlist_reset_submit}" />
                  {/if} </span> </div>
              </div>
            </div>
		  </td>
        </tr>
      </table>
    </div>
  </div>
  {$myobj->setTemplateFolder('general/','blog')}
  {include file='../general/information.tpl'}
  {if $myobj->getFormField('pg') == 'postmostviewed' OR $myobj->getFormField('pg') == 'postmostdiscussed' OR $myobj->getFormField('pg') == 'postmostfavorite'}
  <div class="clsBlogViews">
    <ul class="clsSubMenu clsBlogTabLinks">
      <li {$blogpostActionNavigation_arr.postMostViewed_0}> <a href="javascript:void(0)" onclick="jumpAndSubmitForm('{$blogpostActionNavigation_arr.blog_post_list_url_0}');"> <span><span>{$LANG.header_nav_members_all_time}</span></span> </a> </li>
      <li {$blogpostActionNavigation_arr.postMostViewed_1}> <a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$blogpostActionNavigation_arr.blog_post_list_url_1}');"> <span><span>{$LANG.header_nav_members_today}</span></span> </a> </li>
      <li {$blogpostActionNavigation_arr.postMostViewed_2}> <a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$blogpostActionNavigation_arr.blog_post_list_url_2}');"> <span><span>{$LANG.header_nav_members_yesterday}</span></span> </a> </li>
      <li {$blogpostActionNavigation_arr.postMostViewed_3}> <a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$blogpostActionNavigation_arr.blog_post_list_url_3}');"> <span><span>{$LANG.header_nav_members_this_week}</span></span> </a> </li>
      <li {$blogpostActionNavigation_arr.postMostViewed_4}> <a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$blogpostActionNavigation_arr.blog_post_list_url_4}');"> <span><span>{$LANG.header_nav_members_this_month}</span></span> </a> </li>
      <li {$blogpostActionNavigation_arr.postMostViewed_5}> <a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$blogpostActionNavigation_arr.blog_post_list_url_5}');"> <span><span>{$LANG.header_nav_members_this_year}</span></span> </a> </li>
    </ul>
  </div>
  {literal}
  <script type="text/javascript">
		function jumpAndSubmitForm(url)
		  {
			document.seachAdvancedFilter.start.value = '0';
			document.seachAdvancedFilter.action=url;
			document.seachAdvancedFilter.submit();
		  }
		var subMenuClassName1='clsBlogListMenu';
		var hoverElement1  = '.clsBlogListMenu li';
		loadChangeClass(hoverElement1,subMenuClassName1);
	</script>
  {/literal}
  {/if}
</form>
{if $myobj->isShowPageBlock('form_show_sub_category')}
	<div class="clsAdvancedFilterSearch clsShowHideFilter" id=""> 
		<a href="javascript:void(0)" id="show_link" class="clsShow clsShowFilterSearch"  {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if}    onclick="divShowHide('showHideSubCategory', 'show_link', 'hide_link')">{$LANG.blogpostlist_showpost_subcategory}</a> 
		<a href="javascript:void(0)" id="hide_link" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} class="clsHide clsHideFilterSearch"  onclick="divShowHide('showHideSubCategory', 'show_link', 'hide_link')">{$LANG.blogpostlist_hidepost_subcategory}</a> 
	</div>
<div class="clsBlogsSubcategoryContent" id="showHideSubCategory" style="display:none"> {$myobj->setTemplateFolder('general/','blog')}
  {include file='box.tpl' opt='blog_content_top'}
  <h2 class="clsMarginBottom10"><span>{$LANG.blogpostlist_category_title}</span></h2>
  <div id="selShowAllShoutouts"> {foreach key=scKey item=scValue from=$populateSubCategories_arr.row}
    <div class="clsOverflow">
      <ul class="clsBlogsSubCategory">
        <li><a href="{$scValue.blog_post_list_url}">{$scValue.blog_category_name_manual}</a></li>
      </ul>
    </div>
    {foreachelse}
    <div id="selMsgError">
      <p> {$LANG.blogpostlist_no_sub_categories_found} </p>
    </div>
    {/foreach} </div>
  {$myobj->setTemplateFolder('general/','blog')}
  {include file='box.tpl' opt='blog_content_bottom'}
 </div>
{/if}
<div id="selLeftNavigation">
<!-- Delete Single Post -->
<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
  <p id="msgConfirmText"></p>
  <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
    <div class="clsBlogListTable clsContentsDisplayTbl">
      <input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
      &nbsp;
      <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
      <input type="hidden" name="act" id="act" />
      <input type="hidden" name="blog_post_id" id="blog_post_id" />
    </div>
  </form>
</div>
<!-- Delete Multi Posts -->
<div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
  <p id="msgConfirmTextMulti">{$LANG.blogpostlist_multi_delete_confirmation}</p>
  <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
    <div class="clsBlogListTable clsContentsDisplayTbl">
      <input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
      &nbsp;
      <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
      <input type="hidden" name="blog_post_id" id="blog_post_id" />
      <input type="hidden" name="act" id="act" />
    </div>
  </form>
</div>
<div id="selEditPostComments" class="clsPopupConfirmation" style="display:none;"></div>
{if $myobj->isShowPageBlock('my_posts_form')}
  <div id="selPostListDisplay" class="clsLeftSideDisplayTable">
	{if $myobj->isResultsFound()}
		{if $CFG.admin.navigation.top}
			{$myobj->setTemplateFolder('general/','blog')}
			{include file='pagination.tpl'}
		{/if}
		<form name="blogPostListForm" id="blogPostListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		{if (isMember() && (($myobj->getFormField('user_id') == 0 && $CFG.user.user_id) || ($myobj->getFormField('user_id') == $CFG.user.user_id))) && ($myobj->getFormField('pg') == 'myposts' || $myobj->getFormField('pg') == 'publishedposts' || $myobj->getFormField('pg') == 'toactivate' || $myobj->getFormField('pg') == 'draftposts' || $myobj->getFormField('pg') == 'infutureposts' || $myobj->getFormField('pg') == 'notapproved')}
			<div class="clsOverflow clsCheckAllItems">
				<div id="selCheckAllItems" class="clsFloatLeft"> <span class="clsCheckItem">
				  <input type="checkbox" class="clsCheckRadio clsFloatLeft clsMarginRight10" name="check_all" onclick="CheckAll(document.blogPostListForm.name, document.blogPostListForm.check_all.name)" />
				  <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.blogpostlist_delete_submit}" onclick="if(getMultiCheckBoxValue('blogPostListForm', 'check_all', '{$LANG.common_check_atleast_one}', '{$myobj->anchor}', -100, -500)) Confirmation('selMsgConfirmMulti', 'msgConfirmformMulti', Array('blog_post_id','act', 'msgConfirmTextMulti'), Array(multiCheckValue, 'delete', '{$LANG.blogpostlist_multi_delete_confirmation}'), Array('value','value', 'innerHTML'), 0, 0);" />
				  </span> </div>
				{if $myobj->getFormField('pg') == 'publishedposts'}
				<div class="clsFloatRight"><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-published.gif" alt="{$LANG.common_sidebar_publishedposts}" title="{$LANG.common_sidebar_publishedposts}" /></div>
				{elseif $myobj->getFormField('pg') == 'toactivate'}
				<div class="clsFloatRight"><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-toactivate.gif" alt="{$LANG.common_sidebar_toactivate_mypost}" title="{$LANG.common_sidebar_toactivate_mypost}" /></div>
				{elseif $myobj->getFormField('pg') == 'draftposts'}
				<div class="clsFloatRight"><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-draft.gif" alt="{$LANG.common_sidebar_draftposts}" title="{$LANG.common_sidebar_draftposts}" /></div>
				{elseif $myobj->getFormField('pg') == 'infutureposts'}
				<div class="clsFloatRight"><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-infuture.gif" alt="{$LANG.common_sidebar_infutureposts}" title="{$LANG.common_sidebar_infutureposts}" /></div>
				{elseif $myobj->getFormField('pg') == 'notapproved'}
				<div class="clsFloatRight"><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-notapproved.gif" alt="{$LANG.common_sidebar_not_approvedpost}" title="{$LANG.common_sidebar_not_approvedpost}"/></div>
				{/if} 
		  </div>
			{/if}
			  <p><a href="#" id="{$myobj->anchor}"></a></p>
			  <div id="selDisplayTable"> 
				{foreach key=salKey item=salValue from=$showBlogPostList_arr.row}
				  <div class="clsBlogListContent"> <a href="#" id="{$salValue.anchor}"></a> {if $salValue.record.status =='Locked'}
					  <div class="clsHomeDispContent">
						<h3 class="clsTitleLink">{$salValue.row_blog_post_name_manual}</h3>
						<p class="clsAddedDate">{$LANG.blogpostlist_added}&nbsp;{$salValue.record.date_added}</p>
					  </div>
					  {else}
					  <div class="clsOverflow clsHomeDispContent">
						<h3 class="{if $myobj->getFormField('pg') == 'myposts'} clsPostTitleLink clsFloatLeft {else} clsTitleLink clsFloatLeft {/if}"> 
						    {if isMember() && $salValue.record.user_id == $CFG.user.user_id && ($myobj->getFormField('pg') == 'myposts' || $myobj->getFormField('pg') == 'publishedposts' || $myobj->getFormField('pg') == 'toactivate' || $myobj->getFormField('pg') == 'draftposts' || $myobj->getFormField('pg') == 'infutureposts' || $myobj->getFormField('pg') == 'notapproved')} 
						
								<span><input type="checkbox" class="clsCheckRadio" name="blog_post_ids[]"  value="{$salValue.record.blog_post_id}" tabindex="{smartyTabIndex}" {$salValue.blog_post_ids_checked}/> </span> 
							{/if}
					  {if $myobj->getFormField('pg') == 'myposts'}
						  {if $salValue.record.status =='Ok'} 
						   		<span><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-published.gif" alt="{$LANG.common_sidebar_publishedposts}" title="{$LANG.common_sidebar_publishedposts}" /></span> 
						   {elseif $salValue.record.status =='ToActivate'} 
						  		 <span><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-toactivate.gif" alt="{$LANG.common_sidebar_toactivate_mypost}" title="{$LANG.common_sidebar_toactivate_mypost}" /></span> 
						  {elseif $salValue.record.status =='Draft'} 
						  		<span><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-draft.gif" alt="{$LANG.common_sidebar_draftposts}" title="{$LANG.common_sidebar_draftposts}" /></span> 
						  {elseif $salValue.record.status =='InFuture'} 
						  		<span><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-infuture.gif" alt="{$LANG.common_sidebar_infutureposts}" title="{$LANG.common_sidebar_infutureposts}" /></span> 
						  {elseif $salValue.record.status =='Not Approved'} 
						  		<span><img src="{$CFG.site.blog_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-notapproved.gif" alt="{$LANG.common_sidebar_not_approvedpost}" title="{$LANG.common_sidebar_not_approvedpost}" /></span> 
						  {/if}
					  {/if}
						  
	{if $salValue.status=='Ok'} <a href="{$salValue.view_blog_post_link}">{$salValue.row_blog_post_name_manual}</a>&nbsp;&nbsp;
	  {elseif $CFG.admin.is_logged_in} <a href="{$salValue.view_blog_post_link}">{$salValue.row_blog_post_name_manual}</a>&nbsp;&nbsp;
		  {else} <a id="postComments{$salValue.record.blog_post_id}" href="#showpostComments{$salValue.record.blog_post_id}">{$salValue.row_blog_post_name_manual}</a>
			  <div style="display: none;">
 	              <div id="showpostComments{$salValue.record.blog_post_id}" class="clsPostComments">
					  <h2>{$LANG.blogpostlist_post_preview_post_title}</h2>
					  <p>Title: &nbsp;{$salValue.row_blog_post_name_manual}</p>
					  <p>Content: &nbsp;{$salValue.message}</p>
				 	</div>
		 	{* Added code to invoke jquery fancy box window to display admin comments for not apporced articles *}
			{literal}
				<script type="text/javascript">
					$Jq(document).ready(function() {
					$Jq("#postComments{/literal}{$salValue.record.blog_post_id}{literal}").fancybox({
					'titlePosition'		: 'inside',
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'width'				: 500,
					'height'			: 550,
					});
					});
				</script>
	       {/literal} 
		</div>
	 {/if} 
  </h3>
						  <div class="clsBlogViewDetails clsFloatLeft clsPaddingLeft7"> 
							{if $salValue.record.status =='Ok'}
							  {$LANG.blogpostlist_date_published_on}:&nbsp; 
								 <span>{if $salValue.record.date_published!=''}{$salValue.record.date_published}{else}{$salValue.record.date_added}{/if}</span> 
							{else}
							  {$LANG.blogpostlist_date_published_on}:&nbsp; <span>{$salValue.record.date_added}</span> {/if}
							{if isMember() && $salValue.record.user_id == $CFG.user.user_id}&nbsp;|&nbsp; 
								<span><a href="{$salValue.blog_post_posting_url_ok}" class="clsBlogEditLinks" title="{$LANG.blogpostlist_edit_blog_post}">{$LANG.blogpostlist_edit_blog_post}</a>
								</span>&nbsp;|&nbsp; <span>
									<a href="#" class="clsBlogEditLinks" title="{$LANG.blogpostlist_delete_submit}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','blog_post_id', 'msgConfirmText'), Array('delete','{$salValue.record.blog_post_id}','{$LANG.blogpostlist_delete_confirmation}'), Array('value','value', 'innerHTML'), -100, -500);">{$LANG.blogpostlist_delete_submit}</a></span> 
							{/if} 
						  </div>
					   </div>
					  <div class="clsOverflow clsPaddingLeft20">
						 <p class="clsPostedName">({$LANG.blogpostlist_added_in_blog_title}:&nbsp;
							<a href="{$salValue.view_blog_link}" title="{$salValue.record.blog_name}">{$salValue.record.blog_name}</a>)
						 </p>
					  </div>
					  <div class="clsOverflow">
							 <div class="clsBlogDetails">
								 <div id="blogUserProfile_{$salValue.record.blog_post_id}" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$salValue.record.user_id}', 'blogUserProfile_{$salValue.record.blog_post_id}');" onmouseout="hideUserInfoPopup('blogUserProfile_{$salValue.record.blog_post_id}')">
								 </div>
							  <p> <a href="{$salValue.member_profile_url}"><span class="clsUserProfileImage" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}','{$salValue.record.user_id}', 'blogUserProfile_{$salValue.record.blog_post_id}');" onmouseout="hideUserInfoPopup('blogUserProfile_{$salValue.record.blog_post_id}')"></span></a> </p>
							  <div class="clsBlogContent"> {$salValue.message} </div>
							  <div class="clsOverflow clsTagsCategory">
								  <div class="clsFloatLeft"> {if $myobj->getFormField('blog_tags') != ''}
										 {assign var=blog_tags value=$myobj->getFormField('blog_tags')}
									{elseif $myobj->getFormField('tags') != '' }
										{assign var=blog_tags value=$myobj->getFormField('tags')}
									{else}
										{assign var=blog_tags value=''}
									{/if} 
							  <span class="clsTagBg">{$LANG.blogpostlist_search_blogpost_tags}:</span>{if $salValue.record.blog_tags!=''}
								  {$myobj->getBlogPostsTagsLinks($salValue.record.blog_tags, 13, $blog_tags)}{/if} </div>
							  <div class="clsFloatRight"> <span>{$LANG.blogpostlist_blog_post_category_name}{$showBlogPostList_arr.separator}</span> 
								<span class="clsBlogValues"> <a href="{$salValue.blog_category_id_link}"> {$salValue.row_blog_category_name_manual}</a></span> 
							  </div>
							</div>
						  </div>
						 </div>
					  <div class="clsOverflow">
						   <div class="clsRatingLeft">
							  <div class="clsRatingRight">
								  <div class="clsRatingCenter">
								   <div class="clsFloatLeft clsUserImageBorder"> by <a href="{$salValue.member_profile_url}"><img src="{$salValue.profileIcon.s_url}" title="{$salValue.name}" {$myobj->DISP_IMAGE(15, 15, $salValue.width, $salValue.height)}/>&nbsp;{$salValue.name}</a> </div>
								  <div class="clsFloatRight">
									  <p class="clsRatingDisplay"> 
											<span class="clsBoldFont">
												{if $myobj->getFormField('pg')=='postmostdiscussed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_comments}/{/if}{$salValue.record.total_comments}</span> 
												{if $salValue.record.total_comments > 1}{$LANG.blogpostlist_comments}
											{else}
												{$LANG.blogpostlist_comment}{/if}&nbsp;|&nbsp; 
											<span class="clsBoldFont">{if $myobj->getFormField('pg')=='postmostviewed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_views}/{/if}{$salValue.record.total_views}</span>
												{if $salValue.record.total_views > 1}{$LANG.blogpostlist_views}{else}{$LANG.blogpostlist_view}{/if}&nbsp;|&nbsp;
											 <span class="clsBoldFont">{if $myobj->getFormField('pg')=='postmostfavorite' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_favorites}/{/if}{$salValue.record.total_favorites}</span> 
												{if $salValue.record.total_favorites > 1}{$LANG.blogpostlist_favorites}{else}{$LANG.blogpostlist_favorite}{/if}&nbsp;|&nbsp;                  
											  {if $myobj->populateRatingDetails($salValue.record.rating)}
												 {$myobj->populateBlogRatingImages($salValue.record.rating,'blog')}
											  {else}
												 {$myobj->populateBlogRatingImages(0,'blog')}
											  {/if} 
											</p>
										 </div>
									 </div>
								  </div>
							 </div>
						</div>
					</div>
				{if ($myobj->getFormField('pg') == 'notapproved' || $myobj->getFormField('pg') == 'myposts') && $salValue.record.status =='Not Approved'}
					 <p class="clsViewTagsLink"> 
						<a id="adminComments_post{$salValue.record.blog_post_id}"  title="Admin Comments" href="#showAdminComments_post{$salValue.record.blog_post_id}">{$LANG.blogpostlist_view_admin_comments}</a> 
					 </p>
					 <div style="display: none;">
						 <div id="showAdminComments_post{$salValue.record.blog_post_id}" class="clsPostComments">
							  <h2>{$LANG.blogpostlist_post_admin_comments_title}</h2>
							  <p>{$salValue.record.blog_admin_comments}</p>
						 </div>
				  {* Added code to invoke jquery fancy box window to display admin comments for not apporved posts *}
				  {literal}
					<script type="text/javascript">
						$Jq(document).ready(function() {
						$Jq("#adminComments_post{/literal}{$salValue.record.blog_post_id}{literal}").fancybox({
						'titlePosition'		: 'inside',
						'transitionIn'		: 'none',
						'transitionOut'		: 'none'
						});
						});
					</script>
				  {/literal} 
				 </div>
			  {/if}   
			 {/if}
			{/foreach}
			</div>
			{if $showBlogPostList_arr.extra_td_tr}
			  <div>&nbsp;</div>
			{/if}
		</form>
		{if $CFG.admin.navigation.bottom}
			{$myobj->setTemplateFolder('general/','blog')}
			{include file='pagination.tpl'}
		{/if}
	{else}
		<div id="selMsgAlert">
			<p>{$LANG.blogpostlist_no_records_found}</p>
		</div>
	{/if}
  </div>
{/if}
</div>
</div>
<!--end of rounded corners-->
{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_bottom'}
{* Added code to invoke jquery fancy box window to display admin comments for not apporced blog post *}
{literal}
<script type="text/javascript">
	$Jq(document).ready(function() {
	$Jq("#adminComments").fancybox({
	'titlePosition'		: 'inside',
	'transitionIn'		: 'none',
	'transitionOut'		: 'none'
	});
	});
</script>
{/literal}
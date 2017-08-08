<div id="selArticleList">
	<!--rounded corners-->
  	{$myobj->setTemplateFolder('general/','article')}
    {include file='box.tpl' opt='article_list_top'}

	<form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		<input type="hidden" name="advanceFromSubmission" value="1"/>
    	{$myobj->populateArticleListHidden($paging_arr)}
    	<div class="clsOverflow">
      		<div class="clsArticleListHeading">
        		<h2><span>
                	{if $myobj->getFormField('pg')=='userarticlelist'}
          				{$LANG.articlelist_title}
          			{else}
          				{$LANG.articlelist_title|capitalize:true}
          			{/if}
                    </span>
                </h2>
      		</div>
      		<div class="clsArticleListHeadingRight">
        		<input type="hidden" name="default" id="default" value="{$myobj->getFormField('default')}" />
        		<select id="articlelistselect" name="select" onchange="loadUrl(this)">
	      			<option value="{php} echo getUrl('articlelist','?pg=articlenew','articlenew/','','article'){/php}" {if $myobj->getFormField('pg')==''} selected {/if} >
                    	{$LANG.header_nav_article_article_all}
                    </option>
          			<option value="{php} echo getUrl('articlelist','?pg=articlerecent','articlerecent/','','article'){/php}"{if $myobj->getFormField('pg')=='articlerecent'} selected {/if} >
          				{$LANG.header_nav_article_article_new}
                    </option>
          			<option value="{php} echo getUrl('articlelist','?pg=articletoprated','articletoprated/','','article'){/php}" {if $myobj->getFormField('pg')=='articletoprated'} selected {/if} >
			          {$LANG.header_nav_article_top_rated}
                    </option>
          			<option value="{php} echo getUrl('articlelist','?pg=articlemostviewed','articlemostviewed/','','article'){/php}"{if $myobj->getFormField('pg')=='articlemostviewed'} selected {/if} >
          				{$LANG.header_nav_article_most_viewed}
                    </option>
          			<option value="{php} echo getUrl('articlelist','?pg=articlemostdiscussed','articlemostdiscussed/','','article'){/php}" {if $myobj->getFormField('pg')=='articlemostdiscussed'} selected {/if} >
          				{$LANG.header_nav_article_most_discussed}
                    </option>
          			<option value="{php} echo getUrl('articlelist','?pg=articlemostfavorite','articlemostfavorite/','','article'){/php}" {if $myobj->getFormField('pg')=='articlemostfavorite'} selected {/if} >
				       {$LANG.header_nav_article_most_favorite}
                    </option>
        		</select>
      		</div>
    	</div>
    	{$myobj->setTemplateFolder('general/','article')}
    	{include file='../general/information.tpl'}
    	{if $myobj->getFormField('pg') == 'articlemostviewed' OR $myobj->getFormField('pg') == 'articlemostdiscussed' OR $myobj->getFormField('pg') == 'articlemostfavorite'}
	    	<div class="clsArtilceTabs">
	      		<ul class="clsSubMenu clsArticleLinks">
	        		<li {$articleActionNavigation_arr.articleMostViewed_0}><a href="javascript:void(0)" onclick="jumpAndSubmitForm('{$articleActionNavigation_arr.article_list_url_0}');"><span><span>{$LANG.header_nav_members_all_time}</span></span></a></li>
	                <li {$articleActionNavigation_arr.articleMostViewed_1}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$articleActionNavigation_arr.article_list_url_1}');"><span><span>{$LANG.header_nav_members_today}</span></span></a></li>
	                <li {$articleActionNavigation_arr.articleMostViewed_2}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$articleActionNavigation_arr.article_list_url_2}');"><span><span>{$LANG.header_nav_members_yesterday}</span></span></a></li>
	                <li {$articleActionNavigation_arr.articleMostViewed_3}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$articleActionNavigation_arr.article_list_url_3}');"><span><span>{$LANG.header_nav_members_this_week}</span></span></a></li>
	                <li {$articleActionNavigation_arr.articleMostViewed_4}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$articleActionNavigation_arr.article_list_url_4}');"><span><span>{$LANG.header_nav_members_this_month}</span></span></a></li>
	                <li {$articleActionNavigation_arr.articleMostViewed_5}><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('{$articleActionNavigation_arr.article_list_url_5}');"><span><span>{$LANG.header_nav_members_this_year}</span></span></a></li>
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
                var subMenuClassName1='clsArticleListMenu';
                var hoverElement1  = '.clsArticleListMenu li';
                loadChangeClass(hoverElement1,subMenuClassName1);
	        </script>
	        {/literal}
    	{/if}

        <div id="advanced_search" class="clsAdvancedSearch">
        	{$myobj->setTemplateFolder('general/','article')}
      	    {include file='box.tpl' opt='form_top'}
      		<div class="clsAdvancedSearchBg clsOverflow">
            <div class="clsAdvancedSearchField">
      			<table class="clsAdvancedFilterTable">
        			<tr>
                    	<td>
                        	<input class="clsTextBox" type="text" name="article_keyword" id="article_keyword" value="{if $myobj->getFormField('article_keyword') != ''}{$myobj->getFormField('article_keyword')}{else}{$LANG.articlelist_keyword_field}{/if}" onblur="setOldValue('article_keyword')" onfocus="clearValue('article_keyword')"/>
                        </td>
                    </tr>
                    <tr>
                        {if $myobj->getFormField('pg') != 'myarticles' && $myobj->getFormField('pg') != 'toactivate' && $myobj->getFormField('pg') != 'notapproved' &&
                                $myobj->getFormField('pg') != 'draftarticle' && $myobj->getFormField('pg') != 'infuturearticle' && $myobj->getFormField('pg') != 'publishedarticle'}
                        	<td><input class="clsTextBox" type="text" name="article_owner" id="article_owner" value="{if $myobj->getFormField('article_owner') != ''}{$myobj->getFormField('article_owner')}{else}{$LANG.articlelist_article_created_by}{/if}" onblur="setOldValue('article_owner')"  onfocus="clearValue('article_owner')"/></td>
						{/if}
                    </tr>
             </table>
             </div>
             <div class="clsAdvancedSearchBtn">
             <table>
                    <tr>
                    	<td colspan="2">
                        	<div class="clsSubmitLeft">
                            	<span class="clsSubmitRight">
                                	<input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.articlelist_search_categories_articles_submit}" />
                               	</span>
                           	</div>
                   		</td>
                    </tr>
                    <tr>
                  	     <td>
                            <div class="clsCancelLeft">
                            	<span class="clsCancelRight">
                                	{if $myobj->getFormField('pg') == 'articlenew' && !$myobj->getFormField('cid') && !$myobj->getFormField('sid')}
                                  		<input type="button" name="avd_reset" id="avd_reset" onclick="location.href='{$myobj->getUrl('articlelist', '?pg=articlenew', 'articlenew/', '', 'article')}'" value="{$LANG.articlelist_reset_submit}" />
                                  	{else}
                                  		<input type="submit" name="avd_reset" id="avd_reset" onclick="document.seachAdvancedFilter.start.value = '0';" value="{$LANG.articlelist_reset_submit}" />
                                  	{/if}
                                </span>
                            </div>
                        </td>
                    </tr>
		        </table>
                </div>
      		</div>
            {$myobj->setTemplateFolder('general/','article')}
      		{include file='box.tpl' opt='form_bottom'}
        </div>
  	</form>

    {if $myobj->isShowPageBlock('form_show_sub_category')}
    	<div class="clsAdvancedFilterSearch clsShowHideFilter" id="">
        	<a href="javascript:void(0)" id="show_link" class="clsShow clsShowFilterSearch"  {if $myobj->chkAdvanceResultFound()}  style="display:none" {/if} onclick="divShowHide('showHideSubCategory', 'show_link', 'hide_link')">{$LANG.articlelist_showarticle_subcategory}</a>
            <a href="javascript:void(0)" id="hide_link" {if !$myobj->chkAdvanceResultFound()}  style="display:none" {/if} class="clsHide clsHideFilterSearch"  onclick="divShowHide('showHideSubCategory', 'show_link', 'hide_link')">{$LANG.articlelist_hidearticle_subcategory}</a>
        </div>
        {$myobj->setTemplateFolder('general/','article')}
     	{include file='box.tpl' opt='article_content_top'}
    	<div class="clsArticlesSubcategoryContent" id="showHideSubCategory" style="display:none"><h2><span>{$LANG.articlelist_category_title}</span></h2>
        	<div id="selShowAllShoutouts">
            	{foreach key=scKey item=scValue from=$populateSubCategories_arr.row}
               		<div>
                    	<ul class="clsArticlesSubCategory">
                        	<li><a href="{$scValue.article_list_url}" title="{$scValue.article_category_name_manual}">{$scValue.article_category_name_manual}</a></li>
                        </ul>
                     </div>
            	{foreachelse}
                	<div id="selMsgError">
                    	<p>
                        	{$LANG.articlelist_no_sub_categories_found}
                    	</p>
                	</div>
            	{/foreach}
        	</div>
		</div>
        {$myobj->setTemplateFolder('general/','article')}
 		{include file='box.tpl' opt='article_content_bottom'}
    {/if}

	<div id="selLeftNavigation">
		<!-- Delete Single Articles -->
	    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
	    	<p id="msgConfirmText"></p>
	      	<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
				<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />&nbsp;
			    <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
			    <input type="hidden" name="act" id="act" />
			    <input type="hidden" name="article_id" id="article_id" />
	      	</form>
	    </div>
        <!-- Delete Multi Articles -->
        <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
          <p id="msgConfirmTextMulti">{$LANG.articlelist_multi_delete_confirmation}</p>
          <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		  	<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />&nbsp;
	        <input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
	        <input type="hidden" name="article_id" id="article_id" />
	        <input type="hidden" name="act" id="act" />
          </form>
        </div>

        <div id="selEditArticleComments" class="clsPopupConfirmation" style="display:none;"> </div>
            {if $myobj->isShowPageBlock('my_articles_form')}
            	<div id="selArticleListDisplay" class="clsLeftSideDisplayTable">
                	{if $myobj->isResultsFound()}
                    	{if $CFG.admin.navigation.top}
    						{$myobj->setTemplateFolder('general/','article')}
                         	{include file='pagination.tpl'}
                    	{/if}
                        <form name="articleListForm" id="articleListForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                        	{if isMember() && (($myobj->getFormField('user_id') == 0 && $CFG.user.user_id) || ($myobj->getFormField('user_id') == $CFG.user.user_id))}
		                        {if $myobj->getFormField('pg') == 'myarticles' || $myobj->getFormField('pg') == 'myfavoritearticles' || $myobj->getFormField('pg') == 'toactivate' || $myobj->getFormField('pg') == 'notapproved' ||
	                                $myobj->getFormField('pg') == 'draftarticle' || $myobj->getFormField('pg') == 'infuturearticle' || $myobj->getFormField('pg') == 'publishedarticle'}
                                    <div class="clsOverflow clsCheckAllItems">
	                            	<div id="selCheckAllItems" class="clsFloatLeft">
                                    <span class="clsCheckItem">
	                                	<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.articleListForm.name, document.articleListForm.check_all.name)" />
	                                  	<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.articlelist_delete_submit}" onclick="if(getMultiCheckBoxValue('articleListForm', 'check_all', '{$LANG.common_check_atleast_one}', '{$myobj->anchor}', -100, -500)) Confirmation('selMsgConfirmMulti', 'msgConfirmformMulti', Array('article_id','act', 'msgConfirmTextMulti'), Array(multiCheckValue, 'delete', '{$LANG.articlelist_multi_delete_confirmation}'), Array('value','value', 'innerHTML'), 0, 0);" />
                                        </span>
	                                </div>
                                    </div>
	                            {/if}
                            {/if}

                            <p><a href="#" id="{$myobj->anchor}"></a></p>
                            <div id="selDisplayTable">
                            	{foreach key=salKey item=salValue from=$showArticleList_arr.row}
                                	<div class="clsArticleListContent">
                                    	<a href="#" id="{$salValue.anchor}"></a>
                                        {if $salValue.record.article_status =='Locked'}
                                            <div class="clsHomeDispContent">
                                              <h3 class="clsTitleLink">{$salValue.row_article_title_manual}</h3>
                                              <!--<p>{$salValue.row_article_caption_manual}</p>-->
                                              <p class="clsAddedDate">{$LANG.articlelist_added}&nbsp;{$salValue.record.date_added}</p>
                                            </div>
                                        {else}
                                            <div class="clsHomeDispContent">
                                            	{*{if isMember()}
		                                            {if $myobj->getFormField('pg') == 'myarticles' || $myobj->getFormField('pg') == 'toactivate' || $myobj->getFormField('pg') == 'notapproved' ||
		                                            	$myobj->getFormField('pg') == 'draftarticle' || $myobj->getFormField('pg') == 'infuturearticle' || $myobj->getFormField('pg') == 'publishedarticle' || ($myobj->getFormField('pg') == 'articlenew' && $salValue.record.user_id == $CFG.user.user_id)}
		                                            	{if $salValue.record.user_id == $CFG.user.user_id}
		                                            	<ul class="clsContentEditLinks">
		                                                	<li class="clsCheckBox">
		                                                    	<span class="clsCheckItem">
		                                                    		<input type="checkbox" class="clsCheckRadio" name="article_ids[]"  value="{$salValue.record.article_id}" tabindex="{smartyTabIndex}" {$salValue.article_ids_checked}/>
		                                                      	</span>
		                                                    </li>
		                                                    {if $CFG.admin.articles.auto_activate}
		                                                    	<li class="clsEdit">
		                                                    		<a href="{$salValue.article_writing_url_ok}" class="clsArticleEditLinks" title="{$LANG.articlelist_edit_article}">{$LANG.articlelist_edit_article}</a>
		                                                    	</li>
		                                                    {/if}
		                                                    <li class="clsDelete">
		                                                    	<a href="#" class="clsArticleEditLinks" title="{$LANG.articlelist_delete_submit}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','article_id', 'msgConfirmText'), Array('delete','{$salValue.record.article_id}','{$LANG.articlelist_delete_confirmation}'), Array('value','value', 'innerHTML'), -100, -500);">{$LANG.articlelist_delete_submit}</a>
		                                                    </li>
		                                                 </ul>
		                                                 {/if}
		                                            {/if}
		                                           {/if}*}

												{*{if isMember()}
													{if $salValue.record.user_id == $CFG.user.user_id}
														<span class="clsCheckItem"><input type="checkbox" class="clsCheckRadio" name="article_ids[]"  value="{$salValue.record.article_id}" tabindex="{smartyTabIndex}" {$salValue.article_ids_checked}/></span>
													{/if}
												{/if}*}

												<div class="clsOverflow {if $myobj->getFormField('pg') == 'articlenew' || $myobj->getFormField('pg') == '' || $myobj->getFormField('pg') == 'userarticlelist' || $myobj->getFormField('pg') == 'articlerecent' || $myobj->getFormField('pg') == 'articletoprated' || $myobj->getFormField('pg') == 'articlemostviewed' ||  $myobj->getFormField('pg') == 'articlemostdiscussed' || $myobj->getFormField('pg') == 'articlemostfavorite' || $myobj->getFormField('pg') == 'myfavoritearticles'}clsAllArticles{/if}">
													{if isMember() && $salValue.record.user_id == $CFG.user.user_id}
														{if $myobj->getFormField('pg') == 'myarticles' || $myobj->getFormField('pg') == 'myfavoritearticles' || $myobj->getFormField('pg') == 'toactivate' || $myobj->getFormField('pg') == 'notapproved' ||
	                                						$myobj->getFormField('pg') == 'draftarticle' || $myobj->getFormField('pg') == 'infuturearticle' || $myobj->getFormField('pg') == 'publishedarticle'}
                                                				<div class="clsFloatLeft clsChkBox clsListChkBox">
																	<input type="checkbox" class="clsCheckRadio" name="article_ids[]"  value="{$salValue.record.article_id}" tabindex="{smartyTabIndex}" {$salValue.article_ids_checked}/>
                                                     			</div>
                                                     	{/if}
                                                     {/if}
													<div class="clsFloatLeft clsListTitle">
													<h3 class="clsTitleLink">
														{* Condition to display corrsponding image to indicate article status *}
														{if $myobj->getFormField('pg') == 'publishedarticle'}
					                                    	<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-published.gif" alt="{$LANG.articlelist_publishedarticle_title}" title="{$LANG.articlelist_publishedarticle_title}"/>
						                                {elseif $myobj->getFormField('pg') == 'toactivate'}
					                                    	<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-toactivate.gif" alt="{$LANG.articlelist_toactivatearticle_title}" title="{$LANG.articlelist_toactivatearticle_title}"/>
						                                {elseif $myobj->getFormField('pg') == 'draftarticle'}
					                                    	<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-draft.gif" alt="{$LANG.articlelist_draftarticle_title}" title="{$LANG.articlelist_draftarticle_title}"/>
						                                {elseif $myobj->getFormField('pg') == 'infuturearticle'}
					                                    	<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-infuture.gif" alt="{$LANG.articlelist_infuturearticle_title}" title="{$LANG.articlelist_infuturearticle_title}"/>
						                                {elseif $myobj->getFormField('pg') == 'notapproved'}
					                                    	<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-notapproved.gif" alt="{$LANG.articlelist_notapprovedarticle_title}" title="{$LANG.articlelist_notapprovedarticle_title}"/>
					                                    {elseif $myobj->getFormField('pg') == 'myarticles'}
					                                    	{if $salValue.record.article_status =='Ok'}
	                                							<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-published.gif" alt="{$LANG.articlelist_publishedarticle_title}" title="{$LANG.articlelist_publishedarticle_title}"/>
															{elseif $salValue.record.article_status =='ToActivate'}
	                                							<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-toactivate.gif" alt="{$LANG.articlelist_toactivatearticle_title}" title="{$LANG.articlelist_toactivatearticle_title}"/>
	                                						{elseif $salValue.record.article_status =='Draft'}
	                                							<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-draft.gif" alt="{$LANG.articlelist_draftarticle_title}" title="{$LANG.articlelist_draftarticle_title}"/>
	                                						{elseif $salValue.record.article_status =='InFuture'}
	                                							<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-infuture.gif" alt="{$LANG.articlelist_infuturearticle_title}" title="{$LANG.articlelist_infuturearticle_title}"/>
	                                						{elseif $salValue.record.article_status =='Not Approved'}
	                                							<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-notapproved.gif" alt="{$LANG.articlelist_notapprovedarticle_title}" title="{$LANG.articlelist_notapprovedarticle_title}"/>
	                                						{/if}
					                                    {/if}
														<a href="{$salValue.view_article_link}" title="{$salValue.row_article_title}">{$salValue.row_article_title_manual}</a>&nbsp;&nbsp;
													</h3>
													</div>
                                                </div>

	                                        	<div class="clsArticleDetails">
                                                <p>
                                                  {if $salValue.record.article_status =='Ok'}
                                                                <span class="clsDateRecord">{$LANG.articlelist_date_published}&nbsp;{$salValue.record.date_published}</span>
                                                            {else}
                                                                <span class="clsDateRecord">{$LANG.articlelist_date_added}&nbsp;{$salValue.record.date_added}</span>
                                                            {/if}
                                                            {if isMember() && $salValue.record.user_id == $CFG.user.user_id}
                                                                <span class="clsArticleEdit">
                                                               		<a href="{$salValue.article_writing_url_ok}" title="{$LANG.articlelist_edit_article}">{$LANG.articlelist_edit_article}</a>
                                                                </span>
                                                                <span class="clsArticleDelete">
                                                                    <a href="#" class="" title="{$LANG.articlelist_delete_submit}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','article_id', 'msgConfirmText'), Array('delete','{$salValue.record.article_id}','{$LANG.articlelist_delete_confirmation}'), Array('value','value', 'innerHTML'), -100, -500);">{$LANG.articlelist_delete_submit}</a>
                                                                </span>
                                                            {/if}
                                                     </p>
													<div id="articleUserProfile_{$salValue.record.article_id}" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$salValue.record.user_id}', 'articleUserProfile_{$salValue.record.article_id}');" onmouseout="hideUserInfoPopup('articleUserProfile_{$salValue.record.article_id}')"></div>
	                                    			<p>
	                                    				<a href="{$salValue.member_profile_url}"><span class="clsUserProfileImage" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}',
															'{$salValue.record.user_id}', 'articleUserProfile_{$salValue.record.article_id}');" onmouseout="hideUserInfoPopup('articleUserProfile_{$salValue.record.article_id}')"></span></a>
													</p>

	                                    			<p class="clsViewTagsLink">{$salValue.row_article_caption_manual}
                                                    {*
                                                    <a href="{$salValue.view_article_link}">{$LANG.articlelist_view_full_article}</a>
                                                    *}
                                                    </p>
                                                    <div class="clsOverflow">
                                                        <p class="clsArticleTagDetails clsArticleTag">
                                                            {if $myobj->getFormField('article_tags') != ''}
                                                                {assign var=article_tag value=$myobj->getFormField('article_tags')}
                                                            {elseif $myobj->getFormField('tags') != '' }
                                                                {assign var=article_tag value=$myobj->getFormField('tags')}
                                                            {else}
                                                                {assign var=article_tag value=''}
                                                            {/if}
                                                            <span>{$LANG.articlelist_search_article_tags}:</span>{if $salValue.record.article_tags!=''} {$myobj->getArticleTagsLinks($salValue.record.article_tags, 13, $article_tag)}{/if}
                                                        </p>
                                                        <p class="clsArticleViewDetails clsArticleCategegory">
                                                            {$LANG.articlelist_article_category_name}{$showArticleList_arr.separator}<span>{$salValue.row_article_category_name_manual}</span>
                                                        </p>
                                                    </div>
                                                    {if $myobj->getFormField('pg') == 'notapproved' || $myobj->getFormField('pg') == 'myarticles'}
	                                    				{if $salValue.record.article_status =='Not Approved'}
	                                    					<p class="clsViewAdminComment"><a id="adminComments{$salValue.record.article_id}"  title="Admin Comments" href="#showAdminComments{$salValue.record.article_id}">{$LANG.articlelist_view_admin_comments}</a></p>
                                                                  <div style="display: none;">
                                                                    <div id="showAdminComments{$salValue.record.article_id}" class="clsArticleComments">
                                                                     <h2>{$LANG.articlelist_admin_comments_title}</h2>
                                                                     <p>{$salValue.record.article_admin_comments}</p>																				                                                  					</div>
																{* Added code to invoke jquery fancy box window to display admin comments for not apporced articles *}
																{literal}
																	<script type="text/javascript">
																		$Jq(document).ready(function() {
																		$Jq("#adminComments{/literal}{$salValue.record.article_id}{literal}").fancybox({
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

                                            <div class="clsArticleDetMiddle">
                                                <div class="clsArticleDetLeft">
                                                    <div class="clsArticleDetRight clsOverflow">
                                                    <div class="clsArticleUser">
                                                        <p class="">
                                                        	 {$LANG.articlelist_added_by}
                                                             <a href="{$salValue.member_profile_url}" class="cls15x15 clsImageBorder ClsImageContainer">
                                                        	 <img src="{$salValue.member_image.s_url}" border="0" alt="{$salValue.name|truncate:2}" title="{$salValue.name}"  {$myobj->DISP_IMAGE(15, 15, $salValue.member_image.s_width, $salValue.member_image.s_height)}/></a>
                                                            <a href="{$salValue.member_profile_url}" title="{$salValue.name}"> {$salValue.name}</a>
                                                        </p>
                                                     </div>
                                                     <div class="clsArticleListDetails">
                                                        	<ul>
                                                            	<li>
                                                                    <span class="clsTotalComment">{if $myobj->getFormField('pg')=='articlemostdiscussed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_comments}/{/if}{$salValue.record.total_comments}</span>
                                                                    {if $salValue.record.total_comments > 1}{$LANG.articlelist_comments}{else}{$LANG.articlelist_comment}{/if}
                                                                </li>
                                                                <li>
                                                                    <span>{if $myobj->getFormField('pg')=='articlemostviewed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_views}/{/if}{$salValue.record.total_views}</span>
                                                                    {if $salValue.record.total_views > 1}{$LANG.articlelist_views}{else}{$LANG.articlelist_view}{/if}
                                                                </li>
                                                                <li>
                                                                    <span>{if $myobj->getFormField('pg')=='articlemostfavorite' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_favorites}/{/if}{$salValue.record.total_favorites}</span>
                                                                    {if $salValue.record.total_favorites > 1}{$LANG.articlelist_favorites}{else}{$LANG.articlelist_favorite}{/if}
                                                                </li>
                                                                {if $salValue.record.article_attachment}
                                                                    <li>
                                                                        <span>{$salValue.record.total_downloads}&nbsp;</span>
                                                                        {if $salValue.record.total_downloads > 1}{$LANG.articlelist_downloads}{else}{$LANG.articlelist_download}{/if}
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
                                       	{/if}
                                    </div>
								{/foreach}
                                {if $showArticleList_arr.extra_td_tr}
                                	<div>&nbsp;</div>
                                {/if}
                            </div>
                         </form>
                        {if $CFG.admin.navigation.bottom}
    						{$myobj->setTemplateFolder('general/','article')}
                            {include file='pagination.tpl'}
                        {/if}
                	{else}
                    	<div id="selMsgAlert" class="clsNoArticlesFound">
                        	<p>{$LANG.articlelist_no_records_found}</p>
                      	</div>
                	{/if}
                </div>
            {/if}
        {$myobj->setTemplateFolder('general/','article')}
       	{include file='box.tpl' opt='article_list_bottom'}
    	<!--end of rounded corners-->
	</div>
</div>
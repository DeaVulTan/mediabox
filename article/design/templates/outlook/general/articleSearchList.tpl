<div id="selArticleList">
	<!--rounded corners-->
    {if $myobj->isShowPageBlock('form_show_sub_category')}
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
		                        {*{if $myobj->getFormField('pg') == 'myarticles' || $myobj->getFormField('pg') == 'toactivate' || $myobj->getFormField('pg') == 'notapproved' ||
	                                $myobj->getFormField('pg') == 'draftarticle' || $myobj->getFormField('pg') == 'infuturearticle' || $myobj->getFormField('pg') == 'publishedarticle' || $myobj->getFormField('pg') == 'articlenew'}*}
                                    <div class="clsOverflow clsCheckAllItems">
	                                {if $myobj->getFormField('pg') == 'publishedarticle'}
	                                	<div class="clsFloatRight">
                                    		<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-published.gif" alt="{$LANG.articlelist_publishedarticle_title}" title="{$LANG.articlelist_publishedarticle_title}"/>
                                    	</div>
	                                {elseif $myobj->getFormField('pg') == 'toactivate'}
	                                	<div class="clsFloatRight">
                                    		<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-toactivate.gif" alt="{$LANG.articlelist_toactivatearticle_title}" title="{$LANG.articlelist_toactivatearticle_title}"/>
                                    	</div>
	                                {elseif $myobj->getFormField('pg') == 'draftarticle'}
	                                	<div class="clsFloatRight">
                                    		<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-draft.gif" alt="{$LANG.articlelist_draftarticle_title}" title="{$LANG.articlelist_draftarticle_title}"/>
                                    	</div>
	                                {elseif $myobj->getFormField('pg') == 'infuturearticle'}
	                                	<div class="clsFloatRight">
                                    		<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-infuture.gif" alt="{$LANG.articlelist_infuturearticle_title}" title="{$LANG.articlelist_infuturearticle_title}"/>
                                    	</div>
	                                {elseif $myobj->getFormField('pg') == 'notapproved'}
                                    	<div class="clsFloatRight">
                                    		<img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-notapproved.gif" alt="{$LANG.articlelist_notapprovedarticle_title}" title="{$LANG.articlelist_notapprovedarticle_title}"/>
                                    	</div>
                                    {/if}
                                    </div>
	                            {*{/if}*}
                            {/if}

                            <p><a href="#" id="{$myobj->anchor}"></a></p>
                            <div id="selDisplayTable">
                            	{foreach key=salKey item=salValue from=$showArticleSearchList_arr.row}
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

												<div class="clsOverflow">
													<div class="clsFloatLeft">
													<h3 class="clsTitleLink">
														<a href="{$salValue.view_article_link}" title="{$salValue.row_article_title_manual}">{$salValue.row_article_title_manual}</a>&nbsp;&nbsp;
														{if isMember() && $salValue.record.user_id == $CFG.user.user_id}
															<span class="clsArticleEditLinks"><a href="{$salValue.article_writing_url_ok}" title="{$LANG.articlelist_edit_article}">{$LANG.articlelist_edit_article}</a>&nbsp;&nbsp;
															<a href="#" class="" title="{$LANG.articlelist_delete_submit}" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','article_id', 'msgConfirmText'), Array('delete','{$salValue.record.article_id}','{$LANG.articlelist_delete_confirmation}'), Array('value','value', 'innerHTML'), -100, -500);">{$LANG.articlelist_delete_submit}</a></span>
														{/if}
													</h3>
													</div>

	                                    			{if $myobj->getFormField('pg') == 'myarticles'}
	                                    				{if $salValue.record.article_status =='Ok'}
	                                						<div class="clsFloatRight"><img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-published.gif" alt="{$LANG.articlelist_publishedarticle_title}" title="{$LANG.articlelist_publishedarticle_title}"/></div>
														{elseif $salValue.record.article_status =='ToActivate'}
	                                						<div class="clsFloatRight"><img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-toactivate.gif" alt="{$LANG.articlelist_toactivatearticle_title}" title="{$LANG.articlelist_toactivatearticle_title}"/></div>
	                                					{elseif $salValue.record.article_status =='Draft'}
	                                						<div class="clsFloatRight"><img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-draft.gif" alt="{$LANG.articlelist_draftarticle_title}" title="{$LANG.articlelist_draftarticle_title}"/></div>
	                                					{elseif $salValue.record.article_status =='InFuture'}
	                                						<div class="clsFloatRight"><img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-infuture.gif" alt="{$LANG.articlelist_infuturearticle_title}" title="{$LANG.articlelist_infuturearticle_title}"/></div>
	                                					{elseif $salValue.record.article_status =='Not Approved'}
	                                						<div class="clsFloatRight"><img src="{$CFG.site.article_url}/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/icon-notapproved.gif" alt="{$LANG.articlelist_notapprovedarticle_title}" title="{$LANG.articlelist_notapprovedarticle_title}"/></div>
	                                					{/if}
													{/if}</div>
	                                        	<div class="clsArticleDetails">
													<div id="articleUserProfile_{$salValue.record.article_id}" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}', '{$salValue.record.user_id}', 'articleUserProfile_{$salValue.record.article_id}');" onmouseout="hideUserInfoPopup('articleUserProfile_{$salValue.record.article_id}')"></div>
	                                    			<p>
	                                    				<a href="{$salValue.member_profile_url}"><span class="clsUserProfileImage" onmouseover="showUserInfoPopup('{$myobj->getUrl('userdetail')}',
															'{$salValue.record.user_id}', 'articleUserProfile_{$salValue.record.article_id}');" onmouseout="hideUserInfoPopup('articleUserProfile_{$salValue.record.article_id}')"></span></a>
													</p>
	                                    			<p class="clsArticleViewDetails">
														<a href="{$salValue.member_profile_url}" title="{$salValue.name}">
	                                     					{$salValue.name}</a>&nbsp;|&nbsp;
	                                     					{if $salValue.record.article_status =='Ok'}
	                                     						{if $myobj->getFormField('pg') != 'articlenew' && $myobj->getFormField('pg') != ''}
	                                     							{$LANG.articlelist_date_published}
	                                     						{/if}
	                                    						<span>{$salValue.record.date_published}</span>
	                                     					{else}
																{$LANG.articlelist_date_added}
	                                    						<span>{$salValue.record.date_added}</span>
	                                    					{/if}
															&nbsp;|&nbsp;
	                                    					<span class="clsTotalComment">{if $myobj->getFormField('pg')=='articlemostdiscussed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_comments}/{/if}{$salValue.record.total_comments}</span>
	                                    					{if $salValue.record.total_comments > 1}{$LANG.articlelist_comments}{else}{$LANG.articlelist_comment}{/if}&nbsp;|&nbsp;
	            											<span>{if $myobj->getFormField('pg')=='articlemostviewed' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_views}/{/if}{$salValue.record.total_views}</span>
	            											{if $salValue.record.total_views > 1}{$LANG.articlelist_views}{else}{$LANG.articlelist_view}{/if}&nbsp;|&nbsp;
															<span>{if $myobj->getFormField('pg')=='articlemostfavorite' && $myobj->getFormField('action')!='' && $myobj->getFormField('action')!=0}{$salValue.sum_total_favorites}/{/if}{$salValue.record.total_favorites}</span>
															{if $salValue.record.total_favorites > 1}{$LANG.articlelist_favorites}{else}{$LANG.articlelist_favorite}{/if}
	                                    					{if $salValue.record.article_attachment}&nbsp;|&nbsp;{$salValue.record.total_downloads}&nbsp;<span>{if $salValue.record.total_downloads > 1}{$LANG.articlelist_downloads}{else}{$LANG.articlelist_download}{/if}</span>{/if}
													</p>
	                                    			<p class="clsViewTagsLink">{$salValue.row_article_caption_manual}&nbsp;<a href="{$salValue.view_article_link}" title="{$LANG.articlelist_view_full_article}">{$LANG.articlelist_view_full_article}</a></p>
	                                    			<p class="clsArticleTagDetails">
							                			{if $myobj->getFormField('article_tags') != ''}
							                				{assign var=article_tag value=$myobj->getFormField('article_tags')}
							                			{elseif $myobj->getFormField('tags') != '' }
							                				{assign var=article_tag value=$myobj->getFormField('tags')}
							                			{else}
							                				{assign var=article_tag value=''}
							                			{/if}
	        											<span>{$LANG.articlelist_search_article_tags}:</span>{if $salValue.record.article_tags!=''} {$myobj->getArticleTagsLinks($salValue.record.article_tags, 13, $article_tag)}{/if}

	                                    			</p>
	                                    			<p class="clsArticleViewDetails">
	                                					<span>{$LANG.articlelist_article_category_name}{$showArticleSearchList_arr.separator}</span>{$salValue.row_article_category_name_manual}
	                                    			</p>
	                                    			{if $myobj->getFormField('pg') == 'notapproved' || $myobj->getFormField('pg') == 'myarticles'}
	                                    				{if $salValue.record.article_status =='Not Approved'}
	                                    					<p class="clsViewTagsLink"><a id="adminComments{$salValue.record.article_id}"  title="Admin Comments" href="#showAdminComments{$salValue.record.article_id}">{$LANG.articlelist_view_admin_comments}</a></p>
												  <div style="display: none;">
                                                    <div id="showAdminComments{$salValue.record.article_id}" class="clsArticleComments">
                                                     <h2>{$LANG.articlelist_admin_comments_title}</h2>
                                                     <p>{$salValue.record.article_admin_comments}</p>																				                                                  </div>
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
	                                    			<p class="clsRatingDisplay">
	                                            		{if $myobj->populateRatingDetails($salValue.record.rating)}
									               			{$myobj->populateArticleRatingImages($salValue.record.rating,'article')}
							                    		{else}
										                   {$myobj->populateArticleRatingImages(0,'article')}
									                    {/if}
	                                    			</p>
                                        		</div>
                                        	</div>
                                       	{/if}
                                    </div>
								{/foreach}
                                {if $showArticleSearchList_arr.extra_td_tr}
                                	<div>&nbsp;</div>
                                {/if}
                            </div>
                         </form>
                        {if $CFG.admin.navigation.bottom}
    						{$myobj->setTemplateFolder('general/','article')}
                            {include file='pagination.tpl'}
                        {/if}
                	{else}
                    	<div id="selMsgAlert">
                        	<p>{$LANG.articlelist_no_records_found}</p>
                      	</div>
                	{/if}
                </div>
            {/if}
    	<!--end of rounded corners-->
	</div>
</div>
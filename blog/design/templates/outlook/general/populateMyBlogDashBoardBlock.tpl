{if $opt == 'blog'}
			{assign var=css_temp value=''}
             {if $myobj->_currentPage == 'blogpostlist'}
                    {assign var=css_temp value=$myobj->_currentPage|cat:'_'|cat:$myobj->getFormField('pg')}
             {/if}
			{$myobj->setTemplateFolder('general/','blog')}
        	{include file="box.tpl" opt="sidebar_top"}
            {*CHECKED THE CONDITION IF ALLOWED THE BLOG UPLOAD FOR FAN MEMBER*}
            <p class="
            {if $myobj->_currentPage ==  'managepostcomments'}
                {$myobj->getBlogNavClass('left_managepostcomments')}
            {elseif $css_temp == 'blogpostlist_myposts'}
                {$myobj->getBlogNavClass('left_blogpostlist_myposts')}
            {elseif $css_temp == 'blogpostlist_myfavoriteposts'}
                {$myobj->getBlogNavClass('left_blogpostlist_myfavoriteposts')}
            {/if}    " ></p>
                        <div class="clsSideBarLeft">
                            <p class="clsSideBarLeftTitle">{$LANG.common_sidebar_myblog_dashboard_label}</p>
                        </div>

                <div class="clsSideBarRight clsNoPadding">
            {if !isMember()}
           <div class="clsblogMemberContainer clsNoBorder">
           	<div class="clsblogMemberDetails">
            	<p class="clsSignUpLink">
                	<a href="{$myobj->getUrl('signup')}">{$LANG.common_signup_label}</a>&nbsp; {$LANG.common_or_label} &nbsp;<a href="{$myobj->getUrl('login')}">{$LANG.common_login_label}</a>
                </p>
           	</div>
           </div>
           {/if}
            {assign var=blog_count value=1}
                   <div class="clsDashBoardBlock">
						<ul class="clsMyBlogListing" id="subblogID{$blog_count}">
                            <li class="{$myobj->getBlogNavClass('left_manageblog')} {if $myobj->_currentPage == 'manageblog'}clsActiveLink{/if}" >
                            {if $populateMyBlogDetail_arr.check_blog_added}
                             <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="{$myobj->getUrl('manageblog', '', '', 'members', 'blog')}">{$LANG.common_manage_edit_blog}</a></td>

								</tr>
							</table>
                             {else}
                               <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="{$myobj->getUrl('manageblog', '', '', 'members', 'blog')}">{$LANG.common_manage_add_blog}</a></td>
								</tr>
							</table>
                             {/if}
                            </li>
                             {if $populateMyBlogDetail_arr.check_blog_added}
                             <li class="{$myobj->getBlogNavClass('left_viewblog')} {if $myobj->_currentPage == 'viewblog'}clsActiveLink{/if}" >
                                  <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="{$populateMyBlogDetail_arr.my_blog_url}">{$LANG.common_manage_my_blog}</a></td>
								</tr>
							</table>
                            </li>
                             {/if}

                            <li class="{if $myobj->_currentPage == 'myposts' || $css_temp == 'blogpostlist_draftposts' || $css_temp == 'blogpostlist_notapproved' || $css_temp == 'blogpostlist_infutureposts' || $css_temp == 'blogpostlist_publishedposts' || $css_temp == 'blogpostlist_toactivate' ||  $css_temp == 'blogpostlist_myfavoriteposts'}clsActiveLink{else}{$myobj->getBlogNavClass('left_blogpostlist_myposts')}{/if} clsBlogSubMenu">
                                 <table>
							 	<tr>
									<td class="clsBlogLinksDashboard"><a  href="{$myobj->getUrl('blogpostlist', '?pg=myposts', 'myposts/', 'members', 'blog')}">{$LANG.common_sidebar_mypost_label}</a></td>
									<td><a href="javascript:void(0)"  id="mainblogID{$blog_count}" onClick="showHideMenu('ancPlaylist', 'blogSubMenu','1','{$blog_count}', 'mainblogID')" {if $css_temp == 'blogpostlist_draftposts' || $css_temp == 'blogpostlist_notapproved' || $css_temp == 'blogpostlist_infutureposts' || $css_temp == 'blogpostlist_publishedposts' || $css_temp == 'blogpostlist_toactivate'} class="clsHideSubmenuLinks" {else} class="clsShowSubmenuLinks"{/if}>{$LANG.common_myblogpost_detail_show}</a></td>
                            	  </tr>
								</table>
	                            <ul id="blogSubMenu{$blog_count}" {if $myobj->_currentPage == 'blogpostlist_myposts' || $css_temp == 'blogpostlist_toactivate' || $css_temp == 'blogpostlist_notapproved' || $css_temp == 'blogpostlist_draftposts' || $css_temp == 'blogpostlist_publishedposts' || $css_temp == 'blogpostlist_infutureposts' || $css_temp == 'blogpostlist_myfavoriteposts'}style="display:block;"{else}style="display:none;"{/if}>
                                    <li class="{$myobj->getBlogNavClass('left_blogpostlist_toactivate')}">
                                        <a  href="{$myobj->getUrl('blogpostlist', '?pg=toactivate', 'toactivate/', 'members', 'blog')}">{$LANG.common_sidebar_toactivate_mypost}</a>
                                    </li>
                                    <li class="{$myobj->getBlogNavClass('left_blogpostlist_notapproved')}">
                                        <a  href="{$myobj->getUrl('blogpostlist', '?pg=notapproved', 'notapproved/', 'members', 'blog')}">{$LANG.common_sidebar_not_approvedpost}</a>
                                    </li>
                                    <li class="{$myobj->getBlogNavClass('left_blogpostlist_draftposts')}">
                                        <a  href="{$myobj->getUrl('blogpostlist', '?pg=draftposts', 'draftposts/', 'members', 'blog')}">{$LANG.common_sidebar_draftposts}</a>
                                    </li>
                                    <li class="{$myobj->getBlogNavClass('left_blogpostlist_infutureposts')}">
                                        <a  href="{$myobj->getUrl('blogpostlist', '?pg=infutureposts', 'infutureposts/', 'members', 'blog')}">{$LANG.common_sidebar_infutureposts}</a>
                                    </li>
                                    <li class="{$myobj->getBlogNavClass('left_blogpostlist_publishedposts')}">
                                        <a  href="{$myobj->getUrl('blogpostlist', '?pg=publishedposts', 'publishedposts/', 'members', 'blog')}">{$LANG.common_sidebar_publishedposts}</a>
                                    </li>
                                    <li class="{$myobj->getBlogNavClass('left_blogpostlist_myfavoriteposts')}">
                                        <a  href="{$myobj->getUrl('blogpostlist', '?pg=myfavoriteposts', 'myfavoriteposts/', 'members', 'blog')}">{$LANG.common_sidebar_myfavoriteposts}</a>
                                    </li>
	                            </ul>
							</li>
                            <li class="{$myobj->getBlogNavClass('left_manageblogpost')} {if $myobj->_currentPage == 'manageblogpost'}clsActiveLink{/if}" >
                                  <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a  href="{$myobj->getUrl('manageblogpost', '', '', 'members', 'blog')}">{$LANG.common_blog_new_post}</a></td>

								</tr>
							</table>
                            </li>
                            <li class="{$myobj->getBlogNavClass('left_managepostcomments')} {if $myobj->_currentPage == 'managepostcomments'}clsActiveLink{/if}">
                                     <table>
							 	<tr>
									<td colspan="2" class="clsBlogLinksDashboard"><a href="{$myobj->getUrl('managepostcomments', '', '', 'members', 'blog')}">{$LANG.common_sidebar_post_comments_label}</a></td>
								</tr>
							</table>
                            </li>
                        </ul>
                    </div>
            </div>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" />
			{$myobj->setTemplateFolder('general/','blog')}
            {include file="box.tpl" opt="sidebar_bottom"}

{/if}

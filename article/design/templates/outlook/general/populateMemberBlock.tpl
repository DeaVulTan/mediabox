{if $opt == 'article'}
    	  <!--<div class="clsSideBarLinks">
            <div class="clsSideBar">
                <div class="clsSideBarLeft">
                   <p class="clsSideBarLeftTitle">{$LANG.sidebar_myarticle_label}</p>
                </div>
                <div class="clsSideBarRight">
                    <div class="clsSideBarContent">
                        <ul>
                            {assign var=css_temp value=''}
                            {if $flag}
                                {assign var=css_temp value=$myobj->_currentPage|cat:'_'|cat:$myobj->getFormField('pg')}
                            {/if}
                            {*CHECKED THE CONDITION IF ALLOWED THE article UPLOAD FOR FAN MEMBER*}
                            {if isAllowedArticleUpload()}
                        </ul>
                    </div>
                </div>
            </div>
        </div>-->
            {$myobj->setTemplateFolder('general/','article')}
        	{include file="box.tpl" opt="sidebar_top"}
        	{*{if $header->_currentPage == 'index' && isMember()}*}
            {if $header->_currentPage == 'index1' && isMember()}
            	<div class="clsarticleMemberContainer clsNoBorder">
                	<div class="clsarticleMemberThumb">
                    	<div class="clsThumbImageLink">
                        	<a href="{$populateMemberDetail_arr.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls45x45 clsPointer">
                                <img src="{$populateMemberDetail_arr.icon.m_url}" title="{$populateMemberDetail_arr.name}" />
                            </a>
                        </div>
                    </div>
                    <div class="clsarticleMemberDetails ">
                        <p class="clsBold clsMyarticleUser"><a href="{$populateMemberDetail_arr.memberProfileUrl}" title="{$populateMemberDetail_arr.name}">{$populateMemberDetail_arr.name}</a></p>
                        <p>{$LANG.sidebar_totalarticle_label}<span><a href="{$myobj->getUrl('articlelist', '?pg=myarticle', 'myarticle/', 'members', 'article')}">{$populateMemberDetail_arr.total_article}</a></span></p>
                    </div>
                </div>
           {/if}

            {/if}
            {*CHECKED THE CONDITION IF ALLOWED THE Article UPLOAD FOR FAN MEMBER*}
            <p class="
            {if $myobj->_currentPage ==  'managearticlecomments'}
                {$myobj->getArticleNavClass('left_managearticlecomments')}
            {elseif $css_temp == 'articlelist_myarticles'}
                {$myobj->getArticleNavClass('left_articlelist_myarticles')}
            {elseif $css_temp == 'articlelist_myfavoritearticles'}
                {$myobj->getArticleNavClass('left_articlelist_myfavoritearticles')}
            {/if}    " >
                {assign var=article_count value=1}
                        <div class="clsSideBarLeft">
                            <p class="clsSideBarLeftTitle">{$LANG.sidebar_myarticle_dashboard_label}</p>
                                {*<span {if $myobj->_currentPage == 'managearticlecomments' || $css_temp == 'articlelist_myarticles' || $css_temp == 'articlelist_myfavoritearticles'} class="clsCloseBtn" {else} class="clsCloseBtn"{/if} href="javascript:void(0)" id="mainarticleID{$article_count}" onClick="showHideMenu('ancPlaylist', 'subarticleID','1','{$article_count}', 'mainarticleID')">{$LANG.sidebar_show_label}</span>*}
                        </div>
                <div class="clsSideBarRight clsNoPadding">
		            {if !isMember()}
		           <div class="clsarticleMemberContainer clsNoBorder">
		           	<div class="clsarticleMemberDetails">
		            	<p class="clsSignUpLink">
		                	<a href="{$myobj->getUrl('signup')}">{$LANG.common_signup_label}</a>&nbsp; {$LANG.common_or_label} &nbsp;<a href="{$myobj->getUrl('login')}">{$LANG.common_login_label}</a>
		                </p>
		           	</div>
		           </div>
		           {/if}
                   <div class="clsSideBarContent">
                       {*<ul class="clsMyArticleListing" id="subarticleID{$article_count}" {if $myobj->_currentPage == 'articlelist_myarticles' || $css_temp == 'articlelist_toactivate' || $css_temp == 'articlelist_notapproved' || $css_temp == 'articlelist_draftarticle' || $css_temp == 'articlelist_livearticle' || $css_temp == 'articlelist_publishedarticle' || $css_temp == 'articlelist_infuturearticle'}style="display:block;"{else}style="display:none;"{/if}>*}
						<ul class="clsMyArticleListing" id="subarticleID{$article_count}">
                            <li class="{$myobj->getArticleNavClass('left_articleuploadpopup')} {if $myobj->_currentPage == 'articlewriting'}clsActiveLink{/if}" >
                             <a  href="{$myobj->getUrl('articlewriting', '', '', 'members', 'article')}">{$LANG.common_article_upload}</a>
                            </li>
                            <li class="{$myobj->getArticleNavClass('left_articlelist_articlenew')} {if $myobj->_currentPage == 'articlenew'}clsActiveLink{/if}" >
                             <a  href="{$myobj->getUrl('articlelist','?pg=articlenew','articlenew/','','article')}">{$LANG.sidebar_allarticle}</a>
                            </li>
                            <li class="{if $myobj->_currentPage == 'myarticles' || $css_temp == 'articlelist_myfavoritearticles' || $css_temp == 'articlelist_draftarticle' || $css_temp == 'articlelist_notapproved' || $css_temp == 'articlelist_infuturearticle' || $css_temp == 'articlelist_publishedarticle' || $css_temp == 'articlelist_toactivate'}clsActiveLink{else}{$myobj->getArticleNavClass('left_articlelist_myarticles')}{/if} clsArticleSubMenu">
                            	<table>
                            		<tbody>
                            			<tr>
                            				<td class="clsNoSubmenuImg"><a  href="{$myobj->getUrl('articlelist', '?pg=myarticles', 'myarticles/', 'members', 'article')}">{$LANG.sidebar_myarticle_label}</a></td>
                            				<td><a href="javascript:void(0)" id="mainarticleID{$article_count}" onClick="showHideMenu('ancPlaylist', 'articleSubMenu','1','{$article_count}', 'mainarticleID')" {if $css_temp == 'articlelist_draftarticle' || $css_temp == 'articlelist_notapproved' || $css_temp == 'articlelist_infuturearticle' || $css_temp == 'articlelist_publishedarticle' || $css_temp == 'articlelist_toactivate' || $css_temp == 'articlelist_myarticles'} class="clsHideSubmenuLinks" {else}class="clsShowSubmenuLinks"{/if}>{$LANG.common_show}</a></td>
                            			</tr>
									</tbody>
								</table>
                                {*<ul>
                                	<li>
                                		<a href="javascript:void(0)" id="mainarticleID{$article_count}" onClick="showHideMenu('ancPlaylist', 'articleSubMenu','1','{$article_count}', 'mainarticleID')">{$LANG.common_show}</a>
									</li>
								</ul>*}

	                            <ul id="articleSubMenu{$article_count}" {if $css_temp == 'articlelist_myarticles' || $css_temp == 'articlelist_myfavoritearticles' || $css_temp == 'articlelist_toactivate' || $css_temp == 'articlelist_notapproved' || $css_temp == 'articlelist_draftarticle' || $css_temp == 'articlelist_livearticle' || $css_temp == 'articlelist_publishedarticle' || $css_temp == 'articlelist_infuturearticle'}style="display:block;"{else}style="display:none;"{/if}>
	                            <li class="{$myobj->getArticleNavClass('left_articlelist_myarticles')}">
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=myarticles', 'myarticles/', 'members', 'article')}">{$LANG.sidebar_myarticle_label}</a>
	                            </li>
	                            <li class="{$myobj->getArticleNavClass('left_articlelist_myfavoritearticles')}">
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=myfavoritearticles', 'myfavoritearticles/', 'members', 'article')}">{$LANG.sidebar_favourite_article_label}</a>
	                            </li>
	                            <li class="{$myobj->getArticleNavClass('left_articlelist_toactivate')}" {*{if $myobj->_currentPage == 'articlelist_toactivate'}clsActiveLink{/if}*}>
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=toactivate', 'toactivate/', 'members', 'article')}">{$LANG.sidebar_toactivate_myarticle}</a>
	                            </li>
	                            <li class="{$myobj->getArticleNavClass('left_articlelist_notapproved')}">
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=notapproved', 'notapproved/', 'members', 'article')}">{$LANG.sidebar_not_approvedarticle}</a>
	                            </li>
	                            <!--li class="{$myobj->getArticleNavClass('left_articlelist_livearticle')}">
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=livearticle', 'livearticle/', 'members', 'article')}">{$LANG.sidebar_in_livearticle}</a>
	                            </li-->
	                            <li class="{$myobj->getArticleNavClass('left_articlelist_draftarticle')}">
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=draftarticle', 'draftarticle/', 'members', 'article')}">{$LANG.sidebar_draftarticle}</a>
	                            </li>
	                            <li class="{$myobj->getArticleNavClass('left_articlelist_infuturearticle')}">
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=infuturearticle', 'infuturearticle/', 'members', 'article')}">{$LANG.sidebar_infuturearticle}</a>
	                            </li>
	                            <li class="{$myobj->getArticleNavClass('left_articlelist_publishedarticle')}">
	                                <a  href="{$myobj->getUrl('articlelist', '?pg=publishedarticle', 'publishedarticle/', 'members', 'article')}">{$LANG.sidebar_publishedarticle}</a>
	                            </li>
	                            </ul>
							</li>
                            <li class="{$myobj->getArticleNavClass('left_managearticlecomments')} {if $myobj->_currentPage == 'managearticlecomments'}clsActiveLink{/if}">
                                <a href="{$myobj->getUrl('managearticlecomments', '', '', 'members', 'article')}">{$LANG.sidebar_article_comments_label}</a>
                            </li>
                        </ul>
                	</ul>
            	</div>
        	</div>
    	</p>
	<input type="hidden" value="1" id="memberCount"  name="memberCount" />
    {$myobj->setTemplateFolder('general/','article')}
    {include file="box.tpl" opt="sidebar_bottom"}
{/if}

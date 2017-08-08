{if $CFG.site.script_name == 'index.php'}
<!-- Blog whats going start -->
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="sidebar_whatsgoing_top"}
	<div class="clsWhatgoingHeading clsOverflow">
		<div class="clsFloatLeft" id="indexActivitesTabs">
			<div class="clsTagsRightTab">
					<h3 class="clsFloatLeft">{$LANG.header_nav_whats_goingon_activity_title_lbl}</h3>
					<ul class="clsFloatRight">
					{if isMember()}
						<li><a href="index.php?activity_type=My">{$LANG.header_nav_whats_goingon_activity_my}</a></li>
						<li><a href="index.php?activity_type=Friends">{$LANG.header_nav_whats_goingon_activity_friends}</a></li>
					{/if}
						<li><a href="index.php?activity_type=All">{$LANG.header_nav_whats_goingon_activity_all}</a></li>
					</ul>
				</div>
		</div>
	</div>
<script type="text/javascript">
{literal}
$Jq(window).load(function(){
	attachJqueryTabs('indexActivitesTabs');
});
{/literal}
</script>
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="sidebar_whatsgoing_bottom"}
<!-- Blog whats going on ends -->
</div>
{/if}


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
            {/if}    " >
                        <div class="clsSideBarLeft">
                            <p class="clsSideBarLeftTitle">{$LANG.common_sidebar_myblock_mypost_label}</p>
                        </div>
                <div class="clsSideBarRight clsNoPadding">
            {assign var=blog_count value=1}
                   <div class="clsSideBarContent">
						<ul class="clsMyBlogListing" id="subblogID{$blog_count}">
                             <li class="{$myobj->getBlogNavClass('left_bloglist')} {if $myobj->_currentPage == 'bloglist'}clsActiveLink{/if}" >
                                 <a  href="{$myobj->getUrl('bloglist', '', '', '', 'blog')}">{$LANG.common_manage_all_blogs}</a>
                            </li>
                            <li class="{$myobj->getBlogNavClass('left_blogpostlist_postnew')} {if $myobj->_currentPage == 'postnew'}clsActiveLink{/if}" >
                             <a  href="{$myobj->getUrl('blogpostlist','?pg=postnew','postnew/','','blog')}">{$LANG.common_sidebar_allpost}</a>
                            </li>
                        </ul>
                    </div>
            </p>
            <input type="hidden" value="1" id="memberCount"  name="memberCount" />
			{$myobj->setTemplateFolder('general/','blog')}
            {include file="box.tpl" opt="sidebar_bottom"}

{/if}

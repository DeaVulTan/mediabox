{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="userinfo_top"}
    <div class="clsViewPostUserDetailsContent">
       <!--<p class="clsSideBarLeftTitle">{$LANG.common_sidebar_user_info_title}</p> -->
         <div class="clsMarginTop10 clsOverflow">
          <div class="clsUserInfoLeft">
				<a href="{$blogDetail.profile_url}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
					  <img src="{$blogDetail.profileIcon.m_url}" alt="{$blogDetail.user_name}" title="{$blogDetail.user_name}" {$myobj->DISP_IMAGE(45, 45, $blogDetail.width, $blogDetail.height)}>
				</a>

           </div>
          <div class="clsUserInfoRight">
             <p class="clsUserInfo">by <a href="#">{$blogDetail.user_name|capitalize}</a>&nbsp;|&nbsp;on&nbsp;<span>{$blogDetail.date_added}</span></p>
             <!--<p class="clsUserInfoBg"><a href="{$blogDetail.profile_url}">{$LANG.common_sidebar_view_profile}</a></p> -->
             <div class="clsOverflow">
			 <div class="clsFloatLeft clsUserInfoBg">{$LANG.common_sidebar_total_posted} : <span>{$blogDetail.total_post}</span></div>
			 <div class="clsMarginTop5 clsFloatRight">
			 	<span class="clsSubscribeTab"><a href="{$myobj->getFormField('blog_rss_url')}">{$LANG.common_sidebar_subscribe}</a></span>
			</div>
			</div>
          </div>
         </div>
    </div>
{$myobj->setTemplateFolder('general/','blog')}
{include file="box.tpl" opt="userinfo_bottom"}





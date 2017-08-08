{foreach item=articleValue from=$articleActivity_arr}
   {if $key == $articleValue.parent_id}
    	{if $articleValue.action_key == 'article_uploaded'}
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="{$articleValue.article_uploaded.uploaded_user.url}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="{$articleValue.article_uploaded.user_article.imgsrc.m_url}" alt="{$articleValue.article_uploaded.user_name|truncate:5}" title="{$articleValue.article_uploaded.user_name}"  {$myobj->DISP_IMAGE(45, 45, $articleValue.article_uploaded.user_article.imgsrc.s_width, $articleValue.article_uploaded.user_article.imgsrc.s_height)}/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="{$articleValue.article_uploaded.uploaded_user.url}">{$articleValue.article_uploaded.user_name}</a>
                            </div>
                            <div class="clsFloatRight"><span>{$articleValue.article_uploaded.date_added}</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="{$CFG.site.url}article/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/article_upload.gif" alt="" border="0" />
                            {$articleValue.article_uploaded.lang}
                            <a href="{$articleValue.article_uploaded.viewarticle.url}">{$articleValue.article_uploaded.article_title}</a>
                        </div>
                    </div>
                </div>
            </div>

        {elseif $articleValue.action_key == 'article_comment'}
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="{$articleValue.article_comment.comment_user.url}"  class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img src="{$articleValue.article_comment.user_article.imgsrc.m_url}" alt="{$articleValue.article_comment.user_name|truncate:5}" title="{$articleValue.article_comment.user_name}"  {$myobj->DISP_IMAGE(45, 45, $articleValue.article_comment.user_article.imgsrc.s_width, $articleValue.article_comment.user_article.imgsrc.s_height)}/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="{$articleValue.article_comment.comment_user.url}">
                            {$articleValue.article_comment.user_name}</a></div>
                            <div class="clsFloatRight"><span>{$articleValue.article_comment.date_added}</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="{$CFG.site.url}article/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/article_comment.gif" alt="" border="0" />
                            {$articleValue.article_comment.lang}
                            <a href="{$articleValue.article_comment.viewarticle.url}">{$articleValue.article_comment.article_title}</a>
                        </div>
                    </div>
                </div>
            </div>

		{elseif $articleValue.action_key == 'article_rated'}
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="{$articleValue.article_rated.comment_user.url}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="{$articleValue.article_rated.user_article.imgsrc.m_url}" alt="{$articleValue.article_rated.user_name|truncate:5}" title="{$articleValue.article_rated.user_name}"  {$myobj->DISP_IMAGE(45, 45, $articleValue.article_rated.user_article.imgsrc.s_width, $articleValue.article_rated.user_article.imgsrc.s_height)}/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="{$articleValue.article_rated.comment_user.url}">
                            {$articleValue.article_rated.user_name|ucwords}</a></div>
                            <div class="clsFloatRight"><span>{$articleValue.article_rated.date_added}</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="{$CFG.site.url}article/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/article_rated.gif" alt="" border="0" />{$articleValue.article_rated.lang}
                            <a href="{$articleValue.article_rated.viewarticle.url}">{$articleValue.article_rated.article_title}</a>
                        </div>
                    </div>
                </div>
            </div>

         {elseif $articleValue.action_key == 'article_favorite'}
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="{$articleValue.article_favorite.comment_user.url}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="{$articleValue.article_favorite.user_article.imgsrc.m_url}" alt="{$articleValue.article_favorite.user_name|truncate:5}" title="{$articleValue.article_favorite.user_name}"  {$myobj->DISP_IMAGE(45, 45, $articleValue.article_favorite.user_article.imgsrc.s_width, $articleValue.article_favorite.user_article.imgsrc.s_height)}/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="{$articleValue.article_favorite.comment_user.url}">
                            {$articleValue.article_favorite.user_name|ucwords}</a></div>
                            <div class="clsFloatRight"><span>{$articleValue.article_favorite.date_added}</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="{$CFG.site.url}article/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/article_favorite.gif" alt="" border="0" />              {$articleValue.article_favorite.lang}
                            <a href="{$articleValue.article_favorite.viewarticle.url}">{$articleValue.article_favorite.article_title}</a>
                        </div>
                    </div>
                </div>
            </div>

         {elseif $articleValue.action_key == 'article_share'}
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="{$articleValue.article_share.sender.url}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="{$articleValue.article_share.user_article.imgsrc.m_url}" alt="{$articleValue.article_share.sender_user_name|truncate:5}" title="{$articleValue.article_share.sender_user_name}"  {$myobj->DISP_IMAGE(45, 45, $articleValue.article_share.user_article.imgsrc.s_width, $articleValue.article_share.user_article.imgsrc.s_height)}/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="{$articleValue.article_share.sender.url}">{$articleValue.article_share.sender_user_name}</a></div>

                            {foreach item=firendList from=$articleValue.article_share.firend_list}
                            <div class="clsFloatLeft"><a href="{$firendList.url}">{$firendList.firend_name}</a></div>
                            {/foreach}
                            <div class="clsFloatRight"><span>{$articleValue.article_share.date_added}</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                        	<img src="{$CFG.site.url}article/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/article_share.gif" alt="" border="0" />
                             {$articleValue.article_share.lang1}
                             {$articleValue.article_share.lang2}
                            </div>
              		  </div>
                </div>
            </div>
        {/if}
 	{/if}
{/foreach}
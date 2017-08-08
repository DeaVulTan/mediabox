{foreach item=photoValue from=$photoActivity_arr}
   {if $key == $photoValue.parent_id}
    	{if $photoValue.action_key == 'photo_uploaded'}
<div class="clsWhatsGoingUserDetails">
  <div class="clsWhatsGoingBg clsOverflow">
       <div class="clsFloatLeft">
           <a href="{$photoValue.photo_uploaded.uploaded_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
              <img src="{$photoValue.photo_uploaded.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_uploaded.user_name|truncate:5}" title="{$photoValue.photo_uploaded.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_uploaded.user_photo.imgsrc.s_width, $photoValue.photo_uploaded.user_photo.imgsrc.s_height)}/>
            </a>
        </div>
      <div class="clsUserDetailsFriends">
                <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.photo_uploaded.uploaded_user.url}"> {$photoValue.photo_uploaded.user_name} </a>  </div>
                  <div class="clsFloatRight"> <span>{$photoValue.photo_uploaded.date_added}</span> </div>
               </div>
               <div class="clsUserActivityWhtsgoing">
                        <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_upload.gif" alt="" border="0" />
                       {$photoValue.photo_uploaded.lang}
                    <a class="clsActivityTitle" href="{$photoValue.photo_uploaded.viewphoto.url}"> {$photoValue.photo_uploaded.photo_title} </a>
               </div>
      </div>
  </div>
</div>
{elseif $photoValue.action_key == 'photo_comment'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
              <a href="{$photoValue.photo_comment.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="{$photoValue.photo_comment.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_comment.user_name|truncate:5}" title="{$photoValue.photo_comment.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_comment.user_photo.imgsrc.s_width, $photoValue.photo_comment.user_photo.imgsrc.s_height)}/>
              </a>
          </div>
      <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.photo_comment.comment_user.url}"> {$photoValue.photo_comment.user_name} </a> </div>
                  <div class="clsFloatRight"> <span>{$photoValue.photo_comment.date_added}</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                    <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_comment.gif" alt="" border="0" />
                    {$photoValue.photo_comment.lang}
                    <a class="clsActivityTitle" href="{$photoValue.photo_comment.viewphoto.url}"> {$photoValue.photo_comment.photo_title} </a>
                  
              </div>
      </div>
   </div>
</div>
{elseif $photoValue.action_key == 'photo_rated'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
             <a href="{$photoValue.photo_rated.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="{$photoValue.photo_rated.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_rated.user_name|truncate:5}" title="{$photoValue.photo_rated.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_rated.user_photo.imgsrc.s_width, $photoValue.photo_rated.user_photo.imgsrc.s_height)}/>
              </a>
          </div>
         <div class="clsUserDetailsFriends">
                 <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.photo_rated.comment_user.url}"> {$photoValue.photo_rated.user_name|ucwords} </a>  </div>
                  <div class="clsFloatRight"> <span>{$photoValue.photo_rated.date_added}</span> </div>
                </div>
                <div class="clsUserActivityWhtsgoing">
               		<img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_rated.gif" alt="" border="0" />
                    {$photoValue.photo_rated.lang} 
                 <a class="clsActivityTitle" href="{$photoValue.photo_rated.viewphoto.url}"> {$photoValue.photo_rated.photo_title} </a>
                </div>
        </div>
    </div>
 </div>
{elseif $photoValue.action_key == 'photo_favorite'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="{$photoValue.photo_favorite.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                <img src="{$photoValue.photo_favorite.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_favorite.user_name|truncate:5}" title="{$photoValue.photo_favorite.user_name}"  {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_favorite.user_photo.imgsrc.s_width, $photoValue.photo_favorite.user_photo.imgsrc.s_height)}/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.photo_favorite.comment_user.url}"> {$photoValue.photo_favorite.user_name|ucwords} </a> </div>
                  <div class="clsFloatRight"> <span>{$photoValue.photo_favorite.date_added}</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_favourite.gif" alt="" border="0" />
                     {$photoValue.photo_favorite.lang}
                 <a class="clsActivityTitle" href="{$photoValue.photo_favorite.viewphoto.url}"> {$photoValue.photo_favorite.photo_title} </a>
              </div>
          </div>
    </div>
 </div>
{elseif $photoValue.action_key == 'photo_featured'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
           <div class="clsFloatLeft">
               <a href="{$photoValue.photo_featured.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                <img src="{$photoValue.photo_featured.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_featured.user_name|truncate:5}" title="{$photoValue.photo_featured.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_featured.user_photo.imgsrc.s_width, $photoValue.photo_featured.user_photo.imgsrc.s_height)}/>
               </a>
           </div>
         <div class="clsUserDetailsFriends">
                 <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.photo_featured.comment_user.url}"> {$photoValue.photo_featured.user_name|ucwords} </a> </div>
                  <div class="clsFloatRight"> <span>{$photoValue.photo_featured.date_added}</span> </div>
                </div>
                <div class="clsUserActivityWhtsgoing">
                    <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_featured.gif" alt="" border="0" />
                    {$photoValue.photo_featured.lang}
                 <a class="clsActivityTitle" href="{$photoValue.photo_featured.viewphoto.url}"> {$photoValue.photo_featured.photo_title} </a>
                </div>
          </div>
    </div>
</div>
{elseif $photoValue.action_key == 'photo_responded'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="{$photoValue.photo_responded.responses_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="{$photoValue.photo_responded.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_responded.responses_user_name|truncate:5}" title="{$photoValue.photo_responded.responses_user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_responded.user_photo.imgsrc.s_width, $photoValue.photo_responded.user_photo.imgsrc.s_height)}/>
              </a>
          </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.photo_responded.responses_user.url}">{$photoValue.photo_responded.responses_user_name|ucwords}</a>  </div>
                  <div class="clsFloatRight"> <span>{$photoValue.photo_responded.date_added}</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_response.gif" alt="" border="0" />
                    {$photoValue.photo_responded.lang}
                 <a class="clsActivityTitle" href="{$photoValue.photo_responded.old_viewphoto.url}"> {$photoValue.photo_responded.old_photo_title} </a>
              </div>
          </div>
    </div>
</div>
{elseif $photoValue.action_key == 'photo_share'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
            <a href="{$photoValue.photo_share.sender.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                   <img src="{$photoValue.photo_share.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_share.sender_user_name|truncate:5}" title="{$photoValue.photo_share.sender_user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_share.user_photo.imgsrc.s_width, $photoValue.photo_share.user_photo.imgsrc.s_height)}/>
            </a>
        </div>
          <div class="clsUserDetailsFriends">
             <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.photo_share.sender.url}"> {$photoValue.photo_share.sender_user_name} </a></div>
                  <div class="clsFloatRight"> <span>{$photoValue.photo_share.date_added}</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_share.gif" alt="" border="0" />
                     {$photoValue.photo_share.lang1}{$photoValue.photo_share.lang2} {foreach item=firendList from=$photoValue.photo_share.firend_list} 
                     <a class="clsActivityTitle" href="{$firendList.url}">{$firendList.firend_name}</a> {/foreach}
              </div>
          </div>
    </div>
 </div>
{elseif $photoValue.action_key == 'playlist_comment'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
        <div class="clsFloatLeft">
            <a href="{$photoValue.playlist_comment.comment_user.url}"  class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
             <img src="{$photoValue.playlist_comment.user_photo.imgsrc.s_url}" alt="{$photoValue.playlist_comment.user_name|truncate:5}" title="{$photoValue.playlist_comment.user_name}"  {$myobj->DISP_IMAGE(45, 45, $photoValue.playlist_comment.user_photo.imgsrc.s_width, $photoValue.playlist_comment.user_photo.imgsrc.s_height)}/>
            </a>
        </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.playlist_comment.comment_user.url}"> {$photoValue.playlist_comment.user_name} </a> </div>
                  <div class="clsFloatRight"> <span>{$photoValue.playlist_comment.date_added}</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_comment.gif" alt="" border="0" />
                    {$photoValue.playlist_comment.lang} 
                <a class="clsActivityTitle" href="{$photoValue.playlist_comment.viewphoto.url}"> {$photoValue.playlist_comment.playlist_name} </a>
              </div>
          </div>
 	</div>
</div>
{elseif $photoValue.action_key == 'playlist_rated'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="{$photoValue.playlist_rated.rate_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="{$photoValue.playlist_rated.user_photo.imgsrc.s_url}" alt="{$photoValue.playlist_rated.user_name|truncate:5}" title="{$photoValue.playlist_rated.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.playlist_rated.user_photo.imgsrc.s_width, $photoValue.playlist_rated.user_photo.imgsrc.s_height)}/>
              </a>
          </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <p class="clsFloatLeft"> <a href="{$photoValue.playlist_rated.rate_user.url}"> {$photoValue.playlist_rated.user_name|ucwords} </a> </p>
                  <p class="clsFloatRight"> <span>{$photoValue.playlist_rated.date_added}</span> </p>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_rated.gif" alt="" border="0" />
                    {$photoValue.playlist_rated.lang}
                 <a class="clsActivityTitle" href="{$photoValue.playlist_rated.viewphoto.url}"> {$photoValue.playlist_rated.playlist_name} </a>
              </div>
          </div>
     </div>
</div>
{elseif $photoValue.action_key == 'playlist_featured'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
             <a href="{$photoValue.playlist_featured.comment_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="{$photoValue.playlist_featured.user_photo.imgsrc.s_url}" alt="{$photoValue.playlist_featured.user_name|truncate:5}" title="{$photoValue.playlist_featured.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.playlist_featured.user_photo.imgsrc.s_width, $photoValue.playlist_featured.user_photo.imgsrc.s_height)}/>
              </a>
          </div>
          <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <p class="clsFloatLeft"> <a href="{$photoValue.playlist_featured.comment_user.url}"> {$photoValue.playlist_featured.user_name|ucwords} </a>  </p>
                  <p class="clsFloatRight"> <span>{$photoValue.playlist_featured.date_added}</span> </p>
              </div>
              <div class="clsUserActivityWhtsgoing">
                    <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_featured.gif" alt="" border="0" />
                    {$photoValue.playlist_featured.lang}
                <a class="clsActivityTitle" href="{$photoValue.photo_featured.viewphoto.url}"> {$photoValue.playlist_featured.playlist_name} </a>
              </div>
          </div>
     </div>
</div>
{elseif $photoValue.action_key == 'playlist_favorite'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="{$photoValue.playlist_favorite.comment_user.url}')" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                 <img src="{$photoValue.playlist_favorite.user_photo.imgsrc.s_url}" alt="{$photoValue.playlist_favorite.user_name|truncate:5}" title="{$photoValue.playlist_favorite.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.playlist_favorite.user_photo.imgsrc.s_width, $photoValue.playlist_favorite.user_photo.imgsrc.s_height)}/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="{$photoValue.playlist_favorite.comment_user.url}"> {$photoValue.playlist_favorite.user_name|ucwords} </a>  </div>
                  <div class="clsFloatRight"> <span>{$photoValue.playlist_favorite.date_added}</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_favourite.gif" alt="" border="0" />
                    {$photoValue.playlist_favorite.lang}
                 <a class="clsActivityTitle" href="{$photoValue.playlist_favorite.viewphoto.url}"> {$photoValue.playlist_favorite.playlist_name} </a>
              </div>
          </div>
     </div>
</div>
{elseif $photoValue.action_key == 'playlist_share'}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
           <div class="clsFloatLeft">
               <a href="{$photoValue.playlist_share.sender.url}')" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                 <img src="{$photoValue.playlist_share.user_photo.imgsrc.s_url}" alt="{$photoValue.playlist_share.sender_user_name|truncate:5}" title="{$photoValue.playlist_share.sender_user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.playlist_share.user_photo.imgsrc.s_width, $photoValue.playlist_share.user_photo.imgsrc.s_height)}/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a  href="{$photoValue.playlist_share.sender.url}"> {$photoValue.playlist_share.sender_user_name} </a> </div>
                  <div class="clsFloatRight"> <span>{$photoValue.playlist_share.date_added}</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_share.gif" alt="" border="0" />
                     {$photoValue.playlist_share.lang1}{$photoValue.playlist_share.lang2} {foreach item=firendList from=$photoValue.playlist_share.firend_list}
                      <p><a href="{$firendList.url}">{$firendList.firend_name}</a></p>
                      {/foreach}
                      <p> <a class="clsActivityTitle" href="{$photoValue.playlist_share.viewphoto.url}"> {$photoValue.playlist_share.playlist_name} </a></p>
              </div>
          </div>
 	</div>
</div>
{elseif $photoValue.action_key == 'playlist_create'}
<div class="clsWhatsGoingUserDetails">
 <div class="clsWhatsGoingBg clsOverflow">
        <div class="clsFloatLeft">
            <a href="{$photoValue.playlist_create.uploaded_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
              <img src="{$photoValue.playlist_create.user_photo.imgsrc.s_url}" alt="{$photoValue.playlist_create.user_name|truncate:5}" title="{$photoValue.playlist_create.user_name}"  {$myobj->DISP_IMAGE(45, 45, $photoValue.playlist_create.user_photo.imgsrc.s_width, $photoValue.playlist_create.user_photo.imgsrc.s_height)}/>
            </a>
        </div>
      <div class="clsUserDetailsFriends">
           <div class="clsOverflow clsWhatsGoingUser">
              <div class="clsFloatLeft"> <a  href="{$photoValue.playlist_create.uploaded_user.url}"> {$photoValue.playlist_create.user_name} </a> </div>
              <div class="clsFloatRight"> <span>{$photoValue.playlist_create.date_added}</span> </div>
           </div>
           <div class="clsUserActivityWhtsgoing">
                     <img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/photo_upload.gif" alt="" border="0" />
                    {$photoValue.playlist_create.lang}
                 <a class="clsActivityTitle" href="{$photoValue.playlist_create.viewphoto.url}" > {$photoValue.playlist_create.playlist_name} </a>
           </div>
      </div>
 </div>
</div>
{elseif $photoValue.action_key == 'photo_movie_share' && $CFG.admin.photos.movie_maker}
<div class="clsWhatsGoingUserDetails">
 	<div class="clsWhatsGoingBg clsOverflow">
       <div class="clsFloatLeft">
           <a href="{$photoValue.photo_movie_share.sender.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
              <img src="{$photoValue.photo_movie_share.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_movie_share.sender_user_name|truncate:5}" title="{$photoValue.photo_movie_share.sender_user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_movie_share.user_photo.imgsrc.s_width, $photoValue.photo_movie_share.user_photo.imgsrc.s_height)}/>
            </a>
        </div>
     	<div class="clsUserDetailsFriends">
          <div class="clsOverflow clsWhatsGoingUser">
              <div class="clsFloatLeft"> <a  href="{$photoValue.photo_movie_share.sender.url}"> {$photoValue.photo_movie_share.sender_user_name} </a> </div>
              <div class="clsFloatRight"> <span>{$photoValue.photo_movie_share.date_added}</span> </div>
           </div>
           <div class="clsUserActivityWhtsgoing">
                     <img src="" alr="img" />
                   {$photoValue.photo_movie_share.lang1} 
                  <a class="clsActivityTitle" href="{$photoValue.photo_movie_share.viewphotomovie.url}"> {$photoValue.photo_movie_share.photo_movie_name} </a> <span>{$photoValue.photo_movie_share.lang2}</span> {foreach item=firendList from=$photoValue.photo_movie_share.firend_list} <a class="clsActivityTitle" href="{$firendList.url}">{$firendList.firend_name}</a> {/foreach}
           </div>
      </div>
 	</div>
</div>
{elseif $photoValue.action_key == 'photo_movie_created' && $CFG.admin.photos.movie_maker}
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
           <div class="clsFloatLeft">
               <a href="{$photoValue.photo_movie_created.uploaded_user.url}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                <img src="{$photoValue.photo_movie_created.user_photo.imgsrc.s_url}" alt="{$photoValue.photo_movie_created.user_name|truncate:5}" title="{$photoValue.photo_movie_created.user_name}" {$myobj->DISP_IMAGE(45, 45, $photoValue.photo_movie_created.user_photo.imgsrc.s_width, $photoValue.photo_movie_created.user_photo.imgsrc.s_height)}/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <p class="clsFloatLeft"> <a  href="{$photoValue.photo_movie_created.uploaded_user.url}"> {$photoValue.photo_movie_created.user_name} </a>  </p>
                  <p class="clsFloatRight"> <span>{$photoValue.photo_movie_created.date_added}</span> </p>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="" alr="img" />
                    {$photoValue.photo_movie_created.lang}
                 <a class="clsActivityTitle" href="{$photoValue.photo_movie_created.viewphotomovie.url}"> {$photoValue.photo_movie_created.photo_movie_name} </a>
              </div>
          </div>
     </div>
</div>
{/if}
 	{/if}
{/foreach}
{if chkAllowedModule(array('music')) and $fanblock}
{$myobj->chkTemplateImagePathForModuleAndSwitch('music', $CFG.html.template.default, $CFG.html.stylesheet.screen.default)}
<div class="clsMusicShelfTable">
 <table {$myobj->defaultTableBgColor}>
        <tr>
          <th colspan="2">
          	  <div class="clsProfileMusicBlockTitle">{$myobj->defaultBlockTitle} <span>{$LANG.viewprofile_shelf_musics}</span></div>
              <div class="clsProfileMusicBlockLink">
              		{*ADDED THE CONDITION IF ALLOWED THE MUSIC UPLOAD FOR FAN MEMBER*}
                    {if $myprofileObj->isEditableLinksAllowed() and isAllowedMusicUpload()}
                        <a class="clsProfileMusicUpload" href="{$myprofileObj->getUrl('musicuploadpopup','','','','music')}" title="{$LANG.myprofile_link_view_musics_upload}">{$LANG.myprofile_link_view_musics_upload}</a>
                    {else}
                        &nbsp;
                    {/if}
              </div>
          </th>
        </tr>
  {if $music_list_arr==0}
        <tr>
          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> {$LANG.myprofile_musics_no_msg}</p></div></div></td>
        </tr>
  {else}
        <tr>
          <td colspan="2">
              <div class="clsProfileTableInfo">

                <table class="clsMusicShelf" id="{$CFG.profile_box_id.musics_list}">
                <tr>
                 {foreach key=item item=value from=$music_list_arr}
                <td class="clsMusicBlockDetails">
                  <div class="clsOverflow">
                      <div class="clsThumbImageLink">
                        <a class="ClsImageContainer ClsImageBorder1 Cls93x70" href="{$value.musicUrl}">
                             <img src="{$value.music_path}"  title="{$value.wrap_music_title}" {$myobj->DISP_IMAGE(93, 70, $value.thumb_width, $value.thumb_height)} />
                         </a>
                       </div>
                   </div>
                  <div class="clsProfileMusicTime">{$value.playing_time}</div>
                  <div class="clsMusicShelfDet">
                  <p class="clsName"><span>{*$LANG.myprofile_musics_title*}</span><a href="{$value.musicUrl}" title="{$value.wrap_music_title}">{$value.wrap_music_title}</a></p>
                  {*<p><span>{$LANG.myprofile_musics_album}:</span><a href="{$value.albumUrl}" title="{$value.wrap_album_title}">{$value.wrap_album_title}</a></p>*}
                  {*<p><span>{$LANG.index_added}:</span>{$value.date_added}</p>*}
                  <p><span>{$LANG.index_views}:</span> {$value.total_views}</p>
                  </div>
                </td>
                {/foreach}
                </tr>
                </table>
              </div>
		 	</td>
		 </tr>
		 <td colspan="2" class="clsMoreBgMusicCols">
		  <div class="clsMusicViewMoreLink">
				{if $musicDisplayed}
					<a href="{$usermusiclistURL}" title="{$LANG.myprofile_link_view_musics}">{$LANG.myprofile_link_view_musics}</a>
				{/if}
		  </div>
		</td>  
  {/if} {* music_list_arr condition closed *}
</table>
</div>
{/if}

 {if $CFG.admin.musics.music_artist_feature and $fanblock}
   <div class="clsArtistInfoTable">
      <table {$myobj->defaultTableBgColor} >
        <tr>
          <th colspan="2" class="text clsProfileTitle" {$myobj->defaultBlockTitle} ><span class="whitetext12">{$LANG.myprofile_shelf_artist_info}</span></th>
        </tr>
        <tr>
          <td colspan="2">
          {if $artist_info_arr.artist_promo_image and $artist_info_arr.image_ext}
		  <div class="clsArtistInfoContainer">
				<div class="clsArtistInfoImage">
					<div class="clsOverflow">
                      <div class="clsThumbImageLink">
                        <a href="{$artist_info_arr.memberProfileUrl}"  class="ClsImageContainer ClsImageBorder1 Cls455x305">
                             <img src="{$artist_info_arr.artist_promo_image}"  title="{$artist_info_arr.user_name}" />
                         </a>
                       </div>
                   </div>
				</div>
			{/if}
				<div class="clsArtistInfoDetails clsOverflow">
					<div class="clsArtistInfoDetailsLeft">
						<p>{$LANG.myprofile_artist_info_genres}<a href="#">{$artist_info_arr.music_artist_category}{if $artist_info_arr.music_artist_sub_category}/{$artist_info_arr.music_artist_sub_category}{/if}</a></p>
						<p>{$LANG.myprofile_artist_info_stats} <span>{$artist_info_arr.total_fans}</span> {$LANG.myprofile_artist_info_fans} /<span>{$artist_info_arr.total_plays}</span>{$LANG.myprofile_artist_info_plays} / <span>{$artist_info_arr.total_songs}</span> {$LANG.myprofile_artist_info_songs}</p>
					</div>
					<div class="clsArtistInfoDetailsRight">
					{if $artist_info_arr.fanbutton}
					{if isMember()}
						{if $artist_info_arr.already_fan}
							<div id="becomefan" style="display:none"><div class="clsProfileFanLeft"><div class="clsProfileFanRight"> <input onclick="addToFan('{$artist_info_arr.member_feature_url}')" type="button" value="{$LANG.myprofile_artist_become_fan}" /></div></div></div>
							<div id="removefan"><div class="clsProfileFanLeft"><div class="clsProfileFanRight"> <input onclick="removeToFan('{$artist_info_arr.member_unfeature_url}')" type="button" value="{$LANG.myprofile_artist_remove_fan}" /></div></div></div>
						{else}
							<div id="becomefan"><div class="clsProfileFanLeft"><div class="clsProfileFanRight"> <input onclick="addToFan('{$artist_info_arr.member_feature_url}')" type="button" value="{$LANG.myprofile_artist_become_fan}" /></div></div></div>
							<div id="removefan" style="display:none"> <div class="clsProfileFanLeft"><div class="clsProfileFanRight"> <input onclick="removeToFan('{$artist_info_arr.member_unfeature_url}')" type="button" value="{$LANG.myprofile_artist_remove_fan}" /></div></div></div>
						{/if}
					{else}
							<div id="becomefan"><div class="clsProfileFanLeft"><div class="clsProfileFanRight"> <input onclick="memberBlockLoginConfirmation('{$LANG.sidebar_login_become_fan_err_msg}','{$artist_info_arr.member_url}');return false;" type="button" value="{$LANG.myprofile_artist_become_fan}" /></div></div></div>
					{/if}
					{/if}
					</div>
				</div>
			</div>
		 	</td>
		 </tr>
      </table>
   </div>
   {/if}
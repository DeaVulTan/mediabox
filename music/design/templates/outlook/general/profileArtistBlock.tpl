{if $CFG.admin.musics.music_artist_feature}
<div class="clsFavouriteArtistTable">
      <table>

        <tr>
          <th colspan="3">
		  	<div class="clsFavouriteArtistTitle"> <span>{$LANG.myprofile_shelf_artist}</span></div>
		  	{if $artists_displayed}
		  		<div class="clsFavouriteArtistAllFans"><a href="{$artist_url}" title="{$LANG.myprofile_link_view_artist}">{$LANG.myprofile_link_view_artist}</a></div>
		  	{/if}
		  </th>
        </tr>
		<tr>
		<td>
			<table>
			{if $artists_displayed}
			{foreach key=inc item=value from=$artistdetails_arr}
			{if $value.open_tr}
				<tr>
			{/if}
					<td>
						<div class="clsOverflow {$value.addclass}">
							<div class="clsFavouriteArtistImage">
								<a href="{$value.memberProfileUrl}" alt="{$value.user_name}" class="ClsImageContainer ClsImageBorder1 Cls66x66">
									<img title="{$value.user_name}" src="{$value.profileIcon.s_url}"/>
								</a>
							</div>
							<div class="clsFavouriteArtistDes">
								<p><a href="{$value.memberProfileUrl}" alt="{$value.user_name}" title="{$value.user_name}">{$value.user_name}</a></p>
								<p>{$value.country}</p>
							</div>
						</div>
					</td>

				{if $value.end_tr}
			    	<tr>
			    {/if}
			    {/foreach}
				{else}
				<tr>
					<td><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> {$LANG.myprofile_artist_no_msg}</p></div></div></td>
				</tr>
				{/if}
			</table>
		</td>
	  </tr>
	</table>
</div>
{/if}
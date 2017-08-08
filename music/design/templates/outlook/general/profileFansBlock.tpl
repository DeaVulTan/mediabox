{if $CFG.admin.musics.music_artist_feature and $fanblock}
<div class="clsFansShelfTable">
      <table>

        <tr>
          <th colspan="3">
		  	<div class="clsFansShelfTitle"> <span>{$LANG.myprofile_shelf_fans}</span></div>
		  	{if $fans_displayed}
		  		<div class="clsFansShelfAllFans"><a href="{$fans_url}" title="{$LANG.myprofile_link_view_fans}">{$LANG.myprofile_link_view_fans}</a></div>
		  	{/if}
		  </th>
        </tr>
		<tr>
		<td>
			<table>
			{if $fans_displayed}
			{foreach key=inc item=value from=$fandetails_arr}
			{if $value.open_tr}
				<tr>
			{/if}
					<td>
						<div class="clsOverflow {$value.addclass}">
							<div class="clsFansShelfImage">
								<div class="ClsImageContainer ClsImageBorder1 Cls45x45 clsPointer">
									<img title="{$value.user_name}" src="{$value.profileIcon.s_url}"/>
								</div>
							</div>
							<div class="clsFansShelfDes">
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
					<td><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> {$LANG.myprofile_fans_no_msg}</p></div></div></td>
				</tr>
				{/if}
			</table>
		</td>
	  </tr>
	</table>
</div>
{/if}
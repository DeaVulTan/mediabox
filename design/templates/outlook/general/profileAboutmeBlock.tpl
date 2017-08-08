{if $about_me}
   <div class="clsAboutInfoTable">
      <table {$myobj->defaultTableBgColor} >
        <tr>
          <th class="text clsProfileTitle" {$myobj->defaultBlockTitle} ><span class="whitetext12">{$LANG.myprofile_about_me_shelf}</span></th>
        </tr>
        <tr><td>
			<table class="clsAboutInfo" id="{$CFG.profile_box_id.aboutme_list}">
                <tr>
					<td>
					   		<div id="{$about_me_id}" class="{$about_me_class}">{$about_me}</div>
					</td>
				</tr>
       		</table>
		</td></tr>
      </table>
   </div>
{/if}

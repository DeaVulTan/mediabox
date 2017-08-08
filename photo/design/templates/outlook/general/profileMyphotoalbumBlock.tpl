{if chkAllowedModule(array('photo')) and isAllowedPhotoUpload()}
<div class="clsPhotoAlbumShelfTable">
<table>
	<tr>
	  <th colspan="2">
		  <div class="clsPhotoProfileAlbumBlockTitle">{$LANG.viewprofile_shelf_photo_album}</div>
	  </th>
	</tr>
{if $photo_album_list_arr==0}
        <tr>
          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> {$LANG.myprofile_photo_albums_no_msg}</p></div></div></td>
        </tr>
  {else}
        <tr>
          <td colspan="2">
          	<div>
            	<table class="clsPhotoShelf" id="{$CFG.profile_box_id.myphotoalbum_list}">
                	{assign var=i value=0}
                 	{foreach key=item item=value from=$photo_album_list_arr}
                    {if $i % 4 == 0} 
                    <tr>
                    {/if}
                	<td class="clsPhotoBlockDetails">
						 <a class="Cls93x70 clsPhotoImageHolder clsPhotoImageBorder" {if $value.albumUrl!=''} href="{$value.albumUrl}"  {/if}>
							 <img src="{$value.photo_path}" border="0"  title="{$value.wrap_album_title}" alt="{$value.wrap_album_title}" {$myobj->DISP_IMAGE(93, 70, $value.s_width, $value.s_height)}/>
						 </a>
                  </td>
				{assign var=i value=$i+1}
                {if $i % 4 == 0}
                </tr>
                {/if}
                {/foreach}
                </table>
              </div>
		 	</td>
		 </tr>
		 <td colspan="2" class="clsMoreBgPhotoCols">
		  {if $photoAlbumDisplayed}
			 <div class="clsPhotoViewMoreLink">
				<a href="{$userphotoalbumlistURL}">{$LANG.viewprofile_link_view_photo_album}</a>
			 </div>
           {/if}
		 </td>
  {/if} {* photo_list_arr condition closed *}   
</table>
</div>
{/if}
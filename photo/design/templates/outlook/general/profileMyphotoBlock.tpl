{if chkAllowedModule(array('photo')) and isAllowedPhotoUpload()}
<div class="clsPhotoShelfTable">
 <table {$myobj->defaultTableBgColor}>
        <tr>
          <th colspan="2">
          	  <div class="clsProfilePhotoBlockTitle">{$myobj->defaultBlockTitle} {$LANG.viewprofile_shelf_photos}</div>
              <div class="clsProfilePhotoBlockLink">
              		{*ADDED THE CONDITION IF ALLOWED THE Photo UPLOAD FOR FAN MEMBER*}
                    {if $myprofileObj->isEditableLinksAllowed() and isAllowedPhotoUpload()}
                        <a class="clsProfilePhotoUpload" href="{$myprofileObj->getUrl('photouploadpopup','','','','photo')}">{$LANG.myprofile_link_view_photos_upload}</a>
                    {else}
                        &nbsp;
                    {/if}
              </div>
          </th>
        </tr>
  {if $photo_list_arr==0}
        <tr>
          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> {$LANG.myprofile_photos_no_msg}</p></div></div></td>
        </tr>
  {else}
        <tr>
          <td colspan="2">
              <div class="clsProfileTableInfo">
                <table class="clsPhotoShelf" id="{$CFG.profile_box_id.myphotos_list}">
                {assign var=i value=0}
                {foreach key=item item=value from=$photo_list_arr}
                {if $i % 4 == 0}
                <tr>
                {/if}
                <td class="clsPhotoBlockDetails">
					<a class="Cls93x70 clsPhotoImageHolder clsPhotoImageBorder" href="{$value.photoUrl}">
						 <img src="{$value.photo_path}"  title="{$value.wrap_photo_title}" alt="{$value.wrap_photo_title}" {$myobj->DISP_IMAGE(93, 70, $value.s_width, $value.s_height)}/>
					</a>
					<div class="clsPhotoShelfDet">
                  		<p class="clsName"><span>{*$LANG.myprofile_photos_title*}</span><a href="{$value.photoUrl}" title="{$value.wrap_photo_title}">{$value.wrap_photo_title}</a></p>
                  		{*<p><span>{$LANG.myprofile_photos_album}:</span>&nbsp;<a href="{$value.albumUrl}" title="{$value.wrap_album_title}">{$value.wrap_album_title}</a></p>*}
                  		{*<p><span>{$LANG.index_added}:</span>&nbsp;{$value.date_added}</p>*}
                  		<p><span>{$LANG.index_views}:</span>&nbsp;{$value.total_views}</p>
                    </div>
                </td>{assign var=i value=$i+1}
                {if $i % 4 == 0}
                </tr>
                {/if}                
                {/foreach}
               
                </table>
              </div>
		 	</td>
		 </tr>
		 <td colspan="2" class="clsMoreBgPhotoCols">
		  <div class="clsPhotoViewMoreLink">
			{if $photoDisplayed}
				<a href="{$userphotolistURL}">{$LANG.myprofile_link_view_photos}</a>
			{/if}
		  </div>
        </td>			  
  {/if} {* photo_list_arr condition closed *}
</table>
</div>
{/if}
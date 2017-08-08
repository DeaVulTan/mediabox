<div id="selMusicPlaylistManage">
  <h2>
  		{if $myobj->getFormField('artist_id') == ''}
        	{$LANG.manageartist_title}
        {else}
    		{$myobj->page_title}
        {/if}
  </h2>
  <br />
  {if $myobj->isShowPageBlock('list_artistlist_block')}
    <form id="form1" name="form1" method="post" action="">
        <table class="clsNoBorder">
            <tr>
            <td class="clsWidthSmall clsFormLabelCellDefault">
                <label>{$LANG.manageartist_artist_name}
				</label>
				 </td>
            <td align="left" valign="middle" class="clsFormFieldCellDefault">
			<input type="text" name="name" id="name" class="clsTextBox" /></td>
			</tr>
			<tr>
            <td class="clsFormFieldCellDefault"><input type="submit" name="search" id="search" value="{$LANG.manageartist_search}" class="clsSubmitButton" /><input  type="reset" class="clsCancelButton" name="reset_submit" id="reset_submit" value="{$LANG.manageartistphoto_reset_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/manageArtistMembersPhoto.php')"tabindex="{smartyTabIndex}"></td>
            </tr>
        </table>
    </form>
    <div id="selmusicArtistListManageDisplay" class="clsLeftSideDisplayTable">
            {if $myobj->isResultsFound()}
                {if $CFG.admin.navigation.top}
                        {$myobj->setTemplateFolder('admin')}
                        {include file=pagination.tpl}
                {/if}
                <table>
                         <tr>
                            <th class="clsSmallWidth">
                                {$LANG.manageartist_image}
                            </th>
                            <th>
                                {$LANG.manageartist_name}
				            </th>
                            <th>
                                {$LANG.manageartist_manage_photo}
                           </th>
                        </tr>
                    {foreach key=musicArtistListKey item=musicArtistList from=$myobj->list_artistlist_block.showArtistlists.row}
                        <tr>
                            <td class="clsSmallWidth">
                            <a href="manageArtistMembersPhoto.php?artist_id={$musicArtistList.record.user_id}&artist_name={$musicArtistList.record.user_name}">
                            <img src="{$musicArtistList.profileIcon.t_url}" alt="{$musicArtistList.record.user_name}" title="{$musicArtistList.record.user_name}"/>
                            </a>
	                        </td>
                             <td>
                            <p>{$musicArtistList.record.user_name}</p>
                            </td>
                          <td class="clsSmallWidth">
                          	<a href="manageArtistMembersPhoto.php?artist_id={$musicArtistList.record.user_id}&artist_name={$musicArtistList.record.user_name}">{$LANG.manageartist_clickhere}</a>
                            <p>{$LANG.manageartistphoto_photo_approved}({$myobj->getArtistPhotoStatusCount($musicArtistList.record.user_id, 'Yes')})</p>
                            <p> {$LANG.manageartistphoto_photo_waiting}({$myobj->getArtistPhotoStatusCount($musicArtistList.record.user_id, 'ToActivate')})</p>
                            </td>
                        </tr>
                    {/foreach}
               </table>
              {if $CFG.admin.navigation.bottom}
                    <div id="bottomLinks">
                        {include file='pagination.tpl'}
                    </div>
                {/if}
             {else}
                <div id="selMsgAlert">
                    {$LANG.manageartist_no_records_found}
          </div>
            {/if}
        </div>
     {/if}
    <!-- information div -->
    {$myobj->setTemplateFolder('admin')}
    {include file='information.tpl'}
    <!-- Upload photo block Start-->
    {if $myobj->isShowPageBlock('upload_photo_block')}
    	<a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')"   id="show_link" href="javascript:void(0)">{$LANG.manageartistphoto_upload_artist_photo}</a>
        <a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')"  style="display:none" id="hide_link" href="javascript:void(0)">{$LANG.manageartistphoto_upload_artist_photo}</a>
        <div id="upload_photo_block" {if !$myobj->flag} style="display:none" {/if}>
            <form action="{$myobj->getCurrentUrl()}" method="post"   enctype="multipart/form-data" name="musicPlayListManage" >
                <table  class="clsCreateAlbumTable clsNoBorder">
                    <tr>
                        <td class="clsSmallWidth" align="left" valign="top">
                            <label for="artist_photo">
                            {$LANG.manageartistphoto_upload_photo} {$myobj->photosize_detail}
                            </label>
                        </td>
                        <td align="left" valign="top">
                            <input type="file" name="artist_photo" id="artist_photo" tabindex="{smartyTabIndex}" />
                            {$myobj->getFormFieldErrorTip('artist_photo')}
                            {$myobj->ShowHelpTip('artist_photo', 'artist_photo')}
                        </td>
                    </tr>
                   <!-- <tr>
                        <td align="left" valign="top">
                            <label for="image_caption">
                            {$LANG.manageartistphoto_photo_caption}
                            </label>
                        </td>
                        <td align="left" valign="top">
                            <textarea name="image_caption" id="image_caption" cols="45" rows="5" tabindex="{smartyTabIndex}">{$myobj->getFormField('image_caption')}</textarea>
                            {$myobj->getFormFieldErrorTip('image_caption')}
                            {$myobj->ShowHelpTip('image_caption', 'image_caption')}
                        </td>
                    </tr>-->
                    <tr>
                        <td>&nbsp;

                        </td>
                        <td>
                            <input type="submit" name="upload" id="upload" value="{$LANG.manageartistphoto_upload}" class="clsSubmitButton" />
                       </td>
                    </tr>
                </table>
            </form>
        </div>
    {/if}
    <!-- Upload photo block End-->
     <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.manageartist_detail}" class="clsNoBorder">
				<tr>
					<td>
                    	<img id="artistImg" border="0" />
					</td>
				</tr>
				<tr>
					<td>

						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="music_artist_member_image" id="music_artist_member_image" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
    <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.manageartistphoto_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="music_artist_member_image" id="music_artist_member_image" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Photo list block start-->
    {if $myobj->isShowPageBlock('list_photo_block')}
       	{if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}
                    {$myobj->setTemplateFolder('admin')}
                    {include file=pagination.tpl}
            {/if}
            <form name="selFormArtistPhoto" id="selFormArtistPhoto" method="post" action="announcement.php">
            <table >
                <tr>
                    <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormArtistPhoto.name, document.selFormArtistPhoto.check_all.name)"/></th>
                    <th>{$LANG.manageartistphoto_image}</th>
                    <th>{$LANG.manageartistphoto_photo_status}</th>
                   <!-- <th>{$LANG.manageartistphoto_caption}</th>-->
                    <th>{$LANG.manageartistphoto_action}</th>
                </tr>
            {foreach key=asKey item=saValue from=$myobj->list_photo_block.showArtistImageList}
                <tr>
                    <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="forum_ids[]" value="{$saValue.record.music_artist_member_image}" onClick="disableHeading('selFormAnnouncement');" tabindex="{smartyTabIndex}"/></td>
                    <td><p>

                    	 {if $saValue.artist_image  != ''}
                            	<img src="{$saValue.artist_image}" title="" {$saValue.disp_image}/>
                            {else}
                               <img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_artist_T.jpg" title="{$musicArtistList.record.artist_name}"/>
                            {/if}
                    </p></td>
                    <td>
                    	{if $saValue.record.status == 'Yes'}
                        	{$LANG.common_display_active}
                        {elseif $saValue.record.status == 'No'}
                        	{$LANG.common_display_inactive}
                        {elseif $saValue.record.status == 'ToActivate'}
                        	{$LANG.manageartistphoto_photo_waiting}
                        {/if}

                    </td>
                    <!--<td><p title="{$saValue.record.image_caption}">{$saValue.record.image_caption}</p></td>-->
                    <td>
                        <p>
	                        <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_member_image', 'artistImg', 'confirmMessageSingle'), Array('Delete', '{$saValue.record.music_artist_member_image}', '{$saValue.artist_image}', '{$LANG.manageartistphoto_delete_confirmation}'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);">{$LANG.manageartistphoto_delete}</a>
                        <p>
                        {if $saValue.record.status == 'No'}
                            <p>
                                <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_member_image', 'artistImg', 'confirmMessageSingle'), Array('Active', '{$saValue.record.music_artist_member_image}', '{$saValue.artist_image}', '{$LANG.manageartistphoto_active_confirm_message}'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);">{$LANG.common_display_active}</a>
                            <p>
                        {elseif $saValue.record.status == 'Yes'}
                            <p>
                                <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_member_image', 'artistImg', 'confirmMessageSingle'), Array('Inactive', '{$saValue.record.music_artist_member_image}', '{$saValue.artist_image}', '{$LANG.manageartistphoto_inactive_confirm_message}'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);">{$LANG.common_display_inactive}</a>
                            <p>
                        {elseif $saValue.record.status == 'ToActivate'}
                            <p>
                                <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_member_image', 'artistImg', 'confirmMessageSingle'), Array('Approve', '{$saValue.record.music_artist_member_image}', '{$saValue.artist_image}', '{$LANG.manageartistphoto_approve_confirm_message}'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);">{$LANG.manageartistphoto_photo_approve}</a> /
                              	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_member_image', 'artistImg', 'confirmMessageSingle'), Array('Delete', '{$saValue.record.music_artist_member_image}', '{$saValue.artist_image}', '{$LANG.manageartistphoto_disapprove_confirm_message}'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);">{$LANG.manageartistphoto_photo_disapprove}</a>
                            <p>
                        {/if}
                        					</td>
                </tr>
            {/foreach}
             <tr>
                    <td colspan="6">
                    	<select name="action_val" id="action_val" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_action}</option>
                        {$myobj->generalPopulateArray($myobj->list_photo_block.action_arr, $myobj->getFormField('action'))}
                        </select>
                    	<input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="{$LANG.manageartistphoto_submit}" onClick="getMultiCheckBoxValue('selFormArtistPhoto', 'check_all', '{$LANG.manageartistphoto_err_tip_select_titles}');if(multiCheckValue!='') getAction()"/>
                        <input type="button" class="clsCancelButton" name="cancel_submit" id="cancel_submit" value="{$LANG.manageartistphoto_cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/music/manageArtistMembersPhoto.php')"tabindex="{smartyTabIndex}">                        </td>
              </tr>
             </table>
  </form>
  {*<!--	{assign var='count' value='0'}
  			<table>
  			   {foreach key=asKey item=saValue from=$myobj->list_photo_block.showArtistImageList}
                 {if $count == 0}
                    <tr>
                    {/if}
                        <td>
                            <p><img src="{$saValue.artist_image}" title="{$saValue.record.image_caption}"/></p>
                            <p title="{$saValue.title_image_caption}">{$saValue.record.image_caption}</p>
                            {if $saValue.record.user_id eq $CFG.user.user_id }
                                    <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_member_image', 'artistImg', 'confirmMessageSingle'), Array('delete', '{$saValue.record.music_artist_member_image}', '{$saValue.artist_image}', '{$LANG.manageartistphoto_delete_confirmation}'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);">{$LANG.manageartistphoto_delete}</a>
                                </p>
                            {/if}
                        </td>
                   {counter  assign=count}
                   {if $count%$CFG.admin.musics.artist_image_cols eq 0}
                        {counter start=0}
                        </tr>
                    {/if}
            {/foreach}
            {assign var=cols  value=$CFG.admin.musics.artist_image_cols-$count}
            {if $count != 0}
                {section name=foo start=0 loop=$cols step=1}
                    <td>&nbsp;</td>
                {/section}
                <tr>
            {/if}
            </table> -->*}

            {if $CFG.admin.navigation.bottom}
<div id="bottomLinks">
                	{include file='pagination.tpl'}
              	</div>
            {/if}
         {else}
            <div id="selMsgAlert">
                {$LANG.manageartistphoto_no_records_found}
            </div>
        {/if}
    {/if}
     <!-- Photo list block end-->
</div>
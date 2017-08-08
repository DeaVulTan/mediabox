<script language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti');
</script>
<div id="selMyAlbums">
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div class="clsPageHeading">
  	<h2><span>{$LANG.videoalbums_title}</span></h2>
</div>
	<!--- Delete Single Albums --->
	<div id="selLeftNavigation">
		<div id="selMsgConfirm" style="display:none;" class="clsPopupConfirmation">
    		<p>{$LANG.videoalbums_delete_confirmation}</p>
	      	<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">

							<p id="selImageBorder" class="clsPlainImageBorder">
                                <span id="selPlainCenterImage">
                                    <img id="selVideoId" border="0" />
                                </span>
                            </p>

						  	<p><input type="submit" class="clsSubmitButton" name="delete" id="delete" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="album_id" id="album_id"/></p>
							{*$myobj->populateHidden(array('start'))*}

	      	</form>
	    </div>
		<!--- Delete Multi Videos --->
		<div id="selMsgConfirmMulti" style="display:none;" class="clsMsgConfirm">
    		<p>{$LANG.multi_delete_confirmation}</p>
			<form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
	        	<table summary="{$LANG.videoalbums_tbl_summary}" class="clsMyVideosTable">
				  	<tr>
		            	<td>
						  	<input type="submit" class="clsSubmitButton" name="delete" id="delete" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}"
                             onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="album_id" id="album_id"/>
							{*$myobj->populateHidden(array('start'))*}
						</td>
		          	</tr>
	        	</table>
	      	</form>
	    </div>
		{if $myobj->isShowPageBlock('msg_form_error')}
		<div id="selMsgError">
			<p>{$myobj->getCommonErrorMsg()}</p>
		</div>
        {/if}
        {if $myobj->isShowPageBlock('msg_form_success')}
    	<div id="selMsgSuccess">
			<p>{$myobj->getCommonErrorMsg()}</p>
		</div>
        {/if}
		{if $myobj->isShowPageBlock('my_albums_form')}
            <div id="selMyAlbumsDisplay" class="clsLeftSideDisplayTable">
            {if $myobj->isResultsFound()}
                {if $CFG.admin.navigation.top}
                <div id="topLinks">
                    {$myobj->setTemplateFolder('general/')}
                    {include file=pagination.tpl}
                </div>
                {/if}

                <p class="clsCreateAlbumTitle" id="selCreateAlbum">
                    <a href="{$myobj->videoalbum_create_link}">{$LANG.videoalbums_create_new}</a>
                </p>
                <form name="deleVideoForm" id="deleVideoForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
                <div class="clsDataTable">
                    <table summary="" class="clsMyVideoAlbumTbl">
                        <tr>
                            <th>
                            <input type="checkbox" class="clsCheckRadio" name="check_all"
                            onclick = "CheckAll(document.deleVideoForm.name, document.deleVideoForm.check_all.name)" />
                            </th>
                            <th>{$LANG.videoalbums_album_image}</th>
                            <th>{$LANG.videoalbums_album_name}</th>
                            <th class="clsAlbumVideos">{$LANG.videoalbums_videos}</th>
                            <th>{$LANG.videoalbums_user_action}</th>
                        </tr>
                        {foreach from=$myobj->my_albums_form item=album}
                        <tr>
                            <td class="clsWidth20">
                                <input type="checkbox" class="clsCheckRadio" name="album_ids[]" value="{$album.video_album_id}" tabindex="{smartyTabIndex}"
                                {$album.checked} onClick="disableHeading('deleVideoForm');"/>
                            </td>
                            {if $album.video_path}
                            <td id="selVideoGallery" class="clsWidth90">
                                <a id="{$album.anchor}" href="#"></a>
                                <div class="">
                                    <div id="{$album.anchor}"  class="clsThumbImageLink">
                                        <a href="{$album.abumvideolist_link}" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                        <img src="{$album.video_path}" title="{$album.album_title}"  border="0"{$album.disp_image} />
                                        </a>
                                    </div>
                                </div>
                            </td>
                            {else}
                            <td id="selVideoGallery">
                                <a id="{$anchor}" href="#"></a>
                                <p id="selImageBorder">
                                    <a href="#" onClick="return false"><img src="{$album.video_path}" width="{$CFG.admin.videos.small_width}" /></a>
                                </p>
                            </td>
                            {/if}
                            <td id="selAlbumName">
                            {if $album.total_videos}
                                <p>
                                    <a href="{$album.abumvideolist_link}">{$album.album_title}</a>
                                </p>
                            {else}
                                <p>{$album.album_title}</p>
                            {/if}
                            </td>
                            <td class="clsAlbumVideos">{$album.total_videos}</td>
                            <td class="clsUserAlbumActions">
                                <span class="clsUpload">
                                    <a href="{$album.videoUpload}">{$LANG.videoalbums_upload_video}</a>
                                </span>

                                <span class="clsAlbumEdit">
                                    	<a href="{$album.createalbum_edit_url}">{$LANG.videoalbums_edit}</a>
                                </span>
                                <span class="clsDeleteAlbum" id="anchor_{$album.video_album_id}">
                                    <a onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                    Array('act','album_id', 'selVideoId', 'msgConfirmText'), Array('delete','{$album.video_album_id}', '{$album.video_path}','{$LANG.videoalbums_delete_confirmation}'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_{$album.video_album_id}');" title="{$LANG.videoalbums_delete_album}" class="clsVideoVideoEditLinks" href="#">{$LANG.videoalbums_delete_album}</a>
                                </span>
                            </td>
                        </tr>
                        {/foreach}
                        </table>
						<div class="clsOverflow">
                            <a href="#" id="dAltMulti"></a>
                            <div class="clsGreyButtonLeft">
                                 <div class="clsGreyButtonRight">
                                     <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="{smartyTabIndex}" value="{$LANG.common_delete_option}" onClick="return deleteMultiCheck('{$LANG.check_atleast_one}','dAltMulti','{$LANG.multi_delete_confirmation}','deleVideoForm','album_id')" />
                                 </div>
                            </div>
						</div>			

                </div>
                </form>
                {if $CFG.admin.navigation.bottom}
                <div id="bottomLinks">
                        {include file='pagination.tpl'}
                </div>
                {/if}
            {else}
            <div id="selMsgAlert">
                <p>{$LANG.videoalbums_no_records_found}</p>
            </div>
            <p class="clsCreateAlbumTitle" id="selCreateAlbum">
                <a href="{$myobj->videoalbum_create_link}">{$LANG.videoalbums_create_new}</a>
            </p>
            {/if}
 		</div>
        {/if}

	</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
</div>
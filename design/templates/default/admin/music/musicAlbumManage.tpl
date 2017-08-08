<div id="selmusicList">
  	<h2><span>{$LANG.musicAlbumManage_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.musicAlbumManage_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.musicAlbumManage_cancel}"  onclick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="music_categories" id="music_categories" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
	{$myobj->setTemplateFolder('admin')}
	{include file='information.tpl'}
	{if $myobj->isShowPageBlock('list_music_album_form')}
    <div id="selMusicAlbumList">
		{if $myobj->isResultsFound()}
		<form name="music_album_form" id="music_album_form" method="post" action="{$myobj->getCurrentUrl(true)}">

            {if $CFG.admin.navigation.top}
            	{$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
            {/if}
		  	<table summary="{$LANG.musicAlbumManage_tbl_summary}">
				<tr>
					<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.music_album_form.name, document.music_album_form.check_all.name)"/></th>
					<th>{$LANG.musicAlbumManage_album_id}</th>
                    <th>{$LANG.musicAlbumManage_album_title}</th>
                    <th>{$LANG.musicAlbumManage_total_music}</th>
					<th>{$LANG.musicAlbumManage_access_type}</th>
					<th>{$LANG.album_user_name}</th>
                    {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
					<th>{$LANG.album_price}</th>
                    {/if}
					<th>{$LANG.album_featured}</th>
				</tr>
				{foreach key=dalKey item=dalValue from=$displayalbumList_arr.row}
				<tr>
					<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="{$dalValue.record.music_album_id}-{$dalValue.record.user_id}" onclick="disableHeading('music_album_form');"/></td>
					<td>
                       	{$dalValue.record.music_album_id}
                    </td>
                    <td>
                       	{$dalValue.record.album_title}
                    </td>
					<td>
						{$dalValue.record.total_music}
					</td>
					<td>{$dalValue.record.album_access_type}</td>
					<td>{$dalValue.name}</td>
                    {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
					<td>{$dalValue.record.album_price}</td>
                    {/if}
					<td>{$dalValue.record.album_featured}</td>
				</tr>
                {/foreach}
				<tr>
					<td colspan="7">
						<a href="javascript:void(0)" id="dAltMlti"></a>
						<select name="album_options" id="album_options" tabindex="{smartyTabIndex}">
							<option value="">{$LANG.action_select}</option>
							<option value="Featured">{$LANG.action_featured}</option>
							<option value="UnFeatured">{$LANG.action_unfeatured}</option>
						</select>&nbsp;
						<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.musicAlbumManage_submit}" onclick="if(getMultiCheckBoxValue('music_album_form', 'check_all', '{$LANG.musicAlbumManage_err_tip_select_albums}'))  {literal} { {/literal} getAction() {literal} } {/literal}" />
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="javascript:void(0)" id="dAltMlti"></a>
					</td>
				</tr>
			</table>
            {if $CFG.admin.navigation.bottom}
            	{$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
            {/if}
			{$myobj->populateHidden($myobj->list_music_form.hidden_arr)}
		</form>
		{else}
    	<div id="selMsgSuccess">
        	{$LANG.musicAlbumManage_no_records_found}
        </div>
		{/if}
    </div>
	{/if}
</div>
{if $myobj->isResultsFound}
{$myobj->setTemplateFolder('general/', 'music')}
{include file='information.tpl'}
<script type="text/javascript">
var clsSuccessMessage = "clsSuccessMessage";
var clsErrorMessage = "clsErrorMessage";
</script>
	<div id="organize_playlist" style="display:none"></div>
{if $myobj->isShowPageBlock('block_playlist_player')}
	<div class="clsSongList">
	<div class="clsSongListHeader">
		<div class="clsListHeading">
			<p>{$LANG.common_msg_drag_songs_playlist}</p>
		</div>
	</div>
	<form name="dragDropContainer_frm" id="dragDropContainer_frm" method="post" action="" autocomplete="off">
		<div id="dhtmlgoodies_dragDropContainer">
		<ul class="clsSongListContent clsDraglist" id="allItems" >
			{assign var='count' value='0'}
			{foreach key=musicAlbumlistKey item=musicalbumlist from=$myobj->list_playlist_block.getOrganizePlaylistList.row}
			{counter  assign=count}
				<div id="delete_{$musicalbumlist.music_id}">
					<li id="{$musicalbumlist.music_id}">
						<div class="clsTakeOut" >
							<a href="javascript:void(0);" onclick="deletePlaylistSongsInPlayer('{$musicalbumlist.playlist_id}','{$musicalbumlist.music_id}');" title="{$LANG.common_delete}"></a>
						</div>
						<div class="clsTitles" id="draggable" >
							<p style="padding:12px 0">{if $musicalbumlist.music_title !=''}{$musicalbumlist.music_title}{/if}</p>
						</div>
						<input type="hidden" name="music_id" id="music_id" value="{$count}_{$musicalbumlist.music_id}"/>
						<input type="hidden" name="play_list_order_id" id="play_list_order_id" value="{$count}"/>
					</li>
				</div>
			{/foreach}
		</ul>
		</div>
	</form>
	</div>
{/if}
{else}
	<div id="selMsgAlert">
		<p>{$LANG.common_msg_no_playlist_song_added}</p>
	</div>
{/if}
{*CONFIRMATION BOX FOR NAVIGATING PLAYLIST CLEAR ALL STARTS HERE*}
<div id="selMsgPlaylistConfirmMulti" class="clsPopupConfirmation" style="display:none;">
	<p id="selPlaylistAlertLoginMessage">{$LANG.sidebar_login_err_msg}</p>
	<form name="msgPlaylistConfirmformMulti1" id="msgQuickMixConfirmformMulti1" method="post" action="" autocomplete="off">
		<input type="button" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" onclick="clearAllPlaylistId('{$myobj->getFormField('playlist_id')}');"/> &nbsp;
		<input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hidingPlayListBlocks();" />
	</form>
</div>
{*CONFIRMATION BOX FOR NAVIGATING TO PLAYLIST CLEAR ALL ENDS HERE*}







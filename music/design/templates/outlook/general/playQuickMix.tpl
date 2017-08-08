{$myobj->setTemplateFolder('general/','music')}
{include file='information.tpl'}
{if $myobj->isShowPageBlock('block_music_playlist_player')}
{* TO GENERATE PLAYLIST PLAYER *}
			{** @param string $div_id
			 * @param string $music_player_id
			 * @param integer $width
			 * @param integer $height
			 * @param string $auto_play
			 * @param boolean $hidden
			 * @param boolean $playlist_auto_play
 		     * @param boolean $javascript_enabled *}
			<div class="clsQuickMixContainer"> 
			 {$myobj->setTemplateFolder('general/', 'music')}
			{include file="box.tpl" opt="playlist_top"}
			 <div class="clsQuickMixPlayer">
{$myobj->populatePlayerWithPlaylist($music_fields)}
			</div>
			{$myobj->setTemplateFolder('general/', 'music')}
			{include file="box.tpl" opt="playlist_bottom"}
			</div>
	<div class="clsButtonHolder clsPopupPlayerButtons"><p class="clsEditButton" id="save_quick_mix">
		<span class=""><a title="{$LANG.common_save_quick_mix}" href="javascript:void(0)" onclick="managePlaylist('{$myobj->getFormField('music_id')}', '{$myobj->savePlaylistUrl}', '{$LANG.common_create_playlist}');">{$LANG.common_save_quick_mix}</a></span>
	</p>
	<p class="clsDeleteButton"><span class="">
		<a href="javascript:void(0)" title="{$LANG.common_quickmix_clear_all}" onclick="quickMixClearAlert('{$LANG.common_clear_all_err_msg}');">{$LANG.common_quickmix_clear_all}</a>
	</span></p></div>
	<p id='anchor_id'>
{/if}
{if $myobj->isShowPageBlock('block_music_add_quickmix')}
	<div id="redirectQuickMix" class="clsRedirectMessage">
		<div class="clsNoRecordsFound"><p>{$LANG.common_msg_no_quickmix_added}&nbsp;&nbsp;<a href="javascript:void(0)" onclick="addQuickMixRedirect('{$myobj->getUrl('musiclist', '?pg=music_new', 'music_new/','', 'music')}')" title="{$LANG.common_close}">{$LANG.common_close}</a></p></div>
		<!--<img src="" /></a>-->
	</div>
{/if}
{*CONFIRMATION BOX FOR NAVIGATING TO QUICK MIX CLEAR STARTS HERE*}
 <div id="selMsgQuickMixConfirmMulti" class="clsPopupConfirmation" style="display:none;">
        <p id="selQuickMixAlertLoginMessage">{$LANG.sidebar_login_err_msg}</p>
        <form name="msgQuickMixConfirmformMulti1" id="msgQuickMixConfirmformMulti1" method="post" action="" autocomplete="off">
          <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" onclick="clearQuickMix();" /> &nbsp;
          <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hidingQuickMixBlocks()" />
        </form>
 </div>
{*CONFIRMATION BOX FOR NAVIGATING TO QUICK MIX CLEAR ENDS HERE*}
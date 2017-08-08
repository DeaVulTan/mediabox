<h2><span>{$LANG.musicManage_manage_featured_head_label}</span></h2>
{if !$myobj->getFormField('type')}
<p class="clsBackLink"><a href="{$CFG.site.url}admin/music/musicManage.php" >{$LANG.common_music_back}</a></p>
{/if}
{if $myobj->isResultsFound}
{$myobj->setTemplateFolder('admin/')}
{include file='information.tpl'}
<script type="text/javascript">
var clsSuccessMessage = "clsSuccessMessage";
var clsErrorMessage = "clsErrorMessage";
</script>
<div id="organize_playlist" style="display:none"></div>
{if $myobj->isShowPageBlock('block_musiclist_player')}
	<div class="clsSongList">
	<div class="clsSongListHeader clsOverflow">
		<div class="clsListHeading">
			<p>{$LANG.common_msg_drag_songs_playlist}</p>
		</div>
		  <div class="clsHeaderButtonHolder">
			<p class="clsPopupSave" id="save_quick_mix">
				<input type="button" onclick="saveFeaturedMusicDragDropNodes()" class="clsSubmitButton" value="Save">
				<!--<input type="button" onclick="feturedMusicCancel();return false;" class="clsSubmitButton"value="Cancel">-->
			</p>
		  </div>
	</div>
	<form name="dragDropContainer_frm" id="dragDropContainer_frm" method="post" action="" autocomplete="off">
		<div id="dhtmlgoodies_dragDropContainer">
		<ul class="clsSongListContent clsDraglist" id="allItems" >
			{assign var='count' value='0'}
			{foreach key=Key item=musiclist from=$myobj->list_order_block.getOrganizeMusicList.row}
			{counter  assign=count}
				<div id="delete_{$musiclist.music_id}">
					<li id="{$musiclist.music_id}">
						<div class="clsTitles" id="draggable" >
							<p>{if $musiclist.music_title !=''}{$musiclist.music_title}{/if}</p>
						</div>
						<input type="hidden" name="music_id" id="music_id" value="{$count}_{$musiclist.music_id}"/>
					</li>
				</div>
			{/foreach}
		</ul>
		</div>
	</form>
	</div>
{/if}
{else}

	<div id="selMsgAlert" class="clsSuccessMessages">
		<p>{$LANG.sidebar_no_audio_found_error_msg}</p>
	</div>

{/if}

<div class="clsNote">
{$LANG.musicManage_manage_featured_add_note1}<a href="#"  onclick="callMusicHome();">{$LANG.musicManage_manage_featured_add_note2}</a>{$LANG.musicManage_manage_featured_add_note3}

</div>

{literal}
<script language="javascript">
	function callMusicHome()
	{
		parent.location ='{/literal}{$CFG.site.url}admin/music/musicManage.php{literal}';
	}
</script>
{/literal}



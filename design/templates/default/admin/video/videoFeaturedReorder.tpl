<h2><span>{$LANG.videoManage_manage_featured_head_label}</span></h2>
{if !$myobj->getFormField('type')}
<p class="clsBackLink"><a href="{$CFG.site.url}admin/video/videoManage.php" >{$LANG.common_video_back}</a></p>
{/if}
{if $myobj->isResultsFound}
{$myobj->setTemplateFolder('admin/')}
{include file='information.tpl'}
<div id="reOrder_playlist" class="clsSuccessMessages" style="display:none"><p>{$LANG.common_msg_reorder_featured_video_list}</p></div>
{if $myobj->isShowPageBlock('block_videolist_player')}
	<div class="clsSongList">
	<div class="clsSongListHeader clsOverflow">
		<div class="clsListHeading">
			<p>{$LANG.common_msg_drag_videos_playlist}</p>
		</div>
		  <div class="clsHeaderButtonHolder">
			<p class="clsPopupSave" id="save_quick_mix">
				<input type="button" onclick="saveFeaturedVideoDragDropNodes()" class="clsSubmitButton" value="Save">
				<!--<input type="button" onclick="feturedMusicCancel();return false;" class="clsSubmitButton"value="Cancel">-->
			</p>
		  </div>
	</div>
	<form name="dragDropContainer_frm" id="dragDropContainer_frm" method="post" action="" autocomplete="off">
		<div id="dhtmlgoodies_dragDropContainer">
		<ul class="clsSongListContent clsDraglist" id="allItems" >
			{assign var='count' value='0'}
			{foreach key=Key item=videolist from=$myobj->list_order_block.getOrganizeVideoList.row}
			{counter  assign=count}
				<div id="delete_{$videolist.video_id}">
					<li id="{$videolist.video_id}">
						<div class="clsTitles" id="draggable" >
							<p>{if $videolist.video_title !=''}{$videolist.video_title}{/if}</p>
						</div>
						<input type="hidden" name="video_id" id="video_id" value="{$count}_{$videolist.video_id}"/>
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
		<p>{$LANG.sidebar_no_video_found_error_msg}</p>
	</div>

{/if}

<div class="clsNote">
{$LANG.videoManage_manage_featured_add_note1}<a href="#"  onclick="callVideoHome();">{$LANG.videoManage_manage_featured_add_note2}</a>{$LANG.videoManage_manage_featured_add_note3}
</div>

{literal}
<script language="javascript">
	function callVideoHome()
	{
		parent.location ='{/literal}{$CFG.site.url}admin/video/videoManage.php{literal}';
	}
</script>
{/literal}


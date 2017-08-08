<h2><span>{$LANG.photoManage_manage_featured_head_label}</span></h2>
{if !$myobj->getFormField('type')}
<p class="clsBackLink"><a href="{$CFG.site.url}admin/photo/photoManage.php" >{$LANG.common_photo_back}</a></p>
{/if}
{if $myobj->isResultsFound}
{$myobj->setTemplateFolder('admin/')}
{include file='information.tpl'}
<div id="reOrder_playlist" class="clsSuccessMessages" style="display:none"><p>{$LANG.common_msg_reorder_featured_photo_list}</p></div>
{if $myobj->isShowPageBlock('block_photolist_player')}
	<div class="clsPhotoList">
	<div class="clsPhotoListHeader">
		<div class="clsListHeading">
			<p>{$LANG.common_msg_drag_photos_playlist}</p>
		</div>
		  <div class="clsHeaderButtonHolder">
			<p class="clsPopupSave" id="save_quick_mix">
				<input type="button" onclick="saveFeaturedPhotoDragDropNodes()" class="clsSubmitButton" value="Save">
				<!--<input type="button" onclick="feturedPhotoCancel();return false;" class="clsSubmitButton"value="Cancel">-->
			</p>
		  </div>
	</div>
	<form name="dragDropContainer_frm" id="dragDropContainer_frm" method="post" action="" autocomplete="off">
		<div id="dhtmlgoodies_dragDropContainer">
		<ul class="clsPhotoListContent clsDraglist" id="allItems" >
			{assign var='count' value='0'}
			{foreach key=Key item=photolist from=$myobj->list_order_block.getOrganizePhotoList.row}
			{counter  assign=count}
				<div id="delete_{$photolist.photo_id}">
					<li id="{$photolist.photo_id}">
						<div class="clsTitles" id="draggable" >
							<p>{if $photolist.photo_title !=''}{$photolist.photo_title}{/if}</p>
						</div>
						<input type="hidden" name="photo_id" id="photo_id" value="{$count}_{$photolist.photo_id}"/>
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
		<p>{$LANG.sidebar_no_photo_found_error_msg}</p>
	</div>

{/if}

<div class="clsNote">
{$LANG.photoManage_manage_featured_add_note}
{$LANG.photoManage_manage_featured_add_note1}<a href="#"  onclick="callPhotoHome();">{$LANG.photoManage_manage_featured_add_note2}</a>{$LANG.photoManage_manage_featured_add_note3}
</div>




{literal}
<script language="javascript">
	function callPhotoHome()
	{
		parent.location ='{/literal}{$CFG.site.url}admin/photo/photoManage.php{literal}';
	}
</script>
{/literal}
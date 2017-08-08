{if $myobj->isResultsFound}
	{$myobj->setTemplateFolder('general/', 'photo')}
	{include file='information.tpl'}

	<!-- added to show the confirmation for delete in dialog -->
	<div id="playlist_delete" class="clsSuccessMessage" style="display:none"><p>{$LANG.common_msg_playlist_remove_all}</p></div>
	<div id="selOrganizeSlideMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      	<div id="organizeSlideMsgConfirmText"></div>
      	<form name="organizeSlideMsgConfirmform" id="organizeSlideMsgConfirmform" autocomplete="off">
        	<input type="button" class="clsPopUpButtonSubmit" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" onclick="removeImageFromSlidelist()" />
        	&nbsp;
        	<input type="button" class="clsPopUpButtonReset" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideConfirmDeleteSlideBlock()" />
        	<input type="hidden" name="photo_id" id="photo_id" />
      	</form>
	</div>
	<!-- added to show the confirmation for delete in dialog -->

	{if $myobj->isShowPageBlock('block_slidelist_photos')}
		<div class="clsPlayList">
			<div class="clsPlayListHeader">
				{$myobj->setTemplateFolder('general/','photo')}
 				{include file='box.tpl' opt='popupwithheadingtop_top'}
      			<div class="clsOverflow">
					<div class="clsPhotoListHeading clsLightWindowSlideLeft">
						<h3>{$LANG.common_msg_drag_photos_reorder_slidelist}</h3>
					</div>
        			<div class="clsPhotoPopupHeaderButton clsLightWindowSlideRight">
	    				<form name="reorder_frm" action="{$myobj->getCurrentUrl()}" method="post" class="clsLightWindowForm">
    	    				<input type="button" class="clsPopupSave" onclick="saveDragDropNodes('{$myobj->getFormField('photo_slidelist_id')}')" value="{$LANG.common_update}">
             			</form>
        			</div>
        			{if $myobj->isShowPageBlock('block_msg_form_reorder_success')}
        				<div class="clsLightWindowSlideMiddle">{$LANG.common_msg_reorder_playlist}</div>
        			{/if}
    			</div>
				{$myobj->setTemplateFolder('general/', 'photo')}
  				{include file='box.tpl' opt='popupwithheadingtop_bottom'}
			</div>

  			{$myobj->setTemplateFolder('general/','photo')}
   			{include file='box.tpl' opt='popupwithheadingbottom_top'}
   			<div class="clsOverflow">
				<form name="dragDropContainer_frm" id="dragDropContainer_frm" method="post" action="" autocomplete="off">
    				{assign var='photoAlbumBox' value=265}
    				{assign var='photoScrollBarTracker' value=230}
			    	<div class="clsScrollBarSlideListContainer">
			      		<div id="scrollbar_container" class="clsScrollBar_SlideList" >
			            	<div id="manageslide_scrollbar_content" class="clsScrollBar_SlideContent" style="height:{$photoAlbumBox}px;">
			                	<div id="dhtmlgoodies_dragDropContainer">
			                		<ul class="ui-sortable" id="ulThumbnailList">
			                    		{assign var='count' value='0'}
			                    		{foreach key=photoAlbumlistKey item=photoalbumlist from=$myobj->list_slidelist_block.getOrganizeSlidelistList.row}
			                    			{counter  assign=count}
			                    			<!-- Do not change class name and structure -->
			                        		<li id="{$photoalbumlist.photo_id}" class="photolistitem">
			                         			<div class="imagecontainer">
			                         				<a href="javascript:;">
			                             				<img src="{$photoalbumlist.img_src}" class="thumbnailimage" alt="{$photoalbumlist.photo_title}" title="{$photoalbumlist.photo_title}">
			                         				</a>
			                         			</div>
			                         			<div class="captiondisplay" style="opacity: 0.8;">{$photoalbumlist.photo_wbr_title}</div>
			                        			<div class="" style="position:relative;">
			                         				<div style="display:none;" class="deletethumbnail" id="del_{$photoalbumlist.photo_id}">X</div>
			                        			</div>
			                        		</li>
			                    		{/foreach}
			                		</ul>
			                	</div>
			         		</div>
		        		</div>
		     		</div>
				<input type="hidden" name="photo_order_ids" id="photo_order_ids" value="" />
				</form>
	    	</div>
		   {$myobj->setTemplateFolder('general/','photo')}
		   {include file='box.tpl' opt='popupwithheadingbottom_bottom'}
		</div>
	{/if}
{else}
	{$myobj->setTemplateFolder('general/','photo')}
 	{include file='box.tpl' opt='popupbox_top'}
		<div id="selMsgAlert" class="clsNoMarginAlert"><p>{$LANG.sidebar_no_photo_found_error_msg}</p></div>
  	{$myobj->setTemplateFolder('general/','photo')}
  	{include file='box.tpl' opt='popupbox_bottom'}
{/if}
{literal}
	<script language="javascript" type="text/javascript">
       photoslidelistmanage = true;
    </script>
{/literal}

<div class="clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_top"}
<div id="selPhotoPlaylistManage">
  <!-- heading -->
  <div class="clsMainBarHeading">
    <h3> {if $myobj->getFormField('photo_playlist_id') != ''}
      {$LANG.photoslidelist_update_playlist_label}
      {else}
      {$LANG.photoslidelist_createlist}
      {/if} </h3>
  </div>
  <!-- information div -->
  {$myobj->setTemplateFolder('general/', 'photo')}
  {include file='information.tpl'}
  <!-- Multi confirmation box -->
  <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
  {$myobj->setTemplateFolder('general/','photo')}
 	 {include file='box.tpl' opt='popupbox_top'}
    <p id="confirmMessage"></p>
    <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
      <input type="submit" class="clsPopUpButtonSubmit" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
      &nbsp;
      <input type="button" class="clsPopUpButtonReset" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
      <input type="hidden" name="photo_playlist_ids" id="photo_playlist_ids" />
      <input type="hidden" name="action" id="action" />
      {$myobj->populateHidden($myobj->hidden_arr)}
    </form>
	{$myobj->setTemplateFolder('general/','photo')}
   {include file='box.tpl' opt='popupbox_bottom'}
  </div>
  <!-- confirmation box-->
  <!-- Single confirmation box -->
  <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
  {$myobj->setTemplateFolder('general/','photo')}
 	{include file='box.tpl' opt='popupbox_top'}
    <p id="confirmMessageSingle"></p>
    <form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="{$myobj->getCurrentUrl(true)}">
      <input type="submit" class="clsPopUpButtonSubmit" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
      &nbsp;
      <input type="button" class="clsPopUpButtonReset" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
      <input type="hidden" name="photo_playlist_ids" id="photo_playlist_ids" />
      <input type="hidden" name="action" id="action" />
      {$myobj->populateHidden($myobj->hidden_arr)}
    </form>
	{$myobj->setTemplateFolder('general/','photo')}
    {include file='box.tpl' opt='popupbox_bottom'}
  </div>
  <!-- confirmation box-->
  <!-- Create playlist block -->
  {if $myobj->isShowPageBlock('create_playlist_block')}
  <form name="photoPlayListManage" id="photoPlayListManage" method="post" action="{$myobj->getCurrentUrl()}" >
    <div class="clsDataTable clsBorderBottom">
      <table class="clsCreateAlbumTb1">
        <tr>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="playlist_name"> {$LANG.photoslidelist_name} </label>
            <span class="clsMandatoryFieldIcon">*</span> </td>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><input type="text" name="playlist_name" id="playlist_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('playlist_name')}" maxlength="{$CFG.fieldsize.photo_playlist_name.max}">
            <p>{$myobj->getFormFieldErrorTip('playlist_name')}</p>
            <p>{$myobj->ShowHelpTip('photo_playlist_name', 'playlist_name')} </p></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><label for="playlist_description"> {$LANG.photoslidelist_description} </label>
            <span class="clsMandatoryFieldIcon">*</span> </td>
          <td align="left" valign="top" class="clsFormFieldCellDefault clsUploadBlock"><textarea name="playlist_description" id="playlist_description" cols="45" rows="5" tabindex="{smartyTabIndex}">{$myobj->getFormField('playlist_description')}</textarea>
            <p>{$myobj->getFormFieldErrorTip('playlist_description')}</p>
            <p>{$myobj->ShowHelpTip('photo_playlist_description', 'playlist_description')} </p></td>
        </tr>
        <tr>
          <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
          <td align="left" valign="top" class="clsFormFieldCellDefault"><input  type="hidden" class="clsSubmitButton" name="photo_playlist_id" id="photo_playlist_id" value="{$myobj->getFormField('photo_playlist_id')}" />
            <div class="clsSubmitButton-l"><span class="clsSubmitButton-r">
              <input type="submit" class="clsSubmitButton" name="playlist_submit" id="playlist_submit" value="{if $myobj->getFormField('photo_playlist_id') != ''}{$LANG.photoslidelist_update_playlist_label}{else}{$LANG.photoslidelist_create_palylist}{/if}" tabindex="{smartyTabIndex}">
              </span></div>
            {if $myobj->chkIsAdminSide()}
            <div class="clsDeleteButton-l"><span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.photoslidelist_Cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/photo/photoSlideList.php')"tabindex="{smartyTabIndex}">
              </span></div>
            {else}
            <div class="clsDeleteButton-l"><span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.photoslidelist_Cancel_label}" onclick="Redirect2URL('{$myobj->createplaylist_url}')"tabindex="{smartyTabIndex}">
              </span></div>
            {/if} </td>
        </tr>
      </table>
    </div>
  </form>
  {/if}
  {if $myobj->isShowPageBlock('list_playlist_block') && !$myobj->chkIsAdminSide()}
  <form id="delePhotoForm" name="delePhotoForm" method="post" action="{$myobj->getCurrentUrl(true)}">
    <div id="selPhotoPlaylistManageDisplay">
      <p class="clsPlayListStepsTitle">{$LANG.photoslidelist_title}</p>
      {if $myobj->isResultsFound()}
      <div class="clsOverflow clsManageSlideList">
      	<p class="clsPlayListStepsTitle clsFloatLeft">
	  		<input type="checkbox" name="check_all" id="check_all" class="clsRadioButtonBorder" onclick="CheckAll(document.delePhotoForm.name, document.delePhotoForm.check_all.name)" />
	  	</p>
	  		<div class="clsOverflow">
        		<div class="clsDeleteButton-l">
					<span class="clsDeleteButton-r">
          				<input type="button" class="clsSubmitButton" name="button" id="button" value="{$LANG.photoslidelist_delete}" onClick="getMultiCheckBoxValue('delePhotoForm', 'check_all', '{$LANG.photoslidelist_err_tip_select_titles}');if(multiCheckValue!='') getAction('delete')"/>
					</span>
				</div>
      		</div>
      </div>
      <div class="clsOverflow clsSlideBorder">
       <div class="clsPhotoPaging">
      	{if $CFG.admin.navigation.top}
        {$myobj->setTemplateFolder('general/', 'photo')}
        {include file=pagination.tpl}
      {/if}
      </div>
      </div>
      <div class="clsOverflow">
        {assign var=count value=1}
        {foreach key=photoPlaylistKey item=photoplaylist from=$myobj->list_playlist_block.showPlaylists}
         <div class="clsListContents">
         <div class="clsNewAlbumList {if $count % 3 == 0} clsThumbPhotoFinalRecord{/if}">
           {$myobj->setTemplateFolder('general/','photo')}
           {include file="box.tpl" opt="listimage_top"}
		    {if $photoplaylist.getPlaylistImageDetail.total_record gt 0}
          		<div class="clsPhotoListDetails" onmouseover="showCaption('slideList_{$photoplaylist.photo_playlist_id}');" onmouseout="hideCaption('slideList_{$photoplaylist.photo_playlist_id}')">
	           		<div class="clsMultipleImage clsPointer">
           			  {foreach key=playlistImageDetailKey item=playlistImageDetailValue from=$photoplaylist.getPlaylistImageDetail.row}
						   <table  {if $playlistImageDetailKey % 2 == 0}class="clsSlidelistFinalRecord"{/if}>
								<tr>
									<td>
                                      <div>
										<a href="{$photoplaylist.playlist_view_link}">
											<img src="{$playlistImageDetailValue.playlist_path}" alt="{$playlistImageDetailValue.photo_title_word_wrap}" title="{$playlistImageDetailValue.photo_title_word_wrap}"/>
										</a>
                                      </div>
									</td>
								</tr>
							 </table>
						  {/foreach}
						  {if $photoplaylist.getPlaylistImageDetail.total_record lt 4}
							  {section name=foo start=0 loop=$photoplaylist.getPlaylistImageDetail.noimageCount step=1}
							  {assign var =countNoImage value=$smarty.section.foo.index}
							  {* Condition added to apply class to second column no images to fix browser issue *}
							  <table {if $photoplaylist.getPlaylistImageDetail.noimageCount eq 4}
											{if $countNoImage % 2 == 0}class="clsSlidelistFinalRecord"{/if}
										{elseif $photoplaylist.getPlaylistImageDetail.noimageCount eq 3}
											{if $countNoImage eq 0 || $countNoImage eq 2}class="clsSlidelistFinalRecord"{/if}
										{elseif $photoplaylist.getPlaylistImageDetail.noimageCount eq 2}
											{if $countNoImage eq 1}class="clsSlidelistFinalRecord"{/if}
										{elseif $photoplaylist.getPlaylistImageDetail.noimageCount eq 1}
											class="clsSlidelistFinalRecord"
										{/if}>
								<tr>
								  <td><img src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImageSlieList.jpg" /></td>
								</tr>
							  </table>
							  {/section}
						  {/if}
				 	</div>
          		</div>
			  {else}
				  <div class="clsPhotoListDetails">
					<div class="clsPhotoSlideListNoImage">
						<img  src="{$CFG.site.url}photo/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/icon-noImageSlieList.jpg" />
					</div>
				</div>
			  {/if}
		 <div class="clsOverflow">
          <div class="clsGetEditDel" onmouseover="showCaption('slideList_{$photoplaylist.photo_playlist_id}');" onmouseout="hideCaption('slideList_{$photoplaylist.photo_playlist_id}')" id="slideList_{$photoplaylist.photo_playlist_id}" style="display:none;">
        <ul class="clsContentEditLinks">
          <li class="clsEdit"><a href="{$photoplaylist.edit_link}" class="clsPhotoVideoEditLinks" title="{$LANG.photoslidelist_edit_playlist}">{$LANG.photoslidelist_edit_playlist}</a></li>
          <li class="clsDelete"><a href="javascript:void(0);" class="clsPhotoVideoEditLinks" title="{$LANG.photoslidelist_delete_playlist}" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','photo_playlist_ids', 'confirmMessageSingle'), Array('delete','{$photoplaylist.photo_playlist_id}', '{$LANG.photoslidelist_delete_confirmation}'), Array('value','value', 'innerHTML'), -100, -500);">{$LANG.photoslidelist_delete_playlist}</a></li>
       <li class="clsManageSlideListPop"><a class="clsPhotoVideoEditLinks" href="{$CFG.site.photo_url}organizeSlidelist.php?photo_slidelist_id={$photoplaylist.record.photo_playlist_id}" id="manage_{$photoplaylist.record.photo_playlist_id}">{$LANG.photoslidelist_organize_playlist}</a></li>
       </ul>
          </div>
          </div>
          <div class="clsAlbumContentDetails">
           <div>
            <p class="clsPhotoSlideListHeading"><input type="checkbox" name="forum_ids[]" id="check" class="clsRadioButtonBorder" tabindex="{smartyTabIndex}" value="{$photoplaylist.photo_playlist_id}" onClick="disableHeading('delePhotoForm');"/>
            <span class="clsHeading"><a href="{$photoplaylist.playlist_view_link}" title="{$photoplaylist.playlist_name}">{$photoplaylist.playlist_name}</a></span> </p>
           </div>
           <p class="clsAlbumContent">{$LANG.photoslidelist_total_photo}<span>{$photoplaylist.total_photos}</span></p>
           </div>
			{$myobj->setTemplateFolder('general/','photo')}
           {include file="box.tpl" opt="listimage_bottom"}
         </div>
         </div>
         {assign var=count value=$count+1}
        {/foreach}
        </div>
      {*<div class="clsOverflow">
        <div class="clsDeleteButton-l"><span class="clsDeleteButton-r">
          <input type="button" class="clsSubmitButton" name="button" id="button" value="{$LANG.photoslidelist_delete}" onClick="getMultiCheckBoxValue('delePhotoForm', 'check_all', '{$LANG.photoslidelist_err_tip_select_titles}');if(multiCheckValue!='') getAction('delete')"/></span></div>
      </div>*}
      <div class="clsOverflow clsSlideBorder">
        <div id="bottomLinks" class="clsPhotoPaging">
         {if $CFG.admin.navigation.bottom}
            {$myobj->setTemplateFolder('general/', 'photo')}
            {include file='pagination.tpl'}
         {/if}
        </div>
      </div>
      {else}
      {$myobj->setTemplateFolder('general/','photo')}
       {include file='box.tpl' opt='popupbox_top'}
          <div id="selMsgAlert" class="clsNoMarginAlert"><p>{$LANG.photoslidelist_no_records_found}</p></div>
		  {$myobj->setTemplateFolder('general/','photo')}
       {include file='box.tpl' opt='popupbox_bottom'}
      {/if} </div>
  </form>
  {/if}
 </div>
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_bottom"}
</div>
<script>
{literal}
$Jq(document).ready(function() {
    for(var i=0;i<manage_slidelist_ids.length;i++)
	{
	$Jq('#manage_'+manage_slidelist_ids[i]).fancybox({
		'width'				: 865,
		'height'			: 336,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	}
});
{/literal}
</script>
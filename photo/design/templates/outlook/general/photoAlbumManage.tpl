<div id="selPhotoPlaylistManage" class="clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_top"}
	<!-- heading -->
	<div class="clsMainBarHeading"><h3>
    	{if $myobj->getFormField('photo_album_id') != ''}
        	{$LANG.photoalbum_update_album_label}
        {else}
        	{$LANG.photoalbum_createlist}
        {/if}
    </h3></div>
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
                <input type="hidden" name="photo_album_ids" id="photo_album_ids" />
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
                <input type="hidden" name="photo_album_ids" id="photo_album_ids" />
                <input type="hidden" name="action" id="action" />
                {$myobj->populateHidden($myobj->hidden_arr)}
		</form>
		{$myobj->setTemplateFolder('general/','photo')}
      {include file='box.tpl' opt='popupbox_bottom'}
	</div>
    <!-- confirmation box-->
    <!-- Create album block -->
	{if $myobj->isShowPageBlock('create_album_block')}
    <form name="photoAlbumManages" id="photoAlbumManages" method="post" action="{$myobj->getCurrentUrl()}" >
            <div class="clsDataTable clsBorderBottom"><table class="clsCreateAlbumTable">
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<label for="photoalbum_title">
                    	{$LANG.photoalbum_title}
                    </label>{$myobj->displayCompulsoryIcon()}
                </td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                	<input type="text" name="photo_album_title" id="photo_album_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('photo_album_title')}">
                	<p>{$myobj->getFormFieldErrorTip('photo_album_title')}</p>
                   <p>{$myobj->ShowHelpTip('photo_album_title', 'photo_album_title')} </p></td>
              </tr>
              <tr>
              	<td align="left" valign="top" class="clsFormFieldCellDefault"><label for="album_access_type">{$LANG.photoalbum_album_access_type}</label></td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">
                	<input type="radio" name="album_access_type" id="album_access_type" class="clsRadioButtonBorder" value="Private" {$myobj->isCheckedRadio('album_access_type','Private')} /> <strong>{$LANG.common_yes_option}</strong>
                	<input type="radio" name="album_access_type" id="album_access_type" class="clsRadioButtonBorder" value="Public" {$myobj->isCheckedRadio('album_access_type','Public')}  /> <strong>{$LANG.common_no_option}</strong>
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="clsFormFieldCellDefault">&nbsp;</td>
                <td align="left" valign="top" class="clsFormFieldCellDefault">

                    <input  type="hidden" class="clsSubmitButton" name="photo_album_id" id="photo_album_id" value="{$myobj->getFormField('photo_album_id')}" />
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" class="clsSubmitButton" name="album_submit" id="album_submit" value="{if $myobj->getFormField('photo_album_id') != ''}{$LANG.photoalbum_update_album_label}{else}{$LANG.photoalbum_create_palylist}{/if}" tabindex="{smartyTabIndex}"></span></div>
                {*if $myobj->chkIsAdminSide()}
                	<div class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.photoalbum_Cancel_label}" onclick="Redirect2URL('{$CFG.site.url}admin/photo/photoPlaylist.php')"tabindex="{smartyTabIndex}"></span></div>
                {else*}
                	<div class="clsDeleteButton-l"><span class="clsDeleteButton-r"><input type="button" class="clsSubmitButton" name="cancel_submit" id="cancel_submit" value="{$LANG.photoalbum_Cancel_label}" onclick="Redirect2URL('{$myobj->createalbum_url}')"tabindex="{smartyTabIndex}"></span></div>
                {*/if*}
                </td>
              </tr>
            </table>
          </div>
  </form>
    {/if}
    {if $myobj->isShowPageBlock('list_album_block')}
    	<div id="selPhotoPlaylistManageDisplay" class="clsManageCommentsDisplay">
            {if $myobj->isResultsFound()}
               <div class="clsOverflow clsSlideBorder">
                        <div class="clsPhotoPaging">
                  		{if $CFG.admin.navigation.top}
                          {$myobj->setTemplateFolder('general/', 'photo')}
                          {include file=pagination.tpl}
                       {/if}
                         </div>
                       </div>
               <form id="delePhotoForm" name="delePhotoForm" method="post" action="{$myobj->getCurrentUrl(true)}">
                    <div class="clsDataTable">
                        <table class="clsManageCommentsTb1 clsBorderBottom">
                            <tr>
                                <th class="clsBorderLeft"><input type="checkbox" name="check_all" id="check_all" class="clsRadioButtonBorder" onclick="CheckAll(document.delePhotoForm.name, document.delePhotoForm.check_all.name)" /></th>
                                 <th class="{$myobj->getOrderCss('photoalbum_title')} clsSelectLarge"><a href="javascript:void(0)" onclick="return changeOrderbyElements('delePhotoForm','photo_album_title')" title="{$LANG.photoalbum_title}">{$LANG.photoalbum_title}</a></th>
                                <th>{$LANG.photoalbum_totla_photo}</th>
                                <th class="{$myobj->getOrderCss('album_access_type')}"><a href="javascript:void(0)" onclick="return changeOrderbyElements('delePhotoForm','album_access_type')" title="{$LANG.photoalbum_access_type}">{$LANG.photoalbum_access_type}</a></th>
                                <th colspan="4" class="clsUserActionTh">{$LANG.photoalbum_user_action}</th>
                            </tr>
                            {foreach key=photoPlaylistKey item=photoalbum from=$myobj->list_album_block.showAlbums}
                            <tr>
                                <td class="clsBorderLeft clsCheckBoxWidth">
									{if $photoalbum.photo_album_id!= 1}
									<input type="checkbox" name="photo_album_ids[]" id="check" class="clsRadioButtonBorder" tabindex="{smartyTabIndex}" value="{$photoalbum.photo_album_id}" onClick="disableHeading('delePhotoForm');"/>
									{/if}
									</td>
                                <td><a href="{$photoalbum.album_view_link}" title="{$photoalbum.photo_album_title}">{$photoalbum.album_wrap_title}</a></td>
								<td>{$myobj->getPhotoCount($photoalbum.photo_album_id)}</td>
								<td>{$photoalbum.album_access_type}</td>
                                <td class="clsMngComments clsTableNoBorder"><a class="clsEdit clsPhotoVideoEditLinks"  href="{$photoalbum.edit_link}" title="{$LANG.photoalbum_edit_album}">{$LANG.photoalbum_edit_album}</a></td>
								<td  class="clsMngComments">
								{if $photoalbum.photo_album_id!= 1}
								<a class="clsDelete clsPhotoVideoEditLinks" href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action','photo_album_ids','confirmMessageSingle'), Array('delete','{$photoalbum.photo_album_id}', '{$LANG.photoalbum_delete_confirmation}'), Array('value','value','innerHTML'), -100, -500);" title="{$LANG.photoalbum_delete_album}">{$LANG.photoalbum_delete_album}</a>
								{/if}
								</td>
                            {/foreach}
                            <tr>
                            {$myobj->populateHidden($myobj->hidden_arr)}
                            </table>
                 <div class="clsManageCommentsBtn clsOverflow">
                 <div class="clsDeleteButton-l"><span class="clsDeleteButton-r">
				 <input type="button" class="clsSubmitButton" name="button" id="button" value="{$LANG.photoalbum_delete}" onClick="getMultiCheckBoxValue('delePhotoForm', 'check_all', '{$LANG.photoalbum_err_tip_select_titles}');if(multiCheckValue!='') getAction('delete')"/></span></div>

                   <div class="clsOverflow clsSlideBorder">
                    <div id="bottomLinks" class="clsPhotoPaging">
                	  {if $CFG.admin.navigation.bottom}
					  {$myobj->setTemplateFolder('general/', 'photo')}
                        {include file='pagination.tpl'}
                    {/if}
                    </div>
                </div>
        		</div>
                 {else}
                 <div id="selMsgAlert">
                    <p>{$LANG.photoalbum_no_records_found}</p>
                 </div>
               {/if}
              </div>
                </form>
    		{/if}
		</div>
{$myobj->setTemplateFolder('general/','photo')}
{include file="box.tpl" opt="photomain_bottom"}
 </div>
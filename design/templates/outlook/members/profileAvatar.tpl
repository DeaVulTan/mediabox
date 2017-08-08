{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selEditPersonalProfile">
<div class="clsPageHeading"><h2>{$LANG.profileavatar_title_basic}</h2></div>
  	<div id="selLeftNavigation">
 {$myobj->setTemplateFolder('general/')}
 {include file='information.tpl'}
<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
	  <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
		<p id="confirmMessage"></p>
			<!-- clsFormSection - starts here -->
			  <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="{$LANG.common_confirm}" tabindex="{smartyTabIndex}" />
			  &nbsp;
			  <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
		<input type="hidden" name="action" />
		<!-- clsFormSection - ends here -->
	  </form>
	</div>
{if $myobj->isShowPageBlock('form_editprofile')}
	<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		<div class="clsDataTable">
        <table summary="{$LANG.profileavatar_tbl_summary}" class="clsProfileEditTbl">
        	<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('user_image')}"><label for="user_image">{$LANG.profileavatar_image}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('user_image')}">
					<input type="file" class="clsFileBox" name="user_image" id="user_image" tabindex="{smartyTabIndex}"/>
                    ({$CFG.admin.members_profile.profile_image_max_size}&nbsp;KB)<br />({$myobj->changeArrayToCommaSeparator($CFG.admin.members_profile.image_format_arr)})<br />
                    {$myobj->getFormFieldErrorTip('user_image')}
				</td>
			</tr>
		   	<tr>
				<td>&nbsp;</td>
                <td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<div class="clsSubmitLeft"><div class="clsSubmitRight">
						<input type="submit" class="clsSubmitButton" name="editprofile_submit" id="editprofile_submit" tabindex="{smartyTabIndex}" value="{$LANG.profileavatar_submit}" />
					</div>
				</td>
		   	</tr>
		   	{if isset($CFG.admin.module.cam_profile_avatar) && $CFG.admin.module.cam_profile_avatar}
		   	<tr>
				<td>&nbsp;</td>
                <td class="{$myobj->getCSSFormFieldCellClass('submit')}">
					<strong>{$LANG.profileavatar_captured_images|replace:'link':$myobj->getUrl('profilecamavatar')}</strong>
				</td>
		   	</tr>
		   	{/if}
		   	{if $myobj->avatar_image_exists}
		   	<tr>
		   		<td>&nbsp;</td>
           		<td>
           		<a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="{$myobj->getUserDetail('user_id', $CFG.user.user_id, 'profile_url')}">
					<img src="{$myobj->icon.t_url}?{php}echo time(){/php}" alt="{$CFG.user.user_name|truncate:9}" title="{$CFG.user.user_name}" border="0" {$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $myobj->icon.t_width, $myobj->icon.t_height)}/>
				</a>
               	</td>
		   	</tr>
		   	<tr>
		   		<td>&nbsp;</td>
		   		<td>
					<a onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action', 'confirmMessage'), Array('delete_avatar', '{$LANG.profileavatar_delete_confirmation}'), Array('value', 'innerHTML'))">{$LANG.profileavatar_delete_image}</a>
               	</td>
		   	</tr>
		   	{/if}
		</table>
        </div>
	</form>
{/if}{* end of isShowPageBlock('form_editprofile') *}
	</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
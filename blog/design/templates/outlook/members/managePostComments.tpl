<script language="javascript" type="text/javascript" src=cfg_site_url+"js/functions.js"></script>

{literal}
<script language="javascript" type="text/javascript">
	var block_arr= new Array('selMsgConfirm');
	function changeCommentStatus(statusVal)
		{
			document.commentStatusForm.submit();
		}
</script>
{/literal}
<div id="selPostCommentContainer"> {$myobj->setTemplateFolder('general/','blog')}
  {include file="box.tpl" opt="display_top"}
  <div class="clsOverflow">
    <div class="clsListHeadingLeft">
      <h2>{$myobj->form_manage_comments.comments_title}</h2>
    </div>
    <div class="clsListHeadingRight">
      <form name="commentStatusForm" id="commentStatusForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <select name="comment_status" id="comment_status" tabindex="{smartyTabIndex}" onchange="return changeCommentStatus(this.value)">
          <option value="" {if $myobj->getFormField('comment_status') == ''}Selected{/if}>{$LANG.managepostcomments_selectbox_all}</option>
          <option value="{$LANG.common_yes_option}" {if $myobj->getFormField('comment_status') == $LANG.common_yes_option}Selected{/if}>{$LANG.managepostcomments_activate}</option>
          <option value="{$LANG.common_no_option}" {if $myobj->getFormField('comment_status') == $LANG.common_no_option}Selected{/if}>{$LANG.managepostcomments_inactivate}</option>
        </select>
      </form>
    </div>
  </div>
  {$myobj->setTemplateFolder('general/','blog')}
  {include file='../general/information.tpl'}
  <div id="selLeftNavigation">
    <div id="selMsgConfirm" style="display:none;" class="clsMsgConfirm">
     {$myobj->setTemplateFolder('general/','blog')}
 	 {include file='box.tpl' opt='popupbox_top'}
      <p id="selConfirmMsg"></p>
      <form name="confirm_form" id="confirm_form" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <input type="submit" class="clsPopUpButtonSubmit" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        <input type="hidden" name="comment_id" id="comment_id" />
        <input type="hidden" name="act" id="act" />
        {$myobj->populateHidden($myobj->form_manage_comments.form_hidden_value)}
      </form>
	{$myobj->setTemplateFolder('general/','blog')}
    {include file='box.tpl' opt='popupbox_bottom'} 
    </div>
    {if $myobj->isShowPageBlock('comments_form')}
    <div id="selManageCommentsDisplay" class="clsManageCommentsDisplay"> {if $myobj->form_manage_comments.record_found}
      {$myobj->setTemplateFolder('general/','blog')}
      {if $CFG.admin.navigation.top}
      {include file='../general/pagination.tpl'}
      {/if}
      <div class="clsDataTable">
        <form name="commendsForm" id="commendsForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
          <table summary="{$myobj->form_manage_comments.comments_tbl_summary}" class="clsManageCommentsTb1">
            <tr>
              <th class="clsBorderLeft"> <input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="check_all" onclick="CheckAll(document.commendsForm.name, document.commendsForm.check_all.name)" />
              </th>
              <th class="clsWidth150">{$myobj->form_manage_comments.comments_module}</th>
              <th class="clsWidth90">{$LANG.managepostcomments_by}</th>
              <th class="clsWidth75">{$LANG.managepostcomments_date}</th>
              <th class="clsWidth55">{$LANG.managepostcomments_status}</th>
              <th class="clsTableNoBorder">{$LANG.managepostcomments_option}</th>
            </tr>
            <div class="clsTabBorder">
            {if $myobj->form_manage_comments.comments_list}
            {foreach key=inc item=value from=$myobj->form_manage_comments.comments_list}
            <tr class="{$value.tr_class}">
              <td class="clsBorderLeft"><input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="comment_ids[]" value="{$value.comment_id}" tabindex="{smartyTabIndex}" {$value.comment_chk_value} onClick="disableHeading('commendsForm');"/></td>
              <td id="selCommentGallery"><p id="selCommentTitle"><a href="{$value.module_view_link}">{$value.comment_title}</a></p></td>
              <td id="selCommentGallery"><p id="selMemberName" class="clsGroupSmallImg"><a href="{$value.member_profile_url}"><span>{$value.user_details}</span></a></p></td>
              <td>{$value.date_added}</td>
              <td> {if $value.comment_status == 'Yes'}
                {$LANG.managepostcomments_activate}
                {elseif $value.comment_status == 'No'}
                {$LANG.managepostcomments_inactivate}
                {/if} </td>
              <td class="clsMngComments"><a href="javascript:void(0);"  onclick="popupWindow('{$value.viewcomment_url}')">{$value.comment}</a></td>
            </tr>
            {/foreach}
            {/if}
            </div>
          </table>
          <div class="clsManageCommentsBtn clsOverflow"><a href="#" id="dAltMulti"></a> {$myobj->populateHidden($myobj->form_manage_comments.form_hidden_value)}
            <p class="clsDeleteButton-l clsFloatLeft"> <span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.managepostcomments_delete}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'delete', '{$LANG.managepostcomments_delete_confirmation}'), Array('value','value', 'innerHTML'), 0, 0);" />
              </span></p>
            {if $myobj->getFormField('comment_status') != $LANG.common_yes_option}
            <p class="clsSubmitButton-l clsFloatLeft"> <span class="clsSubmitButton-r">
              <input type="button" class="clsSubmitButton" name="activate" id="activate" tabindex="{smartyTabIndex}" value="{$LANG.managepostcomments_activate_button_label}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'activate', '{$LANG.managepostcomments_activate_confirmation}'), Array('value','value', 'innerHTML'), 200, 100);" />
              </span></p>
            {/if}
            {if $myobj->getFormField('comment_status') != $LANG.common_no_option}
            <p class="clsDeleteButton-l clsFloatLeft"> <span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="inactivate" id="inactivate" tabindex="{smartyTabIndex}" value="{$LANG.managepostcomments_inactivate_button_label}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'inactivate', '{$LANG.managepostcomments_inactivate_confirmation}'), Array('value','value', 'innerHTML'), 200, 100);" />
              </span></p>
            {/if} </div>
        </form>
      </div>
      {if $CFG.admin.navigation.bottom}
      {$myobj->setTemplateFolder('general/','blog')}
      {include file='../general/pagination.tpl'}
      {/if}
      {else}
      <div id="selMsgAlert">
        <p>{$LANG.common_no_records_found}</p>
      </div>
      {/if} </div>
    {/if} </div>
  {$myobj->setTemplateFolder('general/','blog')}
  {include file="box.tpl" opt="display_bottom"} </div>

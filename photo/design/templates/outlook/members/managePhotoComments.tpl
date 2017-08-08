<script language="javascript" type="text/javascript" src=cfg_site_url+"js/functions.js"></script>

{literal}
<script language="javascript" type="text/javascript">
   managePhotoCommentsPage = true;
	var block_arr= new Array('selMsgConfirm');
	function changeCommentStatus(statusVal)
		{
			document.commentStatusForm.submit();
		}
</script>
{/literal}
<div id="selPhotoPlayListContainer" class="clsOverflow">
{$myobj->setTemplateFolder('general/','photo')}
  {include file="box.tpl" opt="photomain_top"}
  <div class="clsOverflow">
    <div class="clsHeadingLeft">
      <h2><span>{$myobj->form_manage_comments.comments_title}</span></h2>
    </div>
    <div class="clsHeadingRight">
      <form name="commentStatusForm" id="commentStatusForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <select name="comment_status" id="comment_status" tabindex="{smartyTabIndex}" onchange="return changeCommentStatus(this.value)">
          <option value="" {if $myobj->getFormField('comment_status') == ''}Selected{/if}>{$LANG.managephotocomments_selectbox_all}</option>
          <option value="{$LANG.common_yes_option}" {if $myobj->getFormField('comment_status') == $LANG.common_yes_option}Selected{/if}>{$LANG.managephotocomments_activate}</option>
          <option value="{$LANG.common_no_option}" {if $myobj->getFormField('comment_status') == $LANG.common_no_option}Selected{/if}>{$LANG.managephotocomments_inactivate}</option>
        </select>
      </form>
    </div>
  </div>
  {$myobj->setTemplateFolder('general/', 'photo')}
  {include file='../general/information.tpl'}
  <div id="selLeftNavigation">
    <div id="selMsgConfirm" style="display:none;" class="clsMsgConfirm">
	{$myobj->setTemplateFolder('general/', 'photo')}
 	 {include file='box.tpl' opt='popupbox_top'}
      &nbsp;
      <p id="selConfirmMsg"></p>
        &nbsp;
      <form name="confirm_form" id="confirm_form" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
        <input type="submit" class="clsPopUpButtonSubmit" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        <input type="hidden" name="comment_id" id="comment_id" />
        <input type="hidden" name="act" id="act" />
        {$myobj->populateHidden($myobj->form_manage_comments.form_hidden_value)}
      </form>
	  {$myobj->setTemplateFolder('general/', 'photo')}
    {include file='box.tpl' opt='popupbox_bottom'}
    </div>
    {if $myobj->isShowPageBlock('comments_form')}
    <div id="selManageCommentsDisplay" class="clsManageCommentsDisplay"> {if $myobj->form_manage_comments.record_found}
      {if $CFG.admin.navigation.top}
	  {$myobj->setTemplateFolder('general/', 'photo')}
      {include file='../general/pagination.tpl'}
      {/if}
      <div class="clsDataTable">
        <form name="commendsForm" id="commendsForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
          <table summary="{$myobj->form_manage_comments.comments_tbl_summary}" class="clsManageCommentsTb1">
            <tr>
              <th class="clsBorderLeft"> <input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="check_all" onclick="CheckAll(document.commendsForm.name, document.commendsForm.check_all.name)" />
              </th>
              <th class="clsWidth150">{$myobj->form_manage_comments.comments_module}</th>
              <th class="clsWidth90">{$LANG.managephotocomments_by}</th>
              <th class="clsWidth75">{$LANG.managephotocomments_date}</th>
              <th class="clsWidth55">{$LANG.managephotocomments_status}</th>
              <th class="clsTableNoBorder">{$LANG.managephotocomments_option}</th>
            </tr>
            <div class="clsTabBorder">
            {if $myobj->form_manage_comments.comments_list}
            {foreach key=inc item=value from=$myobj->form_manage_comments.comments_list}
            <tr class="{$value.tr_class}">
              <td class="clsBorderLeft"><input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="comment_ids[]" value="{$value.comment_id}" tabindex="{smartyTabIndex}" {$value.comment_chk_value} onClick="disableHeading('commendsForm');"/></td>
              <td id="selPhotoGallery"><p id="selPhotoTitle"><a href="{$value.module_view_link}" title="{$value.comment_title}">{$value.comment_title}</a></p></td>
              <td id="selPhotoGallery"><p id="selMemberName" class="clsGroupSmallImg"><a href="{$value.member_profile_url}" title="{$value.user_details}"><span>{$value.user_details}</span></a></p></td>
              <td>{$value.date_added}</td>
              <td> {if $value.comment_status == 'Yes'}
                {$LANG.managephotocomments_activate}
                {elseif $value.comment_status == 'No'}
                {$LANG.managephotocomments_inactivate}
                {/if} </td>
              <td class="clsMngComments"><a href="{$value.viewcomment_url}" id="manage_{$value.comment_id}">{$value.comment}</a></td>
            </tr>
            {/foreach}
            {/if}
            </div>
          </table>
          <div class="clsManageCommentsBtn clsOverflow"><a href="#" id="dAltMulti"></a> {$myobj->populateHidden($myobj->form_manage_comments.form_hidden_value)}
            
            {if $myobj->getFormField('comment_status') != $LANG.common_yes_option}
            <p class="clsSubmitButton-l"> <span class="clsSubmitButton-r">
              <input type="button" class="clsSubmitButton" name="activate" id="activate" tabindex="{smartyTabIndex}" value="{$LANG.managephotocomments_activate_button_label}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'activate', '{$LANG.managephotocomments_activate_confirmation}'), Array('value','value', 'innerHTML'), 200, 100);" />
              </span></p>
            {/if}
            {if $myobj->getFormField('comment_status') != $LANG.common_no_option}
            <p class="clsDeleteButton-l"> <span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="inactivate" id="inactivate" tabindex="{smartyTabIndex}" value="{$LANG.managephotocomments_inactivate_button_label}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'inactivate', '{$LANG.managephotocomments_inactivate_confirmation}'), Array('value','value', 'innerHTML'), 200, 100);" />
              </span></p>
            {/if}
            <p class="clsDeleteButton-l"> <span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.managephotocomments_delete}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'delete', '{$LANG.managephotocomments_delete_confirmation}'), Array('value','value', 'innerHTML'), 0, 0);" />
              </span>
            </p>
             </div>
        </form>
      </div>
      {if $CFG.admin.navigation.bottom}
	  {$myobj->setTemplateFolder('general/', 'photo')}
      {include file='../general/pagination.tpl'}
      {/if}
      {else}
      <div id="selMsgAlert">
        <p>{$LANG.common_no_records_found}</p>
      </div>
      {/if} </div>
    {/if} </div>
  {$myobj->setTemplateFolder('general/','photo')}
  {include file="box.tpl" opt="photomain_bottom"}
</div>
<script>
{literal}
$Jq(document).ready(function() {
    for(var i=0;i<manage_comment_ids.length;i++)
	{
	$Jq('#manage_'+manage_comment_ids[i]).fancybox({
		'width'				: 865,
		'height'			: 400,
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
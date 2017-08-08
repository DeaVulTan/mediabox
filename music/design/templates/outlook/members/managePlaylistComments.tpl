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
<div id="selManageMusicComments">
{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_top'}
    <div class="clsOverflow">
      <div class="clsHeadingLeft">
        <h2><span><span>{$myobj->form_manage_comments.comments_title}</span></h2>
      </div>
        <div class="clsHeadingRight">
				<form name="commentStatusForm" id="commentStatusForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
							<select name="comment_status" id="comment_status" tabindex="{smartyTabIndex}" onchange="return changeCommentStatus(this.value)">
								<option value="" {if $myobj->getFormField('comment_status') == ''}Selected{/if}>{$LANG.manageplaylistcomments_selectbox_all}</option>
								<option value="{$LANG.common_yes_option}" {if $myobj->getFormField('comment_status') == $LANG.common_yes_option}Selected{/if}>{$LANG.manageplaylistcomments_activate}</option>
								<option value="{$LANG.common_no_option}" {if $myobj->getFormField('comment_status') == $LANG.common_no_option}Selected{/if}>{$LANG.manageplaylistcomments_inactivate}</option>
							</select>
				</form>
        </div>
    </div>
{$myobj->setTemplateFolder('general/','music')}
	{include file='../general/information.tpl'}

	<div id="selLeftNavigation">
		<div id="selMsgConfirm" style="display:none;" class="clsMsgConfirm">
    		<p id="selConfirmMsg"></p>
	      	<form name="confirm_form" id="confirm_form" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">

						  	<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
			              	<input type="hidden" name="comment_id" id="comment_id" />
							<input type="hidden" name="act" id="act" />
							{$myobj->populateHidden($myobj->form_manage_comments.form_hidden_value)}

	      	</form>
	    </div>
		{if $myobj->isShowPageBlock('comments_form')}
      		<div id="selManageCommentsDisplay">
				{if $myobj->form_manage_comments.record_found}
					{if $CFG.admin.navigation.top}
						{$myobj->setTemplateFolder('general/','music')}
						{include file='../general/pagination.tpl'}
					{/if}
                    <div class="clsDataTable">
						<form name="commendsForm" id="commendsForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
						<table summary="{$myobj->form_manage_comments.comments_tbl_summary}" class="clsMyMusicAlbumTbl">
						  <tr>
							<th class="clsCheckBoxTD">
								<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.commendsForm.name, document.commendsForm.check_all.name)" />							</th>
							<th class="clsWidth150">{$myobj->form_manage_comments.comments_module}</th>
							<th class="clsWidth90">{$LANG.manageplaylistcomments_by}</th>
							<th class="clsWidth75">{$LANG.manageplaylistcomments_date}</th>
							<th class="clsWidth55">{$LANG.manageplaylistcomments_status}</th>
							<th>{$LANG.manageplaylistcomments_option}</th>
						  </tr>
						  {if $myobj->form_manage_comments.comments_list}
							{foreach key=inc item=value from=$myobj->form_manage_comments.comments_list}
								<tr class="{$value.tr_class}">
								  <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="comment_ids[]" value="{$value.comment_id}" tabindex="{smartyTabIndex}" {$value.comment_chk_value} onClick="disableHeading('commendsForm');"/></td>
								  <td id="selMusicGallery"><p id="selMusicTitle"><a href="{$value.module_view_link}">{$value.comment_title}</a></p></td>
								  <td id="selMusicGallery">
								  	{*{if $value.icon}
										<p id="selImageBorder"><a href="{$value.member_profile_url}"><img src="{$value.image_path}" alt="{$value.user_details}" {$value.image_attribute} /></a></p>
									{/if}*}
									<p id="selMemberName" class="clsGroupSmallImg"><a href="{$value.member_profile_url}">{$value.user_details}</a></p>								  </td>
								  <td>{$value.date_added}</td>
								  <td>
                                  {if $value.comment_status == 'Yes'}
                                   	{$LANG.manageplaylistcomments_activate}
                                  {elseif $value.comment_status == 'No'}
                                  	{$LANG.manageplaylistcomments_inactivate}
                                  {/if}
                                  </td>
								  <td><span>
                                  <a href="{$value.viewcomment_url}" id="manage_{$value.comment_id}" title="{$value.comment}">{$value.comment}</a>
                                  {*<a href="javascript:void(0);"  onclick="popupWindow('{$value.viewcomment_url}')">{$value.comment}</a>*}</span></td>
								</tr>
							{/foreach}
						  {/if}
						
						</table>
						<table style="border-bottom:0; margin-bottom:0;">
						  <tr>
                            <td style="padding:0">
								<a href="#" id="dAltMulti"></a>
								{$myobj->populateHidden($myobj->form_manage_comments.form_hidden_value)}
								<div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.manageplaylistcomments_delete}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'delete', '{$LANG.manageplaylistcomments_delete_confirmation}'), Array('value','value', 'innerHTML'), 0, 0);" /></span></div>
								{*if $myobj->getFormField('comment_status') != '' && $myobj->getFormField('comment_status') != $LANG.common_yes_option*}
									<div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" class="clsSubmitButton" name="activate" id="activate" tabindex="{smartyTabIndex}" value="{$LANG.manageplaylistcomments_activate_button_label}" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.common_check_atleast_one}', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'activate', '{$LANG.manageplaylistcomments_activate_confirmation}'), Array('value','value', 'innerHTML'), 200, 100);" /></span></div>
								{*/if*}							</td>
								 <td style="padding:0">
								{if $CFG.admin.navigation.bottom}
						{$myobj->setTemplateFolder('general/','music')}
						 {include file='../general/pagination.tpl'}
					{/if}
								</td>
						  </tr>
						</table>
					</form>
                    </div>
					<script>
					{literal}
					$Jq(window).load(function() {
						for(var i=0;i<manage_comment_ids.length;i++)
						{
						$Jq('#manage_'+manage_comment_ids[i]).fancybox({
							'width'				: 865,
							'height'			: '100%',
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
				{else}
					<div id="selMsgAlert">
						<p>{$LANG.common_no_records_found}</p>
					</div>
				{/if}
  		 	</div>
	    {/if}
	</div>

{$myobj->setTemplateFolder('general/','music')}
{include file='box.tpl' opt='audioindex_bottom'}
</div>

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
{$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='display_top'}
<div class="clsOverflow">
		<div class="clsVideoListHeading">
 			<h2><span>{$myobj->form_manage_comments.comments_title}</span></h2>
        </div>
        <div class="clsVideoListHeadingRight">
				<form name="commentStatusForm" id="commentStatusForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
							<select name="comment_status" id="comment_status" tabindex="{smartyTabIndex}" onchange="return changeCommentStatus(this.value)">
								<option value="" {if $myobj->getFormField('comment_status') == ''}Selected{/if}>{$LANG.manage_selectbox_all}</option>
								<option value="{$LANG.common_yes_option}" {if $myobj->getFormField('comment_status') == $LANG.common_yes_option}Selected{/if}>{$LANG.manage_comment_active}</option>
								<option value="{$LANG.common_no_option}" {if $myobj->getFormField('comment_status') == $LANG.common_no_option}Selected{/if}>{$LANG.manage_comment_inactive}</option>
							</select>
				</form>
        </div>
    </div>
	{$myobj->setTemplateFolder('general/','video')}
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
				{if $myobj->isResultsFound()}
					{if $CFG.admin.navigation.top}
						{$myobj->setTemplateFolder('general/','video')}
						{include file='../general/pagination.tpl'}
					{/if}
                    <div class="clsDataTable">
						<form name="commendsForm" id="commendsForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
						<table summary="{$myobj->form_manage_comments.comments_tbl_summary}" class="clsMyMusicAlbumTbl">
						  <tr>
							<th>
								<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.commendsForm.name, document.commendsForm.check_all.name)" />
							</th>
							<th class="clsWidth90">{$myobj->form_manage_comments.comments_module}</th>
							<th class="clsWidth90">{$LANG.manage_comment_by}</th>
							<th class="clsWidth90">{$LANG.manage_comment_date}</th>
							<th>{$LANG.manage_comment_option}</th>
							<th>{$LANG.manage_comment_status}</th>
						  </tr>
						  {if $myobj->form_manage_comments.comments_list}
							{foreach key=inc item=value from=$myobj->form_manage_comments.comments_list}
								<tr class="{$value.tr_class}">
								  <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="comment_ids[]" value="{$value.comment_id}" tabindex="{smartyTabIndex}" {$value.comment_chk_value} onClick="disableHeading('commendsForm');"/></td>
								  <td id="selMusicGallery">
                                        <div class="clsOverflow">
                                              <div class="clsThumbImageLink">
                                                    <a href="{$value.module_view_link}" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                       <img src="{$value.respose_video_img_src}" border="0" title="{$value.comment_title}" {$value.disp_image}/>
                                                      </a> 
                                              </div>
                                        </div>

                                        <a href="{$value.module_view_link}">{$value.comment_title}</a>
                                      </td>
								  <td id="selMusicGallery">
								  	{*{if $value.icon}
										<p id="selImageBorder"><a href="{$value.member_profile_url}"><img border="0" src="{$value.image_path}" alt="{$value.user_details}" {$value.image_attribute} /></a></p>
									{/if}*}
									<p id="selMemberName" class="clsGroupSmallImg"><a href="{$value.member_profile_url}">{$value.user_details}</a></p>
								  </td>
								  <td>{$value.date_added}</td>
								  <td>
								  		<span class="clsVideoCommentsList">
                                        <a href="{$value.viewcomment_url}" id="manage_{$value.comment_id}" title="{$value.comment}">{$value.comment}</a>
										</span>
								  </td>
                                                  <td>
                                                      {if $value.comment_status == 'Yes'}
                                                            {$LANG.manage_comment_active}
                                                      {else}
                                                            {$LANG.manage_comment_inactive}
                                                      {/if}
                                                  </td>
								</tr>
							{/foreach}
						  {/if}
</table>
		                            <div class="clsOverflow">
								<a href="#" id="dAltMulti"></a>
								<div class="clsGreyButtonSelect">
                                                	<select class="clsWidth150" name="action" id="action" tabindex="{smartyTabIndex}" >
                                                      <option value="" {if $myobj->getFormField('comment_status') == ''}Selected{/if}>{$LANG.common_select_option}</option>
                                                      <option value="activate" >{$LANG.manage_comment_activate}</option>
                                                      <option value="inactivate" >{$LANG.manage_comment_inactivate}</option>
                                                      <option value="delete">{$LANG.manage_comment_delete}</option>
									</select>
                                                </div>
		                                	<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" name="action_button" id="action_button" value="{$LANG.manage_comment_submit}" onClick="getMultiCheckBoxValue('commendsForm', 'check_all', '{$LANG.manage_comment_err_tip_select_titles}');if(multiCheckValue!='') getAction()"/>						</div></div>
		</div>
					</form>
                    </div>
					{if $CFG.admin.navigation.bottom}
						{$myobj->setTemplateFolder('general/','video')}
						 {include file='../general/pagination.tpl'}
					{/if}
				{else}
					<div id="selMsgAlert">
						<p>{$LANG.common_no_records_found}</p>
					</div>
				{/if}
  		 	</div>
	    {/if}
	</div>

{$myobj->setTemplateFolder('general/','video')}
{include file='box.tpl' opt='display_bottom'}
</div>
<script>
{literal}
$Jq(document).ready(function() {
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
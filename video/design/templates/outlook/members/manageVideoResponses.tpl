<div id="selManageMusicResponses">
	{$myobj->setTemplateFolder('general/')}
    {include file='box.tpl' opt='display_top'}
     <div class="clsOverflow">
 		<div class="clsVideoListHeading">
	    <h2><span>{$myobj->form_manage_responses.responses_title}</span></h2>

    </div>
     <div class="clsVideoListHeadingRight">
				<form name="commentStatusForm" id="commentStatusForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
							<select name="comment_status" id="comment_status" tabindex="{smartyTabIndex}" onchange="return changeCommentStatus(this.value)">
								<option value="" {if $myobj->getFormField('comment_status') == ''}Selected{/if}>{$LANG.manage_selectbox_all}</option>
								<option value="{$LANG.common_yes_option}" {if $myobj->getFormField('comment_status') == $LANG.common_yes_option}Selected{/if}>{$LANG.manage_comment_activate}</option>
								<option value="{$LANG.common_no_option}" {if $myobj->getFormField('comment_status') == $LANG.common_no_option}Selected{/if}>{$LANG.manage_response_inactivate}</option>
							</select>
				</form>
        </div>
    </div>
    {include file='information.tpl'}
	 <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.manage_response_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="response_ids" id="response_ids" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->form_manage_responses.form_hidden_value)}
					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
   	{if $myobj->isShowPageBlock('responses_form')}
      		<div id="selManageResponsesDisplay" class="clsLeftSideDisplayTable">

				{if $myobj->isResultsFound()}
					{if $CFG.admin.navigation.top}
						{$myobj->setTemplateFolder('general/')}
                        {include file='pagination.tpl'}
					{/if}
	  <form name="responsesForm" id="responsesForm" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
      					<div class="clsDataTable">
						<table summary="{$myobj->form_manage_responses.responses_tbl_summary}" class="clsMyMusicAlbumTbl">
						  <tr>
							<th class="clsAlignCenter">
								<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.responsesForm.name, document.responsesForm.check_all.name)" />							</th>
							<th>{$LANG.manage_response_video_image}</th>
							<th>{$LANG.manage_response_original_image}</th>
							<th>{$LANG.manage_response_by}</th>
							<th>{$LANG.manage_response_date}</th>
                            <th>{$LANG.manage_response_status}</th>
						  </tr>
						  {if $myobj->form_manage_responses.responses_list}
							{foreach key=inc item=value from=$myobj->form_manage_responses.responses_list}
								<tr>
								  <td class="clsWidth20"><input type="checkbox" class="clsCheckRadio" name="response_ids[]" value="{$value.response_id}" tabindex="{smartyTabIndex}" onClick="disableHeading('responsesForm');"/></td>
								  <td id="selMusicGallery" class="clsViewThumbImageMediumWidth">
                                      <div class="clsOverflow">
                                            <div class="clsThumbImageLink">
                                                <a href="{$value.respose_video_url}" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                     <img src="{$value.respose_video_img_src}" border="0" title="{$value.respose_video_title}" {$myobj->DISP_IMAGE(93, 70, $value.s_width, $value.s_height)}/>
                                                 </a>
                                            </div>
                                      </div>
                                    <p class="clsResponseVideoText">{$value.respose_video_title}</p>
                                  </td>
                                <td id="selMusicGallery" class="clsViewThumbImageMediumWidth">
                                        <div class="clsOverflow">
                                          <div class="clsThumbImageLink clsPointer">
                                                <a href="{$value.original_video_url}"class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                <img src="{$value.original_video_img_src}" border="0" title="{$value.original_video_title}" />
                                                </a>
                                          </div>
                                  	 </div>
                                    <p class="clsResponseVideoText">{$value.original_video_title}</p>								  </td>
								  <td><a href="{$value.response_user_url}">{$value.response_user_name}</a></td>
								  <td class="clsWidth90">{$value.response_date_added}</td>
								  <td class="clsWidth90">
                                  	{if $value.video_responses_status == 'Yes'}
                                   		{$LANG.manage_response_activate}
                                    {else}
                                    	{$LANG.manage_response_inactive}
                                    {/if}
                                  </td>
								</tr>
							{/foreach}
						  {/if}
						  <tr>
							<td></td>
                            <td colspan="5" class="{$myobj->getCSSFormFieldCellClass('response_submit')}">
								<a href="#" id="dAltMulti"></a>

								<div class="clsGreyButtonSelect"><select name="action" id="action" tabindex="{smartyTabIndex}" >
                                    <option value="" {if $myobj->getFormField('response_status') == ''}Selected{/if}>{$LANG.common_select_option}</option>
                                    <option value="activate" >{$LANG.manage_response_active}</option>
                                   <option value="inactive" >{$LANG.manage_response_inactive}</option>
                                   	<option value="delete">{$LANG.manage_response_delete}</option>
								</select></div>
                                <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="button" name="action_button" id="action_button" value="{$LANG.manage_response_submit}" onClick="getMultiCheckBoxValue('responsesForm', 'check_all', '{$LANG.manage_response_err_tip_select_titles}');if(multiCheckValue!='') getAction()"/>						</div></div>

                            </td>
						  </tr>
		  </table>
          				</div>
			  </form>
					{if $CFG.admin.navigation.bottom}
                    	{$myobj->setTemplateFolder('general/')}
						{include file='pagination.tpl'}
					{/if}
				{else}
					<div id="selMsgAlert">
						<p>{$LANG.common_no_records_found}</p>
					</div>
				{/if}
  		 	</div>
	    {/if}
	</div>
    {include file='box.tpl' opt='display_bottom'}
</div>
<script type="text/javascript">
{literal}
	function changeCommentStatus(statusVal)
		{
			document.commentStatusForm.submit();
		}
{/literal}
</script>

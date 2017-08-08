<div id="selManagementProductnews">
	<h2>
    	{$LANG.productnews_title}
    </h2>
    <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="productnews_ids" id="productnews_ids" />
			<input type="hidden" name="action" id="action" />
			{$myobj->populateHidden($myobj->hidden_arr)}
		</form>
	</div>
    <!-- confirmation box-->
	 <!-- information div -->
    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}
    {if $myobj->isShowPageBlock('productnews_form')}
        <form id="form1" name="form1" method="post" action="{$myobj->getCurrentUrl()}">
                    <table class="clsNoBorder">
                        <tr>
                        <td class="widthSmall {$myobj->getCSSFormLabelCellClass('description')}">
                            {$LANG.productnews_description}                </td>
                        <td>
                          {$myobj->getFormFieldErrorTip('description')}
                          {$myobj->populateHtmlEditor('description')}
                         <!--  <textarea name="description" id="description" cols="45" rows="5">{$myobj->getFormField('description')}</textarea>-->
                          {$myobj->ShowHelpTip('productnews_description')}                </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="{$myobj->getCSSFormLabelCellClass('srch_topic_cnt')}">
                                <input  type="hidden" value="{$myobj->getFormField('productnews_id')}" name="productnews_id" id="productnews_id" />
                                <input type="submit" name="productnews_submit" id="productnews_submit" value="{if $myobj->getFormField('productnews_id') == ''}{$LANG.productnews_add}{else}{$LANG.productnews_update}{/if}" />
                               <input type="submit" name="productnews_cancel"  id="productnews_cancel" value="{$LANG.productnews_cancel}" />                         </td>
                        </tr>
              </table>
          </form>
  {/if}
  {if $myobj->isShowPageBlock('productnews_list')}
    {if $CFG.admin.navigation.top}
        {$myobj->setTemplateFolder('admin/')}
        {include file='pagination.tpl'}
    {/if}
      <form name="selFormProductnews" id="selFormProductnews" method="post" action="productNews.php">
        <table>
                <tr>
                    {if $myobj->productnews_list.showProductnewsList.record_count}
                        <td>
                            <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormProductnews.name, document.selFormProductnews.check_all.name)"/>                    </td>
                   {/if}
                   <!-- <td>
                        {$LANG.productnews_id}
                    </td>-->
                    <td>
                        {$LANG.productnews_description}
                    </td>

                    <td>{$LANG.productnews_status}</td>
                    <td>
                        {$LANG.productnews_action}
                    </td>
                </tr>
                {if $myobj->productnews_list.showProductnewsList.record_count}
                    {foreach key=salKey item=salValue from=$myobj->productnews_list.showProductnewsList.row}
                        <tr>
                            <td>
                                <input type="checkbox" class="clsCheckRadio" name="forum_ids[]" value="{$salValue.record.productnews_id}" onClick="disableHeading('selFormProductnews');" tabindex="{smartyTabIndex}" {* $salValue.checkbox_checked *} />                        </td>
                            <!--<td>
                                {$salValue.inc}
                            </td>-->
                            <td>
                                {$salValue.record.description}
                             </td>
                           <td>
                                {if $salValue.record.status == 'Yes'}
                                    {$LANG.productnews_active}
                                 {else}
                                    {$LANG.productnews_inactive}
                                 {/if}
                            </td>
                            <td>
                                <a href="{$salValue.edit_url}"> {$LANG.productnews_edit}</a>
                           </td>
                        </tr>
                      {/foreach}
                        <tr>
                        <td colspan="7">
                            <select name="action" id="action" tabindex="{smartyTabIndex}">
                            <option value="">{$LANG.common_select_action}</option>
                            {$myobj->generalPopulateArray($myobj->productnews_list.action_arr, $myobj->getFormField('action'))}
                            </select>
                            <input type="button" name="action_button" id="action_button" value="{$LANG.productnews_submit}" onClick="getMultiCheckBoxValue('selFormProductnews', 'check_all', '{$LANG.productnews_err_tip_select_titles}');if(multiCheckValue!='') getAction()"/></td>
                        </tr>
                {else}
                    <td colspan="6" align="center">{$LANG.productnews_no_record} &nbsp; <a href="productNews.php?action=add">{$LANG.productnews_add}</a></td>
                {/if}
            </table>
      </form>
    {if $CFG.admin.navigation.bottom}
    {include file='pagination.tpl'}
    {/if}
  {/if}
</div>
</div>

<div id="selManagementAnnouncement">
	<h2>
    	{$LANG.announcement_title}
    </h2>
    	<div id="selMsgSuccess">
        	<p>{$LANG.announcement_note}: {$LANG.announcement_note_msg1}</p>
        </div>
    	<div id="selMsgSuccess">
        	<p>{$LANG.announcement_optimize}: {$LANG.announcement_note_msg2}</p>
        </div>

	 <!-- information div -->
    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}
    {if $myobj->isShowPageBlock('announcement_form')}
    	<form name="form1" id="form1" action="{$myobj->getCurrentUrl(false)}" method="post" onsubmit="return { if $CFG.feature.html_editor eq 'richtext'}getHTMLSource('rte1', 'form1', 'description');{else}true{/if}">
            <table class="clsNoBorder">
                <tr >
                <th class="{$myobj->getCSSFormLabelCellClass('description')}">
                	<label for="description">{$LANG.announcement_description}   </label>
                	{$myobj->displayCompulsoryIcon()}
                </th>
                <td>
              	  {$myobj->getFormFieldErrorTip('description')}
                  {$myobj->ShowHelpTip('announcement_description', 'description')}
					{ if $CFG.feature.html_editor ne 'richtext' && $CFG.feature.html_editor ne 'tinymce'}
						<textarea name="description" id="description" tabindex="{smartyTabIndex}">{$myobj->getFormField('description')}</textarea>
					{/if}
					{$myobj->populateHtmlEditor('description')}
                </td>
                </tr>
                <tr class="{$myobj->getCSSFormLabelCellClass('from_date')}" >
                  <th>
				  	<label for="from_date">{$LANG.announcement_from_date}</label>
                  	{$myobj->displayCompulsoryIcon()}
                  </th>
                  <td>
				  	<input type="text" class="clsTextBox" name="from_date" id="from_date" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('from_date')}" />
				  	{$myobj->populateDateCalendar('from_date', $calendar_opts_arr)}
				  	{$myobj->getFormFieldErrorTip('from_date')}
                  	{$myobj->ShowHelpTip('announcement_from', 'from_date')}
                  </td>
                </tr>
                <tr class="{$myobj->getCSSFormLabelCellClass('description')}" >
                  <th>
				  	<label for="to_date"> {$LANG.announcement_to_date}</label>
					{$myobj->displayCompulsoryIcon()}
                  </th>
                  <td>
				  	<input type="text" class="clsTextBox" name="to_date" id="to_date" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('to_date')}" />
					{$myobj->populateDateCalendar('to_date', $calendar_opts_arr)}
					{$myobj->getFormFieldErrorTip('to_date')}
                  	{$myobj->ShowHelpTip('announcement_to', 'to_date')}
                  </td>
                </tr>
                <tr>
                    <td colspan="2" class="{$myobj->getCSSFormLabelCellClass('srch_topic_cnt')}">
                   		<input  type="hidden" value="{$myobj->getFormField('announcement_id')}" name="announcement_id" id="announcement_id" />
                        <input type="submit" class="clsSubmitButton" name="announcement_submit" id="announcement_submit" value="{if $myobj->getFormField('announcement_id') == ''}{$LANG.announcement_add}{else}{$LANG.announcement_update}{/if}" />
                       <input type="submit" class="clsCancelButton" name="announcement_cancel"  id="announcement_cancel" value="{$LANG.announcement_cancel}" />
                         </td>
                </tr>
            </table>
  </form>
  {/if}
  {if $myobj->isShowPageBlock('announcement_list')}
    {if $CFG.admin.navigation.top}
        {$myobj->setTemplateFolder('admin/')}
        {include file='pagination.tpl'}
    {/if}

    <!-- confirmation box -->
    <div id="selMsgConfirm" style="display:none;">
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.confirm_tbl_summary}">
				<tr>
					<td colspan="2"><p id="confirmMessage"></p></td>
		         </tr>
		         <tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="announcement_ids" id="announcement_ids" />
			<input type="hidden" name="action" id="action" />
			{$myobj->populateHidden($myobj->hidden_arr)}
		</form>
	</div>
    <!-- confirmation box-->
  <form name="selFormAnnouncement" id="selFormAnnouncement" method="post" action="announcement.php">
    <table>
            <tr>
            	{if $myobj->announcement_list.showAnnouncementList.record_count}
                    <th  class="clsSelectAll">
                        <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormAnnouncement.name, document.selFormAnnouncement.check_all.name)"/>                    </th>
               {/if}
               <!-- <td>
                	{$LANG.announcement_id}
                </td>-->
<!--                <th>
                	{$LANG.announcement_description}
                </th>-->
                <th class="">
                	{$LANG.announcement_from_date}
                </th>
                <th class="">
                	{$LANG.announcement_to_date}
                </th>
                <th class="">{$LANG.announcement_status}</th>
                <th class="">
                	{$LANG.announcement_action}
                </th>
            </tr>
            {if $myobj->announcement_list.showAnnouncementList.record_count}
                {foreach key=salKey item=salValue from=$myobj->announcement_list.showAnnouncementList.row}
                    <tr>
                        <td>
                        	<input type="checkbox" class="clsCheckRadio" name="forum_ids[]" value="{$salValue.record.announcement_id}" onClick="disableHeading('selFormAnnouncement');" tabindex="{smartyTabIndex}"/>
                       </td>
<!--            	        <td>
                	   		{$salValue.record.description}
                         </td>-->
	                    <td>
                        	{$salValue.record.from_date|date_format:#format_date_year#}
                        </td>
                    	<td>
                    		{$salValue.record.to_date|date_format:#format_date_year#}
                        </td>
                    	<td>
                        	{if $salValue.record.status == 'Yes'}
                            	{$LANG.announcement_active}
                            {else}
                             	{$LANG.announcement_inactive}
                            {/if}
                        </td>
                    	<td>
                    		<a href="{$salValue.edit_url}">{$LANG.announcement_edit}</a>
                       </td>
                    </tr>
                  {/foreach}
                    <tr>
                    <td colspan="7">
                        <select name="action_val" id="action_val" tabindex="{smartyTabIndex}">
                        <option value="">{$LANG.common_select_action}</option>
                        {$myobj->generalPopulateArray($myobj->announcement_list.action_arr, $myobj->getFormField('action'))}
                        </select>
                    	<input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="{$LANG.announcement_submit}" onClick="getMultiCheckBoxValue('selFormAnnouncement', 'check_all', '{$LANG.announcement_err_tip_select_titles}');if(multiCheckValue!='') getAction()"/></td>
                    </tr>
            {else}
            <tr>
            	<td colspan="6" align="center">{$LANG.announcement_no_record} &nbsp; <a href="announcement.php?action=add">{$LANG.announcement_add}</a></td>
            </tr>
            {/if}
        </table>
  </form>
    {if $CFG.admin.navigation.bottom}
    {include file='pagination.tpl'}
    {/if}
  {/if}
</div>

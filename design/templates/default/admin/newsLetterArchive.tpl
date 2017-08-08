<div id="selnewsletterList">
  	<h2><span>{$LANG.newsletterarchive_title}</span></h2>
  	<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
		<h3 id="confirmMessage"></h3>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.newsletterarchive_confirm_tbl_summary}" class="clsFormSection clsNoBorder">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.newsletterarchive_confirm}" />&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" onClick="return hideAllBlocks();" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="checkbox" id="checkbox" />
			<input type="hidden" name="action" id="action" />
			{$myobj->populateHidden($myobj->hidden_arr, false)}
		</form>
	</div>

{$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}

{if $myobj->isShowPageBlock('form_search')}
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="{$myobj->getCurrentUrl()}">
			<table class="clsNoBorder" summary="{$LANG.newsletterarchive_search_tbl_summary}">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('subject')}"><label for="subject">{$LANG.newsletterarchive_subject}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('subject')}"><input type="text" class="clsTextBox" name="subject" id="subject" value="{$myobj->getFormField('subject')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_date')}"><label for="srch_date">{$LANG.newsletterarchive_search_date_created}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_date')}">{$myobj->getFormFieldErrorTip('srch_date')}
					<input type="text" class="clsTextBox" name="srch_date" id="srch_date" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('srch_date')}" />
					{$myobj->populateDateCalendar('srch_date', $calendar_opts_arr)}
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('status')}"><label for="status">{$LANG.newsletterarchive_status}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('status')}">
					<select name="status" id="status" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.newsletterarchive_select}</option>
						<option value="Inactive" {if $myobj->getFormField('status') == 'Inactive'} SELECTED {/if}>{$LANG.newsletterarchive_status_inactive}</option>
						<option value="Pending" {if $myobj->getFormField('status') == 'Pending'} SELECTED {/if}>{$LANG.newsletterarchive_status_pending}</option>
						<option value="Started" {if $myobj->getFormField('status') == 'Started'} SELECTED {/if}>{$LANG.newsletterarchive_status_started}</option>
						<option value="Finished" {if $myobj->getFormField('status') == 'Finished'} SELECTED {/if}>{$LANG.newsletterarchive_status_finished}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('newsletter_search')}" colspan="2"><input type="submit" class="clsSubmitButton" value="{$LANG.newsletterarchive_search}" id="search" name="search" tabindex="{smartyTabIndex}"/></td>
			</tr>
			</table>

		</form>
	</div>
{/if}
{if $myobj->isShowPageBlock('list_newsletter')}
    <div id="selarchiveList">
	{if $myobj->isResultsFound()}
		   	<form name="archivelist_form" id="archivelist_form" method="post" action="{$myobj->getCurrentUrl(true)}">

            {if $CFG.admin.navigation.top}
                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}

			  	<table summary="{$LANG.newsletterarchive_tbl_summary}">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.archivelist_form.name, document.archivelist_form.check_all.name)"/></th>
						<th>{$LANG.newsletterarchive_subject}</th>
						<th>{$LANG.newsletterarchive_datesent}</th>
                    	<th>{$LANG.newsletterarchive_totalmailsent}</th>
						<th>{$LANG.newsletterarchive_status}</th>
						<th>&nbsp;</th>
					</tr>
					{foreach key=dalKey item=dalValue from=$newsarchiveList_arr.row}
						<tr>
						<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="{$dalValue.record.news_letter_id}" onClick="disableHeading('archivelist_form');"/></td>
						<td>{$dalValue.record.subject}</td>
							<td>{$dalValue.record.date_added|date_format:#format_datetime#}</td>
							<td>{$dalValue.record.total_sent}</td>
							<td>{$dalValue.record.status}</td>
							<td>
								<a href="#" onClick= "popupWindow('newsLettterView.php?news_letter_id={$dalValue.record.news_letter_id}')" class="clsPhotoArticleEditLinks" title="{$LANG.newsletterarchive_view}">{$LANG.newsletterarchive_view}</a><br/>
							</td>
						</tr>
                    {/foreach}
                    	<tr>
                    		<td colspan="6">
                    		<a href="#" id="dAltMlti"></a>
							<select name="newsletter_options" id="newsletter_options" tabindex="{smartyTabIndex}">
								<option value="">{$LANG.newsletterarchive_select}</option>
								<option value="Finished">{$LANG.newsletterarchive_inactivate}</option>
								<option value="Pending">{$LANG.newsletterarchive_activate}</option>
							</select>&nbsp;
							<input type="button" class="clsSubmitButton" name="change_status"
											tabindex="{smartyTabIndex}" value="{$LANG.newsletterarchive_change}"
											onClick="if(getMultiCheckBoxValue('archivelist_form', 'check_all', '{$LANG.newsletterarchive_err_tip_select_record}'))  {literal} { {/literal} getAction() {literal} } {/literal}" />
							</td>
						</tr>
				</table>

            {if $CFG.admin.navigation.bottom}
                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}

			{$myobj->populateHidden($myobj->list_newsletter_form.hidden_arr, false)}

			</form>
	{else}
        <div id="selMsgSuccess"><p class="clsNoRecords">{$LANG.newsletterarchive_no_records_found}</p></div>
	{/if}

    </div>
{/if}

</div>
<div id="selphotoList">
  	<h2><span>{$LANG.photoManage_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.photoManage_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.photoManage_cancel}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="photo_categories" id="photo_categories" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>

{$myobj->setTemplateFolder('admin/')}
{include file='information.tpl'}
<!--{if $myobj->isShowPageBlock('browse_photos')}
      <div id="selActivationConfirm">
        <form name="photo_manage_form1" id="photo_manage_form1" method="post" action="photoManage.php" autocomplete="off">

                        <h3><label for="list">{$LANG.photoManage_list}</label>&nbsp;&nbsp;&nbsp;
                        <select name="list" id="list" tabindex="{smartyTabIndex}">
                            {$myobj->browse_photos.list}
                        </select>
                        <input type="submit" class="clsSubmitButton" name="submit" id="submit" value="{$LANG.photoManage_submit}" tabindex="{smartyTabIndex}" />&nbsp;</h3>

        </form>
      </div>
{/if}
-->{if $myobj->isShowPageBlock('form_search')}
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="{$myobj->getCurrentUrl()}">
			<table class="clsNoBorder clsphotoTable" summary="{$LANG.photoManage_search_tbl_summary}">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('srch_uname')}"><label for="srch_uname">{$LANG.photoManage_search_username}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_uname')}"><input type="text" class="clsTextBox" name="srch_uname" id="srch_uname" value="{$myobj->getFormField('srch_uname')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_title')}"><label for="srch_title">{$LANG.photoManage_search_title}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_title')}">{$myobj->getFormFieldErrorTip('srch_title')}<input type="text" class="clsTextBox" name="srch_title" id="srch_title" value="{$myobj->getFormField('srch_title')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_flag')}"><label for="srch_flag">{$LANG.photoManage_search_flaged}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_flag')}">
					<select name="srch_flag" id="srch_flag" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_flag') == 'Yes'} SELECTED {/if}>{$LANG.photoManage_search_flag_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_flag') == 'No'} SELECTED {/if}>{$LANG.photoManage_search_flag_no}</option>
					</select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_feature')}"><label for="srch_feature">{$LANG.photoManage_search_featured}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_feature')}">
				<select name="srch_feature" id="srch_feature" tabindex="{smartyTabIndex}">
                  <option value="">{$LANG.action_select}</option>
                  <option value="Yes" {if $myobj->getFormField('srch_feature') == 'Yes'} SELECTED {/if}>{$LANG.photoManage_search_feature_yes}</option>
                  <option value="No" {if $myobj->getFormField('srch_feature') == 'No'} SELECTED {/if}>{$LANG.photoManage_search_feature_no}</option>
                </select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_date_added')}"><label for="srch_date">{$LANG.photoManage_search_date_created}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_date_added')}">{$myobj->getFormFieldErrorTip('srch_date_added')}
					<select name="srch_date" id="srch_date" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.photoManage_search_date}</option>
						{$myobj->populateBWNumbers(1, 31, $myobj->getFormField('srch_date'))}
					</select>
					<select name="srch_month" id="srch_month" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.photoManage_search_month}</option>
						{$myobj->populateMonthsList($myobj->getFormField('srch_month'))}
					</select>
					<select name="srch_year" id="srch_year" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.photoManage_search_year}</option>
						{$myobj->populateBWNumbers(1920, $myobj->current_year, $myobj->getFormField('srch_year'))}
					</select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_categories')}"><label for="srch_categories">{$LANG.photoManage_search_categories}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_categories')}">{$myobj->getFormFieldErrorTip('srch_categories')}
					<select name="srch_categories" id="srch_categories" tabindex="{smartyTabIndex}" class="clsSelectLarge">
						<option value="">{$LANG.photoManage_select_categories}</option>
						{$myobj->populatephotoCategory()}
					</select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('photoManage_search')}" colspan="2"><input type="submit" class="clsSubmitButton" value="{$LANG.photoManage_search}" id="search" name="search" tabindex="{smartyTabIndex}"/></td>
			</tr>
			</table>
			{$myobj->populateHidden($myobj->form_search.hidden_arr)}
		</form>
	</div>
{/if}

<table class="clsNoBorder clsPhotoTable" >
<td>
<a href="{$CFG.site.url}admin/photo/photoFeaturedReorder.php" >{$LANG.photoManage_manage_featured_photo_order_link}</a>
</td>
</table>

{if $myobj->isShowPageBlock('list_photo_form')}
    <div id="selphotoList">
	{if $myobj->isResultsFound()}
		   	<form name="photo_manage_form2" id="photo_manage_form2" method="post" action="{$myobj->getCurrentUrl(true)}">

            {if $CFG.admin.navigation.top}
            	{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}
			  	<table summary="{$LANG.photoManage_tbl_summary}">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.photo_manage_form2.name, document.photo_manage_form2.check_all.name)"/></th>
						<th>{$LANG.photomanage_photo_id}</th>
                        <th>{$LANG.photomanage_photo_title}</th>
                        <th>{$LANG.photomanage_photo_image}</th>
						<th>{$LANG.photomanage_photo_category}</th>
                     {if $CFG.admin.photos.sub_category}
                        <th>{$LANG.photomanage_photo_sub_category}</th>
                     {/if}
						<th>{$LANG.photo_user_name}</th>
						<th>{$LANG.photo_date_added}</th>
						<th>{$LANG.photo_option}</th>
						<th>{$LANG.photo_featured}</th>
					</tr>
					{foreach key=dalKey item=dalValue from=$displayphotoList_arr.row}
						<tr>
							<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="{$dalValue.record.photo_id}-{$dalValue.record.user_id}" onClick="disableHeading('photo_manage_form2');"/></td>
                            <td>
                            	{$dalValue.record.photo_id}
                            </td>
							<td>
                            	{$dalValue.record.photo_title}
                            </td>
							<td>
                                
                                {*<a href="javascript:void(0);" onclick="javascript: myLightWindow.activateWindow( {literal} { {/literal} href:'{$dalValue.previewURL}',title:'Photo Preview' {literal} } {/literal} );"><img src="{$dalValue.file_path}" alt="{$dalValue.record.photo_title}"{$dalValue.DISP_IMAGE} /></a>*}
                                 <a id="previewPhoto_{$dalValue.record.photo_id}" href="{$dalValue.previewURL}"  class="lightwindow" title="{$dalValue.record.photo_title}"><img src="{$dalValue.file_path}" alt="{$dalValue.record.photo_title}"{$dalValue.DISP_IMAGE} /></a>
                                
                                
								</td>

							<td>{$myobj->getphotoCategory($dalValue.record.photo_category_id)}</td>
                        {if $CFG.admin.photos.sub_category}
                            <td>{$myobj->getphotoCategory($dalValue.record.photo_sub_category_id)}</td>
                        {/if}
							<td>{$dalValue.name}</td>
							<td>{$dalValue.record.date_added}</td>
							<td>{$dalValue.record.flagged_status}</td>
							<td>{$dalValue.record.featured}</td>
						</tr>
                    {/foreach}
					<tr>
						<td colspan="9">
							<a href="javascript:void(0)" id="dAltMlti"></a>
							<select name="photo_options" id="photo_options" tabindex="{smartyTabIndex}">
								<option value="">{$LANG.action_select}</option>
								<option value="Delete">{$LANG.action_delete}</option>
								<option value="Flag">{$LANG.action_flag}</option>
								<option value="UnFlag">{$LANG.action_unflag}</option>
								<option value="Featured">{$LANG.action_featured}</option>
								<option value="UnFeatured">{$LANG.action_unfeatured}</option>
							</select>&nbsp;
							<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.photoManage_submit}" onClick="if(getMultiCheckBoxValue('photo_manage_form2', 'check_all', '{$LANG.photoManage_err_tip_select_photos}'))  {literal} { {/literal} getAction() {literal} } {/literal}" />
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="javascript:void(0)" id="dAltMlti"></a>
						</td>
					</tr>
				</table>
            {if $CFG.admin.navigation.bottom}
            	{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
            {/if}
			{$myobj->populateHidden($myobj->list_photo_form.hidden_arr)}
			</form>
	{else}
    	<div id="selMsgSuccess">
        	{$LANG.photoManage_no_records_found}
        </div>
	{/if}
    </div>
{/if}
</div>
{* Added code to display fancy box for article comments and preview article *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isResultsFound()}
	{foreach key=dalKey item=dalValue from=$displayphotoList_arr.row}
	{literal}

	$Jq('#previewPhoto_'+{/literal}{$dalValue.record.photo_id}{literal}).fancybox({
		'width'				: 800,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	{/literal}
	{/foreach}
	{/if}
	{literal}
});
{/literal}
</script>
<div id="selvideoList">
  	<h2><span>{$LANG.videoManage_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.videoManage_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.videoManage_cancel}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="video_categories" id="video_categories" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>


{$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}
{if $myobj->isShowPageBlock('browse_videos')}
      <div id="selActivationConfirm">
        <form name="video_manage_form1" id="video_manage_form1" method="post" action="videoManage.php" autocomplete="off">
            
                        <h3><label for="list">{$LANG.videoManage_list}</label>&nbsp;&nbsp;&nbsp;
                        <select name="list" id="list" tabindex="{smartyTabIndex}">
                            {$myobj->browse_videos.list}
                        </select>
                        <input type="submit" class="clsSubmitButton" name="submit" id="submit" value="{$LANG.videoManage_submit}" tabindex="{smartyTabIndex}" />&nbsp;</h3>
               
        </form>
      </div>
{/if}

{if $myobj->isShowPageBlock('form_search')}
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="{$myobj->getCurrentUrl()}">
			<table class="clsNoBorder clsVideoTable" summary="{$LANG.videoManage_search_tbl_summary}">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('srch_uname')}"><label for="srch_uname">{$LANG.videoManage_search_username}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_uname')}"><input type="text" class="clsTextBox" name="srch_uname" id="srch_uname" value="{$myobj->getFormField('srch_uname')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_title')}"><label for="srch_title">{$LANG.videoManage_search_title}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_title')}">{$myobj->getFormFieldErrorTip('srch_title')}<input type="text" class="clsTextBox" name="srch_title" id="srch_title" value="{$myobj->getFormField('srch_title')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_flag')}"><label for="srch_flag">{$LANG.videoManage_search_flaged}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_flag')}">
					<select name="srch_flag" id="srch_flag" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_flag') == 'Yes'} SELECTED {/if}>{$LANG.videoManage_search_flag_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_flag') == 'No'} SELECTED {/if}>{$LANG.videoManage_search_flag_no}</option>
					</select>
				</td>
			</tr>
{* HAVE HIDED FEATURED VIDEOS SEARCH SINCE ADDED FEATURED VIDEOS IN FILTER
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_feature')}"><label for="srch_feature">{$LANG.videoManage_search_featured}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_feature')}">
					<select name="srch_feature" id="srch_feature" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_feature') == 'Yes'} SELECTED {/if}>{$LANG.videoManage_search_feature_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_feature') == 'No'} SELECTED {/if}>{$LANG.videoManage_search_feature_no}</option>
					</select>
				</td>
			</tr>
*}                  
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_date_added')}"><label for="srch_date">{$LANG.videoManage_search_date_created}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_date_added')}">{$myobj->getFormFieldErrorTip('srch_date_added')}
					<select name="srch_date" id="srch_date" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.videoManage_search_date}</option>
						{$myobj->populateBWNumbers(1, 31, $myobj->getFormField('srch_date'))}
					</select>
					<select name="srch_month" id="srch_month" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.videoManage_search_month}</option>
						{$myobj->populateMonthsList($myobj->getFormField('srch_month'))}
					</select>
					<select name="srch_year" id="srch_year" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.videoManage_search_year}</option>                        
						{$myobj->populateBWNumbers(1920, $myobj->current_year, $myobj->getFormField('srch_year'))}
					</select>
                    
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_categories')}"><label for="srch_categories">{$LANG.videoManage_search_categories}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_categories')}">{$myobj->getFormFieldErrorTip('srch_categories')}
					<select name="srch_categories" id="srch_categories" tabindex="{smartyTabIndex}" class="clsSelectLarge">
						<option value="">{$LANG.videoManage_select_categories}</option>
						{$myobj->populateVideoCategory()}
					</select>
				</td>
			</tr>
                <tr>
                    <td class="{$myobj->getCSSFormLabelCellClass('srch_country')}">
                        <label for="srch_country">{$LANG.videoManage_search_country}</label>
                  </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('srch_country')}">
                        <select name="srch_country" id="srch_country" tabindex="{smartyTabIndex}">
                          <option value="0">{$LANG.videoManage_search_sel_country}</option>
                              {$myobj->generalPopulateArray($myobj->LANG_COUNTRY_ARR, $myobj->getFormField('srch_country'))}
                    	</select>
                    </td>
                </tr>
                 <tr>
                   <td class="{$myobj->getCSSFormLabelCellClass('srch_language')}">
                        <label for="srch_language">{$LANG.videoManage_search_language}</label>
                   </td>
                    <td class="{$myobj->getCSSFormFieldCellClass('srch_language')}">
                        <select name="srch_language" id="srch_language" tabindex="{smartyTabIndex}">
                          <option value="0">{$LANG.videoManage_search_sel_language}</option>
                              {$myobj->generalPopulateArray($myobj->LANG_LANGUAGE_ARR, $myobj->getFormField('srch_language'))}
                        </select>
                    </td>
                </tr>                  
			<tr>
                        <td class="{$myobj->getCSSFormFieldCellClass('videoManage_search')}" colspan="2"><input type="submit" class="clsSubmitButton" value="{$LANG.videoManage_search}" id="search" name="search" tabindex="{smartyTabIndex}"/></td>
			</tr>
			</table>
			{$myobj->populateHidden($myobj->form_search.hidden_arr)}
		</form>
	</div>
{/if}

{if $myobj->isShowPageBlock('list_video_form')}
    <div id="selVideoList">

	{if $myobj->isResultsFound()}
		   	<form name="video_manage_form2" id="video_manage_form2" method="post" action="{$myobj->getCurrentUrl(true)}">

            {if $CFG.admin.navigation.top}            	
                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}
            
			  	<table summary="{$LANG.videoManage_tbl_summary}">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.video_manage_form2.name, document.video_manage_form2.check_all.name)"/></th>
						<th>{$LANG.video_video_id}</th>
                        <th>{$LANG.video_video_title}</th>
                        <th>{$LANG.videoManage_video_image}</th>
						<th>{$LANG.video_video_category}</th>
                     {if $CFG.admin.videos.sub_category}
                        <th>{$LANG.video_video_sub_category}</th>
                     {/if}
						<th>{$LANG.video_user_name}</th>
						<th>{$LANG.video_date_added}</th>
						<th>{$LANG.video_option}</th>
						<th>{$LANG.video_featured}</th>
						<th>&nbsp;</th>
					</tr>
					{foreach key=dalKey item=dalValue from=$displayvideoList_arr.row}
						<tr>
							<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="{$dalValue.record.video_id}-{$dalValue.record.user_id}" onClick="disableHeading('video_manage_form2');"/></td>
							<td>
                            	{$dalValue.record.video_id}
                            </td>
                            <td>
                            	{$dalValue.record.video_title}
                            </td>
							<td>
								{*<a href="javascript:void(0)" onClick="popupWindow('videoPreview.php?video_id={$dalValue.record.video_id}')"><img src="{$dalValue.file_path}" alt="{$dalValue.record.video_title}"{$dalValue.DISP_IMAGE} /></a>*}
                                
                                 <a id="viewVideo_{$dalValue.record.video_id}" href="videoPreview.php?video_id={$dalValue.record.video_id}" title="{$dalValue.record.video_title}"><img src="{$dalValue.file_path}" alt="{$dalValue.record.video_title}"{$dalValue.DISP_IMAGE} /></a>
								<!--<a onclick="newTabWindow('{$dalValue.large_img_src}')" title="{$dalValue.record.video_title}" class="lightwindow" params="lightwindow_type=external"><img src="{$dalValue.img_src}" alt="{$dalValue.record.video_title}"/><br />{$dalValue.record.video_title}</a>
								--></td>
							<td>{$myobj->getVideoCategory($dalValue.record.video_category_id)}</td>
                        {if $CFG.admin.videos.sub_category}
                            <td>{$myobj->getVideoCategory($dalValue.record.video_sub_category_id)}</td>
                        {/if}
							<td>{$dalValue.name}</td>
							<td>{$dalValue.record.date_added}</td>
							<td>{$dalValue.record.flagged_status}</td>
							<td>{$dalValue.record.featured}</td>
							<td>
                              	
                                <a id="videoPreview_{$dalValue.record.video_id}" href="{$CFG.site.url}admin/video/manageVideoComments.php?video_id={$dalValue.record.video_id}" title="Manage Video Comments">{$dalValue.comments_text}</a>
                                
                                {*<a href="javascript:void(0)" onclick="popupWindow('{$CFG.site.url}admin/video/manageVideoComments.php?video_id={$dalValue.record.video_id}')" title="Manage Video Comments" >{$dalValue.comments_text}</a>*}
                                
                                
							 {if $dalValue.record.is_external_embed_video == 'No' and $dalValue.record.video_ext != 'flv'}
                              	     <a href="videoReEncode.php?video_id={$dalValue.record.video_id}">{$LANG.re_encode_video}</a>
                                     <a href="{$CFG.site.url}admin/video/reGeneratePlayingTime.php?video_id={$dalValue.record.video_id}">{$LANG.videoManage_regenerate_playing_time}</a>
                                {/if}   
                        	</td>
						</tr>
                    {/foreach}

					<tr>
						<td colspan="9">
							<a href="#" id="dAltMlti"></a>
							<select name="video_options" id="video_options" tabindex="{smartyTabIndex}">
								<option value="">{$LANG.action_select}</option>
								<option value="Delete">{$LANG.action_delete}</option>
								<option value="Flag">{$LANG.action_flag}</option>
								<option value="UnFlag">{$LANG.action_unflag}</option>
								<option value="Featured">{$LANG.action_featured}</option>
								<option value="UnFeatured">{$LANG.action_unfeatured}</option>
							</select>&nbsp;
							<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.videoManage_submit}" onClick="if(getMultiCheckBoxValue('video_manage_form2', 'check_all', '{$LANG.videoManage_err_tip_select_videos}'))  {literal} { {/literal} getAction() {literal} } {/literal}" />
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="#" id="dAltMlti"></a>
                         {* <!-- <select name="video_categories" id="video_categories" tabindex="{smartyTabIndex}" class="clsSelectLarge" >
                            	<option value="">{$LANG.common_select_option}</option>
								{$myobj->generalPopulateArray($myobj->video_category_name, '')}
		  					</select>
							<input type="button" class="clsSubmitButton" name="action_submit" id="action_submit" tabindex="{smartyTabIndex}" value="{$LANG.videocategory_submit}" onClick="if(getMultiCheckBoxValue('video_manage_form2', 'check_all', '{$LANG.videocategory_err_tip_select_category}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('checkbox', 'action', 'video_categories', 'confirmMessage'), Array(multiCheckValue, 'Move', document.video_manage_form2.video_categories.value, '{$LANG.videocategory_confirm_message}'), Array('value', 'value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />
                           --> *} 
						</td>
					</tr>
				</table>            

            {if $CFG.admin.navigation.bottom}
            	
                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}                

			{$myobj->populateHidden($myobj->list_video_form.hidden_arr)}

			</form>
	{else}
    	<div id="selMsgSuccess">
        	{$LANG.videoManage_no_records_found}
        </div>
	{/if}

    </div>
{/if}
</div>

{* Added code to display fancy box for article admin comments and preview article *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isResultsFound()}
	{foreach item=dalValue from=$displayvideoList_arr.row}
	{literal}
	$Jq('#viewVideo_'+{/literal}{$dalValue.record.video_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});


	$Jq('#videoPreview_'+{/literal}{$dalValue.record.video_id}{literal}).fancybox({
		'width'				: 900,
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

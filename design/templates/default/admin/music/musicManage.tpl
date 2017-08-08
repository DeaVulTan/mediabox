<div id="selmusicList">
  	<h2><span>{$LANG.musicManage_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.musicManage_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.musicManage_cancel}"  onclick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="music_categories" id="music_categories" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>
{$myobj->setTemplateFolder('admin')}
{include file='information.tpl'}
<!--{if $myobj->isShowPageBlock('browse_musics')}
      <div id="selActivationConfirm">
        <form name="music_manage_form1" id="music_manage_form1" method="post" action="musicManage.php" autocomplete="off">

                        <h3><label for="list">{$LANG.musicManage_list}</label>&nbsp;&nbsp;&nbsp;
                        <select name="list" id="list" tabindex="{smartyTabIndex}">
                            {$myobj->browse_musics.list}
                        </select>
                        <input type="submit" class="clsSubmitButton" name="submit" id="submit" value="{$LANG.musicManage_submit}" tabindex="{smartyTabIndex}" />&nbsp;</h3>

        </form>
      </div>
{/if}
-->{if $myobj->isShowPageBlock('form_search')}
	<div id="selShowSearchGroup">
		<form name="selFormSearch" id="selFormSearch" method="post" action="{$myobj->getCurrentUrl()}">
			<table class="clsNoBorder clsMusicTable" summary="{$LANG.musicManage_search_tbl_summary}">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('srch_uname')}"><label for="srch_uname">{$LANG.musicManage_search_username}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_uname')}"><input type="text" class="clsTextBox" name="srch_uname" id="srch_uname" value="{$myobj->getFormField('srch_uname')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_title')}"><label for="srch_title">{$LANG.musicManage_search_title}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_title')}">{$myobj->getFormFieldErrorTip('srch_title')}<input type="text" class="clsTextBox" name="srch_title" id="srch_title" value="{$myobj->getFormField('srch_title')}" tabindex="{smartyTabIndex}"/></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_flag')}"><label for="srch_flag">{$LANG.musicManage_search_flaged}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_flag')}">
					<select name="srch_flag" id="srch_flag" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.action_select}</option>
						<option value="Yes" {if $myobj->getFormField('srch_flag') == 'Yes'}selected="selected"{/if}>{$LANG.musicManage_search_flag_yes}</option>
						<option value="No" {if $myobj->getFormField('srch_flag') == 'No'}selected="selected"{/if}>{$LANG.musicManage_search_flag_no}</option>
					</select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_feature')}"><label for="srch_feature">{$LANG.musicManage_search_featured}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_feature')}">
				<select name="srch_feature" id="srch_feature" tabindex="{smartyTabIndex}">
                  <option value="">{$LANG.action_select}</option>
                  <option value="Yes" {if $myobj->getFormField('srch_feature') == 'Yes'}selected="selected"{/if}>{$LANG.musicManage_search_feature_yes}</option>
                  <option value="No" {if $myobj->getFormField('srch_feature') == 'No'}selected="selected"{/if}>{$LANG.musicManage_search_feature_no}</option>
                </select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_date_added')}"><label for="srch_date">{$LANG.musicManage_search_date_created}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_date_added')}">{$myobj->getFormFieldErrorTip('srch_date_added')}
					<select name="srch_date" id="srch_date" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.musicManage_search_date}</option>
						{$myobj->populateBWNumbers(1, 31, $myobj->getFormField('srch_date'))}
					</select>
					<select name="srch_month" id="srch_month" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.musicManage_search_month}</option>
						{$myobj->populateMonthsList($myobj->getFormField('srch_month'))}
					</select>
					<select name="srch_year" id="srch_year" tabindex="{smartyTabIndex}">
						<option value="">{$LANG.musicManage_search_year}</option>
						{$myobj->populateBWNumbers(1920, $myobj->current_year, $myobj->getFormField('srch_year'))}
					</select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srch_categories')}"><label for="srch_categories">{$LANG.musicManage_search_categories}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('srch_categories')}">{$myobj->getFormFieldErrorTip('srch_categories')}
					<select name="srch_categories" id="srch_categories" tabindex="{smartyTabIndex}" class="clsSelectLarge">
						<option value="">{$LANG.musicManage_select_categories}</option>
						{$myobj->populateMusicCategory()}
					</select></td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormFieldCellClass('musicManage_search')}" colspan="2"><input type="submit" class="clsSubmitButton" value="{$LANG.musicManage_search}" id="search" name="search" tabindex="{smartyTabIndex}"/></td>
			</tr>
			</table>
			{$myobj->populateHidden($myobj->form_search.hidden_arr)}
		</form>
	</div>
{/if}
<table class="clsNoBorder clsMusicTable" >
<tr>
	<td>
		<a href="{$CFG.site.url}admin/music/musicFeaturedReorder.php" >{$LANG.musicManage_manage_featured_music_order_link}</a>
	</td>
</tr>
<tr>
	<td>
		<a href="{$CFG.site.url}admin/music/musicLyricsActivate.php" >{$LANG.musicManage_music_lyrics_tobe_activate}</a>
	</td>
</tr>
</table>

{if $myobj->isShowPageBlock('list_music_form')}
    <div id="selMusicList">
	{if $myobj->isResultsFound()}
		   	<form name="music_manage_form2" id="music_manage_form2" method="post" action="{$myobj->getCurrentUrl(true)}">

            {if $CFG.admin.navigation.top}
            	{$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
            {/if}
			  	<table summary="{$LANG.musicManage_tbl_summary}">
					<tr>
						<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.music_manage_form2.name, document.music_manage_form2.check_all.name)"/></th>
						<th>{$LANG.musicmanage_music_id}</th>
                        <th>{$LANG.musicmanage_music_title}</th>
                        <th>{$LANG.musicmanage_music_image}</th>
						<th>{$LANG.musicmanage_music_category}</th>
                     {if $CFG.admin.musics.sub_category}
                        <th>{$LANG.musicmanage_music_sub_category}</th>
                     {/if}
						<th>{$LANG.music_user_name}</th>
                        {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
						<th>{$LANG.music_price}</th>
                        {/if}
						<th>{$LANG.music_date_added}</th>
						<th>{$LANG.music_option}</th>
						<th>{$LANG.music_featured}</th>
						<th>&nbsp;</th>
					</tr>
					{foreach key=dalKey item=dalValue from=$displaymusicList_arr.row}
						<tr>
							<td class="clsSelectAllItems"><input type='checkbox' name='checkbox[]' value="{$dalValue.record.music_id}-{$dalValue.record.user_id}" onclick="disableHeading('music_manage_form2');"/></td>
							<td>
                            	{$dalValue.record.music_id}
                            </td>
                            <td>
                            	{$dalValue.record.music_title}
                            </td>
							<td>
                            
							{*	<a href="javascript:void(0)" onclick="popupWindow('musicPreview.php?music_id={$dalValue.record.music_id}')"><img src="{$dalValue.file_path}" alt="{$dalValue.record.music_title|truncate:16:'...':true}" {$dalValue.DISP_IMAGE} /></a> *}
                                
                                 <a id="viewMusic_{$dalValue.record.music_id}" href="musicPreview.php?music_id={$dalValue.record.music_id}" title="{$dalValue.record.music_title|truncate:16:'...':true}"><img src="{$dalValue.file_path}" alt="{$dalValue.record.music_title|truncate:16:'...':true}" {$dalValue.DISP_IMAGE} /></a>
                                 
								</td>

							<td>{$myobj->getMusicCategory($dalValue.record.music_category_id)}</td>
                        {if $CFG.admin.musics.sub_category}
                            <td>{$myobj->getMusicCategory($dalValue.record.music_sub_category_id)}</td>
                        {/if}
							<td>{$dalValue.name}</td>
                            {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
							<td>{$dalValue.music_price}</td>
                            {/if}
							<td>{$dalValue.record.date_added}</td>
							<td>{$dalValue.record.flagged_status}</td>
							<td>{$dalValue.record.music_featured}</td>
							<td>
                            	<!--<p><a href="{$CFG.site.url}admin/music/musicUploadPopUp.php?music_id={$dalValue.record.music_id}" class="clsMusicMusicEditLinks" title="{$LANG.musiclist_edit_music}">{$LANG.musiclist_edit_music}</a></p>-->
                              	{*
                                <p><a href="javascript:void(0)" onclick="popupWindow('{$CFG.site.url}admin/music/manageMusicComments.php?music_id={$dalValue.record.music_id}')" title="{$LANG.musicManage_musiccomments}" >{$dalValue.comments_text}</a></p>
                                *}
                                
                                
                               <p> <a id="musicComments_{$dalValue.record.music_id}" href="{$CFG.site.url}admin/music/manageMusicComments.php?music_id={$dalValue.record.music_id}" title="{$LANG.musicManage_musiccomments}">{$dalValue.comments_text}</a></p>
                                
							    <!--<p><a href="musicReEncode.php?music_id={$dalValue.record.music_id}">{$LANG.re_encode_music}</a></p>
                                <p><a href="{$CFG.site.url}admin/music/reGeneratePlayingTime.php?music_id={$dalValue.record.music_id}">{$LANG.musicManage_regenerate_playing_time}</a></p>-->
                                <p><a href="{$CFG.site.url}admin/music/manageLyrics.php?music_id={$dalValue.record.music_id}">{$LANG.musicManage_manage_lyrics_label}</a>({$myobj->getTotalLyric($dalValue.record.music_id)})</p>
                                <p> <a href="{$CFG.site.url}admin/music/editMusicDetails.php?music_id={$dalValue.record.music_id}&user_id={$dalValue.record.user_id}">{$LANG.musicManage_edit_music_title}</a></p>

                        	</td>
						</tr>
                    {/foreach}
					<tr>
						<td colspan="9">
							<a href="javascript:void(0)" id="dAltMlti"></a>
							<select name="music_options" id="music_options" tabindex="{smartyTabIndex}">
								<option value="">{$LANG.action_select}</option>
								<option value="Delete">{$LANG.action_delete}</option>
								<option value="Flag">{$LANG.action_flag}</option>
								<option value="UnFlag">{$LANG.action_unflag}</option>
								<option value="Featured">{$LANG.action_featured}</option>
								<option value="UnFeatured">{$LANG.action_unfeatured}</option>
							</select>&nbsp;
							<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.musicManage_submit}" onclick="if(getMultiCheckBoxValue('music_manage_form2', 'check_all', '{$LANG.musicManage_err_tip_select_musics}'))  {literal} { {/literal} getAction() {literal} } {/literal}" />
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="javascript:void(0)" id="dAltMlti"></a>
						</td>
					</tr>
				</table>
            {if $CFG.admin.navigation.bottom}
            	{$myobj->setTemplateFolder('admin')}
                {include file='pagination.tpl'}
            {/if}
			{$myobj->populateHidden($myobj->list_music_form.hidden_arr)}
			</form>
	{else}
    	<div id="selMsgSuccess">
        	{$LANG.musicManage_no_records_found}
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
	{foreach item=dalValue from=$displaymusicList_arr.row}
	{literal}
	$Jq('#viewMusic_'+{/literal}{$dalValue.record.music_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 450,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});


	$Jq('#musicComments_'+{/literal}{$dalValue.record.music_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 700,
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

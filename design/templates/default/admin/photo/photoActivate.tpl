<div id="selphotoList">
  	<h2><span>{$LANG.photoactivate_title}</span></h2>

    <div id="selMsgConfirmDelete" class="selMsgConfirm clsConfirmPopup" style="display:none;">
        <p id="confirmMsg"></p>
            <form name="confirmationForm" id="confirmationForm" method="post" action="{$_SERVER.PHP_SELF}" autocomplete="off">
                            <input type="submit" class="clsSubmitButton" name="submit_button" id="submit_button" value="{$LANG.act_yes}"  tabindex="{smartyTabIndex}" />&nbsp;
                            <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.act_no}"  tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="photo_id" id="photo_id" />

                {$myobj->populateHidden($myobj->hidden)}
            </form>
    </div>

    <!-- information div -->
    {$myobj->setTemplateFolder('admin/')}
    {include file='information.tpl'}
    <!-- preview_block start-->

    {if  $myobj->isShowPageBlock('list_photo_form')}
        <div id="selPhotoList">
        	{if $myobj->isResultsFound()}
                <!-- top pagination start-->
                {if $CFG.admin.navigation.top}
               		{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
                {/if}
                <!-- top pagination end-->
                <form name="photoListForm" id="photoListForm" action="{$_SERVER.PHP_SELF}" method="post">
                    <table summary="{$LANG.photoactivate_tbl_summary}">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio"  name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.photoListForm.name, document.photoListForm.check_all.name)" /></th>
                            <th>{$LANG.photoactivate_photo_title}</th>
                            <th>{$LANG.photoactivate_photo_thumb}</th>
                            <th>{$LANG.photoactivate_user_name}</th>
                            <th>{$LANG.photoactivate_date_added}</th>
                            <th>{$LANG.photoactivate_option}</th>
                        </tr>
                     	{foreach item=disValue from=$myobj->list_photo_form.displayPhotoList.row}
                        <tr class="{$myobj->getCSSRowClass()}">
                            <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="vid[]" id="vid[]" value="{$disValue.record.photo_id}" tabindex="{smartyTabIndex}" /></td>
                            <td>{$disValue.record.photo_title}</td>
                            <td class="clsHomeDispContents"><p id="selImageBorder"><img src="{$disValue.img_src}" alt="{$disValue.record.photo_title}"{$disValue.DISP_IMAGE} /></p></td>
                            <td>{$disValue.record.user_name}</td>
                            <td>{$disValue.record.date_added}</td>
                            <td>
                            	<span id="preview">
	                                <a id="photoPreview_{$disValue.record.photo_id}" href="{$disValue.previewURL}">{$LANG.photoactivate_preview}</a>
                                </span>
							</td>
                             <input type="hidden" name="user_id" id="user_id" />
                        </tr>
                    	{/foreach}
                        <tr>
                            <td colspan="6">
                            <a href="javascript:void(0)" id="{$myobj->list_photo_form.anchor}"></a>
                            <input type="button" class="clsSubmitButton" name="activate_button" id="activate_button" value="{$LANG.photoactivate_activate}" onClick="{$myobj->list_photo_form.onclick_activate}"/>
                            <input type="button" class="clsSubmitButton" name="delete_button" id="delete_button" value="{$LANG.photoactivate_delete}" onClick="{$myobj->list_photo_form.onclick_delete}"/>
                            </td>
                        </tr>
                    </table>
                </form>
                <!-- bottom pagination start-->
                {if $CFG.admin.navigation.bottom}
                	{$myobj->setTemplateFolder('admin/')}
                {include file='pagination.tpl'}
                {/if}
                <!-- bottom pagination end-->
            {else}
                 <div id="selMsgAlert">
           		{$LANG.photoactivate_no_records_found}
                 </div>
            {/if}
        </div>
	{/if}
</div>
{* Added code to display fancy box to preview selected photo *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isShowPageBlock('list_photo_form')}
		{if $myobj->isResultsFound()}
			{foreach item=disValue from=$myobj->list_photo_form.displayPhotoList.row}
				{literal}
				$Jq('#photoPreview_'+{/literal}{$disValue.record.photo_id}{literal}).fancybox({
					'width'				: 900,
					'height'			: 750,
					'padding'			:  0,
					'autoScale'     	: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none'
				});
				{/literal}
			{/foreach}
		{/if}
	{/if}
	{literal}
});
{/literal}
</script>
<div id="searchSetting">
  <h2>{$LANG.searchsettings_title}</h2>
    {$myobj->setTemplateFolder('admin/')}
	{include file="information.tpl"}
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
			<input type="hidden" name="id" id="id" />
			<input type="hidden" name="action" id="action" />
			{$myobj->populateHidden($myobj->hidden_arr)}
		</form>
	</div>
    <!-- confirmation box-->
    {if $myobj->isShowPageBlock('list_search_settings_block')}
    <form name="selFormAnnouncement" id="selFormAnnouncement" method="post" action="announcement.php">
        <table width="200" cellpadding="2" cellspacing="4">
          <tr>
            <th>{$LANG.searchsettings_label}</th>
            <th>{$LANG.searchsettings_moduel}</th>
            <th>{$LANG.searchsettings_priority}</th>
            <th>{$LANG.searchsettings_default_search}</th>
            <th>{$LANG.searchsettings_status}</th>

          </tr>
           {if $myobj->list_search_settings_block.populateSearchSettings.record_count}
              {foreach key=searchKey item=searchValue from=$myobj->list_search_settings_block.populateSearchSettings.row}
                  <tr>
                    <td>{$searchValue.record.label|ucfirst}</td>
                    <td>{$searchValue.record.module|ucfirst}</td>
                    <td>
                        <a href="?action=priority&id={$searchValue.record.id}&priority={$searchValue.record.priority}&opt=up">
                   	 	<img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/admin/images/{$CFG.html.stylesheet.screen.default}/uparrow.gif" title="{$LANG.searchsettings_up}" /></a>&nbsp;&nbsp;&nbsp;
                        <a href="?action=priority&id={$searchValue.record.id}&priority={$searchValue.record.priority}&opt=down">
                        	<img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/admin/images/{$CFG.html.stylesheet.screen.default}/downarrow.gif" title="{$LANG.searchsettings_dowm}"/>                        </a>                   </td>
              <td>
                    	{if $searchValue.record.default_search}
                        	{$LANG.searchsettings_default_yes}
                        {else}
                        	<a href="#" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'confirmMessage'), Array('{$searchValue.record.id}', 'default_search', '{$LANG.searchsettings_default_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290);">{$LANG.searchsettings_default_no}</a>
                        {/if}

                    </td>
                    <td>
                    	{if $searchValue.record.status == 'No'}
                        	<a href="#" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'status', 'confirmMessage'), Array('{$searchValue.record.id}', 'status', 'Yes', '{$LANG.searchsettings_active_confirm_message}'), Array('value', 'value', 'value', 'innerHTML'), -25, -290);">{$LANG.searchsettings_active}</a>
                    	{else}
                        	<a href="#" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('id', 'action', 'status', 'confirmMessage'), Array('{$searchValue.record.id}', 'status', 'No', '{$LANG.searchsettings_inactive_confirm_message}'), Array('value', 'value', 'value', 'innerHTML'), -25, -290);">{$LANG.searchsettings_inactive}</a>
                        {/if}
                    </td>

                  </tr>
              {/foreach}
          {else}
          <tr>
            <td colspan="5">{$LANG.searchsettings_norecords_found}</td>
          </tr>
          {/if}
        </table>
  </form>
  {/if}
</div>
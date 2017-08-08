<h2>{$LANG.menu_management}</h2>
{$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}

{if $myobj->isShowPageBlock('block_menu_manage')}
    <p class="clsPageLink"><a class="clsAdd" href="menuManagement.php?action=add">{$LANG.add_menu}</a></p>
    <p>{$LANG.menumanagement_note}</p>
    <form id="reorder_form" method="post" name="reorder_form">
      	<table class="clsNoBorder">
	      	{*<tr>
	            <td><label>{$LANG.show_channel}</label></td>
	          	<td><input type="radio" name="show_channel" id="show_channel_true" value="true" {if $myobj->getFormField('show_channel')=='true'} checked {/if} /> <label for="show_channel_true">{$LANG.common_yes_option}</label>
	                <input type="radio" name="show_channel" id="show_channel_false" value="false" {if $myobj->getFormField('show_channel')=='false'} checked {/if} /> <label for="show_channel_false">{$LANG.common_no_option}</label> </td>
	      	</tr>
	      	<tr>
	            <td><label>{$LANG.channel_display_type}</label></td>
	          	<td><input type="radio" name="display_channel_in_row" id="display_channel_in_row_true" value="true" {if $myobj->getFormField('display_channel_in_row')=='true'} checked {/if} /><label for="display_channel_in_row_true">{$LANG.common_yes_option}</label>
	          		<input type="radio" name="display_channel_in_row" id="display_channel_in_row_false" value="false" {if $myobj->getFormField('display_channel_in_row')=='false'} checked {/if} /><label for="display_channel_in_row_false">{$LANG.common_no_option}</label>
	          	</td>
	      	</tr>*}
	      	<tr>
	            <td><label for="visible_menu_count">{$LANG.visible_menu_count}</label></td>
	          	<td><input type="text" name="visible_menu_count" id="visible_menu_count" value="{$myobj->getFormField('visible_menu_count')}" /></td>
	      	</tr>
			{*<tr>
	            <td><label for="visible_channel_count">{$LANG.visible_channel_count}</label></td>
	          	<td><input type="text" name="visible_channel_count" id="visible_channel_count" value="{$myobj->getFormField('visible_channel_count')}" /></td>
	      	</tr>*}
      	</table>
      	<h3>{$LANG.reordermenu}</h3>
      	<div class="menuOrderSection">
      		<div class="workarea">
          		<ul class="draglist" id="ul1">
            		{foreach from=$myobj->menu_keys item=menu_id}
                  		<li id="{$menu_id}" class="list1">{$myobj->menu_arr.$menu_id.menu_name|capitalize:true}</li>
            		{/foreach}
            	</ul>
      		</div>
	    </div>
	    <div id="user_actions" style="clear:left;">
		    <input type="submit" class="clsSubmitButton" name="update_order" value="{$LANG.update}" id="showButton" />
	    </div>
	    <input type="hidden" name="left" id="left" />
    </form>
{/if}

{if $myobj->isShowPageBlock('block_add_menu')}
	<!-- Confirmation message block start-->
    <div id="selMsgConfirm" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
            <table summary="">
                <tr><td>
                    <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
                    &nbsp;
                    <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
                </td></tr>
            </table>
	        <input type="hidden" name="action" id="action" />
	        <input type="hidden" name="menu_id" id="menu_id" />
        </form>
    </div>
 	<!-- Confirmation message block end-->
	<form id="add_menu" method="post" name="add_menu" {if $myobj->getFormField('action')!='edit'} action="{$myobj->getCurrentUrl(false)}?action=add {/if}" >
		<input type="hidden" name="increament" value="{* $myobj->inc *}" />
		<table class="clsNoBorder">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('menu_name')}"><label for="menu_name">{$LANG.menu_name}</label>{$myobj->displayCompulsoryIcon()}</td>
			    <td class="{$myobj->getCSSFormFieldCellClass('menu_name')}"><input type="text" class="clsTextBox" name="menu_name" id="menu_name" value="{$myobj->getFormField('menu_name')}"/><br />{$myobj->getFormFieldErrorTip('menu_name')}</td>
			</tr>
            <tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('class_name')}"><label for="class_name">{$LANG.class_name}</label>{$myobj->displayCompulsoryIcon()}</td>
			    <td class="{$myobj->getCSSFormFieldCellClass('class_name')}"><input type="text" class="clsTextBox" name="class_name" id="class_name" value="{if $myobj->getFormField('class_name')}{$myobj->getFormField('class_name')}{else}{$myobj->getFormField('default_class_name')}{/if}"/><br />{$myobj->getFormFieldErrorTip('class_name')}</td>
			</tr>
			<tr>
				<td class="clsWidthSmall"><label for="page_type">{$LANG.menu_page_type}</label></td>
			    <td><select name="page_type" id="page_type" onchange="showElement()">
			    	<option value='normal' {if $myobj->getFormField('page_type')=='normal'} selected {/if}>{$LANG.menu_normal_page}</option>
			        <option value='static' {if $myobj->getFormField('page_type')=='static'} selected {/if}>{$LANG.menu_static_page}</option>
			        <option value='external_link' {if $myobj->getFormField('page_type')=='external_link'} selected {/if}>{$LANG.menu_external_link}</option>
			    </select>
			    <br />{$myobj->getFormFieldErrorTip('page_type')}
			    </td>
			</tr>
			<tr >
				<td id="pg_row_ext_label" {if $myobj->getFormField('page_type')=='normal'} style="display:none" {/if}><label for="menu_page_name_static" id="pg_name">{$LANG.menu_page_name}</label></td>
			    <td id="pg_row_ext" {if $myobj->getFormField('page_type')=='normal'} style="display:none" {/if}> <span id="normalspan" {if $myobj->getFormField('page_type')=='static'} style="display:none" {/if} ><input type="text" class="clsTextBox" name="menu_page_name_normal" id="menu_page_name_normal" value="{$myobj->getFormField('menu_page_name')}" /></span>
			    	<span id="staticspan" {if $myobj->getFormField('page_type')!='static'} style="display:none" {/if} >
			        <select name="menu_page_name_static" id="menu_page_name_static" onchange="getStaticUrl()">
				        <option value="">{$LANG.common_select_option}</option>
				        {$myobj->generalPopulateArray($myobj->staticPage_arr,$myobj->getFormField('menu_page_name'))}
					</select>
			        </span>
			            <br />{$myobj->getFormFieldErrorTip('menu_page_name')}
			        <span id="staticUrl">
			        </span>
			    </td>
			</tr>
			<tr>
				<td class="normal_elemtents" ><label for="menu_normal_query_string">{$LANG.menu_normal_query_string}</label>{$myobj->displayCompulsoryIcon()}</td>
			    <td class="normal_elemtents"><span>{$CFG.site.url}&nbsp;</span><input type="text" class="clsTextBox" name="menu_normal_query_string" id="menu_normal_query_string" value="{$myobj->getFormField('menu_normal_query_string')}"/>
			     <br />{$myobj->getFormFieldErrorTip('menu_normal_query_string')}
			    </td>
			</tr>
			<tr>
				<td class="normal_elemtents"><label for="menu_htaccess_query_string">{$LANG.menu_htaccess_query_string}</label>{$myobj->displayCompulsoryIcon()}</td>
			    <td class="normal_elemtents"><span>{$CFG.site.url}&nbsp;</span><input type="text" class="clsTextBox" name="menu_htaccess_query_string" id="menu_htaccess_query_string" value="{$myobj->getFormField('menu_htaccess_query_string')}"/>
			    <br />{$myobj->getFormFieldErrorTip('menu_htaccess_query_string')}
			    </td>
			</tr>
			<tr>
				<td class="normal_elemtents"><label for="menu_module">{$LANG.menu_module}</label></td>
			    <td class="normal_elemtents">
			    	<select  name="menu_module" id="menu_module" >
				    <option value=""{if !$myobj->getFormField('menu_module')} selected {/if}>General</option>
			        {foreach from=$myobj->module item=module}
			        <option value="{$module}"{if $module==$myobj->getFormField('menu_module')} selected {/if}>{$module|capitalize }</option>
			        {/foreach}
			        </select>
			      </td>
			</tr>
			<tr>
				<td><label for="link_target">{$LANG.menumanagement_link_open_in}</label></td>
			    <td>
			    	<select  name="link_target" id="link_target" >
				    <option value=""{if !$myobj->getFormField('link_target')} selected {/if}>{$LANG.menumanagement_link_open_in_same_window}</option>
			        <option value="_blank" {if $myobj->getFormField('link_target')=='_blank'} selected {/if} >{$LANG.menumanagement_link_open_in_new_window}</option>
			        <option value="popup" {if $myobj->getFormField('link_target')=='popup'} selected {/if}>{$LANG.menumanagement_link_open_in_popup_window}</option>
			        </select>
			      </td>
			</tr>
			<tr>
				<td><label for="menu_display">{$LANG.menu_display}</label></td>
			    <td><input type="checkbox" name="menu_display" id="menu_display" value="Y" {if $myobj->getFormField('menu_display')=='Ok'} checked {/if} /></td>
			</tr>
			<tr>
				<td><label for="member_menu">{$LANG.is_member_menu}</label></td>
			    <td><input type="checkbox" name="member_menu" id="member_menu" value="Yes" {if $myobj->getFormField('member_menu')=='Yes'} checked {/if} /></td>
			</tr>
			<tr>
				<td><label for="hide_member_menu">{$LANG.is_member_hide_menu}</label></td>
			    <td><input type="checkbox" name="hide_member_menu" id="hide_member_menu" value="Yes" {if $myobj->getFormField('hide_member_menu')=='Yes'} checked {/if} /></td>
			</tr>
			<tr>
				<td><label for="is_module_home_page">{$LANG.is_module_home_page}</label></td>
			    <td><input type="checkbox" name="is_module_home_page" id="is_module_home_page" value="Yes" {if $myobj->getFormField('is_module_home_page')=='Yes'} checked {/if} /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="clsSubmitButton" name="menu_add_submit" {if $myobj->getFormField('action')=='edit'}value="{$LANG.update}" {else}value="{$LANG.add}"{/if} /></td>
			</tr>
		</table>
	</form>
	{if $myobj->menuDetail_arr}
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th>{$LANG.menumangement_serial_no}</th>
				<th>{$LANG.menumangement_menu_name}</th>
				<th>{$LANG.menu_page_type}</th>
				<th>{$LANG.menu_url}</th>
				<th>{$LANG.menumangement_module}</th>
				<th>{$LANG.menumangement_action}</th>
			</tr>

			{foreach from=$myobj->menuDetail_arr item=menu key=inc}
				{assign var=inc value=$inc+1}
				<tr>
					<td>{$inc}</td><td>{$menu.menu_name|capitalize}</td>
				    <td>{$menu.page_type}</td><td>
				    {if $menu.file_name_static.normal}
				    	<p>{$LANG.menu_normal_text}: <a href="{$menu.file_name_static.normal}">{$menu.file_name_static.normal}</a></p><br />
				    	<p>{$LANG.menu_seo_text}: <a href="{$menu.file_name_static.seo}">{$menu.file_name_static.seo}</a></p>
				    {else}
					    {if $menu.file_name}
					    	<a href="{$menu.file_name}">{$menu.file_name}</a>
					    {else}
					      	<p>{$LANG.menu_normal_text}: <a href="{$CFG.site.url}{$menu.normal_querystring}">{$CFG.site.url}{$menu.normal_querystring}</a></p><br />
					    	<p>{$LANG.menu_seo_text}: <a href="{$CFG.site.url}{$menu.seo_querystring}">{$CFG.site.url}{$menu.seo_querystring}</a></p>
					    {/if}
				   	{/if}
				    </td><td>{$menu.module|capitalize}</td><td><a href="menuManagement.php?action=edit&menu_id={$menu.id}">{$LANG.menumangement_edit}</a>&nbsp;<a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('menu_id', 'action', 'confirmMessage'), Array('{$menu.id}', 'delete', '{$LANG.menumangement_confirmation_message}'), Array('value', 'value', 'innerHTML'), 0,0);" >{$LANG.menumangement_delete}</a></td>
				</tr>
			{/foreach}

		</table>
	{else}
		<h3>{$LANG.menumanagement_norecords_found}</h3>
	{/if}
{/if}
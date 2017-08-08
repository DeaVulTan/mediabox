{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selCustomizeProfile">
  	<div id="selLeftNavigation">
    <div class="clsPageHeading">
    <h2>
    	{$LANG.profile_theme}&nbsp;
        {if $myobj->isShowPageBlock('form_basic_blocks_handling')}
    		 - {$myobj->block_title}
        {/if}
    </h2>
    </div>
{$myobj->setTemplateFolder('general/')}
 {include file='information.tpl'}
{if $myobj->isShowPageBlock('form_basic_blocks_handling')}
	<form name="selFormEditProfile" id="selFormEditProfile" method="post" action="{$myobj->formAction}" autocomplete="off">
		<div class="clsDataTable">
        <table summary="{$LANG.profile_theme_tbl_summary}" class="clsProfileEditTbl">

			<tr>
				<th colspan="2">{$LANG.entire_block_design}</th>
			</tr>
			<tr>
				<td>{$LANG.background_color}</td>
				<td>
					<input type="color" text="hidden" name="main_bg" id="main_bg" value="{$myobj->form_basic_blocks_handling.main_bg}" class="color" />
				</td>
			</tr>
			<tr>
				<td><label for="main_font">{$LANG.font_style}</label></td>
				<td><select name="main_font" id="main_font" >
                    {if $myobj->form_basic_blocks_handling.main_font_arr!=0}
                        {foreach  key=item item=value from=$myobj->form_basic_blocks_handling.main_font_arr}
                        <option value="{$value.values}" {$value.selected}>{$value.optionvalue}</option>
                        {/foreach}
                     {/if}
                    </select>
                </td>
			</tr>

			<tr>
				<td>{$LANG.font_color}</td>
				<td>
					<input type="color" text="hidden" name="main_color" id="main_color" value="{$myobj->form_basic_blocks_handling.main_color}" class="color" />
				</td>
			</tr>

			<tr>
				<th colspan="2">{$LANG.header_design}</th>
			</tr>
			<tr>
				<td class="clsProfileThemeTD">{$LANG.background}</td>
				<td>
					<input type="color" text="hidden" name="header_bg" id="header_bg" value="{$myobj->form_basic_blocks_handling.header_bg}" class="color" />
				</td>
			</tr>
			<tr>
				<td><label for="header_font">{$LANG.font}</label></td>
				<td><select name="header_font" id="header_font">
               		{if $myobj->form_basic_blocks_handling.header_font_arr!=0}
                        {foreach  key=item item=value from=$myobj->form_basic_blocks_handling.header_font_arr}
                        <option value="{$value.values}" {$value.selected}>{$value.optionvalue}</option>
                        {/foreach}
                     {/if}
                	</select>
                </td>
			</tr>
			<tr>
				<td>{$LANG.font_color}</td>
				<td>
					<input type="color" text="hidden" name="header_color" id="header_color" value="{$myobj->form_basic_blocks_handling.header_color}" class="color" />
				</td>
			</tr>
		   <tr><td></td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
                {$myobj->populateHidden($myobj->form_basic_blocks_handling.hidden_arr)}
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="theme_submit" id="theme_submit" tabindex="{smartyTabIndex}" value="{$LANG.profile_theme_submit}" /></div></div></td>
		   </tr>
		</table>
        </div>
	</form>
{/if}
{if $myobj->isShowPageBlock('form_add_layout')}

	<form name="formAddLayout" id="formAddLayout" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
		<div class="clsDataTable">
        <table summary="{$LANG.profile_theme_tbl_summary}">
			<tr>
				<th>{$LANG.addlayout_toyour_profile}</th>
			</tr>
			<tr>
				<td>{$LANG.layout_code}</td>
			</tr>
			<tr>
				<td><textarea id="layout" name="layout" rows="10" cols="60" tabindex="{smartyTabIndex}">{$myobj->getFormField('layout')}</textarea></td>
			</tr>
		   <tr><td></td>
				<td class="{$myobj->getCSSFormFieldCellClass('submit')}">
				{$myobj->populateHidden($myobj->form_add_layout.hidden_arr)}
				<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="layout_submit" id="layout_submit" tabindex="{smartyTabIndex}" value="{$LANG.profile_theme_layout_submit}" /></div></div></td>
		   </tr>
		</table>
        </div>
	</form>
{/if}
</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
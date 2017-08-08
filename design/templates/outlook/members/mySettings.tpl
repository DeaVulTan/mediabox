<div id="selSignUp">
	<h2>{$LANG.my_settings_title}</h2>
	{include file='../general/information.tpl'}
	{if $myobj->isShowPageBlock('block_form_my_settings')}
		<form name="form_my_settings" id="form_my_settings" method="post" action="{$myobj->getCurrentUrl()}">
			    <!-- clsFormSection - starts here -->
    {include file='../general/box.tpl' opt='form_top'}
    <div class="clsFormSection">

				<div class="clsFormRow">
					 <div class="{$myobj->getCSSFormLabelCellClass('lang')}"><label for="lang1">{$LANG.my_settings_lang}</label></div>
					 <div class="{$myobj->getCSSFormFieldCellClass('lang')}">{$myobj->getFormFieldErrorTip('lang')}
						<select name="lang" id="lang1" tabindex="{smartyTabIndex}">
								{foreach key=key item=value from=$smarty_available_languages}
									<option value="{$key}" {if $key eq $CFG.lang.default}selected="selected"{/if}>{$value}</option>
								{/foreach}
						</select>

				</div>
				{$myobj->ShowHelpTip('lang')}</div>
				 <div class="clsFormRow">
					<div class="{$myobj->getCSSFormLabelCellClass('template')}"><label for="template1">{$LANG.my_settings_template}</label></div>
					<div class="{$myobj->getCSSFormFieldCellClass('template')}">{$myobj->getFormFieldErrorTip('template')}
					{assign var="smarty_default_template" value="`$CFG.html.template.default`__`$CFG.html.stylesheet.screen.default`"}
						<select name="template" id="template1" tabindex="{smartyTabIndex}">
						  {foreach key=template item=css_arr from=$template_arr}
							<optgroup label="{$template}">
								{foreach key=css_key item=css from=$css_arr}
									{assign var="smarty_current_template" value="`$template`__`$css`"}
									 <option value="{$smarty_current_template}" {if $smarty_default_template eq $smarty_current_template}selected="selected"{/if}>{$css}</option>
								{/foreach}
							</optgroup>

						  {/foreach}
						</select>

				  </div>
				  {$myobj->ShowHelpTip('template')}</div>
				   <div class="clsFormRow">
					<div class="{$myobj->getCSSFormLabelCellClass('news_letter')}"><label for="news_letter">{$LANG.my_settings_news_letter}</label></div>
					<div class="{$myobj->getCSSFormFieldCellClass('news_letter')}">{$myobj->getFormFieldErrorTip('news_letter')}
						<input type="radio" class="clsRadioButton" name="news_letter" id="news_letter_y" tabindex="{smartyTabIndex}" value="Yes" {$myobj->isCheckedRadio('news_letter', 'Yes')} />
						<label for="news_letter_y">{$LANG.common_yes_option}</label>
						<input type="radio" class="clsRadioButton" name="news_letter" id="news_letter_n" tabindex="{smartyTabIndex}" value="No" {$myobj->isCheckedRadio('news_letter', 'No')} />
						<label for="news_letter_n">{$LANG.common_no_option}</label>

				  </div>
				  	{$myobj->ShowHelpTip('news_letter','news_letter_n')}</div>
				  <div class="clsFormRow">
					<div class="{$myobj->getCSSFormFieldCellClass('default')}">
						<input type="submit" class="clsSubmitButton" name="change_settings" id="change_settings" tabindex="{smartyTabIndex}" value="{$LANG.my_settings_change_settings}" />
						<input type="submit" class="clsSubmitButton" name="cancel_settings" id="cancel_settings" tabindex="{smartyTabIndex}" value="{$LANG.my_settings_cancel}" />
					</div>
				</div>
			</div>
    {include file='../general/box.tpl' opt='form_bottom'}
    <!-- clsFormSection - ends here -->
		</form>
	{/if}
</div>
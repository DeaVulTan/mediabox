<div id="selVerifyTranslation" class="clsCommonAdminTbl">
    <!--Starting of rounded corners - admin rounded -->
	<div class="clsMainAdminRoundedSection">

     					<h2>{$LANG.page_title}</h2>
                     <div class="clsVerifyTransLateMain">
							{include file='../general/information.tpl'}
                            {if $myobj->isShowPageBlock('block_language_form')}
							<form name="formLanguageVerify" id="formLanguageVerify" method="post" action="{$myobj->getCurrentUrl()}">
		    					<!-- clsFormSection - starts here -->
    							<table class="clsFormTbl">
									<tr class="clsFormRow">
										<td class="{$myobj->getCSSFormLabelCellClass('language_base')}">
											<label for="language_base">{$LANG.verifytranslation_language_base}</label>
										</td>
										<td class="{$myobj->getCSSFormFieldCellClass('language_base')}">
											<select name="language_base" id="language_base" tabindex="{smartyTabIndex}">
                                            	{foreach key=key item=item from=$CFG.lang.available_languages}
													{if $CFG.translated_lang.$key == 'false' }
														continue;
                                                    {/if}
													<option value="{$key}" {if $key == $myobj->getFormField('language_base')} selected="selected" {/if}>{$item}</option>
												{/foreach}
											</select>
											{$myobj->getFormFieldErrorTip('language_base')}
										</td>
									</tr>
									<tr class="clsFormRow">
										<td class="{$myobj->getCSSFormLabelCellClass('language_to_verify')}">
											<label for="language_to_verify">{$LANG.verifytranslation_language_to_verify}</label>
										</td>
										<td class="{$myobj->getCSSFormFieldCellClass('language_to_verify')}">
											<select name="language_to_verify" id="language_to_verify" tabindex="{smartyTabIndex}">
												{foreach key=key item=item from=$CFG.lang.available_languages}
													<option value="{$key}" {if $key == $myobj->getFormField('language_to_verify')} selected="selected" {/if}>{$item}</option>
												{/foreach}
        									</select>
											{$myobj->getFormFieldErrorTip('language_to_verify')}
										</td>
									</tr>
									<tr class="clsFormRow">
										<td class="{$myobj->getCSSFormLabelCellClass('language_category')}">
											<label for="language_category">{$LANG.verifytranslation_language_category}</label>
										</td>
										<td class="{$myobj->getCSSFormFieldCellClass('language_category')}">
											<select name="language_category" id="language_category" tabindex="{smartyTabIndex}">
												<option value="">{$LANG.common_all}</option>
												{$myobj->generalPopulateArray($myobj->block_language_form.getFoldersList, $myobj->getFormField('language_category'))}
											</select>
											{$myobj->getFormFieldErrorTip('language_category')}
										</td>
									</tr>
									<tr class="clsFormRow">
                                    	<td></td>
										<td class="clsButtonAlignment {$myobj->getCSSFormFieldCellClass('default')}" colspan="2">
											<input type="submit" class="clsSubmitButton" name="verify_submit" id="verify_submit" tabindex="{smartyTabIndex}" value="{$LANG.verifytranslation_verify}" />
										</td>
									</tr>
								</table>
    							<!-- clsFormSection - ends here -->
							</form>
						{/if}
						{if $myobj->isShowPageBlock('block_language_list')}

<div class="clsLangChecking">
<ul class="clsClearFix">
	<li class="clsNoErrorCk"><span>&nbsp;</span>{$LANG.verifytranslation_no_error}</li>
	<li class="clsErrorCk"><span>&nbsp;</span>{$LANG.verifytranslation_error}</li>
	<li class="clsFileExCk"><span>&nbsp;</span>{$LANG.verifytranslation_need_to_check_manually}</li>
</ul>
</div>
<table class="clsLangCheckingTa">
	<tr>
		<th>#</th>
		<th>{$LANG.verifytranslation_category}</th>
		<th>{$LANG.verifytranslation_path}</th>
		<th>{$LANG.verifytranslation_file_status}</th>
		<th>{$LANG.verifytranslation_language_status}</th>
		<th>&nbsp;</th>
	</tr>
	{foreach key=vlkey item=vlval from=$myobj->block_language_list.verifyLanguage}
	<tr class="{$vlval.class_row}">
		<td>{$vlval.inc}</td>
		<td>{$vlval.folder_path}</td>
		<td>{$vlval.file_path}</td>
		<td>{$vlval.file_status}</td>
		<td>{$vlval.display_var_text}</td>
		<td>
			<span id="selMsgBlock_{$vlkey}">
				<a href="#" onClick="{$vlval.onclick}">{$LANG.verifytranslation_translate_again}</a>
			</span>
		</td>
	</tr>
	{/foreach}
</table>
{/if}
	   				</div>
	             </div>
	<!--end of rounded corners - admin rounded -->
</div>
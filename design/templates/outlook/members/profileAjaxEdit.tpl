{if $myobj->isShowPageBlock('show_info_option')}
 	{if $infodetails.question_type == 'text'}
		<input type="text" class="clsTextBox" name="{$infodetails.id}" id="{$infodetails.question}" tabindex="{smartyTabIndex}" value="{$infodetails.answer_result}" maxlength="{$infodetails.max_length}" style="{$infodetails.width}"  onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');"/>
		<div class="clsHelpText" id="{$infodetails.id}_Help" style="visibility:hidden">{$infodetails.instruction}</div>
		<script> $Jq("#{$infodetails.id}").focus() </script>
	{elseif $infodetails.question_type == 'textarea'}
		<textarea name="{$infodetails.id}" id="{$infodetails.id}" tabindex="{smartyTabIndex}" rows="{$infodetails.rows}" style="{$infodetails.width}"  maxlength="50" onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');">{$infodetails.answer_result}</textarea>
		<div class="clsHelpText" id="{$infodetails.id}_Help" style="visibility:hidden">{$infodetails.instruction}</div>
		<script> $Jq("#{$infodetails.id}").focus() </script>
	{elseif $infodetails.question_type == 'password'}
        <input type="password" class="clsTextBox" name="{$infodetails.id}" id="{$infodetails.question}" tabindex="{smartyTabIndex}" value="{$infodetails.answer_result}" maxlength="{$infodetails.max_length}" onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');"/>
        <div class="clsHelpText" id="{$infodetails.id}_Help" style="visibility:hidden">{$infodetails.instruction}</div>
        <script> $Jq("#{$infodetails.id}").focus() </script>
    {elseif $infodetails.question_type == 'radio'}
        {foreach key=ssokey item=ssovalue from=$infodetails.option_arr}
        	<p><span class="clsCheckBox"><input type="radio" class="clsCheckRadio" id="opt_{$infodetails.id}_{$ssokey}" name="{$infodetails.id}"  {$infodetails.$ssovalue} value="{$ssovalue}"  tabindex="{smartyTabIndex}" onclick="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');"onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');" onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');" /></span><label for="opt_{$infodetails.id}_{$ssokey}">{$ssovalue}{$infodetails.display}</label></p>
        	{if $infodetails.$ssovalue}
        		<script> $Jq("#opt_{$infodetails.id}_{$ssokey}").focus() </script>
        	{/if}
        {/foreach}
        <div class="clsHelpText" id="opt_{$infodetails.id}_Help" style="visibility:hidden">{$infodetails.instruction}</div>
	{elseif $infodetails.question_type == 'checkbox'}
		{assign var="focused" value=""}
        {foreach key=ssokey item=ssovalue from=$infodetails.option_arr}
            <p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio" id="opt_{$infodetails.id}_{$ssokey}" name="{$infodetails.id}[]"  {$infodetails.checked.$ssokey} value="{$ssovalue}"  tabindex="{smartyTabIndex}" onclick="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');" onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');" /></span><label for="opt_{$infodetails.id}_{$ssokey}">{$ssovalue}{$infodetails.display}</label></p>
        	{if $infodetails.checked.$ssokey AND $focused eq ''}
        		<script> $Jq("#opt_{$infodetails.id}_{$ssokey}").focus() </script>
        		{assign var="focused" value="true"}
        	{/if}
        {/foreach}
        <div class="clsHelpText" id="opt_{$infodetails.id}_Help" style="visibility:hidden">{$infodetails.instruction}</div>
	{elseif $infodetails.question_type == 'select'}
        <select name="{$infodetails.id}" id="{$infodetails.id}" tabindex="{smartyTabIndex}" onchange="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');" onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this, '{$myobj->getFormField('infoid')}');">
           <option value="">{$LANG.common_select_option}</option>
          {$myobj->generalPopulateArray($infodetails.option_arr, $infodetails.answer_result)}
        </select>
        <div class="clsHelpText" id="{$infodetails.id}_Help" style="visibility:hidden">{$infodetails.instruction}</div>
        <script> $Jq("#{$infodetails.id}").focus() </script>
	{/if}
{elseif $myobj->isShowPageBlock('show_info_details')}
	{$myobj->getFormField('infovalue')}
{elseif $myobj->isShowPageBlock('show_aboutme_option')}
	<textarea name="about_me" id="about_me" rows="10" cols="50" tabindex="{smartyTabIndex}" onblur="openAjaxWindow('true', 'ajaxupdate', 'updateProfileData', '{$myobj->getFormField('linkId')}', '{$myobj->getFormField('infotype')}', this);">{$myobj->getFormField('infovalue')}</textarea>
    {$myobj->ShowHelpTip('about_me')}
    <script> $Jq("#about_me").focus() </script>
{elseif $myobj->isShowPageBlock('show_aboutme_details')}
	{$myobj->getFormField('infovalue')}
{/if}
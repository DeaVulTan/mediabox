{ if $myobj->isShowPageBlock('block_userList')}
<div id="selMsgConfirmWindow" class="clsPopupAlert" style="display:none;">
  <h3 id="confirmation_msg"></h3>
  <form name="msgConfirmForm" id="msgConfirmForm" method="post" action="{$myobj->getCurrentUrl()}">
    <input type="submit" class="clsSubmitButton" name="confirm_act" id="confirm_act" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
    &nbsp;
    <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
    {$myobj->populateHidden($myobj->msgConfirmForm_hidden_arr)}
  </form>
</div>
{/if}
<div id="selUserProfiles">
  <h2><span>{$LANG.userprofile_page_title}</span></h2>
  {include file='../general/information.tpl'}
  <h3><span>{$LANG.userprofile_search_title}</span></h3>
  { if $myobj->isShowPageBlock('block_userSearch')}
	<form name="userSearchForm" id="userSearchForm" method="post" action="{$myobj->getCurrentUrl()}">
        <!-- clsFormSection - starts here -->
    {include file='box.tpl' opt='form_top'}
    <div class="clsFormSection">
		<div class="clsFormRow">
			<div class="{$myobj->getCSSFormLabelCellClass('user_name')}"><label for="user_name">{$LANG.userprofile_profile_user_name}</label></div>
			<div class="{$myobj->getCSSFormFieldCellClass('user_name')}">{$myobj->getFormFieldErrorTip('user_name')}<input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" /></div>
		   	{$myobj->ShowHelpTip('username', 'user_name')}
		</div>
		<div class="clsFormRow">
			<div class="{$myobj->getCSSFormLabelCellClass('email')}"><label for="email">{$LANG.userprofile_profile_email}</label></div>
			<div class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}<input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" /></div>
		    {$myobj->ShowHelpTip('email')}
		</div>
		<div class="clsFormRow">
			<div class="{$myobj->getCSSFormLabelCellClass('gender')}"><label for="gender_m">{$LANG.userprofile_profile_gender}</label></div>
			<div class="{$myobj->getCSSFormFieldCellClass('gender')}">{$myobj->getFormFieldErrorTip('gender')}
				<input type="radio" class="clsRadioButton" name="gender" id="gender_opt_b" tabindex="{smartyTabIndex}" value="" {$myobj->isCheckedRadio('gender', '')} /><label for="gender_opt_b">{$LANG.userprofile_both}</label>
				<input type="radio" class="clsRadioButton" name="gender" id="gender_opt_m" tabindex="{smartyTabIndex}" value="m" {$myobj->isCheckedRadio('gender', 'm')} /><label for="gender_opt_m">{$LANG.common_male_option}</label>
				<input type="radio" class="clsRadioButton" name="gender" id="gender_opt_f" tabindex="{smartyTabIndex}" value="f" {$myobj->isCheckedRadio('gender', 'f')} /><label for="gender_opt_f">{$LANG.common_female_option}</label>
			</div>
	    	{$myobj->ShowHelpTip('gender')}
		</div>
		<div class="clsFormRow">
			<div class="{$myobj->getCSSFormFieldCellClass('default')}">
				<input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="{smartyTabIndex}" value="{$LANG.userprofile_search_submit}" />
			</div>
		</div>
    </div>
    {include file='box.tpl' opt='form_bottom'}
    <!-- clsFormSection - ends here -->
	</form>
  {/if}
  { if $myobj->isShowPageBlock('block_userList')}
  <form name="userListForm" id="userListForm" method="post" action="{$myobj->getCurrentUrl()}">
    {if $CFG.admin.navigation.top}
    {include file='../general/pagination.tpl'}
    {/if}
        <!-- clsDataDisplaySection - starts here -->
	{include file='box.tpl' opt='data_top'}
    <div class="clsDataDisplaySection">

      <div class="clsDataHeadSection">
        <div class="clsDataHead"><ul>
          <li class="clsUserNameColumn {$myobj->getOrderCss('user_name')}"><a href="#" onclick="return changeOrderbyElements('userListForm','user_name')">{$LANG.userprofile_th_user_name}</a> </li>
          <li class="clsEmailColumn{$myobj->getOrderCss('email')}"><a href="#" onclick="return changeOrderbyElements('userListForm','email')">{$LANG.userprofile_th_email}</a> </li>
          <li>{$LANG.userprofile_th_name}</li>
		  <li>&nbsp;</li>
        </ul></div>
      </div>
      <div class="clsDataContentSection">
	  {foreach key=inc item=value from=$populateUserProfiles_arr}
        <div class="clsDataRow {$myobj->getCSSRowClass()}">
          <ul>
            <li class="clsUserNameColumn"><a href="{$populateUserProfiles_arr.$inc.profile_url}">{$myobj->getTableData($populateUserProfiles_arr.$inc.user_name)}</a></li>
            <li class="clsEmailColumn">{$myobj->getTableData($populateUserProfiles_arr.$inc.email)}</li>
            <li>{$myobj->getTableData($populateUserProfiles_arr.$inc.name)}</li>
            <li class="clsManageColumn">
	    {if $myobj->chkAllowedModule(array('mail'))}
		<ul>
			<li><a href="{$populateUserProfiles_arr.$inc.send_mail_link}">{$LANG.userprofile_send_mail}</a></li>
		</ul>
	     {else}
	     &nbsp;
	    {/if}
		</li>
          </ul>
        </div>
        {/foreach}
        </div>
      </div>
	{include file='box.tpl' opt='data_bottom'}
        <!-- clsDataDisplaySection - ends here -->
    {if $CFG.admin.navigation.bottom}
    {include file='../general/pagination.tpl'}
    {/if}
    {$myobj->populateHidden($myobj->userListForm_hidden_arr)}
  </form>
  {/if} </div>

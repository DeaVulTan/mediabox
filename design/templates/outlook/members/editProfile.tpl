<div id="selEditProfile">
  <h2>{$LANG.editprofile_title}</h2>
  {include file='../general/information.tpl'}
  { if $myobj->isShowPageBlock('block_form_editprofile')}
  <form name="form_editprofile" id="form_editprofile" method="post" enctype="multipart/form-data" action="{$myobj->getCurrentUrl()}">
        <!-- clsFormSection - starts here -->
    {include file='../general/box.tpl' opt='form_top'}
    <div class="clsFormSection">

      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('first_name')}">
          <label for="first_name">{$LANG.editprofile_first_name}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('first_name')}">{$myobj->getFormFieldErrorTip('first_name')}
          <input type="text" class="clsTextBox" name="first_name" id="first_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('first_name')}" />
        </div>
        {$myobj->ShowHelpTip('firstname', 'first_name')}</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('last_name')}">
          <label for="last_name">{$LANG.editprofile_last_name}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('last_name')}">{$myobj->getFormFieldErrorTip('last_name')}
          <input type="text" class="clsTextBox" name="last_name" id="last_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('last_name')}" />
        </div>
        {$myobj->ShowHelpTip('lastname', 'last_name')}</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('dob')}">
          <label for="dob">{$LANG.editprofile_dob}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('dob')}">{$myobj->getFormFieldErrorTip('dob')}
          <input type="text" class="clsTextBox" name="dob" id="dob" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('dob')}" readonly />
          <button class="clsSubmitButton" type="reset" id="f_trigger_b">...</button>
          {$myobj->populateCalendar('dob', 'f_trigger_b')} </div>
        {$myobj->ShowHelpTip('dob')}</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('gender')}">
          <label for="gender_m">{$LANG.editprofile_gender}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('gender')}">{$myobj->getFormFieldErrorTip('gender')}
          <input type="radio" class="clsRadioButton" name="gender" id="gender_opt_m" tabindex="{smartyTabIndex}" value="m" {$myobj->isCheckedRadio('gender', 'm')} />
          <label for="gender_opt_m">{$LANG.common_male_option}</label>
          <input type="radio" class="clsRadioButton" name="gender" id="gender_opt_f" tabindex="{smartyTabIndex}" value="f" {$myobj->isCheckedRadio('gender', 'f')} />
          <label for="gender_opt_f">{$LANG.common_female_option}</label>
        </div>
        {$myobj->ShowHelpTip('gender')}</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('email')}">
          <label for="email">{$LANG.editprofile_email}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('email')}">{$myobj->getFormFieldErrorTip('email')}
          <input type="text" class="clsTextBox" name="email" id="email" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('email')}" />
        </div>
        {$myobj->ShowHelpTip('email')}</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('phone')}">
          <label for="phone">{$LANG.editprofile_phone}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('phone')}">{$myobj->getFormFieldErrorTip('phone')}
          <input type="text" class="clsTextBox" name="phone" id="phone" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('phone')}" />
        </div>
        {$myobj->ShowHelpTip('phone')} </div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('fax')}">
          <label for="fax">{$LANG.editprofile_fax}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('fax')}">{$myobj->getFormFieldErrorTip('fax')}
          <input type="text" class="clsTextBox" name="fax" id="fax" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('fax')}" />
        </div>
        {$myobj->ShowHelpTip('fax')} </div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('address')}">
          <label for="address">{$LANG.editprofile_address}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('address')}">{$myobj->getFormFieldErrorTip('address')}
          <input type="text" class="clsTextBox" name="address" id="address" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('address')}" />
        </div>
        {$myobj->ShowHelpTip('address')} </div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('city')}">
          <label for="city">{$LANG.editprofile_city}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('city')}">{$myobj->getFormFieldErrorTip('city')}
          <input type="text" class="clsTextBox" name="city" id="city" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('city')}" />
        </div>
        {$myobj->ShowHelpTip('city')}</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('state')}">
          <label for="state">{$LANG.editprofile_state}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('state')}">{$myobj->getFormFieldErrorTip('state')}
          <input type="text" class="clsTextBox" name="state" id="state" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('state')}" />
        </div>
        {$myobj->ShowHelpTip('state')}</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormLabelCellClass('country')}">
          <label for="country">{$LANG.editprofile_country}</label>
        </div>
        <div class="{$myobj->getCSSFormFieldCellClass('country')}">{$myobj->getFormFieldErrorTip('country')}
          <select name="country" id="country" tabindex="{smartyTabIndex}">

						{$myobj->generalPopulateArray($smarty_country_list, $myobj->getFormField('country'))}

          </select>
        </div>
        {$myobj->ShowHelpTip('country')}</div>
		<div class="clsFormRow">
				<div class="{$myobj->getCSSFormLabelCellClass('user_photo')}"><label for="user_photo">{$LANG.editprofile_upload_img}</label></div>

				<div class="{$myobj->getCSSFormFieldCellClass('user_photo')}">
					{$myobj->getFormFieldErrorTip('user_photo')}
					<img src="{$myobj->block_form_editprofile.img_src}" alt="{$myobj->block_form_editprofile.user_details.user_name}"{$myobj->block_form_editprofile.img_size} />
					<input type="file" name="user_photo" id="user_photo" />
				</div>
		  		{$myobj->ShowHelpTip('user_photo', 'user_photo')}
		</div>
      <div class="clsFormRow">
        <div class="{$myobj->getCSSFormFieldCellClass('default')}">
          <input type="submit" class="clsSubmitButton" name="editprofile_submit" id="editprofile_submit" tabindex="{smartyTabIndex}" value="{$LANG.editprofile_submit}" />
		  <input type="submit" class="clsSubmitButton" name="editprofile_cancel" id="editprofile_cancel" tabindex="{smartyTabIndex}" value="{$LANG.editprofile_cancel}" />
        </div>
      </div>
    </div>
     {include file='../general/box.tpl' opt='form_bottom'}
    <!-- clsFormSection - ends here -->
 </form>
  {/if}
  </div>

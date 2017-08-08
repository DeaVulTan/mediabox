<?php /* Smarty version 2.6.18, created on 2011-12-23 01:54:29
         compiled from profileBasic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileBasic.tpl', 16, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selEditPersonalProfile">
<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['personal_title_basic']; ?>
</h2></div>
	<div id="selLeftNavigation">
 		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

 		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_editprofile')): ?>
			<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            	<p class="ClsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
				<div class="clsDataTable">
		        <table summary="<?php echo $this->_tpl_vars['LANG']['personal_profile_tbl_summary']; ?>
" class="clsProfileEditTbl">
					<tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('email'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('email'); ?>
<label for="email"><?php echo $this->_tpl_vars['LANG']['personal_profile_email']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('email'); ?>
">
							<input type="text" class="clsTextBox" name="email" id="email" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" />
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('email'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('update_email','email'); ?>

						</td>
				   </tr>
				   <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('first_name'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('first_name'); ?>
<label for="first_name"><?php echo $this->_tpl_vars['LANG']['personal_profile_first_name']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('first_name'); ?>
">
							<input type="text" class="clsTextBox" name="first_name" id="first_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('first_name'); ?>
" />
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('first_name'); ?>

							<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('first_name'); ?>

						</td>
				   </tr>
				   <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('last_name'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('last_name'); ?>
<label for="last_name"><?php echo $this->_tpl_vars['LANG']['personal_profile_last_name']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('last_name'); ?>
">
							<input type="text" class="clsTextBox" name="last_name" id="last_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('last_name'); ?>
" />
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('last_name'); ?>

							<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('last_name'); ?>

						</td>
				   </tr>
				    <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('sex'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('sex'); ?>
<label for="sex"><?php echo $this->_tpl_vars['LANG']['personal_profile_sex']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('sex'); ?>
">
							<select name="sex" id="sex" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
		                		<?php $_from = $this->_tpl_vars['myobj']->populateGender; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['svalue']):
?>
		                			<option value="<?php echo $this->_tpl_vars['svalue']['values']; ?>
" <?php echo $this->_tpl_vars['svalue']['selected']; ?>
><?php echo $this->_tpl_vars['svalue']['optionvalue']; ?>
&nbsp;</option>
		                		<?php endforeach; endif; unset($_from); ?>
		                	</select>
		                	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('sex'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('sex'); ?>
</td>
				    </tr>
				    <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('dob'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('dob'); ?>
<label for="dob"><?php echo $this->_tpl_vars['LANG']['personal_profile_dob']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('dob'); ?>
">
                        	<input type="text" class="ClsTextBox" name="dob" id="dob" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('dob'); ?>
" />
                        	<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('dob',$this->_tpl_vars['dob_calendar_opts_arr']); ?>
<br/>
                        	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('dob',true); ?>

                        	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('dob'); ?>

                        	<p><input name="show_dob_check" id="show_dob_check" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" type="checkbox" class="clsCheckRadio" value="1" <?php echo $this->_tpl_vars['myobj']->dobChecked; ?>
 onClick="chekc_show_dob()"/>&nbsp;<label for="show_dob_check"><?php echo $this->_tpl_vars['LANG']['personal_profile_show_dob']; ?>
</label></p>
		                    <input name="show_dob" id="show_dob" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" type="hidden" class="clsCheckRadio" value="<?php echo $this->_tpl_vars['myobj']->show_dob_value; ?>
" />
                    	</td>
				    </tr>
				    <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('relation_status'); ?>
"><label for="relation_status"><?php echo $this->_tpl_vars['LANG']['personal_profile_relation_status']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('relation_status'); ?>
">
							<select name="relation_status" id="relation_status" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
								<?php $_from = $this->_tpl_vars['myobj']->populateUserRelation; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['rvalue']):
?>
		                		<option value="<?php echo $this->_tpl_vars['rvalue']['values']; ?>
" <?php echo $this->_tpl_vars['rvalue']['selected']; ?>
><?php echo $this->_tpl_vars['rvalue']['optionvalue']; ?>
&nbsp;</option>
		                        <?php endforeach; endif; unset($_from); ?>
							</select>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('relation_status'); ?>

		                    <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('relation_status'); ?>

						</td>
				    </tr>
				   <tr>
				   	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('about_me'); ?>
"><label for="about_me"><?php echo $this->_tpl_vars['LANG']['personal_profile_about_me']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('about_me'); ?>
">
							<textarea name="about_me" id="about_me" rows="10" cols="50" class="selInputLimiter" maxlimit="<?php echo $this->_tpl_vars['CFG']['fieldsize']['aboutme']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" ><?php echo $this->_tpl_vars['myobj']->getFormField('about_me'); ?>
</textarea>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('about_me'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('about_me'); ?>

		                </td>
				   </tr>
				   <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('web_url'); ?>
"><label for="web_url"><?php echo $this->_tpl_vars['LANG']['personal_profile_web_url']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('web_url'); ?>
">
							<input type="text" class="clsTextBox" name="web_url" id="web_url" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('web_url'); ?>
" />
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('web_url'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('web_url'); ?>

		                </td>
				   </tr>
				   <tr>
				   		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('profile_tags'); ?>
"><label for="profile_tags"><?php echo $this->_tpl_vars['LANG']['personal_profile_tags']; ?>
</label></td>
                		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('profile_tags'); ?>
 clsInputDetails">
							<p><input type="text" class="clsTextBox" name="profile_tags" id="profile_tags" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('profile_tags'); ?>
" /></p>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('profile_tags'); ?>

							<p><span><?php echo $this->_tpl_vars['LANG']['personal_profile_tags_info_1']; ?>
</span></p>
							<p><span><?php echo $this->_tpl_vars['myobj']->profile_tag_length_info; ?>
</span></p>
                    		<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('profile_tags'); ?>

						</td>
		   		   </tr>
				   <tr>
				   		<th colspan="2"><h3><?php echo $this->_tpl_vars['LANG']['personal_profile_location_mode']; ?>
</h3></th>
				   </tr>
				   <tr>
				   		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('hometown'); ?>
"><label for="hometown"><?php echo $this->_tpl_vars['LANG']['personal_profile_hometown']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('hometown'); ?>
">
							<input type="text" class="clsTextBox" name="hometown" id="hometown" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('hometown'); ?>
"  maxlength="100"/>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('hometown'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('hometown'); ?>

		                </td>
				   </tr>
				   <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('city'); ?>
"><label for="city"><?php echo $this->_tpl_vars['LANG']['personal_profile_city']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('city'); ?>
">
							<input type="text" class="clsTextBox" name="city" id="city" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('city'); ?>
" maxlength="50"/>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('city'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('city'); ?>

		                </td>
				   </tr>
				   <tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('postal_code'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('postal_code'); ?>
<label for="postal_code"><?php echo $this->_tpl_vars['LANG']['personal_profile_postal_code']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('postal_code'); ?>
">
							<input type="text" class="clsTextBox" name="postal_code" id="postal_code" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('postal_code'); ?>
" maxlength="9"/>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('postal_code'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('postal_code'); ?>

		                </td>
				   </tr>
				   <tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('country'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayMandatoryIcon('country'); ?>
<label for="country"><?php echo $this->_tpl_vars['LANG']['personal_profile_country']; ?>
</label></td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('country'); ?>
">
							<select name="country" id="country" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->populateCountriesList($this->_tpl_vars['myobj']->getFormField('country')); ?>
</select>
							<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('country'); ?>

		                	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('country'); ?>

		                </td>
				   </tr>
				   <tr>
				   		<td>&nbsp;</td>
		                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
"><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="editprofile_submit" id="editprofile_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['personal_profile_submit']; ?>
" /></div></div></td>
					</tr>
				</table>
		    	</div>
			</form>
		<?php endif; ?>	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
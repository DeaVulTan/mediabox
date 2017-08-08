<?php /* Smarty version 2.6.18, created on 2013-06-13 11:40:10
         compiled from addNewsLetter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'addNewsLetter.tpl', 12, false),array('modifier', 'stripslashes', 'addNewsLetter.tpl', 119, false),)), $this); ?>
<div id="selAddNewsLetter">
	<h2 class="clsNewsLetterTitle"><?php echo $this->_tpl_vars['LANG']['addletter_title']; ?>
</h2>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<!-- confirmation box -->
    <div id="selMsgConfirm" style="display:none;">
    	<h3 id="confirmMessage"></h3>
    	<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
    		<table class="clsFormSection clsNoBorder">
				<tr>
					<td>
						<input type="button" class="clsSubmitButton" name="submit_confirm" id="submit_confirm" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['addletter_yes']; ?>
" onclick="submitform();" />&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['addletter_no']; ?>
" onClick="return hideAllBlocks();" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="action" id="action" />
		<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['form_search_ad_hidden_arr']); ?>

    	</form>
	</div>
	<!-- confirmation box -->

	<?php if (( ! $this->_tpl_vars['myobj']->isShowPageBlock('block_form_confirm') ) && ( $this->_tpl_vars['myobj']->isShowPageBlock('block_form_add_letter') )): ?>
	<form name="form_editBuySelltype" id="form_editBuySelltype" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
    	<table class="clsFormSection clsNoBorder">
		<tr>
			<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
">
				<p>
                <strong>
                <?php echo $this->_tpl_vars['LANG']['addletter_special_code_title']; ?>

                </strong>
				</p>
				<?php echo '
					<span>VAR_EMAIL</span>
					<span>VAR_USERNAME</span>
				'; ?>

				</ul>
			</td>
		</tr>
	    <tr class="clsFormRow">
	        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('uname'); ?>
"><label for="uname"><?php echo $this->_tpl_vars['LANG']['common_username']; ?>
</label></td>
	        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('uname'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('uname'); ?>
<input type="text" class="clsTextBox" name="uname" id="uname" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('uname'); ?>
" />
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('username','uname'); ?>
</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('fname'); ?>
"><label for="fname"><?php echo $this->_tpl_vars['LANG']['addletter_search_first_name']; ?>
</label></td>
		        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('fname'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('fname'); ?>
<input type="text" class="clsTextBox" name="fname" id="fname" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('fname'); ?>
" />
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('first_name','fname'); ?>
</td>
		</tr>
       		<tr>
		        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('lname'); ?>
"><label for="lname"><?php echo $this->_tpl_vars['LANG']['addletter_search_last_name']; ?>
</label></td>
		        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('lname'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('lname'); ?>
<input type="text" class="clsTextBox" name="lname" id="lname" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('lname'); ?>
" />
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('last_name','lname'); ?>
</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('email'); ?>
"><label for="email"><?php echo $this->_tpl_vars['LANG']['addletter_search_email']; ?>
</label></td>
		    	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('email'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('email'); ?>
<input type="text" class="clsTextBox" name="email" id="email" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" />
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('email','email'); ?>
</td>
        	</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('gender'); ?>
"><label for="gender"><?php echo $this->_tpl_vars['LANG']['addletter_search_sex']; ?>
</label></td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('gender'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('gender'); ?>

				<select name="gender" id="gender" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
					<option value=""><?php echo $this->_tpl_vars['LANG']['addletter_search_sex_option_both']; ?>
</option>
					<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['gender_list_arr'],$this->_tpl_vars['myobj']->getFormField('gender')); ?>

				</select>
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('gender'); ?>

			</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('doj_start'); ?>
"><label for="doj_start"><?php echo $this->_tpl_vars['LANG']['addletter_search_doj']; ?>
</label></td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('doj_start'); ?>
">
					<label for="doj_start"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_doj_from']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('doj_start'); ?>

					<input type="text" class="clsTextBox clsDateSelectTextBox" name="doj_start" id="doj_start" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('doj_start'); ?>
" />
					<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('doj_start',$this->_tpl_vars['calendar_opts_arr']); ?>


					<label for="doj_end"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_doj_to']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('doj_end'); ?>

					<input type="text" class="clsTextBox clsDateSelectTextBox" name="doj_end" id="doj_end" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('doj_end'); ?>
" />
					<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('doj_end',$this->_tpl_vars['calendar_opts_arr']); ?>

			</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('dob_start'); ?>
"><label for="dob_start"><?php echo $this->_tpl_vars['LANG']['addletter_search_dob']; ?>
</label></td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('dob_start'); ?>
">
					<label for="dob_start"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_dob_from']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('dob_start'); ?>

					<input type="text" class="clsTextBox clsDateSelectTextBox" name="dob_start" id="dob_start" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('dob_start'); ?>
" />
					<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('dob_start',$this->_tpl_vars['calendar_opts_arr']); ?>


					<label for="dob_end"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_dob_to']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('dob_end'); ?>

					<input type="text" class="clsTextBox clsDateSelectTextBox" name="dob_end" id="dob_end" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('dob_end'); ?>
" />
					<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('dob_end',$this->_tpl_vars['calendar_opts_arr']); ?>

			</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('login_start'); ?>
"><label for="login_start"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_last_logged']; ?>
</label></td>
				<td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('login_start'); ?>
">
					<label for="login_start"></label>
						<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('login_start'); ?>

						<input type="text" class="clsTextBox clsDateSelectTextBox" name="login_start" id="login_start" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('login_start'); ?>
" />
						<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('login_start',$this->_tpl_vars['calendar_opts_arr']); ?>

			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('last_login_date','login_start'); ?>

				</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('user_status_Ok'); ?>
"><label for="user_status_Ok"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_status']; ?>
</label></td>
		 		<td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_status_Ok'); ?>
">
				 	<span><input type="checkbox" class="clsCheckBox" value="Ok" id="user_status_Ok" name="user_status_Ok"  <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('user_status_Ok'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="user_status_Ok"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_status_active']; ?>
</label></span>
					<span><input type="checkbox" class="clsCheckBox" value="ToActivate" id="user_status_ToActivate" name="user_status_ToActivate" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('user_status_ToActivate'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="user_status_ToActivate"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_status_in_active']; ?>
</label></span>
					<span><input type="checkbox" class="clsCheckBox" value="Locked" id="user_status_Locked" name="user_status_Locked" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('user_status_Locked'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="user_status_Locked"><?php echo $this->_tpl_vars['LANG']['addletter_search_results_label_status_locked']; ?>
</label></span>
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('user_status','user_status_Ok'); ?>

		 		</td>
	        </tr>
            <tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('subject'); ?>
"><label for="subject"><?php echo $this->_tpl_vars['LANG']['addletter_subject']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('subject'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('subject'); ?>
<input type="text" class="clsTextBox" name="subject" id="subject" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->getFormField('subject'))) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
" />
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('news_letter_subject','subject'); ?>
</td>
		</tr>
		<tr>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('body'); ?>
"><label for="body"><?php echo $this->_tpl_vars['LANG']['addletter_body']; ?>
</label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
			<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('body'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('body'); ?>

					<textarea name="body" id="body" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->getFormField('body'))) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
</textarea>
			<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('news_letter_body','body'); ?>

			</td>
		</tr>
		<tr>
        <td></td>
		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
">
					<a href="#" id="dAltMlti"></a>
					<input type="button" class="clsSubmitButton" name="addstock" id="addstock" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['addletter_add']; ?>
" onClick="getAction();" />
		</td>
		</tr>
		</table>
		<input type="hidden" name="submit_confirm" id="submit_confirm"/>
	</form>
	<?php endif; ?>
</div>
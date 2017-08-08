<?php /* Smarty version 2.6.18, created on 2011-10-19 10:49:55
         compiled from memberManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'memberManage.tpl', 16, false),array('modifier', 'cat', 'memberManage.tpl', 254, false),array('modifier', 'wordWrap_mb_Manual', 'memberManage.tpl', 254, false),array('modifier', 'date_format', 'memberManage.tpl', 262, false),)), $this); ?>
<div id="selMemberList">
	<!-- heading start-->
	<h2>
    	<span>
        	<?php echo $this->_tpl_vars['LANG']['search_title']; ?>

        </span>
    </h2>
    <!-- heading end-->
    <!-- Confirmation message block start-->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
        <p id="confirmMessage"></p>
        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
            <table summary="">
                <tr>
                    <td>
                        <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
                        &nbsp;
                        <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
                    </td>
                </tr>
            </table>
            <input type="hidden" name="ch_status" id="ch_status" />
            <input type="hidden" name="act" id="act" />
            <input type="hidden" name="uid" id="uid" />
            <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_list_members['populateHidden_arr']); ?>

        </form>
    </div>
    <!-- Confirmation message block end-->
     <!-- information div -->
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_search')): ?>
        <form name="formSearch" id="formSearch" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
        <table class="clsNoBorder clsTextBoxTable">
            <tr>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('uname'); ?>
"><label for="uname"><?php echo $this->_tpl_vars['LANG']['common_username']; ?>
</label></td>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('uname'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('uname'); ?>
<input type="text" class="clsTextBox" name="uname" id="uname" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('uname'); ?>
" /></td>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('email'); ?>
"><label for="email"><?php echo $this->_tpl_vars['LANG']['search_email']; ?>
</label></td>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('email'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('email'); ?>
<input type="text" class="clsTextBox" name="email" id="email" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" /></td>
            </tr>
           <tr>
             <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('fname'); ?>
"><label for="fname"><?php echo $this->_tpl_vars['LANG']['search_first_name']; ?>
</label></td>
             <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('fname'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('fname'); ?>
<input type="text" class="clsTextBox" name="fname" id="fname" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('fname'); ?>
" /></td>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('tagz'); ?>
"><label for="tagz"><?php echo $this->_tpl_vars['LANG']['search_profile_tag']; ?>
</label></td>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('tagz'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('tagz'); ?>
<input type="text" class="clsTextBox" name="tagz" id="tagz" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('tagz'); ?>
" /></td>
          </tr>
            <tr>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('sex'); ?>
"><label for="sex"><?php echo $this->_tpl_vars['LANG']['search_sex']; ?>
</label></td>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('sex'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('sex'); ?>

              <select name="sex" id="sex" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                <option value=""><?php echo $this->_tpl_vars['LANG']['search_sex_option_both']; ?>
</option>
                <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->form_search['LANG_LIST_ARR'],$this->_tpl_vars['myobj']->getFormField('sex')); ?>

              </select>             </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('country'); ?>
"><label for="country"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_country']; ?>
</label></td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('country'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('country'); ?>
<select name="country" id="country" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->populateCountriesList($this->_tpl_vars['myobj']->getFormField('country')); ?>
</select></td>
            </tr>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('doj_s_d'); ?>
"><label for="doj_s_d"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_doj']; ?>
 </label></td>
                <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('doj_s_d'); ?>
">
                    <p>
                        <label for="doj_s_d"><label for="doj_s_d"><?php echo $this->_tpl_vars['LANG']['search_results_label_doj_from']; ?>
</label></label>
                        <select name="doj_s_d" id="doj_s_d" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateDaysList($this->_tpl_vars['myobj']->getFormField('doj_s_d')); ?>

                        </select>&nbsp;
                        <select name="doj_s_m" id="doj_s_m" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateMonthsList($this->_tpl_vars['myobj']->getFormField('doj_s_m')); ?>

                        </select>&nbsp;
                        <select name="doj_s_y" id="doj_s_y" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                       	 <?php echo $this->_tpl_vars['myobj']->populateYearsList($this->_tpl_vars['myobj']->getFormField('doj_s_y')); ?>

                        </select>
                    </p>
                    <p>
                        <label for="doj_e_d"><label for="doj_e_d"><?php echo $this->_tpl_vars['LANG']['search_results_label_doj_to']; ?>
</label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select name="doj_e_d" id="doj_e_d" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateDaysList($this->_tpl_vars['myobj']->getFormField('doj_e_d')); ?>

                        </select>&nbsp;
                        <select name="doj_e_m" id="doj_e_m" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateMonthsList($this->_tpl_vars['myobj']->getFormField('doj_e_m')); ?>

                        </select>&nbsp;
                        <select name="doj_e_y" id="doj_e_y" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateYearsList($this->_tpl_vars['myobj']->getFormField('doj_e_y')); ?>

                        </select>
                    </p>                </td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('login_s_d'); ?>
"><label for="login_s_d"><?php echo $this->_tpl_vars['LANG']['search_results_label_last_logged']; ?>
</label></td>
                <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('login_s_d'); ?>
">
                    <p>
                        <label for="login_s_d"><label for="login_s_d"><?php echo $this->_tpl_vars['LANG']['search_results_label_last_logged_from']; ?>
</label>&nbsp;</label>
                        <select name="login_s_d" id="login_s_d" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateDaysList($this->_tpl_vars['myobj']->getFormField('login_s_d')); ?>

                        </select>
                        <select name="login_s_m" id="login_s_m" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateMonthsList($this->_tpl_vars['myobj']->getFormField('login_s_m')); ?>

                        </select>
                        <select name="login_s_y" id="login_s_y" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateYearsList($this->_tpl_vars['myobj']->getFormField('login_s_y')); ?>

                        </select>
                    </p>
                    <p>
                        <label for="login_e_d"><label for="login_e_d"><?php echo $this->_tpl_vars['LANG']['search_results_label_last_logged_to']; ?>
</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <select name="login_e_d" id="login_e_d" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateDaysList($this->_tpl_vars['myobj']->getFormField('login_e_d')); ?>

                        </select>
                        <select name="login_e_m" id="login_e_m" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateMonthsList($this->_tpl_vars['myobj']->getFormField('login_e_m')); ?>

                        </select>
                        <select name="login_e_y" id="login_e_y" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        <option value="">-</option>
                        <?php echo $this->_tpl_vars['myobj']->populateYearsList($this->_tpl_vars['myobj']->getFormField('login_e_y')); ?>

                        </select>
                    </p>                    </td>
            </tr>
            <tr>
              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('hasVideos'); ?>
"><label for="hasFriends"><?php echo $this->_tpl_vars['LANG']['search_with_photos_videos_friends_groups']; ?>
</label></td>
              <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('hasVideos'); ?>
">
              <?php if ($this->_tpl_vars['myobj']->module_array): ?>
                 <?php $_from = $this->_tpl_vars['myobj']->module_array; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module_detail']):
?>
                 	<span><input type="checkbox" class="clsCheckRadio" id="<?php echo $this->_tpl_vars['module_detail']['field_name']; ?>
" name="<?php echo $this->_tpl_vars['module_detail']['field_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox($this->_tpl_vars['module_detail']['field_name']); ?>
 value="1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="<?php echo $this->_tpl_vars['module_detail']['field_name']; ?>
">&nbsp;<?php echo $this->_tpl_vars['module_detail']['lang_value']; ?>
</label>&nbsp;&nbsp;</span>
                 <?php endforeach; endif; unset($_from); ?>
             <?php endif; ?>
              <span><input type="checkbox" class="clsCheckRadio" id="hasFriends" name="hasFriends" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('hasFriends'); ?>
 value="1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="hasFriends">&nbsp;<?php echo $this->_tpl_vars['LANG']['search_with_friends']; ?>
</label>&nbsp;&nbsp;</span>             </td>
             <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_status_Ok'); ?>
" ><label for="user_status_Ok"><?php echo $this->_tpl_vars['LANG']['search_results_label_status']; ?>
</label></td>
             <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_status_Ok'); ?>
">
                <span><input type="checkbox" class="clsCheckRadio" value="Ok" id="user_status_Ok" name="user_status_Ok"  <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('user_status_Ok'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="user_status_Ok"><?php echo $this->_tpl_vars['LANG']['search_results_label_status_active']; ?>
</label></span>
                <span><input type="checkbox" class="clsCheckRadio" value="ToActivate" id="user_status_ToActivate" name="user_status_ToActivate" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('user_status_ToActivate'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="user_status_ToActivate"><?php echo $this->_tpl_vars['LANG']['search_results_label_status_in_active']; ?>
</label></span>
                <span><input type="checkbox" class="clsCheckRadio" value="Locked" id="user_status_Locked" name="user_status_Locked" <?php echo $this->_tpl_vars['myobj']->isCheckedCheckBox('user_status_Locked'); ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/><label for="user_status_Locked"><?php echo $this->_tpl_vars['LANG']['search_results_label_status_locked']; ?>
</label></span>             </td>
            </tr>
            <?php if ($this->_tpl_vars['CFG']['feature']['membership_payment']): ?>
	            <tr>
	              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_type'); ?>
"><label for="user_type1"><?php echo $this->_tpl_vars['LANG']['member_manage_payment_user_type']; ?>
</label></td>
	              <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_type'); ?>
">
	               <input type="radio" name="user_type" id="user_type1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('user_type','Yes'); ?>
 />
	              <label for="user_type1"><?php echo $this->_tpl_vars['LANG']['member_manage_paid_user']; ?>
</label>
	              <input type="radio" name="user_type" id="user_type2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('user_type','No'); ?>
 />
	              <label for="user_type2"><?php echo $this->_tpl_vars['LANG']['member_manage_unpaid_user']; ?>
</label>
	              </td>
	              <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('empty'); ?>
">&nbsp;</td>
	              <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('empty'); ?>
">&nbsp;

	              </td>
	            </tr>
            <?php endif; ?>
            <tr>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('sort_field'); ?>
"><label for="sort_field"><?php echo $this->_tpl_vars['LANG']['search_results_label_sort_by']; ?>
</label></td>
                <td  class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('sort_field'); ?>
">
	                <select name="sort_field" id="sort_field" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
	                <option value="user_id" <?php echo $this->_tpl_vars['myobj']->form_search['SORT_user_id']; ?>
><?php echo $this->_tpl_vars['LANG']['search_results_label_sort_by_doj']; ?>
</option>
	                <option value="user_name" <?php echo $this->_tpl_vars['myobj']->form_search['SORT_user_name']; ?>
><?php echo $this->_tpl_vars['LANG']['search_results_label_sort_by_user_name']; ?>
</option>
	                <option value="last_logged" <?php echo $this->_tpl_vars['myobj']->form_search['SORT_last_logged']; ?>
><?php echo $this->_tpl_vars['LANG']['search_results_label_sort_by_last_visit']; ?>
</option>
	                <option value=""><?php echo $this->_tpl_vars['LANG']['search_results_label_sort_by_none']; ?>
</option>
	                </select>
	                &nbsp;<?php echo $this->_tpl_vars['LANG']['search_results_label_sort_in']; ?>
&nbsp;
	                <select name="sort_field_order_by" id="sort_field_order_by" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
	                    <option value="ASC" <?php echo $this->_tpl_vars['myobj']->form_search['SORT_ORDER_ASC']; ?>
><?php echo $this->_tpl_vars['LANG']['search_results_label_sort_in_asc']; ?>
</option>
	                    <option value="DESC" <?php echo $this->_tpl_vars['myobj']->form_search['SORT_ORDER_DESC']; ?>
><?php echo $this->_tpl_vars['LANG']['search_results_label_sort_in_desc']; ?>
</option>
	                </select>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('usr_type'); ?>
"><label for="usr_type"><?php echo $this->_tpl_vars['LANG']['member_manage_user_type']; ?>
</label></td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('usr_type'); ?>
">
					<select name="usr_type" id="usr_type" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
						<option value=""><?php echo $this->_tpl_vars['LANG']['search_country_choose']; ?>
</option>
						<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->user_types,$this->_tpl_vars['myobj']->getFormField('usr_type')); ?>

					</select>
				</td>
            </tr>
            <tr>
                <td colspan="4" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
                    <input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['search_submit']; ?>
" />
                    &nbsp;&nbsp;
                    <input type="submit" class="clsSubmitButton" name="search_submit_reset" id="search_submit_reset" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['search_submit_reset']; ?>
" onclick=""/>
				</td>
            </tr>
            <tr>
                <td colspan="4" align="center" id="searchErrorMsg">&nbsp;</td><!--for php coders -->
            </tr>
        </table>
  </form>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_no_records_found')): ?>
        <div id="selMsgAlert">
            <p><?php echo $this->_tpl_vars['LANG']['search_msg_no_records']; ?>
</p>
        </div>
	<?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_user_details_updated') && $this->_tpl_vars['myobj']->getCommonErrorMsg()): ?>
		<div id="selMsgSuccess"><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</div>
    <?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_list_members')): ?>
    	<div id="selMsgChangeStatus" style="display:none;">
	      	<form name="formChangeStatus" id="formChangeStatus" class="clsCenterAlignTD" method="post" action="<?php echo $this->_tpl_vars['_SERVER']['PHP_SELF']; ?>
">
	        	<table class="clsNoBorder">
		          	<tr>
					  	<td colspan="2"><p id="msgConfirmText"></p></td>
		          	</tr>
		          	<tr>
				  		<td id="selPhotoGallery">
							<p id="profileIcon"></p>
						</td>
				  	</tr>
				  	<tr>
		            	<td>
						  	<input type="submit" class="clsSubmitButton" name="submit_yes" id="submit_yes" value="Activate" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
			              	<input type="button" class="clsSubmitButton" name="submit_no" id="submit_no" value="Cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
						</td>
		          	</tr>
	        	</table>
				<input type="hidden" name="action" id="action" />
	          	<input type="hidden" name="uid" id="uid" />
				<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_list_members['populateHidden_arr']); ?>

	      	</form>
	    </div>
        <!-- top pagination start-->
        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
        <table summary="<?php echo $this->_tpl_vars['LANG']['member_list_tbl_summary']; ?>
">
			<tr>
                <th><?php echo $this->_tpl_vars['LANG']['search_results_title_user_id_info']; ?>
</th>
                <th  colspan="2"><?php echo $this->_tpl_vars['LANG']['search_results_title_user_account_info']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['search_results_title_user_primary_info']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['search_results_title_user_site_info']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['search_results_title_status']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['action_links']; ?>
</th>
			</tr>
			<?php $_from = $this->_tpl_vars['myobj']->form_list_members['displayMembers']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dmKey'] => $this->_tpl_vars['dmValue']):
?>
                <tr class="<?php echo $this->_tpl_vars['dmValue']['cssRowClass']; ?>
 <?php echo $this->_tpl_vars['dmValue']['userClass']; ?>
">
                	<td>
                    	<div>	<?php echo $this->_tpl_vars['dmValue']['record']['user_id']; ?>
 </div>
                    </td>
                    <td>
                    	<ul>
							<li><span class="clsProfileThumbImg"><a href="<?php echo $this->_tpl_vars['dmValue']['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['dmValue']['record']['user_name']; ?>
</a></span></li>
							<li id="imgProfileIcon_<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
">
		                        <span class="clsProfileThumbImg">
		                            <a href="<?php echo $this->_tpl_vars['dmValue']['memberProfileUrl']; ?>
">
		                                <img src="<?php echo $this->_tpl_vars['dmValue']['icon']['t_url']; ?>
" alt="<?php echo $this->_tpl_vars['dmValue']['record']['user_name']; ?>
" title="<?php echo $this->_tpl_vars['dmValue']['record']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['dmValue']['icon']['t_width'],$this->_tpl_vars['dmValue']['icon']['t_height']); ?>
 />
		                            </a>
		                        </span>
                        	</li>
                        </ul>
					</td>
                    <td>
	                    <ul class="clsListValues">
	                    	<li>
								<div><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['dmValue']['record']['first_name'])) ? $this->_run_mod_handler('cat', true, $_tmp, ' ') : smarty_modifier_cat($_tmp, ' ')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['dmValue']['record']['last_name']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['dmValue']['record']['last_name'])))) ? $this->_run_mod_handler('wordWrap_mb_Manual', true, $_tmp, 15, 15) : wordWrap_mb_Manual($_tmp, 15, 15)); ?>
</div>
							</li>
	                    	<li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_age']; ?>
</div>
								<div class="clsRight"><?php echo $this->_tpl_vars['dmValue']['record']['age']; ?>
&nbsp;</div>
							</li>
	                    	<li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_last_logged']; ?>
</div>
								<div class="clsRight"><?php if ($this->_tpl_vars['dmValue']['record']['last_logged'] == '0000-00-00 00:00:00'): ?><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_not_visited']; ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['dmValue']['record']['last_logged'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
<?php endif; ?></div>
							</li>
	                    	<li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_doj']; ?>
</div>
								<div class="clsRight"><?php echo ((is_array($_tmp=$this->_tpl_vars['dmValue']['record']['doj'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
</div>
							</li>
	                    	<li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['member_manage_user_type']; ?>
</div>
								<div class="clsRight"><?php echo $this->_tpl_vars['myobj']->getUserTypeName($this->_tpl_vars['dmValue']['record']['usr_type']); ?>
</div>
							</li>
	                    </ul>
					</td>
                    <td>
                    	<ul class="clsListValues">
							<li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_email']; ?>
</div>
								<div class="clsRight"><?php echo $this->_tpl_vars['dmValue']['record']['email']; ?>
</div>
							</li>
		                    <li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_city']; ?>
</div>
								<div class="clsRight"><?php echo $this->_tpl_vars['dmValue']['record']['city']; ?>
&nbsp;</div>
							</li>
		                    <li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_zip']; ?>
</div>
								<div class="clsRight"><?php echo $this->_tpl_vars['dmValue']['record']['postal_code']; ?>
&nbsp;</div>
							</li>
		                    <li>
								<div class="clsLeft"><?php echo $this->_tpl_vars['LANG']['search_results_sub_title_country']; ?>
</div>
								<div class="clsRight"><?php echo $this->_tpl_vars['dmValue']['country']; ?>
&nbsp;</div>
							</li>
						</ul>
					</td>
                    <td>
						<p><?php echo $this->_tpl_vars['LANG']['search_results_title_friends']; ?>
 <?php if ($this->_tpl_vars['dmValue']['record']['total_friends'] != ''): ?>(<?php echo $this->_tpl_vars['dmValue']['record']['total_friends']; ?>
)<?php endif; ?> </p>
                      	<?php $_from = $this->_tpl_vars['dmValue']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['marrKey'] => $this->_tpl_vars['marrValue']):
?>
                      		<p><?php echo $this->_tpl_vars['marrValue']['total_upload']; ?>
</p>
                    	<?php endforeach; endif; unset($_from); ?>
					</td>
                    <td><?php echo $this->_tpl_vars['dmValue']['accountStatus']; ?>
</td>
                   	<td>
						<ul>
							<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Edit')): ?>
								<li><a href="memberAdd.php?user_id=<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
<?php echo $this->_tpl_vars['dmValue']['sessionSearchQueryString']; ?>
" ><?php echo $this->_tpl_vars['LANG']['search_results_link_edit']; ?>
</a></li>
							<?php endif; ?>
							<?php if ($this->_tpl_vars['CFG']['user']['user_id'] != $this->_tpl_vars['dmValue']['user_id']): ?>
	                    		<?php if ($this->_tpl_vars['dmValue']['activateLink'] && ( $this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Activate') )): ?>
		                        	<li>
			                        	<a href="javascript:void(0);"  onClick="return activateMember('<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['search_results_link_activate']; ?>
</a>
		                        	</li>
	                        	<?php endif; ?>
	                        	<?php if ($this->_tpl_vars['dmValue']['deActivateLink'] && ( $this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Inactivate') )): ?>
		                        	<li>
		                         		<a href="javascript:void(0);" onClick="return deActivateMember('<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
')"><?php echo $this->_tpl_vars['LANG']['search_results_link_de_activate']; ?>
</a>
		                         	</li>
	                        	<?php endif; ?>
	                        <?php endif; ?>
	                        <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','View')): ?>
		                        <li>
		                            <a href="<?php echo $this->_tpl_vars['dmValue']['memberProfileUrl']; ?>
" ><?php echo $this->_tpl_vars['LANG']['search_results_link_view']; ?>
</a>
		                        </li>
	                        <?php endif; ?>
	                        <?php if ($this->_tpl_vars['CFG']['user']['user_id'] != $this->_tpl_vars['dmValue']['user_id']): ?>
	                        	<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Delete')): ?>
			                    	<li>
			                       		<a href="javascript:void(0);" onClick="return deleteMember('<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
')">
			                        		<?php echo $this->_tpl_vars['LANG']['search_results_link_delete']; ?>

			                        	</a>
			                        </li>
			                    <?php endif; ?>
	                        <?php endif; ?>
	                        <?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'user_manage','Featured')): ?>
		                        <?php if ($this->_tpl_vars['dmValue']['record']['featured'] == 'Yes'): ?>
		                       		<li>
		                                <a href="javascript:void(0);" onClick="return removeFeaturedMember('<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
')">
		                                    <?php echo $this->_tpl_vars['LANG']['search_results_link_remove_feature']; ?>

		                                </a>
		                            </li>
		                        <?php else: ?>
		                       		 <li>
		                             	<a href="javascript:void(0);" onClick="return setFeaturedMember('<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
')">
		                             	   <?php echo $this->_tpl_vars['LANG']['search_results_link_set_featured']; ?>

		                                </a>
		                             </li>
	                        	<?php endif; ?>
	                        <?php endif; ?>
	                        <?php if (chkAllowedModule ( array ( 'video' ) ) && $this->_tpl_vars['CFG']['admin']['videos']['show_background_image_link_admin']): ?>
	                            <?php if ($this->_tpl_vars['dmValue']['record']['is_upload_background_image'] == 'No'): ?>
	                                <li>
	                                    <a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('Yes', '<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
', 'is_upload_background_image', '<?php echo $this->_tpl_vars['LANG']['member_manage_approve_msg']; ?>
'), Array('value', 'value', 'value', 'innerHTML'));">
	                                        <?php echo $this->_tpl_vars['LANG']['member_manage_approve']; ?>

	                                     </a>
	                                 </li>
	                            <?php else: ?>
	                                <li>
	                                    <a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('No', '<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
', 'is_upload_background_image', '<?php echo $this->_tpl_vars['LANG']['member_manage_disapprove_msg']; ?>
'), Array('value', 'value', 'value', 'innerHTML'));">
	                                      <?php echo $this->_tpl_vars['LANG']['member_manage_disapprove']; ?>

	                                    </a>
	                                </li>
	                            <?php endif; ?>
	                        <?php endif; ?>
	                        <?php if ($this->_tpl_vars['CFG']['feature']['signup_payment']): ?>
		                        <?php if ($this->_tpl_vars['dmValue']['record']['is_paid_member'] == 'Yes'): ?>
		                        	<li
		                             	<a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('No', '<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
', 'is_paid_member', '<?php echo $this->_tpl_vars['LANG']['member_confirm_remove_as_paidmembers']; ?>
'), Array('value', 'value', 'value', 'innerHTML'));">
		                                    <?php echo $this->_tpl_vars['LANG']['member_remove_as_paidmembers']; ?>

	                                  </a>
	                                </li>
		                        <?php else: ?>
		                        	<li>
		                             	<a href="javascript:void(0);" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('ch_status', 'uid', 'act', 'confirmMessage'), Array('Yes', '<?php echo $this->_tpl_vars['dmValue']['user_id']; ?>
', 'is_paid_member', '<?php echo $this->_tpl_vars['LANG']['member_confirm_set_as_paidmembers']; ?>
'), Array('value', 'value', 'value', 'innerHTML'));">
		                                    <?php echo $this->_tpl_vars['LANG']['member_set_as_paidmembers']; ?>

	                                 	</a>
	                                </li>
		                        <?php endif; ?>
	                        <?php endif; ?>
						</ul>
					</td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
		</table>
        <!-- top pagination start-->
        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
         <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
        <!-- top pagination end-->
    <?php endif; ?>
 </div>
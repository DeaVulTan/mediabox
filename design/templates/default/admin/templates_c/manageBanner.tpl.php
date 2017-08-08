<?php /* Smarty version 2.6.18, created on 2011-10-19 10:50:25
         compiled from manageBanner.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageBanner.tpl', 7, false),array('modifier', 'date_format', 'manageBanner.tpl', 221, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_list_advertisement')): ?>
<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
  <h3 id="confirmation_msg"></h3>
  <form name="deleteForm" id="deleteForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
        <!-- clsFormSection - starts here -->

          <input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;
          <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
" onClick="return hideAllBlocks();" />
          <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->deleteForm_hidden_arr); ?>

    <!-- clsFormSection - ends here -->
  </form>
</div>
<div id="selMsgPreviewWindow" class="selMsgConfirmWindow" style="display:none;">
  <form name="previewForm" id="previewForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
  	    <p id="selPreviewBanner"></p>
  </form>
</div>
<div id="selCodeForm" class="clsPopupAlert" style="display:none;">
  <h2 id="codeTitle"></h2>
  <form name="codeForm" id="codeForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
        <!-- clsFormSection - starts here -->
    <table class="clsFormSection">

      <tr>
        <td>
          <textarea name="addCode" id="addCode" rows="2" cols="50"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <p><?php echo $this->_tpl_vars['LANG']['manage_banner_code_instruction']; ?>
</p>
        </td>
      </tr>
    </table>
    <!-- clsFormSection - ends here -->
  </form>
</div>
<?php endif; ?>
<div id="selAdvertisement">
  <h2><span><?php echo $this->_tpl_vars['LANG']['manage_banner_title']; ?>
</span></h2>
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_add_advertisement')): ?>
  <h3><?php echo $this->_tpl_vars['LANG']['manage_banner_page_add_edit_title']; ?>
</h3>
  <div id="selAddAdvertisementBlock">
    <form name="selAddAdvertisementForm" id="selAddAdvertisementForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
          <!-- clsFormSection - starts here -->
    <table class="clsFormSection clsNoBorder">
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('block'); ?>
 clsSmallWidth">
            <label for="block"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_block']; ?>
</label>
            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('block'); ?>
"> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('block'); ?>

            <input type="text" class="clsTextBox" name="block" id="block" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('block'); ?>
" />
            <p class="clsHelpBanner"><a href="javascript:void(0)" onclick="return popupWindow('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
bannerPosition.php', '580', '490')"><?php echo $this->_tpl_vars['LANG']['manage_banner_banner_position']; ?>
</a> &nbsp;<a href="javascript:void(0)" onclick="return popupWindow('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/bannerDetails.php', '580', '400')"><?php echo $this->_tpl_vars['LANG']['manage_banner_banner_details']; ?>
</a></p>

        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_block','block'); ?>

          </td></tr>
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('source'); ?>
">
            <label for="source"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_source']; ?>
</label>
            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('source'); ?>
"> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('source'); ?>

            <textarea name="source" id="source" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('source'); ?>
</textarea>
            <p><a href="javascript:void(0)" onclick="<?php echo $this->_tpl_vars['myobj']->confrimation_preview_onclick; ?>
"><?php echo $this->_tpl_vars['LANG']['manage_banner_preview']; ?>
</a></p>
        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_html_source','source'); ?>

          </td></tr>
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('about'); ?>
">
            <label for="about"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_about']; ?>
</label>
            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('about'); ?>
"> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('about'); ?>

            <textarea name="about" id="about" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('about'); ?>
</textarea>
       <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_about_advertisement','about'); ?>

          </td> </tr>
        <?php if ($this->_tpl_vars['CFG']['admin']['banner']['impressions_date']): ?>
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('start_date'); ?>
">
            <label for="start_date"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_start_date']; ?>
</label>
            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('start_date'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('start_date'); ?>

            <input type="text" class="clsTextBox" name="start_date" id="start_date" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start_date'); ?>
" />
            <?php echo $this->_tpl_vars['myobj']->populateDateCalendar('start_date',$this->_tpl_vars['calendar_opts_arr']); ?>

       		<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_start_date','start_date'); ?>
  </td></tr>
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('end_date'); ?>
">
            <label for="end_date"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_end_date']; ?>
</label>
            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('end_date'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('end_date'); ?>

            <input type="text" class="clsTextBox" name="end_date" id="end_date" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('end_date'); ?>
" />
			<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('end_date',$this->_tpl_vars['calendar_opts_arr']); ?>

       <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_end_date','end_date'); ?>
</td> </tr>
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('allowed_impressions'); ?>
">
            <label for="allowed_impressions"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_allowed_impressions']; ?>
</label>
          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('allowed_impressions'); ?>
"> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('allowed_impressions'); ?>

            <input type="text" class="clsTextBox" name="allowed_impressions" id="allowed_impressions" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('allowed_impressions'); ?>
" />
        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_allowed_impressions','allowed_impressions'); ?>

          </td></tr>
        <?php endif; ?>
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('status'); ?>
">
            <label for="status_opt_1"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_status']; ?>
</label>
          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('status'); ?>
"> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('status'); ?>

            <input type="radio" class="clsRadioButton" name="status" id="status_opt_1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="activate"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('status','activate'); ?>
 />
            <label for="status_opt_1"><?php echo $this->_tpl_vars['LANG']['manage_banner_status_activate']; ?>
</label>
            <input type="radio" class="clsRadioButton" name="status" id="status_opt_2" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="toactivate"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('status','toactivate'); ?>
 />
            <label for="status_opt_2"><?php echo $this->_tpl_vars['LANG']['manage_banner_status_toactivate']; ?>
</label>
        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_status','status'); ?>

          </td></tr>
        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('default'); ?>
">&nbsp;</td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
">
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_edit_advertisement')): ?>
            <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->selAddAdvertisementForm_hidden_arr1); ?>

            <input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manage_banner_update_submit']; ?>
" />
            <input type="submit"  class="clsCancelButton" name="cancel_submit" id="cancel_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manage_banner_cancel_submit']; ?>
" />
            <?php else: ?>
            <input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manage_banner_add_submit']; ?>
" />
            <?php endif; ?>
     <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->selAddAdvertisementForm_hidden_arr); ?>
</td> </tr>
        </table>
    <!-- clsFormSection - ends here -->
    </form>
  </div>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_search')): ?>
  <div id="selSearchBlock">
   <h3><?php echo $this->_tpl_vars['LANG']['manage_banner_page_search_title']; ?>
</h3>
  <form name="selSearchForm" id="selSearchForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
          <!-- clsFormSection - starts here -->
    <table class="clsFormSection clsNoBorder">

        <tr>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('user_name'); ?>
 clsSmallWidth">
            <label for="user_name"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_user_name']; ?>
</label>
          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('user_name'); ?>
"> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('user_name'); ?>

            <input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
" />
		  <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_post_by','user_name'); ?>

          </td>
		  </tr>
          <tr>
        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('block_search'); ?>
">
            <label for="block_search"><?php echo $this->_tpl_vars['LANG']['manage_banner_label_block']; ?>
</label>
          </td>
          <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('block_search'); ?>
"> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('block_search'); ?>

            <input type="text" class="clsTextBox" name="block_search" id="block_search" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('block_search'); ?>
" />
     <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('banner_block','block_search'); ?>

          </td>
	 </tr>
	 <tr>     <td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('default'); ?>
">
            <input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manage_banner_search_submit']; ?>
" />
          </td>
        </tr>
      </table>

    <!-- clsFormSection - ends here -->
   </form>
  </div>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_list_advertisement')): ?>
  <div>
      <div>
            <label for="template_name"><?php echo $this->_tpl_vars['LANG']['manage_banner_template']; ?>
</label>:
            <select name="template_name" id="template_name" onchange="tempalteNav()">
            	<?php $_from = $this->_tpl_vars['CFG']['html']['template']['allowed']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['allowed_templates']):
?>
                  	<option value="<?php echo $this->_tpl_vars['allowed_templates']; ?>
"<?php if ($this->_tpl_vars['allowed_templates'] == $this->_tpl_vars['myobj']->getFormField('template_name')): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['allowed_templates']; ?>
</option>
                  <?php endforeach; endif; unset($_from); ?>
            </select>
      </div>
    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
    <form name="selListAdvertisementForm" id="selListAdvertisementForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
          <!-- clsDataDisplaySection - starts here -->
    <div class="clsDataDisplaySection">
        <div class="clsDataHeadSection">
          <table>
            <tr>
			<th class="clsSelectColumn"><input type="checkbox" class="clsCheckBox" name="check_all" onclick= "CheckAll(document.selListAdvertisementForm.name, document.selListAdvertisementForm.check_all.name)" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></th>
            <th><?php echo $this->_tpl_vars['LANG']['manage_banner_th_banner_id']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['manage_banner_th_block']; ?>
</th>
            <th class="clsBannerDescription"><?php echo $this->_tpl_vars['LANG']['manage_banner_th_about']; ?>
</th>
            <?php if ($this->_tpl_vars['CFG']['admin']['banner']['impressions_date']): ?>
            <th><p><?php echo $this->_tpl_vars['LANG']['manage_banner_allowed_impressions']; ?>
</p><p><?php echo $this->_tpl_vars['LANG']['manage_banner_completed_impressions']; ?>
</p></th>
            <?php endif; ?>
            <th><?php echo $this->_tpl_vars['LANG']['manage_banner_th_added_by']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['manage_banner_th_status']; ?>
</th>
             <th class="clsDateColumn">
			 	<?php if ($this->_tpl_vars['CFG']['admin']['banner']['impressions_date']): ?>
				 	<p><?php echo $this->_tpl_vars['LANG']['manage_banner_th_start_date']; ?>
</p>
            		<p><?php echo $this->_tpl_vars['LANG']['manage_banner_th_end_date']; ?>
</p>
            	<?php endif; ?>
           		<p><?php echo $this->_tpl_vars['LANG']['manage_banner_th_date_added']; ?>
</p>
			</th>
            <th>&nbsp;</th>
</tr>
			<?php $_from = $this->_tpl_vars['populateAdds_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
           <tr>
 			<td class="clsSelectColumn">
              <input type="checkbox" class="clsCheckBox" name="aid[]" value="<?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['add_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('selListAdvertisementForm');"/>
            </td>
            <td><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['add_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['block']; ?>
</td>
            <td class="clsBannerDescription"><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['about']; ?>
</td>
            <?php if ($this->_tpl_vars['CFG']['admin']['banner']['impressions_date']): ?>
            <td><p><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['allowed_impressions']; ?>
</p>
            <p><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['completed_impressions']; ?>
</p></td>
            <?php endif; ?>
            <td><a href="<?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['profile_link']; ?>
"><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['name']; ?>
</a></td>
            <td><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['status']; ?>
</td>
            <td class="clsDateColumn">
            	<?php if ($this->_tpl_vars['CFG']['admin']['banner']['impressions_date']): ?>
					<p><?php echo ((is_array($_tmp=$this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</p>
		            <p><?php echo ((is_array($_tmp=$this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</p>
	            <?php endif; ?>
				<p><?php echo ((is_array($_tmp=$this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</p>
			</td>
            <td> <a href="<?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['edit_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['manage_banner_edit']; ?>
</a>
              <div class="clsPreviewBanner" id="selPreview<?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['add_id']; ?>
" style="display:none;"><?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['source']; ?>
</div>
              <a href="javascript:void(0)" onClick="<?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['preview_onclick']; ?>
"><?php echo $this->_tpl_vars['LANG']['manage_banner_preview']; ?>
</a> <a href="javascript:void(0)" onclick="return populateCode('<?php echo $this->_tpl_vars['populateAdds_arr'][$this->_tpl_vars['inc']]['block']; ?>
')"><?php echo $this->_tpl_vars['LANG']['manage_banner_code']; ?>
</a> </td>
</tr>
          <?php endforeach; endif; unset($_from); ?>
          <tr>
            <td colspan="9"><input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manage_banner_add_delete']; ?>
" onclick="<?php echo $this->_tpl_vars['delete_submit_onclick']; ?>
" />
            <input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manage_banner_add_activate']; ?>
" onclick="<?php echo $this->_tpl_vars['activate_submit_onclick']; ?>
" />
            <input type="button" class="clsSubmitButton" name="toactivate_submit" id="toactivate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manage_banner_add_toactivate']; ?>
" onclick="<?php echo $this->_tpl_vars['inactivate_submit_onclick']; ?>
" /></td>
          </tr>
        </table>
      </div>
	 </div>
        <!-- clsDataDisplaySection - ends here -->
    </form>
    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?> </div>
  <?php endif; ?> </div>
<?php echo '
  <script type="text/javascript">
	function tempalteNav()
		{
			bannerUrl = '; ?>
'<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/manageBanner.php';<?php echo '
			bannerUrl = bannerUrl+\'?template_name=\'+document.getElementById(\'template_name\').value;
			window.location = bannerUrl;
		}
  </script>
'; ?>

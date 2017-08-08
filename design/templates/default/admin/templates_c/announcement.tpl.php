<?php /* Smarty version 2.6.18, created on 2011-10-19 10:46:14
         compiled from announcement.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'announcement.tpl', 27, false),array('modifier', 'date_format', 'announcement.tpl', 127, false),)), $this); ?>
<div id="selManagementAnnouncement">
	<h2>
    	<?php echo $this->_tpl_vars['LANG']['announcement_title']; ?>

    </h2>
    	<div id="selMsgSuccess">
        	<p><?php echo $this->_tpl_vars['LANG']['announcement_note']; ?>
: <?php echo $this->_tpl_vars['LANG']['announcement_note_msg1']; ?>
</p>
        </div>
    	<div id="selMsgSuccess">
        	<p><?php echo $this->_tpl_vars['LANG']['announcement_optimize']; ?>
: <?php echo $this->_tpl_vars['LANG']['announcement_note_msg2']; ?>
</p>
        </div>

	 <!-- information div -->
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('announcement_form')): ?>
    	<form name="form1" id="form1" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" method="post" onsubmit="return <?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] == 'richtext'): ?>getHTMLSource('rte1', 'form1', 'description');<?php else: ?>true<?php endif; ?>">
            <table class="clsNoBorder">
                <tr >
                <th class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('description'); ?>
">
                	<label for="description"><?php echo $this->_tpl_vars['LANG']['announcement_description']; ?>
   </label>
                	<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

                </th>
                <td>
              	  <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('description'); ?>

                  <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('announcement_description','description'); ?>

					<?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] != 'richtext' && $this->_tpl_vars['CFG']['feature']['html_editor'] != 'tinymce'): ?>
						<textarea name="description" id="description" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('description'); ?>
</textarea>
					<?php endif; ?>
					<?php echo $this->_tpl_vars['myobj']->populateHtmlEditor('description'); ?>

                </td>
                </tr>
                <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('from_date'); ?>
" >
                  <th>
				  	<label for="from_date"><?php echo $this->_tpl_vars['LANG']['announcement_from_date']; ?>
</label>
                  	<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

                  </th>
                  <td>
				  	<input type="text" class="clsTextBox" name="from_date" id="from_date" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('from_date'); ?>
" />
				  	<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('from_date',$this->_tpl_vars['calendar_opts_arr']); ?>

				  	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('from_date'); ?>

                  	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('announcement_from','from_date'); ?>

                  </td>
                </tr>
                <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('description'); ?>
" >
                  <th>
				  	<label for="to_date"> <?php echo $this->_tpl_vars['LANG']['announcement_to_date']; ?>
</label>
					<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>

                  </th>
                  <td>
				  	<input type="text" class="clsTextBox" name="to_date" id="to_date" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('to_date'); ?>
" />
					<?php echo $this->_tpl_vars['myobj']->populateDateCalendar('to_date',$this->_tpl_vars['calendar_opts_arr']); ?>

					<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('to_date'); ?>

                  	<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('announcement_to','to_date'); ?>

                  </td>
                </tr>
                <tr>
                    <td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srch_topic_cnt'); ?>
">
                   		<input  type="hidden" value="<?php echo $this->_tpl_vars['myobj']->getFormField('announcement_id'); ?>
" name="announcement_id" id="announcement_id" />
                        <input type="submit" class="clsSubmitButton" name="announcement_submit" id="announcement_submit" value="<?php if ($this->_tpl_vars['myobj']->getFormField('announcement_id') == ''): ?><?php echo $this->_tpl_vars['LANG']['announcement_add']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['announcement_update']; ?>
<?php endif; ?>" />
                       <input type="submit" class="clsCancelButton" name="announcement_cancel"  id="announcement_cancel" value="<?php echo $this->_tpl_vars['LANG']['announcement_cancel']; ?>
" />
                         </td>
                </tr>
            </table>
  </form>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('announcement_list')): ?>
    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>

    <!-- confirmation box -->
    <div id="selMsgConfirm" style="display:none;">
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['confirm_tbl_summary']; ?>
">
				<tr>
					<td colspan="2"><p id="confirmMessage"></p></td>
		         </tr>
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
			<input type="hidden" name="announcement_ids" id="announcement_ids" />
			<input type="hidden" name="action" id="action" />
			<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

		</form>
	</div>
    <!-- confirmation box-->
  <form name="selFormAnnouncement" id="selFormAnnouncement" method="post" action="announcement.php">
    <table>
            <tr>
            	<?php if ($this->_tpl_vars['myobj']->announcement_list['showAnnouncementList']['record_count']): ?>
                    <th  class="clsSelectAll">
                        <input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.selFormAnnouncement.name, document.selFormAnnouncement.check_all.name)"/>                    </th>
               <?php endif; ?>
               <!-- <td>
                	<?php echo $this->_tpl_vars['LANG']['announcement_id']; ?>

                </td>-->
<!--                <th>
                	<?php echo $this->_tpl_vars['LANG']['announcement_description']; ?>

                </th>-->
                <th class="">
                	<?php echo $this->_tpl_vars['LANG']['announcement_from_date']; ?>

                </th>
                <th class="">
                	<?php echo $this->_tpl_vars['LANG']['announcement_to_date']; ?>

                </th>
                <th class=""><?php echo $this->_tpl_vars['LANG']['announcement_status']; ?>
</th>
                <th class="">
                	<?php echo $this->_tpl_vars['LANG']['announcement_action']; ?>

                </th>
            </tr>
            <?php if ($this->_tpl_vars['myobj']->announcement_list['showAnnouncementList']['record_count']): ?>
                <?php $_from = $this->_tpl_vars['myobj']->announcement_list['showAnnouncementList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['salKey'] => $this->_tpl_vars['salValue']):
?>
                    <tr>
                        <td>
                        	<input type="checkbox" class="clsCheckRadio" name="forum_ids[]" value="<?php echo $this->_tpl_vars['salValue']['record']['announcement_id']; ?>
" onClick="disableHeading('selFormAnnouncement');" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/>
                       </td>
<!--            	        <td>
                	   		<?php echo $this->_tpl_vars['salValue']['record']['description']; ?>

                         </td>-->
	                    <td>
                        	<?php echo ((is_array($_tmp=$this->_tpl_vars['salValue']['record']['from_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

                        </td>
                    	<td>
                    		<?php echo ((is_array($_tmp=$this->_tpl_vars['salValue']['record']['to_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

                        </td>
                    	<td>
                        	<?php if ($this->_tpl_vars['salValue']['record']['status'] == 'Yes'): ?>
                            	<?php echo $this->_tpl_vars['LANG']['announcement_active']; ?>

                            <?php else: ?>
                             	<?php echo $this->_tpl_vars['LANG']['announcement_inactive']; ?>

                            <?php endif; ?>
                        </td>
                    	<td>
                    		<a href="<?php echo $this->_tpl_vars['salValue']['edit_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['announcement_edit']; ?>
</a>
                       </td>
                    </tr>
                  <?php endforeach; endif; unset($_from); ?>
                    <tr>
                    <td colspan="7">
                        <select name="action_val" id="action_val" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                        <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_action']; ?>
</option>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->announcement_list['action_arr'],$this->_tpl_vars['myobj']->getFormField('action')); ?>

                        </select>
                    	<input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="<?php echo $this->_tpl_vars['LANG']['announcement_submit']; ?>
" onClick="getMultiCheckBoxValue('selFormAnnouncement', 'check_all', '<?php echo $this->_tpl_vars['LANG']['announcement_err_tip_select_titles']; ?>
');if(multiCheckValue!='') getAction()"/></td>
                    </tr>
            <?php else: ?>
            <tr>
            	<td colspan="6" align="center"><?php echo $this->_tpl_vars['LANG']['announcement_no_record']; ?>
 &nbsp; <a href="announcement.php?action=add"><?php echo $this->_tpl_vars['LANG']['announcement_add']; ?>
</a></td>
            </tr>
            <?php endif; ?>
        </table>
  </form>
    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
  <?php endif; ?>
</div>
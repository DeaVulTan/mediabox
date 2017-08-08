<?php /* Smarty version 2.6.18, created on 2012-01-21 09:21:47
         compiled from membersBrowse.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'membersBrowse.tpl', 32, false),array('modifier', 'truncate', 'membersBrowse.tpl', 232, false),array('modifier', 'capitalize', 'membersBrowse.tpl', 247, false),array('modifier', 'date_format', 'membersBrowse.tpl', 254, false),array('modifier', 'count', 'membersBrowse.tpl', 299, false),array('modifier', 'cat', 'membersBrowse.tpl', 304, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMemberList">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['browse_criteria_title']; ?>
&nbsp;</h2></div>
	<?php if (isMember ( )): ?>
    <div class="clsPaddingLeftRight">
	   	<p class="clsBrowseMemberLink">
       	<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberslist'); ?>
" id="selMemberBrowseLinkID"><?php echo $this->_tpl_vars['LANG']['common_members_list_list_members']; ?>
</a>
	   	<a class="clsBlockUser" href="<?php echo $this->_tpl_vars['myobj']->getUrl('memberblock','','','members'); ?>
" id="selMemberBlockLinkId"><?php echo $this->_tpl_vars['LANG']['members_list_blocked_members']; ?>
</a>
   		</p>
   </div>
   <?php endif; ?>
  	<div class="clsShowHideFilter">
  	   <a href="#" class="clsHideFilterSearch" onclick="showSearchForm();this.blur();return false;" id="anchorToggleSearchForm">
		<span><?php echo $this->_tpl_vars['LANG']['browse']['form_title_anchor_hide_search_form']; ?>
</span></a>
  	</div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	<div id="selSetBrowseCriteria">
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_browse_criteria')): ?>
     	 	<div id="selBrowseCriteria" class="clsDataTable clsMembersBrowseTable clsFriendSearchTable">
   			<form name="formSetBrowseCriteria" id="formSetBrowseCriteria" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
                        <table>
            	<tr>
                	<th colspan="4"><span><?php echo $this->_tpl_vars['LANG']['browse']['form_title']; ?>
</span></th>
                </tr>
                <tr>
                	<td class="clsGenderWiseSearch"><?php echo $this->_tpl_vars['LANG']['browse']['gender_title']; ?>
</td>
                  	<td colspan="3" class="clsCheckBoxList">
                    	<p>
							<span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" name="gender" id="women" value="female" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['female']; ?>
/></span>
                        	<label for="women"><?php echo $this->_tpl_vars['LANG']['browse']['gender_women']; ?>
</label>
						</p>
                        <p>
							<span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" name="gender" id="men" value="male" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['male']; ?>
/></span>
                        	<label for="men"><?php echo $this->_tpl_vars['LANG']['browse']['gender_men']; ?>
</label>
						</p>
                        <p>
							<span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" name="gender" id="both" value="both" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['both']; ?>
/></span>
                        	<label for="both"><?php echo $this->_tpl_vars['LANG']['browse']['gender_both']; ?>
</label>
						</p>
                  	</td>
                </tr>
                <tr>
                	<td><label for="age_prefer_yes"><?php echo $this->_tpl_vars['LANG']['browse']['age']; ?>
</label></td>
                  	<td colspan="3">
                    	<p>
                    		<input type="radio" class="clsCheckRadio clsNoBorder" name="age_prefer" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['agePreferYes']; ?>
 id="age_prefer_yes" value="1" onclick="agePreferOptions()" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                      		<select name="age_start" id="age_start" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                        		<option value=''><?php echo $this->_tpl_vars['LANG']['members_choose']; ?>
</option>
                        		<?php $_from = $this->_tpl_vars['myobj']->form_browse_criteria['ageSetStart_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                        		<option value='<?php echo $this->_tpl_vars['value']['values']; ?>
' <?php echo $this->_tpl_vars['value']['selected']; ?>
><?php echo $this->_tpl_vars['value']['values']; ?>
</option>
                        		<?php endforeach; endif; unset($_from); ?>                        		
                      		</select>
                      		<label for="age_end"><?php echo $this->_tpl_vars['LANG']['browse_and']; ?>
</label>
                      		<select name="age_end" id="age_end" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" >
                        		<option value=''><?php echo $this->_tpl_vars['LANG']['members_choose']; ?>
</option>
                        		<?php $_from = $this->_tpl_vars['myobj']->form_browse_criteria['ageSetEnd_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                        		<option value='<?php echo $this->_tpl_vars['value']['values']; ?>
' <?php echo $this->_tpl_vars['value']['selected']; ?>
><?php echo $this->_tpl_vars['value']['values']; ?>
</option>
                        		<?php endforeach; endif; unset($_from); ?>
                      		</select>
                    	</p>
                    	<p><span class="clsCheckBox"><input type="radio" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsCheckRadio clsNoBorder" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['agePreferNo']; ?>
 name="age_prefer" id="age_prefer_no" value="0" onclick="agePreferOptions()"/><label for="age_prefer_no"><?php echo $this->_tpl_vars['LANG']['browse']['age_no_preference']; ?>
</label></span></p>
                    </td>
                </tr>
                <tr>
                	<td><p><?php echo $this->_tpl_vars['LANG']['browse']['relation_status']; ?>
&nbsp;&nbsp;</p></td>
                  	<td colspan="3" class="clsCheckBoxList">
                  		<?php $_from = $this->_tpl_vars['myobj']->form_browse_criteria['relation_status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                       		<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckBox clsNoBorder" name="<?php echo $this->_tpl_vars['value']['field_name']; ?>
[]" id="<?php echo $this->_tpl_vars['value']['id']; ?>
" value="<?php echo $this->_tpl_vars['value']['values']; ?>
" <?php echo $this->_tpl_vars['value']['checked']; ?>
 tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></span><label for="<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['value']['description']; ?>
</label></p>
                   		<?php endforeach; endif; unset($_from); ?>
                   	</td>
                </tr>
                <tr>
                	<td colspan="4"> <h4><?php echo $this->_tpl_vars['LANG']['browse']['location']; ?>
</h4></td>
                </tr>
                <tr>
                	<td><p><label for="country"><?php echo $this->_tpl_vars['LANG']['browse']['country']; ?>
</label>&nbsp;&nbsp;</p></td>
                  	<td colspan="3">
                      <select name="country" id="country" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                        <?php echo $this->_tpl_vars['myobj']->populateUserCountriesList($this->_tpl_vars['myobj']->getFormField('country')); ?>

                      </select>
                    </td>
                </tr>
                <?php if ($this->_tpl_vars['myobj']->block_show_htmlfields): ?>
                <?php unset($this->_sections['quest_cat']);
$this->_sections['quest_cat']['name'] = 'quest_cat';
$this->_sections['quest_cat']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->block_show_htmlfields) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['quest_cat']['show'] = true;
$this->_sections['quest_cat']['max'] = $this->_sections['quest_cat']['loop'];
$this->_sections['quest_cat']['step'] = 1;
$this->_sections['quest_cat']['start'] = $this->_sections['quest_cat']['step'] > 0 ? 0 : $this->_sections['quest_cat']['loop']-1;
if ($this->_sections['quest_cat']['show']) {
    $this->_sections['quest_cat']['total'] = $this->_sections['quest_cat']['loop'];
    if ($this->_sections['quest_cat']['total'] == 0)
        $this->_sections['quest_cat']['show'] = false;
} else
    $this->_sections['quest_cat']['total'] = 0;
if ($this->_sections['quest_cat']['show']):

            for ($this->_sections['quest_cat']['index'] = $this->_sections['quest_cat']['start'], $this->_sections['quest_cat']['iteration'] = 1;
                 $this->_sections['quest_cat']['iteration'] <= $this->_sections['quest_cat']['total'];
                 $this->_sections['quest_cat']['index'] += $this->_sections['quest_cat']['step'], $this->_sections['quest_cat']['iteration']++):
$this->_sections['quest_cat']['rownum'] = $this->_sections['quest_cat']['iteration'];
$this->_sections['quest_cat']['index_prev'] = $this->_sections['quest_cat']['index'] - $this->_sections['quest_cat']['step'];
$this->_sections['quest_cat']['index_next'] = $this->_sections['quest_cat']['index'] + $this->_sections['quest_cat']['step'];
$this->_sections['quest_cat']['first']      = ($this->_sections['quest_cat']['iteration'] == 1);
$this->_sections['quest_cat']['last']       = ($this->_sections['quest_cat']['iteration'] == $this->_sections['quest_cat']['total']);
?>
                <tr><th colspan="4"><span><?php echo $this->_tpl_vars['myobj']->block_show_htmlfields[$this->_sections['quest_cat']['index']]['title']; ?>
</span></th></tr>
                <?php $_from = $this->_tpl_vars['myobj']->block_show_htmlfields[$this->_sections['quest_cat']['index']]['questions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
         			<?php if ($this->_tpl_vars['value']['question_type'] == 'text'): ?>
                		<tr>
                    		<td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
">
                        		<label for="<?php echo $this->_tpl_vars['value']['question']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label>
                    		</td>
                    		<td colspan="3" class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
                            	<?php $this->assign('temp_name', $this->_tpl_vars['value']['id']); ?>
                    			<input type="text" class="clsTextBox" name="<?php echo $this->_tpl_vars['value']['id']; ?>
" id="<?php echo $this->_tpl_vars['value']['question']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php if ($_POST): ?><?php echo $_POST[$this->_tpl_vars['temp_name']]; ?>
<?php endif; ?>" maxlength="<?php echo $this->_tpl_vars['value']['max_length']; ?>
" style="<?php echo $this->_tpl_vars['value']['width']; ?>
"/>
                    			<div class="clsHelpText" id="<?php echo $this->_tpl_vars['value']['question']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
                    		</td>
                		</tr>
        			<?php endif; ?>
	        		<?php if ($this->_tpl_vars['value']['question_type'] == 'textarea'): ?>
	                	<tr>
	                		<td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="<?php echo $this->_tpl_vars['value']['question']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	                    	<td colspan="3" class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
                            	<?php $this->assign('temp_name', $this->_tpl_vars['value']['id']); ?> 
	                    		<textarea class="clsTextBox" name="<?php echo $this->_tpl_vars['value']['id']; ?>
" id="textArea_<?php echo $this->_tpl_vars['value']['id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="<?php echo $this->_tpl_vars['value']['rows']; ?>
" style="<?php echo $this->_tpl_vars['value']['width']; ?>
"><?php if ($_POST): ?><?php echo $_POST[$this->_tpl_vars['temp_name']]; ?>
<?php endif; ?></textarea>
	                    		<div class="clsHelpText" id="textArea_<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	                    	</td>
	                	</tr>
	        		<?php endif; ?>
	        		<?php if ($this->_tpl_vars['value']['question_type'] == 'password'): ?>
	                	<tr>
	                		<td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="<?php echo $this->_tpl_vars['value']['question']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	                    	<td colspan="3" class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
                            	<?php $this->assign('temp_name', $this->_tpl_vars['value']['id']); ?> 
	                    		<input type="password" class="clsTextBox" name="<?php echo $this->_tpl_vars['value']['id']; ?>
" id="<?php echo $this->_tpl_vars['value']['question']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php if ($_POST): ?><?php echo $_POST[$this->_tpl_vars['temp_name']]; ?>
<?php endif; ?>" maxlength="<?php echo $this->_tpl_vars['value']['max_length']; ?>
"/>
	                    		<div class="clsHelpText" id="<?php echo $this->_tpl_vars['value']['question']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	                    	</td>
	                	</tr>
	        		<?php endif; ?>
	        		<?php if ($this->_tpl_vars['value']['question_type'] == 'radio'): ?>
	        			<tr>
	            			<td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	            			<td colspan="3" class="clsCheckBoxList">
	            				<?php $_from = $this->_tpl_vars['value']['option_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
	              				<?php $this->assign('checkboxId', $this->_tpl_vars['value']['id']); ?>
	                           	<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio clsNoBorder" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" id="opt_<?php echo $this->_tpl_vars['ssokey']; ?>
_<?php echo $this->_tpl_vars['value']['id']; ?>
" name="<?php echo $this->_tpl_vars['value']['id']; ?>
[]"
							   	<?php 
	            			   		$obj_ref = $this->get_template_vars('myobj');
	            					if(in_array($this->get_template_vars('ssovalue'),$obj_ref->getFormField($this->get_template_vars('checkboxId')))) { echo 'checked="checked"'; }
	            				 ?>
	         					value="<?php echo $this->_tpl_vars['ssovalue']; ?>
" /></span><label for="opt_<?php echo $this->_tpl_vars['ssokey']; ?>
_<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['ssovalue']; ?>
</label></p>
	            				<?php endforeach; endif; unset($_from); ?>
	            				<div class="clsHelpText" id="opt_<?php echo $this->_tpl_vars['ssovalue']['ssokey']; ?>
_<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	            			</td>
	        			</tr>
	        		<?php endif; ?>
	        		<?php if ($this->_tpl_vars['value']['question_type'] == 'checkbox'): ?>
	        			<tr>
	            			<td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	            			<td colspan="3" class="clsCheckBoxList" align="left">
			        			<?php $_from = $this->_tpl_vars['value']['option_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ssokey'] => $this->_tpl_vars['ssovalue']):
?>
			        			<?php $this->assign('checkboxId', $this->_tpl_vars['value']['id']); ?>
			        			<p><span class="clsCheckBox"><input type="checkbox" class="clsCheckRadio clsNoBorder" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" id="opt_<?php echo $this->_tpl_vars['ssokey']; ?>
_<?php echo $this->_tpl_vars['value']['id']; ?>
" name="<?php echo $this->_tpl_vars['value']['id']; ?>
[]"
					            <?php 
			        				$obj_ref = $this->get_template_vars('myobj');
			        				if(in_array($this->get_template_vars('ssovalue'),$obj_ref->getFormField($this->get_template_vars('checkboxId')))) { echo 'checked="checked"'; }
			        			 ?>
			      				value="<?php echo $this->_tpl_vars['ssovalue']; ?>
" /></span><label for="opt_<?php echo $this->_tpl_vars['ssokey']; ?>
_<?php echo $this->_tpl_vars['value']['id']; ?>
"><?php echo $this->_tpl_vars['ssovalue']; ?>
</label></p>
			        			<?php endforeach; endif; unset($_from); ?>
	            				<div class="clsHelpText" id="opt_<?php echo $this->_tpl_vars['ssovalue']['ssokey']; ?>
_<?php echo $this->_tpl_vars['value']['id']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	            			</td>
	        			</tr>
	        		<?php endif; ?>
	        		<?php if ($this->_tpl_vars['value']['question_type'] == 'select'): ?>
	        			<tr>
	            			<td class="<?php echo $this->_tpl_vars['value']['label_cell_class']; ?>
"><label for="<?php echo $this->_tpl_vars['value']['question']; ?>
"><?php echo $this->_tpl_vars['value']['question']; ?>
</label></td>
	            			<td colspan="3" class="<?php echo $this->_tpl_vars['value']['field_cell_class']; ?>
">
	            			<select class="clsMemberBrowseSelect" name="<?php echo $this->_tpl_vars['value']['id']; ?>
[]" id="<?php echo $this->_tpl_vars['value']['question']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" multiple="multiple" size="<?php echo $this->_tpl_vars['CFG']['admin']['members']['browse_members_select_box_size']; ?>
">
		                		<?php $_from = $this->_tpl_vars['myobj']->multiSelectPopulateArray($this->_tpl_vars['value']['option_arr']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['sovalue']):
?>
		                			<?php $this->assign('selectId', $this->_tpl_vars['value']['id']); ?>
		                			<?php $this->assign('optval', $this->_tpl_vars['sovalue']['values']); ?>
		                			<option value="<?php echo $this->_tpl_vars['sovalue']['values']; ?>
"
		                			<?php 
		                 			$obj_ref = $this->get_template_vars('myobj');
		                  			if(in_array($this->get_template_vars('optval'),$obj_ref->getFormField($this->get_template_vars('selectId')))) { echo 'selected="selected"'; }
		                			 ?> ><?php echo $this->_tpl_vars['sovalue']['optionvalue']; ?>
</option>
		                		<?php endforeach; endif; unset($_from); ?>
	            			</select>
	            			<div class="clsHelpText" id="<?php echo $this->_tpl_vars['value']['question']; ?>
_Help" style="visibility:hidden"><?php echo $this->_tpl_vars['value']['instruction']; ?>
</div>
	            			</td>
	        			</tr>
	        		<?php endif; ?>
        		<?php endforeach; endif; unset($_from); ?>
                <?php endfor; endif; ?>
                <?php endif; ?>
                <tr>
                	<td><h4><?php echo $this->_tpl_vars['LANG']['browse']['field_sortresult_title']; ?>
</h4></td>
                  	<td colspan="3" class="clsCheckBoxList">
                    	<input type="hidden" value="<?php echo $this->_tpl_vars['myobj']->question_ids; ?>
" name="question_ids"/>
                      	<p>
						  <span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" name="sort_result" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['last_active']; ?>
 value="last_active" id="sort_result_last_active"/></span>
                      	  <label for="sort_result_last_active"><?php echo $this->_tpl_vars['LANG']['browse']['field_sortresult_recent']; ?>
</label>
						</p>
                      	<p>
						  <span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" name="sort_result" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['last_logged']; ?>
 value="last_logged" id="sort_result_last_logged"/></span>
                      	  <label for="sort_result_last_logged"><?php echo $this->_tpl_vars['LANG']['browse']['field_sortresult_last_logged']; ?>
</label>
						</p>
                      	<p>
						  <span class="clsCheckBox"><input type="radio" class="clsCheckRadio clsNoBorder" name="sort_result" <?php echo $this->_tpl_vars['myobj']->form_browse_criteria['doj']; ?>
 value="doj" id="sort_result_doj"/></span>
                      	  <label for="sort_result_doj"><?php echo $this->_tpl_vars['LANG']['browse']['field_sortresult_new_to_rayzz']; ?>
</label>
						</p>
                  	</td>
                </tr>
                <tr>
                	<td colspan="4">
                    	<div class="clsListSubmitLeft"><div class="clsListSubmitRight"><input type="submit" class="clsSubmitButton" name="browse_submit" id="browse_submit" value="<?php echo $this->_tpl_vars['LANG']['browse_submit']; ?>
" /></div></div><div class="clsCancelMargin"><div class="clsListCancelLeft"><div class="clsListCancelRight"><input type="reset" class="clsSubmitButton" name="browse_reset" id="browse_reset" value="<?php echo $this->_tpl_vars['LANG']['browse_reset']; ?>
" /></div></div></div>
                    </td>
                </tr>
            </table>
              			</form>
 		 	</div>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_list_members')): ?>
   			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('show_result_heading')): ?>
  				<h2 class="clsBrowseResult"><?php echo $this->_tpl_vars['LANG']['browse']['search_title_result']; ?>
</h2>
   			<?php endif; ?>
  			<div id="selMembersListing">
				<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                	<?php if ($this->_tpl_vars['smarty_paging_list']): ?>
				  <div class="clsTopPagination">	
         			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				  </div>	
                  <?php endif; ?>
        		<?php endif; ?>
        		<div class="clsMemberListTable clsListTable clsMemberListMainTable">
		    	<table summary="<?php echo $this->_tpl_vars['LANG']['member_list_tbl_summary']; ?>
" id="selMembersBrowseTable" class="clsMembersDisplayTbl clsContentsDisplayTbl">

			 		<?php $_from = $this->_tpl_vars['myobj']->form_list_members['displayMembers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['values']):
?>
  						<?php if ($this->_tpl_vars['values']['open_tr']): ?>
                    		<tr>
                    	<?php endif; ?>
                        	<td class="selPhotoGallery">
                            <ul class="clsMembersPhotoListDisplay">
                              <li id="memberlist_videoli_<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="showVideoDetail(this)" onmouseout="hideVideoDetail(this)">
                                 	<div class="clsUserMenuContainer selMemberName">
                                    	<div class="clsMemberImageContainer">
                                            	<a class="ClsImageContainer ClsImageBorder2 Cls90x90" href="<?php echo $this->_tpl_vars['values']['memberProfileUrl']; ?>
" >
		                                        	<img src="<?php echo $this->_tpl_vars['values']['profileIcon']['t_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['values']['record']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 9) : smarty_modifier_truncate($_tmp, 9)); ?>
" title="<?php echo $this->_tpl_vars['values']['record']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['values']['profileIcon']['t_width'],$this->_tpl_vars['values']['profileIcon']['t_height']); ?>
 />
		                                        </a>
                            					<p class="selMemberName clsPaddingTop9"><a href="<?php echo $this->_tpl_vars['values']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['values']['record']['user_name']; ?>
</a></p>
                                            <a href="#" class="clsMemberInfo clsDisplayNone" id="memberlist_info_<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="showVideoDetail(this)"></a>
                                        </div>
                                     </div>
                                   <?php if ($this->_tpl_vars['CFG']['admin']['members_listing']['online_status']): ?>
								   	  <p class="clsOnline"><a class="<?php echo $this->_tpl_vars['values']['onlineStatusClass']; ?>
" title="<?php echo $this->_tpl_vars['values']['currentStatus']; ?>
"><?php echo $this->_tpl_vars['values']['currentStatus']; ?>
</a></p>
								   <?php endif; ?>
                                                                     
                                <div class="clsPopInfoWidth clsPopInfo clsDisplayNone  <?php if ($this->_tpl_vars['values']['end_tr']): ?> clsPopInfoRight <?php endif; ?>" id="memberlist_selVideoDetails_<?php echo $this->_tpl_vars['inc']; ?>
">
                                  <div class="clsPopUpDivContainer <?php if ($this->_tpl_vars['values']['end_tr']): ?> clsPopUpDivLastContainer <?php endif; ?>"> <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                        <div class="clsPopUpPaddingContent">
                                          <p class="clsPopUpInnerContainer"><a href="<?php echo $this->_tpl_vars['values']['memberProfileUrl']; ?>
" <?php echo $this->_tpl_vars['values']['online']; ?>
><?php echo $this->_tpl_vars['values']['record']['user_name']; ?>
</a> <?php echo $this->_tpl_vars['values']['userLink']; ?>
 | <strong> <span><?php echo $this->_tpl_vars['values']['record']['age']; ?>
</span>, <span><?php echo ((is_array($_tmp=$this->_tpl_vars['values']['record']['sex'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span>,</strong> <span><?php echo $this->_tpl_vars['values']['country']; ?>
</span></p>
                                          <div class="clsOverflow">
                                             <div class="clsPopUpInnerContainer clsPopUpContentBtm"> 
                                                <?php if ($this->_tpl_vars['myobj']->listDetails): ?>
                                                    <?php echo $this->_tpl_vars['LANG']['member_browse_member_joined']; ?>
:&nbsp;
                                                    <span>
                                                        <?php if ($this->_tpl_vars['values']['record']['doj'] != '0000-00-00 00:00:00'): ?>
                                                            <?php echo ((is_array($_tmp=$this->_tpl_vars['values']['record']['doj'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

                                                        <?php endif; ?>
                                                    </span>
                                                    &nbsp; | &nbsp;
                                                <?php endif; ?>                                                    <?php echo $this->_tpl_vars['LANG']['members_browse_member_last_login']; ?>
:&nbsp;
                                                    <span>
                                                        <?php if ($this->_tpl_vars['values']['last_logged'] != '0000-00-00 00:00:00'): ?>
                                                            <?php echo ((is_array($_tmp=$this->_tpl_vars['values']['last_logged'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

                                                        <?php else: ?>
                                                            <?php echo $this->_tpl_vars['LANG']['members_browse_member_first_login']; ?>

                                                        <?php endif; ?> 
                                                    </span> 
                                            </div>
                                             <div id="selMemDetails" class="clsMembersList clsPopUpContentRight"> 
                                                <?php if (isMember ( )): ?>
                                                      <?php if ($this->_tpl_vars['CFG']['user']['user_id'] != $this->_tpl_vars['values']['record']['user_id']): ?>
                                                          <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['values']['mailComposeUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
</a></p>
                                                          <?php if ($this->_tpl_vars['values']['friend'] == 'yes'): ?>
                                                          <p id="selAlReadyFriend"><a class="clsAlreadyFriend" title="<?php echo $this->_tpl_vars['LANG']['members_list_friend']; ?>
" class="clsPhotoVideoEditLinks"><?php echo $this->_tpl_vars['LANG']['members_list_friend']; ?>
</a></p>
                                                          <?php else: ?>
                                                          <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['values']['friendAddUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
</a></p>
                                                          <?php endif; ?>                                     
                                                      <?php endif; ?>          
                                                  
                                                  <?php else: ?>
                                                      <p id="selSendMsg"><a class="clsSendMessage clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['values']['mailComposeUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_send_message']; ?>
</a></p>
                                                      <p id="selAddFriend"><a class="clsAddToFriends clsPhotoVideoEditLinks" href="<?php echo $this->_tpl_vars['values']['friendAddUrl']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
"><?php echo $this->_tpl_vars['LANG']['member_list_add_friend']; ?>
</a></p>
                                                  <?php endif; ?> 
                                              </div>
                                           </div>	  
                                        </div>
                                        <div class="clsPopInfo-bottom">
                                          <div class="clsPopUpPaddingContentBtm clsOverflow">
                                            <div class="clsPopUpContentLeft">
                                               <?php if ($this->_tpl_vars['myobj']->listDetails): ?>
                                                                                                         <?php $this->assign('break_count', 0); ?>
                                                         <ul class="clsMemberPopUpBox">
                                                            <?php if ($this->_tpl_vars['myobj']->friendsCount): ?>
                                                            	<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
																<li>
                                                                <?php echo $this->_tpl_vars['LANG']['browse_result_user_friends']; ?>
:
                                                                <?php if ($this->_tpl_vars['values']['record']['total_friends'] > 0): ?> <a href="<?php echo $this->_tpl_vars['values']['viewfriendsUrl']; ?>
" title="<?php echo $this->_tpl_vars['values']['friend_icon_title']; ?>
"><?php echo $this->_tpl_vars['values']['record']['total_friends']; ?>
</a> <?php else: ?> <span><?php echo $this->_tpl_vars['values']['record']['total_friends']; ?>
</span> <?php endif; ?> </li>                                                
                                                             <?php endif; ?> 
                                                                <?php $this->assign('totcnt', count($this->_tpl_vars['CFG']['site']['modules_arr'])); ?>
                                                                <?php $this->assign('totcnt', $this->_tpl_vars['totcnt']-1); ?>                                                                    
                                                                <?php $_from = $this->_tpl_vars['CFG']['site']['modules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module_value']):
?>
                                                                      <?php if (chkAllowedModule ( array ( $this->_tpl_vars['module_value'] ) )): ?>
                                                                          <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                                                                          <?php $this->assign('total_stats', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_icon_title') : smarty_modifier_cat($_tmp, '_icon_title'))); ?>
                                                                          <?php $this->assign('icon_url', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'ListUrl') : smarty_modifier_cat($_tmp, 'ListUrl'))); ?>
                                                                            <?php $this->assign('total_stats_value', ((is_array($_tmp=((is_array($_tmp='total_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['module_value']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['module_value'])))) ? $this->_run_mod_handler('cat', true, $_tmp, 's') : smarty_modifier_cat($_tmp, 's'))); ?>						   
                                                                          <?php $this->assign('image1_exists', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_image1_exists') : smarty_modifier_cat($_tmp, '_image1_exists'))); ?>
                                                                          <?php $this->assign('image2_exists', ((is_array($_tmp=$this->_tpl_vars['module_value'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_image2_exists') : smarty_modifier_cat($_tmp, '_image2_exists'))); ?>
                                                                          
                                                                          <li class="clsListValues"><?php echo $this->_tpl_vars['values'][$this->_tpl_vars['total_stats_value']]; ?>
</li>
                                                                          <?php if (( $this->_tpl_vars['break_count'] > 3 && $this->_tpl_vars['totcnt'] != $this->_tpl_vars['inc'] )): ?>
                                                                                </ul>
                                                                                <ul class="clsMemberPopUpBox">
                                                                                <?php $this->assign('break_count', 0); ?>
                                                                          <?php endif; ?>
                                                                          
                                                                       <?php endif; ?>
                                                                <?php endforeach; endif; unset($_from); ?>                                        
                                                         </ul>
                                                                                                            <?php endif; ?>                                              
                                              </div>                        
                                          </div>
                                        </div>
                                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
                                </div>
                                
                                                                     
                                     
                              </li>
                            </ul>
						 	</td>
 					 	<?php if ($this->_tpl_vars['values']['end_tr']): ?>
                       		</tr>
                     	<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					<?php if ($this->_tpl_vars['myobj']->final_tr_close): ?>
                    	<td colspan="<?php echo $this->_tpl_vars['myobj']->member_per_row; ?>
">&nbsp;</td>
                    	</tr>
                    <?php endif; ?>
    		</table>
		<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
           <?php if ($this->_tpl_vars['smarty_paging_list']): ?>
             <div class="clsMarginRight10">	
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
             </div>	
           <?php endif; ?>
        <?php endif; ?>
        </div>
    </div>
	<?php endif; ?></div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->resultFound): ?>
	<script type="text/javascript">
		showSearchForm();
	</script>
<?php endif; ?>
<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/videoDetailsToolTip.js"></script>
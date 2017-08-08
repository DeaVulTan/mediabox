<?php /* Smarty version 2.6.18, created on 2012-01-21 11:39:57
         compiled from relationManage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'relationManage.tpl', 27, false),array('modifier', 'truncate', 'relationManage.tpl', 85, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selManageFriends">
	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['managerelations_title']; ?>
&nbsp;-&nbsp;<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['managerelations_title_invite']; ?>
</a></h2></div>
<div class="clsNoteMessage">
   <span class="clsNoteTitle"><?php echo $this->_tpl_vars['LANG']['managerelations_note']; ?>
</span>:&nbsp;<?php echo $this->_tpl_vars['LANG']['managerelations_info']; ?>

</div>
 	<div id="selTwoColumn">
    	<div id="selLeftNavigation">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_info')): ?>
				<div id="selMsgAlert">
					<p><?php echo $this->_tpl_vars['LANG']['msg_no_friends']; ?>
</p>
					<p><?php echo $this->_tpl_vars['LANG']['managerelations_link_add_friends_start']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('membersinvite','','','members'); ?>
"><?php echo $this->_tpl_vars['LANG']['managerelations_link_add_friends_text']; ?>
</a>&nbsp;<?php echo $this->_tpl_vars['LANG']['managerelations_link_add_friends_end']; ?>
</p>
				</div>
			<?php endif; ?>

			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_search_friend')): ?>
				<div id="selFriendSearch" class="clsListTable clsFriendSearchTable">
			        					<form name="formFriendSearch" id="formFriendSearch" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('relationmanage','','','members'); ?>
">
						<table summary="<?php echo $this->_tpl_vars['LANG']['managerelations_search_table']; ?>
" class="clsFriendsSearchTable">
							<tr>
								<td><label for="uname"><?php echo $this->_tpl_vars['LANG']['common_username']; ?>
</label></td>
								<td><label for="email"><?php echo $this->_tpl_vars['LANG']['managerelations_search_email']; ?>
</label></td>
								<td><label for="tagz"><?php echo $this->_tpl_vars['LANG']['managerelations_search_tags']; ?>
</label></td>
								<td rowspan="2" style="vertical-align:bottom"><div class="clsListSubmitLeft"><div class="clsListSubmitRight"><input type="submit" class="clsSubmitButton" value="search" name="friendSearch" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></div></div></td>
							</tr>
							<tr>
								<td><input type="text" class="clsFriendsTextBox" name="uname" id="uname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('uname'); ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['fieldsize']['username']['max']; ?>
"/></td>
								<td><input type="text" class="clsFriendsTextBox" name="email" id="email" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
								<td><input type="text" class="clsFriendsTextBox" name="tagz" id="tagz" value="<?php echo $this->_tpl_vars['myobj']->getFormField('tagz'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
							</tr>
							<tr>
								<td colspan="4"><label for="srch_relation"><?php echo $this->_tpl_vars['LANG']['managerelations_search_relation']; ?>
</label></td>
							</tr>
							<tr>
								<td colspan="4">
									<select id="srch_relation" name="srch_relation" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
										<option value=""><?php echo $this->_tpl_vars['LANG']['managerelations_select_relation']; ?>
</option>
			                        	<?php echo $this->_tpl_vars['myobj']->populateRelations($this->_tpl_vars['myobj']->getFormField('srch_relation')); ?>

			                        </select>
								</td>
							</tr>
						</table>
					</form>
			        				</div>
			<?php endif; ?>

			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_list_friends')): ?>
			    <?php if ($this->_tpl_vars['myobj']->form_list_friends['totalFriends']): ?>

					<div id="selPomptDialog" title="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" style="display:none;">
						<form>
							<label for="name"><?php echo $this->_tpl_vars['LANG']['managerelations_javascript_new_relation']; ?>
</label>
							<input type="text" name="newRelation" id="newRelation" class="text ui-widget-content ui-corner-all" />
						</form>
					</div>

			        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
					   <?php if ($this->_tpl_vars['smarty_paging_list']): ?>
						 <div class="clsTopPagination"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
					   <?php endif; ?>			           
			        <?php endif; ?>
                     <?php $this->assign('count', 1); ?>
			        <div id="selShowFriends" class="clsDataTable clsMembersDataTable">
			            <form name="form_show_friends" id="selShowFriends" method="post" action="<?php echo $this->_tpl_vars['myobj']->getUrl('relationmanage','','','members'); ?>
" autocomplete="off">
			                <table border="0" summary="<?php echo $this->_tpl_vars['LANG']['managerelations_tbl_summary']; ?>
">
			                    <tr>
			                        <th class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" id="checkall" onclick="selectAll(this.form)" name="checkall" value="" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></th>
			                        <th><?php echo $this->_tpl_vars['LANG']['managerelations_friend_name']; ?>
</th>
			                        <th><?php echo $this->_tpl_vars['LANG']['managerelations_relation_name']; ?>
</th>
			                        <th><?php echo $this->_tpl_vars['LANG']['managerelations_action']; ?>
</th>
			                    </tr>
			                    <?php $_from = $this->_tpl_vars['displayMyFriends_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dmfValue']):
?>
			                        <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
 <?php if ($this->_tpl_vars['count'] % 2 == 0): ?> clsAlternateRecord<?php endif; ?>">
			                            <td class="clsFriendsCheckbox"><input type="checkbox" class="clsCheckRadio" name="friendship_ids[]" value="<?php echo $this->_tpl_vars['dmfValue']['record']['friendship_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"  onClick="checkCheckBox(this.form, 'checkall');"/></td>
			                            <td id="selPhotoGallery" class="clsFriendsNameWidth">
			                                <div class="clsOverflow">
												<p id="selImageBorder" class="clsViewThumbImage">
			                                		<div class="clsThumbImageContainer clsMemberImageContainer">
			                                			<div class="clsThumbImageContainer">
			                                    			<a class="ClsImageContainer ClsImageBorder2 Cls45x45" href="<?php echo $this->_tpl_vars['dmfValue']['friendProfileUrl']; ?>
">
						                                		<img src="<?php echo $this->_tpl_vars['dmfValue']['icon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['dmfValue']['record']['friend_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['dmfValue']['icon']['s_width'],$this->_tpl_vars['dmfValue']['icon']['s_height']); ?>
/>
															</a>
			                                        	</div>
			                                        </div>
			                                	</p>
											</div>
			                                <p id="selMemberName" class="clsGroupSmallImg"><a href="<?php echo $this->_tpl_vars['dmfValue']['friendProfileUrl']; ?>
"><?php echo $this->_tpl_vars['dmfValue']['record']['friend_name']; ?>
</a></p>
			                            </td>
			                            <td class="clsFriendsRelation">
			                                <?php echo $this->_tpl_vars['dmfValue']['record']['relation_name']; ?>

			                            </td>
			                            <td><!--if(this.value.length>0)-->
			                                <select name="singleSelect[]" onchange="submit()">
			                                	<option value="" style="text-align:center">-Manage-&nbsp;&nbsp;</option>
			                                    <?php echo $this->_tpl_vars['myobj']->populateMoveToRelations($this->_tpl_vars['dmfValue']['record']['friendship_id'],$this->_tpl_vars['dmfValue']['relation']); ?>

			                                </select>
			                            </td>
				                    </tr>
									<?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
			                    <?php endforeach; endif; unset($_from); ?>
			                    <tr>
			                    	<td></td>
			                        <td colspan="3" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('relation_id'); ?>
">
			                            <div class="clsMailSelectBox"><select name="relation_id" id="relation_id" onchange="addNewRelation(this)" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
			                                <option value=""><?php echo $this->_tpl_vars['LANG']['managerelations_select_relation']; ?>
&nbsp;&nbsp;</option>
			                                <?php echo $this->_tpl_vars['myobj']->populateRelations($this->_tpl_vars['myobj']->getFormField('relation_id')); ?>

			                                <optgroup label="<?php echo $this->_tpl_vars['LANG']['managerelations_new_relation_optgroup']; ?>
"></optgroup>
			                                <option value="add"><?php echo $this->_tpl_vars['LANG']['managerelations_new_relation']; ?>
</option>
			                            </select><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('relation_id'); ?>
</div>
			                            <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="managerelations_submit" id="managerelations_submit" value="<?php echo $this->_tpl_vars['LANG']['managerelations_submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="if(!getMultiCheckBoxValue('form_show_friends', 'check_all', '<?php echo $this->_tpl_vars['LANG']['managerelations_select_friends']; ?>
'))  <?php echo ' { '; ?>
  return false;  <?php echo ' } '; ?>
 if(!document.form_show_friends.relation_id.value) <?php echo ' { '; ?>
 alert_manual('<?php echo $this->_tpl_vars['LANG']['managerelations_select_relation']; ?>
'); return false; <?php echo ' } '; ?>
"/></div></div>

			                        </td>
			                    </tr>
			                </table>
			                <input type="hidden" name="new_relation" id="new_relation" value="<?php echo $this->_tpl_vars['myobj']->getFormField('new_relation'); ?>
" />
			                <input type="hidden" name="uname" id="uname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('uname'); ?>
" />
			                <input type="hidden" name="email" id="email" value="<?php echo $this->_tpl_vars['myobj']->getFormField('email'); ?>
" />
			                <input type="hidden" name="search_enable" id="search_enable" value="<?php echo $this->_tpl_vars['myobj']->getFormField('search_enable'); ?>
" />
			                <input type="hidden" name="tagz" id="tagz" value="<?php echo $this->_tpl_vars['myobj']->getFormField('tagz'); ?>
" />
			            </form>
				        <?php echo '
				            <script type="text/javascript">
				            	var index = document.form_show_friends.relation_id.options.length;
				            </script>
				        '; ?>

			        </div>

			        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
					<?php if ($this->_tpl_vars['smarty_paging_list']): ?>
					  <div class="clsPaddingRightBottom">
						 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					  </div>	
					<?php endif; ?>  			            
			        <?php endif; ?>
			    <?php else: ?>
			        <div id="selMsgError">
			            <p><?php echo $this->_tpl_vars['LANG']['managerelations_search_msg_no_records']; ?>
</p>
			        </div>
			    <?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
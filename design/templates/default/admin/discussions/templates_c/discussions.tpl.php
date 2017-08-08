<?php /* Smarty version 2.6.18, created on 2011-10-19 10:46:54
         compiled from discussions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'discussions.tpl', 20, false),)), $this); ?>
<div id="selDiscussions" class="clsDiscussions">
  <div class="clsDiscussionMyTitleHeading">
    <div class="clsDiscussionTitleHeading">
      <h2 id="selDiscussionTitle"><?php echo $this->_tpl_vars['LANG']['discussions_pagetitle']; ?>
</h2>
      <div id="selMisNavLinks">
			<ul>
			  	<li class="clsNoArrow"><?php echo $this->_tpl_vars['myobj']->page_title; ?>
</li>
			  	<?php $_from = $this->_tpl_vars['myobj']->category_titles; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ckey'] => $this->_tpl_vars['cat_value']):
?>
			  		<li><?php echo $this->_tpl_vars['cat_value']['cat_url']; ?>
</li>
			  	<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
	    <!-- starts confirmation -->
		<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
			<p id="confirmMessage"></p>
			<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
				<table>
					<tr>
						<td>
							<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
							&nbsp;
							<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks();" />
							<input type="hidden" name="discussion_ids" id="forum_ids" />
							<input type="hidden" name="action" id="action" />
							<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

						</td>
					</tr>
				</table>
			</form>
		</div>
		<!-- ends confirmation -->
    </div>
  </div>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <!-- search form starts -->
   <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_search')): ?>
   <form name="formAdvanceSearch" id="formAdvanceSearch" method="post" action="<?php echo $this->_tpl_vars['myobj']->advanced_search_action; ?>
">
		<div id="moreSearchOptions">
		  <table summary="<?php echo $this->_tpl_vars['LANG']['common_displaying_more_search_options']; ?>
">
			<tr>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('discussion_title'); ?>
"><label for="discussion_title"><?php echo $this->_tpl_vars['LANG']['discussion_search_title']; ?>
</label>
			  </td>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('discussion_title'); ?>
">
				<input type="text" class="clsCommonTextBox" name="discussion_title" id="discussion_title" value="<?php echo $this->_tpl_vars['myobj']->getFormField('discussion_title'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
			  </td>
			</tr>
			<tr>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('dname'); ?>
"><label for="dname"><?php echo $this->_tpl_vars['LANG']['search_username']; ?>
</label>
			  </td>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('dname'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('dname'); ?>

				<p>
				  <input type="text" class="clsCommonTextBox" name="dname" id="dname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('dname'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
				</p></td>
			</tr>
			<tr>
	            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('cat_id'); ?>
"><label for="cat_id"><?php echo $this->_tpl_vars['LANG']['discuzz_common_category']; ?>
</label></td>
	            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('cat_id'); ?>
">
	              <select name="discussion_category" id="discussion_category" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
	              		<option value=""><?php echo $this->_tpl_vars['LANG']['search_anywhere']; ?>
</option>
		                <?php $_from = $this->_tpl_vars['myobj']->allCategories_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['daqkey'] => $this->_tpl_vars['daqvalue']):
?>
							<option value="<?php echo $this->_tpl_vars['daqvalue']['search_value']; ?>
" <?php if ($this->_tpl_vars['daqvalue']['search_value'] == $this->_tpl_vars['myobj']->getFormField('discussion_category')): ?> selected <?php endif; ?>>
							<?php unset($this->_sections['tab']);
$this->_sections['tab']['name'] = 'tab';
$this->_sections['tab']['start'] = (int)0;
$this->_sections['tab']['loop'] = is_array($_loop=$this->_tpl_vars['daqvalue']['tab']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['tab']['show'] = true;
$this->_sections['tab']['max'] = $this->_sections['tab']['loop'];
$this->_sections['tab']['step'] = 1;
if ($this->_sections['tab']['start'] < 0)
    $this->_sections['tab']['start'] = max($this->_sections['tab']['step'] > 0 ? 0 : -1, $this->_sections['tab']['loop'] + $this->_sections['tab']['start']);
else
    $this->_sections['tab']['start'] = min($this->_sections['tab']['start'], $this->_sections['tab']['step'] > 0 ? $this->_sections['tab']['loop'] : $this->_sections['tab']['loop']-1);
if ($this->_sections['tab']['show']) {
    $this->_sections['tab']['total'] = min(ceil(($this->_sections['tab']['step'] > 0 ? $this->_sections['tab']['loop'] - $this->_sections['tab']['start'] : $this->_sections['tab']['start']+1)/abs($this->_sections['tab']['step'])), $this->_sections['tab']['max']);
    if ($this->_sections['tab']['total'] == 0)
        $this->_sections['tab']['show'] = false;
} else
    $this->_sections['tab']['total'] = 0;
if ($this->_sections['tab']['show']):

            for ($this->_sections['tab']['index'] = $this->_sections['tab']['start'], $this->_sections['tab']['iteration'] = 1;
                 $this->_sections['tab']['iteration'] <= $this->_sections['tab']['total'];
                 $this->_sections['tab']['index'] += $this->_sections['tab']['step'], $this->_sections['tab']['iteration']++):
$this->_sections['tab']['rownum'] = $this->_sections['tab']['iteration'];
$this->_sections['tab']['index_prev'] = $this->_sections['tab']['index'] - $this->_sections['tab']['step'];
$this->_sections['tab']['index_next'] = $this->_sections['tab']['index'] + $this->_sections['tab']['step'];
$this->_sections['tab']['first']      = ($this->_sections['tab']['iteration'] == 1);
$this->_sections['tab']['last']       = ($this->_sections['tab']['iteration'] == $this->_sections['tab']['total']);
?>
							  &nbsp;&nbsp;
							<?php endfor; endif; ?><?php if ($this->_tpl_vars['daqvalue']['tab'] > 0): ?>&rarr;<?php endif; ?>
							<?php echo $this->_tpl_vars['daqvalue']['search_text']; ?>
</option>
		               <?php endforeach; endif; unset($_from); ?>
		           </select>
	            </td>
	        </tr>
			<tr>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('date_limits_to'); ?>
"><label for="date_limits_to"><?php echo $this->_tpl_vars['LANG']['discussion_search_date_limits_to']; ?>
</label></td>
			  <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('date_limits_to'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('date_limits_to'); ?>

				<label for="date_limits_to">
				<select name="date_limits_to" id="date_limits_to" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
					<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->searchOption_arr,$this->_tpl_vars['myobj']->getFormField('date_limits_to')); ?>

				</select>
				</label>
			  </td>
			</tr>
			<tr>
			 	<td></td>
			 	<td>
				 	<input type="submit" class="clsSubmitButton" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['search']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;
				 	<input type="reset" class="clsCancelButton" name="reset" id="reset" value="<?php echo $this->_tpl_vars['LANG']['discuzz_common_reset']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
			  </td>
			</tr>
		  </table>
		</div>
	</form>
	<?php endif; ?>
   <!-- search form ends -->
  <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_discussions')): ?>
	<?php $_from = $this->_tpl_vars['myobj']->form_show_discussions_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['catkey'] => $this->_tpl_vars['catdetails']):
?>
		<div class="clsCommonIndexRoundedCorner">
			<div class="clsCommonTopAnalystRoundedCorner">
		  	<!--rounded corners-->
		  		<div class="lbtopanalyst">
		    		<div class="rbtopanalyst">
		      			<div class="bbtopanalyst">
		        			<div class="blctopanalyst">
		          				<div class="brctopanalyst">
		            				<div class="tbtopanalyst">
		              					<div class="tlctopanalyst">
		                					<div class="trctopanalyst">
		                						<!-- tabs start -->
												<div class="clsBoardsLink clsDiscusPage">
													<h3>
														<a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" onclick="Effect.toggle('recently_solutioned<?php echo $this->_tpl_vars['catdetails']['cat_id']; ?>
', 'BLIND'); return false;" title="<?php echo $this->_tpl_vars['LANG']['click_here_show_hide']; ?>
"><?php echo $this->_tpl_vars['catdetails']['cat_name']; ?>
</a>
													</h3>
												</div>
												<!-- tabs end -->
                                                <div class="clsCommonTableContainer" id="recently_solutioned<?php echo $this->_tpl_vars['catdetails']['cat_id']; ?>
" style="display: block;">

												<?php if ($this->_tpl_vars['catdetails']['subforum_titles'] || $this->_tpl_vars['catdetails']['discussion_titles']): ?>
													<table summary="<?php echo $this->_tpl_vars['LANG']['discussions_tbl_summary']; ?>
" class="clsDataDisplaySection">
														<tr>
														  	<th class=""><?php echo $this->_tpl_vars['LANG']['discussions_title']; ?>
</th>
														  	<th class="clsLastPostTittle"><?php echo $this->_tpl_vars['LANG']['discussions_last_post']; ?>
</th>
														  	<th class="clsViewsTittle"><?php echo $this->_tpl_vars['LANG']['discuzz_common_boards']; ?>
</th>
														  	<th class="clsTittleSolutions"><?php echo $this->_tpl_vars['LANG']['discuzz_common_solutions']; ?>
</th>
														  	<th class="clsTittleSolutions"><?php echo $this->_tpl_vars['LANG']['discuzz_common_manage']; ?>
</th>
														</tr>
													<?php if (isset ( $this->_tpl_vars['catdetails']['subforum_titles'] ) && $this->_tpl_vars['catdetails']['subforum_titles']): ?>
														<?php $_from = $this->_tpl_vars['catdetails']['subforum_titles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['discussion_key'] => $this->_tpl_vars['subforum_titles']):
?>
															<tr>
															  	<td>
																	<p><span class="clsDiscussionLink"><a href="<?php echo $this->_tpl_vars['subforum_titles']['subforum']['url']; ?>
"> <?php echo $this->_tpl_vars['subforum_titles']['cat_name']; ?>
 </a></span></p>
															  	</td>
																<td class="clsLastPostValue">
																	<?php if ($this->_tpl_vars['subforum_titles']['last_post_date'] && $this->_tpl_vars['subforum_titles']['last_post_name'] != ''): ?>
                                                                        <span class="clsLastPostDate"><?php echo $this->_tpl_vars['subforum_titles']['last_post_date_only']; ?>
,</span>
																		<span class="clsLatPostTime"><?php echo $this->_tpl_vars['subforum_titles']['last_post_time_only']; ?>
</span>
																  		<p class="clsAskBy"><span class="clsLastAskby"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
</span> <a href="<?php echo $this->_tpl_vars['subforum_titles']['lastPost']['url']; ?>
"><?php echo $this->_tpl_vars['subforum_titles']['last_post_name1']; ?>
</a></p>
																  	<?php endif; ?>
																</td>
															  	<td class="clsTotalBoardsValue"><?php echo $this->_tpl_vars['subforum_titles']['total_boards']; ?>
</td>
															  	<td class="clsTotalSolutionsValue"><?php echo $this->_tpl_vars['subforum_titles']['total_solutions']; ?>
</td>
															  	<td class="clsTotalSolutionsValue"></td>
															</tr>
														<?php endforeach; endif; unset($_from); ?>
													<?php endif; ?>
													<?php if (isset ( $this->_tpl_vars['catdetails']['discussion_titles'] ) && $this->_tpl_vars['catdetails']['discussion_titles']): ?>
														<?php $_from = $this->_tpl_vars['catdetails']['discussion_titles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['discussion_key'] => $this->_tpl_vars['discussion_details']):
?>
															<tr>
															  	<td>
																	<p><span class="clsDiscussionLink"><a href="<?php echo $this->_tpl_vars['discussion_details']['discussionBoards']['url']; ?>
"> <?php echo $this->_tpl_vars['discussion_details']['discussionBoards']['title']; ?>
 </a></span></p>
																	<p class="clsDiscussionDesc"><?php echo $this->_tpl_vars['discussion_details']['discussion_description_manual']; ?>
</p>
																	<p class="clsAskBy"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 <a href="<?php echo $this->_tpl_vars['discussion_details']['myanswers']['url']; ?>
"><?php echo $this->_tpl_vars['discussion_details']['post_name']; ?>
</a></p>
																	 <?php if ($this->_tpl_vars['discussion_details']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] && $this->_tpl_vars['myobj']->getFormField('my')): ?>
																 		<p> <?php echo $this->_tpl_vars['discussion_details']['discussions_unpublished_boards']['content']; ?>
</p>
																  	 <?php endif; ?>
															  	</td>
																<td class="clsLastPostValue">
																  	<?php if ($this->_tpl_vars['discussion_details']['last_post_date'] && $this->_tpl_vars['discussion_details']['last_post_name'] != ''): ?>
                                                                        <span class="clsLastPostDate"><?php echo $this->_tpl_vars['discussion_details']['last_post_date_only']; ?>
,</span>
																		<span class="clsLatPostTime"><?php echo $this->_tpl_vars['discussion_details']['last_post_time_only']; ?>
</span>
																  		<p class="clsAskBy"><span class="clsLastAskby"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
</span> <a href="<?php echo $this->_tpl_vars['discussion_details']['lastPost']['url']; ?>
"><?php echo $this->_tpl_vars['discussion_details']['last_post_name1']; ?>
</a></p>
																  	<?php endif; ?>
																</td>
																<td class="clsTotalBoardsValue"><?php echo $this->_tpl_vars['discussion_details']['total_boards']; ?>
</td>
																<td class="clsTotalSolutionsValue"><?php echo $this->_tpl_vars['discussion_details']['total_solutions']; ?>
</td>
																<td class="clsTotalSolutionsValue">
																<a href="<?php echo $this->_tpl_vars['discussion_details']['edit']['url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_edit']; ?>
</a>&nbsp;&nbsp;
																<a id="anchorDelDiscussion"  href="#" title="<?php echo $this->_tpl_vars['LANG']['common_delete']; ?>
" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action', 'discussion_ids', 'confirmMessage'), Array('deleteDiscussion','<?php echo $this->_tpl_vars['discussion_details']['discussion_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['confirm_delete_message']; ?>
'), Array('value','value', 'innerHTML'));"><?php echo $this->_tpl_vars['LANG']['common_delete']; ?>
</a>
																<p><a id="anchorDelDiscussion"  href="#" title="<?php echo $this->_tpl_vars['discussion_details']['action_text']; ?>
" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action', 'discussion_ids', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['discussion_details']['action_link']; ?>
','<?php echo $this->_tpl_vars['discussion_details']['discussion_id']; ?>
', '<?php echo $this->_tpl_vars['discussion_details']['confirm_msg']; ?>
'), Array('value','value', 'innerHTML'));"><?php echo $this->_tpl_vars['discussion_details']['action_text']; ?>
</a></p>
															</tr>
														<?php endforeach; endif; unset($_from); ?>
													<?php endif; ?>
												</table>
												<?php else: ?>
													<div id="selMsgAlert">
														<p><?php echo $this->_tpl_vars['LANG']['discussions_no_titles']; ?>
. <?php if ($this->_tpl_vars['CFG']['admin']['discussions']['add_title']): ?><a class="clsPostNewData" href="<?php echo $this->_tpl_vars['myobj']->discussionsAddTitle_url; ?>
"><?php echo $this->_tpl_vars['LANG']['click_here_to_post_new_discussion']; ?>
</a><?php endif; ?></p>
													</div>
												<?php endif; ?>
                                                </div>
												</div>
		              					</div>
		            				</div>
		          				</div>
		        			</div>
		      			</div>
		    		</div>
		  		</div>
		  	<!--end of rounded corners-->
			</div>
		</div>
												<?php endforeach; else: ?>
													<tr>
														<td>
															<div id="selMsgAlert">
																<p><?php echo $this->_tpl_vars['LANG']['discussions_no_titles']; ?>
. <?php if ($this->_tpl_vars['CFG']['admin']['discussions']['add_title']): ?><a class="clsPostNewData" href="<?php echo $this->_tpl_vars['myobj']->discussionsAddTitle_url; ?>
"><?php echo $this->_tpl_vars['LANG']['click_here_to_post_new_discussion']; ?>
</a><?php endif; ?></p>
															</div>
														</td>
													</tr>
												</table>
		                					</div>
		              					</div>
		            				</div>
		          				</div>
		        			</div>
		      			</div>
		    		</div>
		  		</div>
		  	<!--end of rounded corners-->
			</div>
		</div>
	<?php endif; unset($_from); ?>
   <?php endif; ?>
 </div>
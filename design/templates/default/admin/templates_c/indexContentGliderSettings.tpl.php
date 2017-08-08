<?php /* Smarty version 2.6.18, created on 2011-10-19 10:49:05
         compiled from indexContentGliderSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'indexContentGliderSettings.tpl', 6, false),array('modifier', 'capitalize', 'indexContentGliderSettings.tpl', 177, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_list_glider_content')): ?>
	<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
		<h3 id="confirmationMsg"></h3>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
	    	<!-- clsFormSection - starts here -->
	      	<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
	      	&nbsp;
	      	<input type="button" class="clsSubmitButton clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks('selListFeaturedContentForm');" />
	      	<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->deleteForm_hidden_arr); ?>

			<!-- clsFormSection - ends here -->
		</form>
	</div>
<?php endif; ?>

<div id="selFeaturedContent">
	<h2><span><?php echo $this->_tpl_vars['LANG']['index_glidersetting_title']; ?>
</span></h2>

    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
     <h3><?php echo $this->_tpl_vars['LANG']['index_glidersetting_heading_note']; ?>
</h3>
	<p><strong><?php echo $this->_tpl_vars['LANG']['index_glidersetting_max_rollovers_allowed_note']; ?>
&nbsp;<?php echo $this->_tpl_vars['myobj']->getFormField('max_rollovers_allowed'); ?>
</strong></p>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_add_glider_content')): ?>
		<h3>
			<?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
				<?php echo $this->_tpl_vars['LANG']['index_glidersetting_edit_featured_content']; ?>

			<?php else: ?>
				<?php echo $this->_tpl_vars['LANG']['index_glidersetting_add_featured_content']; ?>

			<?php endif; ?>
		</h3>

		<!-- Add Index Featured Content Glider Block Starts -->
		<div id="selAddFeaturedContentBlock">
			<form id="frmAddContentGlider" name="frmAddContentGlider" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" enctype="multipart/form-data">
				<table class="clsNoBorder">
					<tr>
						<td class="clsWidthSmall">
							<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="media_type"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_media_type']; ?>
</label>
						</td>
			    		<td>
							<select name="media_type" id="id_media_type" onchange="showCustomBlock(this.value)" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
			    				<option value='video' <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') == 'video'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['media_type_video']; ?>
</option>
			        			<option value='music' <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') == 'music'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['media_type_music']; ?>
</option>
			        			<option value='photo' <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') == 'photo'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['media_type_photo']; ?>
</option>
			        			<option value='custom' <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') == 'custom'): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['media_type_custom']; ?>
</option>
			    			</select>
			    			<p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('media_type'); ?>
</p>
			    			<p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('indexcontentglider_media_type','media_type'); ?>
</p>
			    		</td>
					</tr>
					<tr>
						<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('glider_title'); ?>
">
							<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="glider_title"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_slide_title']; ?>
</label>
						</td>
			    		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('glider_title'); ?>
">
							<input type="text" class="clsTextBox" name="glider_title" id="id_glider_title" value="<?php echo $this->_tpl_vars['myobj']->getFormField('glider_title'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['glider']['slide_title_max_length']; ?>
"/>&nbsp;
							<p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('glider_title'); ?>
</p>
							<p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('indexcontentglider_glider_title','glider_title'); ?>
</p>
						</td>
					</tr>
					<tr>
                    	<td colspan="2">
                        	<table id="selMediaId" class="clsNoBorder">
                            	<tr>
                                    <td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('media_id'); ?>
">
                                        <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="media_id"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_media_id']; ?>
</label>
                                    </td>
                                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('media_id'); ?>
">
                                        <input type="text" class="clsTextBox" name="media_id" id="id_media_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('media_id'); ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') == 'custom'): ?>disabled="disabled"<?php endif; ?>/>&nbsp;
                                        <p id="selSearchMedia">
                                            <a id="show_media_search" href="javascript:void(0);"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_search_media_id']; ?>
</a>
                                        </p>
                                        <p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('media_id'); ?>
</p>
                                        <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('indexcontentglider_media_id','media_id'); ?>
</p>
                                    </td>
                                  </tr>
                               </table>
                           </td>
					</tr>
		
                                    <tr>
                                        <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('custom_image'); ?>
">
                                            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="custom_image"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_upload_custom_image']; ?>
</label>
                                        </td>
                                        <td>
                                            <input type="file" class="clsFileBox" name="custom_image" id="id_custom_image" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') != 'custom'): ?>disabled="disabled"<?php endif; ?> />
                                            <div class="clsTdDatas">
                                                <p><strong><?php echo $this->_tpl_vars['LANG']['common_max_file_size']; ?>
:</strong>&nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['glider']['custom_image_max_size']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['common_file_size_in_KB']; ?>
</p>
                                                <p><strong><?php echo $this->_tpl_vars['LANG']['common_allowed_file_formats']; ?>
:</strong>&nbsp;<?php echo $this->_tpl_vars['myobj']->changeArrayToCommaSeparator($this->_tpl_vars['CFG']['admin']['glider']['custom_image_format_arr']); ?>
</p>
                                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('custom_image'); ?>

                                                <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('indexcontentglider_custom_image','custom_image'); ?>
</p>
                                                <?php if ($this->_tpl_vars['myobj']->chkIsEditMode() && $this->_tpl_vars['myobj']->getFormField('media_type') == 'custom' && $this->_tpl_vars['myobj']->getFormField('custom_image_ext') != ''): ?>
                                                    <img src="<?php echo $this->_tpl_vars['myobj']->custom_media_image; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->getFormField('glider_title'); ?>
" /><br/>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                </tr>
        
					<tr>
                    	<td colspan="2">
                        	<table id="selCustomTargetUrl" class="clsNoBorder">
                            	<tr>
                                    <td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('custom_image_url'); ?>
">
                                        <label for="custom_image_url"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_custom_image_link']; ?>
</label>
                                    </td>
                                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('custom_image_url'); ?>
">
                                        <input type="text" class="clsTextBox" name="custom_image_url" id="id_custom_image_url" value="<?php echo $this->_tpl_vars['myobj']->getFormField('custom_image_url'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['glider']['custom_target_url_max_length']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') != 'custom'): ?>disabled="disabled"<?php endif; ?>/>
                                        <p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('custom_image_url'); ?>
</p>
                                        <p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('indexcontentglider_custom_image_url','custom_image_url'); ?>
</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
					</tr>
					<tr>
	            		<td><label><?php echo $this->_tpl_vars['LANG']['index_glidersetting_default_content']; ?>
</label></td>
	          			<td>
						  	<input type="radio" class="clsCheckRadio" name="media_default_content" id="media_default_content1" value="Yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('media_default_content','Yes'); ?>
 onclick="showMediaBlock(this.value)" <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') == 'custom'): ?>disabled="disabled"<?php endif; ?>/>&nbsp;<label for="media_default_content1"><?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
</label>
                        	<input type="radio" class="clsCheckRadio" name="media_default_content" id="media_default_content2" value="No" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('media_default_content','No'); ?>
 onclick="showMediaBlock(this.value)" <?php if ($this->_tpl_vars['myobj']->getFormField('media_type') == 'custom'): ?>disabled="disabled"<?php endif; ?>/>&nbsp;<label for="media_default_content2"><?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
</label>
                        							</td>
	      			</tr>
					<tr>
						<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('rollover_text'); ?>
">
							<span id="rolloverMandatory" style="display:none;"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</span><label for="rollover_text"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_rollover_text']; ?>
</label>
						</td>
			    		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('rollover_text'); ?>
">
							<input type="text" class="clsTextBox" name="rollover_text" id="rollover_text" value="<?php echo $this->_tpl_vars['myobj']->getFormField('rollover_text'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['glider']['rollover_text_max_length']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/>
							<p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('rollover_text'); ?>
</p>
													</td>
					</tr>
					<tr>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('sidebar_content'); ?>
">
                			<span id="sidebarMandatory" style="display:none;"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</span><label for="sidebar_content"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_sidebar_content']; ?>
</label>
                		</td>
                		<td>
							<?php if ($this->_tpl_vars['CFG']['feature']['html_editor'] != 'richtext' && $this->_tpl_vars['CFG']['feature']['html_editor'] != 'tinymce'): ?>
								<textarea name="sidebar_content" id="sidebar_content" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('sidebar_content'); ?>
</textarea>
							<?php endif; ?>
							<?php echo $this->_tpl_vars['myobj']->populateHtmlEditor('sidebar_content'); ?>

							<p><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('sidebar_content'); ?>
</p>
							                		</td>
                	</tr>
	      			<tr>
	      				<td>&nbsp;</td>
						<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('add_submit'); ?>
">
							<?php if ($this->_tpl_vars['myobj']->chkIsEditMode()): ?>
								<input type="submit" class="clsSubmitButton" name="update_submit" id="update_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_update']; ?>
" />
							<?php else: ?>
								<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_save']; ?>
" />
							<?php endif; ?>
							<input type="submit" class="clsCancelButton" name="cancel_submit" id="cancel_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_cancle']; ?>
" />
						</td>
					</tr>
				</table>
				<input type="hidden" id="glider_id" name="glider_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('glider_id'); ?>
" />
				<input type="hidden" id="custom_image_ext" name="custom_image_ext" value="<?php echo $this->_tpl_vars['myobj']->getFormField('custom_image_ext'); ?>
" />
			</form>
		</div>
		<!-- Add Index Featured Content Glider Block Ends -->
	<?php endif; ?>
</div>

<!--  Reorder Feature conntent starts here -->
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_reorder_glider_content')): ?>
	<?php if ($this->_tpl_vars['myobj']->reorder_keys): ?>
		<h3><?php echo $this->_tpl_vars['LANG']['index_glidersetting_reorder_featured_content']; ?>
</h3>
		<table class="clsNoBorder">
			<tr>
				<td>
					<form name="selReorderFeaturedContentForm" id="selReorderFeaturedContentForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			      		<div class="menuOrderSection">
			      			<div class="workarea">
			          			<ul class="draglist" id="ul1">
			            			<?php $_from = $this->_tpl_vars['myobj']->reorder_keys; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['reorder_id']):
?>
			                  			<li id="<?php echo $this->_tpl_vars['reorder_id']; ?>
" class="list1"><?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->reorder_arr[$this->_tpl_vars['reorder_id']]['glider_title'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</li>
			            			<?php endforeach; endif; unset($_from); ?>
			            		</ul>
			      			</div>
				    	</div>
				    	<div id="user_actions" style="clear:left;">
					    	<input type="submit" class="clsSubmitButton" name="update_order" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_update']; ?>
" id="showButton" />
				    	</div>
				    	<input type="hidden" name="left" id="left" />
			    	</form>
    			</td>
    		</tr>
    	</table>
	<?php endif; ?>
<?php endif; ?>
<!--  Reorder Feature conntent ends here -->

<!-- List Glider setting featured content starts here -->
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_form_list_glider_content')): ?>
	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	<h3><?php echo $this->_tpl_vars['LANG']['index_glidersetting_featured_content_title']; ?>
</h3>
	<div>
		<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
		<form name="selListFeaturedContentForm" id="selListFeaturedContentForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
	    	<!-- clsDataDisplaySection - starts here -->
	        <div class="clsDataDisplaySection">
	        	<div class="clsDataHeadSection">
	          		<table>
	            		<tr>
	            			<th class="clsSelectColumn"><input type="checkbox" class="clsCheckBox" name="check_all" onclick= "CheckAll(document.selListFeaturedContentForm.name, document.selListFeaturedContentForm.check_all.name)" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></th>
	            			<th><?php echo $this->_tpl_vars['LANG']['index_glidersetting_list_media_type']; ?>
</th>
	            			<th><?php echo $this->_tpl_vars['LANG']['index_glidersetting_list_media_id']; ?>
</th>
	            			<th><?php echo $this->_tpl_vars['LANG']['index_glidersetting_list_slide_title']; ?>
</th>
	            			<th><?php echo $this->_tpl_vars['LANG']['index_glidersetting_list_status']; ?>
</th>
	            			<th>&nbsp;</th>
	        			</tr>
	            		<?php $_from = $this->_tpl_vars['populateContent_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
	           				<tr>
	            				<td class="clsSelectColumn">
	              					<input type="checkbox" class="clsCheckBox" name="aid[]" value="<?php echo $this->_tpl_vars['populateContent_arr'][$this->_tpl_vars['inc']]['glider_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('selListFeaturedContentForm');"/>
	            				</td>
	            				<td class="clsBannerDescription"><?php echo $this->_tpl_vars['populateContent_arr'][$this->_tpl_vars['inc']]['media_type']; ?>
</td>
	            				<td><?php echo $this->_tpl_vars['populateContent_arr'][$this->_tpl_vars['inc']]['media_id']; ?>
</td>
	            				<td><?php echo $this->_tpl_vars['populateContent_arr'][$this->_tpl_vars['inc']]['glider_title']; ?>
</td>
	            				<td><?php echo $this->_tpl_vars['populateContent_arr'][$this->_tpl_vars['inc']]['status']; ?>
</td>
	            				<td><a href="<?php echo $this->_tpl_vars['populateContent_arr'][$this->_tpl_vars['inc']]['edit_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_glidersetting_edit']; ?>
</a></td>
	        				</tr>
	          			<?php endforeach; endif; unset($_from); ?>
	          			<tr>
	            			<td colspan="6">
	            				<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_delete']; ?>
" onclick="<?php echo $this->_tpl_vars['delete_submit_onclick']; ?>
" />
	            				<input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_activate']; ?>
" onclick="<?php echo $this->_tpl_vars['activate_submit_onclick']; ?>
" />
	            				<input type="button" class="clsSubmitButton" name="deactivate_submit" id="deactivate_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['index_glidersetting_deactivate']; ?>
" onclick="<?php echo $this->_tpl_vars['deactivate_submit_onclick']; ?>
" />
							</td>
	          			</tr>
	        		</table>
	        	</div>
	        </div>
	    	<!-- clsDataDisplaySection - ends here -->
		</form>
		<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    <?php endif; ?>
	</div>
	<?php else: ?>
		<div id="selMsgAlert"><p><strong><?php echo $this->_tpl_vars['LANG']['index_glidersetting_no_records_found']; ?>
</strong></p></div>
	<?php endif; ?>
<?php endif; ?>
<!-- List Glider setting featured content ends here -->
</div>

<?php echo '
<script>
var mediaType = $Jq(\'#id_media_type\').val();
if(mediaType == \'custom\')
{
	$Jq(\'#selCustomImage\').css(\'display\', \'block\');
	$Jq(\'#selCustomTargetUrl\').css(\'display\', \'block\');
	$Jq(\'#selMediaId\').css(\'display\', \'none\');
}
else
{
	$Jq(\'#selCustomImage\').css(\'display\', \'none\');
	$Jq(\'#selCustomTargetUrl\').css(\'display\', \'none\');
}
$Jq(document).ready(function() {
	$Jq(\'#show_media_search\').fancybox({
		\'width\'				: 865,
		\'height\'			: \'100%\',
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'href\'              : \''; ?>
<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo 'admin/indexContentGliderSettings.php?act=search\',
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
});
</script>
'; ?>
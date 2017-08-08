<?php /* Smarty version 2.6.18, created on 2011-10-26 11:41:10
         compiled from manageFlaggedPhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageFlaggedPhoto.tpl', 10, false),)), $this); ?>
<div id="selphotoList">
	<!-- Confirmation message block start-->
  	<h2><span><?php echo $this->_tpl_vars['LANG']['manageflaggedphoto_title']; ?>
</span></h2>
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
">
			<table summary="">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="yes" id="yes" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" />&nbsp;
						<input type="button" class="clsSubmitButton" name="no" id="no" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="photo_ids" id="photo_ids" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- Confirmation message block end-->

    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('flagged_details_form')): ?>
      <div id="selFlaggedDetails">
        <?php if ($this->_tpl_vars['displayFlaggedList_arr']['rs_PO_RecordCount']): ?>
            <table summary="<?php echo $this->_tpl_vars['LANG']['manageflagged_tbl_summary']; ?>
">
              <tr>
                <th><?php echo $this->_tpl_vars['LANG']['manageflagged_user_name']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['manageflagged_flaged_text']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['manageflagged_flag_comment']; ?>
</th>
                <th><?php echo $this->_tpl_vars['LANG']['manageflagged_date_added']; ?>
</th>
              </tr>
              <?php $_from = $this->_tpl_vars['displayFlaggedList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dflValue']):
?>
              <tr>
                <td><?php echo $this->_tpl_vars['dflValue']['name']; ?>
</td>
                <td><?php echo $this->_tpl_vars['dflValue']['record']['flag']; ?>
</td>
                <td><?php echo $this->_tpl_vars['dflValue']['record']['flag_comment']; ?>
</td>
                <td><?php echo $this->_tpl_vars['dflValue']['record']['date_added']; ?>
</td>
              </tr>
              <?php endforeach; endif; unset($_from); ?>

              <form name="flagphotoForm" id="flagphotoForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
              	<tr>
                	<td colspan="4">
                    	<a href="#" id="dAltMlti"></a>
                    	<input type="button" class="clsSubmitButton" name="" id="unflag" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_activate']; ?>
" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
', 'Unflag', '<?php echo $this->_tpl_vars['LANG']['unflag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    	<input type="button" class="clsSubmitButton" name="" id="flag" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_flag']; ?>
" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
', 'Flag', '<?php echo $this->_tpl_vars['LANG']['flag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    	<input type="button" class="clsSubmitButton" name="" id="delete" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_delete']; ?>
" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
', 'Delete', '<?php echo $this->_tpl_vars['LANG']['delete_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290);"/>
                    	<input type="submit" class="clsSubmitButton" name="back_submit" id="back_submit" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_back']; ?>
" />
                	</td>
              	</tr>
              </form>
            </table>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_flagged_photo_form')): ?>
     <div id="selPhotoList">
        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
    	        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

        	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         	<?php endif; ?>
            <form name="flaggedForm" id="flaggedForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
            	<table summary="<?php echo $this->_tpl_vars['LANG']['manageflagged_tbl_summary']; ?>
">
              		<tr>
                		<th class="clsAlignCenter">
                    		<input type="checkbox" class="clsCheckRadio" name="check_all" onclick = "CheckAll(document.flaggedForm.name, document.flaggedForm.check_all.name)" />
                		</th>
                        <th><?php echo $this->_tpl_vars['LANG']['manageflagged_Photo_title']; ?>
</th>
                        <th><?php echo $this->_tpl_vars['LANG']['manageflagged_user_name']; ?>
</th>
                        <th><?php echo $this->_tpl_vars['LANG']['manageflagged_total_flags']; ?>
</th>
                        <th><?php echo $this->_tpl_vars['LANG']['manageflagged_option']; ?>
</th>
                      </tr>
		              <?php $_from = $this->_tpl_vars['displayPhotoList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalValue']):
?>
                        <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                          <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="photo_ids[]" value="<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('flaggedForm');" <?php echo $this->_tpl_vars['dalValue']['checked']; ?>
/></td>
                          <td> <?php echo $this->_tpl_vars['dalValue']['record']['photo_title']; ?>
</td>
                          <td><?php echo $this->_tpl_vars['myobj']->getUserName($this->_tpl_vars['dalValue']['record']['user_id']); ?>
</td>
                          <td><?php echo $this->_tpl_vars['myobj']->getCountOfRequests($this->_tpl_vars['dalValue']['record']['photo_id']); ?>
</td>
                          <td>
                          	<span id="detail">
                            	<a href="?action=detail&amp;photo_id=<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>
&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"><?php echo $this->_tpl_vars['LANG']['manageflagged_detail']; ?>
</a>
                            </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span id="preview">
                            	<a id="photoPreview_<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>
" href="<?php echo $this->_tpl_vars['dalValue']['previewURL']; ?>
"><?php echo $this->_tpl_vars['LANG']['manageflagged_preview_option']; ?>
</a>
                            </span>
                          </td>
                        </tr>
		              <?php endforeach; endif; unset($_from); ?>
                	  <tr>
                    	<td colspan="5" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('photo_submit'); ?>
">
                        	<a href="#" id="dAltMlti"></a>
                        	<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_delete']; ?>
" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['err_tip_select_Photo']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Delete', '<?php echo $this->_tpl_vars['LANG']['delete_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />
                        	<input type="button" class="clsSubmitButton" name="flag_submit" id="flag_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_flag']; ?>
" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['err_tip_select_Photo']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Flag', '<?php echo $this->_tpl_vars['LANG']['flag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />
                        	<input type="button" class="clsSubmitButton" name="unflag_submit" id="unflag_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_activate']; ?>
" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['err_tip_select_Photo']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('photo_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Unflag', '<?php echo $this->_tpl_vars['LANG']['unflag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />
                    	</td>
                	  </tr>
            	</table>
          	</form>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
        <?php else: ?>
            <div id="selMsgAlert">
                <?php echo $this->_tpl_vars['LANG']['manageflagged_no_records_found']; ?>

            </div>
    	<?php endif; ?>
     </div>
    <?php endif; ?>
</div>
<script>
<?php echo '
$Jq(document).ready(function() {
	'; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_flagged_photo_form')): ?>
		<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
			<?php $_from = $this->_tpl_vars['displayPhotoList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalValue']):
?>
				<?php echo '
				$Jq(\'#photoPreview_\'+'; ?>
<?php echo $this->_tpl_vars['dalValue']['record']['photo_id']; ?>
<?php echo ').fancybox({
					\'width\'				: 900,
					\'height\'			: 750,
					\'padding\'			:  0,
					\'autoScale\'     	: false,
					\'transitionIn\'		: \'none\',
					\'transitionOut\'		: \'none\'
				});
				'; ?>

			<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
	<?php endif; ?>
	<?php echo '
});
'; ?>

</script>
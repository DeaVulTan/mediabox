<?php /* Smarty version 2.6.18, created on 2014-08-14 17:11:18
         compiled from manageFlaggedVideo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageFlaggedVideo.tpl', 15, false),)), $this); ?>
<!-- 
	Manage flagged video.
-->
<div id="selVideoList">
  <!-- heading start-->
  <h2><span><?php echo $this->_tpl_vars['LANG']['manageflagged_title']; ?>
</span></h2>
  <!-- heading end-->
  <!-- Confirmation message block start-->
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
						<input type="hidden" name="video_ids" id="video_ids" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

					</td>
				</tr>
			</table>
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
<!-- flagged_details_form start-->
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
          <tr>
            <td colspan="4">
                <a href="#" id="dAltMlti"></a>
                <span id="unflag"><a href="#" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
', 'Unflag', '<?php echo $this->_tpl_vars['LANG']['unflag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290);"><?php echo $this->_tpl_vars['LANG']['manageflagged_activate']; ?>
</a></span>
                <span id="flag"><a href="#" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
', 'Flag', '<?php echo $this->_tpl_vars['LANG']['flag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290);"><?php echo $this->_tpl_vars['LANG']['manageflagged_flag']; ?>
</a></span>
                <span id="delete"><a href="#" onClick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
', 'Delete', '<?php echo $this->_tpl_vars['LANG']['delete_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290);"><?php echo $this->_tpl_vars['LANG']['manageflagged_delete']; ?>
</a></span>
                <span id="back"><a href="?action=back&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"><?php echo $this->_tpl_vars['LANG']['manageflagged_back']; ?>
</a></span>
            </td>
          </tr>
        </table>                
    <?php endif; ?>
  </div>
<?php endif; ?>
<!-- flagged_details_form end-->
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_flagged_video_form')): ?>
  <div id="selVideoList">
	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
   		 <!-- top pagination start--> 
		 <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
			        
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         <?php endif; ?>
         <!-- top pagination end-->
       <form name="flaggedForm" id="flaggedForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
	    <table summary="<?php echo $this->_tpl_vars['LANG']['manageflagged_tbl_summary']; ?>
">
	      <tr>
		  	<th class="clsAlignCenter">
				<input type="checkbox" class="clsCheckRadio" name="check_all" onclick = "CheckAll(document.flaggedForm.name, document.flaggedForm.check_all.name)" />
			</th>
			<th><?php echo $this->_tpl_vars['LANG']['manageflagged_video_title']; ?>
</th>
	        <th><?php echo $this->_tpl_vars['LANG']['manageflagged_user_name']; ?>
</th>
	        <th><?php echo $this->_tpl_vars['LANG']['manageflagged_total_flags']; ?>
</th>
	        <th><?php echo $this->_tpl_vars['LANG']['manageflagged_option']; ?>
</th>
	      </tr>

	<?php $_from = $this->_tpl_vars['displayVideoList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalValue']):
?>
            <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
              <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="video_ids[]" value="<?php echo $this->_tpl_vars['dalValue']['record']['video_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('flaggedForm');" <?php echo $this->_tpl_vars['dalValue']['checked']; ?>
/></td>
              <td> 
              
                          
             
             <a id="videoPreview_<?php echo $this->_tpl_vars['dalValue']['record']['video_id']; ?>
" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoPreview.php?video_id=<?php echo $this->_tpl_vars['dalValue']['record']['video_id']; ?>
" title="Video Preview"><?php echo $this->_tpl_vars['dalValue']['record']['video_title']; ?>
</a>
                                
             
              </td>
              <td><?php echo $this->_tpl_vars['myobj']->getUserName($this->_tpl_vars['dalValue']['record']['user_id']); ?>
</td>
              <td><?php echo $this->_tpl_vars['myobj']->getCountOfRequests($this->_tpl_vars['dalValue']['record']['video_id']); ?>
</td>
              <td><span id="detail"><a href="?action=detail&amp;video_id=<?php echo $this->_tpl_vars['dalValue']['record']['video_id']; ?>
&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"><?php echo $this->_tpl_vars['LANG']['manageflagged_detail']; ?>
</a></span></td>
            </tr>
    <?php endforeach; endif; unset($_from); ?>
          
            <tr>
                <td colspan="5" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_submit'); ?>
">
                    <a href="#" id="dAltMlti"></a>
                    <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_delete']; ?>
" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['err_tip_select_video']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Delete', '<?php echo $this->_tpl_vars['LANG']['delete_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />
                    <input type="button" class="clsSubmitButton" name="flag_submit" id="flag_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_flag']; ?>
" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['err_tip_select_video']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Flag', '<?php echo $this->_tpl_vars['LANG']['flag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />
                    <input type="button" class="clsSubmitButton" name="unflag_submit" id="unflag_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['manageflagged_activate']; ?>
" onClick="if(getMultiCheckBoxValue('flaggedForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['err_tip_select_video']; ?>
', 'dAltMlti', -25, -290)) <?php echo ' { '; ?>
 Confirmation('selMsgConfirm', 'msgConfirmform', Array('video_ids', 'action', 'confirmMessage'), Array(multiCheckValue, 'Unflag', '<?php echo $this->_tpl_vars['LANG']['unflag_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -25, -290); <?php echo ' } '; ?>
" />
                </td>
            </tr>
	    </table>
      </form>
			 <!-- bottom pagination start-->
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
			                
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>    
			<!-- bottom pagination end-->            
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

	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	<?php $_from = $this->_tpl_vars['displayVideoList_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalValue']):
?>
	<?php echo '


	$Jq(\'#videoPreview_\'+'; ?>
<?php echo $this->_tpl_vars['dalValue']['record']['video_id']; ?>
<?php echo ').fancybox({
		\'width\'				: 900,
		\'height\'			: 600,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
	'; ?>

	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
	<?php echo '
});
'; ?>

</script>
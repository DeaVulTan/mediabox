<?php /* Smarty version 2.6.18, created on 2011-12-29 19:10:45
         compiled from reportUser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'reportUser.tpl', 23, false),)), $this); ?>
<div class="">
    <div id="selSharehedding">
        <h2><span><?php echo $this->_tpl_vars['LANG']['report_user']; ?>
</span></h2>
    </div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsReportUserPopupCont">
    	<?php if (( $this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || checkUserPermission ( $this->_tpl_vars['CFG']['user']['user_actions'] , 'report_users' ) == 'Yes' )): ?>
    		<p id='loadingUpdates' style="text-align:center;display:none">
        		<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/ajaxLoadingRed.gif" /> <br/><span style="color:#DD6C34">Loading..</span>
        	</p>
	        <form name="frmReportUsers" id="frmReportUsers" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
			<table>
	        	<tr>
	            	<td><h3><?php echo $this->_tpl_vars['LANG']['reporting_content']; ?>
</h3></td>
	            </tr>
	            <tr>
	                <td><p><?php echo $this->_tpl_vars['LANG']['choose_reasons']; ?>
</p></td>
				</tr>
	            <tr>
	                <td>
	                    <?php $_from = $this->_tpl_vars['LANG_LIST_ARR']['report_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['i']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['i']['iteration']++;
?>
	                        <p>
	                            <input type="checkbox" class="clsCheckRadio" name="report_type[]" id="report_type_<?php echo ($this->_foreach['i']['iteration']-1)+1; ?>
" value="<?php echo ($this->_foreach['i']['iteration']-1)+1; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
	                            <label for="report_type_<?php echo ($this->_foreach['i']['iteration']-1)+1; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</label>
	                        </p>
	                    <?php endforeach; endif; unset($_from); ?>
	                    <div id="selShowCustomDivs">
	                        <p class="clsBold">
								<span ><?php echo $this->_tpl_vars['LANG']['add_custom_message']; ?>
</span>
	                            <span>
	                                <a id="selCancelCustom" href="javascript:void(0);" onclick="$Jq('#custom_message').val('');"><?php echo $this->_tpl_vars['LANG']['cancel']; ?>
</a>
		                            <textarea id="custom_message" name="custom_message"><?php echo $this->_tpl_vars['myobj']->getFormField('custom_message'); ?>
</textarea>
								</span>
	                        </p>
	                	</div>
	                </td>
	            </tr>
	            <tr>
	                <td>
	                    <div class="clsShareButton">
	                        <div class="clsSubmitButtonRight">
	                            <div class="clsSubmitButtonLeft">
			<input type="button" name="add_to_flag" id="add_to_flag" value="<?php echo $this->_tpl_vars['LANG']['set_flag']; ?>
" onclick="return openAjaxWindow('true', 'ajaxupdate', 'submitReporting', 1, '<?php echo $this->_tpl_vars['myobj']->reportingUrl; ?>
');" />
	                            </div>
	                        </div>
	                    </div>
	                </td>
	            </tr>
			</table>
	  		</form>
      	<?php else: ?>
        	<?php echo $this->_tpl_vars['LANG']['reporting_user_permission_not_available']; ?>

      	<?php endif; ?>
    </div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/box.tpl', 'smarty_include_vars' => array('opt' => 'popup_type1_bottom_middle')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/box.tpl', 'smarty_include_vars' => array('opt' => 'popup_type1_footer')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
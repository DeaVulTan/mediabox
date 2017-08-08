<?php /* Smarty version 2.6.18, created on 2011-10-19 10:52:53
         compiled from videoFlag.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoFlag.tpl', 25, false),)), $this); ?>
<div id="option-tab-2" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div id="clsMsgDisplay_flag" class="clsDisplayNone clsTextAlignLeft"></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	<?php if (isMember ( )): ?>
			<a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())"><?php echo $this->_tpl_vars['LANG']['viewvideo_flag_inappropriate_content']; ?>
</a>
            <?php else: ?>
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_flag_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->memberviewVideoUrl; ?>
');return false;"><?php echo $this->_tpl_vars['LANG']['viewvideo_flag_inappropriate_content']; ?>
</a>
            <?php endif; ?>
			</div>
		</div>
</div>

<div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">
	<div id="clsMsgDisplayFlagDiv" class="clsDisplayNone clsFeaturedContent clsAddErrorMsg"></div>
	<div class="clsOverflow">
    	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['viewvideo_flag_title']; ?>
</div>
    </div>
    <div id="flagFrm" class="clsFlagTable">
		<form name="flagfrm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post" autocomplete="off" onsubmit="return false">
			<table class="clsTable100">
				<tr>
					<td class="clsTDLabelwidth"><?php echo $this->_tpl_vars['LANG']['viewvideo_report_media']; ?>
</td>
					<td><?php echo $this->_tpl_vars['LANG']['viewvideo_choose_reasons']; ?>
<br />
	                    <select name="flag" id="flag" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
	                        <option value=""><?php echo $this->_tpl_vars['LANG']['common_select_option']; ?>
</option>
	                        <?php $_from = $this->_tpl_vars['myobj']->flag_type_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ftKey'] => $this->_tpl_vars['ftValue']):
?>
	                        <option value="<?php echo $this->_tpl_vars['ftKey']; ?>
"><?php echo $this->_tpl_vars['ftValue']; ?>
</option>
	                        <?php endforeach; endif; unset($_from); ?>
	                    </select>
	       			</td>
				</tr>
				<tr>
			 		<td>
					 	<?php echo $this->_tpl_vars['LANG']['viewvideo_flag_comment']; ?>
&nbsp;<span class="clsCompulsoryField"><?php echo $this->_tpl_vars['LANG']['important']; ?>
</span>
					</td>
					<td>
						<textarea name="flag_comment" id="flag_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="30" style="width:95%;" maxlength="5"></textarea>
					</td>
			 	</tr>
			 	<tr>
             		<td><!-- --></td>
			 		<td>
						<div class="clsFlagButtonLeft">
							<div class="clsFlagButtonRight">
								<input type="button" name="add_to_flag" id="add_to_flag" value="<?php echo $this->_tpl_vars['LANG']['viewvideo_set_flag']; ?>
" onClick="return addFlagContent('<?php echo $this->_tpl_vars['flagContent']['url']; ?>
')" />
							</div>
						</div>
					</td>
 				</tr>
			</table>
		</form>
    </div>
</div>
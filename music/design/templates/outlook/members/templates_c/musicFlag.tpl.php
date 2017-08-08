<?php /* Smarty version 2.6.18, created on 2011-10-17 15:01:16
         compiled from musicFlag.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicFlag.tpl', 27, false),)), $this); ?>
<div id="listenMusicFlag" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div id="clsMsgDisplay_flag" class="clsDisplayNone clsTextAlignLeft"></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	<?php if ($this->_tpl_vars['myobj']->isMember): ?>
			<a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return Confirmation('flagDiv', 'flagfrm', Array(), Array(), Array())" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_flag_inappropriate_content']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_flag_inappropriate_content']; ?>
</a>
            <?php else: ?>
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_flag_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewMusicUrl; ?>
');return false;" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_flag_inappropriate_content']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_flag_inappropriate_content']; ?>
</a>
            <?php endif; ?>
        </div>
    </div>	
</div>
<div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">
	<div id="clsMsgDisplayFlagDiv" class="clsDisplayNone clsFeaturedContent clsAddErrorMsg"></div>
	<div class="clsOverflow">
    	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['viewmusic_flag_title']; ?>
</div>
    </div>
    <div id="flagFrm" class="clsInnerPlaylist">
		<form name="flagfrm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post" autocomplete="off" onsubmit="return false">
        <div class="clsCreatePlaylist">
        	<div class="clsUserActionMessage"> 
            <?php echo $this->_tpl_vars['LANG']['viewmusic_report_media']; ?>

            </div>
			<div class="clsRow"> 
                <div class="clsTDLabel"><?php echo $this->_tpl_vars['LANG']['viewmusic_choose_reasons']; ?>
</div>
                <div class="clsTDText">
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
       			</div>
            </div>
			<div class="clsRow">
			 	<div class="clsTDLabel"><?php echo $this->_tpl_vars['LANG']['viewmusic_flag_comment']; ?>
&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span>&nbsp;</div>
				<div class="clsTDText">
                	<textarea name="flag_comment" id="flag_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="30" style="width:95%;" maxlength="5"></textarea>
				</div>
			</div>                 
			<div class="clsRow">
            	<div class="clsTDLabel"><!----></div>
			 	<div class="clsTDText">
					<p class="clsButton"><span><input type="button" name="add_to_flag" id="add_to_flag" value="<?php echo $this->_tpl_vars['LANG']['viewmusic_set_flag']; ?>
" onClick="addFlagContentAjax('<?php echo $this->_tpl_vars['flagContent']['url']; ?>
')" /></span></p>
				</div>
 			</div>
		</div>
		</form>
    </div>
</div>
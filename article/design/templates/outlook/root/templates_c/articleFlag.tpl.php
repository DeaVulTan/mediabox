<?php /* Smarty version 2.6.18, created on 2012-02-01 23:56:28
         compiled from articleFlag.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'articleFlag.tpl', 10, false),)), $this); ?>
    <div id="flagDiv" class="clsPopupConfirmation clsTextAlignLeft" style="display:none;">
        <div class="clsOverflow clsFlagTitle">
            <h2><?php echo $this->_tpl_vars['LANG']['viewarticle_flag_title']; ?>
</h2>
        </div>
        <div class="clsFlagInfo">
        	<p id="clsMsgDisplay_flag" class="clsDisplayNone"></p>
            <p><?php echo $this->_tpl_vars['LANG']['viewarticle_report_media']; ?>
</p>
            <p class="clsReason"><?php echo $this->_tpl_vars['LANG']['viewarticle_choose_reasons']; ?>
</p><br />
            <form name="flagFrm" id="flagFrm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <p><select name="flag" id="flag" tabindex="<?php echo smartyTabIndex(array(), $this);?>
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
                </select></p>
                <p><?php echo $this->_tpl_vars['LANG']['viewarticle_flag_comment']; ?>
&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_mandatory']; ?>
</span>&nbsp;</p>
                <p class="clsComments"><textarea name="flag_comment" id="flag_comment" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="5" cols="50" maxlength="5"></textarea></span></p>
                <div class="clsOverflow">
                    <div class="clsCommentsLeft">
                        <div class="clsCommentsRight">
                    <input type="button" name="add_to_flag" id="add_to_flag" value="<?php echo $this->_tpl_vars['LANG']['viewarticle_set_flag']; ?>
" onClick="return addToFlag(1, '<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
viewArticle.php?ajax_page=true&amp;page=flag&amp;article_id=<?php echo $this->_tpl_vars['myobj']->getFormField('article_id'); ?>
&amp;show=<?php echo $this->_tpl_vars['myobj']->getFormField('show'); ?>
')" />
                 	   </div>
                    </div>
                </div>
                <div class="clsRow" style="display:none" id="flag_loader_row">
                  	<div class="clsTDLabel"><!----></div>
                        <div class="clsTDText"><div id="flag_submitted"></div></div>
                </div>
            </form>
        </div>
    </div>
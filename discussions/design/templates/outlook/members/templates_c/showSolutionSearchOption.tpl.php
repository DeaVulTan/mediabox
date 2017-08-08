<?php /* Smarty version 2.6.18, created on 2011-10-18 14:50:03
         compiled from showSolutionSearchOption.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'showSolutionSearchOption.tpl', 4, false),)), $this); ?>
 <form name="selFormSearchBoard" id="selFormSearchBoard" method="post" onsubmit="return checkforSearchText(this.search_board, '<?php echo $this->_tpl_vars['showSolutionSearchOption_arr']['defaultText']; ?>
', '<?php echo $this->_tpl_vars['LANG']['header_enter_text_for_search']; ?>
');" action="<?php echo $this->_tpl_vars['showSolutionSearchOption_arr']['form_action']; ?>
">
	<div class="clsHeadSearch">
		<div class="clsSearchLeftButton">
		<input type="text" name="search_board" id="search_board" maxlength="250" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['showSolutionSearchOption_arr']['board_field_value']; ?>
" onBlur="displayDefaultValue(this, '<?php echo $this->_tpl_vars['showSolutionSearchOption_arr']['defaultText']; ?>
')" onclick="clearDefaultValue(this, '<?php echo $this->_tpl_vars['showSolutionSearchOption_arr']['defaultText']; ?>
')"/>
		</div>
        <input type="hidden" class="clsSearchSubmitButton" name="search" id="search" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['header_search']; ?>
" />
		<a href="#" class="clsSearchRightButton" onclick="javascript:document.getElementById('selFormSearchBoard').submit();"></a>
	</div>
	<div class="clsHeadAdvanceSearch">
		<a href="<?php echo $this->_tpl_vars['showSolutionSearchOption_arr']['advanced_search']['url']; ?>
" class=""></a>
	</div>
    </form>
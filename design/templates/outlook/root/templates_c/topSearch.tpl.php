<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from topSearch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'stripslashes', 'topSearch.tpl', 5, false),array('function', 'smartyTabIndex', 'topSearch.tpl', 5, false),)), $this); ?>
<?php if ($this->_tpl_vars['header']->display_search_form): ?>
<div class="clsTopSearchContainer">
    <form name="formCommonSearch" id="formCommonSearch" method="post" action="<?php echo $this->_tpl_vars['header']->search_form_action; ?>
" onsubmit="return chooseSearchSelect('<?php echo $this->_tpl_vars['populateSearchModules_arr'][0]['module']; ?>
', 'header')">
        <div class="clsTopSearchInput">
        	<input type="text" class="selAutoText" name="tags" id="searchTags_header" title="<?php echo $this->_tpl_vars['LANG']['header_search_text']; ?>
" value="<?php if ($this->_tpl_vars['header']->getFormField('tags')): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header']->getFormField('tags'))) ? $this->_run_mod_handler('stripslashes', true, $_tmp) : stripslashes($_tmp)); ?>
<?php elseif ($this->_tpl_vars['header']->getFormField('keyword') != ''): ?><?php echo $this->_tpl_vars['header']->getFormField('keyword'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['header_search_text']; ?>
<?php endif; ?>" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
        </div>
        <div class="<?php if ($this->_tpl_vars['populateSearchModules_arr']): ?>clsSearchModules<?php endif; ?> clsTopSearchIcon">
            <ul>
                <li class="selDropDownLink">
                    <a class="clsSearchLink" title="<?php echo $this->_tpl_vars['LANG']['common_search']; ?>
"><!----></a>
                    <ul class="clsTopSearchDropdownList">
                    	<div class="clsTopSearch-top"><div class="clsTopSearch-bottom"><div class="clsTopSearch-middle">
                        <?php $_from = $this->_tpl_vars['populateSearchModules_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['searchModule']):
?>
                            <li><a onclick="chooseSearchSelect('<?php echo $this->_tpl_vars['searchModule']['module']; ?>
', 'header')"><?php echo $this->_tpl_vars['searchModule']['label']; ?>
</a></li>
                        <?php endforeach; endif; unset($_from); ?>
                        </div></div></div>
                    </ul>
                </li>
            </ul>
        </div>
    </form>
</div>
<?php endif; ?>
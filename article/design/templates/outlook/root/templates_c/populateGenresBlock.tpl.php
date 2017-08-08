<?php /* Smarty version 2.6.18, created on 2011-11-03 12:05:01
         compiled from populateGenresBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateGenresBlock.tpl', 18, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsSideBarLinks">
<div class="clsSideBarLeft">
    <div class="clsSideBar">
        <p class="clsSideBarLeftTitle">
            <?php echo $this->_tpl_vars['LANG']['sidebar_genres_heading_label']; ?>

        </p>
        <span class=""></span>
    </div>
	<div class="clsSideBarRight clsOverflow">
    <div class="clsSideBarContent clsCategoryLists">
    <?php if ($this->_tpl_vars['populateGenres_arr']['record_count']): ?>
    	<ul>
        	<?php $this->assign('break_count', 1); ?>
            <?php $_from = $this->_tpl_vars['populateGenres_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genresKey'] => $this->_tpl_vars['genresValue']):
?>
            <li <?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['genresValue']['record']['article_category_id']): ?>class='clsActiveLink'<?php endif; ?>>
                <a id="ancGenres<?php echo $this->_tpl_vars['break_count']; ?>
"  class="" href="<?php echo $this->_tpl_vars['genresValue']['articlelist_url']; ?>
" title="<?php echo $this->_tpl_vars['genresValue']['record']['article_category_name']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['genresValue']['article_category_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 45) : smarty_modifier_truncate($_tmp, 45)); ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['genresValue']['articleCount']; ?>
)</span></a>
                                <ul  id="subGenresID<?php echo $this->_tpl_vars['break_count']; ?>
" style="display:<?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['genresValue']['record']['article_category_id']): ?>block<?php else: ?>none<?php endif; ?>;">
                	<?php $_from = $this->_tpl_vars['genresValue']['populateSubGenres']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subgenresKey'] => $this->_tpl_vars['subgenresValue']):
?>
                    	<li <?php if ($this->_tpl_vars['sid'] == $this->_tpl_vars['subgenresValue']['record']['article_category_id']): ?>class='clsActiveLink'<?php else: ?>class='clsInActiveLink'<?php endif; ?>><a href="<?php echo $this->_tpl_vars['subgenresValue']['articlelist_url']; ?>
" title="<?php echo $this->_tpl_vars['subgenresValue']['record']['article_category_name']; ?>
"><?php echo $this->_tpl_vars['subgenresValue']['article_category_name']; ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['subgenresValue']['articleCount']; ?>
)</span></a></li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
            	<?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
            </li>
            <?php endforeach; endif; unset($_from); ?>
	        <input type="hidden" value="<?php echo $this->_tpl_vars['break_count']; ?>
" id="genresCount"  name="genresCount" />
    	</ul>
        <p class="clsMoreTags"><a href="<?php echo $this->_tpl_vars['moregenres_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_more_label']; ?>
</a></p>
    <?php else: ?>
      	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_genres_found_error_msg']; ?>
</div>
    <?php endif; ?>
</div>
</div>
</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
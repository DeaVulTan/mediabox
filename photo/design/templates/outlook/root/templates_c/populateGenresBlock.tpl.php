<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from populateGenresBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateGenresBlock.tpl', 16, false),)), $this); ?>
      <div class="clsSideBarContent">
        <?php if ($this->_tpl_vars['populateGenres_arr']['record_count']): ?>
        	<div class="clsOverflow">
	            <ul class="clsPhotoSidebarLinks">
                <?php $this->assign('break_count', 1); ?>
                <?php $_from = $this->_tpl_vars['populateGenres_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genresKey'] => $this->_tpl_vars['genresValue']):
?>
                    <li class="<?php if ($this->_tpl_vars['cid'] == $this->_tpl_vars['genresValue']['record']['photo_category_id']): ?>clsActiveLink<?php endif; ?> ">
                        <table>
                        	<tr>
                                                         		<td>
                                	<a id="ancGenres<?php echo $this->_tpl_vars['break_count']; ?>
"  class="" href="<?php echo $this->_tpl_vars['genresValue']['photolist_url']; ?>
" title="<?php echo $this->_tpl_vars['genresValue']['record']['photo_category_name']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['genresValue']['wordWrap_mb_ManualWithSpace_photo_category_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['genresValue']['photoCount']; ?>
)</span></a>
                                </td>
                            </tr>
                        </table>
                                                <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
	            <input type="hidden" value="<?php echo $this->_tpl_vars['break_count']; ?>
" id="genresCount"  name="genresCount" >
    	    </ul>
            </div>
           <div class="clsOverflow">
            <div class="clsViewMoreLinks">
        	<p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['moregenres_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_view_all_category']; ?>
</a></p>
           </div>
          </div>
        <?php else: ?>
        	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_genres_found_error_msg']; ?>
</div>
        <?php endif; ?>
    </div>
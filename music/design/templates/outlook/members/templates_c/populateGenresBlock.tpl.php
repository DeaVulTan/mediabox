<?php /* Smarty version 2.6.18, created on 2011-10-17 14:55:34
         compiled from populateGenresBlock.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clsAudioIndex clsCategoryHd clsindexCategriesBlock">
        <h3><?php echo $this->_tpl_vars['LANG']['sidebar_genres_heading_label']; ?>
</h3>
        <?php if ($this->_tpl_vars['populateGenres_arr']['record_count']): ?>
            <ul class="clsOverflow">
                <?php $this->assign('break_count', 1); ?> 
                <?php $_from = $this->_tpl_vars['populateGenres_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genresKey'] => $this->_tpl_vars['genresValue']):
?>
                    <li>        
                       <div class="clsOverflow">
                            <span class="clsTDLinks clsSidelinkLeft">
                                    <a id="ancGenres<?php echo $this->_tpl_vars['break_count']; ?>
"  class="" href="<?php echo $this->_tpl_vars['genresValue']['musiclist_url']; ?>
" title="<?php echo $this->_tpl_vars['genresValue']['record']['music_category_name']; ?>
"><?php echo $this->_tpl_vars['genresValue']['wordWrap_mb_ManualWithSpace_music_category_name']; ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['genresValue']['musicCount']; ?>
)</span></a>
                               </span>
                              <span class="clsSidelinkRight">                   
                                    <?php if ($this->_tpl_vars['genresValue']['populateSubGenres']['record_count']): ?>
	                                    <a class="clsShowSubmenuLinks" href="javascript:void(0)" id="mainGenresID<?php echo $this->_tpl_vars['break_count']; ?>
" onClick="showHideMenu('ancGenres', 'subGenresID', '<?php echo $this->_tpl_vars['break_count']; ?>
', 'genresCount', 'mainGenresID')">show</a>
                                    <?php endif; ?>
								</span>
                            </div>
                        <?php if ($this->_tpl_vars['genresValue']['populateSubGenres']['record_count']): ?>                                
                                <ul  id="subGenresID<?php echo $this->_tpl_vars['break_count']; ?>
" style="display:none;">
                                    <?php $_from = $this->_tpl_vars['genresValue']['populateSubGenres']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subgenresKey'] => $this->_tpl_vars['subgenresValue']):
?>
                                        <li><a href="<?php echo $this->_tpl_vars['subgenresValue']['musiclist_url']; ?>
" title="<?php echo $this->_tpl_vars['subgenresValue']['record']['music_category_name']; ?>
"><?php echo $this->_tpl_vars['subgenresValue']['wordWrap_mb_ManualWithSpace_music_category_name']; ?>
 &nbsp;<span>(<?php echo $this->_tpl_vars['subgenresValue']['musicCount']; ?>
)</span></a></li>
                                    <?php endforeach; endif; unset($_from); ?>
                                </ul>	
                         <?php endif; ?>   
                    </li>
                    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>                    
                <?php endforeach; endif; unset($_from); ?>	            
    	    </ul>
            <input type="hidden" value="<?php echo $this->_tpl_vars['break_count']; ?>
" id="genresCount"  name="genresCount" />
        	<p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['moregenres_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['sidebar_more_label']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_view_all_category']; ?>
</a></p>
        <?php else: ?>	
        	<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_genres_found_error_msg']; ?>
</div>
        <?php endif; ?>
    </div>          
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
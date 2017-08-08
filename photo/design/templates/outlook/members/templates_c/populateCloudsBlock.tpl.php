<?php /* Smarty version 2.6.18, created on 2011-10-17 14:53:22
         compiled from populateCloudsBlock.tpl */ ?>
<?php if ($this->_tpl_vars['opt'] == 'photo'): ?>
        <div class="clsSideBarContent">
            <?php if ($this->_tpl_vars['populateCloudsBlock']['resultFound']): ?>
                <p class="clsPhotoTags">
                    <?php $_from = $this->_tpl_vars['populateCloudsBlock']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
                        <span class="<?php echo $this->_tpl_vars['tag']['class']; ?>
"><a style="font-size: 13px;" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" title="<?php echo $this->_tpl_vars['tag']['name']; ?>
"><?php echo $this->_tpl_vars['tag']['name']; ?>
</a></span>
                    <?php endforeach; endif; unset($_from); ?>
                 </p>
                <div class="clsOverflow">
                 <div class="clsViewMoreLinks">
	             <p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['moreclouds_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_view_all_label_tags']; ?>
</a></p>
                </div>
               </div>
            <?php else: ?>
               <div><p class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_photoclouds_found_error_msg']; ?>
</p></div>
			<?php endif; ?>
        </div>
<?php elseif ($this->_tpl_vars['opt'] == 'playlist'): ?>
        <div class="clsSideBarContent">
            <?php if ($this->_tpl_vars['populateCloudsBlock']['resultFound']): ?>
                <p class="clsPhotoTags">
                    <?php $_from = $this->_tpl_vars['populateCloudsBlock']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
                        <span class="<?php echo $this->_tpl_vars['tag']['class']; ?>
"><a style="font-size: 13px;" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" title="<?php echo $this->_tpl_vars['tag']['name']; ?>
" ><?php echo $this->_tpl_vars['tag']['name']; ?>
</a></span>
                    <?php endforeach; endif; unset($_from); ?>
                 </p>
              <div class="clsOverflow">
               <div class="clsViewMoreLinks">
	            <p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['moreclouds_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_view_all_label_tags']; ?>
</a></p>
               </div>
              </div>
            <?php else: ?>
	           <div class="clsNoRecordsFound"> <?php echo $this->_tpl_vars['LANG']['sidebar_no_playlistclouds_found_error_msg']; ?>
</div>
            <?php endif; ?>
        </div>
<?php endif; ?>
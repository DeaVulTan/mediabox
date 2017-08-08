<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:48
         compiled from populateCloudsBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'music' ) ) || chkAllowedModule ( array ( 'video' ) ) || chkAllowedModule ( array ( 'photo' ) )): ?>
    <?php if (chkAllowedModule ( array ( 'music' ) )): ?>
        <?php if ($this->_tpl_vars['opt'] == 'music'): ?>
            <?php $this->assign('cloud_block_head', $this->_tpl_vars['LANG']['sidebar_music_clouds_heading_label']); ?>
            <?php $this->assign('cloud_no_record', $this->_tpl_vars['LANG']['sidebar_no_musicclouds_found_error_msg']); ?>
        <?php elseif ($this->_tpl_vars['opt'] == 'artist'): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
                <?php $this->assign('cloud_block_head', $this->_tpl_vars['LANG']['sidebar_cast_clouds_heading_label']); ?>
                <?php $this->assign('cloud_no_record', $this->_tpl_vars['LANG']['sidebar_no_castclouds_found_error_msg']); ?>
            <?php else: ?>
                <?php $this->assign('cloud_block_head', $this->_tpl_vars['LANG']['sidebar_artist_clouds_heading_label']); ?>
                <?php $this->assign('cloud_no_record', $this->_tpl_vars['LANG']['sidebar_no_artistclouds_found_error_msg']); ?>
            <?php endif; ?>
        <?php elseif ($this->_tpl_vars['opt'] == 'playlist'): ?>
            <?php $this->assign('cloud_block_head', $this->_tpl_vars['LANG']['sidebar_playlist_clouds_heading_label']); ?>
            <?php $this->assign('cloud_no_record', $this->_tpl_vars['LANG']['sidebar_no_playlistclouds_found_error_msg']); ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (chkAllowedModule ( array ( 'video' ) )): ?>
    	<?php if ($this->_tpl_vars['opt'] == 'video'): ?>    
            <?php $this->assign('cloud_block_head', $this->_tpl_vars['LANG']['sidebar_video_clouds_heading_label']); ?>
            <?php $this->assign('cloud_no_record', $this->_tpl_vars['LANG']['sidebar_no_videoclouds_found_error_msg']); ?>
        <?php endif; ?>
    <?php endif; ?>    
    <?php if (chkAllowedModule ( array ( 'photo' ) )): ?>    
    	<?php if ($this->_tpl_vars['opt'] == 'photo'): ?>    
            <?php $this->assign('cloud_block_head', $this->_tpl_vars['LANG']['sidebar_photo_clouds_heading_label']); ?>
            <?php $this->assign('cloud_no_record', $this->_tpl_vars['LANG']['sidebar_no_photoclouds_found_error_msg']); ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'tags_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div class="clsTagsContainer">
            <?php if ($this->_tpl_vars['populateCloudsBlock']['resultFound']): ?>
                <p class="clsAudioTags">
                    <?php $_from = $this->_tpl_vars['populateCloudsBlock']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
                        <span class="<?php echo $this->_tpl_vars['tag']['class']; ?>
"><a <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
 href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" title="<?php echo $this->_tpl_vars['tag']['name']; ?>
" ><?php echo $this->_tpl_vars['tag']['name']; ?>
</a></span>
                    <?php endforeach; endif; unset($_from); ?>
                 </p>
                <p class="clsViewMore"><a href="<?php echo $this->_tpl_vars['moreclouds_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_view_all_label_tags']; ?>
</a></p>
            <?php else: ?>
                 <div class="clsNoRecordsFound"> <?php echo $this->_tpl_vars['cloud_no_record']; ?>
</div>        		 
            <?php endif; ?>
        </div>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',''); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'tags_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:06
         compiled from mainIndexMusicPlayer.tpl */ ?>
<div class="clsIndexMusicBlockPlayer" >
<?php if (isset ( $this->_tpl_vars['mainIndexObj']->main_player_music_title )): ?><h3><?php echo $this->_tpl_vars['mainIndexObj']->main_player_music_title; ?>
</h3><?php endif; ?>
     <?php if ($this->_tpl_vars['mainIndexObj']->valid_music_details): ?>
                <?php echo $this->_tpl_vars['mainIndexObj']->populateSinglePlayer($this->_tpl_vars['music_fields']); ?>

            <?php else: ?>
        <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['mainIndex_music_no_record']; ?>
</div>
    <?php endif; ?>           	
</div>

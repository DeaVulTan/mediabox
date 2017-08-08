<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:10
         compiled from viewMusicMoreContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'viewMusicMoreContent.tpl', 9, false),)), $this); ?>
<div class="clsSideCaroselContainer clsOverflow">
    <?php if ($this->_tpl_vars['myobj']->total_records): ?>
        <?php $_from = $this->_tpl_vars['relatedMusic']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
            <div class="clsViewPageSideContainer">
                <div class="clsViewPageSideImage">
                    <div class="clsThumbImageLink clsThumbImageBackground">
                        <a href="<?php echo $this->_tpl_vars['result']['music_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls144x110">
							<?php if ($this->_tpl_vars['result']['record']['music_thumb_ext']): ?>
								<img src="<?php echo $this->_tpl_vars['result']['music_image_src']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_music_thumb_width'],$this->_config[0]['vars']['image_music_thumb_height'],$this->_tpl_vars['result']['record']['thumb_width'],$this->_tpl_vars['result']['record']['thumb_height']); ?>
 />
							<?php else: ?>
								<img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" title="<?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"/>
							<?php endif; ?>    
                        </a>
                    </div>
                    <div class="clsTime"><?php echo $this->_tpl_vars['result']['playing_time']; ?>
</div>
					
					 <div class="clsViewPageSideContent">
                    <p class="clsName"><a href="<?php echo $this->_tpl_vars['result']['music_url']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
"><?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
</a></p>
                </div>
                </div>
               
            </div>
        <?php endforeach; endif; unset($_from); ?>
         <div id="selNextPrev" style="display:none">
            <input type="button" href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['common_previous']; ?>
" <?php if ($this->_tpl_vars['myobj']->leftButtonExist): ?> onclick="moveMusicSetToLeft(this, '<?php echo $this->_tpl_vars['myobj']->pg; ?>
')" <?php endif; ?> value="" id="musicPrevButton_<?php echo $this->_tpl_vars['myobj']->pg; ?>
" class="<?php echo $this->_tpl_vars['myobj']->leftButtonClass; ?>
" />
            <input type="button" href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['common_next']; ?>
" <?php if ($this->_tpl_vars['myobj']->rightButtonExists): ?> onclick="moveMusicSetToRight(this, '<?php echo $this->_tpl_vars['myobj']->pg; ?>
')"<?php endif; ?> value="" id="musicNextButton_<?php echo $this->_tpl_vars['myobj']->pg; ?>
" class="<?php echo $this->_tpl_vars['myobj']->rightButtonClass; ?>
" />
        </div>
    <?php else: ?>
    	<div id="selNextPrev" style="display:none">
        </div>
        <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['viewmusic_no_related_musics_found']; ?>
</div>
    <?php endif; ?>
</div>
<?php /* Smarty version 2.6.18, created on 2011-10-17 15:01:19
         compiled from viewMusicMorePeopleListened.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'viewMusicMorePeopleListened.tpl', 11, false),)), $this); ?>
<div class="clsSideCaroselContainer clsOverflow">

        <?php if ($this->_tpl_vars['myobj']->listened_total_records): ?>
        <?php $_from = $this->_tpl_vars['peopleListened']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
           <div class="clsViewPageSideContainer clsOverflow">
                   <div class="clsViewPageSideImageListening">
                      <div class="clsThumbImageLink clsThumbImageBackground">
                          <a href="<?php echo $this->_tpl_vars['result']['music_url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls106x82">
							  <?php if ($this->_tpl_vars['result']['record']['music_thumb_ext']): ?>
								  <img src="<?php echo $this->_tpl_vars['result']['music_image_src']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(104,80,$this->_tpl_vars['result']['record']['thumb_width'],$this->_tpl_vars['result']['record']['thumb_height']); ?>
/>
							  <?php else: ?>
								  <img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_M.jpg" title="<?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
"/>
							  <?php endif; ?> 
                          </a>
                      </div>
                      <div class="clsTime"><!----><?php echo $this->_tpl_vars['result']['playing_time']; ?>
</div>
                  </div>
                  <div class="clsViewPageSideContent clsFloatLeft clspepolListenRight">
                      <p class="clsName"><a href="<?php echo $this->_tpl_vars['result']['music_url']; ?>
"><?php echo $this->_tpl_vars['result']['record']['music_title']; ?>
</a></p>
                      <p class="clsListenLbum"><span><?php echo $this->_tpl_vars['LANG']['viewmusic_album_title']; ?>
: </span><a href="<?php echo $this->_tpl_vars['result']['viewalbum_url']; ?>
"><?php echo $this->_tpl_vars['result']['album_title']; ?>
</a></p>
					  <p class="clsListenGenres"><span><?php echo $this->_tpl_vars['LANG']['music_genre_in']; ?>
</span><a href="<?php echo $this->_tpl_vars['result']['musiccategory_url']; ?>
"><?php echo $this->_tpl_vars['result']['music_category_name']; ?>
</a></p>
                      <p class="clsListenPlayscount"><?php echo $this->_tpl_vars['LANG']['viewmusic_plays_label']; ?>
: <span><?php echo $this->_tpl_vars['result']['record']['total_plays']; ?>
</span></p>
                  </div>
		</div>
         <?php endforeach; endif; unset($_from); ?>
         <input type="hidden" name="listenedstart" id="listenedstart" value="<?php echo $this->_tpl_vars['myobj']->getFormField('listenedstart'); ?>
" />
     <?php else: ?>
     	<div class="clsNoRecordsFound" ><?php echo $this->_tpl_vars['LANG']['viewmusic_no_related_musics_found']; ?>
</div>
     <?php endif; ?>
</div>     
    <div id="people_listened_Paging" class="clsAudioCarouselPaging"  style="display:none" >
	<?php if ($this->_tpl_vars['myobj']->listened_total_records): ?> 
      <ul>
        <li><a  id="Previous" class="<?php echo $this->_tpl_vars['myobj']->activeClsPrevious; ?>
" <?php if ($this->_tpl_vars['myobj']->isPreviousButton): ?> onclick="getPeopleListenedMusic('Previous')" <?php endif; ?> href="javascript:void(0);"><?php echo $this->_tpl_vars['LANG']['viewmusic_previous_label']; ?>
</a></li>
        <li><a  id="Next" class="<?php echo $this->_tpl_vars['myobj']->activeClsNext; ?>
" <?php if ($this->_tpl_vars['myobj']->isNextButton): ?> onclick="getPeopleListenedMusic('Next')" <?php endif; ?> href="javascript:void(0);"><?php echo $this->_tpl_vars['LANG']['viewmusic_next_label']; ?>
</a></li>
      </ul>
  <?php endif; ?>
</div>
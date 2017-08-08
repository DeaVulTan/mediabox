<?php /* Smarty version 2.6.18, created on 2011-10-19 10:53:02
         compiled from relatedVideo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'relatedVideo.tpl', 35, false),)), $this); ?>
<div class="clsViewVideoDetailsContent">
      <?php if ($this->_tpl_vars['myobj']->total_records): ?>
            <div id="selVideoDisp" class="clsOverflow clsPaddingLeft10">
             <table cellpadding="0" cellspacing="0">
          <?php $_from = $this->_tpl_vars['relatedVideo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
                  <?php if ($this->_tpl_vars['result']['open_tr']): ?>
                        <tr>
                  <?php endif; ?>
                  <td class="clsQuickLinkImageWidth">
                        <ul class="clsRelatedVideos">
                  <li>
                   <?php if ($this->_tpl_vars['result']['playing_time']): ?>
                        <div class="clsRunTime"><?php echo $this->_tpl_vars['result']['playing_time']; ?>
</div>
                   <?php endif; ?>

                      <?php if ($this->_tpl_vars['result']['allow_quick_links'] && $this->_tpl_vars['result']['record']['is_external_embed_video'] != 'Yes'): ?>
                          <div id="<?php echo $this->_tpl_vars['result']['quickLinkId']; ?>
" class="clsTopQuickLinks">
                              <?php if (rayzzMvInKL ( $this->_tpl_vars['result']['record']['video_id'] )): ?>
					    <a id="<?php echo $this->_tpl_vars['result']['quickLinkId']; ?>
_added" title="<?php echo $this->_tpl_vars['LANG']['add_to_quick_links_added']; ?>
" class="clsPhotoVideoEditLinks"><img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-addvideo.gif" /></a>
                                  <a id="<?php echo $this->_tpl_vars['result']['quickLinkId']; ?>
_add" class="clsPhotoVideoEditLinks" onclick="updateVideosQuickLinksCount('<?php echo $this->_tpl_vars['result']['record']['video_id']; ?>
','<?php echo $this->_tpl_vars['myobj']->pg; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['add_to_quick_links']; ?>
" style="display:none;">
                                  	<img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-addvideo_added.gif"/>
                                  </a>
                              <?php else: ?>
                                  <a id="<?php echo $this->_tpl_vars['result']['quickLinkId']; ?>
_add" class="clsPhotoVideoEditLinks" onclick="updateVideosQuickLinksCount('<?php echo $this->_tpl_vars['result']['record']['video_id']; ?>
','<?php echo $this->_tpl_vars['myobj']->pg; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['add_to_quick_links']; ?>
">
                                  	<img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-addvideo_added.gif"/>
                                  </a>
                                  <a id="<?php echo $this->_tpl_vars['result']['quickLinkId']; ?>
_added" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['add_to_quick_links_added']; ?>
" style="display:none;">
                                      <img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-addvideo.gif"/>
                                  </a>
                              <?php endif; ?>
                          </div>
                      <?php endif; ?>
                        <div class="clsOverFlow">
                           <a href="<?php echo $this->_tpl_vars['result']['videoLink']; ?>
" class="Cls144x110 ClsImageContainer ClsImageBorder1">
                              <img src="<?php echo $this->_tpl_vars['result']['imageSrc']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['video_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 15) : smarty_modifier_truncate($_tmp, 15)); ?>
" <?php echo $this->_tpl_vars['result']['imageDisp']; ?>
 />
                           </a>
                      </div>
                      <div class="clsClearLeft">
                          <p id="selMemberName">
                              <a href="<?php echo $this->_tpl_vars['result']['videoLink']; ?>
" title="<?php echo $this->_tpl_vars['result']['video_title']; ?>
"><?php echo $this->_tpl_vars['result']['video_title']; ?>
</a>
                          </p>
                          <!-- <p><?php echo $this->_tpl_vars['LANG']['common_from']; ?>
: <?php echo $this->_tpl_vars['result']['name']; ?>
</p>
                          <p><?php echo $this->_tpl_vars['LANG']['views']; ?>
:<span class="clsBold"> <?php echo $this->_tpl_vars['result']['record']['total_views']; ?>
</span></p>-->
                      </div>
                  </li>
                 </ul>
                 </td>
                 <?php if ($this->_tpl_vars['result']['end_tr']): ?>
                        </tr>
                  <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>
             </table>
          </div>
      <?php else: ?>
            <div class="clsNoVideo">
          <p><?php echo $this->_tpl_vars['LANG']['no_related_videos_found']; ?>
</p>
          </div>
      <?php endif; ?>
      <div id="selNextPrev" class="clsRelatedPreviousNext clsDisplayNone">
            <input type="button" <?php if ($this->_tpl_vars['myobj']->leftButtonExist): ?> onclick="moveVideoSetToLeft(this, '<?php echo $this->_tpl_vars['myobj']->pg; ?>
')" <?php endif; ?> value="" id="videoPrevButton_<?php echo $this->_tpl_vars['myobj']->pg; ?>
" class="<?php echo $this->_tpl_vars['myobj']->leftButtonClass; ?>
"/>
            <input type="button" <?php if ($this->_tpl_vars['myobj']->rightButtonExists): ?> onclick="moveVideoSetToRight(this, '<?php echo $this->_tpl_vars['myobj']->pg; ?>
')"<?php endif; ?> value="" id="videoNextButton_<?php echo $this->_tpl_vars['myobj']->pg; ?>
" class="<?php echo $this->_tpl_vars['myobj']->rightButtonClass; ?>
" />
      </div>
</div>
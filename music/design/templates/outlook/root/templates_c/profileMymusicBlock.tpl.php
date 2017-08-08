<?php /* Smarty version 2.6.18, created on 2011-10-26 21:03:03
         compiled from profileMymusicBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'music' ) ) && $this->_tpl_vars['fanblock']): ?>
<?php echo $this->_tpl_vars['myobj']->chkTemplateImagePathForModuleAndSwitch('music',$this->_tpl_vars['CFG']['html']['template']['default'],$this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']); ?>

<div class="clsMusicShelfTable">
 <table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
>
        <tr>
          <th colspan="2">
          	  <div class="clsProfileMusicBlockTitle"><?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
 <span><?php echo $this->_tpl_vars['LANG']['viewprofile_shelf_musics']; ?>
</span></div>
              <div class="clsProfileMusicBlockLink">
              		                    <?php if ($this->_tpl_vars['myprofileObj']->isEditableLinksAllowed() && isAllowedMusicUpload ( )): ?>
                        <a class="clsProfileMusicUpload" href="<?php echo $this->_tpl_vars['myprofileObj']->getUrl('musicuploadpopup','','','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['myprofile_link_view_musics_upload']; ?>
"><?php echo $this->_tpl_vars['LANG']['myprofile_link_view_musics_upload']; ?>
</a>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
              </div>
          </th>
        </tr>
  <?php if ($this->_tpl_vars['music_list_arr'] == 0): ?>
        <tr>
          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> <?php echo $this->_tpl_vars['LANG']['myprofile_musics_no_msg']; ?>
</p></div></div></td>
        </tr>
  <?php else: ?>
        <tr>
          <td colspan="2">
              <div class="clsProfileTableInfo">

                <table class="clsMusicShelf" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['musics_list']; ?>
">
                <tr>
                 <?php $_from = $this->_tpl_vars['music_list_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                <td class="clsMusicBlockDetails">
                  <div class="clsOverflow">
                      <div class="clsThumbImageLink">
                        <a class="ClsImageContainer ClsImageBorder1 Cls93x70" href="<?php echo $this->_tpl_vars['value']['musicUrl']; ?>
">
                             <img src="<?php echo $this->_tpl_vars['value']['music_path']; ?>
"  title="<?php echo $this->_tpl_vars['value']['wrap_music_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(93,70,$this->_tpl_vars['value']['thumb_width'],$this->_tpl_vars['value']['thumb_height']); ?>
 />
                         </a>
                       </div>
                   </div>
                  <div class="clsProfileMusicTime"><?php echo $this->_tpl_vars['value']['playing_time']; ?>
</div>
                  <div class="clsMusicShelfDet">
                  <p class="clsName"><span></span><a href="<?php echo $this->_tpl_vars['value']['musicUrl']; ?>
" title="<?php echo $this->_tpl_vars['value']['wrap_music_title']; ?>
"><?php echo $this->_tpl_vars['value']['wrap_music_title']; ?>
</a></p>
                                                      <p><span><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
:</span> <?php echo $this->_tpl_vars['value']['total_views']; ?>
</p>
                  </div>
                </td>
                <?php endforeach; endif; unset($_from); ?>
                </tr>
                </table>
              </div>
		 	</td>
		 </tr>
		 <td colspan="2" class="clsMoreBgMusicCols">
		  <div class="clsMusicViewMoreLink">
				<?php if ($this->_tpl_vars['musicDisplayed']): ?>
					<a href="<?php echo $this->_tpl_vars['usermusiclistURL']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['myprofile_link_view_musics']; ?>
"><?php echo $this->_tpl_vars['LANG']['myprofile_link_view_musics']; ?>
</a>
				<?php endif; ?>
		  </div>
		</td>  
  <?php endif; ?> </table>
</div>
<?php endif; ?>
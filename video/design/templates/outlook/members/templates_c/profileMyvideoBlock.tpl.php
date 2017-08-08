<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileMyvideoBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'video' ) )): ?>
<div class="clsVideoShelfTable">
 <table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
>
        <tr>
          <th colspan="2">
          	 <div class="clsOverflow">
                  <div class="clsProfileVideoBlockTitle"><?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
 <span><?php echo $this->_tpl_vars['LANG']['myprofile_shelf_videos']; ?>
</span></div>
                  <div class="clsProfileVideoBlockLink">
                        <?php if ($this->_tpl_vars['myprofileObj']->isEditableLinksAllowed()): ?>  
                            <a class="clsProfileVideoUpload" href="<?php echo $this->_tpl_vars['myprofileObj']->getUrl('videouploadpopup','','','','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['viewprofile_link_view_videos_upload']; ?>
</a>
                        <?php else: ?>
                            &nbsp;
                        <?php endif; ?>
                  </div>
              </div>
          </th>
        </tr>
  <?php if ($this->_tpl_vars['video_list_arr'] == 0): ?>
        <tr>
          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> <?php echo $this->_tpl_vars['LANG']['viewprofile_videos_no_msg']; ?>
</p></div></div></td>
        </tr>
  <?php else: ?>
        <tr>
          <td colspan="2">
              <div class="clsProfileTableInfo">
			  <table class="clsVideoShelf" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['videos_list']; ?>
">
                <tr>
                 <?php $_from = $this->_tpl_vars['video_list_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                <td class="clsVideoBlockDetails"> 
				 <div class="clsOverflow">
                    <div class="clsThumbImageLink">                 
					  <a class="ClsImageContainer ClsImageBorder1 Cls93x70" href="<?php echo $this->_tpl_vars['value']['videoUrl']; ?>
">
						<img src="<?php echo $this->_tpl_vars['value']['video_path']; ?>
" title="<?php echo $this->_tpl_vars['value']['video_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(93,70,$this->_tpl_vars['value']['t_width'],$this->_tpl_vars['value']['t_height']); ?>
/>
					  </a>
					 </div>
				 </div>	  
                  <div class="clsProfileVideoTime"><?php echo $this->_tpl_vars['value']['playing_time']; ?>
</div>
                  <p class="clsProfileVideoTitle"><!--<span><?php echo $this->_tpl_vars['LANG']['myprofile_featured_videos_title']; ?>
:</span>&nbsp;--><a href="<?php echo $this->_tpl_vars['value']['videoUrl']; ?>
" title="<?php echo $this->_tpl_vars['value']['video_title']; ?>
"><?php echo $this->_tpl_vars['value']['video_wrap_title']; ?>
</a></p>
                  <div class="clsProfileVideoDes">
                  	<p><span><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
:</span>&nbsp;<?php echo $this->_tpl_vars['value']['total_views']; ?>
</p>
                  </div>
                </td>
                <?php endforeach; endif; unset($_from); ?>
                </tr>
                </table>
              </div>
		 	</td>
		 </tr>
		  <td colspan="2" class="clsMoreBgVideoCols">
		  <div class="clsVideoViewMoreLink">
				<?php if ($this->_tpl_vars['videoDisplayed']): ?>
					<a href="<?php echo $this->_tpl_vars['uservideolistURL']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewprofile_link_view_videos']; ?>
</a>
				<?php endif; ?>
		  </div>
   	</td>
  <?php endif; ?> </table>
</div>
<?php endif; ?>
<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileMyphotoBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'photo' ) ) && isAllowedPhotoUpload ( )): ?>
<div class="clsPhotoShelfTable">
 <table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
>
        <tr>
          <th colspan="2">
          	  <div class="clsProfilePhotoBlockTitle"><?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
 <?php echo $this->_tpl_vars['LANG']['viewprofile_shelf_photos']; ?>
</div>
              <div class="clsProfilePhotoBlockLink">
              		                    <?php if ($this->_tpl_vars['myprofileObj']->isEditableLinksAllowed() && isAllowedPhotoUpload ( )): ?>
                        <a class="clsProfilePhotoUpload" href="<?php echo $this->_tpl_vars['myprofileObj']->getUrl('photouploadpopup','','','','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['myprofile_link_view_photos_upload']; ?>
</a>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
              </div>
          </th>
        </tr>
  <?php if ($this->_tpl_vars['photo_list_arr'] == 0): ?>
        <tr>
          <td colspan="2"><div class="clsProfileTableInfo"><div id="selMsgAlert" class=""><p> <?php echo $this->_tpl_vars['LANG']['myprofile_photos_no_msg']; ?>
</p></div></div></td>
        </tr>
  <?php else: ?>
        <tr>
          <td colspan="2">
              <div class="clsProfileTableInfo">
                <table class="clsPhotoShelf" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['myphotos_list']; ?>
">
                <?php $this->assign('i', 0); ?>
                <?php $_from = $this->_tpl_vars['photo_list_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                <?php if ($this->_tpl_vars['i'] % 4 == 0): ?>
                <tr>
                <?php endif; ?>
                <td class="clsPhotoBlockDetails">
					<a class="Cls93x70 clsPhotoImageHolder clsPhotoImageBorder" href="<?php echo $this->_tpl_vars['value']['photoUrl']; ?>
">
						 <img src="<?php echo $this->_tpl_vars['value']['photo_path']; ?>
"  title="<?php echo $this->_tpl_vars['value']['wrap_photo_title']; ?>
" alt="<?php echo $this->_tpl_vars['value']['wrap_photo_title']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(93,70,$this->_tpl_vars['value']['s_width'],$this->_tpl_vars['value']['s_height']); ?>
/>
					</a>
					<div class="clsPhotoShelfDet">
                  		<p class="clsName"><span></span><a href="<?php echo $this->_tpl_vars['value']['photoUrl']; ?>
" title="<?php echo $this->_tpl_vars['value']['wrap_photo_title']; ?>
"><?php echo $this->_tpl_vars['value']['wrap_photo_title']; ?>
</a></p>
                  		                  		                  		<p><span><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
:</span>&nbsp;<?php echo $this->_tpl_vars['value']['total_views']; ?>
</p>
                    </div>
                </td><?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
                <?php if ($this->_tpl_vars['i'] % 4 == 0): ?>
                </tr>
                <?php endif; ?>                
                <?php endforeach; endif; unset($_from); ?>
               
                </table>
              </div>
		 	</td>
		 </tr>
		 <td colspan="2" class="clsMoreBgPhotoCols">
		  <div class="clsPhotoViewMoreLink">
			<?php if ($this->_tpl_vars['photoDisplayed']): ?>
				<a href="<?php echo $this->_tpl_vars['userphotolistURL']; ?>
"><?php echo $this->_tpl_vars['LANG']['myprofile_link_view_photos']; ?>
</a>
			<?php endif; ?>
		  </div>
        </td>			  
  <?php endif; ?> </table>
</div>
<?php endif; ?>
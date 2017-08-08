<?php /* Smarty version 2.6.18, created on 2011-10-17 14:55:21
         compiled from photoActivity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'photoActivity.tpl', 8, false),array('modifier', 'ucwords', 'photoActivity.tpl', 56, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['photoActivity_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['photoValue']):
?>
   <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['photoValue']['parent_id']): ?>
    	<?php if ($this->_tpl_vars['photoValue']['action_key'] == 'photo_uploaded'): ?>
<div class="clsWhatsGoingUserDetails">
  <div class="clsWhatsGoingBg clsOverflow">
       <div class="clsFloatLeft">
           <a href="<?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['uploaded_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
              <img src="<?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_uploaded']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_uploaded']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_uploaded']['user_photo']['imgsrc']['s_height']); ?>
/>
            </a>
        </div>
      <div class="clsUserDetailsFriends">
                <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['uploaded_user']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['user_name']; ?>
 </a>  </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['date_added']; ?>
</span> </div>
               </div>
               <div class="clsUserActivityWhtsgoing">
                        <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_upload.gif" alt="" border="0" />
                       <?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['lang']; ?>

                    <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_uploaded']['photo_title']; ?>
 </a>
               </div>
      </div>
  </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_comment'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
              <a href="<?php echo $this->_tpl_vars['photoValue']['photo_comment']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="<?php echo $this->_tpl_vars['photoValue']['photo_comment']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_comment']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_comment']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_comment']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_comment']['user_photo']['imgsrc']['s_height']); ?>
/>
              </a>
          </div>
      <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['photo_comment']['comment_user']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_comment']['user_name']; ?>
 </a> </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_comment']['date_added']; ?>
</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                    <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_comment.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['photo_comment']['lang']; ?>

                    <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_comment']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_comment']['photo_title']; ?>
 </a>
                  
              </div>
      </div>
   </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_rated'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
             <a href="<?php echo $this->_tpl_vars['photoValue']['photo_rated']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="<?php echo $this->_tpl_vars['photoValue']['photo_rated']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_rated']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_rated']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_rated']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_rated']['user_photo']['imgsrc']['s_height']); ?>
/>
              </a>
          </div>
         <div class="clsUserDetailsFriends">
                 <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['photo_rated']['comment_user']['url']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_rated']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
 </a>  </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_rated']['date_added']; ?>
</span> </div>
                </div>
                <div class="clsUserActivityWhtsgoing">
               		<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_rated.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['photo_rated']['lang']; ?>
 
                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_rated']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_rated']['photo_title']; ?>
 </a>
                </div>
        </div>
    </div>
 </div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_favorite'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="<?php echo $this->_tpl_vars['photoValue']['photo_favorite']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                <img src="<?php echo $this->_tpl_vars['photoValue']['photo_favorite']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_favorite']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_favorite']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_favorite']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_favorite']['user_photo']['imgsrc']['s_height']); ?>
/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['photo_favorite']['comment_user']['url']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_favorite']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
 </a> </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_favorite']['date_added']; ?>
</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_favourite.gif" alt="" border="0" />
                     <?php echo $this->_tpl_vars['photoValue']['photo_favorite']['lang']; ?>

                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_favorite']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_favorite']['photo_title']; ?>
 </a>
              </div>
          </div>
    </div>
 </div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_featured'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
           <div class="clsFloatLeft">
               <a href="<?php echo $this->_tpl_vars['photoValue']['photo_featured']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                <img src="<?php echo $this->_tpl_vars['photoValue']['photo_featured']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_featured']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_featured']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_featured']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_featured']['user_photo']['imgsrc']['s_height']); ?>
/>
               </a>
           </div>
         <div class="clsUserDetailsFriends">
                 <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['photo_featured']['comment_user']['url']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_featured']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
 </a> </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_featured']['date_added']; ?>
</span> </div>
                </div>
                <div class="clsUserActivityWhtsgoing">
                    <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_featured.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['photo_featured']['lang']; ?>

                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_featured']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_featured']['photo_title']; ?>
 </a>
                </div>
          </div>
    </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_responded'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="<?php echo $this->_tpl_vars['photoValue']['photo_responded']['responses_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="<?php echo $this->_tpl_vars['photoValue']['photo_responded']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_responded']['responses_user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_responded']['responses_user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_responded']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_responded']['user_photo']['imgsrc']['s_height']); ?>
/>
              </a>
          </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['photo_responded']['responses_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_responded']['responses_user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>  </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_responded']['date_added']; ?>
</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_response.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['photo_responded']['lang']; ?>

                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_responded']['old_viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_responded']['old_photo_title']; ?>
 </a>
              </div>
          </div>
    </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_share'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
            <a href="<?php echo $this->_tpl_vars['photoValue']['photo_share']['sender']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                   <img src="<?php echo $this->_tpl_vars['photoValue']['photo_share']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_share']['sender_user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_share']['sender_user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_share']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_share']['user_photo']['imgsrc']['s_height']); ?>
/>
            </a>
        </div>
          <div class="clsUserDetailsFriends">
             <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['photo_share']['sender']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_share']['sender_user_name']; ?>
 </a></div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_share']['date_added']; ?>
</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_share.gif" alt="" border="0" />
                     <?php echo $this->_tpl_vars['photoValue']['photo_share']['lang1']; ?>
<?php echo $this->_tpl_vars['photoValue']['photo_share']['lang2']; ?>
 <?php $_from = $this->_tpl_vars['photoValue']['photo_share']['firend_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['firendList']):
?> 
                     <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['firendList']['url']; ?>
"><?php echo $this->_tpl_vars['firendList']['firend_name']; ?>
</a> <?php endforeach; endif; unset($_from); ?>
              </div>
          </div>
    </div>
 </div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'playlist_comment'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
        <div class="clsFloatLeft">
            <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_comment']['comment_user']['url']; ?>
"  class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
             <img src="<?php echo $this->_tpl_vars['photoValue']['playlist_comment']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_comment']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['playlist_comment']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['playlist_comment']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['playlist_comment']['user_photo']['imgsrc']['s_height']); ?>
/>
            </a>
        </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_comment']['comment_user']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_comment']['user_name']; ?>
 </a> </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['playlist_comment']['date_added']; ?>
</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_comment.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['playlist_comment']['lang']; ?>
 
                <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['playlist_comment']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_comment']['playlist_name']; ?>
 </a>
              </div>
          </div>
 	</div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'playlist_rated'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_rated']['rate_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="<?php echo $this->_tpl_vars['photoValue']['playlist_rated']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_rated']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['playlist_rated']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['playlist_rated']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['playlist_rated']['user_photo']['imgsrc']['s_height']); ?>
/>
              </a>
          </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <p class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_rated']['rate_user']['url']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_rated']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
 </a> </p>
                  <p class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['playlist_rated']['date_added']; ?>
</span> </p>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_rated.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['playlist_rated']['lang']; ?>

                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['playlist_rated']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_rated']['playlist_name']; ?>
 </a>
              </div>
          </div>
     </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'playlist_featured'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
         <div class="clsFloatLeft">
             <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_featured']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
               <img src="<?php echo $this->_tpl_vars['photoValue']['playlist_featured']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_featured']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['playlist_featured']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['playlist_featured']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['playlist_featured']['user_photo']['imgsrc']['s_height']); ?>
/>
              </a>
          </div>
          <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <p class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_featured']['comment_user']['url']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_featured']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
 </a>  </p>
                  <p class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['playlist_featured']['date_added']; ?>
</span> </p>
              </div>
              <div class="clsUserActivityWhtsgoing">
                    <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_featured.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['playlist_featured']['lang']; ?>

                <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_featured']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_featured']['playlist_name']; ?>
 </a>
              </div>
          </div>
     </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'playlist_favorite'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
          <div class="clsFloatLeft">
              <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['comment_user']['url']; ?>
')" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                 <img src="<?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_favorite']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['playlist_favorite']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['playlist_favorite']['user_photo']['imgsrc']['s_height']); ?>
/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['comment_user']['url']; ?>
"> <?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_favorite']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
 </a>  </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['date_added']; ?>
</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_favourite.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['lang']; ?>

                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_favorite']['playlist_name']; ?>
 </a>
              </div>
          </div>
     </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'playlist_share'): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
           <div class="clsFloatLeft">
               <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_share']['sender']['url']; ?>
')" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                 <img src="<?php echo $this->_tpl_vars['photoValue']['playlist_share']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_share']['sender_user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['playlist_share']['sender_user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['playlist_share']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['playlist_share']['user_photo']['imgsrc']['s_height']); ?>
/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
              <div class="clsOverflow clsWhatsGoingUser">
                  <div class="clsFloatLeft"> <a  href="<?php echo $this->_tpl_vars['photoValue']['playlist_share']['sender']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_share']['sender_user_name']; ?>
 </a> </div>
                  <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['playlist_share']['date_added']; ?>
</span> </div>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_share.gif" alt="" border="0" />
                     <?php echo $this->_tpl_vars['photoValue']['playlist_share']['lang1']; ?>
<?php echo $this->_tpl_vars['photoValue']['playlist_share']['lang2']; ?>
 <?php $_from = $this->_tpl_vars['photoValue']['playlist_share']['firend_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['firendList']):
?>
                      <p><a href="<?php echo $this->_tpl_vars['firendList']['url']; ?>
"><?php echo $this->_tpl_vars['firendList']['firend_name']; ?>
</a></p>
                      <?php endforeach; endif; unset($_from); ?>
                      <p> <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['playlist_share']['viewphoto']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_share']['playlist_name']; ?>
 </a></p>
              </div>
          </div>
 	</div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'playlist_create'): ?>
<div class="clsWhatsGoingUserDetails">
 <div class="clsWhatsGoingBg clsOverflow">
        <div class="clsFloatLeft">
            <a href="<?php echo $this->_tpl_vars['photoValue']['playlist_create']['uploaded_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
              <img src="<?php echo $this->_tpl_vars['photoValue']['playlist_create']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['playlist_create']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['playlist_create']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['playlist_create']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['playlist_create']['user_photo']['imgsrc']['s_height']); ?>
/>
            </a>
        </div>
      <div class="clsUserDetailsFriends">
           <div class="clsOverflow clsWhatsGoingUser">
              <div class="clsFloatLeft"> <a  href="<?php echo $this->_tpl_vars['photoValue']['playlist_create']['uploaded_user']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['playlist_create']['user_name']; ?>
 </a> </div>
              <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['playlist_create']['date_added']; ?>
</span> </div>
           </div>
           <div class="clsUserActivityWhtsgoing">
                     <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/photo_upload.gif" alt="" border="0" />
                    <?php echo $this->_tpl_vars['photoValue']['playlist_create']['lang']; ?>

                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['playlist_create']['viewphoto']['url']; ?>
" > <?php echo $this->_tpl_vars['photoValue']['playlist_create']['playlist_name']; ?>
 </a>
           </div>
      </div>
 </div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_movie_share' && $this->_tpl_vars['CFG']['admin']['photos']['movie_maker']): ?>
<div class="clsWhatsGoingUserDetails">
 	<div class="clsWhatsGoingBg clsOverflow">
       <div class="clsFloatLeft">
           <a href="<?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['sender']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
              <img src="<?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_movie_share']['sender_user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['sender_user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_movie_share']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_movie_share']['user_photo']['imgsrc']['s_height']); ?>
/>
            </a>
        </div>
     	<div class="clsUserDetailsFriends">
          <div class="clsOverflow clsWhatsGoingUser">
              <div class="clsFloatLeft"> <a  href="<?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['sender']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['sender_user_name']; ?>
 </a> </div>
              <div class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['date_added']; ?>
</span> </div>
           </div>
           <div class="clsUserActivityWhtsgoing">
                     <img src="" alr="img" />
                   <?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['lang1']; ?>
 
                  <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['viewphotomovie']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['photo_movie_name']; ?>
 </a> <span><?php echo $this->_tpl_vars['photoValue']['photo_movie_share']['lang2']; ?>
</span> <?php $_from = $this->_tpl_vars['photoValue']['photo_movie_share']['firend_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['firendList']):
?> <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['firendList']['url']; ?>
"><?php echo $this->_tpl_vars['firendList']['firend_name']; ?>
</a> <?php endforeach; endif; unset($_from); ?>
           </div>
      </div>
 	</div>
</div>
<?php elseif ($this->_tpl_vars['photoValue']['action_key'] == 'photo_movie_created' && $this->_tpl_vars['CFG']['admin']['photos']['movie_maker']): ?>
<div class="clsWhatsGoingUserDetails">
     <div class="clsWhatsGoingBg clsOverflow">
           <div class="clsFloatLeft">
               <a href="<?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['uploaded_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                <img src="<?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['user_photo']['imgsrc']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photo_movie_created']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['photoValue']['photo_movie_created']['user_photo']['imgsrc']['s_width'],$this->_tpl_vars['photoValue']['photo_movie_created']['user_photo']['imgsrc']['s_height']); ?>
/>
               </a>
           </div>
          <div class="clsUserDetailsFriends">
               <div class="clsOverflow clsWhatsGoingUser">
                  <p class="clsFloatLeft"> <a  href="<?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['uploaded_user']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['user_name']; ?>
 </a>  </p>
                  <p class="clsFloatRight"> <span><?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['date_added']; ?>
</span> </p>
              </div>
              <div class="clsUserActivityWhtsgoing">
                     <img src="" alr="img" />
                    <?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['lang']; ?>

                 <a class="clsActivityTitle" href="<?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['viewphotomovie']['url']; ?>
"> <?php echo $this->_tpl_vars['photoValue']['photo_movie_created']['photo_movie_name']; ?>
 </a>
              </div>
          </div>
     </div>
</div>
<?php endif; ?>
 	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
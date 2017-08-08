<?php /* Smarty version 2.6.18, created on 2011-10-18 17:55:23
         compiled from videoActivity.tpl */ ?>
<?php $_from = $this->_tpl_vars['videoActivity_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['videoValue']):
?>
    <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['videoValue']['parent_id']): ?>
    	<?php if ($this->_tpl_vars['videoValue']['action_key'] == 'video_uploaded'): ?>
            <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="<?php echo $this->_tpl_vars['videoValue']['video_uploaded']['viewvideo']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="<?php echo $this->_tpl_vars['videoValue']['video_uploaded']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['videoValue']['video_uploaded']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['videoValue']['video_uploaded']['profileIcon']['s_width'],$this->_tpl_vars['videoValue']['video_uploaded']['profileIcon']['s_height']); ?>
/>
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['videoValue']['video_uploaded']['uploaded_user']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_uploaded']['user_name']; ?>
</a>
						</div>
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['videoValue']['video_uploaded']['date_added']; ?>
</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/common/icon-videoupload.gif" border="0" /><?php echo $this->_tpl_vars['videoValue']['video_uploaded']['lang']; ?>
 <a href="<?php echo $this->_tpl_vars['videoValue']['video_uploaded']['viewvideo']['url']; ?>
"> <?php echo $this->_tpl_vars['videoValue']['video_uploaded']['video_title']; ?>
</a>
					</div>
			       </div>
               </div>
           </div>
        <?php elseif ($this->_tpl_vars['videoValue']['action_key'] == 'video_comment'): ?>
           <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="<?php echo $this->_tpl_vars['videoValue']['video_comment']['viewvideo']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="<?php echo $this->_tpl_vars['videoValue']['video_comment']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['videoValue']['video_comment']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['videoValue']['video_comment']['profileIcon']['s_width'],$this->_tpl_vars['videoValue']['video_comment']['profileIcon']['s_height']); ?>
 />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['videoValue']['video_comment']['comment_user']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_comment']['user_name']; ?>
</a>
						</div>
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['videoValue']['video_comment']['date_added']; ?>
</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/common/icon-videocomment.gif" border="0" /><?php echo $this->_tpl_vars['videoValue']['video_comment']['lang']; ?>
 <a href="<?php echo $this->_tpl_vars['videoValue']['video_comment']['viewvideo']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_comment']['video_title']; ?>
</a>
					</div>
			       </div>
               </div>
           </div>
		<?php elseif ($this->_tpl_vars['videoValue']['action_key'] == 'video_rated'): ?>
              <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="<?php echo $this->_tpl_vars['videoValue']['video_rated']['viewvideo']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="<?php echo $this->_tpl_vars['videoValue']['video_rated']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['videoValue']['video_comment']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['videoValue']['video_rated']['profileIcon']['s_width'],$this->_tpl_vars['videoValue']['video_rated']['profileIcon']['s_height']); ?>
 />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['videoValue']['video_rated']['comment_user']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_rated']['user_name']; ?>
</a>
						</div>
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['videoValue']['video_rated']['date_added']; ?>
</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/common/icon-videorating.gif" border="0" /><?php echo $this->_tpl_vars['videoValue']['video_rated']['lang']; ?>
 <a href="<?php echo $this->_tpl_vars['videoValue']['video_rated']['viewvideo']['url']; ?>
"> <?php echo $this->_tpl_vars['videoValue']['video_rated']['video_title']; ?>
</a>
					</div>
			       </div>
               </div>
           </div>
         <?php elseif ($this->_tpl_vars['videoValue']['action_key'] == 'video_favorite'): ?>
            <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="<?php echo $this->_tpl_vars['videoValue']['video_favorite']['viewvideo']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="<?php echo $this->_tpl_vars['videoValue']['video_favorite']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['videoValue']['video_favorite']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['videoValue']['video_favorite']['profileIcon']['s_width'],$this->_tpl_vars['videoValue']['video_favorite']['profileIcon']['s_height']); ?>
 />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['videoValue']['video_favorite']['comment_user']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_favorite']['user_name']; ?>
</a>
						</div>
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['videoValue']['video_favorite']['date_added']; ?>
</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/common/icon-videofavorite.gif" border="0" /><?php echo $this->_tpl_vars['videoValue']['video_favorite']['lang']; ?>
 <a href="<?php echo $this->_tpl_vars['videoValue']['video_favorite']['viewvideo']['url']; ?>
"> <?php echo $this->_tpl_vars['videoValue']['video_favorite']['video_title']; ?>
</a>
					</div>
			       </div>
               </div>
           </div>
         <?php elseif ($this->_tpl_vars['videoValue']['action_key'] == 'video_featured'): ?>
           <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="<?php echo $this->_tpl_vars['videoValue']['video_featured']['viewvideo']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="<?php echo $this->_tpl_vars['videoValue']['video_featured']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['videoValue']['video_featured']['user_name']; ?>
"   <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['videoValue']['video_featured']['profileIcon']['s_width'],$this->_tpl_vars['videoValue']['video_featured']['profileIcon']['s_height']); ?>
 />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['videoValue']['video_featured']['comment_user']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_featured']['user_name']; ?>
</a>
						</div>
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['videoValue']['video_featured']['date_added']; ?>
</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
					<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/common/icon-videofeatured.gif" border="0" /><?php echo $this->_tpl_vars['videoValue']['video_featured']['lang']; ?>
 <a href="<?php echo $this->_tpl_vars['videoValue']['video_featured']['viewvideo']['url']; ?>
"> <?php echo $this->_tpl_vars['videoValue']['video_featured']['video_title']; ?>
</a>
					</div>
			       </div>
               </div>
           </div>
         <?php elseif ($this->_tpl_vars['videoValue']['action_key'] == 'video_responded'): ?>
           <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="<?php echo $this->_tpl_vars['videoValue']['video_responded']['viewvideo']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="<?php echo $this->_tpl_vars['videoValue']['video_responded']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['videoValue']['video_responded']['responses_user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['videoValue']['video_responded']['profileIcon']['s_width'],$this->_tpl_vars['videoValue']['video_responded']['profileIcon']['s_height']); ?>
 />
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['videoValue']['video_responded']['responses_user']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_responded']['responses_user_name']; ?>
</a>
						</div>
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['videoValue']['video_responded']['date_added']; ?>
</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/common/icon-videoresponse.gif" border="0" /><?php echo $this->_tpl_vars['videoValue']['video_responded']['lang']; ?>
 <a href="<?php echo $this->_tpl_vars['videoValue']['video_responded']['viewvideo']['url']; ?>
"> <?php echo $this->_tpl_vars['videoValue']['video_responded']['video_title']; ?>
</a>
					</div>
			       </div>
               </div>
           </div>

         <?php elseif ($this->_tpl_vars['videoValue']['action_key'] == 'video_share'): ?>
             <div class="clsWhatsGoingUserDetails">
				<div class="clsWhatsGoingBg clsOverflow">
				  <div class="clsFloatLeft">
				  	<a href="<?php echo $this->_tpl_vars['videoValue']['video_share']['viewvideo']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						 <img src="<?php echo $this->_tpl_vars['videoValue']['video_share']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['videoValue']['video_share']['sender_user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['videoValue']['video_share']['profileIcon']['s_width'],$this->_tpl_vars['videoValue']['video_share']['profileIcon']['s_height']); ?>
/>
					</a>
				  </div>
				  <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['videoValue']['video_share']['comment_user']['url']; ?>
"><?php echo $this->_tpl_vars['videoValue']['video_share']['sender_user_name']; ?>
</a>
						</div>
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['videoValue']['video_share']['date_added']; ?>
</span>
						</div>
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
video/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/common/icon-videoshared.gif" border="0" /><?php echo $this->_tpl_vars['videoValue']['video_share']['lang1']; ?>
 <a href="<?php echo $this->_tpl_vars['videoValue']['video_share']['viewvideo']['url']; ?>
"> <?php echo $this->_tpl_vars['videoValue']['video_share']['video_title']; ?>
</a>
					</div>
			       </div>
               </div>
           </div>
        <?php endif; ?>
 	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
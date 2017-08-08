<?php /* Smarty version 2.6.18, created on 2011-10-17 14:58:06
         compiled from musicActivity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ucwords', 'musicActivity.tpl', 17, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['musicActivity_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicValue']):
?>
<?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['musicValue']['parent_id']): ?>
 	
	<?php echo $this->_tpl_vars['myobj']->chkTemplateImagePathForModuleAndSwitch('music',$this->_tpl_vars['CFG']['html']['template']['default'],$this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']); ?>
		
	
    <?php if ($this->_tpl_vars['musicValue']['action_key'] == 'music_uploaded'): ?>      
		<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['music_uploaded']['uploaded_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
						<img src="<?php echo $this->_tpl_vars['musicValue']['music_uploaded']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['music_uploaded']['user_name']; ?>
" alt="<?php echo $this->_tpl_vars['musicValue']['music_uploaded']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['music_uploaded']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['music_uploaded']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['music_uploaded']['uploaded_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['music_uploaded']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['music_uploaded']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_upload.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['music_uploaded']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['music_uploaded']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['music_uploaded']['music_title']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'music_comment'): ?>    
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['music_comment']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['music_comment']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['music_comment']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['music_comment']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['music_comment']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['music_comment']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['music_comment']['comment_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['music_comment']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['music_comment']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_comment.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['music_comment']['lang']; ?>

                        <a href="<?php echo $this->_tpl_vars['musicValue']['music_comment']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['music_comment']['music_title']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'music_rated'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['music_rated']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['music_rated']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['music_rated']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['music_rated']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['music_rated']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['music_rated']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['music_rated']['comment_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['music_rated']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['music_rated']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_rated.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['music_rated']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['music_rated']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['music_rated']['music_title']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'music_favorite'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['music_favorite']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['music_favorite']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['music_favorite']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['music_favorite']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['music_favorite']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['music_favorite']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['music_favorite']['comment_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['music_favorite']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['music_favorite']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_favorite.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['music_favorite']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['music_favorite']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['music_favorite']['music_title']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'music_featured'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['music_featured']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['music_featured']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['music_featured']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['music_featured']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['music_featured']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['music_featured']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['music_featured']['comment_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['music_featured']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['music_featured']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_featured.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['music_featured']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['music_featured']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['music_featured']['music_title']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'music_responded'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['music_responded']['responses_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['music_responded']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['music_responded']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['music_responded']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['music_responded']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['music_responded']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['music_responded']['responses_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['music_responded']['responses_user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['music_responded']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_responded.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['music_responded']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['music_responded']['old_viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['music_responded']['old_music_title']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'music_share'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['music_share']['sender']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['music_share']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['music_share']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['music_share']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['music_share']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['music_share']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['music_share']['sender']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['music_share']['sender_user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['music_share']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_share.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['music_share']['lang1']; ?>

                        <?php echo $this->_tpl_vars['musicValue']['music_share']['lang2']; ?>

                        <?php $_from = $this->_tpl_vars['musicValue']['music_share']['firend_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['firendList']):
?>
                        <a href="<?php echo $this->_tpl_vars['firendList']['url']; ?>
"><?php echo $this->_tpl_vars['firendList']['firend_name']; ?>
</a>
                        <?php endforeach; endif; unset($_from); ?>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'playlist_comment'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_comment']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['playlist_comment']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['playlist_comment']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['playlist_comment']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['playlist_comment']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['playlist_comment']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_comment']['comment_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['playlist_comment']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['playlist_comment']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_comment.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['playlist_comment']['lang']; ?>

                        <a href="<?php echo $this->_tpl_vars['musicValue']['playlist_comment']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['playlist_comment']['playlist_name']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'playlist_rated'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">					<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_rated']['rate_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['playlist_rated']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['playlist_rated']['user_name']; ?>
" alt="<?php echo $this->_tpl_vars['musicValue']['playlist_rated']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['playlist_rated']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['playlist_rated']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_rated']['rate_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['playlist_rated']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['playlist_rated']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_rated.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['playlist_rated']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_rated']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['playlist_rated']['playlist_name']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
	<?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'playlist_featured'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_featured']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['playlist_featured']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['playlist_featured']['user_name']; ?>
" o alt="<?php echo $this->_tpl_vars['musicValue']['playlist_featured']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['playlist_featured']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['playlist_featured']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_featured']['comment_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['playlist_featured']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['playlist_featured']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_featured.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['playlist_featured']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_featured']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['playlist_featured']['playlist_name']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
    <?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'playlist_favorite'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['playlist_favorite']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['playlist_favorite']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['comment_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['playlist_favorite']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_favorite.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['playlist_favorite']['playlist_name']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
    <?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'playlist_share'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_share']['sender']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['playlist_share']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['playlist_share']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['playlist_share']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['playlist_share']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['playlist_share']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_share']['sender']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['playlist_share']['sender_user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['playlist_share']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_share.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['playlist_share']['lang1']; ?>

                        <?php echo $this->_tpl_vars['musicValue']['playlist_share']['lang2']; ?>

                        <?php $_from = $this->_tpl_vars['musicValue']['playlist_share']['firend_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['firendList']):
?>
                        <a href="<?php echo $this->_tpl_vars['firendList']['url']; ?>
"><?php echo $this->_tpl_vars['firendList']['firend_name']; ?>
</a>
                        <?php endforeach; endif; unset($_from); ?>
                        <a href="<?php echo $this->_tpl_vars['musicValue']['playlist_share']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['playlist_share']['playlist_name']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>
    <?php elseif ($this->_tpl_vars['musicValue']['action_key'] == 'playlist_create'): ?>
    	<div class="clsWhatsGoingUserDetails">
            <div class="clsWhatsGoingBg clsOverflow">
                <div class="clsFloatLeft">
					<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_create']['uploaded_user']['url']; ?>
" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45">
                    	<img src="<?php echo $this->_tpl_vars['musicValue']['playlist_create']['profileIcon']['s_url']; ?>
" border="0" title="<?php echo $this->_tpl_vars['musicValue']['playlist_create']['user_name']; ?>
"  alt="<?php echo $this->_tpl_vars['musicValue']['playlist_create']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['music_index_activity_thumb_width'],$this->_config[0]['vars']['music_index_activity_thumb_height'],$this->_tpl_vars['musicValue']['playlist_create']['profileIcon']['s_width'],$this->_tpl_vars['musicValue']['playlist_create']['profileIcon']['s_height']); ?>
/>
					</a>
				</div>
                <div class="clsUserDetailsFriends">
					<div class="clsOverflow clsWhatsGoingUser">
						<div class="clsFloatLeft">
							<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_create']['uploaded_user']['url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['musicValue']['playlist_create']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a>
						</div>	
						<div class="clsFloatRight">
							<span><?php echo $this->_tpl_vars['musicValue']['playlist_create']['date_added']; ?>
</span>
						</div>	
					</div>
					<div class="clsUserActivityWhtsgoing">
						<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/music_upload.gif" alt="" border="0" />
                        <?php echo $this->_tpl_vars['musicValue']['playlist_create']['lang']; ?>

						<a href="<?php echo $this->_tpl_vars['musicValue']['playlist_create']['viewmusic']['url']; ?>
"><?php echo $this->_tpl_vars['musicValue']['playlist_create']['playlist_name']; ?>
</a>
					</div>	
				</div>	
			</div>	
		</div>              
    <?php endif; ?>
            
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
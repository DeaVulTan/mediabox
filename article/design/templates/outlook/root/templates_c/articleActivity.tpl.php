<?php /* Smarty version 2.6.18, created on 2012-02-01 22:45:40
         compiled from articleActivity.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'articleActivity.tpl', 8, false),array('modifier', 'ucwords', 'articleActivity.tpl', 60, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['articleActivity_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['articleValue']):
?>
   <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['articleValue']['parent_id']): ?>
    	<?php if ($this->_tpl_vars['articleValue']['action_key'] == 'article_uploaded'): ?>
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="<?php echo $this->_tpl_vars['articleValue']['article_uploaded']['uploaded_user']['url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="<?php echo $this->_tpl_vars['articleValue']['article_uploaded']['user_article']['imgsrc']['m_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['articleValue']['article_uploaded']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['articleValue']['article_uploaded']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['articleValue']['article_uploaded']['user_article']['imgsrc']['s_width'],$this->_tpl_vars['articleValue']['article_uploaded']['user_article']['imgsrc']['s_height']); ?>
/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['articleValue']['article_uploaded']['uploaded_user']['url']; ?>
"><?php echo $this->_tpl_vars['articleValue']['article_uploaded']['user_name']; ?>
</a>
                            </div>
                            <div class="clsFloatRight"><span><?php echo $this->_tpl_vars['articleValue']['article_uploaded']['date_added']; ?>
</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/article_upload.gif" alt="" border="0" />
                            <?php echo $this->_tpl_vars['articleValue']['article_uploaded']['lang']; ?>

                            <a href="<?php echo $this->_tpl_vars['articleValue']['article_uploaded']['viewarticle']['url']; ?>
"><?php echo $this->_tpl_vars['articleValue']['article_uploaded']['article_title']; ?>
</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($this->_tpl_vars['articleValue']['action_key'] == 'article_comment'): ?>
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="<?php echo $this->_tpl_vars['articleValue']['article_comment']['comment_user']['url']; ?>
"  class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img src="<?php echo $this->_tpl_vars['articleValue']['article_comment']['user_article']['imgsrc']['m_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['articleValue']['article_comment']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['articleValue']['article_comment']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['articleValue']['article_comment']['user_article']['imgsrc']['s_width'],$this->_tpl_vars['articleValue']['article_comment']['user_article']['imgsrc']['s_height']); ?>
/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['articleValue']['article_comment']['comment_user']['url']; ?>
">
                            <?php echo $this->_tpl_vars['articleValue']['article_comment']['user_name']; ?>
</a></div>
                            <div class="clsFloatRight"><span><?php echo $this->_tpl_vars['articleValue']['article_comment']['date_added']; ?>
</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/article_comment.gif" alt="" border="0" />
                            <?php echo $this->_tpl_vars['articleValue']['article_comment']['lang']; ?>

                            <a href="<?php echo $this->_tpl_vars['articleValue']['article_comment']['viewarticle']['url']; ?>
"><?php echo $this->_tpl_vars['articleValue']['article_comment']['article_title']; ?>
</a>
                        </div>
                    </div>
                </div>
            </div>

		<?php elseif ($this->_tpl_vars['articleValue']['action_key'] == 'article_rated'): ?>
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="<?php echo $this->_tpl_vars['articleValue']['article_rated']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="<?php echo $this->_tpl_vars['articleValue']['article_rated']['user_article']['imgsrc']['m_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['articleValue']['article_rated']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['articleValue']['article_rated']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['articleValue']['article_rated']['user_article']['imgsrc']['s_width'],$this->_tpl_vars['articleValue']['article_rated']['user_article']['imgsrc']['s_height']); ?>
/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['articleValue']['article_rated']['comment_user']['url']; ?>
">
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['articleValue']['article_rated']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a></div>
                            <div class="clsFloatRight"><span><?php echo $this->_tpl_vars['articleValue']['article_rated']['date_added']; ?>
</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/article_rated.gif" alt="" border="0" /><?php echo $this->_tpl_vars['articleValue']['article_rated']['lang']; ?>

                            <a href="<?php echo $this->_tpl_vars['articleValue']['article_rated']['viewarticle']['url']; ?>
"><?php echo $this->_tpl_vars['articleValue']['article_rated']['article_title']; ?>
</a>
                        </div>
                    </div>
                </div>
            </div>

         <?php elseif ($this->_tpl_vars['articleValue']['action_key'] == 'article_favorite'): ?>
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="<?php echo $this->_tpl_vars['articleValue']['article_favorite']['comment_user']['url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="<?php echo $this->_tpl_vars['articleValue']['article_favorite']['user_article']['imgsrc']['m_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['articleValue']['article_favorite']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['articleValue']['article_favorite']['user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['articleValue']['article_favorite']['user_article']['imgsrc']['s_width'],$this->_tpl_vars['articleValue']['article_favorite']['user_article']['imgsrc']['s_height']); ?>
/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['articleValue']['article_favorite']['comment_user']['url']; ?>
">
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['articleValue']['article_favorite']['user_name'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : smarty_modifier_ucwords($_tmp)); ?>
</a></div>
                            <div class="clsFloatRight"><span><?php echo $this->_tpl_vars['articleValue']['article_favorite']['date_added']; ?>
</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/article_favorite.gif" alt="" border="0" />              <?php echo $this->_tpl_vars['articleValue']['article_favorite']['lang']; ?>

                            <a href="<?php echo $this->_tpl_vars['articleValue']['article_favorite']['viewarticle']['url']; ?>
"><?php echo $this->_tpl_vars['articleValue']['article_favorite']['article_title']; ?>
</a>
                        </div>
                    </div>
                </div>
            </div>

         <?php elseif ($this->_tpl_vars['articleValue']['action_key'] == 'article_share'): ?>
            <div class="clsWhatsGoingUserDetails">
                <div class="clsWhatsGoingBg clsOverflow">
                    <div class="clsFloatLeft">
                        <a href="<?php echo $this->_tpl_vars['articleValue']['article_share']['sender']['url']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                        <img border="0" src="<?php echo $this->_tpl_vars['articleValue']['article_share']['user_article']['imgsrc']['m_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['articleValue']['article_share']['sender_user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['articleValue']['article_share']['sender_user_name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['articleValue']['article_share']['user_article']['imgsrc']['s_width'],$this->_tpl_vars['articleValue']['article_share']['user_article']['imgsrc']['s_height']); ?>
/>
                        </a>
                    </div>
                    <div class="clsUserDetailsFriends">
                        <div class="clsOverflow clsWhatsGoingUser">
                            <div class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['articleValue']['article_share']['sender']['url']; ?>
"><?php echo $this->_tpl_vars['articleValue']['article_share']['sender_user_name']; ?>
</a></div>

                            <?php $_from = $this->_tpl_vars['articleValue']['article_share']['firend_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['firendList']):
?>
                            <div class="clsFloatLeft"><a href="<?php echo $this->_tpl_vars['firendList']['url']; ?>
"><?php echo $this->_tpl_vars['firendList']['firend_name']; ?>
</a></div>
                            <?php endforeach; endif; unset($_from); ?>
                            <div class="clsFloatRight"><span><?php echo $this->_tpl_vars['articleValue']['article_share']['date_added']; ?>
</span></div>
                        </div>
                        <div class="clsUserActivityWhtsgoing">
                        	<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
article/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/article_share.gif" alt="" border="0" />
                             <?php echo $this->_tpl_vars['articleValue']['article_share']['lang1']; ?>

                             <?php echo $this->_tpl_vars['articleValue']['article_share']['lang2']; ?>

                            </div>
              		  </div>
                </div>
            </div>
        <?php endif; ?>
 	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
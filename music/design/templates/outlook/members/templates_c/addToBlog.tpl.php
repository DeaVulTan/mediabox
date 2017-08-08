<?php /* Smarty version 2.6.18, created on 2011-10-17 15:01:16
         compiled from addToBlog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'addToBlog.tpl', 33, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
<div id="listenMusicBlog" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div class="clsPopupContent clsSuccessMessage" id="selAddNewBlogSuccess" style="display:none"><p><?php echo $this->_tpl_vars['LANG']['viewmusic_posted_your_blog']; ?>
</p></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	<?php if ($this->_tpl_vars['myobj']->isMember): ?>
			<a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', load_blog_url, '', 'updateBlogTitle');" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
</a>
            <?php else: ?>
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_blog_lyrics_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewMusicUrl; ?>
');return false;" title="<?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog']; ?>
</a>
            <?php endif; ?>
		</div>
	</div>
</div>
<div id="blogDiv" class="clsPopupConfirmation" style="display:none;">
    <div class="clsUserActionMessage" id="no_blog"<?php echo $this->_tpl_vars['myobj']->musics_form['add_new_blog_info']; ?>
>
          <?php echo $this->_tpl_vars['myobj']->LANG['viewmusic_no_blog']; ?>

    </div>    
    <div id="selMsgAddNewBlog"<?php echo $this->_tpl_vars['myobj']->musics_form['post_to_blog']; ?>
>
        <form name="formMsgAddNewBlog" id="formMsgAddNewBlog" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">	
        <div class="clsPopupContent clsErrorMessage" id="selAddNewBlogFailure" style="display:none"></div>
        <div id="selAddNewBlogContent" class="clsInnerPlaylist" >
            <div id="blogPostInfo">
                  <p><?php echo $this->_tpl_vars['myobj']->LANG['viewmusic_blog_post_info']; ?>
</p>
            </div>      
            <div class="clsCreatePlaylist">
                <div class="clsRow" id="selBlogTitle">
                    <?php endif; ?>
                    <?php if (isAjaxPage ( )): ?>                  
                    <div class="clsTDLabel">
                          <label for="blog_title"><?php echo $this->_tpl_vars['LANG']['viewmusic_blog_title']; ?>
:&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span></label>
                    </div>
                    <div class="clsTDText">
                          <select name="blog_title" id="blog_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="showBlogDetailForm()">
                                <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->musics_form['getBlogList'],$this->_tpl_vars['myobj']->getFormField('blog_title')); ?>

                          </select>
                          <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_title'); ?>

                    </div>                  
                    <?php endif; ?>
                    <?php if (! isAjaxPage ( )): ?>
                </div>
                <div class="clsRow">
                    <div class="clsTDLabel">
                          <label for="blog_post_title"><?php echo $this->_tpl_vars['LANG']['viewmusic_blog_post_title']; ?>
:&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span></label>
                    </div>
                    <div class="clsTDText">
                          <input type="text" class="clsFields" name="blog_post_title" id="blog_post_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('blog_post_title'); ?>
" />
                          <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_post_title'); ?>

                    </div>
                </div>
                <div class="clsRow">
                    <div class="clsTDLabel">
                          <label for="blog_post_text"><?php echo $this->_tpl_vars['LANG']['viewmusic_blog_post_text']; ?>
:&nbsp;<span class="clsMandatoryFieldIcon"><?php echo $this->_tpl_vars['LANG']['common_music_mandatory']; ?>
</span></label>
                    </div>
                    <div class="clsTDText">
                          <textarea class="clsFields" name="blog_post_text" id="blog_post_text" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" rows="3" cols="50"><?php echo $this->_tpl_vars['myobj']->getFormField('blog_post_text'); ?>
</textarea>
                          <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_post_text'); ?>

                    </div>
                </div>
                <div class="clsRow" style="display:none" id="blog_loader_row"> 
                    <div class="clsTDLabel"><!----></div>
                    <div class="clsTDText">
                        <div id="blog_submitted"></div>
                    </div>
                  </div>                  
                  <div class="clsRow">
                        <div class="clsTDLabel"><!----></div>
                        <div class="clsTDText">
                              <p class="clsButton"><span><input type="button" class="clsSubmitButton" name="add_blog_submit" id="add_blog_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewmusic_add_blog_submit']; ?>
" onclick="postThisMusic()" /></span></p>
                        </div>
                  </div>
            </div>
        </div>
        </form>
    </div>
</div>
<?php endif; ?>
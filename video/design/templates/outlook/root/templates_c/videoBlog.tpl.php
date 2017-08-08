<?php /* Smarty version 2.6.18, created on 2011-10-18 17:56:33
         compiled from videoBlog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoBlog.tpl', 53, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
<div id="option-tab-3" class="clsDisplayNone clsTextAlignLeft clsOverflow">
	<div class="clsPopupContent clsSuccessMessage" id="selAddNewBlogSuccess" style="display:none"><p><?php echo $this->_tpl_vars['LANG']['viewvideo_posted_your_blog']; ?>
</p></div>
	<div class="clsViewTopicLeft">
		<div class="clsViewTopicRight">
        	<?php if (isMember ( )): ?>
			<a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" onclick="return openAjaxWindow('false', 'ajaxupdate', 'jquery_ajax', '<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'action=popblogtitle', 'updateBlogTitle');"><?php echo $this->_tpl_vars['LANG']['viewvideo_add_to_blog']; ?>
</a>
            <?php else: ?>
            <a href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_video_login_blog_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->notLoginVideoUrl; ?>
'); return false;"><?php echo $this->_tpl_vars['LANG']['viewvideo_add_to_blog']; ?>
</a>
            <?php endif; ?>
		</div>
	</div>
</div>
<!---<div id="selMsgAddNewBlog" class="clsDisplayNone">-->
<div id="blogDiv" class="clsPopupConfirmation" style="display:none;">
    <form name="formMsgAddNewBlog" id="formMsgAddNewBlog" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">

		<div class="clsOverflow"<?php echo $this->_tpl_vars['myobj']->videos_form['no_blog_added']; ?>
>
        	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['viewvideo_no_blog_msg']; ?>
</div>
    	</div>
		<div class="clsOverflow"<?php echo $this->_tpl_vars['myobj']->videos_form['blog_added']; ?>
>
        	<div class="clsFlagTitle"><?php echo $this->_tpl_vars['LANG']['viewvideo_add_to_blog']; ?>
</div>
    	</div>
		<div id="blogPostInfo" class="clsBlogCreate clsOverflow"<?php echo $this->_tpl_vars['myobj']->videos_form['blog_added']; ?>
>
			<p><?php echo $this->_tpl_vars['myobj']->LANG['viewvideo_blog_post_info']; ?>
</p>
        </div>
        <div class="clsPopupContent clsErrorMessage" id="selAddNewBlogFailure" style="display:none"></div>
    	<div class="clsFlagTable" id="selAddNewBlogContent"<?php echo $this->_tpl_vars['myobj']->videos_form['blog_added']; ?>
>
			<table class="clsProfileEditTbl">
				<tr>
					<td>
						<label for="blog_title"><?php echo $this->_tpl_vars['LANG']['viewvideo_blog_title']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['important']; ?>
&nbsp;</label>
					</td>
					<td id="selBlogTitle">
<?php endif; ?>
<?php if (isAjaxPage ( )): ?>
						<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_title'); ?>

						<select name="blog_title" id="blog_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onChange="showBlogDetailForm()">
							<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->videos_form['getBlogList'],$this->_tpl_vars['myobj']->getFormField('blog_title')); ?>

						</select>
<?php endif; ?>
<?php if (! isAjaxPage ( )): ?>
	                </td>
			   	</tr>
				<tr>
					<td>
						<label for="blog_post_title"><?php echo $this->_tpl_vars['LANG']['viewvideo_blog_post_title']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['important']; ?>
&nbsp;</label>
					</td>
					<td>
						<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_post_title'); ?>

						<input type="text" class="clsTextBox" name="blog_post_title" id="blog_post_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('blog_post_title'); ?>
" />
		            </td>
				</tr>
				<tr>
					<td>
						<label for="blog_post_text"><?php echo $this->_tpl_vars['LANG']['viewvideo_blog_post_text']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['important']; ?>
&nbsp;</label>
					</td>
					<td>
						<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_post_text'); ?>

						<textarea name="blog_post_text" id="blog_post_text" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('blog_post_text'); ?>
</textarea>
		            </td>
				</tr>
				<tr>
					<td>
						<div class="clsFlagButtonLeft"><div class="clsFlagButtonRight"><input type="button" class="clsSubmitButton" name="add_blog_submit" id="add_blog_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['viewvideo_add_blog_submit']; ?>
" onClick="postThisVideo()" /></div></div>
					</td>
		   		</tr>
			</table>
		</div>
  	</form>
</div>
<?php endif; ?>
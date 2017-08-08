<?php /* Smarty version 2.6.18, created on 2012-01-21 11:55:42
         compiled from profileBlog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'profileBlog.tpl', 18, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
<div id="selProfileBlog">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsPageHeading  clsOverflow"><h2><span><?php echo $this->_tpl_vars['LANG']['profileblog_title']; ?>
</span></h2></div>
  	<div id="selLeftNavigation">
	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

 		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_blogger_list')): ?>
		<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
  			<h3 id="act_confirmation_msg" class="clsPopUpHeading"></h3>
  			<form name="actForm" id="actForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
				<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->block_blogger_list['confirm_form_hidden_arr']); ?>

           		<input type="hidden" name="bid" value="" />
				<input type="hidden" name="act" value="" />
				<p>
		   			<input type="submit" class="clsPopUpSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
          			&nbsp;
          			<input type="button" class="clsPopUpSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
		 		</p>
  			</form>
		</div>
		<div id="selMsgAddNewBlog" class="selMsgConfirmWindow" style="display:none;">
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupvideo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div class="clsOverflow clsPopupBlogHeadingContainer"><div class="clsPopUpWindowHeading clsPopupBlogHeading">
			<h2 id="confirmation_msg" class="clsPopUpHeading"></h2></div>
				<!--<div class="clsCloseWindowContainer"><a class="clsCloseWindow" href="javascript:void(0)" onclick="closeAddBlog();"><?php echo $this->_tpl_vars['LANG']['profileblog_close']; ?>
</a></div> --></div>
		  	<form name="formMsgAddNewBlog" id="formMsgAddNewBlog" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
				<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->block_blogger_list['confirm_form_hidden_arr']); ?>

		    	<div class="clsPopUpGreyTable" id="selAddNewBlogContent"></div>
		  	</form>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupvideo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
              <div class="clsAddIcon">
                  <a href="javascript:void(0)" onClick="<?php echo $this->_tpl_vars['myobj']->block_blogger_list['add_new_blog_onclick']; ?>
"><?php echo $this->_tpl_vars['LANG']['profileblog_add_new_blog']; ?>
</a>
              </div>
             <div>
              <?php if ($this->_tpl_vars['myobj']->getFormField('video_id') != ''): ?>
                    <p>
                        <a href="<?php echo $this->_tpl_vars['myobj']->view_video_url; ?>
"><?php echo $this->_tpl_vars['LANG']['profileblog_back']; ?>
</a>
                    </p>
              <?php endif; ?>
             </div>

			<?php if ($this->_tpl_vars['myobj']->block_blogger_list['populateBloggerList']): ?>
				<div class="clsDataTable clsBloggerTable">
                	<table>
				<?php $_from = $this->_tpl_vars['myobj']->block_blogger_list['populateBloggerList']['record']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pblkey'] => $this->_tpl_vars['pblvalue']):
?>
					<tr>
						<td class="clsBlogName"><a href="<?php echo $this->_tpl_vars['myobj']->block_blogger_list['populateBloggerList']['link_url'][$this->_tpl_vars['pblkey']]; ?>
"><?php echo $this->_tpl_vars['pblvalue']['blog_title']; ?>
</a></td>
						<td class="clsBlogger"><p class="<?php echo $this->_tpl_vars['myobj']->block_blogger_list['populateBloggerList']['class_name'][$this->_tpl_vars['pblkey']]; ?>
"><?php echo $this->_tpl_vars['pblvalue']['blog_site']; ?>
</p></td>
						<td class="clsRemoveBlog"><a href="javascript:void(0)" onClick="<?php echo $this->_tpl_vars['myobj']->block_blogger_list['populateBloggerList']['remove_onclick'][$this->_tpl_vars['pblkey']]; ?>
"><?php echo $this->_tpl_vars['LANG']['profileblog_remove']; ?>
</a></td>
						<td class="clsModifyBlog"><a href="javascript:void(0)" onClick="<?php echo $this->_tpl_vars['myobj']->block_blogger_list['populateBloggerList']['modify_onclick'][$this->_tpl_vars['pblkey']]; ?>
"><?php echo $this->_tpl_vars['LANG']['profileblog_modify']; ?>
</a></td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</table>
                </div>
			<?php else: ?>
				<div class="clsAlertNoRecords"><p class="clsBold"><?php echo $this->_tpl_vars['LANG']['profileblog_no_blogs_added']; ?>
</p></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_blog_site_list')): ?>
			<input type="hidden" name="bid" id="" value="<?php echo $this->_tpl_vars['myobj']->getFormField('bid'); ?>
" />
			<table class="clsProfileEditTbl">
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('blog_site'); ?>
">
						<label for="blog_site"><?php echo $this->_tpl_vars['LANG']['profileblog_blog_site']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('blog_site'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_site'); ?>

						<select name="blog_site" id="blog_site" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onChange="showBlogDetailForm()" >
							<option value=""><?php echo $this->_tpl_vars['LANG']['profileblog_select_blog']; ?>
</option>
							<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->blog_site_list_arr,$this->_tpl_vars['myobj']->getFormField('blog_site')); ?>

						</select>
	                </td>
			   	</tr>
				<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sub_block_blogger_form')): ?>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('blog_title'); ?>
">
						<label for="blog_title"><?php echo $this->_tpl_vars['LANG']['profileblog_blog_title']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('blog_title'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_title'); ?>

						<input type="text" class="clsTextBox" name="blog_title" id="blog_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('blog_title'); ?>
" />
		            </td>
				</tr>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sub_block_blogger_form')): ?>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('blog_user_name'); ?>
">
						<label for="blog_user_name"><?php echo $this->_tpl_vars['LANG']['profileblog_blog_user_name']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('blog_user_name'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_user_name'); ?>

						<input type="text" class="clsTextBox" name="blog_user_name" id="blog_user_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('blog_user_name'); ?>
" />
		            </td>
				</tr>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sub_block_blogger_form')): ?>
				<tr>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('blog_password'); ?>
">
						<label for="blog_password"><?php echo $this->_tpl_vars['LANG']['profileblog_blog_password']; ?>
</label>
					</td>
					<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('blog_password'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('blog_password'); ?>

						<input type="password" class="clsTextBox" name="blog_password" id="blog_password" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('blog_password'); ?>
" />
		            </td>
				</tr>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sub_block_blogger_form')): ?>
				<tr>
					<td colspan="2" class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
">
						<input type="button" class="clsPopUpSubmitButton" name="add_blog_submit" id="add_blog_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['profileblog_add_blog_submit']; ?>
" onClick="addNewBlog()" />
					</td>
		   		</tr>
				<?php endif; ?>
			</table>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_add_success')): ?>
	        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<script language="javascript" type="text/javascript">
				<?php if ($this->_tpl_vars['myobj']->chkIsReffererUrl()): ?>
					//setTimeout("Redirect2URL('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
?act=redirect&backkey=<?php echo $this->_tpl_vars['myobj']->getFormField('backkey'); ?>
')", 9000);
				<?php else: ?>
					//setTimeout("Redirect2URL('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
')", 9000);
				<?php endif; ?>
			</script>
            <br />
		<?php endif; ?>
           <script language="javascript" type="text/javascript">
			<?php echo '
			function closeAddBlog()
				{
					//hideAllBlocks();
					//Redirect2URL(\''; ?>
<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
<?php echo '\');
				}
			'; ?>

	     </script>

<?php if (! isAjaxPage ( )): ?>
	</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php endif; ?>
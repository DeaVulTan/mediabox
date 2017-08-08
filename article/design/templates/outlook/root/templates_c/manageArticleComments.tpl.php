<?php /* Smarty version 2.6.18, created on 2012-02-02 22:51:15
         compiled from manageArticleComments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageArticleComments.tpl', 21, false),)), $this); ?>
<script language="javascript" type="text/javascript" src=cfg_site_url+"js/functions.js"></script>

<?php echo '
<script language="javascript" type="text/javascript">
	var block_arr= new Array(\'selMsgConfirm\');
	function changeCommentStatus(statusVal)
		{
			document.commentStatusForm.submit();
		}
</script>
'; ?>

<div id="selArticlePlayListContainer">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div class="clsOverflow">
    <div class="clsArticleListHeading">
      <h2><span><?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_title']; ?>
</span></h2>
    </div>
    <div class="clsArticleListHeadingRight">
      <form name="commentStatusForm" id="commentStatusForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
        <select name="comment_status" id="comment_status" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onchange="return changeCommentStatus(this.value)">
          <option value="" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == ''): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['managearticlecomments_selectbox_all']; ?>
</option>
          <option value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_yes_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['managearticlecomments_activate']; ?>
</option>
          <option value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') == $this->_tpl_vars['LANG']['common_no_option']): ?>Selected<?php endif; ?>><?php echo $this->_tpl_vars['LANG']['managearticlecomments_inactivate']; ?>
</option>
        </select>
      </form>
    </div>
  </div>
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div id="selLeftNavigation">
    <div id="selMsgConfirm" style="display:none;" class="clsMsgConfirm">
      <p id="selConfirmMsg"></p>
      <form name="confirm_form" id="confirm_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
        <input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
        &nbsp;
        <input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
        <input type="hidden" name="comment_id" id="comment_id" />
        <input type="hidden" name="act" id="act" />
        <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_manage_comments['form_hidden_value']); ?>

      </form>
    </div>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('comments_form')): ?>
    <div id="selManageCommentsDisplay" class="clsManageCommentsDisplay"> <?php if ($this->_tpl_vars['myobj']->form_manage_comments['record_found']): ?>
      <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
      <div class="clsDataTable">
        <form name="commendsForm" id="commendsForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
          <table summary="<?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_tbl_summary']; ?>
" class="clsManageCommentsTb1">
            <tr>
              <th class="clsBorderLeft"> <input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="check_all" onclick="CheckAll(document.commendsForm.name, document.commendsForm.check_all.name)" />
              </th>
              <th class="clsWidth150"><?php echo $this->_tpl_vars['myobj']->form_manage_comments['comments_module']; ?>
</th>
              <th class="clsWidth90"><?php echo $this->_tpl_vars['LANG']['managearticlecomments_by']; ?>
</th>
              <th class="clsWidth75"><?php echo $this->_tpl_vars['LANG']['managearticlecomments_date']; ?>
</th>
              <th class="clsWidth55"><?php echo $this->_tpl_vars['LANG']['managearticlecomments_status']; ?>
</th>
              <th class="clsTableNoBorder"><?php echo $this->_tpl_vars['LANG']['managearticlecomments_option']; ?>
</th>
            </tr>
            <div class="clsTabBorder">
            <?php if ($this->_tpl_vars['myobj']->form_manage_comments['comments_list']): ?>
            <?php $_from = $this->_tpl_vars['myobj']->form_manage_comments['comments_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
            <tr class="<?php echo $this->_tpl_vars['value']['tr_class']; ?>
">
              <td class="clsBorderLeft"><input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="comment_ids[]" value="<?php echo $this->_tpl_vars['value']['comment_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['value']['comment_chk_value']; ?>
 onClick="disableHeading('commendsForm');"/></td>
              <td id="selArticleGallery"><p id="selArticleTitle"><a href="<?php echo $this->_tpl_vars['value']['module_view_link']; ?>
" title="<?php echo $this->_tpl_vars['value']['comment_title']; ?>
"><?php echo $this->_tpl_vars['value']['comment_title']; ?>
</a></p></td>
              <td id="selArticleGallery"><p id="selMemberName" class="clsGroupSmallImg"><a href="<?php echo $this->_tpl_vars['value']['member_profile_url']; ?>
" title="<?php echo $this->_tpl_vars['value']['user_details']; ?>
"><span><?php echo $this->_tpl_vars['value']['user_details']; ?>
</span></a></p></td>
              <td><?php echo $this->_tpl_vars['value']['date_added']; ?>
</td>
              <td> <?php if ($this->_tpl_vars['value']['comment_status'] == 'Yes'): ?>
                <?php echo $this->_tpl_vars['LANG']['managearticlecomments_activate']; ?>

                <?php elseif ($this->_tpl_vars['value']['comment_status'] == 'No'): ?>
                <?php echo $this->_tpl_vars['LANG']['managearticlecomments_inactivate']; ?>

                <?php endif; ?> </td>
              <td class="clsMngComments"><a href="<?php echo $this->_tpl_vars['value']['viewcomment_url']; ?>
" id="manage_<?php echo $this->_tpl_vars['value']['comment_id']; ?>
" ><?php echo $this->_tpl_vars['value']['comment']; ?>
</a></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
            <?php endif; ?>
            </div>
          </table>
          <div class="clsManageCommentsBtn clsOverflow"><a href="#" id="dAltMulti"></a> <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_manage_comments['form_hidden_value']); ?>

          	<?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') != $this->_tpl_vars['LANG']['common_yes_option']): ?>
            <p class="clsSubmitButton-l"> <span class="clsSubmitButton-r">
              <input type="button" class="clsSubmitButton" name="activate" id="activate" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managearticlecomments_activate_button_label']; ?>
" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'activate', '<?php echo $this->_tpl_vars['LANG']['managearticlecomments_activate_confirmation']; ?>
'), Array('value','value', 'innerHTML'), 200, 100);" />
              </span></p>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['myobj']->getFormField('comment_status') != $this->_tpl_vars['LANG']['common_no_option']): ?>
            <p class="clsDeleteButton-l"> <span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="inactivate" id="inactivate" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managearticlecomments_inactivate_button_label']; ?>
" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'inactivate', '<?php echo $this->_tpl_vars['LANG']['managearticlecomments_inactivate_confirmation']; ?>
'), Array('value','value', 'innerHTML'), 200, 100);" />
              </span></p>
            <?php endif; ?>
            <p class="clsDeleteButton-l"> <span class="clsDeleteButton-r">
              <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['managearticlecomments_delete']; ?>
" onClick="if(getMultiCheckBoxValue('commendsForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
', 'dAltMulti', -100, -500))Confirmation('selMsgConfirm', 'confirm_form', Array('comment_id','act', 'selConfirmMsg'), Array(multiCheckValue, 'delete', '<?php echo $this->_tpl_vars['LANG']['managearticlecomments_delete_confirmation']; ?>
'), Array('value','value', 'innerHTML'), 0, 0);" />
              </span></p>
		 </div>
        </form>
      </div>
      <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
      <?php else: ?>
      <div id="selMsgAlert">
        <p><?php echo $this->_tpl_vars['LANG']['common_no_records_found']; ?>
</p>
      </div>
      <?php endif; ?> </div>
    <?php endif; ?> </div>
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 </div>
 <script>
<?php echo '
$Jq(document).ready(function() {
    for(var i=0;i<manage_comment_ids.length;i++)
	{
	$Jq(\'#manage_\'+manage_comment_ids[i]).fancybox({
		\'width\'				: 865,
		\'height\'			: 400,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
	}
});
'; ?>

</script>
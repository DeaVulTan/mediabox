<?php /* Smarty version 2.6.18, created on 2014-06-06 11:27:37
         compiled from manageMusicComments.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageMusicComments.tpl', 22, false),array('function', 'counter', 'manageMusicComments.tpl', 72, false),array('modifier', 'nl2br', 'manageMusicComments.tpl', 79, false),)), $this); ?>
<div id="selPlaylistCategory" class="clsPlaylistCategory">
	<h2><span><?php echo $this->_tpl_vars['LANG']['page_title']; ?>
</span></h2>
	<div class="clsLeftNavigation" id="selLeftNavigation">

  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('comments_list')): ?>
		<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>

            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            
            <div id="selMsgConfirmDelete" class="clsPopupConfirmation" style="display:none;">
                    <h3 id="confirmation_msg"></h3>
                    <form name="deleteForm" id="deleteForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                        <table summary="<?php echo $this->_tpl_vars['LANG']['tbl_summary']; ?>
" class="clsFormTableSection">
                            <tr>
                                <td>
                                    <input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="<?php echo $this->_tpl_vars['LANG']['act_yes']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                                    <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['act_no']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks();" />
                                    <input type="hidden" name="cid" id="aid" />
                                    <input type="hidden" name="act" id="act" />
                                    <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->comments_list['hidden_arr']); ?>

                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            <div>
                <form name="form_comments_list" id="form_comments_list" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                 	<script language="javascript" type="text/javascript">
							var txt=new Array();
							var comment_id=new Array();
					</script>
                    <table summary="<?php echo $this->_tpl_vars['LANG']['tbl_summary']; ?>
" class="clsFormTableSection">
                        <tr>
                            <th><input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.form_comments_list.name, document.form_comments_list.check_all.name)" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></th>
                            <th><?php echo $this->_tpl_vars['LANG']['th_user']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['th_comment']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['th_date_added']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['managemusiccomments_status_label']; ?>
</th>
                            <th>
                                <input type="hidden" name="new_comment" id="new_comment" />
                                <input type="hidden" name="new_cid" id="new_cid" />
&nbsp;                            </th>
                        </tr>
                        <?php $this->assign('count', '0'); ?>
                        <?php $_from = $this->_tpl_vars['populateComments_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pcKey'] => $this->_tpl_vars['pcValue']):
?>
                        <?php echo '
							<script language="javascript">
                                txt['; ?>
<?php echo $this->_tpl_vars['count']; ?>
<?php echo '] = '; ?>
'<?php echo $this->_tpl_vars['pcValue']['record']['comment']; ?>
'<?php echo ';
                                comment_id['; ?>
<?php echo $this->_tpl_vars['count']; ?>
<?php echo '] = '; ?>
'<?php echo $this->_tpl_vars['pcValue']['record']['music_comment_id']; ?>
'<?php echo ';
                            </script>
                         '; ?>
    
                            <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                                <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="cid[]" value="<?php echo $this->_tpl_vars['pcValue']['record']['music_comment_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="disableHeading('form_comments_list');"/></td>
                                <td><p class="clsImage"><a href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/viewProfile.php?user_id=<?php echo $this->_tpl_vars['pcValue']['record']['comment_user_id']; ?>
"><img src="<?php echo $this->_tpl_vars['pcValue']['profileIcon']['t_url']; ?>
" alt="<?php echo $this->_tpl_vars['pcValue']['UserDetails']; ?>
" title="<?php echo $this->_tpl_vars['pcValue']['UserDetails']; ?>
" <?php echo $this->_tpl_vars['pcValue']['profileIcon']; ?>
 /></a></p></td>
                                <td><textarea rows="4" cols="50" id="commentText_<?php echo $this->_tpl_vars['pcValue']['record']['music_comment_id']; ?>
" name="commentText_<?php echo $this->_tpl_vars['pcValue']['record']['music_comment_id']; ?>
"  wrap="on"><?php echo $this->_tpl_vars['pcValue']['record']['comment']; ?>
</textarea></td>
                                <td><?php echo $this->_tpl_vars['pcValue']['record']['date_added']; ?>
</td>
                                <td>
                                	<?php if ($this->_tpl_vars['pcValue']['record']['comment_status'] == 'Yes'): ?>
                                		<?php echo $this->_tpl_vars['LANG']['managemusiccomments_show_label']; ?>

                                    <?php elseif ($this->_tpl_vars['pcValue']['record']['comment_status'] == 'No'): ?>
                                    	<?php echo $this->_tpl_vars['LANG']['managemusiccomments_hide_label']; ?>

                                    <?php endif; ?>   
                                </td>
                               
                            </tr>
                           <?php echo smarty_function_counter(array('assign' => 'count'), $this);?>
	 
                        <?php endforeach; endif; unset($_from); ?>                        
                        <tr>
							 <td colspan="6"><input type="submit" class="clsSubmitButton" name="updateSubmit" id="updateSubmit" value="<?php echo $this->_tpl_vars['LANG']['update']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="changeSubmitText(<?php echo $this->_tpl_vars['pcValue']['record']['music_comment_id']; ?>
)" />
                            
                                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->comments_list['hidden_arr']); ?>

                                <a href="#" id="<?php echo $this->_tpl_vars['myobj']->anchor; ?>
"></a>
                                <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['delete']; ?>
" onClick="if(getMultiCheckBoxValue('form_comments_list', 'check_all', '<?php echo $this->_tpl_vars['LANG']['check_atleast_one']; ?>
')) <?php echo ' { '; ?>
 Confirmation('selMsgConfirmDelete', 'deleteForm', Array('cid', 'act', 'confirmation_msg'), Array(multiCheckValue, 'delete', '<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['delete_confirmation'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
'), Array('value', 'value', 'innerHTML'), -100, -500); <?php echo ' } '; ?>
" />                            </td>
                        </tr>
                    </table>
              </form>
            </div>
            <?php echo '
            <script language="javascript" type="text/javascript">
				for(i=0;i<txt.length;i++)
					{
						var valCon = \'commentText_\' + comment_id[i];
						temp = replace_string(txt[i], \'<br>\', \'\\n\');
						temp = replace_string(temp, \'<br />\', \'\\n\');
						document.getElementById(valCon).value = temp;
					}
			</script>
            '; ?>

            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
           	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>
            
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            
		<?php else: ?>
			<div id="selMsgAlert">
				<p><?php echo $this->_tpl_vars['LANG']['no_records_found']; ?>
</p>
			</div>
		<?php endif; ?>               
<?php endif; ?>

	</div>
</div>
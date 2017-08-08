<?php /* Smarty version 2.6.18, created on 2011-10-17 15:09:03
         compiled from musicActivate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicActivate.tpl', 6, false),)), $this); ?>
<div id="selPhotoList">
    <h2><span><?php echo $this->_tpl_vars['LANG']['musicactivate_title']; ?>
</span></h2>
    <div id="selMsgConfirmDelete" class="selMsgConfirm clsConfirmPopup" style="display:none;">
        <p id="confirmMsg"></p>
            <form name="confirmationForm" id="confirmationForm" method="post" action="<?php echo $this->_tpl_vars['_SERVER']['PHP_SELF']; ?>
" autocomplete="off">
                            <input type="submit" class="clsSubmitButton" name="submit_button" id="submit_button" value="<?php echo $this->_tpl_vars['LANG']['act_yes']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;
                            <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['act_no']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks();" />
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="music_id" id="music_id" />

                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden); ?>

            </form>
    </div>
    <!-- information div -->
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!-- preview_block start-->
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('preview_block')): ?>
        <div id="selDeleteConfirm">
            <form name="music_delete_form" id="music_delete_form" method="post" action="<?php echo $this->_tpl_vars['_SERVER']['PHP_SELF']; ?>
" autocomplete="off">
                <table summary="<?php echo $this->_tpl_vars['LANG']['musicactivate_tbl_summary']; ?>
" class="clsMyPhotosTable clsNoBorder ">
                    <tr>
                        <td colspan="3">
                           	<div id="flashcontent2">
							                               <script type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/swfobject.js"></script>
                                                                  <?php echo $this->_tpl_vars['myobj']->populateSinglePlayer($this->_tpl_vars['music_fields']); ?>

                                                        							</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['myobj']->preview_block['anchor']; ?>
"></a>
                            <input type="button" class="clsSubmitButton" name="activate" id="activate" value="<?php echo $this->_tpl_vars['LANG']['musicactivate_activate']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('music_id', 'action', 'confirmMsg'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
', 'activate', '<?php echo $this->_tpl_vars['LANG']['musicactivate_activate_confirmation']; ?>
'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp;
                            <input type="button" class="clsSubmitButton" name="delete" id="delete" value="<?php echo $this->_tpl_vars['LANG']['musicactivate_delete']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('music_id', 'action', 'confirmMsg'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
', 'delete', '<?php echo $this->_tpl_vars['LANG']['musicactivate_delete_confirmation']; ?>
'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp;
                            <input type="submit" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['musicactivate_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                            <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->preview_block['populateHidden']); ?>

                        </td>
                    </tr>
                </table>
            </form>
        </div>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_music_form')): ?>
        <div id="selMusicList">
        	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                <!-- top pagination start-->
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
               		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
                <!-- top pagination end-->
                <form name="musicListForm" id="musicListForm" action="<?php echo $this->_tpl_vars['_SERVER']['PHP_SELF']; ?>
" method="post">
                    <table summary="<?php echo $this->_tpl_vars['LANG']['musicactivate_tbl_summary']; ?>
">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio"  name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.musicListForm.name, document.musicListForm.check_all.name)" /></th>
                            <th><?php echo $this->_tpl_vars['LANG']['musicactivate_music_title']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['musicactivate_music_thumb']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['musicactivate_user_name']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['musicactivate_date_added']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['musicactivate_option']; ?>
</th>
                        </tr>
                     	<?php $_from = $this->_tpl_vars['myobj']->list_music_form['displayMusicList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['disValue']):
?>
                            <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                            <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="vid[]" id="vid[]" value="<?php echo $this->_tpl_vars['disValue']['record']['music_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></td>
                            <td><?php echo $this->_tpl_vars['disValue']['record']['music_title']; ?>
</td>
                            <td class="clsHomeDispContents"><p id="selImageBorder"><img src="<?php echo $this->_tpl_vars['disValue']['img_src']; ?>
" alt="<?php echo $this->_tpl_vars['disValue']['record']['music_title']; ?>
"<?php echo $this->_tpl_vars['disValue']['DISP_IMAGE']; ?>
 /></p></td>
                            <td><?php echo $this->_tpl_vars['disValue']['record']['user_name']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['disValue']['record']['date_added']; ?>
</td>
                            <td><span id="preview"><a href="?action=preview&amp;music_id=<?php echo $this->_tpl_vars['disValue']['record']['music_id']; ?>
&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"><?php echo $this->_tpl_vars['myobj']->LANG['musicactivate_preview']; ?>
</a></span></td>
                             <input type="hidden" name="user_id" id="user_id" />
							</tr>
                    	<?php endforeach; endif; unset($_from); ?>
                        <tr>
                            <td colspan="6">
                            <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['myobj']->list_music_form['anchor']; ?>
"></a>
                            <input type="button" class="clsSubmitButton" name="activate_button" id="activate_button" value="<?php echo $this->_tpl_vars['LANG']['musicactivate_activate']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->list_music_form['onclick_activate']; ?>
"/>
                            <input type="button" class="clsSubmitButton" name="delete_button" id="delete_button" value="<?php echo $this->_tpl_vars['LANG']['musicactivate_delete']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->list_music_form['onclick_delete']; ?>
"/>
                            </td>
                        </tr>
                    </table>
                </form>
                <!-- bottom pagination start-->
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
                <!-- bottom pagination end-->
            <?php else: ?>
                 <div id="selMsgAlert">
           		<?php echo $this->_tpl_vars['LANG']['musicactivate_no_records_found']; ?>

                 </div>
            <?php endif; ?>
        </div>
	<?php endif; ?>
</div>

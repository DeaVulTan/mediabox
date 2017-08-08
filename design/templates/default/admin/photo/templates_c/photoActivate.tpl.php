<?php /* Smarty version 2.6.18, created on 2011-10-26 11:41:03
         compiled from photoActivate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'photoActivate.tpl', 7, false),)), $this); ?>
<div id="selphotoList">
  	<h2><span><?php echo $this->_tpl_vars['LANG']['photoactivate_title']; ?>
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
                <input type="hidden" name="photo_id" id="photo_id" />

                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden); ?>

            </form>
    </div>

    <!-- information div -->
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!-- preview_block start-->

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_photo_form')): ?>
        <div id="selPhotoList">
        	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                <!-- top pagination start-->
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
               		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
                <!-- top pagination end-->
                <form name="photoListForm" id="photoListForm" action="<?php echo $this->_tpl_vars['_SERVER']['PHP_SELF']; ?>
" method="post">
                    <table summary="<?php echo $this->_tpl_vars['LANG']['photoactivate_tbl_summary']; ?>
">
                        <tr>
                            <th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio"  name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.photoListForm.name, document.photoListForm.check_all.name)" /></th>
                            <th><?php echo $this->_tpl_vars['LANG']['photoactivate_photo_title']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['photoactivate_photo_thumb']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['photoactivate_user_name']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['photoactivate_date_added']; ?>
</th>
                            <th><?php echo $this->_tpl_vars['LANG']['photoactivate_option']; ?>
</th>
                        </tr>
                     	<?php $_from = $this->_tpl_vars['myobj']->list_photo_form['displayPhotoList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['disValue']):
?>
                        <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                            <td class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="vid[]" id="vid[]" value="<?php echo $this->_tpl_vars['disValue']['record']['photo_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></td>
                            <td><?php echo $this->_tpl_vars['disValue']['record']['photo_title']; ?>
</td>
                            <td class="clsHomeDispContents"><p id="selImageBorder"><img src="<?php echo $this->_tpl_vars['disValue']['img_src']; ?>
" alt="<?php echo $this->_tpl_vars['disValue']['record']['photo_title']; ?>
"<?php echo $this->_tpl_vars['disValue']['DISP_IMAGE']; ?>
 /></p></td>
                            <td><?php echo $this->_tpl_vars['disValue']['record']['user_name']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['disValue']['record']['date_added']; ?>
</td>
                            <td>
                            	<span id="preview">
	                                <a id="photoPreview_<?php echo $this->_tpl_vars['disValue']['record']['photo_id']; ?>
" href="<?php echo $this->_tpl_vars['disValue']['previewURL']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoactivate_preview']; ?>
</a>
                                </span>
							</td>
                             <input type="hidden" name="user_id" id="user_id" />
                        </tr>
                    	<?php endforeach; endif; unset($_from); ?>
                        <tr>
                            <td colspan="6">
                            <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['myobj']->list_photo_form['anchor']; ?>
"></a>
                            <input type="button" class="clsSubmitButton" name="activate_button" id="activate_button" value="<?php echo $this->_tpl_vars['LANG']['photoactivate_activate']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->list_photo_form['onclick_activate']; ?>
"/>
                            <input type="button" class="clsSubmitButton" name="delete_button" id="delete_button" value="<?php echo $this->_tpl_vars['LANG']['photoactivate_delete']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->list_photo_form['onclick_delete']; ?>
"/>
                            </td>
                        </tr>
                    </table>
                </form>
                <!-- bottom pagination start-->
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
                <!-- bottom pagination end-->
            <?php else: ?>
                 <div id="selMsgAlert">
           		<?php echo $this->_tpl_vars['LANG']['photoactivate_no_records_found']; ?>

                 </div>
            <?php endif; ?>
        </div>
	<?php endif; ?>
</div>
<script>
<?php echo '
$Jq(document).ready(function() {
	'; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_photo_form')): ?>
		<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
			<?php $_from = $this->_tpl_vars['myobj']->list_photo_form['displayPhotoList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['disValue']):
?>
				<?php echo '
				$Jq(\'#photoPreview_\'+'; ?>
<?php echo $this->_tpl_vars['disValue']['record']['photo_id']; ?>
<?php echo ').fancybox({
					\'width\'				: 900,
					\'height\'			: 750,
					\'padding\'			:  0,
					\'autoScale\'     	: false,
					\'transitionIn\'		: \'none\',
					\'transitionOut\'		: \'none\'
				});
				'; ?>

			<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
	<?php endif; ?>
	<?php echo '
});
'; ?>

</script>
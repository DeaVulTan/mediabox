<?php /* Smarty version 2.6.18, created on 2011-12-13 23:11:18
         compiled from videoActivate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoActivate.tpl', 6, false),)), $this); ?>
<div id="selPhotoList"> 
    <h2><span><?php echo $this->_tpl_vars['LANG']['videoactivate_title']; ?>
</span></h2>
    <div id="selMsgConfirmDelete" class="selMsgConfirm clsConfirmPopup" style="display:none;">
        <p id="confirmMsg"></p>
            <form name="confirmationForm" id="confirmationForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off">
                <input type="submit" class="clsSubmitButton" name="submit_button" id="submit_button" value="<?php echo $this->_tpl_vars['LANG']['act_yes']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;
                <input type="button" class="clsSubmitButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['act_no']; ?>
"  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks();" />
                <input type="hidden" name="action" id="action" />
                <input type="hidden" name="video_id" id="video_id" />
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
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('preview_block')): ?>
        <div id="selDeleteConfirm"> 
            <form name="video_delete_form" id="video_delete_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" autocomplete="off"> 
                <table summary="<?php echo $this->_tpl_vars['LANG']['videoactivate_tbl_summary']; ?>
" class="clsMyPhotosTable"> 
                    <tr> 
                        <td colspan="3">
                        <?php if ($this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
                       		<?php echo $this->_tpl_vars['myobj']->displayEmbededVideo(); ?>

                        <?php endif; ?>
                        <?php if (! $this->_tpl_vars['myobj']->checkIsExternalEmebedCode()): ?>
                        	<script type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/swfobject.js"></script>
                           	<div id="flashcontent2"></div>
					<script type="text/javascript">
                                var so1 = new SWFObject("<?php echo $this->_tpl_vars['myobj']->preview_block['flv_player_url']; ?>
", "flvplayer", "450", "370", "7",  null, true);
                                so1.addParam("wmode", "transparent");
                                so1.addParam("allowFullScreen", "true");
                                so1.addParam("allowSciptAccess", "always");
                                so1.addVariable("config", "<?php echo $this->_tpl_vars['myobj']->preview_block['configXmlcode_url']; ?>
");
                                so1.write("flashcontent2");
                            </script>	
                         <?php endif; ?>		  	
                        </td> 
                    </tr> 
                    <tr>
                        <td>
                            <a href="#" id="<?php echo $this->_tpl_vars['myobj']->preview_block['anchor']; ?>
"></a>
                            <input type="button" class="clsSubmitButton" name="activate" id="activate" value="<?php echo $this->_tpl_vars['LANG']['videoactivate_activate']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('video_id', 'action', 'confirmMsg'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
', 'activate', '<?php echo $this->_tpl_vars['LANG']['videoactivate_activate_confirmation']; ?>
'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp; 
                            <input type="button" class="clsSubmitButton" name="delete" id="delete" value="<?php echo $this->_tpl_vars['LANG']['videoactivate_delete']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="Confirmation('selMsgConfirmDelete', 'confirmationForm', Array('video_id', 'action', 'confirmMsg'), Array('<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
', 'delete', '<?php echo $this->_tpl_vars['LANG']['videoactivate_delete_confirmation']; ?>
'), Array('value', 'value', 'innerHTML'), 50, -400);" /> &nbsp; 
                            <input type="submit" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['videoactivate_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> 
                            <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->preview_block['populateHidden']); ?>
					
                        </td>
                    </tr>
                </table>      
            </form> 
        </div>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_videos_form')): ?>
        <div id="selVideoList"> 
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
                <form name="videoListForm" id="videoListForm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post">
                    <table summary="<?php echo $this->_tpl_vars['LANG']['videoactivate_tbl_summary']; ?>
"> 
                        <tr> 
                            <th><input type="checkbox" class="clsCheckRadio"  name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.videoListForm.name, document.videoListForm.check_all.name)" /></th>
                            <th><?php echo $this->_tpl_vars['LANG']['videoactivate_video_title']; ?>
</th> 
                            <th><?php echo $this->_tpl_vars['LANG']['videoactivate_video_thumb']; ?>
</th> 
                            <th><?php echo $this->_tpl_vars['LANG']['videoactivate_user_name']; ?>
</th> 
                            <th><?php echo $this->_tpl_vars['LANG']['videoactivate_date_added']; ?>
</th> 
                            <th><?php echo $this->_tpl_vars['LANG']['videoactivate_option']; ?>
</th> 
                        </tr> 
                     	<?php $_from = $this->_tpl_vars['myobj']->list_videos_form['displayVideoList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['disValue']):
?>
                            <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                            <td><input type="checkbox" class="clsCheckRadio" name="vid[]" id="vid" value="<?php echo $this->_tpl_vars['disValue']['record']['video_id']; ?>
-<?php echo $this->_tpl_vars['disValue']['record']['user_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /></td>
                            <td><?php echo $this->_tpl_vars['disValue']['record']['video_title']; ?>
</td> 
                            <td class="clsHomeDispContents"><p id="selImageBorder">
                            
                             <a id="viewVideo_<?php echo $this->_tpl_vars['disValue']['record']['video_id']; ?>
" href="videoPreview.php?video_id=<?php echo $this->_tpl_vars['disValue']['record']['video_id']; ?>
" title="<?php echo $this->_tpl_vars['disValue']['record']['video_title']; ?>
"><img src="<?php echo $this->_tpl_vars['disValue']['file_path']; ?>
" alt="<?php echo $this->_tpl_vars['disValue']['record']['video_title']; ?>
"<?php echo $this->_tpl_vars['disValue']['DISP_IMAGE']; ?>
 /></a>
                            
                                                        
                            </p></td> 
                            <td><?php echo $this->_tpl_vars['disValue']['record']['user_name']; ?>
</td> 
                            <td><?php echo $this->_tpl_vars['disValue']['record']['date_added']; ?>
</td> 
                            <td><span id="preview"><a href="?action=preview&amp;video_id=<?php echo $this->_tpl_vars['disValue']['record']['video_id']; ?>
&amp;start=<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"><?php echo $this->_tpl_vars['myobj']->LANG['videoactivate_preview']; ?>
</a></span></td> 
                            </tr> 
                    	<?php endforeach; endif; unset($_from); ?>
                        <tr>
                            <td colspan="6">
                            <a href="#" id="<?php echo $this->_tpl_vars['myobj']->list_videos_form['anchor']; ?>
"></a>
                            <input type="button" class="clsSubmitButton" name="activate_button" id="activate_button" value="<?php echo $this->_tpl_vars['LANG']['videoactivate_activate']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->list_videos_form['onclick_activate']; ?>
"/>
                            <input type="button" class="clsSubmitButton" name="delete_button" id="delete_button" value="<?php echo $this->_tpl_vars['LANG']['videoactivate_delete']; ?>
" onClick="<?php echo $this->_tpl_vars['myobj']->list_videos_form['onclick_delete']; ?>
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
           		<?php echo $this->_tpl_vars['LANG']['videoactivate_no_records_found']; ?>

                 </div>
            <?php endif; ?>
        </div>
	<?php endif; ?> 
</div>    



<script>
<?php echo '
$Jq(document).ready(function() {
	'; ?>

	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	<?php $_from = $this->_tpl_vars['myobj']->list_videos_form['displayVideoList']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dalValue']):
?>
	<?php echo '
	$Jq(\'#viewVideo_\'+'; ?>
<?php echo $this->_tpl_vars['dalValue']['record']['video_id']; ?>
<?php echo ').fancybox({
		\'width\'				: 900,
		\'height\'			: 600,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});


	$Jq(\'#videoPreview_\'+'; ?>
<?php echo $this->_tpl_vars['dalValue']['record']['video_id']; ?>
<?php echo ').fancybox({
		\'width\'				: 900,
		\'height\'			: 600,
		\'padding\'			:  0,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
	'; ?>

	<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
	<?php echo '
});
'; ?>

</script>
    	
<?php /* Smarty version 2.6.18, created on 2011-10-19 10:49:22
         compiled from indexMediaTabSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'indexMediaTabSettings.tpl', 37, false),)), $this); ?>
<?php if (! isAjaxPage ( )): ?>
	<div id="tabsview">
		<ul>
			<?php $_from = $this->_tpl_vars['myobj']->cname_array; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cakey'] => $this->_tpl_vars['cavalue']):
?>
				<?php $this->assign('label_name', "media_type_".($this->_tpl_vars['cakey'])); ?>
				<?php if ($this->_tpl_vars['CFG']['user']['usr_access'] == 'Admin' || $this->_tpl_vars['myobj']->checkUserPermission($this->_tpl_vars['CFG']['user']['user_actions'],'settings',$this->_tpl_vars['LANG'][$this->_tpl_vars['label_name']])): ?>
                	<?php if (chkAllowedModule ( array ( $this->_tpl_vars['cakey'] ) )): ?>
					<li><a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
?cname=<?php echo $this->_tpl_vars['cakey']; ?>
"><?php echo $this->_tpl_vars['LANG'][$this->_tpl_vars['label_name']]; ?>
</a></li>
                 	<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
<?php else: ?>
	<div id="seldevManageConfig">
		<div>
	  		<h2><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_title']; ?>
</h2>
            <p><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_heading_note']; ?>
</p>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_config_edit')): ?>
				<div class="clsDataTable">
					<?php $this->assign('c_name', $this->_tpl_vars['myobj']->getFormField('cname')); ?>
					<form name="form_editconfig_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" id="form_editconfig_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" onsubmit="" autocomplete="off">
				        <table>
				        	<?php $_from = $this->_tpl_vars['myobj']->block_config_edit['populateMediaTab']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cvkey'] => $this->_tpl_vars['cvvalue']):
?>
                            <?php $this->assign('c_media_tab_type', $this->_tpl_vars['cvvalue']['media_tab_type']); ?>
                            <?php $this->assign('c_media_tab_id', $this->_tpl_vars['cvvalue']['index_media_tab_id']); ?>
				        		<?php if ($this->_tpl_vars['cvvalue']['media_tab_type']): ?>
                                    <tr>
                                        <td class="clsWidthSmall">
                                            <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="media_type"><?php echo $this->_tpl_vars['myobj']->media_tab_array[$this->_tpl_vars['c_name']]; ?>
</label>
                                        </td>
                                        <td>
                                        <input type="hidden" name="index_media_tab_id" value="<?php echo $this->_tpl_vars['cvvalue']['index_media_tab_id']; ?>
" />
                                        	
                                            <select name="media_tab_type" id="media_tab_type" onchange="funFeatureReorderAction(this.value,<?php echo $this->_tpl_vars['cvvalue']['index_media_tab_id']; ?>
)"> tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                                    		<?php $_from = $this->_tpl_vars['myobj']->media_tab_type_array; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mdkey'] => $this->_tpl_vars['mdvalue']):
?>
                                            	<?php if ($this->_tpl_vars['mdkey'] == $this->_tpl_vars['c_name']): ?>
                                                    <?php $_from = $this->_tpl_vars['mdvalue']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mtabkey'] => $this->_tpl_vars['mtabvalue']):
?>
                                                 <option value='<?php echo $this->_tpl_vars['mtabkey']; ?>
' <?php if ($this->_tpl_vars['cvvalue']['media_tab_type'] == $this->_tpl_vars['mtabkey']): ?> selected <?php endif; ?>><?php echo $this->_tpl_vars['mtabvalue']; ?>
</option>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                <?php endif; ?>
                                            <?php endforeach; endif; unset($_from); ?>
                                            
                                    </select>
                                        </td>
                                    </tr>
                                    </table>
                                    <table id="dvFeatureReorder_<?php echo $this->_tpl_vars['c_media_tab_id']; ?>
"  style="<?php if ($this->_tpl_vars['c_media_tab_type'] == 'recommendedphoto' || $this->_tpl_vars['c_media_tab_type'] == 'recommendedmusic' || $this->_tpl_vars['c_media_tab_type'] == 'recommendedvideo'): ?>display:block;<?php else: ?>display:none<?php endif; ?>">
                                    <tr>
                                    	<td colspan="2"><div>                       
                            <a id ="featureReorder_<?php echo $this->_tpl_vars['c_media_tab_id']; ?>
" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
<?php echo $this->_tpl_vars['myobj']->media_tab_reorder[$this->_tpl_vars['c_name']]; ?>
"><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_feature_reorder']; ?>
</a>
                            <?php if ($this->_tpl_vars['c_name'] == 'photo'): ?>  
                            	<?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_photo_feature_note1']; ?>

                                <a href="#"  onclick="callPhotoHome();"><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_photo_feature_note2']; ?>
</a><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_photo_feature_note3']; ?>

                            <?php elseif ($this->_tpl_vars['c_name'] == 'video'): ?> 
                            	<?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_video_feature_note1']; ?>

                                <a href="#"  onclick="callVideoHome();"><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_video_feature_note2']; ?>
</a><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_video_feature_note3']; ?>

                            <?php elseif ($this->_tpl_vars['c_name'] == 'music'): ?> 
                            	<?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_music_feature_note1']; ?>

                                <a href="#"  onclick="callMusicHome();"><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_music_feature_note2']; ?>
</a><?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_music_feature_note3']; ?>

                            <?php else: ?>
                            <?php echo $this->_tpl_vars['LANG']['index_mediatabsetting_feature_note']; ?>

                            <?php endif; ?>
                            </div>
                                        </td>
                                    </tr>
                                    
    								</table>
				        		<?php endif; ?>
						   	<?php endforeach; endif; unset($_from); ?>
                            <table>
						   	<tr>
								<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('submit'); ?>
" colspan="2">
									<input type="submit" class="clsSubmitButton" name="add_submit" id="add_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" onClick="$Jq('#act_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
').val('add_submit'); return postAjaxForm('form_editconfig_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
', 'ui-tabs-<?php echo $this->_tpl_vars['myobj']->cname_array[$this->_tpl_vars['c_name']]; ?>
')" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="cname" value="<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" />
						<input type="hidden" name="act" id="act_<?php echo $this->_tpl_vars['myobj']->getFormField('cname'); ?>
" value="" />
 							
                                        <script>
											<?php echo '
											$Jq(document).ready(function() {
										 
															$Jq(\'#featureReorder_\'+'; ?>
<?php echo $this->_tpl_vars['c_media_tab_id']; ?>
<?php echo ').fancybox({
																\'width\'				: 900,
																\'height\'			: 500,
																\'padding\'			:  0,
																\'autoScale\'     	: false,
																\'transitionIn\'		: \'none\',
																\'transitionOut\'		: \'none\',
																\'type\'				: \'iframe\'
															});
											 });
											'; ?>

										</script> 
                                        
					</form>
			   	</div>
			<?php endif; ?>
		</div>
	</div>

<?php endif; ?>


<?php echo '
<script language="javascript">

function callVideoHome()
	{
		parent.location =\''; ?>
<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/video/videoManage.php<?php echo '\';
	}
function callPhotoHome()
	{
		parent.location =\''; ?>
<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/photo/photoManage.php<?php echo '\';
	}
function callMusicHome()
	{
		parent.location =\''; ?>
<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/musicManage.php<?php echo '\';
	}	
</script>
'; ?>

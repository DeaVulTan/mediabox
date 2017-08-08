<?php /* Smarty version 2.6.18, created on 2011-10-18 17:41:11
         compiled from createalbum.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'createalbum.tpl', 19, false),)), $this); ?>
<script language="javascript" type="text/javascript" src=cfg_site_url+"js/functions.js"></script>
<div id="selCreateAlbum1">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsPageHeading"><h2><?php if ($this->_tpl_vars['myobj']->getFormField('video_album_id') == ''): ?><?php echo $this->_tpl_vars['LANG']['createalbum_create_album']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['LANG']['createalbum_update_album']; ?>
<?php endif; ?></h2></div>
  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="selLeftNavigation">
		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('create_album_form')): ?>

            <div id="selAlbum" class="clsDataTable">
				<form name="create_album_form" id="create_album_form" method="post" action="<?php echo $this->_tpl_vars['myobj']->form_album_create['form_action']; ?>
" autocomplete="off">
			    	<div id="selUploadBlock">
                    <table summary="<?php echo $this->_tpl_vars['LANG']['createalbum_tbl_summary']; ?>
" class="clsCreateAlbumTable">
			    		<tr>
			         		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('album_title'); ?>
">
								<label for="album_title"><?php echo $this->_tpl_vars['LANG']['createalbum_field_length_lbl']; ?>
<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</label>
							</td>
			          		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('album_title'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_title'); ?>

								<input type="text" class="clsTextBox" name="album_title" id="album_title" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('album_title'); ?>
" maxlength="<?php echo $this->_tpl_vars['CFG']['admin']['musics']['title_length']; ?>
" /><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('album_title'); ?>

							</td>
			        	</tr>
						<tr>
			         		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('album_description'); ?>
">
								<label for="album_description"><?php echo $this->_tpl_vars['LANG']['createalbum_album_description']; ?>
<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</label>
							</td>
			          		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('album_description'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_description'); ?>

								<textarea name="album_description" id="album_description" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('album_description'); ?>
</textarea><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('album_description'); ?>

							</td>
			        	</tr>
						<!--<tr>
			         		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('album_access_type'); ?>
">
								<label for="album_access_type"><?php echo $this->_tpl_vars['LANG']['createalbum_album_access_type']; ?>
</label>
							</td>
			          		<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('album_access_type'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_access_type'); ?>

								<p><input type="radio" class="clsCheckRadio" name="album_access_type" id="album_access_type1" value="Public" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_access_type','Public'); ?>
 />&nbsp;<label for="album_access_type1"><?php echo $this->_tpl_vars['LANG']['createalbum_public']; ?>
</label></p>
								<p><input type="radio" class="clsCheckRadio" name="album_access_type" id="album_access_type2" value="Private" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"<?php echo $this->_tpl_vars['myobj']->isCheckedRadio('album_access_type','Private'); ?>
 />&nbsp;<label for="album_access_type2"><?php echo $this->_tpl_vars['LANG']['createalbum_private']; ?>
</label></p>
								<p class="clsSelectHighlightNote"><?php echo $this->_tpl_vars['LANG']['createalbum_only_viewable_you_email']; ?>
</p>
								<p><?php echo $this->_tpl_vars['myobj']->populateCheckBoxForRelationList(); ?>
</p><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('album_access_type'); ?>

							</td>
			        	</tr>-->
						<tr>
                        	<td></td>
							<td class="clsCreateAlbumVideo">
                            	<input type="hidden" name="album_access_type" id="album_access_type" value="Public"/>
                                <input type="hidden" name="video_album_id" id="video_album_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_album_id'); ?>
"/>
								<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->form_album_create['form_hidden_value']); ?>

								<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="create_album" id="create_album" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php if ($this->_tpl_vars['myobj']->getFormField('video_album_id') == ''): ?><?php echo $this->_tpl_vars['LANG']['createalbum_create_album']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['LANG']['createalbum_update_album']; ?>
<?php endif; ?>" /></div></div>
								<div class="clsCancelMargin"><div class="clsCancelLeft"><div class="clsCancelRight"><input type="button" class="clsSubmitButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['createalbum_cancel']; ?>
" onClick="clearValue()"/></div></div></div>
							</td>
						</tr>
					</table>
                    </div>
				</form>
			</div>
            </div>
		<?php endif; ?>
	</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<?php if ($this->_tpl_vars['myobj']->form_album_create['popup_value'] != '0'): ?>
<script language="javascript" type="text/javascript" src=src=cfg_site_url+"js/functions.js"></script>
<script language="javascript" type="text/javascript">
setFullScreenBrowser();
</script>
<?php endif; ?>
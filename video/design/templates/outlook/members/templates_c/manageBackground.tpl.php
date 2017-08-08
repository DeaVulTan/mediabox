<?php /* Smarty version 2.6.18, created on 2011-11-07 10:30:17
         compiled from manageBackground.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageBackground.tpl', 16, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsPageHeading">
<h2><?php echo $this->_tpl_vars['LANG']['upload_background_pg_title']; ?>
</h2>
</div>
<p><?php echo $this->_tpl_vars['LANG']['upload_background_descritption']; ?>
</p>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- confirmation box start-->
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;position:absolute;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			<table summary="<?php echo $this->_tpl_vars['LANG']['tbl_summary']; ?>
">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="action" id="action" value="delete" />
					</td>
				</tr>
			</table>
		</form>
	</div>
<!-- End -->
<form name="manageBackgroundFrm" id="manageBackgroundFrm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(false); ?>
" method="post" enctype="multipart/form-data">
   <p class="ClsMandatoryText"><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_1']; ?>
<span class="clsMandatoryFieldIconInText">*</span><?php echo $this->_tpl_vars['LANG']['common_mandatory_hint_2']; ?>
</p>
    <div class="clsDataTable">
        <table summary="<?php echo $this->_tpl_vars['LANG']['tbl_summary']; ?>
" class="clsManageBackgroundImage">
        <tr>
        	<td colspan="2">
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_image_display')): ?>
                    <div class="clsOverflow">
                        <p class="clsViewThumbImage"><span><img src="<?php echo $this->_tpl_vars['myobj']->background_path; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['videobackground_alttag']; ?>
"<?php if ($this->_tpl_vars['myobj']->image_width > 250): ?> width="250"<?php endif; ?>></span></p>
                    </div>
                    <div class="clsDeleteBackground">
                    	<a href="javascript:void(0)"  onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('confirmMessage'), Array('<?php echo $this->_tpl_vars['LANG']['manageBackground_deleted_confirm_message']; ?>
'), Array('innerHTML'));"><?php echo $this->_tpl_vars['LANG']['managebackground_delete_background']; ?>
</a>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('background_image'); ?>
 clsManageBackgroundLabel"><?php echo $this->_tpl_vars['LANG']['upload_background_image_title']; ?>
 (<?php echo $this->_tpl_vars['myobj']->imageFormat; ?>
) <?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
</td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('background_image'); ?>
">
            <input type="file" class="clsFileBox""  name="background_image" id="background_image" />
            <div><!-- -->
            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('background_image'); ?>

            </div>
            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('background_image'); ?>

            </td>
        </tr>
        <tr>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('background_offset'); ?>
"><label for="background_offset"><?php echo $this->_tpl_vars['LANG']['managebackground_backgroundoffset']; ?>
 <a onclick="showImageTip()" title="<?php echo $this->_tpl_vars['LANG']['playerOffset_tooltip']; ?>
"><?php echo $this->_tpl_vars['LANG']['videobackground_help']; ?>
</a></label><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>


            </td>
            <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('background_offset'); ?>
" ><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('background_offset'); ?>
<input type="text"  name="background_offset" id="background_offset" value="<?php echo $this->_tpl_vars['myobj']->getFormField('background_offset'); ?>
"><?php echo $this->_tpl_vars['myobj']->ShowHelpTip('background_offset'); ?>


            </td>
        </tr>
        <tr>
        	<td></td>
            <td ><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name ="uploadBackground" value="<?php echo $this->_tpl_vars['LANG']['upload_background_image']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" ></div></div>
            <div class="clsCancelLeft"><div class="clsCancelRight"><input id="cancel" type="button" onclick="window.location='<?php  echo getUrl('videolist','?pg=videonew','videonew/','','video') ?>'" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['cancel_button']; ?>
"/></div></div>

            </td>
        </tr>
        </table>
        <table>
        <tr>
        <td>
         <div id="imageTip" style="display:none;margin-top:10px;" ><div class="clsCloseOffsetImage">
            <div value="close" onclick="showImageTip()" title="Close" class="clsCloseWindow"></div>
            <img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/playeroffset.jpg" /></div>
            </div>
        </td> </tr>
        </table>
    </div>
</form>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
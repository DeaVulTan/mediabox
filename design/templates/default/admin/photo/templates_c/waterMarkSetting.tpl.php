<?php /* Smarty version 2.6.18, created on 2012-02-02 19:19:26
         compiled from waterMarkSetting.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'waterMarkSetting.tpl', 46, false),)), $this); ?>
<div id="searchSetting">
	<h2><?php echo $this->_tpl_vars['LANG']['settings_title']; ?>
</h2>

    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
     <!-- confirmation box -->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
	</div>
    <!-- confirmation box-->
	<?php if (! $this->_tpl_vars['CFG']['admin']['photos']['watermark_apply']): ?>
    <div><?php echo $this->_tpl_vars['LANG']['watermark_image_note']; ?>
</div>
	<?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_settings_block')): ?>
    	<div style="padding:10px;">
			<div style="width:150px; float:left;"><label ><?php echo $this->_tpl_vars['LANG']['watermark_image_label']; ?>
</label></div>
			<div >
					<img src="<?php echo $this->_tpl_vars['imagePath']; ?>
?t=<?php echo time(); ?>
" />
					<a href="waterMarkSetting.php?block=edit"><b><?php echo $this->_tpl_vars['LANG']['watermark_edit']; ?>
</b></a>
			</div>
		</div>
	<?php else: ?>
		<div><?php echo $this->_tpl_vars['LANG']['watermark_no_image_label']; ?>
</div>
    <?php endif; ?>
	<div id="selWaterMArkImegeDiv" style="display:<?php echo $this->_tpl_vars['form_display']; ?>
">
    <form name="selFormTemplate" id="selFormTemplate" action="waterMarkSetting.php" method="post" enctype="multipart/form-data">
        <table class="clsNoBorder">
        	<tr>
            	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('watermark_type'); ?>
"><label for="watermark_type"><?php echo $this->_tpl_vars['LANG']['settings_select_type']; ?>
</label></td>
                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('watermark_type'); ?>
">
                	<INPUT TYPE="radio" NAME="watermark_type" VALUE="image" onclick="return changeWaterMarkType(this.value);" <?php if ($this->_tpl_vars['myobj']->getFormField('watermark_type') == 'image'): ?> checked <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['settings_type_image']; ?>

                	<INPUT TYPE="radio" NAME="watermark_type" VALUE="font"  onclick="return changeWaterMarkType(this.value);" <?php if ($this->_tpl_vars['myobj']->getFormField('watermark_type') == 'font'): ?>  checked <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['settings_type_font']; ?>

                </td>
            </tr>

            <tr>
            	<td colspan="2">
            	            	<div id="selImageMarker" style="display:block">
                	<table class="clsNoBorder">
                    	<tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('watermark_file'); ?>
">
                            	<?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="watermark_file"><?php echo $this->_tpl_vars['LANG']['settings_upload_watermark_file']; ?>
</label><br />
                                (<?php echo $this->_tpl_vars['myobj']->imageFormat; ?>
) &nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['watermark']['water_mark_max_size']; ?>
 KB
                            </td>
                        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('watermark_file'); ?>
"><label for="watermark_file"><input type="file" accept="photo/<?php echo $this->_tpl_vars['myobj']->photo_format; ?>
" name="photo_file" id="photo_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('photo_file'); ?>
</label></td>
                    	</tr>
                	</table>
            	</div>
            	            	            	<div id="selFontMarker" style="display:none">
                	<table class="clsNoBorder">
                    	<tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('watermark_text'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="watermark_text"><?php echo $this->_tpl_vars['LANG']['settings_upload_watermark_text']; ?>
</label></td>
                        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('watermark_text'); ?>
">
                            	<input type="text" name="water_mark_text" id="water_mark_text" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('water_mark_text'); ?>
" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('water_mark_text'); ?>

                            </td>
                    	</tr>
                        <tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('back_ground_color'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="back_ground_color"><?php echo $this->_tpl_vars['LANG']['background_color']; ?>
</label></td>
	                        <td>
                                <select name="back_ground_color" id="back_ground_color" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="validate-selection">
                                <?php echo $this->_tpl_vars['myobj']->generalPopulateColorArray($this->_tpl_vars['smarty_color_list'],$this->_tpl_vars['myobj']->getFormField('back_ground_color')); ?>

                                </select><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('back_ground_color'); ?>

                            </td>
                        </tr>
                        <tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('text_color'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="text_color"><?php echo $this->_tpl_vars['LANG']['text_color']; ?>
</label></td>
	                        <td>
                                <select name="text_color" id="text_color" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="validate-selection">
                                <?php echo $this->_tpl_vars['myobj']->generalPopulateColorArray($this->_tpl_vars['smarty_color_list'],$this->_tpl_vars['myobj']->getFormField('text_color')); ?>

                                </select><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('text_color'); ?>

                            </td>
                        </tr>
                        <tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('text_size'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="text_size"><?php echo $this->_tpl_vars['LANG']['text_size']; ?>
</label></td>
                            <td>
                            	<select name="text_size" id="text_size" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="validate-selection">
                                <?php echo $this->_tpl_vars['myobj']->generalPopulateTextSizeArray($this->_tpl_vars['smarty_text_list'],$this->_tpl_vars['myobj']->getFormField('text_size')); ?>

                                </select><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('text_size'); ?>

                            </td>
                        </tr>
                        <tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_width'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="water_mark_text_width"><?php echo $this->_tpl_vars['LANG']['water_mark_text_width']; ?>
</label></td>
                        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_width'); ?>
">
                            	<input type="text" name="water_mark_text_width" id="water_mark_text_width" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('water_mark_text_width'); ?>
" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('water_mark_text_width'); ?>

                            </td>
                    	</tr>
                    	<tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_height'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="water_mark_text_height"><?php echo $this->_tpl_vars['LANG']['water_mark_text_height']; ?>
</label></td>
                        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_height'); ?>
">
                            	<input type="text" name="water_mark_text_height" id="water_mark_text_height" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('water_mark_text_height'); ?>
" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('water_mark_text_height'); ?>

                            </td>
                    	</tr>
                        <tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_xposition'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="water_mark_text_xposition"><?php echo $this->_tpl_vars['LANG']['water_mark_text_xposition']; ?>
</label></td>
                        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_xposition'); ?>
">
                            	<input type="text" name="water_mark_text_xposition" id="water_mark_text_xposition" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('water_mark_text_xposition'); ?>
" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('water_mark_text_xposition'); ?>

                            </td>
                    	</tr>
                    	<tr>
                        	<td class="clsSmallWidth <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_yposition'); ?>
"><?php echo $this->_tpl_vars['myobj']->displayCompulsoryIcon(); ?>
<label for="water_mark_text_yposition"><?php echo $this->_tpl_vars['LANG']['water_mark_text_yposition']; ?>
</label></td>
                        	<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('water_mark_text_yposition'); ?>
">
                            	<input type="text" name="water_mark_text_yposition" id="water_mark_text_yposition" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('water_mark_text_yposition'); ?>
" /><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('water_mark_text_yposition'); ?>

                            </td>
                    	</tr>
                	</table>
            	</div>
            	            	</td>
            </tr>
        	<tr>
            	<td></td>
            	<td>
                	<input type="submit" class="clsSubmitButton" name="update" id="update" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_update']; ?>
" />
            	</td>
        	</tr>
        </table>
    </form>
	</div>
</div>
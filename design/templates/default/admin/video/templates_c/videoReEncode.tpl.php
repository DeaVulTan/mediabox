<?php /* Smarty version 2.6.18, created on 2011-10-25 14:54:00
         compiled from videoReEncode.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoReEncode.tpl', 18, false),)), $this); ?>
<div id="selvideoList">
  	<h2><span><?php echo $this->_tpl_vars['LANG']['videoRencode_title']; ?>
</span></h2>
</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('show_command')): ?>
 <div id="selActivationConfirm">
 	<form id="videoReEncodeFrm" name="videoReEncodeFrm" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post">
		<input type="hidden" name="video_id" id="video_id" value="<?php echo $this->_tpl_vars['myobj']->video_id; ?>
">
		<table summary="<?php echo $this->_tpl_vars['LANG']['videoRencode_tbl_summary']; ?>
" class="clsNoBorder" width="90%">
			<tr>
				<td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('mencoder_path'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['mencoder_path']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('mencoder_path'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('mencoder_path'); ?>

					<input type="hidden" name="mencoder_path" id="mencoder_path" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"  value='<?php echo $this->_tpl_vars['myobj']->getFormField('mencoder_path'); ?>
'>
				</td>
            </tr>
            <tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('input_video'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['input_video']; ?>
</label> <span class="clsMandatoryFieldIcon">*</span>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('input_video'); ?>
">
					<textarea name='input_video' id='input_video' tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    onKeyUp="showOut()"><?php echo $this->_tpl_vars['myobj']->getFormField('input_video'); ?>
</textarea>
                    <div><!-- -->
                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('input_video'); ?>

                    </div>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('encode_hide_1'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['encode_hide_1']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('encode_hide_1'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_1'); ?>

					<input type="hidden" name="encode_hide_1" id="encode_hide_1" value="<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_1'); ?>
">
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('output_video'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['output_video']; ?>
</label> <span class="clsMandatoryFieldIcon">*</span>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('output_video'); ?>
">
					<textarea name='output_video' id='output_video' tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                	onKeyUp="showOut()"><?php echo $this->_tpl_vars['myobj']->getFormField('output_video'); ?>
</textarea>
                    <div><!-- -->
                    	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('output_video'); ?>

                    </div>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('extra_command'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['extra_command']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('extra_command'); ?>
">
					<textarea name='extra_command' id='extra_command' tabindex="<?php echo smartyTabIndex(array(), $this);?>
"
                    onKeyUp="showOut()"><?php echo $this->_tpl_vars['myobj']->getFormField('extra_command'); ?>
</textarea>
				<br>
					<?php echo $this->_tpl_vars['LANG']['extra_command_description']; ?>

				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('encode_hide_2'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['encode_hide_2']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('encode_hide_2'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_2'); ?>

					<input type="hidden" name="encode_hide_2" id="encode_hide_2" value="<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_2'); ?>
">
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('audio_codec'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['audio_codec']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('audio_codec'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('audio_codec'); ?>

					<input type="text" name="audio_codec" id="audio_codec" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onKeyUp="showOut()"
                    value="<?php echo $this->_tpl_vars['myobj']->getFormField('audio_codec'); ?>
" size=50/>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('encode_hide_3'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['encode_hide_3']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('encode_hide_3'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_3'); ?>

					<input type="hidden" name="encode_hide_3" id="encode_hide_3" value="<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_3'); ?>
">
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('vbitrate'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['vbitrate']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('vbitrate'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('vbitrate'); ?>

					<input type="text" name="vbitrate" id="vbitrate" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onKeyUp="showOut()"
                    value="<?php echo $this->_tpl_vars['myobj']->getFormField('vbitrate'); ?>
" size=50/>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('encode_hide_4'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['encode_hide_4']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('encode_hide_4'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_4'); ?>

					<input type="hidden" name="encode_hide_4" id="encode_hide_4" value="<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_4'); ?>
">
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('vfscale'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['vfscale']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('vfscale'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('vfscale'); ?>

					<input type="text" name="vfscale" id="vfscale" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onKeyUp="showOut()"
                    value="<?php echo $this->_tpl_vars['myobj']->getFormField('vfscale'); ?>
" size=50/>
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('encode_hide_5'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['encode_hide_5']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('encode_hide_5'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_5'); ?>

					<input type="hidden" name="encode_hide_5" id="encode_hide_5" value="<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_5'); ?>
">
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('srate'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['srate']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('srate'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('srate'); ?>

					<input type="text" name="srate" id="srate" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onKeyUp="showOut()" value="<?php echo $this->_tpl_vars['myobj']->getFormField('srate'); ?>
"
                    size=50/>
				</td>
			</tr>
				<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('encode_hide_6'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['encode_hide_6']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('encode_hide_6'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_6'); ?>

					<input type="hidden" name="encode_hide_6" id="encode_hide_6" value="<?php echo $this->_tpl_vars['myobj']->getFormField('encode_hide_6'); ?>
">
				</td>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('lavcresample'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['lavcresample']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('lavcresample'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('lavcresample'); ?>

					<input type="text" name="lavcresample" id="lavcresample" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onKeyUp="showOut()"
                    value="<?php echo $this->_tpl_vars['myobj']->getFormField('lavcresample'); ?>
" size=50/>
				</td>
			</tr>
				<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('strBframes'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['strBframes']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('strBframes'); ?>
">
					<?php echo $this->_tpl_vars['myobj']->getFormField('strBframes'); ?>

					<input type="hidden" name="strBframes" id="strBframes" value="<?php echo $this->_tpl_vars['myobj']->getFormField('strBframes'); ?>
">
				</td>
			</tr>
			</tr>
			<tr>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('add_to_cron'); ?>
">
					<label for="list"><?php echo $this->_tpl_vars['LANG']['add_to_cron']; ?>
</label>
				</td>
				<td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('add_to_cron'); ?>
">
					<input type="radio" name="add_to_cron" id="add_to_cron" value="Yes" <?php if ($this->_tpl_vars['myobj']->getFormField('add_to_cron') == 'Yes'): ?> checked <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['yes']; ?>
 &nbsp;
					<input type="radio" name="add_to_cron" id="add_to_cron" value="No" <?php if ($this->_tpl_vars['myobj']->getFormField('add_to_cron') == 'No'): ?> checked <?php endif; ?>><?php echo $this->_tpl_vars['LANG']['no']; ?>

				</td>
			</tr>
			<tr>
				<td id='outdisplay' colspan="2"></td>
			</tr>
			<tr>
				<td colspan='2'>
                <input type="submit" class="clsSubmitButton" name="submit" id="submit" value="<?php echo $this->_tpl_vars['LANG']['submit']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;</td>
			</tr>
		</table>
		<script type="text/javascript">
		showOut();
		</script>
	 </form>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('show_output')): ?>
<h2><?php echo $this->_tpl_vars['LANG']['show_output_title']; ?>
</h2>
<div><?php echo $this->_tpl_vars['myobj']->output; ?>
</div>
<?php endif; ?>

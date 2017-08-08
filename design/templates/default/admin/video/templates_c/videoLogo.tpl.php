<?php /* Smarty version 2.6.18, created on 2011-10-26 16:33:39
         compiled from videoLogo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoLogo.tpl', 24, false),)), $this); ?>
<div id="sellogoupload">
    <h2>
    	<span>
			<?php echo $this->_tpl_vars['LANG']['page_title']; ?>

        </span>
    </h2>
    <div id="selLeftNavigation">
        <!-- information -->

        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('logo_upload_form')): ?>
            <div id="selUpload">
                <form name="logo_video_upload_form" id="logo_video_upload_form" method="post" action="videoLogo.php" autocomplete="off" enctype="multipart/form-data">
                    <div id="selUploadBlock">
                        <table class="clsNoBorder clsUploadBlock"summary="<?php echo $this->_tpl_vars['LANG']['logoupload_tbl_summary']; ?>
" id="selUploadTbl">
                            <tr>
                                <td class="clsWidthSmall <?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('logo_name'); ?>
">
                                    <label for="logo_name">
                                        <?php echo $this->_tpl_vars['LANG']['logo_name']; ?>

                                    </label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('logo_name'); ?>
">
                                    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('logo_name'); ?>

                                    <input type="text" class="clsTextBox" name="logo_name" id="logo_name" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('logo_name'); ?>
" />
                                </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('logo_description'); ?>
">
                                    <label for="logo_description"><?php echo $this->_tpl_vars['LANG']['logo_description']; ?>
</label>
                                </td>
                                    <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('logo_description'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('logo_description'); ?>

                                        <textarea name="logo_description" id="logo_description" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('logo_description'); ?>
</textarea>
                                    </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('logo_url'); ?>
">
                                    <label for="logo_url"><?php echo $this->_tpl_vars['LANG']['logo_url']; ?>
</label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('logo_url'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('logo_url'); ?>

                                    <input type="text" class="clsTextBox" name="logo_url" id="logo_url" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('logo_url'); ?>
" /><p>http://www.example.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('logo_position'); ?>
">
                                    <label for="logo_position"><?php echo $this->_tpl_vars['LANG']['logo_position']; ?>
</label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('logo_position'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('logo_position'); ?>

                                    <select name="logo_position" id="logo_position" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                                   <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->logo_upload_form['logo_position_array'],$this->_tpl_vars['myobj']->getFormField('logo_position')); ?>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('logo_transparency'); ?>
">
                                    <label for="logo_transparency"><?php echo $this->_tpl_vars['LANG']['logo_transparency']; ?>
</label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('logo_transparency'); ?>
">
                                	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('logo_transparency'); ?>

                                    <input type="text" class="clsTextBox" name="logo_transparency" id="logo_transparency" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('logo_transparency'); ?>
" />&nbsp;(<?php echo $this->_tpl_vars['LANG']['recommended']; ?>
 30)
                                </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('logo_rollover_transparency'); ?>
">
                                    <label for="logo_rollover_transparency"><?php echo $this->_tpl_vars['LANG']['logo_rollover_transparency']; ?>
</label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('logo_rollover_transparency'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('logo_rollover_transparency'); ?>

                                    <input type="text" class="clsTextBox" name="logo_rollover_transparency" id="logo_rollover_transparency" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['myobj']->getFormField('logo_rollover_transparency'); ?>
" />&nbsp;(<?php echo $this->_tpl_vars['LANG']['recommended']; ?>
 80)
                                </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('animated_logo'); ?>
">
                                    <label for="animated_logo1"><?php echo $this->_tpl_vars['LANG']['animated_logo']; ?>
</label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('animated_logo'); ?>
">
                                	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('animated_logo'); ?>

                                    <input type="radio" class="clsCheckRadio" name="animated_logo" id="animated_logo1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('animated_logo','yes'); ?>
 />&nbsp;<label for="animated_logo1"><?php echo $this->_tpl_vars['LANG']['yes']; ?>
</label>
                                    <input type="radio" class="clsCheckRadio" name="animated_logo" id="animated_logo2" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="no" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('animated_logo','no'); ?>
 />&nbsp;<label for="animated_logo2"><?php echo $this->_tpl_vars['LANG']['no']; ?>
</label>
                                </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('video_logo_file'); ?>
">
                                    <label for="video_logo_file"><?php echo $this->_tpl_vars['LANG']['logoupload_logo_file']; ?>
&nbsp;[<?php echo $this->_tpl_vars['myobj']->logo_upload_form['implode_logo_format_arr']; ?>
]</label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('video_logo_file'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('video_logo_file'); ?>

                                    <div id="selLeftPlainImage">
                                        <p id="selImageBorder"><span id="selPlainCenterImage"><?php echo $this->_tpl_vars['myobj']->getLogoImage(); ?>
</span></p>
                                    </div>
                                    <input type="file" class="clsFileBox"  name="video_logo_file" id="video_logo_file" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                                (<?php echo $this->_tpl_vars['CFG']['admin']['videos']['logo_max_size']; ?>
&nbsp;KB)
                                </td>
                            </tr>
                            <tr>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormLabelCellClass('main_logo'); ?>
">
                                    <label for="main_logo1"><?php echo $this->_tpl_vars['LANG']['main_logo']; ?>
</label>
                                </td>
                                <td class="<?php echo $this->_tpl_vars['myobj']->getCSSFormFieldCellClass('main_logo'); ?>
">
                                	<?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('main_logo'); ?>

                                    <input type="radio" class="clsCheckRadio" name="main_logo" id="main_logo1" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="yes" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('main_logo','yes'); ?>
 />&nbsp;<label for="main_logo1"><?php echo $this->_tpl_vars['LANG']['on']; ?>
</label>
                                    <input type="radio" class="clsCheckRadio" name="main_logo" id="main_logo2" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="no" <?php echo $this->_tpl_vars['myobj']->isCheckedRadio('main_logo','no'); ?>
 />&nbsp;<label for="main_logo2"><?php echo $this->_tpl_vars['LANG']['off']; ?>
</label>
                               </td>
                            </tr>
                                                       <tr>
                                <td colspan="2" class="clsFormFieldCellDefault">
                                    <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->logo_upload_form['hidden_array']); ?>

                                    <input type="submit" class="clsSubmitButton" name="upload" id="upload" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['upload']; ?>
" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        <?php endif; ?>
	</div>
</div>
<?php /* Smarty version 2.6.18, created on 2012-02-02 01:23:24
         compiled from imageInsertPopUp.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<form action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" id="uploadForm" method="post" enctype="multipart/form-data">
		<div class="clsUploadImage">
        	<div class="clsUploadNotes">
            <p><?php echo $this->_tpl_vars['LANG']['insertimage_image_upload']; ?>
&nbsp;&nbsp;(<?php echo $this->_tpl_vars['LANG']['insertimage_choose_image_to_upload']; ?>
)</p>
                [<?php echo $this->_tpl_vars['LANG']['insertimage_max_file_size']; ?>
:&nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['articles']['image_max_size']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['common_kilobyte']; ?>
]<br/>
                [<?php echo $this->_tpl_vars['LANG']['insertimage_allowed_formats']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->image_format; ?>
]
            </div>
            <div class="actions clsImageFormats">
                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('insertimage'); ?>

                <div class="clsFloatLeft">
                <input id="file-upload" name="insertimage" type="file">
                </div>
                <div class="clsUploadLeft">
                	<div class="clsUploadRight">
	                	<input id="file-upload-submit" value="<?php echo $this->_tpl_vars['LANG']['insertimage_start_upload']; ?>
" type="submit" name="file-upload-submit">
                    </div>
                </div>
                <br/>
                <span id="upload-clear"></span>
                <ul class="upload-queue" id="upload-queue">
                    <li style="display: none;"></li>
                </ul>
            </div>
        </div>
	</form>

<form action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" id="imageForm" method="post" enctype="multipart/form-data">
	<div id="messages" style="display: none;">
		<span id="message"></span><img src="../images/dots.gif" alt="..." width="22" height="12">
	</div>

	<div class="clsUploadIframeImage">
    	<iframe id="imageframe" name="imageframe" src="<?php echo $this->_tpl_vars['myobj']->insert_image_form['image_list_url']; ?>
" class="clsImageFrame"></iframe><br/>
    	<span><?php echo $this->_tpl_vars['LANG']['insertimage_select_image']; ?>
</span>
    </div>
		<table class="properties clsImageProperties">
			<tbody><tr>
				<td><label for="f_url"><?php echo $this->_tpl_vars['LANG']['insertimage_url']; ?>
</label></td>
				<td><input id="f_url" value="" type="text" class="clsTextarea"></td>
				<td><label for="f_align"><?php echo $this->_tpl_vars['LANG']['insertimage_align']; ?>
</label></td>
				<td>
					<select size="1" id="f_align" title="Positioning of this image">
						<option value="" selected="selected"><?php echo $this->_tpl_vars['LANG']['insertimage_align_notset']; ?>
</option>
						<option value="left"><?php echo $this->_tpl_vars['LANG']['insertimage_align_left']; ?>
</option>
						<option value="right"><?php echo $this->_tpl_vars['LANG']['insertimage_align_right']; ?>
</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="f_alt"><?php echo $this->_tpl_vars['LANG']['insertimage_image_desc']; ?>
</label></td>
				<td><input id="f_alt" value="" type="text" class="clsTextarea"></td>
			</tr>
			<tr>
				<td><label for="f_title"><?php echo $this->_tpl_vars['LANG']['insertimage_image_title']; ?>
</label></td>
				<td><input id="f_title" value="" type="text" class="clsTextarea"></td>
				<td><label for="f_caption"><?php echo $this->_tpl_vars['LANG']['insertimage_image_caption']; ?>
</label></td>
				<td><input id="f_caption" type="checkbox"></td>
			</tr>
            <tr>
            	<td>
                </td>
                <td>
                    <button type="button" onClick="ImageManager.onok();" class="clsSubmitButton"><?php echo $this->_tpl_vars['LANG']['insertimage_insert']; ?>
</button>
                    <button type="button" onClick="parent.myLightWindow.deactivate();" class="clsCancelButton"><?php echo $this->_tpl_vars['LANG']['insertimage_cancel']; ?>
</button>
                </td>
            </tr>
		</tbody>
     </table>

	<input id="dirPath" name="dirPath" type="hidden">

	<input id="f_file" name="f_file" type="hidden">
	<input id="tmpl" name="component" type="hidden">
</form>
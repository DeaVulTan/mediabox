{$myobj->setTemplateFolder('general/','article')}
{include file='information.tpl'}
	<form action="{$myobj->getCurrentUrl()}" id="uploadForm" method="post" enctype="multipart/form-data">
		<div class="clsUploadImage">
        	<div class="clsUploadNotes">
            <p>{$LANG.insertimage_image_upload}&nbsp;&nbsp;({$LANG.insertimage_choose_image_to_upload})</p>
                [{$LANG.insertimage_max_file_size}:&nbsp;{$CFG.admin.articles.image_max_size}&nbsp;{$LANG.common_kilobyte}]<br/>
                [{$LANG.insertimage_allowed_formats}:&nbsp;{$myobj->image_format}]
            </div>
            <div class="actions clsImageFormats">
                {$myobj->getFormFieldErrorTip('insertimage')}
                <div class="clsFloatLeft">
                <input id="file-upload" name="insertimage" type="file">
                </div>
                <div class="clsUploadLeft">
                	<div class="clsUploadRight">
	                	<input id="file-upload-submit" value="{$LANG.insertimage_start_upload}" type="submit" name="file-upload-submit">
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

<form action="{$myobj->getCurrentUrl()}" id="imageForm" method="post" enctype="multipart/form-data">
	<div id="messages" style="display: none;">
		<span id="message"></span><img src="../images/dots.gif" alt="..." width="22" height="12">
	</div>

	<div class="clsUploadIframeImage">
    	<iframe id="imageframe" name="imageframe" src="{$myobj->insert_image_form.image_list_url}" class="clsImageFrame"></iframe><br/>
    	<span>{$LANG.insertimage_select_image}</span>
    </div>
		<table class="properties clsImageProperties">
			<tbody><tr>
				<td><label for="f_url">{$LANG.insertimage_url}</label></td>
				<td><input id="f_url" value="" type="text" class="clsTextarea"></td>
				<td><label for="f_align">{$LANG.insertimage_align}</label></td>
				<td>
					<select size="1" id="f_align" title="Positioning of this image">
						<option value="" selected="selected">{$LANG.insertimage_align_notset}</option>
						<option value="left">{$LANG.insertimage_align_left}</option>
						<option value="right">{$LANG.insertimage_align_right}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="f_alt">{$LANG.insertimage_image_desc}</label></td>
				<td><input id="f_alt" value="" type="text" class="clsTextarea"></td>
			</tr>
			<tr>
				<td><label for="f_title">{$LANG.insertimage_image_title}</label></td>
				<td><input id="f_title" value="" type="text" class="clsTextarea"></td>
				<td><label for="f_caption">{$LANG.insertimage_image_caption}</label></td>
				<td><input id="f_caption" type="checkbox"></td>
			</tr>
            <tr>
            	<td>
                </td>
                <td>
                    <button type="button" onClick="ImageManager.onok();" class="clsSubmitButton">{$LANG.insertimage_insert}</button>
                    <button type="button" onClick="parent.myLightWindow.deactivate();" class="clsCancelButton">{$LANG.insertimage_cancel}</button>
                </td>
            </tr>
		</tbody>
     </table>

	<input id="dirPath" name="dirPath" type="hidden">

	<input id="f_file" name="f_file" type="hidden">
	<input id="tmpl" name="component" type="hidden">
</form>
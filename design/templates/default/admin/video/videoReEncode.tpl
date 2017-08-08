<div id="selvideoList">
  	<h2><span>{$LANG.videoRencode_title}</span></h2>
</div>

{$myobj->setTemplateFolder('admin/')}
{include file="information.tpl}
{if $myobj->isShowPageBlock('show_command')}
 <div id="selActivationConfirm">
 	<form id="videoReEncodeFrm" name="videoReEncodeFrm" action="{$myobj->getCurrentUrl()}" method="post">
		<input type="hidden" name="video_id" id="video_id" value="{$myobj->video_id}">
		<table summary="{$LANG.videoRencode_tbl_summary}" class="clsNoBorder" width="90%">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('mencoder_path')}">
					<label for="list">{$LANG.mencoder_path}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('mencoder_path')}">
					{$myobj->getFormField('mencoder_path')}
					<input type="hidden" name="mencoder_path" id="mencoder_path" tabindex="{smartyTabIndex}"  value='{$myobj->getFormField('mencoder_path')}'>
				</td>
            </tr>
            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('input_video')}">
					<label for="list">{$LANG.input_video}</label> <span class="clsMandatoryFieldIcon">*</span>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('input_video')}">
					<textarea name='input_video' id='input_video' tabindex="{smartyTabIndex}"
                    onKeyUp="showOut()">{$myobj->getFormField('input_video')}</textarea>
                    <div><!-- -->
                    	{$myobj->getFormFieldErrorTip('input_video')}
                    </div>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('encode_hide_1')}">
					<label for="list">{$LANG.encode_hide_1}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('encode_hide_1')}">
					{$myobj->getFormField('encode_hide_1')}
					<input type="hidden" name="encode_hide_1" id="encode_hide_1" value="{$myobj->getFormField('encode_hide_1')}">
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('output_video')}">
					<label for="list">{$LANG.output_video}</label> <span class="clsMandatoryFieldIcon">*</span>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('output_video')}">
					<textarea name='output_video' id='output_video' tabindex="{smartyTabIndex}"
                	onKeyUp="showOut()">{$myobj->getFormField('output_video')}</textarea>
                    <div><!-- -->
                    	{$myobj->getFormFieldErrorTip('output_video')}
                    </div>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('extra_command')}">
					<label for="list">{$LANG.extra_command}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('extra_command')}">
					<textarea name='extra_command' id='extra_command' tabindex="{smartyTabIndex}"
                    onKeyUp="showOut()">{$myobj->getFormField('extra_command')}</textarea>
				<br>
					{$LANG.extra_command_description}
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('encode_hide_2')}">
					<label for="list">{$LANG.encode_hide_2}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('encode_hide_2')}">
					{$myobj->getFormField('encode_hide_2')}
					<input type="hidden" name="encode_hide_2" id="encode_hide_2" value="{$myobj->getFormField('encode_hide_2')}">
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('audio_codec')}">
					<label for="list">{$LANG.audio_codec}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('audio_codec')}">{$myobj->getFormFieldErrorTip('audio_codec')}
					<input type="text" name="audio_codec" id="audio_codec" tabindex="{smartyTabIndex}" onKeyUp="showOut()"
                    value="{$myobj->getFormField('audio_codec')}" size=50/>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('encode_hide_3')}">
					<label for="list">{$LANG.encode_hide_3}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('encode_hide_3')}">
					{$myobj->getFormField('encode_hide_3')}
					<input type="hidden" name="encode_hide_3" id="encode_hide_3" value="{$myobj->getFormField('encode_hide_3')}">
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('vbitrate')}">
					<label for="list">{$LANG.vbitrate}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('vbitrate')}">{$myobj->getFormFieldErrorTip('vbitrate')}
					<input type="text" name="vbitrate" id="vbitrate" tabindex="{smartyTabIndex}" onKeyUp="showOut()"
                    value="{$myobj->getFormField('vbitrate')}" size=50/>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('encode_hide_4')}">
					<label for="list">{$LANG.encode_hide_4}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('encode_hide_4')}">
					{$myobj->getFormField('encode_hide_4')}
					<input type="hidden" name="encode_hide_4" id="encode_hide_4" value="{$myobj->getFormField('encode_hide_4')}">
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('vfscale')}">
					<label for="list">{$LANG.vfscale}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('vfscale')}">{$myobj->getFormFieldErrorTip('vfscale')}
					<input type="text" name="vfscale" id="vfscale" tabindex="{smartyTabIndex}" onKeyUp="showOut()"
                    value="{$myobj->getFormField('vfscale')}" size=50/>
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('encode_hide_5')}">
					<label for="list">{$LANG.encode_hide_5}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('encode_hide_5')}">
					{$myobj->getFormField('encode_hide_5')}
					<input type="hidden" name="encode_hide_5" id="encode_hide_5" value="{$myobj->getFormField('encode_hide_5')}">
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('srate')}">
					<label for="list">{$LANG.srate}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('srate')}">{$myobj->getFormFieldErrorTip('srate')}
					<input type="text" name="srate" id="srate" tabindex="{smartyTabIndex}" onKeyUp="showOut()" value="{$myobj->getFormField('srate')}"
                    size=50/>
				</td>
			</tr>
				<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('encode_hide_6')}">
					<label for="list">{$LANG.encode_hide_6}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('encode_hide_6')}">
					{$myobj->getFormField('encode_hide_6')}
					<input type="hidden" name="encode_hide_6" id="encode_hide_6" value="{$myobj->getFormField('encode_hide_6')}">
				</td>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('lavcresample')}">
					<label for="list">{$LANG.lavcresample}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('lavcresample')}">{$myobj->getFormFieldErrorTip('lavcresample')}
					<input type="text" name="lavcresample" id="lavcresample" tabindex="{smartyTabIndex}" onKeyUp="showOut()"
                    value="{$myobj->getFormField('lavcresample')}" size=50/>
				</td>
			</tr>
				<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('strBframes')}">
					<label for="list">{$LANG.strBframes}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('strBframes')}">
					{$myobj->getFormField('strBframes')}
					<input type="hidden" name="strBframes" id="strBframes" value="{$myobj->getFormField('strBframes')}">
				</td>
			</tr>
			</tr>
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('add_to_cron')}">
					<label for="list">{$LANG.add_to_cron}</label>
				</td>
				<td class="{$myobj->getCSSFormFieldCellClass('add_to_cron')}">
					<input type="radio" name="add_to_cron" id="add_to_cron" value="Yes" {if $myobj->getFormField('add_to_cron')=='Yes'} checked {/if} >
                    {$LANG.yes} &nbsp;
					<input type="radio" name="add_to_cron" id="add_to_cron" value="No" {if $myobj->getFormField('add_to_cron')=='No'} checked {/if}>{$LANG.no}
				</td>
			</tr>
			<tr>
				<td id='outdisplay' colspan="2"></td>
			</tr>
			<tr>
				<td colspan='2'>
                <input type="submit" class="clsSubmitButton" name="submit" id="submit" value="{$LANG.submit}" tabindex="{smartyTabIndex}" />&nbsp;</td>
			</tr>
		</table>
		<script type="text/javascript">
		showOut();
		</script>
	 </form>
</div>
{/if}

{if $myobj->isShowPageBlock('show_output')}
<h2>{$LANG.show_output_title}</h2>
<div>{$myobj->output}</div>
{/if}


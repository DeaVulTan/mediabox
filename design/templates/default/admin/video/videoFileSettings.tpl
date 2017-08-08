<h2>{$LANG.videofile_setting_title}</h2>

{$myobj->setTemplateFolder('admin/')} {include file="information.tpl"}
{if $myobj->isShowPageBlock('block_video_file_settings')}
<h3>{$LANG.videofile_setting_info_mesage}</h3>
<form id="video_file_settings" method="post" name="video_file_settings" action="{$myobj->getCurrentUrl()}">
<table class="clsNoBorder">
<tr>
	<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('video_thumb_name')}"><label for="video_thumb_name">{$LANG.videofile_setting_thumb_name}</label></td>
    <td class="{$myobj->getCSSFormFieldCellClass('video_thumb_name')}">{$myobj->getFormFieldErrorTip('video_thumb_name')}<input type="text" class="clsTextBox" name="video_thumb_name" id="video_thumb_name" value="{$myobj->getFormField('video_thumb_name')}"></td>
</tr>
<tr>
	<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('video_file_name')}"><label for="video_file_name">{$LANG.videofile_setting_video_name}</label></td>
    <td class="{$myobj->getCSSFormFieldCellClass('video_file_name')}">{$myobj->getFormFieldErrorTip('video_file_name')}<input type="text" class="clsTextBox" name="video_file_name" id="video_file_name" value="{$myobj->getFormField('video_file_name')}"></td>
</tr>
<tr>
	<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('trimed_video_name')}"><label for="trimed_video_name">{$LANG.videofile_setting_trimed_video_name}</label></td>
    <td class="{$myobj->getCSSFormFieldCellClass('trimed_video_name')}">{$myobj->getFormFieldErrorTip('trimed_video_name')}<input type="text" class="clsTextBox" name="trimed_video_name" id="trimed_video_name" value="{$myobj->getFormField('trimed_video_name')}"></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" class="clsSubmitButton" name="update_file_settings" value="{$LANG.videofile_setting_update}" />

    </td>

</tr>
</table>
</form>
{/if}

<h2>{$LANG.musicfile_setting_title}</h2>
{$myobj->setTemplateFolder('admin')}
{include file="information.tpl"}
{if $myobj->isShowPageBlock('block_music_file_settings')}
	<form id="music_file_settings" method="post" name="music_file_settings" action="{$myobj->getCurrentUrl()}">
		<table class="clsNoBorder">
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('music_thumb_name')}"><label for="music_thumb_name">{$LANG.musicfile_setting_thumb_name}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_thumb_name')}">{$myobj->getFormFieldErrorTip('music_thumb_name')}<input type="text" class="clsTextBox" name="music_thumb_name" id="music_thumb_name" value="{$myobj->getFormField('music_thumb_name')}"></td>
			</tr>
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('music_file_name')}"><label for="music_file_name">{$LANG.musicfile_setting_music_name}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('music_file_name')}">{$myobj->getFormFieldErrorTip('music_file_name')}<input type="text" class="clsTextBox" name="music_file_name" id="music_file_name" value="{$myobj->getFormField('music_file_name')}"></td>
			</tr>
			<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('trimed_music_name')}"><label for="trimed_music_name">{$LANG.musicfile_setting_trimed_music_name}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('trimed_music_name')}">{$myobj->getFormFieldErrorTip('trimed_music_name')}<input type="text" class="clsTextBox" name="trimed_music_name" id="trimed_music_name" value="{$myobj->getFormField('trimed_music_name')}"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="clsSubmitButton" name="update_file_settings" value="{$LANG.musicfile_setting_update}" /></td>    
			</tr>
		</table>
	</form>
{/if}

<div id="selCreateAlbum">
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selCreateAlbum', 'selMsgConfirm')
</script>

{$myobj->setTemplateFolder('general/','music')}
{include file='information.tpl'}
<div id="errorTips" style="display:none" class="clsErrorMessage">
        </div>
{if $myobj->isShowPageBlock('form_create_album')}
<form name="selFormCreateAlbum" id="selFormCreateAlbum"  method="post" action="" autocomplete="off">
<input type="hidden" name="album_access_type" id="album_access_type" value="Private" />
    <table class="clsCreateAlbumPopup clsStepsTable">
    	<tr>
        	<td class="{$myobj->getCSSFormLabelCellClass('album_title')}">
            <label for="album_title">{$LANG.createalbum_music_album}</label>
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('album_title')}">
            <input type="text" class="clsTextBox" name="album_title" id="album_title" value="{$myobj->getFormField('album_title')}" tabindex="{smartyTabIndex}" />   
            {$myobj->getFormFieldErrorTip('album_title')}          
            </td>
        </tr>
        {if $CFG.admin.musics.allowed_usertypes_to_upload_for_sale != 'None'}
        <tr>
        	<td class="{$myobj->getCSSFormLabelCellClass('album_for_sale')}">
            <label for="album_for_sale">{$LANG.createalbum_album_for_sale}</label>
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('album_for_sale')}">
            <input type="radio" class="clsCheckRadio" name="album_for_sale" onclick="enabledFormFields(Array('album_price'))" id="album_for_sale_1" value="Yes" tabindex="{smartyTabIndex}" 
                        {$myobj->isCheckedRadio('album_for_sale','Yes')} />&nbsp;<label for="for_sale1">{$LANG.createalbum_yes}
                        </label>
                        <input type="radio" class="clsCheckRadio" name="album_for_sale" id="album_for_sale_2" value="No" onclick="disabledFormFields(Array('album_price'))" tabindex="{smartyTabIndex}" 
                        {$myobj->isCheckedRadio('album_for_sale','No')} />&nbsp;<label for="for_sale2">{$LANG.createalbum_no}</label>
            </td>
        </tr>
       	<tr>
        	<td class="{$myobj->getCSSFormLabelCellClass('album_price')}">
            <label for="album_title">{$LANG.createalbum_music_album_price}</label>({$CFG.currency})
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('album_price')}">
            <input type="text" class="clsTextBox" name="album_price" id="album_price" value="{$myobj->getFormField('album_price')}" tabindex="{smartyTabIndex}" />
            {$myobj->getFormFieldErrorTip('album_price')}    
            </td>
        </tr>
        {/if}
        <tr>
        	<td colspan="2" style="text-align:center;">
            	<input type="button" class="clsSubmitButton" name="send" id="send" value="{$LANG.createalbum_save}" tabindex="{smartyTabIndex}" {if isAjaxPage()} onclick="if(valid.form())return saveAjaxAlbum('{$myobj->getUrl('createalbum','?ajax_page=true&page=save','?ajax_page=true&page=save','members','music')}')" {/if}/>
            </td>
        </tr>
    </table>
</form>
{literal}
<script type="text/javascript">
var valid = $Jq('#selFormCreateAlbum').validate({
	rules: {
		album_title: {
			required: true
		}
	}
});
</script>
{/literal}
{/if} 
</div>
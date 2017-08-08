<script language="javascript" type="text/javascript" src=cfg_site_url+"js/functions.js"></script>
<div id="selCreateAlbum1">
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
	<div class="clsPageHeading"><h2>{if $myobj->getFormField('video_album_id') == '' }{$LANG.createalbum_create_album} {else} {$LANG.createalbum_update_album}{/if}</h2></div>
  	{include file='../general/information.tpl'}
	<div id="selLeftNavigation">
		{if $myobj->isShowPageBlock('create_album_form')}

            <div id="selAlbum" class="clsDataTable">
				<form name="create_album_form" id="create_album_form" method="post" action="{$myobj->form_album_create.form_action}" autocomplete="off">
			    	<div id="selUploadBlock">
                    <table summary="{$LANG.createalbum_tbl_summary}" class="clsCreateAlbumTable">
			    		<tr>
			         		<td class="{$myobj->getCSSFormLabelCellClass('album_title')}">
								<label for="album_title">{$LANG.createalbum_field_length_lbl}{$myobj->displayCompulsoryIcon()}</label>
							</td>
			          		<td class="{$myobj->getCSSFormFieldCellClass('album_title')}">{$myobj->getFormFieldErrorTip('album_title')}
								<input type="text" class="clsTextBox" name="album_title" id="album_title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('album_title')}" maxlength="{$CFG.admin.musics.title_length}" />{$myobj->ShowHelpTip('album_title')}
							</td>
			        	</tr>
						<tr>
			         		<td class="{$myobj->getCSSFormLabelCellClass('album_description')}">
								<label for="album_description">{$LANG.createalbum_album_description}{$myobj->displayCompulsoryIcon()}</label>
							</td>
			          		<td class="{$myobj->getCSSFormFieldCellClass('album_description')}">{$myobj->getFormFieldErrorTip('album_description')}
								<textarea name="album_description" id="album_description" tabindex="{smartyTabIndex}">{$myobj->getFormField('album_description')}</textarea>{$myobj->ShowHelpTip('album_description')}
							</td>
			        	</tr>
						<!--<tr>
			         		<td class="{$myobj->getCSSFormLabelCellClass('album_access_type')}">
								<label for="album_access_type">{$LANG.createalbum_album_access_type}</label>
							</td>
			          		<td class="{$myobj->getCSSFormFieldCellClass('album_access_type')}">{$myobj->getFormFieldErrorTip('album_access_type')}
								<p><input type="radio" class="clsCheckRadio" name="album_access_type" id="album_access_type1" value="Public" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('album_access_type','Public')} />&nbsp;<label for="album_access_type1">{$LANG.createalbum_public}</label></p>
								<p><input type="radio" class="clsCheckRadio" name="album_access_type" id="album_access_type2" value="Private" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('album_access_type','Private')} />&nbsp;<label for="album_access_type2">{$LANG.createalbum_private}</label></p>
								<p class="clsSelectHighlightNote">{$LANG.createalbum_only_viewable_you_email}</p>
								<p>{$myobj->populateCheckBoxForRelationList()}</p>{$myobj->ShowHelpTip('album_access_type')}
							</td>
			        	</tr>-->
						<tr>
                        	<td></td>
							<td class="clsCreateAlbumVideo">
                            	<input type="hidden" name="album_access_type" id="album_access_type" value="Public"/>
                                <input type="hidden" name="video_album_id" id="video_album_id" value="{$myobj->getFormField('video_album_id')}"/>
								{$myobj->populateHidden($myobj->form_album_create.form_hidden_value)}
								<div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="create_album" id="create_album" tabindex="{smartyTabIndex}" value="{if $myobj->getFormField('video_album_id') == '' }{$LANG.createalbum_create_album} {else} {$LANG.createalbum_update_album}{/if}" /></div></div>
								<div class="clsCancelMargin"><div class="clsCancelLeft"><div class="clsCancelRight"><input type="button" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.createalbum_cancel}" onClick="clearValue()"/></div></div></div>
							</td>
						</tr>
					</table>
                    </div>
				</form>
			</div>
            </div>
		{/if}
	</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
</div>

{if $myobj->form_album_create.popup_value != '0'}
<script language="javascript" type="text/javascript" src=src=cfg_site_url+"js/functions.js"></script>
<script language="javascript" type="text/javascript">
setFullScreenBrowser();
</script>
{/if}
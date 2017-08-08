{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div class="clsPageHeading">
<h2>{$LANG.upload_background_pg_title}</h2>
</div>
<p>{$LANG.upload_background_descritption}</p>
{$myobj->setTemplateFolder('general/')}
{include file=information.tpl}
<!-- confirmation box start-->
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;position:absolute;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
						<input type="hidden" name="action" id="action" value="delete" />
					</td>
				</tr>
			</table>
		</form>
	</div>
<!-- End -->
<form name="manageBackgroundFrm" id="manageBackgroundFrm" action="{$myobj->getCurrentUrl(false)}" method="post" enctype="multipart/form-data">
   <p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
    <div class="clsDataTable">
        <table summary="{$LANG.tbl_summary}" class="clsManageBackgroundImage">
        <tr>
        	<td colspan="2">
                {if $myobj->isShowPageBlock('block_image_display') }
                    <div class="clsOverflow">
                        <p class="clsViewThumbImage"><span><img src="{$myobj->background_path}" alt="{$LANG.videobackground_alttag}"{if $myobj->image_width > 250} width="250"{/if}></span></p>
                    </div>
                    <div class="clsDeleteBackground">
                    	<a href="javascript:void(0)"  onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('confirmMessage'), Array('{$LANG.manageBackground_deleted_confirm_message}'), Array('innerHTML'));">{$LANG.managebackground_delete_background}</a>
                    </div>
                {/if}
            </td>
        </tr>
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('background_image')} clsManageBackgroundLabel">{$LANG.upload_background_image_title} ({$myobj->imageFormat}) {$myobj->displayCompulsoryIcon()}</td>
            <td class="{$myobj->getCSSFormFieldCellClass('background_image')}">
            <input type="file" class="clsFileBox""  name="background_image" id="background_image" />
            <div><!-- -->
            {$myobj->getFormFieldErrorTip('background_image')}
            </div>
            {$myobj->ShowHelpTip('background_image')}
            </td>
        </tr>
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('background_offset')}"><label for="background_offset">{$LANG.managebackground_backgroundoffset} <a onclick="showImageTip()" title="{$LANG.playerOffset_tooltip}">{$LANG.videobackground_help}</a></label>{$myobj->displayCompulsoryIcon()}

            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('background_offset')}" >{$myobj->getFormFieldErrorTip('background_offset')}<input type="text"  name="background_offset" id="background_offset" value="{$myobj->getFormField('background_offset')}">{$myobj->ShowHelpTip('background_offset')}

            </td>
        </tr>
        <tr>
        	<td></td>
            <td ><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name ="uploadBackground" value="{$LANG.upload_background_image}" tabindex="{smartyTabIndex}" ></div></div>
            <div class="clsCancelLeft"><div class="clsCancelRight"><input id="cancel" type="button" onclick="window.location='{php} echo getUrl('videolist','?pg=videonew','videonew/','','video'){/php}'" tabindex="{smartyTabIndex}" value="{$LANG.cancel_button}"/></div></div>

            </td>
        </tr>
        </table>
        <table>
        <tr>
        <td>
         <div id="imageTip" style="display:none;margin-top:10px;" ><div class="clsCloseOffsetImage">
            <div value="close" onclick="showImageTip()" title="Close" class="clsCloseWindow"></div>
            <img src="{$CFG.site.video_url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/playeroffset.jpg" /></div>
            </div>
        </td> </tr>
        </table>
    </div>
</form>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}

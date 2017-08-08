{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}

<div class="clsPageHeading">
	<h2>{$LANG.profilebackground_pg_title}</h2>
</div>

{$myobj->setTemplateFolder('general/')}
{include file=information.tpl}

<p class="clsNoteMessange"><span>{$LANG.profilebackground_note}</span>:&nbsp;{$LANG.profilebackground_description}</p>

<!-- confirmation box start-->
<div id="selMsgConfirm" style="display:none;">
	<p id="confirmMessage"></p>
	<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
		<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_confirm}" />
		&nbsp;
		<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}"  onClick="return hideAllBlocks('selFormForums');" />
		<input type="hidden" name="action" id="action" value="delete" />
	</form>
	</div>
<!-- End -->
<form action="{$myobj->getCurrentUrl(false)}" id="selFormEditProfileBackground" name="selFormEditProfileBackground"  method="post" enctype="multipart/form-data">
    <div class="clsDataTable">
        <table summary="{$LANG.profilebackground_tbl_summary}">
      <tr>
            <td class="{$myobj->getCSSFormLabelCellClass(profile_background_color)}"><label>{$LANG.profilebackground_color_title}</label></td>
            <td>
                  <input type="color" text="hidden" name="profile_background_color" id="profile_background_color" value="{$myobj->getFormField('profile_background_color')}" class="color" />
				  {* <div class="clsPick text" onclick="pickColour(this)" title="Pick color" style="background-color:{$myobj->getFormField('profile_background_color')}">
                        <span class="pick">{$LANG.profilebackground_pick}<input type="hidden" name="profile_background_color" id="profile_background_color" value="{$myobj->getFormField('profile_background_color')}"></span>
                  </div> *}
            </td>
      </tr>
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('profile_background_image')} clsManageBackgroundLabel"><label for="profile_background_image">{$LANG.profilebackground_image_title}</label></td>
            <td class="{$myobj->getCSSFormFieldCellClass('profile_background_image')}">
            <input type="file" class="clsFileBox" name="profile_background_image" id="profile_background_image" />
            <p>[{$LANG.profilebackground_image_allowed}:&nbsp;{$myobj->imageFormat}]</p>
            <p>[{$LANG.profilebackground_maxsize}:&nbsp;{$CFG.profile.background_image_max_size}&nbsp;KB]</p>
            <div><!-- -->
            {$myobj->getFormFieldErrorTip('profile_background_image')}
            </div>
            {$myobj->ShowHelpTip('profile_background_image')}
            </td>
        </tr>

        <tr>
        	<td><!-- --></td>
        	<td>
                {if $myobj->isShowPageBlock('block_image_display') }
                    <div class="clsOverflow">
                        <p class="clsViewThumbImage"><span><img src="{$myobj->background_path}" alt="{$LANG.profilebackground_alttag}"{if $myobj->image_width > 250} width="250"{/if}></span></p>
                    </div>
                    <div class="clsDeleteBackground">
                    	<a href="javascript:void(0)" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('confirmMessage'), Array('{$LANG.profilebackground_deleted_confirm_message}'), Array('innerHTML'));">{$LANG.profilebackground_delete_background}</a>
                    </div>
                {/if}
            </td>
        </tr>
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('profile_background_offset')}"><label for="profile_background_offset">{$LANG.profilebackground_backgroundoffset}&nbsp;<a onclick="showImageTip()" title="{$LANG.profilebackground_offset_tooltip}">{$LANG.profilebackground_help}</a></label>

            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('background_offset')}" >
            	<input type="text"  name="profile_background_offset" id="profile_background_offset" value="{$myobj->getFormField('profile_background_offset')}" onfocus="hideImageTip()">
                  {$myobj->getFormFieldErrorTip('profile_background_offset')}
                  {$myobj->ShowHelpTip('profile_background_offset')}
            </td>
        </tr>
	 <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('profile_background_repeat')}"><label>{$LANG.profilebackground_repeat}</label>

            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('profile_background_repeat')}" >
            	<input type="radio" class="clsCheckRadio" name="profile_background_repeat" id="profile_background_repeat" value="Yes" {$myobj->isCheckedRadio('profile_background_repeat', 'Yes')}  tabindex="{smartyTabIndex}" />
            	<label for="profile_background_repeat">{$LANG.common_yes_option}</label>
            	<input type="radio" class="clsCheckRadio" name="profile_background_repeat" id="profile_background_repeat_opt_no" value="No" {$myobj->isCheckedRadio('profile_background_repeat', 'No')} tabindex="{smartyTabIndex}"/>
            	<label for="profile_background_repeat_opt_no">{$LANG.common_no_option}</label>
                {$myobj->ShowHelpTip('profile_background_repeat')}
            </td>
        </tr>
        <tr>
        	<td></td>
            <td ><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name="uploadBackground" value="{$LANG.profilebackground_submit}"></div></div>
                 <div class="clsCancelMargin">
				   <div class="clsCancelLeft">
				     <div class="clsCancelRight">
					    <a id="cancel_layout" onclick="Redirect2URL('{$myobj->getUrl('myprofile','','','members')}')">{$LANG.common_cancel}</a>
					 </div>
				   </div>
				 </div>
            </td>
        </tr>
        </table>
        <table>
        <tr>
        <td>
         <div id="imageTip" style="display:none;">
		   <div class="clsCloseOffsetImage">
		    <div class="clsOffsetHeader clsOverflow"><span>{$LANG.common_my_profile_offset}</span> <a onclick="showImageTip()" title="{$LANG.common_close}" class="clsCloseWindow"></a></div>
            <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/profileoffset.jpg" /></div>
            </div>
        </td> </tr>
        </table>
    </div>
</form>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}

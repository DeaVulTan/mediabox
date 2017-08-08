{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_top'}

<div class="clsPageHeading">
	<h2>{$LANG.manageblog_title}</h2>
</div>

{$myobj->setTemplateFolder('general/','blog')}
{include file=information.tpl}

<!-- confirmation box start-->
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.manageblog_tbl_summary}">
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
<p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1}<span class="clsMandatoryFieldIconInText">*</span>{$LANG.common_mandatory_hint_2}</p>
<!-- End -->
<form name="manageBlogFrm" id="manageBlogFrm" action="{$myobj->getCurrentUrl(false)}" method="post" enctype="multipart/form-data">
    <div class="clsDataTable">
        <table summary="{$LANG.manageblog_tbl_summary}">
         <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('blog_name')}">
               <label for="blog_name">{$myobj->manageblog_blog_name_lang}</label>
			   {$myobj->displayCompulsoryIcon()}
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('blog_title')}" >
            	<input type="text" class="clsTextBox" name="blog_name" id="blog_name" value="{$myobj->getFormField('blog_name')}" tabindex="{smartyTabIndex}" maxlength="{$CFG.fieldsize.blog_name.max}" />
                {$myobj->getFormFieldErrorTip('blog_name')}
                {$myobj->ShowHelpTip('blog_name')}
            </td>
        </tr>
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('blog_title')}">
               <label for="blog_title">{$LANG.manageblog_blog_title}</label>
	       {$myobj->displayCompulsoryIcon()}
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('blog_title')}" >
            	<input type="text" class="clsTextBox" name="blog_title" id="blog_title" value="{$myobj->getFormField('blog_title')}" tabindex="{smartyTabIndex}" maxlength="{$CFG.fieldsize.blog_slogan.max}" />
                {$myobj->getFormFieldErrorTip('blog_title')}
                {$myobj->ShowHelpTip('blog_title')}
            </td>
        </tr>
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('blog_slogan')}">
               <label for="blog_slogan">{$LANG.manageblog_blog_slogan}</label>
            </td>
            <td class="{$myobj->getCSSFormFieldCellClass('blog_slogan')}" >
            	<input type="text" class="clsTextBox" name="blog_slogan" id="blog_slogan" value="{$myobj->getFormField('blog_slogan')}" tabindex="{smartyTabIndex}" />
                {$myobj->getFormFieldErrorTip('blog_slogan')}
                {$myobj->ShowHelpTip('blog_slogan')}
            </td>
        </tr>
        <tr>
            <td class="{$myobj->getCSSFormLabelCellClass('blog_logo_image')} clsManageBackgroundLabel"><label for="blog_logo_image">{$LANG.manageblog_blog_logo}</label></td>
            <td class="{$myobj->getCSSFormFieldCellClass('blog_logo_image')}">
            <input type="file" class="clsFileBox" name="blog_logo_image" id="blog_logo_image" tabindex="{smartyTabIndex}" />
            <p>[{$LANG.manageblog_image_allowed}:&nbsp;{$myobj->imageFormat}]</p>
            <p>[{$LANG.manageblog_maxsize}:&nbsp;{$CFG.admin.blog.logo_max_size}&nbsp;KB]</p>
            <div><!-- -->
            {$myobj->getFormFieldErrorTip('blog_logo_image')}
            </div>
            {$myobj->ShowHelpTip('blog_logo_image')}
            </td>
        </tr>
        <tr>
        	<td><!-- --></td>
        	<td>
                {if $myobj->isShowPageBlock('block_logo_image_display') }
                    <div class="clsOverflow">
                        <p class="clsViewThumbImage"><span><img src="{$myobj->logo_image_path}" alt="{$LANG.manageblog_logo_alttag}"></span></p>
                    </div>
                    <div class="clsDeleteBackground">
                    	<a href="javascript:void(0)" onclick="Confirmation('selMsgConfirm', 'msgConfirmform', Array('confirmMessage'), Array('{$LANG.manageblog_delete_confirmation}'), Array('innerHTML'));">{$LANG.manageblog_delete_logo_image}</a>
                    </div>
                {/if}
            </td>
        </tr>
        <tr>
        	<td></td>
            <td ><div class="clsSubmitLeft"><div class="clsSubmitRight">
            {if !$myobj->blogadded}
            <input type="submit" name="addBlog" value="{$LANG.manageblog_submit}" tabindex="{smartyTabIndex}">
            {else}
            <input type="submit" name="updateBlog" value="{$LANG.manageblog_update}" tabindex="{smartyTabIndex}">
            {/if}
            </div></div>
                 <div class="clsCancelMargin">
					 <div class="clsCancelLeft">
						 <div class="clsCancelRight">
						 	<input type="button" name="cancelBlogMangage" value="{$LANG.common_cancel}" onclick="cancelRedirect()" tabindex="{smartyTabIndex}">
						 </div>
					 </div>
				 </div>
	         </td>
        </tr>
        </table>
    </div>
</form>
{$myobj->setTemplateFolder('general/','blog')}
{include file='box.tpl' opt='display_bottom'}

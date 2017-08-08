{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_top"}
<div id="selViewArticle" class="clsPageHeading">
	<h2><span>{$LANG.manageAttachments_title}&nbsp;-&nbsp;<a href="{$myobj->view_article_url}">{$myobj->getFormField('article_title')}</a></span></h2>
    <div id="selLeftNavigation">
    {$myobj->setTemplateFolder('general/','article')}
  	{include file='information.tpl'}
    {if $myobj->isShowPageBlock('article_attachments')}
    	<div id="selViewArticleFrm" class="clsAttachments">
	    	{if $myobj->getFormField('article_attachment')}
            	<table summary="{$LANG.manageAttachments_tbl_summary}" id="selArticleTable">
                	<tr>
                    	<td class="clsAttachmentArticle">
                        	<h3>{$LANG.manageAttachments_attachments}</h3>
                            <div id="attachments">
                            	{foreach key=gadKey item=gadValue from=$getAttachmentDetails.row}
                                	<p>{$gadValue.sno}. {$gadValue.record.file_name}&nbsp;{if $CFG.admin.articles.allow_edit_article_attachment}-&nbsp;<a href="{$gadValue.delete_url}">{$LANG.manageAttachments_delete}</a>{/if}</p>
                                {/foreach}
                            </div>
                        </td>
                   	</tr>
                </table>
                {if $CFG.admin.navigation.bottom}
    				{$myobj->setTemplateFolder('general/','article')}
                    {include file='pagination.tpl'}
                {/if}
           {else}
		   		<h3>{$LANG.manageAttachments_no_atachments}</h3>
           {/if}
       	</div>
    {/if}

    {if $myobj->isShowPageBlock('add_article_attachments')}
    	<div class="clsAddAttatchments">
        	<h3>{$LANG.manageAttachments_add_attachments}</h3>
            {if $myobj->getFormField('article_attachment') < $CFG.admin.articles.article_total_attachments}
            	<form name="manage_attachments_form" id="manage_attachments_form" method="post" action="{$myobj->add_article_attachments.form_action}" enctype="multipart/form-data" autocomplete="off">
                	<table summary="{$LANG.manageAttachments_tbl_summary}" id="selWritingTbl" class="clsRichTextTable clsFormTableSection clsWritingBlock">
                    	<tr>
                        	<td class="{$myobj->getCSSFormLabelCellClass('article_file')}">
                        		{if $CFG.admin.articles.article_attachment_compulsory}{$myobj->displayCompulsoryIcon()}{/if}
                            	<label for="article_file">{$LANG.manageAttachments_attachment}</label>
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('article_file')}">
                            	<input type="file" class="clsFileBox" accept="image/{$myobj->changeArrayToCommaSeparator($CFG.admin.articles.attachment_format_arr)}" name="article_file" id="article_file" tabindex="{smartyTabIndex}" /><br/>
                            	<label class="clsBold">{$LANG.manageAttachments_attachment_max_filesize}</label>&nbsp;{$CFG.admin.articles.attachment_max_size}&nbsp;{$LANG.common_kilobyte}<br />
								<label class="clsBold">{$LANG.manageAttachments_attachment_allowed_formats}</label>&nbsp;{$myobj->changeArrayToCommaSeparator($CFG.admin.articles.attachment_format_arr)}
								{$myobj->getFormFieldErrorTip('article_file')}
                                {$myobj->ShowHelpTip('article_attachment', 'article_file')}
                            </td>
                         </tr>
                         <tr id="selDateLocationRow">
                         	<td>&nbsp;</td>
							<td class="clsFormFieldCellDefault">
                            	<input type="submit" class="clsSubmitButton" name="submit_attachment" id="submit_attachment" tabindex="{smartyTabIndex}" value="{$LANG.manageAttachments_submit}" />
                            </td>
                          </tr>
                    </table>
                </form>
            {else}
                <p>{$LANG.manageAttachments_attachment_maximum}</p>
            {/if}
        </div>
    {/if}
</div>
</div>
{$myobj->setTemplateFolder('general/','article')}
{include file="box.tpl" opt="display_bottom"}
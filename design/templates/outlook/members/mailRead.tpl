{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div class="clsMessageDisplay">
  <div class="clsPageHeading"><h2>{$LANG.mailread_page_title}</h2></div>

{if $myobj->isShowPageBlock('block_form_show_message')}
	<!-- Confirmation Div -->
	<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
	  <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
		<p id="confirmMessage"></p>
			<!-- clsFormSection - starts here -->
		<div class="clsFormSection">
		 <div class="clsFormRow">
			<div class="clsFormLabelCellDefault">
			  <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="{$LANG.common_confirm}" tabindex="{smartyTabIndex}" />
			  &nbsp;
			  <input type="button" class="clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
			  <input type="hidden" name="action" />
			</div>
		  </div>
		</div>
		<!-- clsFormSection - ends here -->
	  </form>
	</div>
{/if}

  {include file='../general/information.tpl'}
  {$myobj->setTemplateFolder('members/')}
  {if $myobj->isShowPageBlock('block_form_show_message')}
  {include file='mail_message_header.tpl'}
  <div class="clsDataTable">
  <table>
  			 <tr>
             		{if $myobj->getFormField('folder') ne 'sent'}
                  <th class="clsFromTitle">{$LANG.mailread_from}</th>
                   {else}
                   <th class="clsFromTitle">{$LANG.mailread_to}</th>
                   {/if}
                  <th>{$LANG.mailread_message}</th>
               </tr>
          <tr>
            <td id="selPhotoGallery" class="clsMailMemberWidth">
             	<div class="clsOverflow"><p class="clsViewThumbImage"><a href="{$mail_details_arr.user_profiles_link}" class="ClsImageContainer ClsImageBorder2 Cls45x45">
                   <img src="{$mail_details_arr.user_profiles_icon.s_url}" alt="{$mail_details_arr.user_name|truncate:4}" title="{$mail_details_arr.user_name}" {$myobj->DISP_IMAGE(45, 45, $mail_details_arr.user_profiles_icon.s_width, $mail_details_arr.user_profiles_icon.s_height)} />
                 </a></p></div>
                 <p class="clsMailUserLink">
                <a href="{$mail_details_arr.user_profiles_link}">
                {$mail_details_arr.display_user_name}
                </a></p>


            </td>
            <td class="clsMessageDetailSection">
            <p>
            <span class="clsImageReSize"> {$LANG.mailread_date} </span> {$mail_details_arr.mess_date|date_format:#format_date_year#}&nbsp;&nbsp;{$mail_details_arr.mess_date|date_format:#format_time#}
            </p>
            <p>
            <span class="clsBold">{$LANG.mailread_subject} </span> {$mail_details_arr.subject}
            </p>
            <p>{$mail_details_arr.message}</p>

            </td>
          </tr>

  </table>
  </div>
  {include file='mail_message_header.tpl'}
{/if}
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}

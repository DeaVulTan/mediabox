<div id="selVideoCategory" class="clsVideoCategory">
	<h2><span>{$LANG.managevideocategory_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
			<table summary="{$LANG.managevideocategory_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}" onClick="return hideAllBlocks();" />
						<input type="hidden" name="category_ids" id="category_ids" />
                        <input type="hidden" name="category_id" id="category_id" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr1)}
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="selMsgConfirmSub" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessageSub"></p>
		<form name="msgConfirmformSub" id="msgConfirmformSub" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.managevideocategory_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirm_actionSub" id="confirm_actionSub" tabindex="{smartyTabIndex}" value="{$LANG.common_yes_option}" />&nbsp;
						<input type="button" class="clsSubmitButton" name="cancelSub" id="cancelSub" tabindex="{smartyTabIndex}" value="{$LANG.common_no_option}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="category_ids" id="category_ids" />
						<input type="hidden" name="action" id="action" />
						{$myobj->populateHidden($myobj->hidden_arr2)}
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="clsLeftNavigation" id="selLeftNavigation">
  {$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}

<p class="ClsMandatoryText">{$LANG.common_mandatory_hint_1} {$myobj->displayCompulsoryIcon()}{$LANG.common_mandatory_hint_2}</p>

{if $myobj->isShowPageBlock('form_create_category')}
	<div id="selCreateCategory">
		<form name="selCreateCategoryFrom" id="selCreateCategoryFrom" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
		<table class="clsNoBorder" summary="{$LANG.managevideocategory_create_tbl_summary}">
		   	<tr>
				<td class="clsSmallWidth {$myobj->getCSSFormLabelCellClass('category')}"><label for="category">{$LANG.managevideocategory_category_name}</label>  {$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('category')}">
					<input type="text" class="clsTextBox" maxlength="{$CFG.admin.videos.category_accept_max_length}" name="category" id="category" value="{$myobj->getFormField('category')}" tabindex="{smartyTabIndex}" />
                    <div><!-- -->
                    {$myobj->getFormFieldErrorTip('category')}</div>
                    {$myobj->ShowHelpTip('category')}				</td>
			</tr>
            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('category_image')}"><label for="category_image">{$LANG.managevideocategory_category_image} ({$myobj->imageFormat}) {$CFG.admin.videos.category_image_max_size} KB
                </label>  {$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('category_image')}">
					{if $myobj->getFormField('category_id')}
						<img src="{$myobj->category_image}" alt="{$myobj->getFormField('category')}" />
					{/if}
					<input type="file" class="clsFileBox" name="category_image" id="category_image" tabindex="{smartyTabIndex}" />
                    <div><!-- -->
                    	{$myobj->getFormFieldErrorTip('category_image')}
                     </div>
                    {$myobj->ShowHelpTip('category_image')}				</td>
			</tr>


			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('category_description')}"><label for="category_description">{$LANG.managevideocategory_category_description}</label>  {$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('category_description')}">
					<textarea rows="4" cols="50" name="category_description" id="category_description" tabindex="{smartyTabIndex}">{$myobj->getFormField('category_description')}</textarea>
                    <div><!-- -->
                    {$myobj->getFormFieldErrorTip('category_description')}</div>
                    {$myobj->ShowHelpTip('category_description')}
                    </td>
			</tr>
       {if $myobj->chkAllowedModule(array('content_filter'))}
			<tr id="selDateLocationRow" class="clsAllowOptions">
         		<td class="{$myobj->getCSSFormLabelCellClass('allow_post')}">
					<label for="allow_post1">{$LANG.manageVideocategory_allow_post}</label>				</td>
          		<td class="{$myobj->getCSSFormFieldCellClass('allow_post')}">{$myobj->getFormFieldErrorTip('allow_post')}
					<input type="radio" class="clsCheckRadio" name="allow_post" id="allow_post1" value="Yes" tabindex="{smartyTabIndex}"
                    {$myobj->isCheckedRadio('allow_post','Yes')} />&nbsp;<label for="allow_post1">{$LANG.common_yes_option}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="allow_post" id="allow_post2" value="No" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('allow_post','No')} />&nbsp;<label for="allow_post2">{$LANG.common_no_option}</label>				</td>
        	</tr>
			<tr id="selDateLocationRow" class="clsAllowOptions">
         		<td class="{$myobj->getCSSFormLabelCellClass('video_category_type')}">
					<label for="video_category_type1">{$LANG.managevideocategory_video_category_type}</label>				</td>
          		<td class="{$myobj->getCSSFormFieldCellClass('video_category_type')}">{$myobj->getFormFieldErrorTip('video_category_type')}
					<input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type1" value="Porn" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('video_category_type','Porn')} />&nbsp;<label for="video_category_type1" >{$LANG.porn}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="video_category_type" id="video_category_type2" value="General" tabindex="{smartyTabIndex}"{$myobj->isCheckedRadio('video_category_type','General')}/>&nbsp;<label for="video_category_type2">{$LANG.general}</label>				</td>
        	</tr>
{/if}
			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('status')}"><label for="status_yes">{$LANG.managevideocategory_category_status}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('status')}">
					<input type="radio" class="clsCheckRadio" name="status" id="status_yes" value="Yes" {if $myobj->getFormField('status') == 'Yes'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="status_yes">{$LANG.managevideocategory_status_yes}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="status" id="status_no" value="No" {if $myobj->getFormField('status') == 'No'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="status_no">{$LANG.managevideocategory_status_no}</label>				</td>
			</tr>
			<tr>
			  <td class="{$myobj->getCSSFormLabelCellClass('priority')}"><label for="priority">{$LANG.manageVideocategory_priority}</label></td>
			  <td class="{$myobj->getCSSFormFieldCellClass('priority')}">{$myobj->getFormFieldErrorTip('priority')}
              <input type="text" class="clsTextBox" name="priority" id="priority"  tabindex="{smartyTabIndex}" value="{$myobj->getFormField('priority')}"/>
               {$myobj->ShowHelpTip('about_priority', 'priority')}
              </td>
		  </tr>
			<tr>
				<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('category_submit')}">
			{if $myobj->chkIsEditMode()}
					<input type="submit" class="clsSubmitButton" name="category_submit" id="category_submit" tabindex="{smartyTabIndex}" value="{$LANG.managevideocategory_update_submit}" />
					<input type="submit" class="clsCancelButton" name="category_cancel" id="category_cancel" tabindex="{smartyTabIndex}" value="{$LANG.managevideocategory_cancel_submit}" />
			{else}
			        <input type="submit" class="clsSubmitButton" name="category_submit" id="category_submit" tabindex="{smartyTabIndex}" value="{$LANG.managevideocategory_add_submit}" />
			{/if}				</td>
			</tr>
		</table>
        {$myobj->populateHidden($myobj->form_create_category.hidden_arr)}
		</form>
	</div>

{/if}

{if $myobj->isShowPageBlock('form_create_sub_category')}
	<p class="clsPageLink"><a href="{$myobj->getCurrentUrl(false)}">{$LANG.managevideocategory_back_to_main}</a></p>
	<div id="selCreateSubCategory">
		<form name="selCreateSubCategory" id="selCreateSubCategory" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl(true)}" autocomplete="off">
		<table class="clsNoBorder" summary="{$LANG.managevideocategory_create_tbl_summary}">
		   	<tr>
				<td class="clsWidthSmall {$myobj->getCSSFormLabelCellClass('sub_category')}"><label for="sub_category">{$LANG.managevideocategory_subcategory_name}</label>  {$myobj->displayCompulsoryIcon()}</td>
				<td class="{$myobj->getCSSFormFieldCellClass('sub_category')}">
					<input type="text" class="clsTextBox" maxlength="{$CFG.admin.videos.category_accept_max_length}" name="sub_category" id="sub_category" value="{$myobj->getFormField('sub_category')}" tabindex="{smartyTabIndex}" />
                    <div><!-- -->
                    {$myobj->getFormFieldErrorTip('sub_category')}</div>
                     {$myobj->ShowHelpTip('sub_category')}				</td>
			</tr>
            <tr>
				<td class="{$myobj->getCSSFormLabelCellClass('sub_category_image')}">
                <label for="sub_category_image">{$LANG.managevideocategory_sub_category_image}                </label>  {$myobj->displayCompulsoryIcon()}                </td>
				<td class="{$myobj->getCSSFormFieldCellClass('sub_category_image')}">
					{if $myobj->getFormField('sub_category_id') && $myobj->getFormField('opt') == 'subedit'}
						<img src="{$myobj->category_image}" alt="{$myobj->getFormField('sub_category')}" />
					{/if}
					<input type="file" class="clsFileBox" name="sub_category_image" id="sub_category_image" tabindex="{smartyTabIndex}" />
                    <div><!-- -->
                    {$myobj->getFormFieldErrorTip('sub_category_image')}</div>
                    {$myobj->ShowHelpTip('sub_category_image')}				</td>
			</tr>
            <tr>
              <td class="{$myobj->getCSSFormLabelCellClass('priority')}"><label for="priority">{$LANG.manageVideocategory_priority}</label></td>
              <td class="{$myobj->getCSSFormFieldCellClass('priority')}">
              	{$myobj->getFormFieldErrorTip('priority')}
                <input class="clsTextBox" type="text" name="priority" id="priority" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('priority')}"/>
                {$myobj->ShowHelpTip('about_priority', 'priority')}              </td>
            </tr>
<!--			<tr>
				<td class="{$myobj->getCSSFormLabelCellClass('status')}"><label for="status_yes">{$LANG.managevideocategory_category_status}</label></td>
				<td class="{$myobj->getCSSFormFieldCellClass('status')}">
					<input type="radio" class="clsCheckRadio" name="status" id="status_yes" value="Yes" {if $myobj->getFormField('status') == 'Yes'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="status_yes">{$LANG.managevideocategory_status_yes}</label>
					&nbsp;&nbsp;
					<input type="radio" class="clsCheckRadio" name="status" id="status_no" value="No" {if $myobj->getFormField('status') == 'No'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="status_no">{$LANG.managevideocategory_status_no}</label>				</td>
			</tr>
-->
			<tr>
				<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('category_submit')}">

				{if $myobj->chkIsEditModeSub()}
					<input type="submit" class="clsSubmitButton" name="update_category_submit" id="sub_category_submit" tabindex="{smartyTabIndex}" value="{$LANG.managevideocategory_update_submit}" />
				  <input type="submit" class="clsCancelButton" name="sub_category_cancel" id="sub_category_cancel" tabindex="{smartyTabIndex}" value="{$LANG.managevideocategory_cancel_submit}" />
				{else}
		          <input type="submit" class="clsSubmitButton" name="sub_category_submit" id="sub_category_submit" tabindex="{smartyTabIndex}" value="{$LANG.managevideocategory_add_submit}" />
				{/if}				</td>
			</tr>
		</table>
        {$myobj->populateHidden($myobj->form_create_sub_category.hidden_arr)}
        <input type="hidden" id="category_id" name="category_id" value="{$myobj->getFormField('category_id')}" />
        <input type="hidden" id="sub_category_id" name="sub_category_id" value="{$myobj->getFormField('sub_category_id')}" />
		<input type="hidden" name="start" value="{$myobj->getFormField('start')}" />
		</form>
	</div>
{/if}

{if $myobj->isShowPageBlock('form_show_sub_category')}
    {if $populateSubCategories_arr.rs_PO_RecordCount}
    	<form name="selFormSubCategory" id="selFormSubCategory" method="post" action="{$myobj->getCurrentUrl(true)}">
        <table>
            <tr>
                <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormSubCategory.name, document.selFormSubCategory.check_all.name)"/></th>
                <th>{$LANG.managevideocategory_subcategory_id}</th>
              <!--                <th>{$LANG.managevideocategory_category}</th>-->
                <th>{$LANG.managevideocategory_subcategory_name}</th>
                <th>{$LANG.managevideocategory_date_added}</th>
                <th>&nbsp;</th>
            </tr>
      	{foreach item=pscValue from=$populateSubCategories_arr.row}
        	<tr>
                <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="category_ids[]" value="{$pscValue.record.video_category_id}" tabindex="{smartyTabIndex}" {$pscValue.checked} onClick="disableHeading('flaggedForm');"/></td>
                <td>{$pscValue.record.video_category_id}</td>
                <td>
                    <p id="categoryName">{$pscValue.record.video_category_name}</p>                </td>
<!--                <td>{$pscValue.record.video_category_name}</td>-->
                <td>{$pscValue.record.date_added}</td>
                <td><p id="edit"><a href="manageVideoCategory.php?category_id={$myobj->getFormField('category_id')}&amp;sub_category_id={$pscValue.record.video_category_id}&amp;opt=subedit">{$LANG.managevideocategory_edit}</a></p></td>
            </tr>
        {/foreach}
            <tr>
                <td colspan="5">
                    <a href="#" id="dAltMltiSub" name="dAltMltiSub"></a>
                    <input type="button" value="{$LANG.managevideocategory_action_delete}" onClick="if(getMultiCheckBoxValue('selFormSubCategory', 'check_all', '{$LANG.managevideocategory_err_tip_select_category}', 'dAltMltiSub', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirmSub', 'msgConfirmformSub', Array('category_ids', 'action', 'category_id', 'confirmMessageSub'), Array(multiCheckValue, 'delete', '{$myobj->getFormField('category_id')}', '{$LANG.managevideocategory_confirm_message}'), Array('value', 'value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />                </td>
            </tr>
        </table>
      </form>
    {else}
        <div id="selMsgAlert">
            <p>{$LANG.managevideocategory_no_sub_category}</td>
        </div>
    {/if}
{/if}

{if $myobj->isShowPageBlock('form_show_category')}
	<form name="selFormCategory" id="selFormCategory" method="post" action="{$myobj->getCurrentUrl()}">
    {$myobj->populateHidden($myobj->form_show_category.hidden_arr)}

    <div id="selShowCategories">
        {if $myobj->isResultsFound()}
            {if $CFG.admin.navigation.top}

                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}

            <table summary="{$LANG.managevideocategory_tbl_summary}">
                <tr>
                    <th><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.selFormCategory.name, document.selFormCategory.check_all.name)"/></th>
                    <th>{$LANG.managevideocategory_category_id}</th>
                    <th>{$LANG.managevideocategory_category}</th>
                    <th>{$LANG.managevideocategory_video_category_type}</th>
                    <th>{$LANG.managevideocategory_video_count}</th>
                    <th>{$LANG.managevideocategory_description}</th>
                    <th>{$LANG.managevideocategory_allow_post}</th>
                    <th>{$LANG.managevideocategory_status}</th>
                    <th>{$LANG.managevideocategory_date_added}</th>
                    <th>&nbsp;</th>
                </tr>
			{foreach key=scKey item=scValue from=$showCategories_arr}
                <tr>
                    <td class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" name="category_ids[]" value="{$scValue.record.video_category_id}" tabindex="{smartyTabIndex}" {$scValue.checked} onClick="checkCheckBox(this.form, 'check_all');"/></td>
                    <td>{$scValue.record.video_category_id}</td>
                    <td>
                        <p id="categoryName"><a href="manageVideoCategory.php?category_id={$scValue.record.video_category_id}&amp;opt=sub">{$scValue.record.video_category_name}</a></p>                    </td>
                    <td>{$scValue.record.video_category_type}</td>
                    <td>{$myobj->getVideoCount($scValue.record.video_category_id)}</td>

                    <td>{$scValue.record.video_category_description}</td>
                    <td>{$myobj->getVideoCount($scValue.record.allow_post)}</td>
                    <td>
                        <p>{$scValue.record.video_category_status}</p>                    </td>
                    <td>
                        <p>{$scValue.record.date_added}</p>                    </td>
                    <td>
                        <p id="edit"><a href="manageVideoCategory.php?category_id={$scValue.record.video_category_id}&amp;start={$myobj->getFormField('start')}">{$LANG.managevideocategory_edit}</a></p>
                        {if $CFG.admin.videos.sub_category }
                        <p>
                            <a href="manageVideoCategory.php?category_id={$scValue.record.video_category_id}&amp;opt=sub">{$LANG.managevideosubgenrelink}</a>
                            </p>
                         {/if}

                                            </td>
                </tr>
            {/foreach}
				<tr>
					<td colspan="10" class="{$myobj->getCSSFormFieldCellClass('delete')}">
						<a href="#" id="dAltMlti"></a>
						<select name="video_options" id="video_options" tabindex="{smartyTabIndex}" >
							<option value="Enable">{$LANG.managevideocategory_action_enable}</option>
	  						<option value="Disable">{$LANG.managevideocategory_action_disable}</option>
	  						<option value="Delete">{$LANG.managevideocategory_action_delete}</option>
	  					</select>
						<input type="button" class="clsSubmitButton" name="action_submit" id="action_submit" tabindex="{smartyTabIndex}" value="{$LANG.managevideocategory_submit}" onClick="if(getMultiCheckBoxValue('selFormCategory', 'check_all', '{$LANG.managevideocategory_err_tip_select_category}', 'dAltMlti', -25, -290)) {literal} { {/literal} Confirmation('selMsgConfirm', 'msgConfirmform', Array('category_ids', 'action', 'confirmMessage'), Array(multiCheckValue, document.selFormCategory.video_options.value, '{$LANG.managevideocategory_confirm_message}'), Array('value', 'value', 'innerHTML'), -25, -290); {literal} } {/literal}" />					</td>
				</tr>
			</table>

        {if $CFG.admin.navigation.bottom}

                {$myobj->setTemplateFolder('admin/')} {include file='pagination.tpl'}
            {/if}
        {else}
            <div id="selMsgAlert">
                <p>{$LANG.managevideocategory_no_category}</td>
            </div>
        {/if}
    </div>
	</form>
{/if}

	</div>
</div>
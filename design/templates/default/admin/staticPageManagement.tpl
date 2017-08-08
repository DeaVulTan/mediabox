{ if $myobj->isShowPageBlock('block_sel_page_list')}
<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
 	<h3 id="confirmation_msg"></h3>
    <form name="deleteForm" id="deleteForm" method="post" action="{$myobj->getCurrentUrl()}">
    	    <!-- clsFormSection - starts here -->
    	<table class="clsFormSection clsNoBorder">
	  		<tr><td>
				  	<input type="submit" class="clsSubmitButton" name="delete_add" id="delete_add" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
				  	<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.common_cancel}" onClick="return hideAllBlocks();" />
         	</td></tr>
      	</table>
		{$myobj->populateHidden($myobj->deleteForm_hidden_arr)}
    <!-- clsFormSection - ends here -->
    </form>
</div>
<div id="selCodeForm" class="clsPopupAlert" style="display:none;">
	<h3 id="codeTitle"></h3>
    <form name="codeForm" id="codeForm" method="post" action="{$myobj->getCurrentUrl()}">
	<!-- clsFormSection - starts here -->
    <table class="clsFormSection clsNoBorder">

            	<tr><td class="clsFormLabelCellDefault">
					<label for="addCode">{$LANG.outside_the_static}</label>
				</td>
				<td class="clsFormFieldCellDefault">
					<textarea name="addCode" id="addCode" rows="3" cols="75"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
				</td></tr>
            	<tr><td class="clsFormLabelCellDefault">
					<label for="addCodeStatic">{$LANG.inside_the_static}</label>
				</td>
				<td class="clsFormFieldCellDefault">
					<textarea name="addCodeStatic" id="addCodeStatic" rows="3" cols="75"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
				</td></tr>
            	<tr><td class="clsFormLabelCellDefault">
					<label for="addCodeTemplate">{$LANG.code_template}</label>
				</td>
				<td class="clsFormFieldCellDefault">
					<textarea name="addCodeTemplate" id="addCodeTemplate" rows="3" cols="75"  onfocus="this.select()" onclick="this.select()" readonly></textarea>
					<p>{$LANG.code_instruction}</p>
				</td></tr>
         	</table>
    <!-- clsFormSection - ends here -->
     </form>
</div>
{/if}
<div id="selStaticPgMgt">
	<h2>{$LANG.document_editor}</h2>
	{$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}
	{ if $myobj->isShowPageBlock('block_document_editor')}
	<div id="selDocumentEditor">
		{if $CFG.admin.static_page_editor}
		<form name="frmDocumentEditor" action="{$myobj->getCurrentUrl()}" method="post" onsubmit="return { if $CFG.feature.html_editor eq 'richtext'}getHTMLSource('rte1', 'frmDocumentEditor', 'page_content');{else}true{/if}">
		{else}
		<form name="frmDocumentEditor" action="{$myobj->getCurrentUrl()}" method="post">
		{/if}
			{$myobj->populateHidden($myobj->frmDocumentEditor_hidden_arr)}
			<table class="clsFormSection clsNoBorder">
				<tr>
					<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('page_content')}">{$myobj->getFormFieldErrorTip('page_content')}
						{if $CFG.feature.html_editor eq 'tinymce'}
    	                    {$myobj->populateHtmlEditor('page_content')}
                        {else}
							<textarea name="page_content" id="page_content" tabindex="{smartyTabIndex}" cols="100" rows="15">{$myobj->getFormField('page_content')}</textarea>
						{/if}
						{if $CFG.feature.html_editor eq 'textarea'}
							<p>{$LANG.put_the_html_code}</p>
						{/if}
					</td>
				</tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('page_name')}">
						<label for="pagename">{$LANG.save_as}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('page_name')}">{$myobj->getFormFieldErrorTip('page_name')}
						<input type="text" class="clsTextBox" name="page_name" id="pagename" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('page_name')}" />
                        {$myobj->ShowHelpTip('static_page_name', 'page_name')}
					</td>
			   	</tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('title')}">
						<label for="title">{$LANG.label_title}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('title')}">{$myobj->getFormFieldErrorTip('title')}
						<input type="text" class="clsTextBox" name="title" id="title" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('title')}" />
					{$myobj->ShowHelpTip('static_title', 'title')}</td>
			   	</tr>
				<tr>
					<td class="{$myobj->getCSSFormLabelCellClass('status')}">
						<label for="status2">{$LANG.status}</label>
					</td>
					<td class="{$myobj->getCSSFormFieldCellClass('status')}">{$myobj->getFormFieldErrorTip('status')}
						<input type="radio" class="clsRadioButton" name="status" id="status2" tabindex="{smartyTabIndex}" value="Activate"{$myobj->isCheckedRadio('status', 'Activate')} /><label for="status2">{$LANG.label_activate}</label>&nbsp;
						<input type="radio" class="clsRadioButton" name="status" id="status3" tabindex="{smartyTabIndex}" value="Toactivate"{$myobj->isCheckedRadio('status', 'Toactivate')} /><label for="status3">{$LANG.label_toactivate}</label>
					 {$myobj->ShowHelpTip('static_status', 'status')}</td>
			   	</tr>
					<tr>
						<td colspan="2" class="{$myobj->getCSSFormFieldCellClass('default')}">
							<input type="submit" class="clsSubmitButton" name="document_submit" id="document_submit" tabindex="{smartyTabIndex}" value="{$LANG.submit_document}" />
						</td>
					</tr>
				</table>
			</form>
		</div>
		{/if}
		{ if $myobj->isShowPageBlock('block_sel_page_list')}
		<form name="selListStaticForm" id="selListStaticForm" method="post" action="{$myobj->getCurrentUrl()}">
			{if $CFG.admin.navigation.top}
				{$myobj->setTemplateFolder('admin/')}{include file='pagination.tpl'}
			{/if}
	  		    <!-- clsDataDisplaySection - starts here -->

    <div class="clsDataDisplaySection">
	  				<table>
                    <tr>
                        <th><input type="checkbox" class="clsCheckBox" name="check_all" onclick= "CheckAll(document.selListStaticForm.name, document.selListStaticForm.check_all.name)" tabindex="{smartyTabIndex}" /></td>
                        <th class="{$myobj->getOrderCss('page_name')}"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','page_name')">{$LANG.th_page_name}</a></th>
                        <th class="{$myobj->getOrderCss('title')}"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','title')">{$LANG.th_title}</a></th>
                        <th class="{$myobj->getOrderCss('status')}"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','status')">{$LANG.th_status}</a></th>
                        <th class="{$myobj->getOrderCss('date_added')}"><a href="#" onclick="return changeOrderbyElements('selListStaticForm','date_added')">{$LANG.th_date_added}</a></th>
                        <th>&nbsp;</th>
					</tr>
                {foreach key=inc item=value from=$populateStaticPagesList_arr}
					<tr class="clsDataRow {$myobj->getCSSRowClass()}">
                        <td><input type="checkbox" class="clsCheckBox" name="page_name[]" value="{$populateStaticPagesList_arr.$inc.page_name}" tabindex="{smartyTabIndex}" onClick="disableHeading('selListStaticForm');"/></td>
                        <td>{$populateStaticPagesList_arr.$inc.page_name}</td>
                        <td>{$populateStaticPagesList_arr.$inc.title}</td>
                        <td>{$populateStaticPagesList_arr.$inc.status}</td>
                        <td>{$populateStaticPagesList_arr.$inc.date_added|date_format:#format_date_year#}</td>
                        <td>
						<a id="{$populateStaticPagesList_arr.$inc.page_name}" href="#"></a>
						<a href="{$populateStaticPagesList_arr.$inc.edit_link}">{$LANG.edit}</a>
						<a id="code_{$populateStaticPagesList_arr.$inc.page_name}" href="#" onclick="return populateCode('{$populateStaticPagesList_arr.$inc.page_name}', '{$populateStaticPagesList_arr.$inc.title}')">{$LANG.code}</a>
						</td>
					</tr>
				{/foreach}
	  				<tr>
						<td colspan="6">
	  					{$myobj->populateHidden($myobj->selListStaticForm_hidden_arr)}
	  					<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="{smartyTabIndex}" value="{$LANG.add_delete}" onclick="{$delete_submit_onclick}" />
	  					<input type="button" class="clsSubmitButton" name="activate_submit" id="activate_submit" tabindex="{smartyTabIndex}" value="{$LANG.add_activate}" onclick="{$activate_submit_onclick}" />
	  					<input type="button" class="clsSubmitButton" name="toactivate_submit" id="toactivate_submit" tabindex="{smartyTabIndex}" value="{$LANG.add_toactivate}" onclick="{$inactivate_submit_onclick}" />
	  					</td>
					</tr>
	  		   	</table>
	  		</div>

        <!-- clsDataDisplaySection - ends here -->
			{if $CFG.admin.navigation.bottom}
				{$myobj->setTemplateFolder('admin/')}{include file='pagination.tpl'}
			{/if}
		</form>
		{/if}
</div>
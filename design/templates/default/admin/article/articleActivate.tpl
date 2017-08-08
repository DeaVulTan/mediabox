<div id="selarticleList">
  	<h2><span>{$LANG.articleActivate_title}</span></h2>
	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
		<p id="confirmMessage"></p>
		<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl()}">
			<table summary="{$LANG.articleActivate_confirm_tbl_summary}">
				<tr>
					<td>
						<input type="submit" class="clsSubmitButton" name="confirmdel" id="confirmdel" tabindex="{smartyTabIndex}" value="{$LANG.confirm}" />
						&nbsp;
						<input type="button" class="clsSubmitButton" name="subcancel" id="subcancel" tabindex="{smartyTabIndex}" value="{$LANG.cancel}"  onClick="return hideAllBlocks();" />
						<input type="hidden" name="checkbox" id="checkbox" />
						<input type="hidden" name="action" id="action" />
						<input type="hidden" name="article_categories" id="article_categories" />
						{$myobj->populateHidden($myobj->hidden_arr)}
					</td>
				</tr>
			</table>
		</form>
	</div>

  {$myobj->setTemplateFolder('admin/')}
  {include file='information.tpl'}

	{if $myobj->isShowPageBlock('list_article_form')}

	  		<div id="selArticleList">

		{if $myobj->isResultsFound()}
	        <form name="article_manage_form2" id="article_manage_form2" method="post" action="{$myobj->getCurrentUrl()}">
	            {if $CFG.admin.navigation.top}
		            {$myobj->setTemplateFolder('admin/')}
	                {include file='pagination.tpl'}
	            {/if}
	            	<p><b>{$LANG.common_article_note}</b>&nbsp;{$LANG.articleActivate_disapprove_comment_confirmation_note}</p>
	                <table summary="{$LANG.articleActivate_tbl_summary}">
						<tr>
							<th class="clsSelectAllItems"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="{smartyTabIndex}" onclick="CheckAll(document.article_manage_form2.name, document.article_manage_form2.check_all.name)"/></th>

							<th>{$LANG.articleActivate_article_title}</th>
							<th>{$LANG.articleActivate_article_category}</th>
							<th>{$LANG.articleActivate_user_name}</th>
							<th>{$LANG.articleActivate_date_added}</th>
							<th>{$LANG.articleActivate_flagged}</th>
							<th>{$LANG.articleActivate_option}</th>
						</tr>
					{foreach item=dalValue from=$displayarticleList_arr}
	                    <tr>
	                        <td class="clsSelectAllItems"><input type="checkbox" name="checkbox[]" value="{$dalValue.record.article_id}-{$dalValue.record.user_id}" /></td>
	                        <td>
								<a href="javascript:void(0);"  onclick="popupWindow('{$dalValue.view_article_link}')">{$dalValue.record.article_title}</a>
							</td>
	                        <td>{$myobj->getArticleCategory($dalValue.record.article_category_id)}</td>
	                        <td>{$dalValue.name}</td>
	                        <td>{$dalValue.record.date_added}</td>
	                        <td>{$dalValue.record.flagged_status}</td>
	                        <td>
	                            {*<a href="{$CFG.site.url}admin/article/articlePreview.php?article_id={$dalValue.record.article_id}"  class="lightwindow" params="lightwindow_type=external">{$LANG.articleActivate_preview}</a>*}
	                            <span id="preview">
						  			{*<a id="articlePreview_{$dalValue.record.article_id}" href="{$CFG.site.url}admin/article/articlePreview.php?article_id={$dalValue.record.article_id}" class="lightwindow">{$myobj->LANG.articleActivate_preview}</a>*}
						  			<a href="javascript:void(0);"  onclick="popupWindow('{$dalValue.view_article_link}')">{$myobj->LANG.articleActivate_preview}</a>
							 	</span>&nbsp;&nbsp;&nbsp;&nbsp;
			              		<span id="adminComments">
		                    		<a id="viewAdminArticleComment_{$dalValue.record.article_id}" href="{$CFG.site.url}admin/article/articleAdminComment.php?article_id={$dalValue.record.article_id}" class="lightwindow">{$LANG.articleActivate_admin_comment}</a>
		                    	</span>
	                        </td>
	                    </tr>
	                {/foreach}

						<tr>
							<td colspan="9">
								<a href="#" id="dAltMlti"></a>
								<input type="hidden" name="article_options" value="Ok" />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.articleactivate_activate}" onClick="if(getMultiCheckBoxValue('article_manage_form2', 'check_all', '{$LANG.articleActivate_err_tip_select_articles}')) {literal} { {/literal} getAction('Ok') {literal} } {/literal}" />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.articleactivate_delete}" onClick="if(getMultiCheckBoxValue('article_manage_form2', 'check_all', '{$LANG.articleActivate_err_tip_select_articles}')) {literal} { {/literal} getAction('Delete') {literal} } {/literal} " />
								<input type="button" class="clsSubmitButton" name="delete" tabindex="{smartyTabIndex}" value="{$LANG.articleactivate_disapprove}" onClick="if(getMultiCheckBoxValue('article_manage_form2', 'check_all', '{$LANG.articleActivate_err_tip_select_articles}')) {literal} { {/literal} getAction('NotApproved') {literal} } {/literal} " />
								&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
						</tr>
					</table>

	            {if $CFG.admin.navigation.bottom}
		            {$myobj->setTemplateFolder('admin/')}
	                {include file='pagination.tpl'}
	            {/if}

				{$myobj->populateHidden($myobj->list_article_form.hidden_arr)}

	        </form>
		{else}
			<div id="selMsgAlert">
				{$LANG.articleActivate_no_records_found}
			</div>
		{/if}
	  		</div>
	{/if}
</div>
{* Added code to display fancy box for article admin comments and preview article *}
<script>
{literal}
$Jq(document).ready(function() {
	{/literal}
	{if $myobj->isResultsFound()}
	{foreach item=dalValue from=$displayarticleList_arr}
	{literal}
	$Jq('#viewAdminArticleComment_'+{/literal}{$dalValue.record.article_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 600,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

	$Jq('#previewArticle_'+{/literal}{$dalValue.record.article_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 750,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});

	$Jq('#articlePreview_'+{/literal}{$dalValue.record.article_id}{literal}).fancybox({
		'width'				: 900,
		'height'			: 750,
		'padding'			:  0,
		'autoScale'     	: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe'
	});
	{/literal}
	{/foreach}
	{/if}
	{literal}
});
{/literal}
</script>
<div class="clsManageFeatuedSearch">
	<div class="clsManageTitle">
    	<h2>{$LANG.index_glidersetting_featured_content_popup_search}</h2>
	</div>
</div>
<div class="clsManageFeatuedMainSearch">
	<form name="searchForm" id="searchForm" method="post" action="{$myobj->getCurrentUrl()}">
		<table>
			<tr>
				<td>{$LANG.index_glidersetting_featured_content_selected_media_type}</td>
				<td><div id="search_media_type">Music</div>
                <input type="hidden" class="clsTextBox" name="search_media_type" id="hidden_search_media_type" value="" readonly="readonly"></td>
			</tr>
			<tr>
				<td><input type="text" class="clsTextBox" name="search_input" id="search_input" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_featured_content_enter_search_keyword}" onClick="this.value='';" onBlur="if(this.value=='') this.value='{$LANG.index_glidersetting_featured_content_enter_search_keyword}';" /></td>
				<td><input type="submit" class="clsSubmitButton" name="search_submit" id="search_submit" tabindex="{smartyTabIndex}" value="{$LANG.index_glidersetting_featured_content_search}"/></td>
			</tr>
		</table>
	</form>
{if $searchResultCount>0}
	<div>
		<h3>{$LANG.index_glidersetting_featured_content_search_result_for} '{$searchKeyword}'</h3>
	</div>
	{$myobj->setTemplateFolder('admin')}
	{include file='information.tpl'}
    <form name="featured_content_search_form" id="featured_content_search_form" method="post" action="{$myobj->getCurrentUrl()}">
    	<input type="hidden" name="seachKeyword" id="searchKeyword" value="{$searchKeyword}" />
    	<table>
    		{if $searchSelectTemplate!=''}
    			<tr>
        			<td colspan="3" align="right" class="clsSelectPage">
            			{$LANG.index_glidersetting_featured_content_search_select_page}{$searchSelectTemplate}
          			</td>
        		</tr>
        	{/if}
        	<tr>
        		<th>{$LANG.index_glidersetting_featured_content_search_media_id}</th>
				<th>{$LANG.index_glidersetting_featured_content_search_media_title}</th>
				<th>&nbsp;</th>
        	</tr>
         	{foreach key=inc item=value from=$searchResult}
        	<tr>
        		<td>{$searchResult.$inc.media_id}</td>
            	<td>{$searchResult.$inc.media_title}</td>
            	<td><a href="javascript: void(0);" onclick="selectMediaId({$searchResult.$inc.media_id});">{$LANG.index_glidersetting_featured_content_select_media}</a></td>
        	</tr>
        	{/foreach}
    	</table>
    </form>
{/if}
</div>
{$myobj->setTemplateFolder('admin')}
{include file='information.tpl'}
{literal}
<script type="text/javascript">
function selectMediaId(mediaId)
{
	window.parent.document.frmAddContentGlider.media_id.value = mediaId;
	parent.$Jq.fancybox.close();
}
document.getElementById('search_media_type').innerHTML = window.parent.document.frmAddContentGlider.media_type.value;
document.getElementById('hidden_search_media_type').value = window.parent.document.frmAddContentGlider.media_type.value;
</script>
{/literal}

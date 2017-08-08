 <div id="selNewLetterView">
  <h2><span>{$LANG.newsletterview_title}</span></h2>
  {$myobj->setTemplateFolder('admin/')}
{include file="information.tpl"}
{if $myobj->isShowPageBlock('view_newsletter_form')}
  <div id="selNewsLetterViewFrm" class="clsNoBorder">
  		<table summary="{$LANG.newsletterview_tbl_summary}">
			<tr>
				<td class="clsWidthSmall">{$LANG.newsletterview_subject}</td>
				<td>{$displaynewsletter_arr.row.subject}</td>
			</tr>
			<tr>
				<td>{$LANG.newsletterview_content}</td>
				<td>{$displaynewsletter_arr.row.body}</td>
			</tr>
			{*<!--<tr>
				<td>{$LANG.newsletterview_sqlcondition}</td>
				<td>{$displaynewsletter_arr.row.sql_condition}</td>
			</tr>
			<tr>
				<td>{$LANG.newsletterview_sentuptouserid}</td>
				<td>{$displaynewsletter_arr.row.upto_user_id}</td>
			</tr>-->*}
			<tr>
				<td>{$LANG.newsletterview_datesent}</td>
				<td>{$displaynewsletter_arr.row.date_added|date_format:#format_datetime#}</td>
			</tr>
			<tr>
				<td>{$LANG.newsletterview_totalmailsent}</td>
				<td>{$displaynewsletter_arr.row.total_sent}</td>
			</tr>
			<tr>
				<td>{$LANG.newsletterview_status}</td>
				<td>{$displaynewsletter_arr.row.status}</td>
			</tr>
		</table>
   </div>
{/if}

</div>
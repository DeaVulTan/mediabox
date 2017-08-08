<div id="sellatestNews" class="clsCommonAdminTbl">

  	<h2>{$LANG.latestnews_title}</h2>
   <div class="clsAdminLatestNews">
        {include file='../general/information.tpl'}
        {if $myobj->isShowPageBlock('block_main_ionformation')}
            <div id="selReportBlock">

            </div>
        {/if}
        <table class="clsFormTbl">
        	{foreach key=pnkey item=pnvalue from=$myobj->block_main_ionformation.populateNews}
            	<tr>
                    <td><p class="clsLatestSubject"><span>{$pnvalue.SUBJECT}</span></p>
                    <p >{$pnvalue.DATE_ADDED|date_format:#format_datetime#}</p>

                    <p>{$pnvalue.CONTENT}</p>
                    </td>
                </tr>
	        {foreachelse}
                <tr>
                    <td>
                        <div id="selMsgAlert">
                        <p>{$LANG.latestnews_no_records_found}</p>
                        </div>
                    </td>
                </tr>
        {/foreach}
        </table>
    </div>
</div>
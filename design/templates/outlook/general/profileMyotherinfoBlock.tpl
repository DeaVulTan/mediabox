{if $other_info_arr!=0}
   <div class="clsOtherInfoTable">
      <table{$myobj->defaultTableBgColor} >
        <tr>
          <th colspan="2" class="text clsProfileTitle" {$myobj->defaultBlockTitle} ><span class="whitetext12">{$LANG.myprofile_other_info}</span></th>
        </tr>
        <tr><td class="clsProfileTableInformation" colspan="2">
            <div class="clsProfileTableInfo">
				<table class="clsOtherInfo" id="{$CFG.profile_box_id.otherInfo_list}">
                    {foreach key=item item=value from=$other_info_arr}
                    	{if $value.answer_result != $CFG.profile.question_no_answer && $value.answer_result !=''}
                     		<tr>
                     			<td><p>{$value.question}</p></td>
                     			<td class="clsOtherAnswerSection">
                     					<div id="{$value.sel_id}" class="{$value.class_name}">{$value.answer_result}</div>
								</td>
                     		</tr>
                     	{/if}
                    {/foreach}
            	</table>
			</div>
		</td></tr>
      </table>
   </div>
{/if}
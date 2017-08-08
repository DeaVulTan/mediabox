{if $block_show_htmlfields}
{section name=quest_cat loop=$block_show_htmlfields}
   <div class="clsPersonalInfoTable">
      <table {$myobj->defaultTableBgColor} >
        <tr>
          <th colspan="2" class="text clsProfileTitle" {$myobj->defaultBlockTitle} ><span class="whitetext12">{$block_show_htmlfields[quest_cat].title}</span></th>
        </tr>
        <tr><td colspan="2">
        	<div class="clsProfileTableInfo">
				<table class="clsPersonalInfo" id="{$CFG.profile_box_id.personalinfo_list}">
                    {foreach key=inc item=value from=$block_show_htmlfields[quest_cat].questions}
                    	{if $value.answer_result != $CFG.profile.question_no_answer && $value.answer_result !=''}
                    		<tr>
                     			<td><p class="clsListing">{$value.question}</p></td>
                     			<td class="clsAnswerSection">
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
{/section}
{/if}

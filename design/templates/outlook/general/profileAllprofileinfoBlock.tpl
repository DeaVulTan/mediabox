{section name=profile_info loop=$profile_info_arr}
{if $selected_category eq $profile_info_arr[profile_info].cat_id}
   <div class="clsDefaultInfoTable {$profile_info_arr[profile_info].css_class_name}">
      <table {$myobj->defaultTableBgColor} >
        <tr>
          <th colspan="2" class="{$profile_info_arr[profile_info].css_class_name}" {$myobj->defaultBlockTitle} ><span class="whitetext12">{$profile_info_arr[profile_info].title}</span></th>
        </tr>
        <tr><td class="{$profile_info_arr[profile_info].css_class_name}" colspan="2">
            <div class="clsProfileTableInfo">
				<table class="clsOtherInfo" id="{$CFG.profile_box_id.otherInfo_list}">
                    {foreach key=item item=value from=$profile_info_arr[profile_info].profile_info}
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
{/section}
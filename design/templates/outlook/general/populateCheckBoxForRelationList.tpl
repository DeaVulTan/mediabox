{if $myobj->relation_list_count}
    {foreach from=$populateCheckBoxForRelationList item=friends}
    <input type="checkbox" class="clsCheckRadio" name="relation_id[]" id="relation_id_{$friends.record.relation_id}" 
    value="{$friends.record.relation_id}" tabindex="{smartyTabIndex}" 
    {$myobj->isCheckedCheckBoxArray('relation_id', $friends.record.relation_id)} />
                <label for="relation_id_{$friends.record.relation_id}">
                    <b>{$friends.record.relation_name}({$friends.record.total_contacts})</b>
                </label><br />
    {/foreach}
{else}
<p>{$LANG.no_relation_list}</p>
{/if}
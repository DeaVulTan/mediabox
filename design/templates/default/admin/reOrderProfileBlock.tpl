<div id="selProfileBlock">
<h2 class="clsPopUpHeading">{$LANG.reorderprofileblock_title}</h2>
 <p class="clsPageLink"><a class="clsAdd" href="manageProfileBlock.php">{$LANG.reorderprofileblock_add_block}</a>
 <div id="selMsgSuccess">
        	<p>{$LANG.reorderprofileblock_note}: {$LANG.reorderprofileblock_note_message}</p>
 </div>
{$myobj->setTemplateFolder('admin/')}
{include file='information.tpl'}
<div class="clsOverflow"><form name="reorder_form" id="reorder_form" method="post" action="#">
<div class="clsOverflow"><div class="workarea">
  <h3>{$LANG.reorderprofileblock_left_side_block}</h3>
  <ul id="ul1" class="draglist">
   {foreach key=scKey item=Lvalue from=$myobj->show_profile_block.profile_block}
     {if $Lvalue.position=='left'}
    <li class="list1" id="{$Lvalue.block_name}">{$Lvalue.block_category_name}</li>
      {/if}
   {/foreach}
  </ul>
</div>

<div class="workarea">
  <h3>{$LANG.reorderprofileblock_right_side_block}</h3>
  <ul id="ul2" class="draglist">
   {foreach key=scKey item=Rvalue from=$myobj->show_profile_block.profile_block}
     {if $Rvalue.position=='right'}
    <li class="list2" id="{$Rvalue.block_name}">{$Rvalue.block_category_name}</li>
     {/if}
   {/foreach}
  </ul>
</div></div>

<div id="user_actions">
<input id="left"  type="hidden" name="left"/>
<input id="right"  type="hidden" name="right"/><div class="clsPopUpUpdate">
<input class="clsSubmitButton" id="showButton" value="{$LANG.common_update}" name="update_order" type="submit"/></div>
</div>
</form></div>

</div>
<div id="selProfileBlock">
<div class="clsAdminIndexBlockHd clsOverflow">
	<h2>{$LANG.reorderindexblock_title}</h2>
    <p class="clsAddManageBlockLink clsPageLink"><a class="clsAdd" href="manageHomePageBlock.php">{$LANG.reorderindexblock_add_block}</a></p>
</div>


{$myobj->setTemplateFolder('admin/')} {include file='information.tpl'}

{if $myobj->isShowPageBlock('show_index_block_settings')}
  <h3>{$LANG.reorderindexblock_block_location_settings}</h3>
 <div class="clsBlockLocationList">
	  <form name="form_profile_block" id="form_profile_block" method="post" > 
  	<div class="clsNote">
        	<p>{$LANG.reorderindexblock_note}:&nbsp;{$LANG.reorderindexblock_settings_note_message}</p>
      </div>
	<div class="clsDataDisplaySection">
	  <div class="clsDataHeadSection">      
            <table>
                  <tr>
                        <th>{$LANG.reorderindexblock_block}</th>
                        <th>{$LANG.reorderindexblock_location}</th>
                  </tr>
             {foreach key=key item=settings_value from=$myobj->index_block_settings_arr}
                  {assign var=location_field_name value=location_$settings_value.block_name}
                  <tr>
                        <td class="{$myobj->getCSSFormLabelCellClass($settings_value.block_name)}"><label for="display_yes">{$settings_value.display_text}</label></td>
                        <td class="{$myobj->getCSSFormFieldCellClass('display')}">
                              <input type="radio" class="clsCheckRadio" name="location_{$settings_value.block_name}" id="{$settings_value.block_name}_mainblock" value="mainblock" {if $myobj->getFormField($settings_value.field_name) == 'mainblock'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="{$settings_value.block_name}_mainblock">{$LANG.reorderindexblock_main_block}</label>
                              &nbsp;&nbsp;
                              <input type="radio" class="clsCheckRadio" name="location_{$settings_value.block_name}" id="{$settings_value.block_name}_sidebar" value="sidebar" {if $myobj->getFormField($settings_value.field_name) == 'sidebar'} CHECKED {/if} tabindex="{smartyTabIndex}" />&nbsp;<label for="{$settings_value.block_name}_sidebar">{$LANG.reorderindexblock_side_bar}</label>				</td>
                  </tr>      	
             {/foreach}
            </table>
        </div>
     </div>
            <input type="reset" class="clsSubmitButton" name="cancel" id="cancel" tabindex="{smartyTabIndex}" value="{$LANG.reorderindexblock_cancel}" />
            <input type="submit" class="clsSubmitButton" name="update_location" id="update_location" tabindex="{smartyTabIndex}" value="{$LANG.reorderindexblock_update}" />
  </form>
  </div>
{/if}

 <h3>{$LANG.reorderindexblock_reorder_title}</h3>

 <div class="clsNote">
        	<p>{$LANG.reorderindexblock_note}: {$LANG.reorderindexblock_note_message}</p>
  </div>

      <div class="clsOverflow">
            <form name="form_profile_block" id="form_profile_block" method="post" > 
             <div class="clsOverflow"><div class="workarea">
               <ul id="ul1" class="draglist">
                {foreach key=scKey item=value from=$myobj->show_index_block.index_block}
                  <li class="list1" id="{$value.block_name}">{$value.display_text}</li>
                {/foreach}
               </ul>
             </div></div>	
             <div id="user_actions">
                  <input id="order"  type="hidden" name="order"><div class="clsPopUpUpdate">
                  <input class="clsSubmitButton" id="showButton" value="{$LANG.common_update}" name="update_order" type="submit">
             </div>
            </div>
            </form>
      </div>
</div>
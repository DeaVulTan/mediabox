{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div class="clsSubscriptionHeading">
  <h2>{$LANG.mysubscription_title}</h2>
<div class="clsTabNavigation clsRecentActivities">
  <ul>
      <li{$myobj->active_member_class}><span><a href="{$myobj->getUrl('mysubscription', '?pg=member_subscription', 'member_subscription/', 'members')}">{$LANG.mysubscription_member_title}</a></span></li>
      <li{$myobj->active_category_class}><span><a href="{$myobj->getUrl('mysubscription', '?pg=category_subscription', 'category_subscription/', 'members')}">{$LANG.mysubscription_category_title}</a></span></li>
      <li{$myobj->active_tag_class}><span><a href="{$myobj->getUrl('mysubscription', '?pg=tag_subscription', 'tag_subscription/', 'members')}">{$LANG.mysubscription_tag_title}</a></span></li>
  </ul>
</div>

{if $myobj->isShowPageBlock('member_subscription')}
	<div>
  {include file='../general/information.tpl'}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='form_top'}
   <p class="clsNoteMessange"><span>{$LANG.common_note}:&nbsp;</span>{$LANG.common_subscription_note_member_manage_msg}</p>
   <form name="form_membersubscription" id="form_membersubscription" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
   <table class="clsFormSection clsMySubscitpionFilter">
      <tr class="clsFormRow">
        <td class="{$myobj->getCSSFormLabelCellClass('user_name')}">
        	{$myobj->displayCompulsoryIcon()}
          <label for="user_name">{$LANG.mysubscription_field_username}</label>
        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('user_name')}">
          <input type="text" class="clsTextBox" name="user_name" id="user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('user_name')}" />
          {$myobj->getFormFieldErrorTip('user_name')}
          {$myobj->ShowHelpTip('subscription_username', 'user_name')}
        </td>

        </tr>
      <tr class="clsFormRow">
        <td class="{$myobj->getCSSFormLabelCellClass('sub_module')}">
          <label for="sub_module">{$LANG.mysubscription_field_module}</label>
        </td>
        <td class="{$myobj->getCSSFormFieldCellClass('sub_module')}">
		{foreach item=sub_module from=$myobj->sub_module_arr}
	          <p><input type="checkbox" name="sub_module[]" id="sub_module[]" tabindex="{smartyTabIndex}" value="{$sub_module}" /> <label>{$sub_module|capitalize}</label></p>
            {/foreach}
          {$myobj->getFormFieldErrorTip('sub_module')}
          {$myobj->ShowHelpTip('subscription_module', 'sub_module')}
        </td>

        </tr>
      <tr class="clsFormRow">
        <td class="{$myobj->getCSSFormFieldCellClass('default')}">
          <input type="hidden" name="pg" id="pg" value="{$myobj->getFormField('pg')}" />
          <input type="hidden" name="sub_type" id="sub_type" value="User" />
          <input type="submit" class="clsSubmitButton" name="member_submit" id="member_submit" tabindex="{smartyTabIndex}" value="{$LANG.mysubscription_subscribe}" />
	    <input type="submit" class="clsSubmitButton" name="member_cancel" id="member_cancel" tabindex="{smartyTabIndex}" value="{$LANG.mysubscription_cancel}" />
        </td>
      </tr>
      </table>
  </form>

{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='form_bottom'}
  </div>
	<div id="selViewAllMembers" class="clsMemberListTable">
   <div class="clsOverflow">
   		<div class="clsSubscriptionTitleLeft">
       		 <h3>{$LANG.mysubscription_list_subscriptions}</h3>
        </div>
        <div><!----></div>
   </div>
     {if $myobj->member_subscription_arr|@count > 0}
          <table>
          {foreach key=inc item=value from=$myobj->member_subscription_arr}
            {if $value.open_tr}
            <tr>
            {/if}
               <td>
                <ul class="clsSubscribersListDisplay">
                  <li id="memberlist_videoli_{$inc}">

                    <div class="clsThumbImageContainer clsMemberImageContainer">
                            <div class="clsThumbImageContainer">
                                <div class="clsThumbImageLink" id="selMemberName">
                                    <div  class="clsPointer">
                                        <div class="ClsImageContainer ClsImageBorder2 Cls66x66" {$value.profileIcon.t_attribute} id="memberlist_thumb_{$inc}">
                                        <a href="{$value.memberProfileUrl}" class="ClsImageContainer ClsImageBorder2 Cls66x66">
                                           <img border="0" src="{$value.profileIcon.s_url}" alt="{$value.record.user_name|truncate:7}" title="{$value.record.user_name}"  {$value.profileIcon.s_attribute}/></a>
                                         </div>
                                   </div>
                                </div>
                                <div class="clsMemberListThumbTitle">
                                    <a href="{$value.memberProfileUrl}">{$value.record.user_name}</a>
                                </div>
                                    <p class="clsSubscriptionIcon">
                                          <a title="{$LANG.common_subscriptions}" href="javascript:void(0);" id="anchor_subscribe_{$value.record.user_id}" onclick="get_subscription_options({$value.record.user_id}, -160, -30, 'anchor_subscribe_{$value.record.user_id}');">{$LANG.common_subscriptions}</a>
                                    </p>
                            </div>
                    </div>
                  </li>
                 </ul>
              </td>
            {if $value.end_tr}
                  </tr>
            {/if}
        {/foreach}
        {if $myobj->mem_last_tr_close}
                {section name=foo start=0 loop=$myobj->mem_user_per_row step=1}
                        <td>&nbsp;</td>
                {/section}
              </tr>
        {/if}
          </table>
     {else}
	    <div id="selMsgAlert"><p>{$LANG.common_no_subscribed_members_found}</p></div>
     {/if}
        </div>
{/if}

{if $myobj->isShowPageBlock('category_subscription')}
	<div>
        {include file='../general/information.tpl'}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='form_top'}
	  <p class="clsNoteMessange"><span>{$LANG.common_note}:&nbsp;</span>{$LANG.common_subscription_note_category_msg}</p>
        <form name="form_categorysubscription" id="form_categorysubscription" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
          <table class="clsFormSection clsMySubscitpionFilter">
            <tr class="clsFormRow"{$myobj->display_category_module}>
              <td class="{$myobj->getCSSFormFieldCellClass('sub_module')}">
                   <label for="sub_module">{$LANG.mysubscription_field_module}</label>
              </td>
              <td class="{$myobj->getCSSFormFieldCellClass('sub_module')}">
                   <select name="sub_module" id="sub_module" tabindex="{smartyTabIndex}" onchange="getCategoriesForSubscription(this.value);">
                    <option value="">{$LANG.common_select_option}</option>
                    {foreach item=cat_module from=$myobj->sub_module_arr}
                  	<option value="{$cat_module}"{if $cat_module==$myobj->getFormField('sub_module')} selected="selected"{/if}>{$cat_module|capitalize}</option>
                    {/foreach}
                   </select>
                {$myobj->getFormFieldErrorTip('sub_module')}
              {$myobj->ShowHelpTip('subscription_module', 'sub_module')}
              </td>
              </tr>

            <tr class="clsFormRow">
              <td class="{$myobj->getCSSFormFieldCellClass('category_id')}">
                   <label for="category_id">{$LANG.mysubscription_field_category}</label>
              </td>
              <td class="{$myobj->getCSSFormFieldCellClass('category_id')}" id="category_container">
                   <select name="category_id" id="category_id" tabindex="{smartyTabIndex}">
                     <option value="">{$LANG.common_select_option}</option>
                   </select>
              {$myobj->getFormFieldErrorTip('category_id')}
              {$myobj->ShowHelpTip('subscription_category', 'category_id')}
              </td>
              </tr>

            <tr class="clsFormRow">
              <td class="{$myobj->getCSSFormFieldCellClass('sub_category_id')}">
                   <label for="sub_category_id">{$LANG.mysubscription_field_sub_category}</label>
              </td>
              <td class="{$myobj->getCSSFormFieldCellClass('sub_category_id')}" id="sub_category_container">
                   <select name="sub_category_id" id="sub_category_id" tabindex="{smartyTabIndex}">
                     <option value="">{$LANG.common_select_option}</option>
                   </select>
                    {$myobj->getFormFieldErrorTip('sub_category_id')}
                    {$myobj->ShowHelpTip('subscription_sub_category', 'sub_category')}
              </td>
              </tr>

            <tr class="clsFormRow">
              <td class="{$myobj->getCSSFormFieldCellClass('default')}">
			{if $myobj->display_category_module != ''}
	                <input type="hidden" name="sub_module" id="sub_module" value="{$myobj->category_module}" />
                  {/if}
                <input type="hidden" name="pg" id="pg" value="{$myobj->getFormField('pg')}" />
                <input type="hidden" name="sub_type" id="sub_type" value="Category" />
                <input type="submit" class="clsSubmitButton" name="category_submit" id="category_submit" tabindex="{smartyTabIndex}" value="{$LANG.mysubscription_subscribe}" />
                <input type="submit" class="clsSubmitButton" name="category_cancel" id="category_cancel" tabindex="{smartyTabIndex}" value="{$LANG.mysubscription_cancel}" />
              </td>
            </tr>
            </table>
        </form>
	  {if $myobj->display_category_module != ''}
           {literal}
		  <script type="text/javascript">
		  //Event.observe(window, 'load', function() {
		  $Jq(document).ready(function(){
			getCategoriesForSubscription('{/literal}{$myobj->category_module}{literal}');
		    });
              </script>
           {/literal}
        {/if}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='form_bottom'}
    </div>
        <div>
            <div class="clsOverflow">
              <div class="clsSubscriptionTitleLeft">
                  <h3>{$LANG.mysubscription_list_subscriptions}</h3>
               </div>
               <div class="clsSubscriptionTitleRight"{$myobj->display_category_module}><select name="category_module" id="category_module" tabindex="{smartyTabIndex}" onchange="Redirect2URL(this.value)">
                     <option value="">{$LANG.common_select_option}</option>
                        {foreach item=cat_filter from=$myobj->category_filter_arr}
                        <option value="{$cat_filter.url}"{if $cat_filter.display_val==$myobj->getFormField('category_module')} selected="selected"{/if}>{$cat_filter.display_val|capitalize}</option>
                        {/foreach}
                   </select>
             </div>
              </div>
             {if $myobj->getFormField('category_module') != ''}
                    {$myobj->populateSubscribedCategories()}
             {/if}
         </div>
{/if}

{if $myobj->isShowPageBlock('tag_subscription')}
    <div>
        {include file='../general/information.tpl'}
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='form_top'}
	  <p class="clsNoteMessange"><span>{$LANG.common_note}:&nbsp;</span>{$LANG.common_subscription_note_tag_msg}</p>
        <form name="form_tagsubscription" id="form_tagsubscription" method="post" action="{$myobj->getCurrentUrl(false)}" autocomplete="off">
          <table class="clsFormSection clsMySubscitpionFilter">
            <tr class="clsFormRow"{$myobj->display_tag_module}>
              <td class="{$myobj->getCSSFormFieldCellClass('sub_module')}">
                   <label for="sub_module">{$LANG.mysubscription_field_module}</label>
              </td>
              <td class="{$myobj->getCSSFormFieldCellClass('sub_module')}">
                   <select name="sub_module" id="sub_module" tabindex="{smartyTabIndex}">
                     <option value="">{$LANG.common_select_option}</option>
                          {foreach item=cat_module from=$myobj->sub_module_arr}
                              <option value="{$cat_module}"{if $cat_module==$myobj->getFormField('sub_module')} selected="selected"{/if}>{$cat_module|capitalize}</option>
                          {/foreach}
                   </select>
                {$myobj->getFormFieldErrorTip('sub_module')}
                {$myobj->ShowHelpTip('subscription_module', 'sub_module')}
              </td>
              </tr>

            <tr class="clsFormRow">
              <td class="{$myobj->getCSSFormFieldCellClass('tag')}">
                   <label for="tag">{$LANG.mysubscription_field_tag}</label>
              </td>
              <td class="{$myobj->getCSSFormFieldCellClass('tag')}">
                   <input name="tag" id="tag" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('tag')}" />
                  {$myobj->getFormFieldErrorTip('tag')}
              	  {$myobj->ShowHelpTip('subscription_tag', 'tag')}
              </td>
              </tr>

            <tr class="clsFormRow">
              <td class="{$myobj->getCSSFormFieldCellClass('default')}">
			{if $myobj->display_tag_module != ''}
	                <input type="hidden" name="sub_module" id="sub_module" value="{$myobj->tag_module}" />
                  {/if}
                <input type="hidden" name="pg" id="pg" value="{$myobj->getFormField('pg')}" />
                <input type="hidden" name="sub_type" id="sub_type" value="Tag" />
                <input type="submit" class="clsSubmitButton" name="tag_submit" id="tag_submit" tabindex="{smartyTabIndex}" value="{$LANG.mysubscription_subscribe}" />
                <input type="submit" class="clsSubmitButton" name="tag_cancel" id="tag_cancel" tabindex="{smartyTabIndex}" value="{$LANG.mysubscription_cancel}" />
              </td>
            </tr>
            </table>
        </form>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='form_bottom'}
    </div>
	<div>
        <div class="clsOverflow">
        <div class="clsSubscriptionTitleLeft">
            <h3>{$LANG.mysubscription_list_subscriptions}</h3>
        </div>
        <div class="clsSubscriptionTitleRight"{$myobj->display_tag_module}>
           <select name="tag_module" id="tag_module" tabindex="{smartyTabIndex}" onchange="Redirect2URL(this.value)">
             <option value="">{$LANG.common_select_option}</option>
                {foreach item=tag_filter from=$myobj->tag_filter_arr}
                <option value="{$tag_filter.url}"{if $tag_filter.display_val==$myobj->getFormField('tag_module')} selected="selected"{/if}>{$tag_filter.display_val|capitalize}</option>
                {/foreach}
           </select>
         </div>
          </div>
           {if $myobj->getFormField('tag_module') != ''}
                {$myobj->populateSubscribedTags()}
         {/if}
     </div>

{/if}

</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}

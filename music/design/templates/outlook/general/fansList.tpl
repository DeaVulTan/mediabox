{$myobj->setTemplateFolder('general/', 'music')}
{include file='box.tpl' opt='display_top'}
<div id="selMembersBrowse" class="clsListTable">
    <div class="clsOverflow">
    <div class="clsListHeadingLeft">
		<h2><span>{$myobj->form_list_members.page_title}</span></h2>
    </div>

    </div>
   <div>
 {$myobj->setTemplateFolder('general/','music')}
  {include file='information.tpl'}

  <div id="selLeftNavigation">
{if $myobj->isShowPageBlock('form_list_members')}

         <div  id="advanced_search">
      	  {$myobj->setTemplateFolder('general/','music')}
            {include file='box.tpl' opt='form_top'}
            <form id="membersAdvancedFilters" name="membersAdvancedFilters" method="post" action="{$myobj->getCurrentUrl()}">
                <table class="clsAdvancedFilterTable">
                	<tr>
                		<th colspan="2">{$LANG.fanslist_search_filters}</th>
                	</tr>
                    <tr>
                      <td class="{$myobj->getCSSFormLabelCellClass('uname')}"><input type="text" class="clsTextBox" name="uname" id="uname" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('uname')}" onclick="if(this.value=='{$LANG.search_user_name}') this.value=''" onblur="if(this.value=='') this.value='{$LANG.search_user_name}'" />
                      </td>
                      <td class="{$myobj->getCSSFormLabelCellClass('country')}" colspan="2">
                            <select name="country" id="country" tabindex="{smartyTabIndex}">
                                {$myobj->populateCountriesList($myobj->getFormField('country'))}
                            </select>
                        </td>
                    </tr>

                     <tr>
                        <td colspan="2" align="right" valign="middle">
                             <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" name="avd_search" id="avd_search" value="Search" tabindex="{smartyTabIndex}"/></div></div>
                             <div class="clsCancelMargin clsCancelLeft"><div class="clsCancelRight"><input type="submit" name="search_reset" id="search_reset" value="{$LANG.members_list_browse_reset}" tabindex="{smartyTabIndex}" /></div></div>
                        </td>
                    </tr>
                </table>
            </form>
        {$myobj->setTemplateFolder('general/', 'music')}
        {include file='box.tpl' opt='form_bottom'}
        </div>
    {if $myobj->isResultsFound()}

         {if $CFG.admin.navigation.top}
			{$myobj->setTemplateFolder('general/','music')}
             {include file='pagination.tpl'}
         {/if}

		    <div id="selViewAllMembers" class="clsMemberListTable">
                      <table summary="{$LANG.member_list_tbl_summary}">
                      {foreach key=inc item=value from=$myobj->form_list_members.display_members}
                        {if $value.open_tr}
                        <tr>
                        {/if}
                      		<td id="selPhotoGallery">
                            <ul class="clsVideoListDisplay">
                            	<li id="memberlist_videoli_{$inc}">

                                <div class="clsThumbImageContainer clsMemberImageContainer">
                                        <div class="clsThumbImageContainer">
                                            <div class="clsThumbImageLink" id="selMemberName">
                                                <div  class="">
                                                    <div class="ClsImageContainer ClsImageBorder1 Cls90x90" {$value.profileIcon.t_attribute} id="memberlist_thumb_{$inc}">
                                                    	<a href="{$value.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls90x90">
                                                				<img border="0" src="{$value.profileIcon.t_url}" alt="{$value.record.user_name}" title="{$value.record.user_name}" /></a>
                                                    </div>
                                                </div>
                                                {$myobj->membersRelRayzz($value.record)}
                                            </div>
                                            <div class="clsMemberListThumbTitle">
		                                    	<a href="{$value.memberProfileUrl}" title="{$value.record.user_name}" alt="{$value.record.user_name}">{$value.record.user_name}</a>  {$value.userLink}
		                                    	<p>{$value.country}</p>
                                            </div>

                                        </div>
                                </div>
                             <div class="clsInfoPopUpContainerDiv clsDisplayNone" id="memberlist_clsInfoPopUpContainerDiv_{$inc}" onmouseover="hideVideoDetail(this)"></div>
                             <div class="clsInfoPopUp clsDisplayNone" id="memberlist_selVideoDetails_{$inc}">
                             	<div class="clsThumbImageContainer_inside" >
                                	<div class="clsThumbImageLink">
                                        <div onclick="Redirect2URL('{$value.memberProfileUrl}')" class="">
											<div class="ClsImageContainer ClsImageBorder1 Cls90x90 clsPointer">
                                            	<A href="{$value.memberProfileUrl}"class="ClsImageContainer ClsImageBorder1 Cls90x90 clsPointer">
														<img src="{$value.profileIcon.t_url}" alt="{$value.record.user_name}" title="{$value.record.user_name}" {$value.profileIcon.t_attribute} border="0" /></A>
											 </div>
                                         </div>

                                        </div>
                                    <div class="clsMemberListThumbTitle">
                                        <a href="{$value.memberProfileUrl}" title="{$value.record.user_name}" alt="{$value.record.user_name}">{$value.record.user_name}</a> {$value.userLink}
                                    <p>{$value.country}</p>
									</div>


                                    <a href="#" class="clsMemberInfo_inside"></a>
                                </div>

                             </div>
                             	</li>
                             </ul>

                          </td>
                        {if $value.end_tr}
	                        </tr>
                        {/if}
                    {/foreach}
                    {if $myobj->last_tr_close}
							{section name=foo start=0 loop=$myobj->user_per_row step=1}
	                    		<td>&nbsp;</td>
                            {/section}
	                    </tr>
                    {/if}
                      </table>
		 </div>
         {if $CFG.admin.navigation.bottom}
     		  {$myobj->setTemplateFolder('general/','music')}
              {include file='pagination.tpl'}
         {/if}

		{if $myobj->showRelatedTags}
		        <div id="selRelatedTags"> <span>{$LANG.members_list_related_tags}:&nbsp;</span>
                {foreach key=inc item=value from=$myobj->form_list_members.related_tags}
					<span><a href="{$myobj->tagListUrl}?tags={$value.tags}" title="{$value.tags}" >{$value.tags}</a></span>
                {/foreach}
                </div>
		{/if}
    {else}
    	<div id="selMsgError">{$LANG.msg_no_records}</div>
	{/if}
{/if}
  </div>
</div>
{$myobj->setTemplateFolder('general/', 'music')}
{include file='box.tpl' opt='display_bottom'}

<script type="text/javascript" language="javascript" src="{$CFG.site.url}js/videoDetailsToolTip.js"></script>
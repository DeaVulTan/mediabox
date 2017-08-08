{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selManageFriends">
	<div class="clsPageHeading"><h2>{$LANG.managerelations_title}&nbsp;-&nbsp;<a href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.managerelations_title_invite}</a></h2></div>
<div class="clsNoteMessage">
   <span class="clsNoteTitle">{$LANG.managerelations_note}</span>:&nbsp;{$LANG.managerelations_info}
</div>
 	<div id="selTwoColumn">
    	<div id="selLeftNavigation">
			{include file='../general/information.tpl'}
			{if $myobj->isShowPageBlock('msg_form_info')}
				<div id="selMsgAlert">
					<p>{$LANG.msg_no_friends}</p>
					<p>{$LANG.managerelations_link_add_friends_start}&nbsp;<a href="{$myobj->getUrl('membersinvite', '', '', 'members')}">{$LANG.managerelations_link_add_friends_text}</a>&nbsp;{$LANG.managerelations_link_add_friends_end}</p>
				</div>
			{/if}

			{if $myobj->isShowPageBlock('form_search_friend')}
				<div id="selFriendSearch" class="clsListTable clsFriendSearchTable">
			        {*include file='box.tpl' opt='form_top'*}
					<form name="formFriendSearch" id="formFriendSearch" method="post" action="{$myobj->getUrl('relationmanage', '', '', 'members')}">
						<table summary="{$LANG.managerelations_search_table}" class="clsFriendsSearchTable">
							<tr>
								<td><label for="uname">{$LANG.common_username}</label></td>
								<td><label for="email">{$LANG.managerelations_search_email}</label></td>
								<td><label for="tagz">{$LANG.managerelations_search_tags}</label></td>
								<td rowspan="2" style="vertical-align:bottom"><div class="clsListSubmitLeft"><div class="clsListSubmitRight"><input type="submit" class="clsSubmitButton" value="search" name="friendSearch" tabindex="{smartyTabIndex}"/></div></div></td>
							</tr>
							<tr>
								<td><input type="text" class="clsFriendsTextBox" name="uname" id="uname" value="{$myobj->getFormField('uname')}"  tabindex="{smartyTabIndex}" maxlength="{$CFG.fieldsize.username.max}"/></td>
								<td><input type="text" class="clsFriendsTextBox" name="email" id="email" value="{$myobj->getFormField('email')}" tabindex="{smartyTabIndex}"/></td>
								<td><input type="text" class="clsFriendsTextBox" name="tagz" id="tagz" value="{$myobj->getFormField('tagz')}" tabindex="{smartyTabIndex}"/></td>
							</tr>
							<tr>
								<td colspan="4"><label for="srch_relation">{$LANG.managerelations_search_relation}</label></td>
							</tr>
							<tr>
								<td colspan="4">
									<select id="srch_relation" name="srch_relation" tabindex="{smartyTabIndex}">
										<option value="">{$LANG.managerelations_select_relation}</option>
			                        	{$myobj->populateRelations($myobj->getFormField('srch_relation'))}
			                        </select>
								</td>
							</tr>
						</table>
					</form>
			        {*include file='box.tpl' opt='form_bottom'*}
				</div>
			{/if}

			{if $myobj->isShowPageBlock('form_list_friends')}
			    {if $myobj->form_list_friends.totalFriends}

					<div id="selPomptDialog" title="{$CFG.site.name}" style="display:none;">
						<form>
							<label for="name">{$LANG.managerelations_javascript_new_relation}</label>
							<input type="text" name="newRelation" id="newRelation" class="text ui-widget-content ui-corner-all" />
						</form>
					</div>

			        {if $CFG.admin.navigation.top}
					   {if $smarty_paging_list}
						 <div class="clsTopPagination">{include file='../general/pagination.tpl'}</div>
					   {/if}			           
			        {/if}
                     {assign var=count value=1}
			        <div id="selShowFriends" class="clsDataTable clsMembersDataTable">
			            <form name="form_show_friends" id="selShowFriends" method="post" action="{$myobj->getUrl('relationmanage', '', '', 'members')}" autocomplete="off">
			                <table border="0" summary="{$LANG.managerelations_tbl_summary}">
			                    <tr>
			                        <th class="clsAlignCenter"><input type="checkbox" class="clsCheckRadio" id="checkall" onclick="selectAll(this.form)" name="checkall" value="" tabindex="{smartyTabIndex}" /></th>
			                        <th>{$LANG.managerelations_friend_name}</th>
			                        <th>{$LANG.managerelations_relation_name}</th>
			                        <th>{$LANG.managerelations_action}</th>
			                    </tr>
			                    {foreach item=dmfValue from=$displayMyFriends_arr.row}
			                        <tr class="{$myobj->getCSSRowClass()} {if $count % 2 == 0} clsAlternateRecord{/if}">
			                            <td class="clsFriendsCheckbox"><input type="checkbox" class="clsCheckRadio" name="friendship_ids[]" value="{$dmfValue.record.friendship_id}" tabindex="{smartyTabIndex}"  onClick="checkCheckBox(this.form, 'checkall');"/></td>
			                            <td id="selPhotoGallery" class="clsFriendsNameWidth">
			                                <div class="clsOverflow">
												<p id="selImageBorder" class="clsViewThumbImage">
			                                		<div class="clsThumbImageContainer clsMemberImageContainer">
			                                			<div class="clsThumbImageContainer">
			                                    			<a class="ClsImageContainer ClsImageBorder2 Cls45x45" href="{$dmfValue.friendProfileUrl}">
						                                		<img src="{$dmfValue.icon.s_url}" alt="{$dmfValue.record.friend_name|truncate:5}" {$myobj->DISP_IMAGE(45, 45, $dmfValue.icon.s_width, $dmfValue.icon.s_height)}/>
															</a>
			                                        	</div>
			                                        </div>
			                                	</p>
											</div>
			                                <p id="selMemberName" class="clsGroupSmallImg"><a href="{$dmfValue.friendProfileUrl}">{$dmfValue.record.friend_name}</a></p>
			                            </td>
			                            <td class="clsFriendsRelation">
			                                {$dmfValue.record.relation_name}
			                            </td>
			                            <td><!--if(this.value.length>0)-->
			                                <select name="singleSelect[]" onchange="submit()">
			                                	<option value="" style="text-align:center">-Manage-&nbsp;&nbsp;</option>
			                                    {$myobj->populateMoveToRelations($dmfValue.record.friendship_id, $dmfValue.relation)}
			                                </select>
			                            </td>
				                    </tr>
									{assign var=count value=$count+1}
			                    {/foreach}
			                    <tr>
			                    	<td></td>
			                        <td colspan="3" class="{$myobj->getCSSFormFieldCellClass('relation_id')}">
			                            <div class="clsMailSelectBox"><select name="relation_id" id="relation_id" onchange="addNewRelation(this)" tabindex="{smartyTabIndex}">
			                                <option value="">{$LANG.managerelations_select_relation}&nbsp;&nbsp;</option>
			                                {$myobj->populateRelations($myobj->getFormField('relation_id'))}
			                                <optgroup label="{$LANG.managerelations_new_relation_optgroup}"></optgroup>
			                                <option value="add">{$LANG.managerelations_new_relation}</option>
			                            </select>{$myobj->getFormFieldErrorTip('relation_id')}</div>
			                            <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="managerelations_submit" id="managerelations_submit" value="{$LANG.managerelations_submit}" tabindex="{smartyTabIndex}" onClick="if(!getMultiCheckBoxValue('form_show_friends', 'check_all', '{$LANG.managerelations_select_friends}'))  {literal} { {/literal}  return false;  {literal} } {/literal} if(!document.form_show_friends.relation_id.value) {literal} { {/literal} alert_manual('{$LANG.managerelations_select_relation}'); return false; {literal} } {/literal}"/></div></div>

			                        </td>
			                    </tr>
			                </table>
			                <input type="hidden" name="new_relation" id="new_relation" value="{$myobj->getFormField('new_relation')}" />
			                <input type="hidden" name="uname" id="uname" value="{$myobj->getFormField('uname')}" />
			                <input type="hidden" name="email" id="email" value="{$myobj->getFormField('email')}" />
			                <input type="hidden" name="search_enable" id="search_enable" value="{$myobj->getFormField('search_enable')}" />
			                <input type="hidden" name="tagz" id="tagz" value="{$myobj->getFormField('tagz')}" />
			            </form>
				        {literal}
				            <script type="text/javascript">
				            	var index = document.form_show_friends.relation_id.options.length;
				            </script>
				        {/literal}
			        </div>

			        {if $CFG.admin.navigation.bottom}
					{if $smarty_paging_list}
					  <div class="clsPaddingRightBottom">
						 {include file='../general/pagination.tpl'}
					  </div>	
					{/if}  			            
			        {/if}
			    {else}
			        <div id="selMsgError">
			            <p>{$LANG.managerelations_search_msg_no_records}</p>
			        </div>
			    {/if}
			{/if}
		</div>
	</div>
</div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
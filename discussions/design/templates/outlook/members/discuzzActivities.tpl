{foreach item=discussionValue from=$discussionsActivity_arr}
      <tr>
	  	<td>
			<div class='{$discussionValue.iconClassName}'>
				<div class=" clsActivityContainer clsClearFix">
					<div class="clsActivityImage">{$myobj->displayProfileImage($discussionValue.user_details_arr, 'tiny' , $CFG.admin.discussions.showpopup)}</div>
					<div class="clsActivityDescription">{$discussionValue.content}
					| <span>{$discussionValue.activity_added}</span>
					</div>
				</div>
			</div>
		</td>
      </tr>
{foreachelse}
	<div class="clsNoRecords">{$LANG.no_recent_activities}</div>
{/foreach}
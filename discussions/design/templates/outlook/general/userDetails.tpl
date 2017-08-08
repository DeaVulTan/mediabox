<div class="clsUserPopUpTop">
  <div class="clsUserPopUpMiddle">
    <div class="clsUserPopUpBottom">
      <div class="{$myobj->userdetails_arr.userLevelClass} clsUserPopUpDetails">
        <div class="clsInline">
          <p class="clsUserName clsOtherInfo"><a href="{$myobj->userdetails_arr.user_mysolutions_url}">{$myobj->userdetails_arr.user_display_uname}</a></p>
          {if $myobj->CFG.admin.user_levels.allowed}

          {/if}
		  {if chkIsAllowedModule(array('mail'))}
	          <p class="clsSendMessage clsOtherInfi"><a href="{$myobj->userdetails_arr.user_compose_url}">{$LANG.discuzz_common_send_message}</a></p>
          {/if}
        </div>
        <div class="clsInline">

		  <p class="clsOtherInfo">{$LANG.discuzz_common_total_points} <span class="clsNumbers">{$myobj->userdetails_arr.userLog_total_points}</span></p>

          {if $myobj->userdetails_arr.userLog_total_solution neq 0}
		  	<p class="clsOtherInfo">{$LANG.user_details_total_solutions} <a href="{$myobj->userdetails_arr.user_boards_ans_url}"><span class="clsTotalNumbers">{$myobj->userdetails_arr.userLog_total_solution}</span></a></p>
          {else}
		  	<p class="clsOtherInfo">{$LANG.user_details_total_solutions} <span class="clsTotalNumbers">{$myobj->userdetails_arr.userLog_total_solution}</span></p>
          {/if}
          {if $myobj->CFG.admin.best_solutions.allowed}
			  {if $myobj->userdetails_arr.bestAnspercentage neq 0}
			  	<p class="clsOtherInfo">{$LANG.best_solution_percentage} <a href="{$myobj->userdetails_arr.user_boards_bestans_url}"><span class="clsTotalNumbers">{$myobj->userdetails_arr.bestAnspercentage}</span></a>%</p>
			  {else}
				<p class="clsOtherInfo">{$LANG.best_solution_percentage} <span class="clsTotalNumbers">{$myobj->userdetails_arr.bestAnspercentage}%</span></p>
			  {/if}
		  {/if}
		</div>
     	<div class="clsInline">
     		{if $myobj->userdetails_arr.userLog_total_board neq 0}
				<p class="clsOtherInfo">{$LANG.discuzz_common_board_asked} <a href="{$myobj->userdetails_arr.user_boards_ques_url}"><span class="clsTotalNumbers">{$myobj->userdetails_arr.userLog_total_board}</span></a></p>
			{else}
				<p class="clsOtherInfo">{$LANG.discuzz_common_board_asked} <span class="clsTotalNumbers">{$myobj->userdetails_arr.userLog_total_board}</span></p>
			{/if}
        </div>
      </div>
    </div>
  </div>
</div>
 {assign var='classspan' value='yes'}
			{assign var='bdrclass' value=''}

	{include file='../general/information.tpl'}
	{if $myobj->isShowPageBlock('form_board') OR $myobj->isShowPageBlock('form_solutions') OR $myobj->isShowPageBlock('form_add')}
    <div id="selDelMsgConfirm" class="selMsgConfirm" style="display:none;">
  <form name="formDelConfirm" id="formDelConfirm" method="post" action="{$myobj->getCurrentUrl(true)}">
        <p id="confirmDelMessage"></p>
        <table summary="{$LANG.container_to_get_confirmation}">
      <tr>
            <td><input type="button" class="clsSubmitButton" name="confirm_del_action" id="confirm_del_action" value="{$LANG.discuzz_common_yes_option}" tabindex="{smartyTabIndex}" onClick="hideAllBlocks(); doRemoveAction();"/>
          &nbsp;
          <input type="button" class="clsCancelButton" name="del_cancel" id="del_cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
        </td>
          </tr>
    </table>
        {$myobj->populateHidden($myobj->confirm.hidden_arr1)}
      </form>
</div>
    <div id="selDelAttachconfirm" class="clsPopupConfirmation" style="display:none;">
  <form name="msgAttachConfirmform" id="msgAttachConfirmform" method="post" action="{$myobj->confirm.form_action}">
        <p id="msgAttachConfirmText"></p>
        <p class="clsCenter">
      <input type="button" class="clsPopupsubmit" name="confirm" id="confirm" onclick="deleteSolutionAttachments('{$myobj->confirm.onclick_url}', '&amp;ajax_page=true&amp;deletemoreattachments=1');chkLimit(); return hideAllBlocks();" value="{$LANG.discuzz_common_yes_option}" tabindex="{smartyTabIndex}" />
      &nbsp;
      <input type="button" class="clsPopupcancel" name="no" id="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
      <input type="hidden" name="attach_id" id="attach_id" />
      <input type="hidden" name="attach_content_id" id="attach_content_id" />
      <input type="hidden" name="attach_name" id="attach_name" />
      <input type="hidden" name="act" id="act" />
      {$myobj->populateHidden($myobj->confirm.hidden_arr2)} </p>
      </form>
</div>
    {/if}

{if $myobj->isShowPageBlock('form_board') OR $myobj->isShowPageBlock('form_solutions')}
<!-- Confirmation Div -->
<div id="selMsgConfirm" class="selMsgConfirm" style="display:none;">
  <form name="formConfirm" id="formConfirm" method="post" action="{$myobj->getCurrentUrl(true)}">
    <p id="confirmMessage"></p>
    <p class="clsCenter">
      <input type="submit" class="clsPopupsubmit" name="confirm_action" id="confirm_action" value="{$LANG.discuzz_common_yes_option}" tabindex="{smartyTabIndex}" />
      <input type="button" class="clsPopupcancel" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks();" />
      {$myobj->populateHidden($myobj->confirm.hidden_arr1)} </p>
  </form>
</div>
<!-- Confirmation Div -->
<div id="selMsgAbuseConfirm" class="selMsgAbuseConfirm" style="display:none;">
  <form class="clsCenter" name="formAbuseConfirm" id="formAbuseConfirm" method="post" action="{$myobj->getCurrentUrl(true)}">
    <p id="confirmAbuseMessage" class="clsReportAbuseHeading"></p>
    <p>{$LANG.discuzz_common_reason}</p>
    <p>
      <textarea name="reason" class="clsReportAbuseTextArea" id="reason" cols="23" rows="5" tabindex="{smartyTabIndex}">{$myobj->getFormField('reason')}</textarea>
    </p>
    <span id="validReason" class="LV_validation_message LV_invalid"></span>
    <p>
      <input type="submit" class="clsPopupsubmit" name="confirm_action" id="confirm_action" value="{$LANG.discuzz_common_yes_option}" tabindex="{smartyTabIndex}" onClick="return chkIsAbuseReasonExists();" />
      <input type="button" class="clsPopupcancel" name="cancel" id="cancel" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onClick="removeReasonErrors(); return hideAllBlocks();" />
    </p>
    {$myobj->populateHidden($myobj->confirm.hidden_arr)}
  </form>
</div>
{/if}
<!-- Board details block -->
{if $myobj->isShowPageBlock('form_board')}

<!-- Header search area ends here -->
<!-- Board details area -->
<div class="clsCommonIndexRoundedCorner">
{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_top'}
<!-- tabs start -->
<div class="clsBoardsLink">
  <div class="clsFloatLeft clsSolutionBoard">
    <h3> {$myobj->navigation_details.board_title_manual} </h3>
  </div>
  <div class="clsFloatRight">
    <div class="clsSolnPrevNext clsClearFix"> {$myobj->showAnotherBoard()}{$myobj->showAnotherBoard(1)} </div>
    <div class="clsSolutionViews"> <span>{$LANG.solutions_views}: </span>
      <p class="clsSolutionViewimage"><span class="clsBold">{$myobj->board_details.total_views}</span></p>
    </div>
  </div>
</div>
<table summary="{$LANG.board_details_tbl}" class="clsSolutionTable">
  <tr class="">
    <td><table class="clsSolutionFirstColTable">
        <tr class="clsViewBestRow">
          <td class="clsSolutionFirtCol"><div class="clsClearFix clsSolutionFirtblock">
              <div class="clsSolnUserimage">
			  	 {if isUserImageAllowed()}
                	{*{$myobj->displayProfileImage($myobj->board_details, 'small', $CFG.admin.discussions.showpopup)}*}
                	<a href="{$myobj->form_board.displayBoardDetails_arr.mysolutions.url}"><img src="{$myobj->form_board.displayBoardDetails_arr.member_image.s_url}" border="0" alt="{$myobj->form_board.displayBoardDetails_arr.asked_by_manual|truncate:2}" title="{$myobj->form_board.displayBoardDetails_arr.asked_by_manual}"  {$myobj->DISP_IMAGE(45, 45, $myobj->form_board.displayBoardDetails_arr.member_image.s_width, $myobj->form_board.displayBoardDetails_arr.member_image.s_height)}/></a>
                {/if}
			  </div>
              <div class="clsSolnUserdetail">
                <p class="clsSolnUserInfo"> <span class="clsSolnUserName"> <a href="{$myobj->form_board.displayBoardDetails_arr.mysolutions.url}">{$myobj->form_board.displayBoardDetails_arr.asked_by_manual}</a></span> </p>
                <p class="clsSolnUserInfo">{$LANG.discuzz_common_solutions}: <span class="clsValue">{$myobj->form_board.displayBoardDetails_arr.total_posts}</span></p>
                <p class="clsSolnUserJoinedInfo clsDateFixedWidth">{$LANG.solutions_joined_on}: <span class="clsValue">{$myobj->form_board.displayBoardDetails_arr.user_doj}</span></p>
              </div>
            </div>
            <div class="clsClearFix"> {if $myobj->board_details.best_solution_id}
              <div class="clsViewBestSoln"> <a href="{$myobj->best_nav.url}">{$LANG.solutions_view_best}</a> </div>
              {/if}
              <div class="clsReplayBtnContainer">
                <p class="clsAddSolnBtn"> {if isMember()} <a href="#" onClick="showQuickSolutionDiv({$myobj->getFormField('qid')}); return false;">{$LANG.solutions_add}<br />
                  {$LANG.solutions_add_solution}</a> {else} <a href="{$myobj->form_board.displayBoardDetails_arr.solution_reply.url}">{$LANG.solutions_add}<br />
                  {$LANG.solutions_add_solution}</a> {/if} </p>
              </div>
            </div></td>
          <td class="clsSolutionSecondCol">
          	<div class="">
              <div class="clsReplayHeading">
                <div>
                  <p class="clsQuestionBox">{$myobj->board_details.board_wrap}</p>
                  <!--rating starts-->
                  <div>
                    <!-- Board ratings -->
                    {if $myobj->CFG.admin.board.ratings}
                    {* ---------------DISPLAYING RATING FORM BEGINS--------------------------*}
                    <div class="clsSharePhotoHeadingRight"> {if $myobj->chkAllowBoardRating()}
                      <div id="ratingForm">
                        <!-- <p class="clsRateThisHd"> {$LANG.discuzz_rate_this_label}:</p>-->
                        {assign var=tooltip value=""}
                        {if !isLoggedIn()}
                        {$discussion->populateBoardRatingImages($myobj->board_rating, 'board',$LANG.discuzz_login_message, '#', 'discussions')}
                        {assign var=tooltip value=$LANG.discuzz_login_message}
                        {else}
                        <div id="selRatingPhoto" class="clsBoardRating clsDiscuszzBoardRating clsOverflow"> {if isMember() and $myobj->rankUsersRayzz}
                          {$myobj->populateBoardRatingImagesForAjax($myobj->board_rating, 'discussion')}
                          {else}
                          {$discussion->populateBoardRatingImages($myobj->board_rating, 'board', $LANG.discuzz_rate_yourself, '#', 'discussions')}
                          {assign var=tooltip value=$LANG.discuzz_rate_yourself}
                          {/if}
                          &nbsp;(<span> {$myobj->getFormField('board_rating_count')} </span>) </div>
                        {/if}
                        <script type="text/javascript">
                                                  {literal}
                                                  $Jq(document).ready(function(){
                                                    $Jq('#ratingLink').attr('title','{/literal}{$tooltip}{literal}');
                                                    $Jq('#ratingLink').tooltip({
                                                                            track: true,
                                                                            delay: 0,
                                                                            showURL: false,
                                                                            showBody: " - ",
                                                                            extraClass: "clsToolTip",
                                                                            top: -10
                                                                        });
                                                        });
                                                    {/literal}
                                              </script>
                      </div>
                      {/if} </div>
                    {* -------------- DISPLAYING RATING FORM ENDS------------------------*}
                    {/if}
                    <!-- ends Board ratings -->
                  </div>
                  <!--rating ends-->
                  <div class="clsQuestionPost clsClearFix">
                    <div class="clsSolnPostLeft"> {$LANG.solutions_posted_on} <span class="clsQuestionPostDate">{$myobj->board_details.date_posted}</span> </div>
                    <div class="clsSonPostRight">
                      <div class="clsOption"> <span class="clsOptionLink"><a onclick="showHideOptions('showhideoptions','optionList');">{$LANG.solutions_options}</a></span>
                        <div id="showhideoptions" class="clsOptionList" style="display: none;">
                          <!-- Additional links -->
                          <ul class="clsMisNavSubLink" id="optionList">
                            {if $CFG.admin.abuse_boards.allowed AND $myobj->board_details.user_id != $CFG.user.user_id}
                            {if isMember()}
                            {if $myobj->chkIsBoardAbusedAlready($myobj->getFormField('qid'))}
                            <li><a class="clsNoLink" href="{$myobj->form_board.displayBoardDetails_arr.solution.url}" onClick="return false;">{$LANG.discuzz_common_abused}</a></li>
                            {else}
                            {if $myobj->isAllowedToAsk($myobj->board_details.user_id)}
                            <li><a href="{$myobj->form_board.displayBoardDetails_arr.solution.url}" onClick="abuseContent('abuseboard', '{$myobj->getFormField('qid')}', '{$myobj->form_board.displayBoardDetails_arr.anchor}', '{$LANG.confirm_abuse_board_message}'); return false;">{$LANG.report_abuse}</a></li>
                            {else}
                            <li><a href="" onclick="alert_manual('{$LANG.info_not_allowed_to_abuse_board}');return false;">{$LANG.report_abuse}</a></li>
                            {/if}
                            {/if}
                            {else}
                            <li><a href="{$myobj->form_board.displayBoardDetails_arr.login_solution_member.url}">{$LANG.report_abuse}</a></li>
                            {/if}
                            {/if}
                            {if $CFG.admin.email_to_friend.allowed}
                            {if isMember()}
                            <li> <span><a onclick="showShareDiv('{$myobj->form_board.displayBoardDetails_arr.email_solutions.url}')" title="{$LANG.viewphoto_share_photo}">{$LANG.discuzz_common_email_to_friends}</a> </span></li>
                            {else}
                            <li><a href="{$myobj->form_board.displayBoardDetails_arr.login_solution_member.url}">{$LANG.discuzz_common_email_to_friends}</a></li>
                            {/if}
                            {/if}

                            {if $CFG.admin.favorite_soultion.allowed}
                            <li id="selShowFavoriteText_Board_{$myobj->getFormField('qid')}"> {if isMember()}
                              {if $myobj->isFavoriteContent($myobj->getFormField('qid'), 'Board')} <a class="clsFavourite" href="{$myobj->form_board.displayBoardDetails_arr.solution_member.url}" onClick="toggleFavorites('{$myobj->form_board.displayBoardDetails_arr.favorite_solutions.url}', 'cid={$myobj->getFormField('qid')}&amp;ctype=Board', 'selShowFavoriteText_Board_{$myobj->getFormField('qid')}'); return false;">{$LANG.solutions_remove_favorites}</a> {else} <a class="clsFavourite" href="{$myobj->form_board.displayBoardDetails_arr.solution_member.url}" onClick="toggleFavorites('{$myobj->form_board.displayBoardDetails_arr.favorite_solutions.url}', 'cid={$myobj->getFormField('qid')}&amp;ctype=Board', 'selShowFavoriteText_Board_{$myobj->getFormField('qid')}'); return false;">{$LANG.solutions_add_to_favorites}</a> {/if}
                              {else} <a id="addtofavourties" href="{$myobj->form_board.displayBoardDetails_arr.login_solution_member.url}">{$LANG.solutions_add_to_favorites}</a> {/if} </li>
                            {/if}
                            {if $myobj->board_details.user_id == $CFG.user.user_id}
                            {if $CFG.admin.board.edit}
                            <li><a href="{$myobj->form_board.displayBoardDetails_arr.boards_member.url}">{$LANG.common_edit}</a></li>
                            {/if}
                            {if $CFG.admin.board.delete}
                            <li><a href="{$myobj->form_board.displayBoardDetails_arr.solution.url}" onClick="doActionOnBoard('delete', '{$myobj->form_board.displayBoardDetails_arr.anchor}', '{$LANG.confirm_delete_message}'); return false;">{$LANG.discuzz_common_delete}</a></li>
                            {/if}
                            {/if}
                          </ul>
                          <!-- Additional links ends-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <p class="clsQuestionDescription">{$myobj->form_board.displayBoardDetails_arr.description_manual}</p>
              </div>
            </div>
            <!--start attachment-->
            <div id="allAttachments">
              <div class="clsReplies"> {if $myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments}
                <div class="clsViewReplies clsClearFix"> {foreach key=fAqkey item=fAqvalue  from=$myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments}
                  {if (in_array($fAqvalue.extern, $CFG.admin.attachments.image_formats))}
                  <div class="cls90x90thumbImage clsThumbImageOuter clsAttachContainer clsPointer">
                    <div class="clsThumbImageMiddle">
                      <div class="clsThumbImageInner"> <a href="{$fAqvalue.attachment_path}" id="attachmentcontent{$fAqvalue.attachment_id}" rel="gallery['{$fAqvalue.gallery}']" ><img src="{$fAqvalue.image_path}" alt="" /></a> {literal}
                        <script>
                                                    $Jq(document).ready(function() {

                                                                    $Jq('#attachmentcontent'+{/literal}{$fAqvalue.attachment_id}{literal}).fancybox({
                                                                        'width'				: 815,
                                                                        'height'			: 620,
                                                                        'padding'			:  0,
                                                                        'autoScale'     	: false,
                                                                        'transitionIn'		: 'none',
                                                                        'transitionOut'		: 'none',
                                                                        'type'				: 'iframe',
																		'text-align'		: 'center'
                                                                    });
                                                     });
                                                    </script>
                        {/literal} </div>
                    </div>
                  </div>
                  {/if}
                  {/foreach}
                  {foreach key=fAqkey item=fAqvalue  from=$myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments}
                  <ul>
                    {if (!in_array($fAqvalue.extern, $CFG.admin.attachments.image_formats))}
                    <li class="clsDocText"><a href="{$fAqvalue.attachment_original_path}" target="_blank">{$fAqvalue.attachment_name}</a></li>
                    {/if}
                  </ul>
                  {/foreach} </div>
                {/if} </div>
            </div>
            <!--end attachments -->
            {if 0 AND $myobj->form_board.displayBoardDetails_arr.boardBadgeUrl}
            <div id="selBoardBadgeEmbed">
              <p class="meta clsMetaScript">{$myobj->form_board.displayBoardDetails_arr.solutions_badge_embed_hint}</p>
              <p>
                <input type="text" class="clsBadgeTextBox" size="85" value='{$myobj->form_board.displayBoardDetails_arr.boardBadgeUrl}' READONLY onclick="this.select()" />
              </p>
            </div>
            <p id="badgeText"></p>
            {/if}
            {*if $myobj->CFG.admin.board.bookmarking AND $myobj->CFG.admin.board.addthis*}
            {*$myobj->addThisOption()*}
            {*/if*}
            <!-- Quick solution form starts -->
            <div id="quickSolutionId_{$myobj->getFormField('qid')}" class="clsQuickSolution" {if !$myobj->isShowPageBlock('block_msg_form_error')} style="display:none;" {else}style="display:block;"{/if} >
              <h2>Quick Solution</h2>
              <form name="quicksolutionfrm" id="quicksolutionfrm" method="post" action="{$myobj->solutions_Url}">
                <div>
                  <script>edToolbar('solution'); </script>
                  <textarea name="solution" id="solution" class="{$myobj->getCSSFormFieldElementClass('solution')} clsSolnTextArea selInputLimiter" cols="23" rows="5" tabindex="{smartyTabIndex}" maxlength="{$CFG.admin.quick_solutions.limit}" maxlimit="{$CFG.admin.quick_solutions.limit}">{$myobj->getFormField('solution')}</textarea>
                  {$myobj->getFormFieldElementErrorTip('solution')} </div>
                <div class="clsClearFix">
                  <p class="clsQuickSubmit"><span>
                    <input type="submit" name="solution_submit" id="submit" tabindex="{smartyTabIndex}" value="{$LANG.add_solution}" onclick="return updatelengthMine(this.form.solution);" />
                    </span></p>
                  <p class="clsGoSubmit"><span>
                    <input type="button" name="advanced_solution" id="advanced_solution" tabindex="{smartyTabIndex}" value="{$LANG.go_advanced}" onclick="location.href='{$myobj->form_board.displayBoardDetails_arr.solution_reply.url}'" />
                    </span></p>
                </div>
              </form>
            </div>
            <!-- Quick solution form ends -->
          </td>
        </tr>
      </table></td>
  </tr>
  <!-- Ends Board detail area -->
  {/if}
  <!-- Ends Board details block -->
  {if $myobj->isShowPageBlock('form_solutions')}
  {if $myobj->isResultsFound()}
  <tr>
    <td><div class="clsClearFix clsSolutionBox">
        <p class=" clsFloatLeft"> {$LANG.solutions_re} {$myobj->form_board.displayBoardDetails_arr.board_manual} </p>
        <div class="clsFloatRight"> {if $CFG.admin.navigation.top}
          {include file='../general/pagination.tpl'}
          {/if} </div>
      </div></td>
  </tr>
  {foreach key=fAkey item=fAvalue  from=$myobj->form_solutions.displayAllSolutions_arr}
  <tr class="">

  <td class="clsSolutionTableHeader">

  <table>
    <tr class="{$fAvalue.row_class}">
      <td class="clsSolutionFirtCol"><div class="clsClearFix clsSolutionFirtblock">
          <div class="clsSolnUserimage">
            <div id="solutionuser{$fAvalue.ansId}" class=""> {if isUserImageAllowed()}
              {*{$myobj->displayProfileImage($fAvalue.record, 'small', $CFG.admin.discussions.showpopup)}*}
              <a href="{$fAvalue.mysolutions.url}">
			  	<img src="{$fAvalue.member_image.s_url}" border="0" alt="{$fAvalue.row_solutioned_by_manual|truncate:2}" title="{$fAvalue.row_solutioned_by_manual}"  {$myobj->DISP_IMAGE(45, 45, $fAvalue.member_image.s_width, $fAvalue.member_image.s_height)}/>
			  </a>
              {/if} </div>
          </div>
          <div class="clsSolnUserdetail">
            <p class="clsSolnUserInfo"> <span class="clsSolnUserName"> <a href="{$fAvalue.mysolutions.url}">{$fAvalue.row_solutioned_by_manual}</a> </span> </p>
            <p class="clsSolnUserInfo">{$LANG.discuzz_common_solutions}: <span class="clsValue">{$fAvalue.total_posts}</span></p>
            <p class="clsSolnUserInfo clsDateFixedWidth">{$LANG.solutions_joined_on}: <span class="clsValue">{$fAvalue.user_doj}</span></p>
          </div>
        </div></td>
      <td class="clsSolutionSecondCol"><div class="clsReplayHeading">
          <!-- solutionmore div start-->
          <div id="solutionmore{$fAvalue.ansId}">
            <div class="">
              <div class="">
                <div class="">
                  <!--rating start-->
                  <div class="clsSolutionRatingImg">
                  			{if $CFG.admin.solution.ratings}
                                    {* ---------------DISPLAYING SOLUTION RATING FORM BEGINS--------------------------*}
                                                <div class="clsSharePhotoHeadingRight"> {if $myobj->chkAllowSolutionRating($fAvalue.record.solution_id)}
                                                  <div id="SolutionratingForm{$fAvalue.record.solution_id}">
                                                    <!-- <p class="clsRateThisHd"> {$LANG.discuzz_rate_this_label}:</p>-->
                                                    {assign var=tooltip value=""}
                                                    {if !isLoggedIn()}
                                                    {$discussion->populateSolutionRatingImages($fAvalue.rating, 'solution',$LANG.discuzz_login_message, '#', 'discussions',$fAvalue.record.solution_id)}
                                                    {assign var=tooltip value=$LANG.discuzz_login_message}
                                                    {else}
                                                    <div id="selRatingPhoto{$fAvalue.record.solution_id}" class="clsSolutionRating clsDiscuzzSolutionRating clsOverflow"> {if isMember() and $fAvalue.rankUsersRayzz}
                                                      {$myobj->populateSolutionRatingImagesForAjax($fAvalue.rating, 'discussion', $fAvalue.record.solution_id)}
                                                      {else}
                                                      {$discussion->populateSolutionRatingImages($fAvalue.rating, 'solution', $LANG.solution_rate_yourself, '#', 'discussions',$fAvalue.record.solution_id)}
                                                      {assign var=tooltip value=$LANG.solution_rate_yourself}
                                                      {/if}
                                                      &nbsp;(<span> {$fAvalue.solution_rating_count} </span>) </div>
                                                    {/if}
                                                    <script type="text/javascript">
                                                                                      {literal}
                                                                                      $Jq(document).ready(function(){
                                                                                        $Jq('#ratingLink_{/literal}{$fAvalue.record.solution_id}{literal}').attr('title','{/literal}{$tooltip}{literal}');
                                                                                        $Jq('#ratingLink_{/literal}{$fAvalue.record.solution_id}{literal}').tooltip({
                                                                                                                track: true,
                                                                                                                delay: 0,
                                                                                                                showURL: false,
                                                                                                                showBody: " - ",
                                                                                                                extraClass: "clsToolTip",
                                                                                                                top: -10
                                                                                                            });
                                                                                            });
                                                                                        {/literal}
                                                                                  </script>
                                                  </div>
                                                  {/if} </div>
                                    {* -------------- DISPLAYING RATING FORM ENDS------------------------*}
                            {/if}
                  </div>
                </div>
                <!--rating end-->
                <div class="clsQuestionPost clsClearFix">
                  <div class="clsSolnPostLeft"> {$LANG.solutions_replied_on} <span class="clsSolutionPostDate">{$fAvalue.record.date_replied}</span> </div>
                  {if $fAvalue.showOptions}
                  <div class="clsSonPostRight">
                    <div class="clsOption">
                      <div class="clsOptionLink"> <a onclick="showHideOptions('showhideoptions_{$fAvalue.record.solution_id}','optionList_{$fAvalue.record.solution_id}')">{$LANG.solutions_options}</a></div>
                      <div id="showhideoptions_{$fAvalue.record.solution_id}" class="clsOptionList" style="display: none;">
                        <ul id="optionList_{$fAvalue.record.solution_id}">
                          {if $CFG.admin.abuse_solutions.allowed AND $CFG.user.user_id != $fAvalue.record.user_id}
                          <li> {if isMember()}
                            {if $myobj->chkIsSolutionAbusedAlready($fAvalue.ansId)} <a class="clsNoLink" href="{$fAvalue.solution.url}" onClick="return false;">{$LANG.discuzz_common_abused}</a> {else}
                            {if $myobj->isAllowedToAsk($fAvalue.record.user_id)} <a href="{$fAvalue.solution.url}" onClick="abuseContent('abusesolution', '{$fAvalue.record.solution_id}', '{$fAvalue.anchor}', '{$LANG.confirm_abuse_solution_message}'); return false;">{$LANG.report_abuse}</a> {else} <a href="" onclick="alert_manual('{$LANG.info_not_allowed_to_abuse_solution}');return false;">{$LANG.report_abuse}</a> {/if}
                            {/if}
                            {else} <a href="{$fAvalue.solution_members.url}">{$LANG.report_abuse}</a> {/if} </li>
                          {/if}

                          {if $fAvalue.record.user_id == $CFG.user.user_id}
                          <li> {if $CFG.admin.solution.edit} <a href="{$fAvalue.solution_edit.url}">{$LANG.common_edit}</a> {/if}
                            {if $CFG.admin.solution.delete} <a href="{$fAvalue.solution_delete.url}" onClick="doActionOnSolution('deletesolution', '{$fAvalue.anchor}', '{$LANG.confirm_delete_message_solution}', '{$fAvalue.record.solution_id}'); return false;">{$LANG.discuzz_common_delete}</a> {/if} </li>
                          {/if}
                        </ul>
                      </div>
                    </div>
                  </div>
                  {/if}
                  <div class="clsFloatRight">
                    <!--reply button starts-->
                    <div class="clspostReplayBtnContainer"> {if $classspan != ''}
                      {assign var='bdrclass' value='clsNoBorder'}
                      {/if}

                      {if $CFG.admin.solutions_comment.allowed}
                      {if $CFG.admin.number_of_comments.allowed != 0}
                      {if isMember()}
                      {if  $CFG.admin.board_owner_comment_present.allowed AND $CFG.admin.only_solution_owner_allowed_to_comment.allowed}
                      {if ($CFG.user.user_id == $myobj->board_details.user_id || $myobj->isSolutionOwner($fAvalue.ansId)) AND $fAvalue.record.status == 'Active' }
                      {if  $CFG.user.user_id == $myobj->board_details.user_id }
                      {if $myobj->getTotalSolutionComments($fAvalue.record.solution_id)} <span class="clsReplayBtn" id="addComment_{$fAvalue.record.solution_id}"> <a href="{$fAvalue.solution.url}"  onClick="ajaxUpdateDiv('{$fAvalue.solution.url}', 'ajax_page=true&amp;showOptionToComment=1&amp;c_solution_id={$fAvalue.record.solution_id}&amp;c_seo_title={$myobj->getFormField('seo_title')}&amp;c_qid= {$myobj->getFormField('qid')}', '{$fAvalue.commentSpanIDId}'); return false;">{$LANG.solutions_reply}</a> </span> {/if}
                      {else}
                      {if $myobj->checkIfReplyAllowed($myobj->getFormField('qid'), $fAvalue.record.solution_id ) AND $myobj->checkIfCommentAdded($fAvalue.record.solution_id)} <span class="clsReplayBtn" id="addReply_{$fAvalue.record.solution_id}"><a href="{$fAvalue.solution.url}"  onClick="ajaxUpdateDiv('{$fAvalue.solution.url}', 'ajax_page=true&amp;showOptionToComment=1&amp;reply=reply&amp;c_solution_id={$fAvalue.record.solution_id}&amp;c_seo_title={$myobj->getFormField('seo_title')}&amp;c_qid= {$myobj->getFormField('qid')}', '{$fAvalue.commentSpanIDId}'); return false;">{$LANG.solutions_reply}</a></span> {/if}
                      {/if}
                      {/if}
                      {elseif  !$CFG.admin.board_owner_comment_present.allowed AND $CFG.admin.only_solution_owner_allowed_to_comment.allowed}
                      {if ($CFG.user.user_id == $myobj->board_details.user_id || $myobj->isSolutionOwner($fAvalue.ansId)) AND   $fAvalue.record.status == 'Active' }
                      {if  $CFG.user.user_id == $myobj->board_details.user_id }
                      {if  $myobj->getTotalSolutionComments($fAvalue.record.solution_id)} <span class="clsReplayBtn" id="addComment_{$fAvalue.record.solution_id}"><a href="{$fAvalue.solution.url}"  onClick="ajaxUpdateDiv('{$fAvalue.solution.url}', 'ajax_page=true&amp;showOptionToComment=1&amp;c_solution_id={$fAvalue.record.solution_id}&amp;c_seo_title={$myobj->getFormField('seo_title')}&amp;c_qid= {$myobj->getFormField('qid')}', '{$fAvalue.commentSpanIDId}'); return false;">{$LANG.solutions_reply}</a></span> {/if}
                      {else}
                      {if $myobj->checkIfReplyAllowed($myobj->getFormField('qid'), $fAvalue.record.solution_id)} <span class="clsReplayBtn" id="addReply_{$fAvalue.record.solution_id}"><a href="{$fAvalue.solution.url}"  onClick="ajaxUpdateDiv('{$fAvalue.solution.url}', 'ajax_page=true&amp;showOptionToComment=1&amp;reply=reply&amp;c_solution_id={$fAvalue.record.solution_id}&amp;c_seo_title={$myobj->getFormField('seo_title')}&amp;c_qid= {$myobj->getFormField('qid')}', '{$fAvalue.commentSpanIDId}'); return false;">{if $myobj->chkBoardOwnerPostedComments($fAvalue.record.solution_id)} {$LANG.reply_for_comment}{else}{$LANG.solutions_reply}{/if}</a></span> {/if}
                      {/if}
                      {/if}
                      {elseif  $CFG.admin.board_owner_comment_present.allowed AND !$CFG.admin.only_solution_owner_allowed_to_comment.allowed}
                      {if  $fAvalue.record.status == 'Active' }
                      {if  $CFG.user.user_id == $myobj->board_details.user_id }
                      {if  $myobj->getTotalSolutionComments($fAvalue.record.solution_id)} <span class="clsReplayBtn" id="addComment_{$fAvalue.record.solution_id}"><a href="{$fAvalue.solution.url}"  onClick="ajaxUpdateDiv('{$fAvalue.solution.url}', 'ajax_page=true&showOptionToComment=1&amp;c_solution_id={$fAvalue.record.solution_id}&amp;c_seo_title={$myobj->getFormField('seo_title')}&amp;c_qid= {$myobj->getFormField('qid')}', '{$fAvalue.commentSpanIDId}'); return false;">{$LANG.solutions_reply}</a></span> {/if}
                      {else}
                      {if $myobj->checkIfReplyAllowed($myobj->getFormField('qid'), $fAvalue.record.solution_id) AND $myobj->checkIfCommentAdded($fAvalue.record.solution_id)} <span class="clsReplayBtn" id="addReply_{$fAvalue.record.solution_id}"><a href="{$fAvalue.solution.url}"  onClick="ajaxUpdateDiv('{$fAvalue.solution.url}', 'ajax_page=true&amp;showOptionToComment=1&amp;reply=reply&amp;c_solution_id={$fAvalue.record.solution_id}&amp;c_seo_title={$myobj->getFormField('seo_title')}&amp;c_qid= {$myobj->getFormField('qid')}', '{$fAvalue.commentSpanIDId}'); return false;">{if $fAvalue.record.user_id != $CFG.user.user_id}{$LANG.reply_for_comment}{else}{$LANG.solutions_reply}{/if}</a></span> {/if}
                      {/if}
                      {/if}
                      {else}
                      {if $myobj->isAllowedToAsk($fAvalue.record.user_id)}
                      {if  $myobj->getTotalSolutionComments($fAvalue.record.solution_id)} <span class="clsReplayBtn" id="addComment_{$fAvalue.record.solution_id}"><a href="{$fAvalue.solution.url}"  onClick="ajaxUpdateDiv('{$fAvalue.solution.url}', 'ajax_page=true&amp;showOptionToComment=1&amp;c_solution_id={$fAvalue.record.solution_id}&amp;c_seo_title={$myobj->getFormField('seo_title')}&amp;c_qid= {$myobj->getFormField('qid')}', '{$fAvalue.commentSpanIDId}'); return false;">{$LANG.solutions_reply}</a></span> {/if}
                      {else} <span class="clsReplayBtn"><a onclick="alert_manual('{$LANG.info_not_allowed_to_comment}');return false;">{$LANG.solutions_reply}</a></span> {/if}
                      {/if}
                      {else} <span class="clsReplayBtn" id="addComment_{$fAvalue.record.solution_id}"> <a href="{$fAvalue.solution_members.url}">{$LANG.solutions_reply}</a> </span> {/if}
                      {/if}

                      {/if} </div>
                    <!--reply button ends-->
                    <span class="clsChooseBest"> {if $CFG.admin.best_solutions.allowed AND $CFG.user.user_id == $myobj->board_details.user_id  AND $fAvalue.record.status == 'Active'}
                    {assign var='classspan' value=''}
                    {if $myobj->board_details.best_solution_id == 0} <a href="{$fAvalue.solution.url}"  onClick="doActionOnSolution('bestsolutions', '{$fAvalue.anchor}', '{$LANG.best_solution_confirm_message}', '{$fAvalue.record.solution_id}'); return false;">{$LANG.best_solution}</a> {elseif $myobj->board_details.best_solution_id neq $fAvalue.record.solution_id} <a href="{$fAvalue.solution.url}"  onClick="doActionOnSolution('bestsolutions', '{$fAvalue.anchor}', '{$LANG.change_best_solution_confirm_message}', '{$fAvalue.record.solution_id}'); return false;">{$LANG.best_solution}</a> {elseif $myobj->board_details.best_solution_id eq $fAvalue.record.solution_id} <a href="{$fAvalue.solution.url}"  class="clsRemoveBestSolution" onClick="doActionOnSolution('removebestsolutions', '{$fAvalue.anchor}', '{$LANG.remove_best_solution_confirm_message}', '{$fAvalue.record.solution_id}'); return false;">{$LANG.remove_as_best_solution}</a> {/if}
                    {/if}
                    {if $CFG.user.user_id == $myobj->board_details.user_id AND $fAvalue.record.status == 'ToActivate'} <a href="{$fAvalue.solution.url}"  onClick="doActionOnSolution('publishsolution', '{$fAvalue.anchor}', '{$LANG.publish_solution_confirm_message}', '{$fAvalue.record.solution_id}'); return false;">{$LANG.solutions_publish_solution}</a>
                    </li>
                    {/if} </span> {if $myobj->board_details.best_solution_id eq $fAvalue.record.solution_id}
                    <div class="clsViewAcceptSoln">
                      <p>{$LANG.solutions_accepted}</p>
                    </div>
                    {/if} </div>
                </div>
                <p class="clsSolutionDescription"> {$fAvalue.row_solution_manual} </p>
                <a href="{$myobj->getCurrentUrl()}" id="{$fAvalue.anchor}"></a> {if $fAvalue.fetchMoreAttachments}
                <div class="clsClearFix"> {foreach key=fAkey item=fAavalue  from=$fAvalue.fetchMoreAttachments}
                  {if (in_array($fAavalue.extern, $CFG.admin.attachments.image_formats))}
                  <div class="cls90x90thumbImage clsThumbImageOuter clsAttachContainer clsPointer">
                    <div class="clsThumbImageMiddle">
                      <div class="clsThumbImageInner"> <a href="{$fAavalue.attachment_path}" id="attachment{$fAavalue.attachment_id}" rel="gallery['{$fAavalue.gallery}']" ><img src="{$fAavalue.image_path}" alt="" /></a> {literal}
                        <script>
                                                                    $Jq(document).ready(function() {

                                                                                    $Jq('#attachment'+{/literal}{$fAavalue.attachment_id}{literal}).fancybox({
                                                                                        'width'				: 815,
                                                                                        'height'			: 620,
                                                                                        'padding'			:  0,
                                                                                        'autoScale'     	: false,
                                                                                        'transitionIn'		: 'none',
                                                                                        'transitionOut'		: 'none',
                                                                                        'type'				: 'iframe'
                                                                                    });
                                                                     });
                                                                    </script>
                        {/literal} </div>
                    </div>
                  </div>
                  {/if}
                  {/foreach}
                  {foreach key=fAkey item=fAavalue  from=$fAvalue.fetchMoreAttachments}
                  <ul>
                    {if (!in_array($fAavalue.extern, $CFG.admin.attachments.image_formats))}
                    <li class="clsDocText"><a href="{$fAavalue.attachment_original_path}" target="_blank">{$fAavalue.attachment_name}</a></li>
                    {/if}
                  </ul>
                  {/foreach} </div>
                {/if}
                <div id="{$fAvalue.commentSpanIDId}" class="clsNoBorder"></div>
                {if $CFG.admin.solutions_comment.allowed}
                <div class="clsBubInfoTitle " id="msg{$fAvalue.commentSpanIDId}"> {if $fAvalue.populateCommentList}
                  {foreach key=farlkey item=farlvalue from=$fAvalue.populateCommentList}
                  <div class="clsSolutionCommentDetails clsCommentSolutionDisplay">
                    <div class="clsUserThumbDetails">
                      <div class="clsUserDetails clsClearFix">
                        <p class="clsSolutionPost"> <span class=""> {$LANG.solutions_comment_replied_by} <span class="clsUserName"><a href="{$farlvalue.mysolutions.url}">{$farlvalue.user_details.display_name}</a></span> </span> <span>{$LANG.solutions_date_added} {$farlvalue.record.date_added}</span> </p>
                        <p class="clsCommentText"><span class="">{$farlvalue.record.comment}</span></p>
                        {if $myobj->isBoardOpen()}
                        {if $CFG.user.user_id == $farlvalue.record.user_id  && $CFG.admin.delete_comment.allowed}
                        <p><span class="clsCommentDelete"><a href="{$fAvalue.solution.url}" onClick="doActionOnComment('deletecomment', '{$farlvalue.anchor}', '{$LANG.confirm_delete_message_comment}', '{$farlvalue.record.comment_id}'); return false;">{$LANG.discuzz_common_delete}</a></span></p>
                        {/if}
                        {/if} </div>
                    </div>
                  </div>
                  {/foreach}
                  {/if} </div>
                {/if} </div>
            </div>
          </div>
        </div>
        <!-- solutionmore div end-->
    </div>

    <!-- solutions div end-->
    </td>

    </tr>

  </table>
  </td>

  </tr>

  {/foreach}
</table>
{else}
<table>
<tr class="clsNoBorder">
  <td class="clsSolutionTableHeader"><table>
      <td colspan="3"><div id="selMsgAlert">
            <p>{$LANG.solutions_not_added}. <a class="clsPostNewData" href="{$myobj->form_board.displayBoardDetails_arr.solution_reply.url}">{$LANG.click_here_to_post_new_solution}</a></p>
          </div></td>
      </tr>
    </table></td>
</tr>
</table>
{/if}
{/if}
<div id="selSharePhotoContent" style="display:none"></div>
{if $myobj->isShowPageBlock('form_add')}
	{$myobj->postSolutionsForm('main')}
{/if}

{if $myobj->isShowPageBlock('form_board')}
<div class="clsClearFix clsIeHeight35">
  <div class="clsFloatLeft clsPostsolutionBtm">
    <div class="clsPostLeftButton">
      <div class="clsPostRightButton"> <a href="{$myobj->post_new_link}">{$LANG.solution_postnew}</a> </div>
    </div>
  </div>
   <div class="clsFloatRight"> {if $CFG.admin.navigation.top}
    {include file='../general/pagination.tpl'}
    {/if} </div>
</div>
{/if}
{$myobj->setTemplateFolder('general/', 'discussions')}
{include file='box.tpl' opt='topanalyst_bottom'}
</div>
{if $myobj->isShowPageBlock('from_related_boards')}
	{$myobj->relatedBoards()}
{/if}
{if $myobj->isShowPageBlock('form_add')}
{literal}
<script language="javascript" type="text/javascript">
	function chkLimit()
		{
			var uploaded_images = document.getElementById("uploaded_images");
			if(uploaded_images == null)
				var d = 0;
			else
				{
					items_uploaded = uploaded_images.getElementsByTagName("img");
					var d  =  items_uploaded.length;
					if(d >= file_upload_limit)
							{
								document.getElementById("image_uploads").style.display = "none";
							}
						else
							{
								document.getElementById("image_uploads").style.display = "block";
							}
			   }

		}
	chkLimit();
</script>
{/literal}
{/if}
{literal}
<script>
    $Jq(document).ready(function() {

                    $Jq('#solutionboardid').fancybox({
                        'width'				: 900,
                        'height'			: 750,
                        'padding'			:  0,
                        'autoScale'     	: false,
                        'transitionIn'		: 'none',
                        'transitionOut'		: 'none',
                        'type'				: 'iframe'
                    });
                    $Jq('#reportbuse').fancybox({
                        'width'				: 900,
                        'height'			: 750,
                        'padding'			:  0,
                        'autoScale'     	: false,
                        'transitionIn'		: 'none',
                        'transitionOut'		: 'none',
                        'type'				: 'iframe'
                    });
                    $Jq('#addtofavourties').fancybox({
                        'width'				: 900,
                        'height'			: 750,
                        'padding'			:  0,
                        'autoScale'     	: false,
                        'transitionIn'		: 'none',
                        'transitionOut'		: 'none',
                        'type'				: 'iframe'
                    });
     });
    </script>
{/literal}
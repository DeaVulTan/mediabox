
    <div class="clsOtherBlocksContent">
        <div class="clsForumContent">
		  <div class="clsIndexForumContent">	
            <h3>{$LANG.recent_boards}</h3>
            {if isset($recentDiscussionBoards.row) && ($recentDiscussionBoards.row)}
               {foreach from=$recentDiscussionBoards.row item=detail key=caption}
                <div class="clsOtherBlockContentList">
                    <p class="clsTitle">{$detail.boardDetails.board_link}  </p>
                    <div class="clsOtherBlockMainContent">{$detail.boardDetails.description}</div>
                    {include file="box.tpl" opt="othercontent_top"}
                        <div class="clsOverflow">
                            <div class="clsMembersName">by <img src="{$detail.member_icon.t_url}" alt="{$detail.boardDetails.name}" title="{$detail.boardDetails.name}" {$myobj->DISP_IMAGE(66, 66, $detail.member_icon.t_width, $detail.member_icon.t_height)} /><a href="{$detail.member_profile_url}">{$detail.boardDetails.name}</a></div>
                            <div class="clsContentDetails">
                                <ul class="clsFloatRight">
                                 	<li>{$detail.boardDetails.pubdate}</li>
                                    <li><span>{$detail.boardDetails.total_solutions}</span> {$LANG.common_solutions}</li>
                                    <li class="clsBackgroundNone"><span>{$detail.boardDetails.total_views}</span>  {$LANG.common_views}</li>
                                </ul>
                            </div>
                        </div>
                    {include file="box.tpl" opt="othercontent_bottom"}
                </div>
                {/foreach}
            {else}
            		<div class="clsNoRecordsFound">{$LANG.common_no_records_found}</div>
            {/if}
			</div>
            {if isset($recentDiscussionBoards.row) && ($recentDiscussionBoards.row)}
            	<div class="clsViewAll">
               	 	<a href="{$recentDiscussionBoards.boards_url}">{$LANG.common_viewall_boards}</a>
           		 </div>
            {/if}
        </div>
    </div>

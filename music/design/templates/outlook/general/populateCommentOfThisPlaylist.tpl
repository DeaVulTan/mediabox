<form name="frmMusicComments" id="frmMusicComments" action="{$myobj->getCurrentUrl()}">
	{if isset($populateCommentOfThisPlaylist_arr.hidden_arr) and $populateCommentOfThisPlaylist_arr.hidden_arr}
		{$myobj->populateHidden($populateCommentOfThisPlaylist_arr.hidden_arr)}
	{/if}
	{if isset($populateCommentOfThisPlaylist_arr.row) and $populateCommentOfThisPlaylist_arr.row}
    
	{if $CFG.admin.navigation.top}
	<div class="clsCommentsViewVideopaging">
		{$myobj->setTemplateFolder('general/','music')}
	    {include file='pagination.tpl'}
	</div>
	{/if}
    
    
	{foreach key=cmKey item=cmValue from=$populateCommentOfThisPlaylist_arr.row}
	<div class="clsListContents" id="cmd{$cmValue.record.playlist_comment_id}">
        <div class="clsOverflow">
            <div class="clsCommentThumb">
                <div class="clsThumbImageLink">
                    <a href="{$cmValue.memberProfileUrl}" class="ClsImageContainer ClsImageBorder1 Cls45x45">
                       <img src="{$cmValue.icon.s_url}" title="{$cmValue.name}" {$myobj->DISP_IMAGE(45, 45, $cmValue.icon.s_width, $cmValue.icon.s_height)}/>            
                    </a>
                </div>
            </div>
            <div class="clsCommentDetails">
                <p class="clsCommentedBy"><a href="{$cmValue.memberProfileUrl}" title="{$cmValue.name}">{$cmValue.name}</a><span class="clsLinkSeperator">|</span> <span> {$cmValue.record.pc_date_added}</span> </p>
                <p id="selEditCommentTxt_{$cmValue.record.playlist_comment_id}" class="clsPlaylistCommentdisplay">{$cmValue.makeClickableLinks}</p>
        		<div class="" id="selEditComments_{$cmValue.record.playlist_comment_id}"></div>
            </div>
         </div>    
        <div class="clsButtonHolder">
        	{if isMember() and $cmValue.record.comment_user_id == $CFG.user.user_id}            
            <p class="clsEditButton" id="selViewEditComment_{$cmValue.record.playlist_comment_id}" ><span><a href="javascript:void(0)" onclick="return callAjaxEdit('{$CFG.site.url}music/viewPlaylist.php?ajax_page=true&amp;page=comment_edit&amp;playlist_id={$myobj->getFormField('playlist_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$cmValue.record.playlist_comment_id}')">{$LANG.viewplaylist_edit_label}</a></span></p>  
            <p class="clsDeleteButton" id="selViewDeleteComment_{$cmValue.record.playlist_comment_id}"><span><a href="javascript:void(0)" onclick="return deletePlaylistCommand('{$CFG.site.url}music/viewPlaylist.php?playlist_id={$myobj->getFormField('playlist_id')}&amp;comment_id={$cmValue.record.playlist_comment_id}&amp;ajax_page=true&amp;page=deletecomment','cmd{$cmValue.record.playlist_comment_id}', false)">{$LANG.viewplaylist_deleted_label}</a></span></p>
            {/if}
            
            	
            {if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
            
        	{/if}
            
            
        	{if isMember() and $cmValue.record.comment_user_id != $CFG.user.user_id}
            {if $myobj->getFormField('user_id') == $CFG.user.user_id}
                <p class="clsDeleteButton" id="selViewDeleteComment_{$cmValue.record.playlist_comment_id}">
                <span>
                    <a href="javascript:void(0)" onclick="return deletePlaylistCommand('{$CFG.site.url}music/viewPlaylist.php?playlist_id={$myobj->getFormField('playlist_id')}&amp;comment_id={$cmValue.record.playlist_comment_id}&amp;ajax_page=true&amp;page=deletecomment','cmd{$cmValue.record.playlist_comment_id}', false)">{$LANG.viewplaylist_deleted_label}</a>
                </span>
               </p>
            {/if}
        	{/if}
            
        </div>
        
        {if $cmValue.populateReply_arr}
        
        {if $cmValue.populateReply_arr.rs_PO_RecordCount}
        
        
        {foreach key=prKey item=prValue from=$cmValue.populateReply_arr.row}  
        <div class="clsMoreInfoContent clsOverflow" id="delcmd{$prValue.record.playlist_comment_id}">
            <div class="clsMoreInfoComment">
                <div class="clsOverflow">
                    <div class="clsCommentThumb">
                        <div class="clsThumbImageLink">
                            <a class="ClsImageContainer ClsImageBorder1 Cls45x45" href="{$prValue.memberProfileUrl}">
                                <img src="{$prValue.icon.m_url}" title="{$prValue.name}" {$myobj->DISP_IMAGE(45, 45, $prValue.icon.m_width, $prValue.icon.m_height)}/>
                            </a>
                        </div>
                    </div>
                    <div class="clsCommentDetails">
                        <p class="clsCommentedBy"><span>{$prValue.name}</span><span class="clsLinkSeperator">|</span>{$LANG.viewplaylist_replied_label}</p>
                        <p id="selEditCommentTxt_{$prValue.record.playlist_comment_id}">{$prValue.comment_makeClickableLinks}</p>
                        <div id="selEditComments_{$prValue.record.playlist_comment_id}"></div>
                        <p class="clsAddedTime">{$prValue.record.pc_date_added}</p>
                        <div id="selEditComments_{$prValue.record.playlist_comment_id}"></div>
                    </div>
                </div>
            </div>
            <div class="clsButtonHolder">
                {if (isMember() and $prValue.record.comment_user_id == $CFG.user.user_id)}                                
                        <p class="clsEditButton" id="selViewEditComment_{$prValue.record.playlist_comment_id}">
                            <span>
                                <a href="javascript:void(0);" onclick="return callAjaxEdit('{$CFG.site.url}music/viewPlaylist.php?ajax_page=true&amp;playlist_id={$myobj->getFormField('playlist_id')}&amp;vpkey={$myobj->getFormField('vpkey')}&amp;show={$myobj->getFormField('show')}','{$prValue.record.playlist_comment_id}')">{$LANG.viewplaylist_edit_label}</a>
                            </span>
                        </p>
                {/if}
                {if (isMember() || $prValue.record.comment_user_id != '' || $myobj->getFormField('user_id') != '')}
                {if (isMember())}
                       <p class="clsDeleteButton" id="selViewDeleteComment_{$prValue.record.playlist_comment_id}">
                            <span>
                                <a href="javascript:void(0);" onclick="return deleteCommandReply('{$CFG.site.url}music/viewPlaylist.php?playlist_id={$myobj->getFormField('playlist_id')}&amp;comment_id={$prValue.record.playlist_comment_id}&amp;ajax_page=true&amp;page=deletecomment','cmd{$prValue.record.playlist_comment_id}')">{$LANG.viewplaylist_deleted_label}</a>
                            </span>	
                        </p> 
                 {/if}                             
                 {/if}
             </div>                        	
        </div>
        {/foreach}
        
        
        {/if}
        {/if}
        
        
    </div>
	{/foreach}
	{if $CFG.admin.navigation.bottom}
		{$myobj->setTemplateFolder('general/','music')}
	    {include file='pagination.tpl'}
	{/if}
	{else}
	<div class="clsNoRecordsFound">
		<p>{$LANG.viewplaylist_no_comments}</p>
 	</div>
	{/if}
</form>
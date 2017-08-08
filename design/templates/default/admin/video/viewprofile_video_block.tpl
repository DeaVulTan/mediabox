<table id="" cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor}>
    <tr>
        <td colspan="2" class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle}>
            <span class="whitetext12">
            	{$myobj->form_show_profile.user_name} {$LANG.viewprofile_shelf_videos}
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table id="">
                {if $displayMyVideos_arr.record_count}
                    <tr>
                        {foreach key=dmvKey  item=dmvValue from=$displayMyVideos_arr.row}
                            <td>
                                <p id="selImageBorder">
                                <img src="{$dmvValue.video_path}" {$dmvValue.widthHeightAttr}  alt="{$dmvValue.record.video_title}" />
                                </p>
                            </td>
                        {/foreach}
                    </tr>
                    <tr>
                        <td colspan="4">
                            <a href="video/videoManage.php?srch_uname={$myobj->user_details_arr.user_name}">
                            	{$LANG.viewprofile_link_view_videos}
                            </a>
                        </td>
                    </tr>
                {else} 
                    <tr>
                    	<td>
                        	<div id="selMsgAlert">
                        	{$LANG.viewprofile_no_video}
                            </div>
                        </td>
                    </tr>
                {/if}
            </table>
        </td>
    </tr> 
</table>
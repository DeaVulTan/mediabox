<table id="{$CFG.profile_box_id.musics}" cellspacing="0" {$myobj->form_show_profile.defaultTableBgColor}>
    <tr>
        <td colspan="2" class="text clsProfileTitle" {$myobj->form_show_profile.defaultBlockTitle}>
            <span class="whitetext12">
            	{$myobj->form_show_profile.user_name} {$LANG.viewprofile_shelf_musics}
            </span>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table id="{$CFG.profile_box_id.musics_list}">
                {if $displayMyMusics_arr.record_count}
                    <tr>
                        {foreach key=dmvKey  item=dmvValue from=$displayMyMusics_arr.row}
                            <td>
                                <p id="selImageBorder">
                                {if $dmvValue.music_path != ''}	
        	                        <img src="{$dmvValue.music_path}" {$dmvValue.widthHeightAttr}  alt="{$dmvValue.record.music_title}" />
                                {else}
	                                <img   src="{$CFG.site.url}music/design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/no_image/noImage_audio_T.jpg" alt="{$dmvValue.record.music_title}"/>
                               {/if}   
                                </p>
                            </td>
                        {/foreach}
                    </tr>
                    <tr>
                        <td colspan="4">
                            <a href="music/musicManage.php?srch_uname={$myobj->user_details_arr.user_name}">
                            	{$LANG.viewprofile_link_view_musics}
                            </a>
                        </td>
                    </tr>
                {else} 
                    <tr>
                    	<td>
                        	<div id="selMsgAlert">
                        	{$LANG.viewprofile_no_music}
                            </div>
                        </td>
                    </tr>
                {/if}
            </table>
        </td>
    </tr> 
</table>
{include file='information.tpl'}
<table class="clsScrapBook" id="{$profile_scrap_box_id}">
	{foreach key=item item=value from=$ajax_comment_arr}
  		<tr>
    		<td id="selProfileComment">
        		<div class="clsScrapBookContent">
            		<div class="clsFrameScrapBookThumb">
                		<p id="selImageBorder">
                    		<a href="{$value.commentorProfileUrl}" class="ClsImageContainer ClsImageBorder2 Cls45x45" {$value.online}>
								<img src="{$value.profileIcon.s_url}" alt="{$value.user_name|truncate:5}" title="{$value.user_name}" {$myobj->DISP_IMAGE(45, 45, $value.profileIcon.s_width, $value.profileIcon.s_height)}/>
                    		</a>
                		</p>
            		</div>
            		<div class="clsScrapBookThumbDetails">
                		<p><a href="{$value.commentorProfileUrl}">{$value.user_name}</a><span>{$value.display_date_added|date_format:#format_datetime#}</span></p>
                		<p>{$value.comment}</p>
            		</div>
        		</div>
    		</td>
  		</tr>
	{/foreach}
</table>
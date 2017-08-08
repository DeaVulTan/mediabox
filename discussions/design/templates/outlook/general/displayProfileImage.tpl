{if $displayProfileImage_arr.img_src}
	{if $displayProfileImage_arr.showPopup}
		<div id="{$displayProfileImage_arr.popupDivId}"  style="display:none;" ></div>
		<div>
			<a href="{$displayProfileImage_arr.user_url}" id="img{$displayProfileImage_arr.popupDivId}" class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45"><img src="{$displayProfileImage_arr.img_src}"{$displayProfileImage_arr.attr} alt="{$displayProfileImage_arr.altName}" /></a>
					
		</div>
	{else}
		<div>
					<a class="ClsImageContainer ClsImageBorderWhatsgoing Cls45x45" href="{$displayProfileImage_arr.user_url}"><img src="{$displayProfileImage_arr.img_src}"{$displayProfileImage_arr.attr} alt="{$displayProfileImage_arr.altName}" /></a>     
		</div>
	{/if}
{/if}
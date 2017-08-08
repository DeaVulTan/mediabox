	<div class="clsPlayerBlock">
    {if $mainIndexObj->main_index_video_arr}
        <h3>{$mainIndexObj->main_player_video_title}</h3>
        {* Video Player Begins *}
        {if $mainIndexObj->isMainVideoExternal}
            <div id="flashcontent2" class="clsFlashContent2">
                {$mainIndexObj->displayEmbededVideo($mainIndexObj->main_player_embed_code)}
            </div>
         {else}
            <div id="flashcontent2" class="clsFlashContent2">
                {$mainIndexObj->getMainIndexVideoPlayer($mainIndexObj->main_player_video_id)}
            </div>
         {/if}
         {* Video Player ends *}
{else}
	<div class="clsNoRecordsFound">
		{$LANG.mainIndex_video_no_record}
	</div>
{/if}
    </div>
{if ($mainIndexObj->main_index_video_arr && $mainIndexObj->isMainVideoExternal)}
{literal}
<script type="text/javascript">
	var playerActualHeight =250;
	var playerActualWidth=300;
	function chkValidHeightAndWidth(ele)
		{

			flash_content_div_width = $Jq('#flashcontent2').css('width');
			flash_content_div_height = $Jq('#flashcontent2').css('height');

			height=parseInt($Jq(ele).css('height'));
			width=parseInt($Jq(ele).css('width'));
			if((height>playerActualHeight || width >playerActualWidth))
				{
					$Jq(ele).css('height', playerActualHeight);
					$Jq(ele).css('width', playerActualWidth);
				}
		}
	function chkExtenalEmbededHeightAndWidth()
	  {
		var embeded_ele=$Jq('#flashcontent2 embed').length;
		if(embeded_ele)
			{
				$Jq('#flashcontent2 embed').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});
			}


		object_ele=$Jq('#flashcontent2 object').length;
		if(object_ele)
			{

				$Jq('#flashcontent2 object').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});

			}
	  }

							var user_agent = navigator.userAgent.toLowerCase();
							if(user_agent.indexOf("msie") != -1)
								{
									// FIX for IE 6 since sometimes dom:loaded not working
									$Jq(window).load(function(){
										chkExtenalEmbededHeightAndWidth();
									});
								}
							else
								{
									$Jq(document).ready( function(){
										chkExtenalEmbededHeightAndWidth();
									});
								}
							</script>
{/literal}
{/if}

<script type="text/javascript">
	removeLoadingBg('indexAudioContainer');
</script>
{if $total_music_list_pages}
<div class="clsCarouselContainer">
    <ul id="{$showtab}carouselMusicList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
		<div class="clsIndexViewAllLinks">
				<a title="{$LANG.myhome_music_view_all_music}" href="{$myobj->view_all_music_url}">{$LANG.myhome_music_view_all_music}</a>
		</div>
</div>
<script type="text/javascript">
	var music_carousel_tab = '{$showtab}carouselMusicList';
	{literal}	
	jQuery('#' + music_carousel_tab).jcarousel({
		scroll: 1,
		size: {/literal}{$total_music_list_pages}{literal},
		block: '{/literal}{$showtab}{literal}',
		itemFallbackDimension: 610,
		itemLoadCallback: musiccarousel_itemLoadCallback
	});
	{/literal}
</script>
{else}
{if $showtab == 'topratedmusic'}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_audio_rated_error_msg}</div>
{else}
<div class="clsNoRecordsFound">{$LANG.sidebar_no_audio_found_error_msg}</div>
{/if}
{/if}
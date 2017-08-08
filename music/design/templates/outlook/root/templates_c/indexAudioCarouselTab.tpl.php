<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:01
         compiled from indexAudioCarouselTab.tpl */ ?>
<script type="text/javascript">
	removeLoadingBg('indexAudioContainer');
</script>
<?php if ($this->_tpl_vars['total_music_list_pages']): ?>
<div class="clsCarouselContainer">
    <ul id="<?php echo $this->_tpl_vars['showtab']; ?>
carouselMusicList" class="jcarousel-skin-tango">    	
      	<!-- The content will be dynamically loaded here -->
    </ul>
		<div class="clsIndexViewAllLinks">
				<a title="<?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_music']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->view_all_music_url; ?>
"><?php echo $this->_tpl_vars['LANG']['myhome_music_view_all_music']; ?>
</a>
		</div>
</div>
<script type="text/javascript">
	var music_carousel_tab = '<?php echo $this->_tpl_vars['showtab']; ?>
carouselMusicList';
	<?php echo '	
	jQuery(\'#\' + music_carousel_tab).jcarousel({
		scroll: 1,
		size: '; ?>
<?php echo $this->_tpl_vars['total_music_list_pages']; ?>
<?php echo ',
		block: \''; ?>
<?php echo $this->_tpl_vars['showtab']; ?>
<?php echo '\',
		itemFallbackDimension: 610,
		itemLoadCallback: musiccarousel_itemLoadCallback
	});
	'; ?>

</script>
<?php else: ?>
<?php if ($this->_tpl_vars['showtab'] == 'topratedmusic'): ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_audio_rated_error_msg']; ?>
</div>
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_audio_found_error_msg']; ?>
</div>
<?php endif; ?>
<?php endif; ?>
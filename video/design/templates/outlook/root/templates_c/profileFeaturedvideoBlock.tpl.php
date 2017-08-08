<?php /* Smarty version 2.6.18, created on 2011-10-26 21:03:03
         compiled from profileFeaturedvideoBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'video' ) )): ?>
<?php if ($this->_tpl_vars['isFeaturedvideo']): ?>
<div class="clsFeaturedVideoBlockTable">
<div class="clsFeaturedVideoBlock">
<div class="clsFeaturedVideoBlock" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['featuredvideo_list']; ?>
">
	<div class="clsFeaturedVideoPlayer">
			<div id="flashcontent2" class="clsVideoPlayerBorder">
			<?php if ($this->_tpl_vars['featured_video_list_arr']['is_external_embed_video'] == 'Yes'): ?>
				<?php echo $this->_tpl_vars['featured_video_list_arr']['video_external_embed_code']; ?>

			<?php endif; ?>
			 </div>
			<?php if ($this->_tpl_vars['featured_video_list_arr']['is_external_embed_video'] == 'Yes'): ?>
			<script type="text/javascript">
			var playerActualHeight =<?php echo $this->_tpl_vars['CFG']['profile']['featured_video_player_minimum_height']; ?>
;
			var playerActualWidth=<?php echo $this->_tpl_vars['CFG']['profile']['featured_video_player_minimum_width']; ?>
;
			<?php echo '
	function chkValidHeightAndWidth(ele)
		{

			flash_content_div_width = $Jq(\'#flashcontent2\').css(\'width\');
			flash_content_div_height = $Jq(\'#flashcontent2\').css(\'height\');

			height=parseInt($Jq(ele).css(\'height\'));
			width=parseInt($Jq(ele).css(\'width\'));
			if((height>playerActualHeight || width >playerActualWidth))
				{
					$Jq(ele).css(\'height\', playerActualHeight);
					$Jq(ele).css(\'width\', playerActualWidth);
				}
		}
	function chkExtenalEmbededHeightAndWidth()
	  {
		var embeded_ele=$Jq(\'#flashcontent2 embed\').length;
		if(embeded_ele)
			{
				$Jq(\'#flashcontent2 embed\').each(function(ele)
					{
					   	chkValidHeightAndWidth($Jq(this));
					});
			}


		object_ele=$Jq(\'#flashcontent2 object\').length;
		if(object_ele)
			{

				$Jq(\'#flashcontent2 object\').each(function(ele)
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
								'; ?>

							</script>

			<?php else: ?>
						<script type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/swfobject.js"></script>
			<script type="text/javascript">
			var so1 = new SWFObject("<?php echo $this->_tpl_vars['flv_player_url']; ?>
", "flvplayer", "<?php echo $this->_tpl_vars['CFG']['profile']['featured_video_player_minimum_width']; ?>
", "<?php echo $this->_tpl_vars['CFG']['profile']['featured_video_player_minimum_height']; ?>
", "7",  null, true);
			so1.addParam("allowFullScreen", "true");
			so1.addParam("wmode", "transparent");
			so1.addParam("autoplay", "false");
			so1.addParam("allowSciptAccess", "always");
			so1.addVariable("config", "<?php echo $this->_tpl_vars['configXmlUrl']; ?>
");
			so1.write("flashcontent2");

		   </script>
						<?php endif; ?>

	</div>
		<div class="clsFeaturedVideoBlockDetails">
			<p><?php echo $this->_tpl_vars['LANG']['myprofile_featured_videos_title']; ?>
:&nbsp;<span class="clsBold clsNoSeparator">
			   <a href="<?php echo $this->_tpl_vars['featured_video_list_arr']['videoUrl']; ?>
"><?php echo $this->_tpl_vars['featured_video_list_arr']['video_title']; ?>
</a></span>
			</p>
			<p><?php echo $this->_tpl_vars['LANG']['index_playing_time']; ?>
:<span><?php echo $this->_tpl_vars['featured_video_list_arr']['playing_time']; ?>
</span>
			   <?php echo $this->_tpl_vars['LANG']['index_added']; ?>
:<span><?php echo $this->_tpl_vars['featured_video_list_arr']['video_date_added']; ?>
</span>
			   <?php echo $this->_tpl_vars['LANG']['index_views']; ?>
:<span class="clsNoSeparator"><?php echo $this->_tpl_vars['featured_video_list_arr']['total_views']; ?>
</span>
			</p>
		</div>
	</div>
 </div>
<?php else: ?>
		<div class="clsOverflow">
		<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['myprofile_featuredvideo_no_records']; ?>
</div>
	  </div>
<?php endif; ?>
<?php endif; ?>
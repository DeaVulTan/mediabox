<?php /* Smarty version 2.6.18, created on 2011-10-18 17:54:54
         compiled from mainIndexVideoPlayer.tpl */ ?>
	<div class="clsPlayerBlock">
    <?php if ($this->_tpl_vars['mainIndexObj']->main_index_video_arr): ?>
        <h3><?php echo $this->_tpl_vars['mainIndexObj']->main_player_video_title; ?>
</h3>
                <?php if ($this->_tpl_vars['mainIndexObj']->isMainVideoExternal): ?>
            <div id="flashcontent2" class="clsFlashContent2">
                <?php echo $this->_tpl_vars['mainIndexObj']->displayEmbededVideo($this->_tpl_vars['mainIndexObj']->main_player_embed_code); ?>

            </div>
         <?php else: ?>
            <div id="flashcontent2" class="clsFlashContent2">
                <?php echo $this->_tpl_vars['mainIndexObj']->getMainIndexVideoPlayer($this->_tpl_vars['mainIndexObj']->main_player_video_id); ?>

            </div>
         <?php endif; ?>
         <?php else: ?>
	<div class="clsNoRecordsFound">
		<?php echo $this->_tpl_vars['LANG']['mainIndex_video_no_record']; ?>

	</div>
<?php endif; ?>
    </div>
<?php if (( $this->_tpl_vars['mainIndexObj']->main_index_video_arr && $this->_tpl_vars['mainIndexObj']->isMainVideoExternal )): ?>
<?php echo '
<script type="text/javascript">
	var playerActualHeight =250;
	var playerActualWidth=300;
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
							</script>
'; ?>

<?php endif; ?>
<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:22
         compiled from indexRecentVideo.tpl */ ?>
<?php if ($this->_tpl_vars['videoIndexObj']->video_list_show): ?>
 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'lastwatchedvideo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div class="clsVideoListContainer">
            <div class="clsRandomVideosTitle">
                <h2><?php echo $this->_tpl_vars['LANG']['index_title_watched_now_videos_title']; ?>
</h2>
            </div>
            <div class="clsRandomVideosList">
            	<table>
                  <tr>
                    <td>
                    	<div class="clsRandomVideoInfo">
                    		<div id="flashcontent_youtube"></div>
				       <script type="text/javascript">
					var so1 = new SWFObject("<?php echo $this->_tpl_vars['videoIndexObj']->recentvideo_flv_player_url; ?>
", "playList", "640", "110", "5",  null, true);
					so1.addParam("allowSciptAccess", "always");
					so1.addParam("wmode", "transparent");
					so1.addVariable("xmlpath", "<?php echo $this->_tpl_vars['videoIndexObj']->recentvideo_configXmlcode_url; ?>
");
					so1.addVariable("listCounts", "<?php echo $this->_tpl_vars['CFG']['admin']['videos']['recent_videos_play_list_counts']; ?>
");
					so1.write("flashcontent_youtube");
					</script>
                    	</div>
                    </td>
                  </tr>
                </table>
            </div>
        </div>
 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>
		
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'lastwatchedvideo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--<script type="text/javascript" language="javascript">
//recentViewedSlideShowRepeat();
</script> -->
<?php endif; ?>
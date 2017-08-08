<?php /* Smarty version 2.6.18, created on 2011-10-18 15:29:57
         compiled from index.tpl */ ?>
<div class="clsOverflow">
		<div class="clsMusicIndexRight">

    	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_activity_block')): ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexActivityHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
	    
    	   <?php echo $this->_tpl_vars['myobj']->populateMemberDetail('music'); ?>

   	 

		   <?php echo $this->_tpl_vars['myobj']->populateMemberDetail('playlist'); ?>

   	
        	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_topcontributors_block')): ?>
        	<?php echo $this->_tpl_vars['myobj']->topContributors(); ?>

        <?php endif; ?>
   	
            <?php $this->assign('index_total_popular_artist', '4'); ?>
    
	<?php if (isset ( $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature'] ) && $this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
    	<?php echo $this->_tpl_vars['myobj']->populatePopularMemberArtist($this->_tpl_vars['index_total_popular_artist']); ?>

    <?php else: ?>
		<?php echo $this->_tpl_vars['myobj']->populatePopularArtist($this->_tpl_vars['index_total_popular_artist']); ?>

	<?php endif; ?>
    
    	    <?php echo $this->_tpl_vars['myobj']->populateAudioTracker(); ?>

    
        	<?php echo $this->_tpl_vars['myobj']->populateGenres(); ?>

    
        <div class="cls336pxBanner">
        <div><?php global $CFG; getAdvertisement('sidebanner1_336x280') ?></div>
    </div>
    
	        <div class="clsTagsRightTab" id="cloudTabs">
        	<?php $this->assign('music_cloud_display', $this->_tpl_vars['myobj']->populateSidebarClouds('music','music_tags')); ?>
            <?php $this->assign('artist_cloud_display', $this->_tpl_vars['myobj']->populateSidebarClouds('artist','music_artist')); ?>
            <ul class="clsOverflow">
                <?php if ($this->_tpl_vars['music_cloud_display']): ?><li><a href="#tagCloudsmusic"><?php echo $this->_tpl_vars['LANG']['common_music_cloud_music']; ?>
</a></li><?php endif; ?>
                <?php if ($this->_tpl_vars['artist_cloud_display']): ?><li><a href="#tagCloudsartist"><?php echo $this->_tpl_vars['LANG']['common_music_cloud_artist']; ?>
</a></li><?php endif; ?>
            </ul>          
        </div>        
        <script type="text/javascript">
            <?php echo '
            $Jq(window).load(function(){
				attachJqueryTabs(\'cloudTabs\');
            });
            '; ?>

        </script>
    
	</div>
    

		<div class="clsMusicIndexLeft">

				<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_feartured_musiclist')): ?>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<div class="clsFeaturedPlaylistContainer">
					<h3><?php echo $this->_tpl_vars['featured_list_title']; ?>
</h3>
					<div class="clsplayerContainer">
                    <div class="clsPlayerPreLoaderContainer" id="indexMusicPlayerLoader">
                        <div class="clsPlayerPreLoader"></div>
                    </div>
					<div class="clsAudioPlayer" id="indexMusicPlayer" style="display:none;">
                                                <?php echo $this->_tpl_vars['myobj']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

					</div>
					</div>
				</div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'playlist_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
		
				<?php if ($this->_tpl_vars['featured_content_module_enabled'] == 'true'): ?>
			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_feartured_content_glider')): ?>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

		        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexFeaturedContentGlider.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		    <?php endif; ?>
		<?php endif; ?>
		
				<?php echo $this->_tpl_vars['myobj']->populateHiddenPlayer(); ?>

		
				<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_audio_block')): ?>
    	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexAudioBlockHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    <?php endif; ?>
		
			    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_featured_albums')): ?>
    	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexFeaturedAlbumsHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    <?php endif; ?>
		        
            	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_topchart_block')): ?>
        	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexTopChartHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    	<?php endif; ?>
		
			    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_popular_playlist')): ?>
    	    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexPopularPlaylistHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    <?php endif; ?>
		        
                <div class="cls468pxBanner">
            <div><?php global $CFG; getAdvertisement('bottom_banner_468x60') ?></div>
        </div>
        
    </div>
    </div>
    
    
    
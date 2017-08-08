<?php /* Smarty version 2.6.18, created on 2011-10-18 15:29:57
         compiled from html_header.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->getTpl('general','header.tpl'); ?>

<iframe name="facebook_logout" id="facebook_logout" style="display:none"></iframe>
<script type="text/javascript">
window.name="mycartwindow";
</script>
<script type="text/javascript">
var music_ajax_page_loading = '<img alt="<?php echo $this->_tpl_vars['LANG']['common_music_loading']; ?>
" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" />';
var music_site_url = '<?php echo $this->_tpl_vars['CFG']['site']['music_url']; ?>
';
</script>
	<?php echo $this->_tpl_vars['myobj']->populateMusicJsVars(); ?>



<div id="header" class="clsHeaderContainer">
    <div class="clsHeaderShadowImage">
        <div class="clsHeaderBlock">
            <div class="clsMainLogo">
                <h1>
                    <a href="<?php echo $this->_tpl_vars['header']->index_page_link; ?>
"><img src="<?php echo $this->_tpl_vars['header']->logo_url; ?>
" alt="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" title="<?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
" /></a>
                </h1>
            </div>
            <div class="clsHeaderContents">
                <!-- Top header menu Begins -->
                <div class="clsTopHeaderLinks">
                	<?php echo $this->_tpl_vars['myobj']->getTpl('general','topMenu.tpl'); ?>

                </div>
                <!-- End of Top header menu -->
                <div class="clsTopHeader">
				
									<div class="cls468pxTopBanner">
						<div><?php getAdvertisement('top_banner_468x60') ?></div>
					</div>
								
				<div id="selRightHeader" class="clsSearchUploadContainer">
					<?php echo $this->_tpl_vars['myobj']->getTpl('general','topUpload.tpl'); ?>

					<?php echo $this->_tpl_vars['myobj']->getTpl('general','topSearch.tpl'); ?>

				</div>
				
              </div>
            </div>
            <div class="clsNavigationStatsContainer">
                <div class="clsMainNavMiddle">
                    <div class="clsMainNavLeft">
                        <div class="clsMainNavRight">
                            <!-- Start of Main Menu -->
                            <?php echo $this->_tpl_vars['myobj']->getTopMenu('general','mainMenu.tpl'); ?>

                            <!-- end of Main Menu -->
                            <!-- stats starts -->
                            <?php echo $this->_tpl_vars['header']->populateSiteStatistics(); ?>

                            <!-- stats ends -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   	<?php if ($this->_tpl_vars['header']->isUserStyle()): ?>
    	<div class="clsBodyContent profileBodyContent">
    <?php else: ?>
		<div class="clsBodyContent">
	<?php endif; ?>


<div class="clsOverflow">
	<div class="clsHeadTopMusicLeft">
		<div class="clsMusicHeadDetailLeft">        
			<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_head']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_head']; ?>
</a>
		</div>
		<div class="clsMusicHeadDetailRight">
			<p>
				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=musicnew','musicnew/','members','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_head_tracks']; ?>
"><?php echo $this->_tpl_vars['myobj']->getTotalSongs(); ?>
</a>
				<span><?php echo $this->_tpl_vars['LANG']['common_music_head_tracks']; ?>
,</span>                
				<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=musicmostviewed','musicmostviewed/','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_head_listened']; ?>
"><?php echo $this->_tpl_vars['myobj']->totalSongsListened(); ?>
</a>
				<span><?php echo $this->_tpl_vars['LANG']['common_music_head_listened']; ?>
,</span>
				<span><?php echo $this->_tpl_vars['myobj']->totalSongsDonwloads(); ?>
 <?php echo $this->_tpl_vars['LANG']['common_music_head_downloads']; ?>
,</span>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistnew','playlistnew/','members','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_head_playlists']; ?>
"><?php echo $this->_tpl_vars['myobj']->getTotalPlaylists(); ?>
</a>
				<span><?php echo $this->_tpl_vars['LANG']['common_music_head_playlists']; ?>
</span>
			</p>
		</div>
	</div>
	<div class="clsHeadTopMusicRight">
	<?php if (isMember ( )): ?>
    	<?php if (( isLoggedIn ( ) && $this->_tpl_vars['CFG']['admin']['musics']['allow_quick_mixs'] )): ?>
		<div class="clsQuickMixLink">
			<div class="clsQuickMixLeft">
				<div class="clsQuickMixRight">
					<a href="javascript:void(0)" onclick="quickMixPlayer();"><?php echo $this->_tpl_vars['LANG']['header_music_open_quick_mix']; ?>
</a>
				</div>
			</div>
		</div>
        <?php endif; ?>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['musics']['individual_song_play']): ?>
		<div class="clsVolumeBar">
			<div id="volume_container" class="clsVolumeDisabled" onmouseover="show_what_is_this()">
				<div id="volume_speaker" onclick="mute_volume()" class="clsSpeakerOn"></div>
				<div class="clsVolumeAdjust">
					<div id="volume_slider" class="slider">
					</div>
				</div>
			</div>
		</div>
		<!--<div id="volume_what_is_this" class="clsVolumeHelp" onmouseover="show_volume_help_tip()" onmouseout="hide_volume_help_tip()" style="visibility:hidden;"></div>-->
	<?php endif; ?>
	<div class="clsMyMusicShortcut clsOverflow">
    <?php $this->assign('css_temp', ''); ?>
		<ul>
			<li class="selDropDownLink">
				<div class="clsMyMusicShortcutLeft">
					<div class="clsMyMusicShortcutRight">
						<a href="#"><?php echo $this->_tpl_vars['LANG']['common_music_head_music_shortcuts']; ?>
</a>
					</div>
				</div>
				<ul class="clsMyshortcutDropdown">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'musicdrop_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<?php /*?><li>
							<a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicuploadpopup','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_head_upload_music']; ?>
</a>
						</li>
						<li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=mymusics','mymusics/','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_head_my_music']; ?>
</a>
						</li>
						<li>                
							 <a  href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicalbummanage','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_head_manage_album']; ?>
</a>
						</li><?php */?>
						<li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=myplaylist','myplaylist/','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_head_my_playlist']; ?>
</a>
						</li>
						<?php /*?><li>
							<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicdefaultsettings','','','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_head_music_setting']; ?>
</a>
						</li><?php */?>
                    <!--by ahmedov abror-->    
                         <li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_musiclist_myfavoritemusics'); ?>
" ><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_favourite_label']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiclist','?pg=myfavoritemusics','myfavoritemusics/','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_favourite_label']; ?>
</a></li>


				<li class="<?php echo $this->_tpl_vars['myobj']->getMusicNavClass('left_mymusictracker'); ?>
"><a title="<?php echo $this->_tpl_vars['LANG']['sidebar_music_viewing_histry_label']; ?>
 " href="<?php echo $this->_tpl_vars['myobj']->getUrl('mymusictracker','','','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['sidebar_music_viewing_histry_label']; ?>
 </a></li>
                  <!--by ahmedov abror end-->     	
                        
                        
                        
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'musicdrop_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				</ul>
			</li>
		</ul>
	</div>
  </div>
</div>
<div class="clsBreadcum">
<p>
    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','',''); ?>
" alt="<?php echo $this->_tpl_vars['LANG']['common_music_link_home']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_link_home']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_link_home']; ?>
</a>
    <?php if ($this->_tpl_vars['myobj']->_currentPage == 'index'): ?>
    	<?php echo $this->_tpl_vars['LANG']['common_music_link_music']; ?>

    <?php else: ?>
        <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('index','','','','music'); ?>
" alt="<?php echo $this->_tpl_vars['LANG']['common_music_link_music']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_music_link_music']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_link_music']; ?>
</a>    
        <?php if ($this->_tpl_vars['myobj']->_currentPage == 'musiclist'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_view_all_music']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'musicuploadpopup'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_upload_music']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'mymusictracker'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_my_music_tracker']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'albumlist' || $this->_tpl_vars['myobj']->_currentPage == 'albumsortlist'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_album_list']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'musicalbummanage'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_music_album_manage']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'musicplaylist'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_music_playlist']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'musicplaylistmanage'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_music_playlist_manage']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'manageplaylistcomments'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_manage_playlist_comments']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'musicdefaultsettings'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_music_default_settings']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'transactionlist'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_transaction_list']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'managemusiccomments'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_manage_music_comments']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'listenmusic'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_listen_music']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'viewalbum'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_view_album']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'viewplaylist'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_view_playlist']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'artistlist'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_artist_list']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'artistphoto'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_artist_photo']; ?>

        <?php elseif ($this->_tpl_vars['myobj']->_currentPage == 'musicdownload'): ?>
        	<?php echo $this->_tpl_vars['LANG']['common_music_link_download_music']; ?>
  
        <?php endif; ?> 
       
    <?php endif; ?>
	 </p>
</div>


<?php if (! $this->_tpl_vars['myobj']->chkIsAllowedLeftMenu()): ?>
    <!--SIDEBAR-->
          <div class="clsSideBar1Audio" id="sideBarAudio">
                         	<?php echo $this->_tpl_vars['myobj']->populateMemberDetail('music'); ?>

                          
          	             	<?php echo $this->_tpl_vars['myobj']->populateMemberDetail('playlist'); ?>

             
			 				<?php if ($this->_tpl_vars['myobj']->_currentPage == 'musiclist'): ?>
					<div class="cls336pxBanner">
						<div><?php getAdvertisement('sidebanner1_336x280') ?></div>
					</div>
				<?php endif; ?>
		  	 	

                              <?php echo $this->_tpl_vars['myobj']->populateGenres(); ?>

             		
            <div class="clsTagsRightTab" id="cloudTabs">
            	<?php $this->assign('music_cloud_display', $this->_tpl_vars['myobj']->populateSidebarClouds('music','music_tags')); ?>
                <?php $this->assign('artist_cloud_display', $this->_tpl_vars['myobj']->populateSidebarClouds('artist','music_artist')); ?>                
                <?php $this->assign('playlist_cloud_display', $this->_tpl_vars['myobj']->populateSidebarClouds('playlist','music_playlist_tags')); ?>
                <ul class="clsOverflow">
                    <?php if ($this->_tpl_vars['music_cloud_display']): ?><li><a href="#tagCloudsmusic"><?php echo $this->_tpl_vars['LANG']['common_music_cloud_music']; ?>
</a></li><?php endif; ?>
                    <?php if ($this->_tpl_vars['artist_cloud_display']): ?><li><a href="#tagCloudsartist"><?php echo $this->_tpl_vars['LANG']['common_music_cloud_artist']; ?>
</a></li><?php endif; ?>
                    <?php if ($this->_tpl_vars['playlist_cloud_display']): ?><li><a href="#tagCloudsplaylist"><?php echo $this->_tpl_vars['LANG']['common_music_cloud_playlist']; ?>
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

							<?php if ($this->_tpl_vars['myobj']->_currentPage == 'musiclist'): ?>
					<div class="cls336pxBanner">
						<div><?php getAdvertisement('sidebanner2_336x280') ?></div>
					</div>
				<?php endif; ?>
		  	 	

          </div>
    <!--end of SIDEBAR-->
<?php endif; ?>

<!-- Main -->
<div id="main" class="<?php echo $this->_tpl_vars['CFG']['main']['class_name']; ?>
 <?php echo $this->_tpl_vars['header']->headerBlock['banner']['class']; ?>
">
<!-- Header ends -->
<?php if ($this->_tpl_vars['header']->chkIsProfilePage()): ?>
	<div class="clsProfilePageStyles">
<?php endif; ?>

<?php echo '
<script type="text/javascript">
var volume_slider = $Jq("#volume_slider").slider({
			min: 0,
			max: 100,
			value: playlist_player_volume,
			disabled: true,
			slide: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				setVolume(ui.value);
			},
			change: function(event, ui) {
				playlist_player_volume = ui.value;
				//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
				toggle_volume_control(ui.value);
				//FOR MUTE CONTROL
				//if(playlist_player_volume_mute_prev != playlist_player_volume_mute_cur)
					{
						playlist_player_volume_mute_prev = playlist_player_volume_mute_cur;
						playlist_player_volume_mute_cur = ui.value;
					}
				setVolume(ui.value);
				store_volume_in_session(ui.value);
	      	}
		});


$Jq(document).ready(function(){
	//TO CHANGE MUTE CONTROL AND VOLUME CONTROL BACKGROUND
	toggle_volume_control(playlist_player_volume);

	var menuLi = $Jq(\'.clsMenu li\');
	menuLi.each(function(li)
	{
		$Jq(this).bind(\'mouseover\', function()
		{
			$Jq(this).addClass(\'clsHoverMenu\');
		});
		$Jq(this).bind(\'mouseout\', function()
		{
			$Jq(this).removeClass(\'clsHoverMenu\');
		});
	});

	'; ?>

	<?php unset($this->_sections['sec']);
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['menu']['main']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec']['start'] = (int)0;
$this->_sections['sec']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['max'] = (int)$this->_tpl_vars['mainMenuMax'];
$this->_sections['sec']['show'] = true;
if ($this->_sections['sec']['max'] < 0)
    $this->_sections['sec']['max'] = $this->_sections['sec']['loop'];
if ($this->_sections['sec']['start'] < 0)
    $this->_sections['sec']['start'] = max($this->_sections['sec']['step'] > 0 ? 0 : -1, $this->_sections['sec']['loop'] + $this->_sections['sec']['start']);
else
    $this->_sections['sec']['start'] = min($this->_sections['sec']['start'], $this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] : $this->_sections['sec']['loop']-1);
if ($this->_sections['sec']['show']) {
    $this->_sections['sec']['total'] = min(ceil(($this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] - $this->_sections['sec']['start'] : $this->_sections['sec']['start']+1)/abs($this->_sections['sec']['step'])), $this->_sections['sec']['max']);
    if ($this->_sections['sec']['total'] == 0)
        $this->_sections['sec']['show'] = false;
} else
    $this->_sections['sec']['total'] = 0;
if ($this->_sections['sec']['show']):

            for ($this->_sections['sec']['index'] = $this->_sections['sec']['start'], $this->_sections['sec']['iteration'] = 1;
                 $this->_sections['sec']['iteration'] <= $this->_sections['sec']['total'];
                 $this->_sections['sec']['index'] += $this->_sections['sec']['step'], $this->_sections['sec']['iteration']++):
$this->_sections['sec']['rownum'] = $this->_sections['sec']['iteration'];
$this->_sections['sec']['index_prev'] = $this->_sections['sec']['index'] - $this->_sections['sec']['step'];
$this->_sections['sec']['index_next'] = $this->_sections['sec']['index'] + $this->_sections['sec']['step'];
$this->_sections['sec']['first']      = ($this->_sections['sec']['iteration'] == 1);
$this->_sections['sec']['last']       = ($this->_sections['sec']['iteration'] == $this->_sections['sec']['total']);
?>
		<?php echo 'listen(\'mouseover\', '; ?>
'<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['id']; ?>
'<?php echo ', function(){
			'; ?>

			<?php if ($this->_tpl_vars['mainmenu_more']): ?>
				<?php echo '
				allowMenuMoreHide=true;
				hideMenuMore();
				'; ?>

			<?php endif; ?>
			<?php if ($this->_tpl_vars['menu_channel']): ?>
				<?php echo '
				allowChannelHide=true;
				hideChannel();
				'; ?>

			<?php endif; ?>
			<?php echo '
		});
	'; ?>

	<?php endfor; endif; ?>
	<?php echo '
});
function openPopupWindow(url){
  	window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
}
</script>
'; ?>
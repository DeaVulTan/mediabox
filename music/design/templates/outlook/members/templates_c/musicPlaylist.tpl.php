<?php /* Smarty version 2.6.18, created on 2011-10-24 16:50:53
         compiled from musicPlaylist.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
<div id="musicPlaylist" class="clsAudioPlayListContainer">
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <?php echo $this->_tpl_vars['myobj']->populateMusicListHidden($this->_tpl_vars['paging_arr']); ?>

            <div class="clsOverflow">                    
              <div class="clsHeadingLeft">  
                <h2>
                    <?php if ($this->_tpl_vars['myobj']->page_heading != ''): ?>
                        <?php echo $this->_tpl_vars['myobj']->page_heading; ?>

                    <?php else: ?>    
                        <?php echo $this->_tpl_vars['LANG']['musicplaylist_title']; ?>

                    <?php endif; ?>
                </h2>
              </div>
              <div class="clsHeadingRight">
                        <input type="hidden" name="default" id="default" value="<?php echo $this->_tpl_vars['myobj']->getFormField('default'); ?>
" />
        		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('search_playlist_block')): ?>
                        <select id="musicplaylistselect" onchange="loadUrl(this)">	
                        	<option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistnew','playlistnew/','','music'); ?>
" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == ''): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['LANG']['header_nav_music_music_all']; ?>
</option>	
                            <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistrecent','playlistrecent/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistrecent'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_music_new']; ?>

                            </option>
                            <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlisttoprated','playlisttoprated/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlisttoprated'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_music_top_rated']; ?>

                            </option>
                            <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistrecommended','playlistrecommended/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistrecommended'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_recommended']; ?>

                            </option>
                            <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistmostlistened','playlistmostlistened/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostlistened'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_most_listened']; ?>

                            </option>
                            <!--<option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistmostviewed','playlistmostviewed/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostviewed'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_most_viewed']; ?>

                            </option>-->
                            <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistmostdiscussed','playlistmostdiscussed/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostdiscussed'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_discussed']; ?>

                            </option>
                            <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistmostfavorite','playlistmostfavorite/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostfavorite'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_favorite']; ?>

                            </option>
                            <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=featuredplaylistlist','featuredplaylistlist/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'featuredplaylistlist'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['musicplaylist_heading_mostfeaturedmusiclist']; ?>

                            </option>
                             <option value="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylist','?pg=playlistmostrecentlyviewed','playlistmostrecentlyviewed/','','music'); ?>
"
                                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostrecentlyviewed'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_music_recently_viewed']; ?>

                            </option>
                        </select>
             	<?php endif; ?>
              </div>
             </div>
            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostviewed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostdiscussed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostfavorite' || $this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostlistened'): ?>
                <div class="clsAudioListMenu">
             		<ul>
                        <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['cssli_0']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_0']; ?>
')"><span><?php echo $this->_tpl_vars['LANG']['header_nav_this_all_time']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['cssli_1']; ?>
>	
							<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_1']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_today']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['cssli_2']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_2']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_yesterday']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['cssli_3']; ?>
>
                       		<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_3']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_week']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['cssli_4']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_4']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_month']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['cssli_5']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_5']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_year']; ?>
</span></a>
                        </li>
                    </ul>
                </div>
                <?php echo '
					<script type="text/javascript">
						function jumpAndSubmitForm(url)
							{
								document.seachAdvancedFilter.start.value = \'0\';
								document.seachAdvancedFilter.action=url;
								document.seachAdvancedFilter.submit();										
							}
						var subMenuClassName1=\'clsActiveTabNavigation\';
						var hoverElement1  = \'.clsTabNavigation li\';
						loadChangeClass(hoverElement1,subMenuClassName1);	
					</script>
                 '; ?>

            <?php endif; ?>   
           <div class="clsOverflow clsAddMusicPlayListLinkHd"  >
        	<div class="clsAdvancedFilterSearch clsAdvancedFilterSearchAlignment">
                <a <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsShow"   id="show_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['musicplaylist_show_advanced_filters']; ?>
</span></a>
                <a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsHide" <?php if (! $this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> id="hide_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['musicplaylist_hide_advanced_filters']; ?>
</span></a>
                <a href="<?php  echo getUrl('musicplaylist','?pg=playlistnew','playlistnew/','','music') ?>" id="show_link" class="clsResetFilter">(<?php echo $this->_tpl_vars['LANG']['musicplaylist_reset_search']; ?>
)</a>
            </div>
           <div class="clsAddMusicPlayListLink">
            <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>		
				<p class="clsCancelButton-l"><span class="clsCancelButton-r">
					<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musicplaylistmanage','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['musicplaylist_add_playlist']; ?>
</a>							
					</span>
					</p>
            <?php endif; ?>
            </div>
            </div>
            <div id="advancedPlaylistSearch" class="clsAdvancedFilterContainer" <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:block <?php else: ?> style="display:none;  <?php endif; ?>margin:10px 0;">
     			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
                    <table class="clsAdvancedFilterTable">
                    <tr>
                        <td>
                            <input type="text" class="clsTextBox" name="playlist_title" id="playlist_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('playlist_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_playlist_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('playlist_title'); ?>
<?php endif; ?>" onblur="setOldValue('playlist_title')"  onfocus="clearValue('playlist_title')"/>                   
                      </td>
                      <td>
                            <input type="text" class="clsTextBox" name="createby" id="createby" onfocus="clearValue('createby')"  onblur="setOldValue('createby')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('createby') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_createby']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('createby'); ?>
<?php endif; ?>" />                    
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="tracks" id="tracks">
			                  <option value=""><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_tracks']; ?>
</option>
            			      <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_SEARCH_TRACK_ARR,$this->_tpl_vars['myobj']->getFormField('tracks')); ?>

		                    </select>                                    
<!--                            <input type="text" class="clsTextBox" name="tracks" id="tracks" onfocus="clearValue('tracks')"  onblur="setOldValue('tracks')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('tracks') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_tracks']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('tracks'); ?>
<?php endif; ?>"/>-->
                        </td>
                        <td>
                            <select name="plays" id="plays">
			                  <option value=""><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_plays']; ?>
</option>
            			      <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_SEARCH_PLAY_ARR,$this->_tpl_vars['myobj']->getFormField('plays')); ?>

		                    </select>                        
                           <!-- <input type="text" class="clsTextBox" name="plays" id="plays" onfocus="clearValue('plays')"  onblur="setOldValue('plays')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('plays') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_of_plays']; ?>
 <?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('plays'); ?>
<?php endif; ?>" />   -->                 
                        </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                      <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['musicplaylist_search']; ?>
" /></span></div>
                      <div class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                      </td>
                    </tr>
                    </table>
     			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
            </div>
            <!--<input type="hidden" name="short_by_playlist" id="short_by_playlist" value="<?php echo $this->_tpl_vars['myobj']->getFormField('short_by_playlist'); ?>
" />-->
        </form> 
    
   	
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_playlist_block')): ?>
    	<div id="selMusicPlaylistManageDisplay" class="clsPlaylistPageContents">
        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <div class="clsOverflow clsSortByLinksContainer">
                                    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                        <div class="clsSortByPagination">
                            <div class="clsAudioPaging">
								<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            </div>
                        </div>
                    <?php endif; ?>
            </div>
            	<script language="javascript" type="text/javascript"> 
					original_height = new Array();
					original_width = new Array();
				</script>
				<div class="clsFavMusicplaylist">
				<?php $this->assign('array_count', '1'); ?> 
                <?php $_from = $this->_tpl_vars['myobj']->list_playlist_block['showPlaylists']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicPlaylistKey'] => $this->_tpl_vars['musicplaylist']):
?>
                 <div class="clsListContents">
                     <div class="clsOverflow">
                     	<div class="clsThumb">
                     		<div class="clsMultipleImage clsPointer" onclick="Redirect2URL('<?php echo $this->_tpl_vars['musicplaylist']['view_playlisturl']; ?>
')" title="<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
">
                                <?php if ($this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['total_record'] > 0): ?>
                                    <?php $_from = $this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlistImageDetailKey'] => $this->_tpl_vars['playlistImageDetailValue']):
?>
                                    	<?php echo '
                                       	<script language="javascript" type="text/javascript"> 
											original_height['; ?>
<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo '] = \''; ?>
<?php echo $this->_tpl_vars['playlistImageDetailValue']['record']['thumb_height']; ?>
<?php echo '\';
											original_width['; ?>
<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo ']  = \''; ?>
<?php echo $this->_tpl_vars['playlistImageDetailValue']['record']['thumb_width']; ?>
<?php echo '\';
									    </script>
                                       '; ?>

                                       <table><tr><td  >
                                       <img  id="t<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" style="position:;z-index:999;display:none;" src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_thumb_path']; ?>
" onmouseout="playlistImageZoom('Shrink', 's<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
', 't<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
', <?php echo $this->_tpl_vars['array_count']; ?>
); return false;"/>
                                       <img  id="s<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_path']; ?>
" />
                                       </td></tr></table>
                                       <?php $this->assign('array_count', $this->_tpl_vars['array_count']+1); ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                    <?php if ($this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['total_record'] < 4): ?>
                                        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['noimageCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                                            <table><tr><td><img  width="65" height="44" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_S.jpg" /></td></tr></table>
                                        <?php endfor; endif; ?>	
                                    <?php endif; ?>
                                <?php else: ?>    
                                    <div class="clsSingleImage"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" /></div>
                                <?php endif; ?>    
                        </div>
                        </div>
                         <div class="clsPlayerImage">
                                <div class="clsPlayerIcon" >
                                    <a class="clsPlaySong" id="play_music_icon_<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" onClick="playlistInPlayListPlayer('<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
')" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_playallsong_helptips']; ?>
"></a>
                                    <a class="clsStopSong" id="play_playing_music_icon_<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" onClick="stopSong(<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
)" style="display:none" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['musicplaylist_stop_helptips']; ?>
"></a>                                        
                                </div>
                                <p class="clsSongListLink"><a href="#" id="musicplaylist_light_window_<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicplaylist_song_list']; ?>
</a></p>
                                								<script type="text/javascript">
                                <?php echo '
                                $Jq(window).load(function() {
                                    $Jq(\'#musicplaylist_light_window_'; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
<?php echo '\').fancybox({
                                        \'width\'				: 550,
                                        \'height\'			: 350,
                                        \'autoScale\'     	: false,
                                        \'href\'              : \''; ?>
<?php echo $this->_tpl_vars['musicplaylist']['light_window_url']; ?>
<?php echo '\',
                                        \'transitionIn\'		: \'none\',
                                        \'transitionOut\'		: \'none\',
                                        \'type\'				: \'iframe\'
                                    });
                                });
                                '; ?>

                                </script>  
								
								 					                 
                                                      
                         </div>
                        <div class="clsContentDetails">
                            <p class="clsHeading"><a href="<?php echo $this->_tpl_vars['musicplaylist']['view_playlisturl']; ?>
" title="<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
"><?php echo $this->_tpl_vars['musicplaylist']['wordWrap_mb_ManualWithSpace_playlist_title']; ?>
</a> 
							</p>
							<p>
								<span>(<?php if ($this->_tpl_vars['musicplaylist']['record']['total_tracks'] <= 1): ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_track']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicplaylist_tracks']; ?>
<?php endif; ?>:&nbsp;<?php echo $this->_tpl_vars['musicplaylist']['record']['total_tracks']; ?>
<?php if ($this->_tpl_vars['musicplaylist']['private_song'] > 0): ?>&nbsp;|&nbsp;<?php echo $this->_tpl_vars['LANG']['musicplaylist_private_label']; ?>
:&nbsp;<?php echo $this->_tpl_vars['musicplaylist']['private_song']; ?>
<?php endif; ?>)</span>
							</p>
							
							<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('songlist_block')): ?>
							<p>
                                                              <?php echo $this->_tpl_vars['myobj']->displaySongList($this->_tpl_vars['musicplaylist']['record']['playlist_id'],true,3); ?>

                                  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "songList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>                                  
                                
							</p>                                                    
							<?php endif; ?>
                             <?php if ($this->_tpl_vars['musicplaylist']['record']['allow_ratings'] == 'Yes'): ?>         
                                 <p>
                                    <?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['musicplaylist']['record']['rating'],'audio','','','music'); ?>

                                </p>
                             <?php endif; ?>
                         </div>
						 </div>
						 <div>
						  <?php echo '
					<script type="text/javascript">										
						$Jq(window).load(function(){
							$Jq("#trigger_'; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
<?php echo '").click(function(){
								displayMusicMoreInfo(\''; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
<?php echo '\');
								return false;
							});
						});										
					</script>
                    '; ?>

					 <div class="clsMoreInfoContainer clsOverflow">
						  <a  id="trigger_<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" class="clsMoreInformation" href="javascript:void(0)"  onclick="moreInformation('moreInfoPlaylist_<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
')">
                                	<span><?php echo $this->_tpl_vars['LANG']['musicplaylist_more_info']; ?>
</span>
                          </a>
					</div>            
						 <div class="clsMoreInfoBlock" id="panel_<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" style="display:none;" >
								<div class="clsMoreInfoContent">
								<div class="clsOverflow">
										 <table>
												<tr>
													<td>
														<span><?php echo $this->_tpl_vars['LANG']['musicplaylist_postby']; ?>
</span>
														<span class="clsMoreInfodata"><a href="<?php echo $this->_tpl_vars['musicplaylist']['getMemberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['musicplaylist']['record']['user_name']; ?>
</a></span>
													</td>
													<td>
														<span><?php echo $this->_tpl_vars['LANG']['musicplaylist_added']; ?>
</span>
														<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicplaylist']['record']['date_added']; ?>
</span>
													</td>
												</tr>
												<tr>
													<td>
														<span><?php echo $this->_tpl_vars['LANG']['musicplaylist_plays']; ?>
</span>
														<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicplaylist']['record']['total_views']; ?>
</span>
													</td>
													<td>
														<span><?php echo $this->_tpl_vars['LANG']['musicplaylist_comments']; ?>
</span>
														<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicplaylist']['record']['total_comments']; ?>
</span>
													</td>
												</tr>
												<tr>
												<td>
													<span><?php echo $this->_tpl_vars['LANG']['musicplaylist_favorites']; ?>
</span>
													<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicplaylist']['record']['total_favorites']; ?>
</span>
												</td> 
												<td>
													<?php if ($this->_tpl_vars['musicplaylist']['record']['allow_ratings'] == 'Yes'): ?>  
														<span><?php echo $this->_tpl_vars['LANG']['musicplaylist_rated_label']; ?>
</span> 
														<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['musicplaylist']['record']['rating_count']; ?>
</span>
													<?php endif; ?>
												</td>
												</tr>
												</table>
											   
										 </div>
										 <?php if ($this->_tpl_vars['myobj']->getFormField('tags') != ''): ?>
												<?php $this->assign('music_tag', $this->_tpl_vars['myobj']->getFormField('tags')); ?>
											<?php else: ?>
												<?php $this->assign('music_tag', ''); ?>
											<?php endif; ?>
										 <p class="clsMoreinfoTags"><?php echo $this->_tpl_vars['LANG']['musicplaylist_tags_label']; ?>
 <?php if ($this->_tpl_vars['musicplaylist']['record']['playlist_tags'] || $this->_tpl_vars['music_tag']): ?><?php echo $this->_tpl_vars['myobj']->getTagsLinkForPlaylist($this->_tpl_vars['musicplaylist']['record']['playlist_tags'],5,$this->_tpl_vars['musicplaylist']['record']['playlist_id'],$this->_tpl_vars['music_tag']); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
										<p title="<?php echo $this->_tpl_vars['musicplaylist']['wordWrap_mb_ManualWithSpace_playlist_description']; ?>
" class="clsDescription"><span class="clsLabel"><?php echo $this->_tpl_vars['LANG']['musicplaylist_description_label']; ?>
</span> <?php if ($this->_tpl_vars['musicplaylist']['wordWrap_mb_ManualWithSpace_playlist_description']): ?><?php echo $this->_tpl_vars['musicplaylist']['wordWrap_mb_ManualWithSpace_playlist_description']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
									 </div>  
					 </div>  
                  </div>
                 </div>
				 
                <?php endforeach; endif; unset($_from); ?> 
				</div>
              <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <div id="bottomLinks" class="clsAudioPaging">
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </div>
                <?php endif; ?>  
             <?php else: ?>   
             	<div id="selMsgAlert">
             		<p><?php echo $this->_tpl_vars['LANG']['musicplaylist_no_records_found']; ?>
</p>
                </div>    
            <?php endif; ?>    
        </div>
    <?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
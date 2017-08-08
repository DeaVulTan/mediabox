<?php /* Smarty version 2.6.18, created on 2012-01-01 20:17:24
         compiled from artistList.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="musicArtistList" class="clsAudioListContainer clsArtistListContainer">
   <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
   <input type="hidden" name="advanceFromSubmission" value="1"/>
	<input type="hidden" name="start" value="1"/>
    <div class="clsOverflow">
      <div class="clsHeadingLeft">
        <h2><span>
            <?php if ($this->_tpl_vars['myobj']->page_heading != ''): ?>
                <?php echo $this->_tpl_vars['myobj']->page_heading; ?>

            <?php else: ?>
                <?php echo $this->_tpl_vars['LANG']['musicArtistList_title']; ?>

            <?php endif; ?>
            </span>
        </h2>
      </div>
   	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('search_artistlist_block')): ?>
        <div class="clsHeadingRight" >
            		 </div>
             </div>
            			 <div class="clsOverflow clsshowhidefiltersblock">
        	<div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                <a onclick="divShowHide('advancedArtistlistSearch', 'show_link', 'hide_link')" class="clsShow"   id="show_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['musicArtistList_show_advanced_filters']; ?>
</span></a>
                <a onclick="divShowHide('advancedArtistlistSearch', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['musicArtistList_hide_advanced_filters']; ?>
</span></a>
            </div>
			</div>
            <div id="advancedArtistlistSearch" class="clsAdvancedFilterTable clsOverflow" <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:block <?php else: ?> style="display:none;  <?php endif; ?>margin:10px 0;"  >
			<div class="clsAdvanceSearchIcon">
                <table class="">
                    <tr>
                        <td>
                            <input class="clsTextBox" type="text" name="artistlist_title" id="artistlist_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('artistlist_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_artistList_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('artistlist_title'); ?>
<?php endif; ?>" onblur="setOldValue('artistlist_title')"  onfocus="clearValue('artistlist_title')"/>
                        </td>
						<td>
                            <input class="clsTextBox" type="text" name="album_title" id="album_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('album_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_album_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('album_title'); ?>
<?php endif; ?>" onblur="setOldValue('album_title')"  onfocus="clearValue('album_title')"/>
                        </td>
                    </tr>
					  <tr>
                        <td>
                            <input class="clsTextBox" type="text" name="music_title" id="music_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('music_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_music_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('music_title'); ?>
<?php endif; ?>" onblur="setOldValue('music_title')"  onfocus="clearValue('music_title')"/>
                        </td>
						<td>
                            <input class="clsTextBox" type="text" name="total_plays" id="total_plays"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('total_plays') == ''): ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_total_plays']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('total_plays'); ?>
<?php endif; ?>" onblur="setOldValue('total_plays')"  onfocus="clearValue('total_plays')"/>
                        </td>
                    </tr>
                   
                </table>
				</div>
			<div class="clsAdvancedSearchBtn">
			<table>
				 <tr>
                        <td>
                            <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['musicArtistList_search']; ?>
" onclick="document.seachAdvancedFilter.start.value = '0';"/></span></div>
							</td></tr>
							<tr>
							<td>
                           <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                        </td>
                    </tr>
			</table>
			</div>
          </div>
		  
        </form>
    <?php endif; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_artistlist_block')): ?>
    	<div id="selmusicArtistListManageDisplay" class="clsLeftSideDisplayTable">
		    <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                        <div class="clsOverflow">
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
                <?php $_from = $this->_tpl_vars['myobj']->list_artistlist_block['showArtistlists']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicArtistListKey'] => $this->_tpl_vars['musicArtistList']):
?>
                    <div class="clsListContents clsLargeImageListContent">
                     <div class="clsOverflow">
                        <div class="clsThumb">
                            <div class="ClsImageContainer ClsImageBorder1 Cls90x90">
								<?php if ($this->_tpl_vars['musicArtistList']['artist_image'] != ''): ?>
								<img src="<?php echo $this->_tpl_vars['musicArtistList']['artist_image']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(88,88,$this->_tpl_vars['musicArtistList']['thumb_width'],$this->_tpl_vars['musicArtistList']['thumb_height']); ?>
 alt="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
" title="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
"/>
								<?php else: ?>
								<img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_artist_T.jpg" alt="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
" title="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
"/>
								<?php endif; ?>
                           </div>
                         </div>
                        <div class="clsPlayerImage">
	                        <ul class="clsAdditionalLinks">
                                <li><a href="<?php echo $this->_tpl_vars['musicArtistList']['getUrl_viewartist_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['musicArtistList_manageartistphoto_label']; ?>
</a></li>
								<input type="hidden" name="music_artist_id" id="music_artist_id" value="<?php echo $this->_tpl_vars['musicArtistList']['record']['music_artist_id']; ?>
" />

                            </ul>
                        </div>
                        <div class="clsContentDetails">
                            <p class="clsHeading" title="<?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
"><a href="<?php echo $this->_tpl_vars['musicArtistList']['getUrl_musiclist_url']; ?>
"><?php echo $this->_tpl_vars['musicArtistList']['record']['artist_name']; ?>
</a></p>
							<p>(<?php if ($this->_tpl_vars['musicArtistList']['total_songs'] <= 1): ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_song_label']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_songs_label']; ?>
<?php endif; ?>:&nbsp;<?php echo $this->_tpl_vars['musicArtistList']['total_songs']; ?>
)</p>
                               <?php echo $this->_tpl_vars['myobj']->displayArtistSongList($this->_tpl_vars['musicArtistList']['record']['music_artist_id'],3); ?>

                               <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "artistMusicList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                            <p><?php if ($this->_tpl_vars['musicArtistList']['record']['sum_plays'] <= 1): ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_play_label']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['musicArtistList_plays_label']; ?>
<?php endif; ?>:&nbsp;<?php echo $this->_tpl_vars['musicArtistList']['record']['sum_plays']; ?>
</p>

                      </div>
                    </div>
                   </div>
                <?php endforeach; endif; unset($_from); ?>
          <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <div id="bottomLinks">
                        <div class="clsAudioPaging">
						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						</div>
          </div>
                <?php endif; ?>
             <?php else: ?>
             	<div id="selMsgAlert">
             		<p><?php echo $this->_tpl_vars['LANG']['musicArtistList_no_records_found']; ?>
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
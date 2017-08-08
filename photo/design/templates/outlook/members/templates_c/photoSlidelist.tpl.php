<?php /* Smarty version 2.6.18, created on 2012-12-17 16:38:15
         compiled from photoSlidelist.tpl */ ?>
<div class="clsPhotoListContainer clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="photoPlaylist" class="clsOverflow">
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <?php echo $this->_tpl_vars['myobj']->populatePhotoListHidden($this->_tpl_vars['paging_arr']); ?>

            <div class="clsOverflow">
              <div class="clsHeadingLeft">
                <h2><span>
                    <?php if ($this->_tpl_vars['myobj']->page_heading != ''): ?>
                        <?php echo $this->_tpl_vars['myobj']->page_heading; ?>

                    <?php else: ?>
                        <?php echo $this->_tpl_vars['LANG']['photoslidelist_title']; ?>

                    <?php endif; ?></span>
                </h2>
              </div>
             </div>
            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostviewed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostdiscussed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostfavorite' || $this->_tpl_vars['myobj']->getFormField('pg') == 'playlistmostlistened'): ?>
                <div class="clsPhotoListMenu">
             		<ul>
                        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['cssli_0']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_0']; ?>
')"><span><?php echo $this->_tpl_vars['LANG']['header_nav_this_all_time']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['cssli_1']; ?>
>
							<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_1']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_today']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['cssli_2']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_2']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_yesterday']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['cssli_3']; ?>
>
                       		<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_3']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_week']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['cssli_4']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_4']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_month']; ?>
</span></a>
                        </li>
                        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['cssli_5']; ?>
>
                        	<a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_5']; ?>
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

           	<div class="clsOverflow clsAddPhotoPlayListLinkHd">
        		<div class="clsAdvancedFilterSearch clsAdvancedFilterSearchAlignment">
                	<a <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsShow"   id="show_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['photoslidelist_show_advanced_filters']; ?>
</span></a>
                	<a onclick="divShowHide('advancedPlaylistSearch', 'show_link', 'hide_link')" class="clsHide" <?php if (! $this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> id="hide_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['photoslidelist_hide_advanced_filters']; ?>
</span></a>
                	<a href="<?php  echo getUrl('photoslidelist','?pg=slidelistnew','slidelistnew/','','photo') ?>" id="show_link" class="clsResetFilter">(<?php echo $this->_tpl_vars['LANG']['photoslidelist_reset_search']; ?>
)</a>
            	</div>

            </div>


            <div id="advancedPlaylistSearch" class="clsAdvancedFilterContainer" <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:block <?php else: ?> style="display:none;  <?php endif; ?>margin:0 0 10px 0;">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    			  <div class="clsOverflow">
                       <div class="clsAdvancedSearchBg">
                        <table class="clsAdvancedFilterTable">
                        <tr>
                            <td>
                                <input type="text" class="clsTextBox" name="playlist_title" id="playlist_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('playlist_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['photoslidelist_slidelist_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('playlist_title'); ?>
<?php endif; ?>" onblur="setOldValue('playlist_title')"  onfocus="clearValue('playlist_title')"/>
                          </td>
                          <td>
                                <input type="text" class="clsTextBox" name="createby" id="createby" onfocus="clearValue('createby')"  onblur="setOldValue('createby')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('createby') == ''): ?><?php echo $this->_tpl_vars['LANG']['photoslidelist_createby']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('createby'); ?>
<?php endif; ?>" />
                          </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="photos" id="photos">
                                  <option value=""><?php echo $this->_tpl_vars['LANG']['photoslidelist_no_of_photos']; ?>
</option>
                                  <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_SEARCH_PHOTO_ARR,$this->_tpl_vars['myobj']->getFormField('photos')); ?>

                                </select>

                            </td>
                            <td>
                                <select name="views" id="views">
                                  <option value=""><?php echo $this->_tpl_vars['LANG']['photoslidelist_no_of_views']; ?>
</option>
                                  <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_SEARCH_VIEW_ARR,$this->_tpl_vars['myobj']->getFormField('views')); ?>

                                </select>

                            </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                          <div class="clsSearchButton-l"><span class="clsSearchButton-r"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['photoslidelist_search']; ?>
" /></span></div>
                          <div class="clsResetButton-l"><span class="clsResetButton-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                          </td>
                        </tr>
                        </table>
                       </div>
                    </div>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>

        </form>


	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_playlist_block')): ?>
    	<div id="selPhotoPlaylistManageDisplay">
        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <div id="" class="clsOverflow clsSlideBorder">

                        <div class="clsSortByPagination">
                            <div class="clsPhotoPaging">
                    		 <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                             <?php endif; ?>
                            </div>
                        </div>
            </div>
            	<script language="javascript" type="text/javascript">
					original_height = new Array();
					original_width = new Array();
				</script>
                <?php $this->assign('count', 1); ?>
				<?php $this->assign('array_count', '1'); ?>
                <?php $_from = $this->_tpl_vars['myobj']->list_playlist_block['showSlidelists']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['photoPlaylistKey'] => $this->_tpl_vars['photoplaylist']):
?>
                 <div class="clsListContents">
                     <div class="clsNewAlbumList <?php if ($this->_tpl_vars['count'] % 3 == 0): ?> clsThumbPhotoFinalRecord<?php endif; ?>">

                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <div>
                                                              <?php echo $this->_tpl_vars['myobj']->displayPhotoList($this->_tpl_vars['photoplaylist']['record']['photo_playlist_id'],true,4); ?>

                                  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

	                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "photosInSlideList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                                        <div class="clsAlbumContentDetails">
                            <p class="clsHeading">

								<a href="<?php if (( $this->_tpl_vars['photoplaylist']['record']['total_photos'] - $this->_tpl_vars['photoplaylist']['private_photo'] ) > 0): ?><?php echo $this->_tpl_vars['photoplaylist']['view_playlisturl']; ?>
 <?php else: ?> # <?php endif; ?>"  title="<?php echo $this->_tpl_vars['photoplaylist']['record']['photo_playlist_name']; ?>
">
								<?php echo $this->_tpl_vars['photoplaylist']['wordWrap_mb_ManualWithSpace_playlist_title']; ?>
</a>
                            </p>
                            <p class="clsAlbumContent">
                            	<?php if ($this->_tpl_vars['photoplaylist']['record']['total_photos'] <= 1): ?>
                                	<?php echo $this->_tpl_vars['LANG']['photoslidelist_photo']; ?>

                                <?php else: ?>
                                	<?php echo $this->_tpl_vars['LANG']['photoslidelist_photos']; ?>

                                <?php endif; ?>:&nbsp;<span><?php echo $this->_tpl_vars['photoplaylist']['record']['total_photos']; ?>
</span>
                            </p>
                             <p class="clsAlbumContent">
                                <?php if ($this->_tpl_vars['photoplaylist']['private_photo'] > 0): ?><?php echo $this->_tpl_vars['LANG']['photoslidelist_private_label']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['photoplaylist']['private_photo']; ?>
</span>&nbsp;|&nbsp;<?php endif; ?>
                                	<?php echo $this->_tpl_vars['LANG']['photoslidelist_total_views']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['photoplaylist']['record']['total_views']; ?>
</span>
                            </p>
							<p class="clsUserLink">
							<?php echo $this->_tpl_vars['LANG']['photoslidelist_createby']; ?>
:&nbsp;<span><a href="<?php echo $this->_tpl_vars['photoplaylist']['memberProfileUrl']; ?>
" alt="<?php echo $this->_tpl_vars['photoplaylist']['record']['alt_user_name']; ?>
" title="<?php echo $this->_tpl_vars['photoplaylist']['record']['alt_user_name']; ?>
"><?php echo $this->_tpl_vars['photoplaylist']['record']['user_name']; ?>
</a></span>
							</p>

                            <p class="clsAlbumContent">

								<a href="<?php if (( $this->_tpl_vars['photoplaylist']['record']['total_photos'] - $this->_tpl_vars['photoplaylist']['private_photo'] ) > 0): ?><?php echo $this->_tpl_vars['photoplaylist']['view_playlisturl']; ?>
 <?php else: ?> # <?php endif; ?>"  title="<?php echo $this->_tpl_vars['photoplaylist']['record']['photo_playlist_name']; ?>
">
                                <?php echo $this->_tpl_vars['LANG']['photoslidelist_view']; ?>

                                </a>
                            </p>

                            </div>
                         </div>
                         <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                 </div>
				 </div>
				<?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
                <?php endforeach; endif; unset($_from); ?>  </div></div>
                  <div id="bottomLinks" class="clsPhotoPaging">
              		 <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <?php endif; ?>
                  </div>
             <?php else: ?>
             	<div id="selMsgAlert">
             		<p><?php echo $this->_tpl_vars['LANG']['photoslidelist_no_records_found']; ?>
</p>
                </div>
            <?php endif; ?>

    <?php endif; ?>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
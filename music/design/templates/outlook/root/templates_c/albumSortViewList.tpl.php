<?php /* Smarty version 2.6.18, created on 2012-02-06 20:12:03
         compiled from albumSortViewList.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsAudioListContainer clsAudioPlayListContainer">
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('search_albumlist_block')): ?>
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <input type="hidden" name="advanceFromSubmission" value="1"/>
            <input type="hidden" name="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2>
                            <?php if ($this->_tpl_vars['myobj']->page_heading != ''): ?>
                                <?php echo $this->_tpl_vars['myobj']->page_heading; ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['LANG']['albumviewsort_title']; ?>

                            <?php endif; ?>
                        </h2>
                    </div>
                      <div class="clsHeadingRight clsVideoListHeadingRightLink clsAlphaShortListing">
                    	<h2>
						    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=albumlistnew','albumlistnew/','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['albumviewsort_album_normal_list_link']; ?>
"><?php echo $this->_tpl_vars['LANG']['albumviewsort_album_normal_list_link']; ?>
</a>
						</h2>
                    </div>
                    </div>
         </form>
    <?php endif; ?>
</div>
<div id="advancedAlbumlistSearch" class="clsAdvancedFilterContainer clsAdvancedFilterAlbumSortList">
		<form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <table class="clsAdvancedFilterTable">
                <tr>
                    <td class="clsAlphaListing">
                        <input class="clsTextBox" type="text" name="album_src_chr" id="album_src_chr" onfocus="clearValue('album_src_chr')"  onblur="setOldValue('album_src_chr')"
						 value="<?php if ($this->_tpl_vars['myobj']->getFormField('album_src_chr') == '' && $this->_tpl_vars['myobj']->getFormField('album_chr') == ''): ?><?php echo $this->_tpl_vars['LANG']['albumviewsort_no_of_title']; ?>
<?php else: ?><?php if ($this->_tpl_vars['myobj']->getFormField('album_src_chr') == ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('album_chr'); ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('album_src_chr'); ?>
<?php endif; ?><?php endif; ?>"/>
					    <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_src_chr'); ?>

						<?php echo $this->_tpl_vars['myobj']->ShowHelpTip('album_src_chr'); ?>

                    </td>
                    <td>
                        <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['albumviewsort_search']; ?>
" onclick="albumViewListRedirect(<?php echo $this->_tpl_vars['myobj']->getFormField('album_src_chr'); ?>
)" /></span></div>
                       <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                    </td>
                </tr>
            </table>
        </form>

 </div>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_albumlist_block')): ?>
    <div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
          <?php if ($this->_tpl_vars['myobj']->isResultsFound() && $this->_tpl_vars['showAlbumlists_arr']['row'] != ''): ?>
               <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                <div class="clsOverflow clsSortByLinksContainer">
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
                <div class="clsAlbumSortlistContent">
                    <div class="clsAlbumSortListTitle">
                        <h4 class=""><?php echo $this->_tpl_vars['myobj']->getFormField('album_chr'); ?>
</h4>
                    </div>
                    <div class="clsAlbumShotListDetails">
                        <table width="100%" class="">
                            <?php $_from = $this->_tpl_vars['showAlbumlists_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicAlbumlistKey'] => $this->_tpl_vars['musicalbumlist']):
?>
                            <tr>
								<td><?php echo $this->_tpl_vars['musicalbumlist']['album_title']; ?>
<?php echo $this->_tpl_vars['musicalbumlist']['song_count']; ?>
<?php echo $this->_tpl_vars['musicalbumlist']['album_title_end']; ?>
</td>
							</tr>
                            <?php endforeach; endif; unset($_from); ?>
                         </table>
                     </div>
                     <p class="clsBack">
                        <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumsortlist','','','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['albumviewsort_back']; ?>
"><?php echo $this->_tpl_vars['LANG']['albumviewsort_back']; ?>
 </a>
                     </p>
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
                    <input type="hidden" name="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
                <?php endif; ?>
                <?php else: ?>
                <div id="selMsgAlert">
                    <p><?php echo $this->_tpl_vars['LANG']['albumviewsort_no_records_found']; ?>
</p>
                </div>
                 <p class="clsBack">
                    <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumsortlist','','','','music'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['albumviewsort_back']; ?>
"><?php echo $this->_tpl_vars['LANG']['albumviewsort_back']; ?>
 </a>
                 </p>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
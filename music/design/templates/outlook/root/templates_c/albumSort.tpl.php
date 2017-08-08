<?php /* Smarty version 2.6.18, created on 2012-01-12 23:00:06
         compiled from albumSort.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsAudioListContainer clsAudioPlayListContainer">
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('search_albumlist_block')): ?>
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2>
                            <?php if ($this->_tpl_vars['myobj']->page_heading != ''): ?>
                                <?php echo $this->_tpl_vars['myobj']->page_heading; ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['LANG']['albumsort_title']; ?>

                            <?php endif; ?>
                        </h2>
                    </div>
                    <div class="clsHeadingRight clsVideoListHeadingRightLink clsAlphaShortListing">
                    	<h2><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('albumlist','?pg=albumlistnew','albumlistnew/','','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['albumsort_album_normal_list_link']; ?>
</a></h2>
                    </div>
                    </div>
    <?php endif; ?>

<div id="advancedAlbumlistSearch" class="clsAdvancedFilterContainer clsAdvancedFilterAlbumSortList">

		<form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <table class="clsAdvancedFilterTable">
                <tr>
                    <td class="clsAlphaListing">
                        <input class="clsTextBox" type="text" name="album_chr" id="album_chr" onfocus="clearValue('album_chr')"  onblur="setOldValue('album_chr')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('album_chr') == ''): ?><?php echo $this->_tpl_vars['LANG']['albumsort_no_of_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('album_chr'); ?>
<?php endif; ?>"/>
                        <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('album_chr'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('album_chr'); ?>

                    </td>
                    <td>
                        <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['albumsort_search']; ?>
" onclick="albumViewListRedirect(<?php echo $this->_tpl_vars['myobj']->getFormField('album_chr'); ?>
)" /></span></div>
                       <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" value="Reset" id="avd_reset" name="avd_reset"/></span></div>
                    </td>
                </tr>
            </table>
        </form>

 </div>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_albumlist_block')): ?>
		<div id="selMusicPlaylistManageDisplay" class="clsLeftSideDisplayTable">
		  <form name="selFormAlbumList" id="selFormAlbumList" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
		  <?php if ($this->_tpl_vars['myobj']->isResultsFound() && $this->_tpl_vars['showAlbumlists_arr']['row'] != ''): ?>
			   <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
				<div class="clsOverflow clsSortByLinksContainer">
					<div class="clsAudioPaging">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
				</div>
				<?php endif; ?>

					<?php $_from = $this->_tpl_vars['showAlbumlists_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicAlbumlistKey'] => $this->_tpl_vars['musicalbumlist']):
?>
						<?php if ($this->_tpl_vars['musicalbumlist']['album_chr'] != ''): ?><div class="clsListContents clsAlbumSortlistContent"><div class="clsAlbumSortListTitle">
							<h4><?php echo $this->_tpl_vars['musicalbumlist']['album_chr']; ?>
</h4>
                            <span><a href="<?php echo $this->_tpl_vars['musicalbumlist']['album_chr_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['albumsort_view_all_title']; ?>
"><?php echo $this->_tpl_vars['LANG']['albumsort_view_all_title']; ?>
</a></span></div>
						   <?php echo $this->_tpl_vars['myobj']->populateAlbumSortTitle($this->_tpl_vars['musicalbumlist']['album_chr']); ?>

						   <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

						   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "albumSortList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
						</div>
					<?php endforeach; endif; unset($_from); ?>

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
				<p><?php echo $this->_tpl_vars['LANG']['albumsort_no_records_found']; ?>
</p>
			</div>
		<?php endif; ?>
        <input type="hidden" name="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
" />
		</form>
			</div>
		<?php endif; ?>
    </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
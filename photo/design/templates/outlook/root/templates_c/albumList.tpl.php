<?php /* Smarty version 2.6.18, created on 2012-01-21 09:22:17
         compiled from albumList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'albumList.tpl', 173, false),)), $this); ?>
<?php echo '
	<script type="text/javascript">
		// REQUIRED GLOBAL VARS
		var t;
		var counter = 0;
		var timer   = 1000;

		function switchImages(albumImages, img_id)
		{
			var images = albumImages.split(\',\');
			var numImages = images.length;
			if (document.getElementById(img_id)){
				document.getElementById(img_id).src   = images[counter];
				counter++;
				if(counter >= numImages){
					counter = 0;
				}
			}
			t = setTimeout(\'switchImages(\\\'\'+albumImages+\'\\\',\\\'\'+img_id+\'\\\')\', timer);
		}

		function setDefaultAlbumImage(defaultImage, img_id)
		{
			clearTimeout(t);
			c=0;
			counter=0;
			if (document.getElementById(img_id))
				document.getElementById(img_id).src = defaultImage;
		}
   </script>
'; ?>


<div class="clsPhotoListContainer clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('search_albumlist_block')): ?>
        <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
            <input type="hidden" name="advanceFromSubmission" value="1"/>
            <input type="hidden" name="start" value="<?php echo $this->_tpl_vars['myobj']->getFormField('start'); ?>
"/>
            <div class="clsOverflow">
                    <div class="clsHeadingLeft">
                        <h2><span>
                            <?php if ($this->_tpl_vars['myobj']->page_heading != ''): ?>
                                <?php echo $this->_tpl_vars['myobj']->page_heading; ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['LANG']['photoalbumList_title']; ?>

                            <?php endif; ?></span>
                        </h2>
                    </div>
                    <div class="clsHeadingRight">
                                            </div>
                </div>
                                <div class="clsAdvancedFilterSearch clsAdvancedFilterSearchAlignment">
                      <div style="float:left">
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsShow"  id="show_link" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['photoalbumList_show_advanced_filters']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['photoalbumList_show_advanced_filters']; ?>
</span></a>
                        <a onclick="divShowHide('advancedAlbumlistSearch', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['photoalbumList_hide_advanced_filters']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['photoalbumList_hide_advanced_filters']; ?>
</span></a>
                      </div>
                      <?php if ($this->_tpl_vars['CFG']['admin']['photos']['album_image_swap']): ?>
                      <div class="clsGlimpse">
                      	<?php echo $this->_tpl_vars['LANG']['photoalbumList_mouseover_message']; ?>

	                  </div>
                      <?php endif; ?>
                    </div>
                <div id="advancedAlbumlistSearch" class="clsAdvancedFilterContainer" <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:block <?php else: ?> style="display:none;  <?php endif; ?>margin:0 0 10px 0;"  >
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
                                    <input class="clsTextBox" type="text" name="albumlist_title" id="albumlist_title"   value="<?php if ($this->_tpl_vars['myobj']->getFormField('albumlist_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['photoalbumList_albumList_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('albumlist_title'); ?>
<?php endif; ?>" onblur="setOldValue('albumlist_title')"  onfocus="clearValue('albumlist_title')"/>
                                </td>
                                <td>
                                    <input class="clsTextBox" type="text" name="photo_title" id="photo_title" onfocus="clearValue('photo_title')"  onblur="setOldValue('photo_title')" value="<?php if ($this->_tpl_vars['myobj']->getFormField('photo_title') == ''): ?><?php echo $this->_tpl_vars['LANG']['photoalbumList_no_of_photo_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('photo_title'); ?>
<?php endif; ?>" />
                                </td>
                            </tr>
	                        <tr>
    	                        <td colspan="2">
        	                        <div class="clsSearchButton-l"><span class="clsSearchButton-r"><input type="submit" name="search" id="search" value="<?php echo $this->_tpl_vars['LANG']['photoalbumList_search']; ?>
" onclick="document.seachAdvancedFilter.start.value = '0';" /></span></div>
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

                <?php endif; ?>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_albumlist_block')): ?>
                    <div id="selphotoPlaylistManageDisplay" class="clsLeftSideDisplayTable">
                        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                                      <div class="clsPhotoPaging clsSlideBorder">
                                      <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                                         <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                                          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                       <?php endif; ?>
                                      </div>
                        <!-- top pagination end-->
                        <div class="clsOverflow">
                            <form name="photoListForm" id="photoListForm" action="<?php echo $this->_tpl_vars['_SERVER']['PHP_SELF']; ?>
" method="post">
                            <?php $this->assign('count', 1); ?>
                            <?php $this->assign('i', 0); ?>
                            <?php $_from = $this->_tpl_vars['myobj']->list_albumlist_block['showAlbumlists']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['photoAlbumlistKey'] => $this->_tpl_vars['photoalbumlist']):
?>
                                    <div class="clsNewAlbumList <?php if ($this->_tpl_vars['count'] % 3 == 0): ?> clsThumbPhotoFinalRecord<?php endif; ?>">
                                    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        								<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                            <div class="clsThumb">
                                                    <input type="hidden" name="photo_album_id" id="photo_album_id" value="<?php echo $this->_tpl_vars['photoalbumlist']['record']['photo_album_id']; ?>
" />
                                                    <div <?php if ($this->_tpl_vars['photoalbumlist']['total_photo'] > 0 && $this->_tpl_vars['photoalbumlist']['photo_image_src'] != ''): ?>class="clsLargeThumbImageBackground clsNoLink"<?php endif; ?>>
                                                      <div class="clsPhotoThumbImageOuter" <?php if ($this->_tpl_vars['photoalbumlist']['total_photo'] > 0 && $this->_tpl_vars['photoalbumlist']['photo_image_src'] != ''): ?>onclick="Redirect2URL('<?php echo $this->_tpl_vars['photoalbumlist']['getUrl_viewAlbum_url']; ?>
')"<?php endif; ?>>
                                                        <div class="cls146x112 clsImageHolder clsImageBorderBg">
                                                                <?php if ($this->_tpl_vars['photoalbumlist']['photo_image_src'] != ''): ?>
                                                                    <img id="img_<?php echo $this->_tpl_vars['i']; ?>
" src="<?php echo $this->_tpl_vars['photoalbumlist']['photo_image_src']; ?>
" <?php echo $this->_tpl_vars['photoalbumlist']['photo_disp']; ?>
 title="<?php echo $this->_tpl_vars['photoalbumlist']['photo_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoalbumlist']['photo_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
" <?php if ($this->_tpl_vars['CFG']['admin']['photos']['album_image_swap']): ?> onmouseover="switchImages('<?php echo $this->_tpl_vars['photoalbumlist']['album_image']; ?>
','img_<?php echo $this->_tpl_vars['i']; ?>
');" onmouseout="setDefaultAlbumImage('<?php echo $this->_tpl_vars['photoalbumlist']['photo_image_src']; ?>
','img_<?php echo $this->_tpl_vars['i']; ?>
');"<?php endif; ?>/>
                                                                <?php else: ?>
                                                                    <img   src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noAlbumImage.jpg" title="<?php echo $this->_tpl_vars['photoalbumlist']['photo_title']; ?>
" alt="<?php echo $this->_tpl_vars['LANG']['common_no_images']; ?>
"/>
                                                                <?php endif; ?>
                                                            </div>
                                                       </div>
                                                      </div>
                                                </div>
                                                <!--div class="clsPlayerImage">
                                                    <p class="clsPhotoListLink"><a href="javascript:void(0)" onclick="javascript: myLightWindow.activateWindow(<?php echo '{'; ?>
type:'external',href:'<?php echo $this->_tpl_vars['photoalbumlist']['light_window_url']; ?>
',title:'<?php echo $this->_tpl_vars['LANG']['photoalbumList_photo_list']; ?>
',width:550,height:350<?php echo '}'; ?>
);" title="<?php echo $this->_tpl_vars['LANG']['photoalbumList_allphotodetail_helptips']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoalbumList_photo_list']; ?>
</a></p>
                                                </div-->
                                            <div class="clsAlbumContentDetails">
                                                    <p class="clsHeading clsTitleWrap">
                                                        <?php if ($this->_tpl_vars['photoalbumlist']['total_photo'] > 0 && $this->_tpl_vars['photoalbumlist']['photo_image_src'] != ''): ?>
                                                        	<a  href="<?php echo $this->_tpl_vars['photoalbumlist']['getUrl_viewAlbum_url']; ?>
" title="<?php echo $this->_tpl_vars['photoalbumlist']['word_wrap_album_title']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['photoalbumlist']['word_wrap_album_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</a>
                                                        <?php else: ?>
                                                        	<span class="clsNoPhotoLink" title="<?php echo $this->_tpl_vars['photoalbumlist']['word_wrap_album_title']; ?>
"><?php echo $this->_tpl_vars['photoalbumlist']['word_wrap_album_title']; ?>
</span>
                                                        <?php endif; ?>
                                                    </p>
                                                    <p>
                                                    	<?php if ($this->_tpl_vars['photoalbumlist']['total_photo'] <= 1): ?>
                                                        	<?php echo $this->_tpl_vars['LANG']['photoalbumList_photo']; ?>
:&nbsp;
                                                            <span><?php echo $this->_tpl_vars['photoalbumlist']['total_photo']; ?>
</span>
                                                        <?php else: ?>
                                                        	<?php echo $this->_tpl_vars['LANG']['photoalbumList_photos']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['photoalbumlist']['total_photo']; ?>
</span>
                                                        <?php endif; ?>
                                                        <?php if ($this->_tpl_vars['photoalbumlist']['private_photo'] > 0): ?>&nbsp;|&nbsp;<?php echo $this->_tpl_vars['LANG']['photoalbumList_private']; ?>
:&nbsp;
                                                        	<span><?php echo $this->_tpl_vars['photoalbumlist']['private_photo']; ?>
</span>
                                                        <?php endif; ?>
                                                     </p>

                                                    
                                                                                                 <div class="clsAlbumContent">
                                                 <p>
                                                 	<?php if ($this->_tpl_vars['photoalbumlist']['total_photo'] > 0 && $this->_tpl_vars['photoalbumlist']['photo_image_src'] != ''): ?>
	                                                    <a  href="<?php echo $this->_tpl_vars['photoalbumlist']['getUrl_viewAlbum_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['photoalbumList_view_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['photoalbumList_view_album']; ?>
</a>
                                                    <?php else: ?>
                                                       	<?php echo $this->_tpl_vars['LANG']['photoalbumList_view_album']; ?>

                                                    <?php endif; ?>
                                                    &nbsp;|

                                                  	<?php if ($this->_tpl_vars['photoalbumlist']['total_photo'] > 0 && $this->_tpl_vars['photoalbumlist']['photo_image_src'] != ''): ?>
                                                      	<!--a href="javascript:void(0);" onclick="openSlodeListShow('<?php echo $this->_tpl_vars['photoalbumlist']['view_albumplaylisturl']; ?>
')"-->
														<a href="<?php echo $this->_tpl_vars['photoalbumlist']['view_albumplaylisturl']; ?>
"  title="<?php echo $this->_tpl_vars['LANG']['photoalbumList_slideshow_album']; ?>
">
                                                          	<?php echo $this->_tpl_vars['LANG']['photoalbumList_slideshow_album']; ?>

                                                        </a>
                                                    <?php else: ?>
                                                      	<?php echo $this->_tpl_vars['LANG']['photoalbumList_slideshow_album']; ?>

		                                            <?php endif; ?>
                                                 </p>
                                             </div>
                                                    <!--p><?php echo $this->_tpl_vars['LANG']['photoalbumList_view']; ?>
:&nbsp;<?php echo $this->_tpl_vars['photoalbumlist']['record']['total_views']; ?>
</p-->
                                                </div>
                                     	  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        								  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                                     </div>
                             <?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
                            <?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
                            <?php endforeach; endif; unset($_from); ?>
                              </form>
                              </div>
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
                                </form>
                        <?php else: ?>
                        <div id="selMsgAlert">
                            <p><?php echo $this->_tpl_vars['LANG']['photoalbumList_no_records_found']; ?>
</p>
                        </div>
                    <?php endif; ?>
                    </div>
                    <?php endif; ?>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
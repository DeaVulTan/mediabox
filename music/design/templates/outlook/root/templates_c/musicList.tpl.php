<?php /* Smarty version 2.6.18, created on 2011-11-08 15:10:54
         compiled from musicList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'musicList.tpl', 243, false),array('modifier', 'truncate', 'musicList.tpl', 340, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsAudioListContainer">
<script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['project_path_relative']; ?>
js/AG_ajax_html.js"></script>
<script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditMusicComments','selMsgCartSuccess');
	var max_width_value = "<?php echo $this->_tpl_vars['CFG']['admin']['musics']['get_code_max_size']; ?>
";
	var delLink_value;
</script>
<?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
				<?php echo $this->_tpl_vars['myobj']->populatePlayerWithPlaylist($this->_tpl_vars['music_fields']); ?>

	<input type="hidden" name="hidden_player_status" id="hidden_player_status" value="" />
    <?php endif; ?>
    <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
        <div class="clsOverflow">
	        <input type="hidden" name="advanceFromSubmission" value="1"/>
			<?php echo $this->_tpl_vars['myobj']->populateMusicListHidden($this->_tpl_vars['paging_arr']); ?>


              <div class="clsHeadingLeft">
                <h2>
                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'usermusiclist'): ?>
                  <?php echo $this->_tpl_vars['LANG']['musiclist_title']; ?>

                <?php else: ?>
                  <?php echo $this->_tpl_vars['LANG']['musiclist_title']; ?>

                <?php endif; ?>
               </h2>
              </div>
              <div class="clsHeadingRight">
                <input type="hidden" name="default" id="default" value="<?php echo $this->_tpl_vars['myobj']->getFormField('default'); ?>
" />
                <select name="select" onchange="loadUrl(this)" id="musicselect">
					<option value="<?php  echo getUrl('musiclist','?pg=musicnew','musicnew/','','music') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == ''): ?> selected="selected" <?php endif; ?> ><?php echo $this->_tpl_vars['LANG']['header_nav_music_music_all']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=musicrecent','musicrecent/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicrecent'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_music_new']; ?>
 </option>
                    <!--<option value="<?php  echo getUrl('musiclist','?pg=randommusic','randommusic/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'randommusic'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_music_random']; ?>
 </option>-->
                    <option value="<?php  echo getUrl('musiclist','?pg=musictoprated','musictoprated/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musictoprated'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_top_rated']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=musicrecommended','musicrecommended/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicrecommended'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_recommended']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=musicmostviewed','musicmostviewed/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostviewed'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_viewed']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=musicmostdiscussed','musicmostdiscussed/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostdiscussed'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_discussed']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=musicmostfavorite','musicmostfavorite/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostfavorite'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_favorite']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=musicmostrecentlyviewed','musicmostrecentlyviewed/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostrecentlyviewed'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_recently_viewed']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=featuredmusiclist','featuredmusiclist/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'featuredmusiclist'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_most_featuredmusiclist']; ?>
</option>
                    <!--<option value="<?php  echo getUrl('musiclist','?pg=musicmostlinked','musicmostlinked/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostlinked'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_most_linked']; ?>
</option>
                    <option value="<?php  echo getUrl('musiclist','?pg=musicmostresponded','musicmostresponded/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostresponded'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_most_responded']; ?>
</option>-->
                  <!--<option value="<?php  echo getUrl('albumlist','?pg=albumlistnew','albumlistnew/','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'albummusiclist'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_album_list']; ?>
 </option>-->
                    <!--<option value="<?php  echo getUrl('musiccategory','','','','music') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musiccategory'): ?> selected <?php endif; ?> >
                    <?php echo $this->_tpl_vars['LANG']['header_nav_music_music_category']; ?>
 </option>-->
                </select>
              </div>
          </div>
          <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostviewed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostdiscussed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'musicmostfavorite'): ?>
              <div class="clsMostDiscusTab">
			  <div class="clsAudioListMenu">
                <ul>
                  <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['musicMostViewed_0']; ?>
><a href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_0']; ?>
');"><span ><?php echo $this->_tpl_vars['LANG']['header_nav_members_all_time']; ?>
</span></a></li>
                  <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['musicMostViewed_1']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_1']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_today']; ?>
</span></a></li>
                  <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['musicMostViewed_2']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_2']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_yesterday']; ?>
</span></a></li>
                  <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['musicMostViewed_3']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_3']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_week']; ?>
</span></a></li>
                  <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['musicMostViewed_4']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_4']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_month']; ?>
</span></a></li>
                  <li <?php echo $this->_tpl_vars['musicActionNavigation_arr']['musicMostViewed_5']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['musicActionNavigation_arr']['music_list_url_5']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_year']; ?>
</span></a></li>
                </ul>
              </div>
			  </div>
              <?php echo '
                  <script type="text/javascript">
                    function jumpAndSubmitForm(url)
                      {
                        document.seachAdvancedFilter.start.value = \'0\';
						document.seachAdvancedFilter.action=url;
                        document.seachAdvancedFilter.submit();
                      }
                    var subMenuClassName1=\'clsAudioListMenu\';
                    var hoverElement1  = \'.clsAudioListMenu li\';
                    loadChangeClass(hoverElement1,subMenuClassName1);
                  </script>
              '; ?>

          <?php endif; ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_sub_category')): ?>
                <?php if ($this->_tpl_vars['populateSubCategories_arr']['row']): ?>
                <?php endif; ?>
                <div id="selShowAllShoutouts" class="clsDataTable">
               		<table id="selCategoryTable" class="clsSubCategoryTable">
                <?php $_from = $this->_tpl_vars['populateSubCategories_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subCategoryItem'] => $this->_tpl_vars['subCategoryValue']):
?>
                <?php echo $this->_tpl_vars['subCategoryValue']['open_tr']; ?>

                <td id="selVideoGallery_<?php echo $this->_tpl_vars['subCategoryItem']; ?>
" class="clsVideoCategoryCell">
                    <div id="selImageDet">
                    <h3>
                        <div class="clsOverflow"><span class="clsViewThumbImage">
                        <a href="<?php echo $this->_tpl_vars['subCategoryValue']['music_list_url']; ?>
">
                        <img src="<?php echo $this->_tpl_vars['subCategoryValue']['imageSrc']; ?>
" /></a>
                        </span></div>
                        <a href="<?php echo $this->_tpl_vars['subCategoryValue']['music_list_url']; ?>
">
                        <?php echo $this->_tpl_vars['subCategoryValue']['music_category_name_manual']; ?>

                        </a>
                    </h3>
                    </div>
                </td>
                <?php echo $this->_tpl_vars['subCategoryValue']['end_tr']; ?>

                <?php endforeach; else: ?>
                <?php endif; unset($_from); ?>
                </table>
                </div>
			<?php endif; ?>
         <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'albumlist'): ?>
		 <div class="clsOverflow clsshowhidefiltersblock">
        	<div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                <a href="javascript:void(0)" id="show_link" class="clsShow"  <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['musiclist_show_adv_search']; ?>
</span></a>
                <a href="javascript:void(0)" id="hide_link" <?php if (! $this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> class="clsHide"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['musiclist_hide_adv_search']; ?>
</span></a>
             </div>
			 <div class="clsAdvancedFilterSearch clsOverflow clsFloatLeft">
                <a href="javascript:void(0)" id="show_alpha_link" class="clsShow"  <?php if ($this->_tpl_vars['myobj']->chkAlphabeticalResultFound()): ?>  style="display:none" <?php endif; ?> onclick="divShowHide('alpha_search', 'show_alpha_link', 'hide_alpha_link')"><span><?php echo $this->_tpl_vars['LANG']['musiclist_show_alpha_search']; ?>
</span></a>
                <a href="javascript:void(0)" id="hide_alpha_link" <?php if (! $this->_tpl_vars['myobj']->chkAlphabeticalResultFound()): ?>  style="display:none" <?php endif; ?> class="clsHide"  onclick="divShowHide('alpha_search', 'show_alpha_link', 'hide_alpha_link')"><span><?php echo $this->_tpl_vars['LANG']['musiclist_hide_alpha_search']; ?>
</span></a>
             </div>
			</div>
            <div id="advanced_search" class="clsAdvancedFilterTable clsOverflow" <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:block <?php else: ?> style="display:none;  <?php endif; ?>margin:1px 0 10px;" >
				<div class="clsAdvanceSearchIcon">
              	  <table class="">
                <tr>
	             <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
	                   <td>
	                    <input class="clsTextBox" type="text" name="advan_music_artist" id="advan_music_artist" value="<?php if ($this->_tpl_vars['myobj']->getFormField('advan_music_artist') == ''): ?><?php echo $this->_tpl_vars['LANG']['musiclist_artist_cast']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('advan_music_artist'); ?>
<?php endif; ?>" onblur="setOldValue('advan_music_artist')"  onfocus="clearValue('advan_music_artist', '<?php echo $this->_tpl_vars['LANG']['musiclist_artist_cast']; ?>
')"/>
	                  </td>
	                  <?php else: ?>
                     <td>
	                    <input class="clsTextBox" type="text" name="advan_music_user_name" id="advan_music_user_name" value="<?php if ($this->_tpl_vars['myobj']->getFormField('advan_music_user_name') == ''): ?><?php echo $this->_tpl_vars['LANG']['musiclist_user_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('advan_music_user_name'); ?>
<?php endif; ?>" onblur="setOldValue('advan_music_user_name')"  onfocus="clearValue('advan_music_user_name', '<?php echo $this->_tpl_vars['LANG']['musiclist_user_name']; ?>
')"/>
	                  </td>
	              <?php endif; ?>
                  <td>
                    <input class="clsTextBox" type="text" name="advan_music_album_name" id="advan_music_album_name" value="<?php if ($this->_tpl_vars['myobj']->getFormField('music_album_name') == ''): ?> <?php echo $this->_tpl_vars['LANG']['musiclist_album_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('music_album_name'); ?>
<?php endif; ?>" onblur="setOldValue('advan_music_album_name')"  onfocus="clearValue('advan_music_album_name', '<?php echo $this->_tpl_vars['LANG']['musiclist_album_name']; ?>
')" />
                  </td>
                </tr>
                <tr>
                  <td>
                    <input class="clsTextBox" type="text" name="music_tags" id="music_tags" value="<?php if ($this->_tpl_vars['myobj']->getFormField('music_tags') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('music_tags'); ?>
<?php elseif ($this->_tpl_vars['myobj']->getFormField('tags') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('tags'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['musiclist_tags']; ?>
<?php endif; ?>" onblur="setOldValue('music_tags')"  onfocus="clearValue('music_tags', '<?php echo $this->_tpl_vars['LANG']['musiclist_tags']; ?>
')"/>
                  </td>
                <td>
                  <select name="run_length" id="run_length">
                  <option value=""><?php echo $this->_tpl_vars['LANG']['musiclist_run_length']; ?>
</option>
                  <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->MUSICRUN_LENGTH_ARR,$this->_tpl_vars['myobj']->getFormField('run_length')); ?>

                  </select>
				</td>

                </tr>
                <tr>
                  <td>
                  <select name="added_within" id="added_within">
                  <option value=""><?php echo $this->_tpl_vars['LANG']['musiclist_added_within']; ?>
</option>
                  <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->ADDED_WITHIN_ARR,$this->_tpl_vars['myobj']->getFormField('added_within')); ?>

                  </select>
                  </td>
                  <td>
    	          	  <select name="music_language" id="music_language">
	                    <option value=""><?php echo $this->_tpl_vars['LANG']['musiclist_language_list']; ?>
</option>
                        <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_LANGUAGE_ARR,$this->_tpl_vars['myobj']->getFormField('music_language')); ?>

                      </select>
                  </td>
                </tr>
                </table>
				</div>
				<div class="clsAdvancedSearchBtn">
					<table>
						<tr>
                  <td valign="middle">
                  <div class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="<?php echo $this->_tpl_vars['LANG']['musiclist_search_categories_musics_submit']; ?>
" /></span></div>
				  </td></tr>
				  <tr>
				  <td>
                  <div class="clsCancelButton1-l"><span class="clsCancelButton1-r"><input type="submit" name="avd_reset" id="avd_reset" value="<?php echo $this->_tpl_vars['LANG']['musiclist_reset_submit']; ?>
" /></span></div>                  </td>
                </tr>
					</table>
				</div>
              </div>

                <div id="alpha_search" <?php if ($this->_tpl_vars['myobj']->chkAlphabeticalResultFound()): ?>  style="display:block <?php else: ?> style="display:none;  <?php endif; ?>margin:1px 0 10px;" >
			  		<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
					<div class="clsAlpahbetPaging">
			  			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

              			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "alphabetPagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			  			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			  		</div>
            		<?php endif; ?>
                </div>

          <?php endif; ?>
     </form>

          <!--FORM End-->
          <div id="selLeftNavigation">
            <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmText"></p>
              <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                      <div><p id="selImageBorder" class="clsPlainImageBorder">
                       <span id="delete_music_msg_id"> </span>
					    <p id="selPlainCenterImage">
                          <img id="selVideoId" border="0" src="" alt=""/>
                        </p>
                      </p>
                    </div>
                  <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                  <input type="button" class="clsCancelButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
                  <input type="hidden" name="act" id="act" />
                  <input type="hidden" name="music_id" id="music_id" />
              </form>
            </div>
            <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
              <p id="msgConfirmTextMulti"><?php echo $this->_tpl_vars['LANG']['musiclist_multi_delete_confirmation']; ?>
</p>
              <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
                <input type="hidden" name="music_id" id="music_id" />
                <input type="hidden" name="act" id="act" />
              </form>
            </div>
            <div id="selMsgCartSuccess" class="clsPopupConfirmation" style="display:none;">
              <p id="selCartAlertSuccess"></p>
              <form name="msgCartFormSuccess" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_option_ok']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
              </form>
            </div>
            <div id="selEditMusicComments" class="clsPopupConfirmation" style="display:none;"></div>
            <form name="musicListForm" id="musicListForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
            <?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
            <div class="clsSelectAllLinks clsOverflow">
              <p class="clsListCheckBox"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.musicListForm.name, document.musicListForm.check_all.name)"/></p>
              <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['music_list_play']; ?>
" onClick="getMultiCheckBoxValue('musicListForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(multiCheckValue!='') playInPlayListPlayer(multiCheckValue);"/></span></p>
              <?php if (isMember ( )): ?>
              	<?php if ($this->_tpl_vars['myobj']->allow_quick_mixs): ?>
                      <p class="clsCancelButton-l"><span class="clsCancelButton-r" id="quick_mix"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['common_music_add_to_quick_mix']; ?>
" onclick="getMultiCheckBoxValueForQuickMix('musicListForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musicManage_err_tip_select_musics']; ?>
');if(quickMixmultiCheckValue!='') updateMusicsQuickMixCount(quickMixmultiCheckValue);"/></span></p>
                 <?php endif; ?>
					<p class="clsCancelButton-l"><span class="clsCancelButton-r"><input type="button" value="<?php echo $this->_tpl_vars['LANG']['common_music_add_to_playlist']; ?>
" onclick="getMultiCheckBoxValue('musicListForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['musiclist_select_titles']; ?>
');if(multiCheckValue!='') return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'select', multiCheckValue);" /></span></p>
                 <?php echo $this->_tpl_vars['myobj']->populatePlaylist(); ?>

              <?php endif; ?>

              <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'mymusics' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritemusics' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myplaylist' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending'): ?>
                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'mymusics' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending'): ?>
                  <a href="javascript:void(0)" id="dAltMulti"></a>
                  <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                  <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onclick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['musiclist_select_titles']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_musics_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['musiclist_delete_confirmation']; ?>
','musicListForm','music_id','mymusicdelete');"/></span></p>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myplaylist'): ?>
                 <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                    <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                    tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onclick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['musiclist_select_titles']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_musics_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['musiclist_delete_confirmation']; ?>
','musicListForm','music_id','myPlaylistMusicDelete');" /></span></p>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritemusics'): ?>
                   <p class="clsCancelButton-l"><span class="clsCancelButton-r">
                  <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onclick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['musiclist_select_titles']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_musics_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['musiclist_favorite_delete_confirmation']; ?>
','musicListForm','music_id','myFavoriteMusicsDelete');" /></span></p>
                <?php endif; ?>
              <?php endif; ?>
              </div>
              <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
              <?php endif; ?>
            <div class="clsOverflow clsSortByLinksContainer">
              <div class="clsSortByLinks">

				 <!-- class="clsActive" -->
				 <ul class="clsOverflow">
				 	<li> <?php echo $this->_tpl_vars['LANG']['music_list_sort_by']; ?>
 </li>
                    <li><a class="<?php echo $this->_tpl_vars['musicViewNavigation_arr1']; ?>
" href="javascript:void(0);" onclick="jumpAndFormsubmit('<?php echo $this->_tpl_vars['LANG']['music_list_title']; ?>
');return false;" title="<?php echo $this->_tpl_vars['LANG']['music_list_title']; ?>
"><?php echo $this->_tpl_vars['LANG']['music_list_title']; ?>
</a></li>
                  <li>|</li>
				   <li><a class="<?php echo $this->_tpl_vars['musicViewNavigation_arr2']; ?>
" href="javascript:void(0);" onclick="jumpAndFormsubmit('<?php echo $this->_tpl_vars['LANG']['music_list_album']; ?>
');return false;" title="<?php echo $this->_tpl_vars['LANG']['music_list_album']; ?>
"><?php echo $this->_tpl_vars['LANG']['music_list_album']; ?>
</a></li>
				  </ul>
                 <!-- | <a  class="<?php echo $this->_tpl_vars['musicViewNavigation_arr3']; ?>
" href="#" onclick="jumpAndFormsubmit('<?php echo $this->_tpl_vars['LANG']['music_list_artist']; ?>
');"><?php echo $this->_tpl_vars['LANG']['music_list_artist']; ?>
</a>-->
              </div>
              <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_musics_form')): ?>
                <div class="clsSortByPagination">
                      <div class="clsAudioPaging">
                          <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
								<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                          <?php endif; ?>
                      </div>
                </div>
            </div>
            <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['myobj']->my_musics_form['anchor']; ?>
"></a>
			<div class="clsMusicListingMainBlock">
              <?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
                      <?php $this->assign('count', 0); ?>
                      <?php $this->assign('song_id', 1); ?>
                      <?php $_from = $this->_tpl_vars['music_list_result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['music'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['music']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['result']):
        $this->_foreach['music']['iteration']++;
?>
                      <?php if ($this->_foreach['music']['iteration']%$this->_tpl_vars['myobj']->my_musics_form['showMusicList']['musicsPerRow'] == 1): ?>
                      <?php endif; ?>
                            <div class="clsListContents">
                                    <div class="clsOverflow">
                                      <p class="clsListCheckBox">
                                              <input type="checkbox" name="checkbox[]" id="view_music_checkbox_<?php echo $this->_tpl_vars['result']['record']['music_id']; ?>
" value="<?php echo $this->_tpl_vars['result']['record']['music_id']; ?>
" onclick="disableHeading('musicListForm');"/></p>
                                      <div class="clsThumb">
                                                <div class="clsLargeThumbImageBackground clsNoLink">
													  <a id="<?php echo $this->_tpl_vars['result']['anchor']; ?>
"></a>
                                                      <?php if ($this->_tpl_vars['result']['img_src']): ?>
                                                      <a  href="<?php echo $this->_tpl_vars['result']['view_music_link']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls144x110"><img src="<?php echo $this->_tpl_vars['result']['img_src']; ?>
" title="<?php echo $this->_tpl_vars['result']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['result']['record']['thumb_width'],$this->_tpl_vars['result']['record']['thumb_height']); ?>
/></a>
                                                      <?php else: ?>
                                                      <p class="ClsImageContainer ClsImageBorder1 Cls144x110"><img src="<?php echo $this->_tpl_vars['album_music_count_list'][$this->_tpl_vars['result']['music_album_id']]['img_src']; ?>
"  title="<?php echo $this->_tpl_vars['result']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['album_music_count_list'][$this->_tpl_vars['result']['music_album_id']]['thumb_width'],$this->_tpl_vars['album_music_count_list'][$this->_tpl_vars['result']['music_album_id']]['thumb_height']); ?>
/></p>
                                              <?php endif; ?>
                                        </div>
                                      <div class="clsTime"><!----><?php echo $this->_tpl_vars['result']['playing_time']; ?>
</div>

                                      </div>
                                      <div class="clsPlayerImage">
									  		 <?php if ($this->_tpl_vars['result']['record']['allow_ratings'] == 'Yes'): ?>
											 <p>
                                        	<?php if ($this->_tpl_vars['myobj']->populateRatingDetails($this->_tpl_vars['result']['rating'])): ?>
                                                <?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages($this->_tpl_vars['result']['rating'],'music'); ?>

                                            <?php else: ?>
                                               	<?php echo $this->_tpl_vars['myobj']->populateMusicRatingImages(0,'music'); ?>

                                            <?php endif; ?>	<span>&nbsp; ( <?php echo $this->_tpl_vars['result']['record']['rating_count']; ?>
 )</span>
											</p>
                                         <?php endif; ?>
										 <div class="clsOverflow clsFloatRight clsPlayQuickmix">

                                        <?php if ($this->_tpl_vars['result']['add_quickmix']): ?>
											<div class="clsFloatRight">
                                                <?php if ($this->_tpl_vars['result']['is_quickmix_added']): ?>
                                                      <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['result']['music_id']; ?>
"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['music_list_added_to_quickmix']; ?>
" ><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>
                                                <?php else: ?>
                                                      <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['result']['music_id']; ?>
" style="display:none"><a href="javascript:void(0)" class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['music_list_added_to_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>

                                                      <p class="clsQuickMix" id="quick_mix_<?php echo $this->_tpl_vars['result']['music_id']; ?>
"><a href="javascript:void(0)" onclick="updateMusicsQuickMixCount('<?php echo $this->_tpl_vars['result']['music_id']; ?>
')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['music_list_add_to_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_music_quick_mix']; ?>
</a></p>
                                               <?php endif; ?>
											   </div>
                                         <?php endif; ?>
										  <div class="clsPlayerIcon clsFloatRight">
                                          	<a class="clsPlaySong" id="play_music_icon_<?php echo $this->_tpl_vars['result']['music_id']; ?>
" onclick="playSelectedSong(<?php echo $this->_tpl_vars['result']['music_id']; ?>
)" href="javascript:void(0)"></a>
                                          	<a class="clsStopSong" id="play_playing_music_icon_<?php echo $this->_tpl_vars['result']['music_id']; ?>
" onclick="stopSong(<?php echo $this->_tpl_vars['result']['music_id']; ?>
)" style="display:none" href="javascript:void(0)"></a>                 </div>
                                      	</div>
						  </div>
									  <div class="clsContentDetails">
											<p class="clsHeading"><a  href="<?php echo $this->_tpl_vars['result']['view_music_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['music_title']; ?>
"><?php echo $this->_tpl_vars['result']['music_title_word_wrap']; ?>
</a></p>
											<p class="clsAlbumLink"><?php echo $this->_tpl_vars['LANG']['album_title']; ?>
: <a  href="<?php echo $this->_tpl_vars['result']['view_album_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['album_title']; ?>
"><?php echo $this->_tpl_vars['result']['album_title_word_wrap']; ?>
</a></p>
											<p>	<?php if ($this->_tpl_vars['result']['record']['music_artist']): ?>
															<?php echo $this->_tpl_vars['LANG']['music_list_added_by_artist']; ?>

															<?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?>
																<a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl[$this->_tpl_vars['result']['record']['user_id']]; ?>
"><?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
</a>
															<?php else: ?>
												<?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['result']['record']['music_artist'],true,0,$this->_tpl_vars['myobj']->getFormField('artist')); ?>

											<?php endif; ?>
													  <?php endif; ?>
													</p>
											<p class="clsGeneres"><?php echo $this->_tpl_vars['LANG']['music_genre_in']; ?>
 <a href="<?php echo $this->_tpl_vars['result']['music_category_link']; ?>
"><?php echo $this->_tpl_vars['result']['music_category_name_word_wrap']; ?>
</a></p>
											<?php if (( $this->_tpl_vars['myobj']->getFormField('pg') == 'mymusics' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending' || $this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] ) && $this->_tpl_vars['myobj']->getFormField('myfavoritemusic') != 'Yes'): ?>
										  <ul class="selMusicLinks clsContentEditLinks">
										   											 <li class="clsEdit">
												  <a href="<?php echo $this->_tpl_vars['result']['musicupload_url']; ?>
" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiclist_edit_music']; ?>
">
												  </a>
											  </li>
											  <li class="clsGetCode" id="anchor_getcode_<?php echo $this->_tpl_vars['result']['music_id']; ?>
">
												  <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiclist_get_code']; ?>
"
												  onclick="return getAjaxGetCode('<?php echo $this->_tpl_vars['result']['callAjaxGetCode_url']; ?>
', '<?php echo $this->_tpl_vars['result']['anchor']; ?>
','selEditMusicComments','anchor_getcode_<?php echo $this->_tpl_vars['result']['music_id']; ?>
')">
												  </a>
											  </li>
											  <li class="clsDelete" id="anchor_myvid_<?php echo $this->_tpl_vars['result']['music_id']; ?>
">
												 <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiclist_delete_music']; ?>
"
												 onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
												 Array('act','music_id', 'selVideoId', 'delete_music_msg_id'), Array('delete','<?php echo $this->_tpl_vars['result']['music_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
',
												 '<?php echo $this->_tpl_vars['result']['delete_music_title']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -500,'anchor_myvid_<?php echo $this->_tpl_vars['result']['music_id']; ?>
');">
												 </a>
											  </li>
										   <?php if ($this->_tpl_vars['myobj']->getTotalManageLyricCount($this->_tpl_vars['result']['music_id']) > 0): ?>
												<li class="clsManageLyrics">
												   <a href="<?php echo $this->_tpl_vars['result']['manage_lyrics_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['musiclist_manage_lyrics']; ?>
"></a>
												</li>
											<?php endif; ?>
										  </ul>
										  <?php endif; ?>
										  <?php if ($this->_tpl_vars['myobj']->getFormField('myfavoritemusic') == 'Yes'): ?>
										  <ul id="selVideoLinks" class="clsContentEditLinks">
											  <li class="clsDelete" id="anchor_myfav_<?php echo $this->_tpl_vars['result']['music_id']; ?>
">
												<a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiclist_delete_music']; ?>
"
												onclick="return Confirmation('selMsgConfirm', 'msgConfirmform',
												Array('act','music_id', 'selVideoId', 'delete_music_msg_id'),
												Array('favorite_delete','<?php echo $this->_tpl_vars['result']['music_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo $this->_tpl_vars['result']['delete_music_title']; ?>
'),
												Array('value','value', 'src', 'innerHTML'), -100, -500,'anchor_myfav_<?php echo $this->_tpl_vars['result']['music_id']; ?>
');">
												</a>
											  </li>
											  <li class="clsGetCode" id="anchor_getcode_<?php echo $this->_tpl_vars['result']['music_id']; ?>
">
												<a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiclist_get_code']; ?>
"
												onclick="return getAjaxGetCode('<?php echo $this->_tpl_vars['result']['callAjaxGetCode_url']; ?>
', '<?php echo $this->_tpl_vars['result']['anchor']; ?>
','selEditMusicComments','anchor_getcode_<?php echo $this->_tpl_vars['result']['music_id']; ?>
')">
												</a>
											  </li>
										  </ul>
										  <?php endif; ?>
									  </div>
                                    </div>
									<div>
									 <?php echo '
                                    <script type="text/javascript">
										$Jq(window).load(function(){
											$Jq("#trigger_'; ?>
<?php echo $this->_tpl_vars['result']['music_id']; ?>
<?php echo '").click(function(){
												displayMusicMoreInfo(\''; ?>
<?php echo $this->_tpl_vars['result']['music_id']; ?>
<?php echo '\');
												return false;
											});
										});
									</script>
                                    '; ?>

										<div class="clsMoreInfoContainer clsOverflow">
									  <a class="clsMoreInformation" id="trigger_<?php echo $this->_tpl_vars['result']['music_id']; ?>
">
										  <span><?php echo $this->_tpl_vars['LANG']['header_nav_more_info']; ?>
</span>
									  </a>
									  </div>
										<div class="clsMoreInfoBlock" id="panel_<?php echo $this->_tpl_vars['result']['music_id']; ?>
" style="display:none;" >
										<div class="clsMoreInfoContent clsOverflow">
											<div class="clsOverflow">
												<table>
													<tr>
														<td>
															<span><?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?> <?php echo $this->_tpl_vars['LANG']['music_list_more_cast']; ?>
 <?php else: ?> <?php echo $this->_tpl_vars['LANG']['music_list_added_by']; ?>
 <?php endif; ?></span>
															<span class="clsMoreInfodata">
															   <?php if ($this->_tpl_vars['CFG']['admin']['musics']['music_artist_feature']): ?><?php echo $this->_tpl_vars['myobj']->getArtistLink($this->_tpl_vars['result']['record']['music_artist'],true,0,$this->_tpl_vars['myobj']->getFormField('artist')); ?>

																	  <?php else: ?>
																 <a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl[$this->_tpl_vars['result']['record']['user_id']]; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
</a>
															 <?php endif; ?>
															</span>
														</td>
														 <td>
															  <span><?php echo $this->_tpl_vars['LANG']['music_list_added_date']; ?>
</span>
															 <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['date_added']; ?>
</span>
														</td>
													  </tr>
													<tr>
														<td>
															<span><?php echo $this->_tpl_vars['LANG']['music_list_plays']; ?>
</span>
															<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['record']['total_plays']; ?>
</span>
														</td>
														<td>
															 <span><?php echo $this->_tpl_vars['LANG']['music_list_commented']; ?>
</span>
															  <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['record']['total_comments']; ?>
</span>
														</td>
													</tr>
													<tr>
														 <td>
															<span><?php echo $this->_tpl_vars['LANG']['music_list_favorite']; ?>
</span>
															<span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['record']['total_favorites']; ?>
</span>
														</td>

														<td> <?php if ($this->_tpl_vars['result']['record']['allow_ratings'] == 'Yes'): ?>
																 <span><?php echo $this->_tpl_vars['LANG']['music_list_ratted']; ?>
</span>
																  <span class="clsMoreInfodata"><?php echo $this->_tpl_vars['result']['rating']; ?>
 (<?php echo $this->_tpl_vars['result']['total_rating']; ?>
 <?php echo $this->_tpl_vars['LANG']['musiclist_ratted']; ?>
)</span>
															  <?php endif; ?>
														</td>
													</tr>
													 <tr>
														 <td>
															<span><?php echo $this->_tpl_vars['LANG']['music_list_year_released']; ?>
</span>
															<span class="clsMoreInfodata"><?php if ($this->_tpl_vars['result']['record']['music_year_released']): ?><?php echo $this->_tpl_vars['result']['record']['music_year_released']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></span>
														</td>
														 <td>
															 <span><?php echo $this->_tpl_vars['LANG']['musiclist_language_list']; ?>
: </span>
															 <span class="clsMoreInfodata"><?php if ($this->_tpl_vars['result']['music_language_val']): ?><?php echo $this->_tpl_vars['result']['music_language_val']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></span>
														</td>
													 </tr>
											   </table>
											</div>
											<?php if ($this->_tpl_vars['myobj']->getFormField('music_tags') != ''): ?>
												<?php $this->assign('music_tag', $this->_tpl_vars['myobj']->getFormField('music_tags')); ?>
											<?php elseif ($this->_tpl_vars['myobj']->getFormField('tags') != ''): ?>
												<?php $this->assign('music_tag', $this->_tpl_vars['myobj']->getFormField('tags')); ?>
											<?php else: ?>
												<?php $this->assign('music_tag', ''); ?>
											<?php endif; ?>
										   <p class="clsMoreinfoTags"><?php echo $this->_tpl_vars['LANG']['music_list_tags']; ?>
: <?php if ($this->_tpl_vars['result']['record']['music_tags'] != ''): ?><?php echo $this->_tpl_vars['myobj']->getMusicTagsLinks($this->_tpl_vars['result']['record']['music_tags'],5,$this->_tpl_vars['music_tag']); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?></p>
										   <p class="clsDescription"><span class="clsLabel"><?php echo $this->_tpl_vars['LANG']['music_list_description']; ?>
</span>: <?php if ($this->_tpl_vars['myobj']->getDescriptionForMusicList($this->_tpl_vars['result']['record']['music_caption'])): ?><?php echo $this->_tpl_vars['myobj']->getDescriptionForMusicList($this->_tpl_vars['result']['record']['music_caption']); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['common_not_available']; ?>
<?php endif; ?>
											<?php $_from = $this->_tpl_vars['getDescriptionLink_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['descriptionsValue']):
?>
											<?php echo $this->_tpl_vars['descriptionsValue']['wordWrap_mb_ManualWithSpace_description_name']; ?>

											<?php endforeach; endif; unset($_from); ?>
                                           </p>

										</div>
					  </div>
									</div>

              			 </div>
					<?php if ($this->_foreach['music']['iteration']%$this->_tpl_vars['myobj']->my_musics_form['showMusicList']['musicsPerRow'] == 0): ?>
					<?php endif; ?>
						<?php $this->assign('song_id', $this->_tpl_vars['song_id']+1); ?>
					<?php endforeach; endif; unset($_from); ?>
					<?php else: ?>
					<div id="selMsgAlert">
					  <p><?php echo $this->_tpl_vars['LANG']['common_music_no_records_found']; ?>
</p>
					</div>
					<?php endif; ?>
            <?php endif; ?>
			</div>
            <div class="clsAudioPaging">
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
            </div>
                                </form>
          </div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
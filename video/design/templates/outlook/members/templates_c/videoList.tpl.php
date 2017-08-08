<?php /* Smarty version 2.6.18, created on 2011-10-24 21:01:50
         compiled from videoList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoList.tpl', 214, false),array('modifier', 'truncate', 'videoList.tpl', 323, false),)), $this); ?>
<div id="selVideoList">
<!--rounded corners-->
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				  <div id="selVideoTitle">
                  <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
                  <input type="hidden" name="advanceFromSubmission" value="1"/>
		       <?php echo $this->_tpl_vars['myobj']->populateVideoListHidden($this->_tpl_vars['paging_arr']); ?>

                  <div class="clsOverflow">
                                      	<div class="clsVideoListHeading clsVideoLisPageTitle">
                              <h2><span>
                              <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'uservideolist' || $this->_tpl_vars['myobj']->getFormField('pg') == 'videoresponseslist'): ?>
                                    <?php echo $this->_tpl_vars['LANG']['videolist_title']; ?>

                              <?php else: ?>
                                    <?php echo $this->_tpl_vars['LANG']['videolist_title']; ?>

                              <?php endif; ?>
                               </span></h2>
				</div>
                                        
                    <div class="clsVideoListHeadingRight">
	                  <input type="hidden" name="default" id="default" value="<?php echo $this->_tpl_vars['myobj']->getFormField('default'); ?>
" />
                    	<select onchange="loadUrl(this)" id="videoselect">
                        	<option value="<?php  echo getUrl('videolist','?pg=videonew','videonew/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videonew'): ?> selected <?php endif; ?> >
    	                       <?php echo $this->_tpl_vars['LANG']['header_nav_video_video_new']; ?>

                            </option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videotoprated','videotoprated/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videotoprated'): ?> selected <?php endif; ?> >
	                           <?php echo $this->_tpl_vars['LANG']['header_nav_video_top_rated']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videorecommended','videorecommended/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videorecommended'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_video_most_recommended']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videomostviewed','videomostviewed/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostviewed'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_video_most_viewed']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videomostdiscussed','videomostdiscussed/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostdiscussed'): ?> selected <?php endif; ?> >
    	                        <?php echo $this->_tpl_vars['LANG']['header_nav_video_most_discussed']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videomostfavorite','videomostfavorite/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostfavorite'): ?> selected <?php endif; ?> >
	                            <?php echo $this->_tpl_vars['LANG']['header_nav_video_most_favorite']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videomostrecentlyviewed','videomostrecentlyviewed/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostrecentlyviewed'): ?> selected <?php endif; ?> >
    	                        <?php echo $this->_tpl_vars['LANG']['header_nav_video_recently_viewed']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=featuredvideolist','featuredvideolist/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'featuredvideolist'): ?> selected <?php endif; ?> >
                            <?php echo $this->_tpl_vars['LANG']['header_nav_video_most_featuredvideolist']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videomostlinked','videomostlinked/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostlinked'): ?> selected <?php endif; ?> >
                            <?php echo $this->_tpl_vars['LANG']['header_most_linked']; ?>
</option>
                        	<option value="<?php  echo getUrl('videolist','?pg=videomostresponded','videomostresponded/','','video') ?>"
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostresponded'): ?> selected <?php endif; ?> >
	                           <?php echo $this->_tpl_vars['LANG']['header_most_responded']; ?>
</option>
                           <option value="<?php  echo getUrl('videolist','?pg=albumlist','albumlist/','','video') ?>"
                           <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'albumlist'): ?> selected <?php endif; ?> >
                                <?php echo $this->_tpl_vars['LANG']['header_nav_video_album_list']; ?>

                            </option>
                        </select>
                    </div>
                                     </div>
                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_sub_category')): ?>
                    		<?php if ($this->_tpl_vars['populateSubCategories_arr']['row']): ?>
                                <h2>
                                    <?php echo $this->_tpl_vars['LANG']['videolist_sub_categories_label']; ?>

                                </h2>
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
                                                <a href="<?php echo $this->_tpl_vars['subCategoryValue']['video_list_url']; ?>
">
                                                <img src="<?php echo $this->_tpl_vars['subCategoryValue']['imageSrc']; ?>
" /></a>
                                                </span></div>
                                                <a href="<?php echo $this->_tpl_vars['subCategoryValue']['video_list_url']; ?>
">
                                                <?php echo $this->_tpl_vars['subCategoryValue']['video_category_name_manual']; ?>

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

                       <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostviewed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'videomostdiscussed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'videomostfavorite'): ?>
                                <div class="clsTabNavigation">
                                    <ul>
                                        <li<?php echo $this->_tpl_vars['videoActionNavigation_arr']['videoMostViewed_0']; ?>
><a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['videoActionNavigation_arr']['video_list_url_0']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_all_time']; ?>
</span></a></li>
                                        <li<?php echo $this->_tpl_vars['videoActionNavigation_arr']['videoMostViewed_1']; ?>
><a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['videoActionNavigation_arr']['video_list_url_1']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_today']; ?>
</span></a></li>
                                        <li<?php echo $this->_tpl_vars['videoActionNavigation_arr']['videoMostViewed_2']; ?>
><a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['videoActionNavigation_arr']['video_list_url_2']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_yesterday']; ?>
</span></a></li>
                                        <li<?php echo $this->_tpl_vars['videoActionNavigation_arr']['videoMostViewed_3']; ?>
><a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['videoActionNavigation_arr']['video_list_url_3']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_week']; ?>
</span></a></li>
                                        <li<?php echo $this->_tpl_vars['videoActionNavigation_arr']['videoMostViewed_4']; ?>
><a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['videoActionNavigation_arr']['video_list_url_4']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_month']; ?>
</span></a></li>
                                        <li<?php echo $this->_tpl_vars['videoActionNavigation_arr']['videoMostViewed_5']; ?>
><a href="javascript:void(0);" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['videoActionNavigation_arr']['video_list_url_5']; ?>
');"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_year']; ?>
</span></a></li>
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

                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'albumlist'): ?>
                        <div id="videosThumsDetailsLinks" class="clsVideoRight clsShowHideFilter clsOverflow">
                            <a href="javascript:void(0)" id="show_link" class="clsShowFilterSearch"  <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['videolist_show_adv_search']; ?>
</span></a>
                       		<a href="javascript:void(0)" id="hide_link" <?php if (! $this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> class="clsHideFilterSearch"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link')"><span><?php echo $this->_tpl_vars['LANG']['videolist_hide_adv_search']; ?>
</span></a>
                        </div>
                     <div id="advanced_search" style="<?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>display:block;<?php else: ?>display:none;<?php endif; ?>margin:0 0 10px 0;" class="clsAdvancedFilterTable clsOverflow">                  	 	<div class="clsAdvanceSearchIcon">
                            <table>
                            	 <tr>
                                    <td>
                                    	<input class="clsTextBox" type="text" name="keyword" id="keyword" value="<?php if ($this->_tpl_vars['myobj']->getFormField('keyword') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('keyword'); ?>
<?php elseif ($this->_tpl_vars['header']->getFormField('tags') != ''): ?><?php echo $this->_tpl_vars['header']->getFormField('tags'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['videolist_keyword']; ?>
<?php endif; ?>" onblur="setOldValue('keyword')"  onfocus="clearValue('keyword')"/>
                                    </td>
                                    <td>
                                    	<input class="clsTextBox" type="text" name="video_owner" id="video_owner" value="<?php if ($this->_tpl_vars['myobj']->getFormField('video_owner') == ''): ?> <?php echo $this->_tpl_vars['LANG']['videolist_user_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('video_owner'); ?>
<?php endif; ?>" onblur="setOldValue('video_owner')"  onfocus="clearValue('video_owner')" />
                                   </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select  name="video_country" id="video_country">
                                            <option value=""><?php echo $this->_tpl_vars['LANG']['videolist_country_list']; ?>
</option>
                                            <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_COUNTRY_ARR,$this->_tpl_vars['myobj']->getFormField('video_country')); ?>

                                        </select>                                    </td>
                                    <td>
                                        <select name="video_language" id="video_language">
                                            <option value=""><?php echo $this->_tpl_vars['LANG']['videolist_language_list']; ?>
</option>
                                            <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->LANG_LANGUAGE_ARR,$this->_tpl_vars['myobj']->getFormField('video_language')); ?>

                                        </select>                                    </td>
                                </tr>
                                 <tr>
                                    <td>
                                        <select name="run_length" id="run_length">
                                       		<option value=""><?php echo $this->_tpl_vars['LANG']['videolist_run_length']; ?>
</option>
                                            <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->VIDEORUN_LENGTH_ARR,$this->_tpl_vars['myobj']->getFormField('run_length')); ?>

                                        </select>                                    </td>
                                    <td>
                                    	<select name="added_within" id="added_within">
                                        	<option value=""><?php echo $this->_tpl_vars['LANG']['videolist_added_within']; ?>
</option>
                                            <?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->ADDED_WITHIN_ARR,$this->_tpl_vars['myobj']->getFormField('added_within')); ?>

                                        </select>                                    </td>
                                </tr>

                            </table>
						</div>
						<div class="clsAdvancedSearchBtn">
						<table>
							<tr>
                                    <td>
                                         <div class="clsSubmitLeft">
                                         <div class="clsSubmitRight">
                                             <input type="submit" name="avd_search" id="avd_search" value="<?php echo $this->_tpl_vars['LANG']['videolist_search_categories_videos_submit']; ?>
" />
                                         </div>
                                         </div>
										</td>
								<tr>
                                    <td>
                                         <div class="clsCancelMargin clsCancelLeft"><div class="clsCancelRight">
                                         	<input type="submit" name="avd_reset" id="avd_reset" value="<?php echo $this->_tpl_vars['LANG']['videolist_reset_submit']; ?>
" />
                                         </div>
                                         </div>

                                    </td>
                                </tr>
							</table>
                    </div>
                    <?php endif; ?>
                    </form>
                  </div>

                  <div id="selLeftNavigation">
                  <!-- Delete Single Videos -->
                  	<div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
    					<p id="msgConfirmText"></p>
                        <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                                       <div><p id="selImageBorder" class="clsPlainImageBorder">
                                            <span id="selPlainCenterImage">
                                                <img id="selVideoId" border="0" src=""/>
                                            </span>
                                        </p></div>
                                        <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                                            tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                                        <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                                            tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
                                        <input type="hidden" name="act" id="act" />
                                        <input type="hidden" name="video_id" id="video_id" />
                        </form>
                    </div>
                    <!-- Delete Multi Videos -->
					<div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
							<p id="msgConfirmTextMulti"><?php echo $this->_tpl_vars['LANG']['videolist_multi_delete_confirmation']; ?>
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
" onClick="return hideAllBlocks()" />
                                            <input type="hidden" name="video_id" id="video_id" />
                                            <input type="hidden" name="act" id="act" />
							</form>
					</div>

                 	<div id="selEditVideoComments" class="clsPopupConfirmation" style="display:none;">
					</div>

                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
                    <div id="selMsgError">
                        <p><?php echo $this->_tpl_vars['myobj']->msg_form_error['common_error_msg']; ?>
</p>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_success')): ?>
                    <div id="selMsgSuccess">
                        <p><?php echo $this->_tpl_vars['myobj']->msg_form_success['common_error_msg']; ?>
</p>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_videos_form')): ?>
                    <div id="selVideoListDisplay" class="clsLeftSideDisplayTable">
                        <?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
                        <form name="videoListForm" id="videoListForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                        <div id="topLinks">
                            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

                                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                            <?php endif; ?>
                        </div>
                        <!-- Chek All item -->
                            <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myvideos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritevideos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myplaylist'): ?>
                            	<div class="clsShowHideSeparator">
	                                <div id="selCheckAllItems" class="clsOverflow clsDeleteSeparator">

                                    <span class="clsVideoListCheckBox">
                                        <input type="checkbox" class="clsCheckRadio" name="check_all" o
                                            onclick="CheckAll(document.videoListForm.name, document.videoListForm.check_all.name)" />
                                    </span>

                                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myvideos'): ?>
                                    <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight">
                                        <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onClick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_videos_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['videolist_multi_delete_confirmation']; ?>
','videoListForm','video_id','delete')" />
                                        </div></div>
                                     <?php endif; ?>

                                     <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myplaylist'): ?>
                                    <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight">
                                        <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onClick="deleteVideoMultiCheck('<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
', '<?php echo $this->_tpl_vars['myobj']->my_videos_form['anchor']; ?>
', '<?php echo $this->_tpl_vars['LANG']['videolist_multi_delete_confirmation']; ?>
', 'videoListForm', 'video_id', 'playlist_delete')" />
                                        </div></div>
                                     <?php endif; ?>

                                     <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritevideos'): ?>
                                    <div class="clsGreyButtonLeft"><div class="clsGreyButtonRight">
                                        <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                                        tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['videolist_remove_favorite']; ?>
" onClick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_videos_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['videolist_favorite_multi_delete_confirmation']; ?>
','videoListForm','video_id','favorite_delete')" />
                                        </div></div>
                                     <?php endif; ?>

                                </div>
                                </div>
                            <?php endif; ?>

                        	<p><a href="#" id="<?php echo $this->_tpl_vars['myobj']->my_videos_form['anchor']; ?>
"></a></p>
                            <div class="clsVideoListVideos">
                            <table summary="<?php echo $this->_tpl_vars['LANG']['videolist_tbl_summary']; ?>
" class="clsContentsDisplayTbl clsVideoListTable" id="selDisplayTable">
                            <?php $this->assign('count', 0); ?>
                                <?php $_from = $this->_tpl_vars['video_list_result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['video'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['video']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['result']):
        $this->_foreach['video']['iteration']++;
?>
                                    <?php if ($this->_foreach['video']['iteration']%$this->_tpl_vars['myobj']->my_videos_form['showVideoList']['videosPerRow'] == 1): ?>
                                        <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                                    <?php endif; ?>
                                            <td id="selVideoGallery_<?php echo $this->_tpl_vars['inc']; ?>
" class="clsModifyItem">
                                                <div class="<?php echo $this->_tpl_vars['myobj']->my_videos_form['showVideoList']['clsVideoListCommon']; ?>
">

                                                    <ul class="cls141x106PXThumbImage">
                                                        <li id="videolist_videoli_<?php echo $this->_tpl_vars['inc']; ?>
" class="clsVideoListDisplayVideos">
                                                            <a id="<?php echo $this->_tpl_vars['result']['anchor']; ?>
"></a>


                                                                  <div class="clsListVideoThumbImage" id="videolist_video_thumb_image_<?php echo $this->_tpl_vars['inc']; ?>
">
                                                                      <div class="clsListThumbImageContainer" id="videolist_thumb_image_container_<?php echo $this->_tpl_vars['inc']; ?>
">
                                                                        <div class="clsThumbImageContainer">
                                                                              <div>
                                                                                  <div class="clsThumbImageLink clsPointer">
                                                                                   <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'albumlist'): ?>
                                                                                      <span class="clsRunTime"><?php echo $this->_tpl_vars['result']['playing_time']; ?>
</span>
                                                                                   <?php else: ?>
                                                                                      <span class="clsRunTime"><?php echo $this->_tpl_vars['result']['record']['total_album_videos']; ?>
 <?php echo $this->_tpl_vars['LANG']['common_videos']; ?>
</span>
                                                                                   <?php endif; ?>
                                                                                    <?php if ($this->_tpl_vars['result']['img_src']): ?>
                                                                                          <div id="videolist_thumb_<?php echo $this->_tpl_vars['inc']; ?>
" <?php echo $this->_tpl_vars['result']['div_onmouseOverText']; ?>
>
                                                                                                   <a  href="<?php echo $this->_tpl_vars['result']['view_video_link']; ?>
" class="Cls142x108 ClsImageBorder1 ClsImageContainer" title="<?php echo $this->_tpl_vars['result']['video_title']; ?>
" >
                                                                                             		<img src="<?php echo $this->_tpl_vars['result']['img_src']; ?>
" title="<?php echo $this->_tpl_vars['result']['video_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['video_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 15) : smarty_modifier_truncate($_tmp, 15)); ?>
" <?php echo $this->_tpl_vars['result']['img_disp_image']; ?>
 <?php echo $this->_tpl_vars['result']['image_onmouseOverText']; ?>
 <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['result']['record']['t_width'],$this->_tpl_vars['result']['record']['t_height']); ?>
 />
                                                                                                    </a>
                                                                                           </div>
                                                                                    <?php else: ?>
                                                                                          <div class="clsThumbImageOuter">
                                                                                              <div class="clsrThumbImageMiddle">
                                                                                                  <div class="clsThumbImageInner">
                                                                                                             <img src="<?php echo $this->_tpl_vars['album_video_count_list'][$this->_tpl_vars['result']['video_album_id']]['img_src']; ?>
"  <?php echo $this->_tpl_vars['album_video_count_list'][$this->_tpl_vars['result']['video_album_id']]['img_disp_image']; ?>
 <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['result']['record']['t_width'],$this->_tpl_vars['result']['record']['t_height']); ?>
 />
                                                                                                   </div>
                                                                                               </div>
	                                                                                     </div>
                                                                                    <?php endif; ?>
                                                                                  </div>
                                                                              </div>
                                                                        <a href="javascript:void(0)" class="clsInfo clsDisplayNone" id="videolist_info_<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="show_thumb=true;this.className='clsDisplayNone';showVideoDetail(this)"></a>
                                                                        <?php if ($this->_tpl_vars['result']['add_quicklink']): ?>
                                                                          <div class="clsAddQuickVideoMediumImg">
                                                                              <div id="quick_link_<?php echo $this->_tpl_vars['result']['video_id']; ?>
">
                                                                                  <?php if ($this->_tpl_vars['result']['is_quicklink_added']): ?>
                                                                                  <a class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_added_quicklinks']; ?>
">
                                                                                      <img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-addvideo.gif"/>
                                                                                  </a>
                                                                                  <?php else: ?>
                                                                                  <a id="qucik_link_add_<?php echo $this->_tpl_vars['result']['video_id']; ?>
" onclick="updateVideosQuickLinksCount('<?php echo $this->_tpl_vars['result']['video_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['videolist_quicklist_tooltips']; ?>
" class="clsPhotoVideoEditLinks">
                                                                                      <img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-addvideo_added.gif"/>
                                                                                  </a>
                                                                                  <a id="qucik_link_added_<?php echo $this->_tpl_vars['result']['video_id']; ?>
" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_added_quicklinks']; ?>
" style="display:none;">
                                                                                      <img src="<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-addvideo.gif"/>
                                                                                  </a>

                                                                                  <?php endif; ?>
                                                                              </div>
                                                                          </div>
                                                                        <?php endif; ?>
                                                                  </div>
			                                         		     </div>
                                                             		 	                                                               		 <div class="clsVideoDetailsInfo" id="videolist_selVideoDetails_<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="show_thumb=true;showVideoDetail(this)" onmouseout="show_thumb=false;hideVideoDetail(this)">
                                                                        <div class="clsVideoDetailsInfoCont">
                                                                           <div class=" clsVideoBackgroundInfo">
                                                                        <a href="javascript:void(0)" id="clsInfo" class="clsInfo_inside" style="display:none"></a>
                                                                       <div>
                                                                         <?php if ($this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] && $this->_tpl_vars['myobj']->getFormField('pg') != 'myvideos'): ?>
                                                                            <ul id="selVideoLinks" class="clsContentEditLinks clsPopUpContentEditLinks">
                                                                                <li class="clsEdit">
                                                                                    <a href="<?php echo $this->_tpl_vars['result']['videoupload_url']; ?>
" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_edit_video']; ?>
">
                                                                                        <?php echo $this->_tpl_vars['LANG']['videolist_edit_video']; ?>

                                                                                    </a>
                                                                                </li>
                                                                                <?php if ($this->_tpl_vars['CFG']['admin']['videos']['embedable']): ?>
                                                                                    <li class="clsGetCode">
                                                                                        <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_get_code']; ?>
"
                                                                                        onClick="return callAjaxGetCode('<?php echo $this->_tpl_vars['result']['callAjaxGetCode_url']; ?>
', '<?php echo $this->_tpl_vars['result']['anchor']; ?>
','selEditVideoComments')">
                                                                                            <?php echo $this->_tpl_vars['LANG']['videolist_get_code']; ?>

                                                                                        </a>
                                                                                    </li>
                                                                                <?php endif; ?>
                                                                                <li class="clsDelete" id="anchor_<?php echo $this->_tpl_vars['result']['video_id']; ?>
">
                                                                                    <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_delete_video']; ?>
"
                                                                                    onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                                    Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('delete','<?php echo $this->_tpl_vars['result']['video_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
',
                                                                                    '<?php echo $this->_tpl_vars['LANG']['videolist_delete_confirmation']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_<?php echo $this->_tpl_vars['result']['video_id']; ?>
');">
                                                                                        <?php echo $this->_tpl_vars['LANG']['videolist_delete_video']; ?>

                                                                                    </a>
                                                                                </li>
                                                                            </ul>
												 <?php else: ?>
	                                                                        <p><?php echo $this->_tpl_vars['LANG']['common_from']; ?>
: <a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl[$this->_tpl_vars['result']['user_id']]; ?>
"><?php echo $this->_tpl_vars['myobj']->getUserDetail('user_id',$this->_tpl_vars['result']['user_id'],'user_name'); ?>
</a></p>
                                                                         <?php endif; ?>
                                                                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'albumlist'): ?>
												 <div class="" id="videolist_clsVideoDetails_<?php echo $this->_tpl_vars['inc']; ?>
">
                                                                           <div class="">
                                                                              <div class="">
                                                                                    <div class="clsVideoUserDetails">

                                                                                      <p><?php echo $this->_tpl_vars['LANG']['common_views']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['total_views']; ?>
</span></p>
                                                                                      <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'featuredvideolist'): ?>
                                                                                      	<p><?php echo $this->_tpl_vars['LANG']['videolist_total_featured']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['total_featured']; ?>
</span></p>
                                                                                      <?php endif; ?>

                                                                                      <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostfavorite'): ?>
                                                                                      	<p><?php echo $this->_tpl_vars['LANG']['videolist_total_favorite']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['total_favorite']; ?>
</span></p>
                                                                                      <?php endif; ?>

                                                                                      <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videorecommended'): ?>
                                                                                      	<p><?php echo $this->_tpl_vars['LANG']['videolist_total_recommended']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['record']['total_featured']; ?>
</span></p>
                                                                                      <?php endif; ?>

                                                                                      <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostlinked'): ?>
                                                                                      	<p><?php echo $this->_tpl_vars['LANG']['videolist_total_linked']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['record']['total_linked']; ?>
</span></p>
                                                                                      <?php endif; ?>

                                                                                      <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostresponded'): ?>
                                                                                      	<p><?php echo $this->_tpl_vars['LANG']['videolist_total_responded']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['record']['total_responded']; ?>
</span></p>
                                                                                      <?php endif; ?>

                                                                                      <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'videomostdiscussed'): ?>
                                                                                      	<p><?php echo $this->_tpl_vars['LANG']['videolist_total_discussed']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['total_comments']; ?>
</span></p>
                                                                                      <?php endif; ?>
                                                                                      <p><?php echo $this->_tpl_vars['LANG']['common_added']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['result']['date_added']; ?>
</span></p>
                                                                                      <p><?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['result']['rating'],'video'); ?>
</p>
                                                                                    </div>
                                                                               </div>
                                                                          </div>
                                                                         </div>
                                                                    <?php endif; ?>
                                                                    </div>
                                                                     </div>
                                                                     	</div>

                                                            	</div>
                                                                      
                                                          		</div>
                                                                   <div id="video_title_<?php echo $this->_tpl_vars['inc']; ?>
" class="clsThumbImageTitle">
                                                                          <!-- Thumb yes start -->
                                                                          <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'yes'): ?>
                                                                                  <p><a href="<?php echo $this->_tpl_vars['result']['view_video_link']; ?>
" class="clsBlueColor">
                                                                                      <?php echo $this->_tpl_vars['result']['video_title_word_wrap']; ?>

                                                                                  </a></p>
                                                                          <?php endif; ?>
                                                                          <!-- Thumb yes end -->
                                                                   </div>

                                                        </li>
                                                    </ul>

                                                    <div id="selVideosContent_<?php echo $this->_tpl_vars['result']['video_id']; ?>
" class="<?php echo $this->_tpl_vars['myobj']->my_videos_form['showVideoList']['clsVideoListRight']; ?>
">

                                                        <!-- myvideos start -->
                                                        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myvideos'): ?>
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsCheckBox">
                                                                <span class="clsCheckItem">
                                                                    <input type="checkbox" class="clsCheckRadio" name="video_ids[]"  value="<?php echo $this->_tpl_vars['result']['video_id']; ?>
"
                                                                        tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['result']['checked']; ?>
 onclick="disableHeading('videoListForm')"/>
                                                                </span>
                                                            </li>
                                                            <li class="clsEdit">
                                                                <a href="<?php echo $this->_tpl_vars['result']['videoupload_url']; ?>
" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_edit_video']; ?>
">
                                                                    <?php echo $this->_tpl_vars['LANG']['videolist_edit_video']; ?>

                                                                </a>
                                                            </li>
                                                            <li class="clsGetCode">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_get_code']; ?>
"
                                                                onClick="return callAjaxGetCode('<?php echo $this->_tpl_vars['result']['callAjaxGetCode_url']; ?>
', '<?php echo $this->_tpl_vars['result']['anchor']; ?>
','selEditVideoComments')">
                                                                    <?php echo $this->_tpl_vars['LANG']['videolist_get_code']; ?>

                                                                </a>
                                                            </li>
                                                            <li class="clsDelete" id="anchor_myvid_<?php echo $this->_tpl_vars['result']['video_id']; ?>
">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_delete_video']; ?>
"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('delete','<?php echo $this->_tpl_vars['result']['video_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
',
                                                                '<?php echo $this->_tpl_vars['LANG']['videolist_delete_confirmation']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myvid_<?php echo $this->_tpl_vars['result']['video_id']; ?>
');">
                                                                    <?php echo $this->_tpl_vars['LANG']['videolist_delete_video']; ?>

                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        <?php endif; ?>
                                                        <!-- myvideos end -->

                                                        <!-- myfavouritevideo start -->
                                                        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritevideos'): ?>
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsCheckBox">
                                                                <span class="clsCheckItem">
                                                                    <input type="checkbox" class="clsCheckRadio" name="video_ids[]" value="<?php echo $this->_tpl_vars['result']['video_id']; ?>
"
                                                                        tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['result']['checked']; ?>
 onclick="disableHeading('videoListForm')"/>
                                                                </span>
                                                            </li>
                                                            <li class="clsGetCode">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_get_code']; ?>
"
                                                                onClick="return callAjaxGetCode('<?php echo $this->_tpl_vars['result']['callAjaxGetCode_url']; ?>
', '<?php echo $this->_tpl_vars['result']['anchor']; ?>
','selEditVideoComments')">
                                                                    <?php echo $this->_tpl_vars['LANG']['videolist_get_code']; ?>

                                                                </a>
                                                            </li>
                                                            <li class="clsDelete" id="anchor_myfav_<?php echo $this->_tpl_vars['result']['video_id']; ?>
">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_remove_favorite']; ?>
"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'),
                                                                Array('favorite_delete','<?php echo $this->_tpl_vars['result']['video_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo $this->_tpl_vars['LANG']['videolist_favorite_delete_confirmation']; ?>
'),
                                                                Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfav_<?php echo $this->_tpl_vars['result']['video_id']; ?>
');"><?php echo $this->_tpl_vars['LANG']['videolist_delete_video']; ?>

                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        <?php endif; ?>
                                                        <!-- myfavouritevideo end -->

                                                        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myalbumvideolist'): ?>
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsSetFeatured" id="anchor_myalb_<?php echo $this->_tpl_vars['result']['video_id']; ?>
">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_set_album_profile_image']; ?>
"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'),
                                                                Array('set_album_thumb','<?php echo $this->_tpl_vars['result']['video_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo $this->_tpl_vars['LANG']['videolist_set_album_profile_image_confirmation']; ?>
'),
                                                                Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myalb_<?php echo $this->_tpl_vars['result']['video_id']; ?>
');">
                                                                    <?php echo $this->_tpl_vars['LANG']['videolist_set_album_profile_image']; ?>

                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        <?php endif; ?>
                                                        <!-- myalbumvideolist end -->

                                                        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myplaylist'): ?>
                                                        <div class="clsContentEditLinksContainer">
                                                        <ul id="selVideoLinks" class="clsContentEditLinks">
                                                            <li class="clsCheckBox">
                                                                    <span class="clsCheckItem">
                                                                        <input type="checkbox" class="clsCheckRadio" name="video_ids[]"  value="<?php echo $this->_tpl_vars['result']['video_id']; ?>
"
                                                                            tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['result']['checked']; ?>
/>
                                                                    </span>
                                                                </li>
                                                            <li class="clsDelete" id="anchor_myply_<?php echo $this->_tpl_vars['result']['video_id']; ?>
">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_delete_video']; ?>
"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'),
                                                                Array('playlist_delete','<?php echo $this->_tpl_vars['result']['video_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo $this->_tpl_vars['LANG']['videolist_delete_confirmation']; ?>
'),
                                                                Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myply_<?php echo $this->_tpl_vars['result']['video_id']; ?>
');"><?php echo $this->_tpl_vars['LANG']['videolist_set_album_profile_image']; ?>

                                                                </a>
                                                            </li>
                                                            <li class="clsSetFeatured" id="anchor_myfea_<?php echo $this->_tpl_vars['result']['video_id']; ?>
">
                                                                <a href="javascript:void(0)" class="clsVideoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['videolist_set_palylist_thumbnail']; ?>
"
                                                                onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',
                                                                Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('set_playlist_thumb','<?php echo $this->_tpl_vars['result']['video_id']; ?>
','<?php echo $this->_tpl_vars['result']['img_src']; ?>
',
                                                                '<?php echo $this->_tpl_vars['LANG']['videolist_playlist_thumbnail_confirmation']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfea_<?php echo $this->_tpl_vars['result']['video_id']; ?>
');">
                                                                    <?php echo $this->_tpl_vars['LANG']['videolist_set_palylist_thumbnail']; ?>

                                                                </a>
                                                            </li>
                                                        </ul>
                                                        </div>
                                                        <?php endif; ?>


                                                    </div>
                                                </div>
                                             </td>
                                          <?php if ($this->_foreach['video']['iteration']%$this->_tpl_vars['myobj']->my_videos_form['showVideoList']['videosPerRow'] == 0): ?>
                                        		</tr>
	                                   	<?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                            </table>
                            </div>

                        <div id="bottomLinks">
                        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
		                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

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
                              	<p><?php echo $this->_tpl_vars['LANG']['common_video_no_records_found']; ?>
</p>
                              </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
</div>
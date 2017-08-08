<?php /* Smarty version 2.6.18, created on 2011-10-19 09:48:01
         compiled from photoList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'photoList.tpl', 172, false),array('function', 'cycle', 'photoList.tpl', 271, false),array('modifier', 'truncate', 'photoList.tpl', 287, false),array('modifier', 'escape', 'photoList.tpl', 322, false),)), $this); ?>
<?php echo '
<script type="text/javascript">
	function resetFormField(url, viewType)
	{
		document.seachAdvancedFilter.thumb.value = viewType;
		document.seachAdvancedFilter.action = url;
		document.seachAdvancedFilter.submit();
	}
</script>
'; ?>


<div class="clsPhotoListContainer clsOverflow">
  <script type="text/javascript" language="javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['project_path_relative']; ?>
js/AG_ajax_html.js"></script>
  <script type="text/javascript" language="javascript">
	var block_arr= new Array('selMsgConfirm', 'selMsgConfirmMulti', 'selEditPhotoComments');
	var delLink_value;
</script>
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
    <input type="hidden" name="advanceFromSubmission" value="1"/>
    <?php echo $this->_tpl_vars['myobj']->populatePhotoListHidden($this->_tpl_vars['paging_arr']); ?>

    <div class="clsOverflow">
      <div class="clsHeadingLeft">
        <h2><span> <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'userphotolist'): ?>
          <?php echo $this->_tpl_vars['LANG']['photolist_title']; ?>

          <?php else: ?>
          <?php echo $this->_tpl_vars['LANG']['photolist_title']; ?>

          <?php endif; ?> </span></h2>
      </div>
      <div class="clsHeadingRight">
        <input type="hidden" name="default" id="default" value="<?php echo $this->_tpl_vars['myobj']->getFormField('default'); ?>
" />
        <select name="select" id="photoselect" onChange="loadUrl(this)">
          <option value="<?php  echo getUrl('photolist','?pg=photonew','photonew/','','photo') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == ''): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['LANG']['header_nav_photo_photo_all']; ?>
</option>
          <option value="<?php  echo getUrl('photolist','?pg=photorecent','photorecent/','','photo') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photorecent'): ?> selected <?php endif; ?> >
          <?php echo $this->_tpl_vars['LANG']['header_nav_photo_photo_new']; ?>
 </option>
          <option value="<?php  echo getUrl('photolist','?pg=phototoprated','phototoprated/','','photo') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'phototoprated'): ?> selected <?php endif; ?> >
          <?php echo $this->_tpl_vars['LANG']['header_nav_photo_top_rated']; ?>
</option>
          <option value="<?php  echo getUrl('photolist','?pg=photomostviewed','photomostviewed/','','photo') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostviewed'): ?> selected <?php endif; ?> >
          <?php echo $this->_tpl_vars['LANG']['header_nav_photo_most_viewed']; ?>
</option>
          <option value="<?php  echo getUrl('photolist','?pg=photomostdiscussed','photomostdiscussed/','','photo') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostdiscussed'): ?> selected <?php endif; ?> >
          <?php echo $this->_tpl_vars['LANG']['header_nav_photo_most_discussed']; ?>
</option>
          <option value="<?php  echo getUrl('photolist','?pg=photomostfavorite','photomostfavorite/','','photo') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostfavorite'): ?> selected <?php endif; ?> >
          <?php echo $this->_tpl_vars['LANG']['header_nav_photo_most_favorite']; ?>
</option>
          <option value="<?php  echo getUrl('photolist','?pg=featuredphotolist','featuredphotolist/','','photo') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'featuredphotolist'): ?> selected <?php endif; ?> >
          <?php echo $this->_tpl_vars['LANG']['header_nav_photo_most_featuredphotolist']; ?>
</option>
		  <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
		   <option value="<?php  echo getUrl('photolist','?pg=subscribedphotolist','subscribedphotolist/','','photo') ?>"
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'subscribedphotolist'): ?> selected <?php endif; ?> >
          <?php echo $this->_tpl_vars['LANG']['common_subscribed_photo']; ?>
</option>
		  <?php endif; ?>
        </select>
      </div>
    </div>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostviewed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'photomostdiscussed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'photomostfavorite'): ?>
    <div class="clsPhotoListMenu">
      <ul>
        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['photoMostViewed_0']; ?>
><a href="javascript:void(0)" onClick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_0']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_nav_members_all_time']; ?>
"><span ><?php echo $this->_tpl_vars['LANG']['header_nav_members_all_time']; ?>
</span></a></li>
        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['photoMostViewed_1']; ?>
><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_1']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_nav_members_today']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_today']; ?>
</span></a></li>
        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['photoMostViewed_2']; ?>
><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_2']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_nav_members_yesterday']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_yesterday']; ?>
</span></a></li>
        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['photoMostViewed_3']; ?>
><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_3']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_nav_members_this_week']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_week']; ?>
</span></a></li>
        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['photoMostViewed_4']; ?>
><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_4']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_nav_members_this_month']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_month']; ?>
</span></a></li>
        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['photoMostViewed_5']; ?>
><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_5']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_nav_members_this_year']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_year']; ?>
</span></a></li>
        <li <?php echo $this->_tpl_vars['photoActionNavigation_arr']['photoMostViewed_6']; ?>
><a  href="javascript:void(0)" onClick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['photoActionNavigation_arr']['photo_list_url_6']; ?>
');" title="<?php echo $this->_tpl_vars['LANG']['header_nav_members_befor_one_year']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_befor_one_year']; ?>
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
                    var subMenuClassName1=\'clsPhotoListMenu\';
                    var hoverElement1  = \'.clsPhotoListMenu li\';
                    loadChangeClass(hoverElement1,subMenuClassName1);
                  </script>
    '; ?>

    <?php endif; ?>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_sub_category')): ?>
    <?php if ($this->_tpl_vars['populateSubCategories_arr']['row']): ?>
    <div id='selShowSubcategory' class="clsShowCategory" style="display:none;"><?php echo $this->_tpl_vars['LANG']['photo_list_showphoto_subcategory']; ?>
</div>
    <div id='selHideSubcategory' class="clsHideCategory"><?php echo $this->_tpl_vars['LANG']['photo_list_hidephoto_subcategory']; ?>
</div>
    <div id="selShowAllShoutouts" class="clsDataTable">
      <table id="selCategoryTable" class="clsSubCategoryTable">
        <?php $_from = $this->_tpl_vars['populateSubCategories_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subCategoryItem'] => $this->_tpl_vars['subCategoryValue']):
?>
        <?php echo $this->_tpl_vars['subCategoryValue']['open_tr']; ?>

        <td id="selPhotoGallery_<?php echo $this->_tpl_vars['subCategoryItem']; ?>
" class="clsPhotoCategoryCell"><div id="selImageDet">
              <h3>
                <div class="clsOverflow"><span class="clsViewThumbImage"> <a href="<?php echo $this->_tpl_vars['subCategoryValue']['photo_list_url']; ?>
"> <img src="<?php echo $this->_tpl_vars['subCategoryValue']['imageSrc']; ?>
"  alt="<?php echo $this->_tpl_vars['subCategoryValue']['photo_category_name_manual']; ?>
" title="<?php echo $this->_tpl_vars['subCategoryValue']['photo_category_name_manual']; ?>
"/></a> </span></div>
                <a href="<?php echo $this->_tpl_vars['subCategoryValue']['photo_list_url']; ?>
" title="<?php echo $this->_tpl_vars['subCategoryValue']['photo_category_name_manual']; ?>
"> <?php echo $this->_tpl_vars['subCategoryValue']['photo_category_name_manual']; ?>
 </a> </h3>
            </div></td>
          <?php echo $this->_tpl_vars['subCategoryValue']['end_tr']; ?>

          <?php endforeach; else: ?>
          <?php endif; unset($_from); ?>
      </table>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'albumlist'): ?>
    <div class="clsAdvancedFilterSearch" id=""> <a href="javascript:void(0)" id="show_link" class="clsShow"  <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> onclick="divShowHide('advanced_search', 'show_link', 'hide_link')" title="<?php echo $this->_tpl_vars['LANG']['photolist_show_adv_search']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['photolist_show_adv_search']; ?>
</span></a> <a href="javascript:void(0)" id="hide_link" <?php if (! $this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> class="clsHide"  onclick="divShowHide('advanced_search', 'show_link', 'hide_link')" title="<?php echo $this->_tpl_vars['LANG']['photolist_hide_adv_search']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['photolist_hide_adv_search']; ?>
</span></a> <a href="<?php  echo getUrl('photolist','?pg=photonew','photonew/','','photo') ?>" id="show_link" class="clsResetFilter" title="<?php echo $this->_tpl_vars['LANG']['photolist_reset_search']; ?>
">&nbsp;( <?php echo $this->_tpl_vars['LANG']['photolist_reset_search']; ?>
 )</a> </div>
    <div id="advanced_search" <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?> style="display:block;" <?php else: ?> style="display:none;"  <?php endif; ?>>
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
                    <td><input class="clsTextBox" type="text" name="advance_keyword" id="advance_keyword" value="<?php if ($this->_tpl_vars['myobj']->getFormField('photo_keyword') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('photo_keyword'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['photolist_keyword_field']; ?>
<?php endif; ?>" onBlur="setOldValue('advance_keyword')"  onfocus="clearValue('advance_keyword')"/>
                    </td>
                    <td><input class="clsTextBox" type="text" name="advantage_photo_album_name" id="advantage_photo_album_name" value="<?php if ($this->_tpl_vars['myobj']->getFormField('photo_album_name') == ''): ?> <?php echo $this->_tpl_vars['LANG']['photo_list_album']; ?>
<?php else: ?><?php echo $this->_tpl_vars['myobj']->getFormField('photo_album_name'); ?>
<?php endif; ?>" onBlur="setOldValue('advantage_photo_album_name')"  onfocus="clearValue('advantage_photo_album_name')" />
                    </td>
                </tr>
                <tr>
                   <td><input class="clsTextBox" type="text" name="advantage_photo_owner" id="advantage_photo_owner" value="<?php if ($this->_tpl_vars['myobj']->getFormField('photo_owner') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('photo_owner'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['photolist_photo_created_by']; ?>
<?php endif; ?>" onBlur="setOldValue('advantage_photo_owner')"  onfocus="clearValue('advantage_photo_owner')"/>
                  </td>
                  <td><div id="map_canvas" ></div>
                    <div  id="selLocationTextBox">
                      <input class="clsTextBox" type="text" name="advantage_location" id="advantage_location" value="<?php if ($this->_tpl_vars['myobj']->getFormField('location') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('location'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['photolist_photo_location']; ?>
<?php endif; ?>"  onBlur="setOldValue('advantage_location')"  onfocus="clearValue('advantage_location')"/>
                    </div>
                    <div id="selResult"></div>
                  </td>
                </tr>
              </table>
      </div>
          <div class="clsAdvancedSearchBtn">
              <table>
                <tr>
                  <td colspan="2" align="right" valign="middle"><div class="clsSearchButton-l"><span class="clsSearchButton-r">
                      <input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="<?php echo $this->_tpl_vars['LANG']['photolist_search_categories_photos_submit']; ?>
" />
                      </span></div>
                   </td>
                </tr>
                <tr>
                   <td>
                    <div class="clsResetButton-l"><span class="clsResetButton-r">
                      <input type="submit" name="avd_reset" id="avd_reset" onclick="document.seachAdvancedFilter.start.value = '0';" value="<?php echo $this->_tpl_vars['LANG']['photolist_reset_submit']; ?>
" />
                      </span></div>
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
 ?> </div>
    <?php endif; ?>
  </form>
  <!--FORM End-->
  <div id="selLeftNavigation">
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
     <div class="clsOverflow">
      <p id="msgConfirmText"></p>
      <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
        <div id="selImageBorder" class="clsPlainImageBorder">
            <div id="delete_photo_msg_id" class="clsPopUpInnerContent"> </div>
            <div id="selPlainCenterImage"> <img id="selPhotoId" border="0" src="" alt=""/> </div>
        </div>
        <div>
        <input type="submit" class="clsPopUpButtonSubmit" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
        <input type="hidden" name="act" id="act" />
        <input type="hidden" name="photo_id" id="photo_id" />
        </div>
      </form>
     </div>
    </div>

    <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      &nbsp;
      <p id="msgConfirmTextMulti"><?php echo $this->_tpl_vars['LANG']['photolist_multi_delete_confirmation']; ?>
</p>
      &nbsp;
      <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
        <input type="submit" class="clsPopUpButtonSubmit" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
        &nbsp;
        <input type="button" class="clsPopUpButtonReset" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
"
                tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
        <input type="hidden" name="photo_id" id="photo_id" />
        <input type="hidden" name="act" id="act" />
      </form>
	  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
    <div id="selEditPhotoComments" class="clsPopupConfirmation" style="display:none;"></div>
    <form name="photoListForm" id="photoListForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
            <?php if (isMember ( )): ?>
      <div class="clsOverflow clsBorderBottom">
        <p class="clsListCheckBox clsListBoxPosition">
          <input type="checkbox" class="clsCheckRadio clsRadioButtonBorder" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="CheckAll(document.photoListForm.name, document.photoListForm.check_all.name)"/>
        </p>
		<?php if ($this->_tpl_vars['CFG']['admin']['photos']['allow_quick_mixs']): ?>
        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r" id="quick_mix">
          <input type="button" value="<?php echo $this->_tpl_vars['LANG']['common_photo_add_to_quick_view']; ?>
" onClick="getMultiCheckBoxValueForQuickMix('photoListForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['photolist_select_titles']; ?>
');if(quickMixmultiCheckValue!='') updatePhotosQuickMixCount(quickMixmultiCheckValue);"/>
          </span></p>
		 <?php endif; ?>
        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r">
          	<input type="button"  value="<?php echo $this->_tpl_vars['LANG']['common_photo_add_to_slidelist']; ?>
" onclick="getMultiCheckBoxValue('photoListForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['photolist_select_titles']; ?>
');if(multiCheckValue!='') return populateMyPlayList('<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
', 'select', multiCheckValue);" />
          </span></p>
          <?php echo $this->_tpl_vars['myobj']->populatePlaylist(); ?>

          <?php if ($this->_tpl_vars['CFG']['admin']['photos']['movie_maker']): ?>
        <p class="clsSubmitButton-l"><span class="clsSubmitButton-r" id="movie_photo_queue">
          <input type="button" value="<?php echo $this->_tpl_vars['LANG']['common_photo_add_to_movie_queue']; ?>
" onClick="getMultiCheckBoxValueForMovieQueue('photoListForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['photolist_select_titles']; ?>
');if(movieQueueMultiCheckValue!='') updatePhotosMovieQueueCount(movieQueueMultiCheckValue);"/>
          </span></p>
		 <?php endif; ?>
        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myphotos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritephotos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myplaylist' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending'): ?>
        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myphotos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending'): ?> <a href="javascript:void(0)" id="dAltMulti"></a>
        <p class="clsDeleteButton-l"><span class="clsDeleteButton-r">
          <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onClick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['photolist_select_titles']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_photos_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['photolist_delete_confirmation']; ?>
','photoListForm','photo_id','myphotodelete');"/>
          </span></p>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myplaylist'): ?>
        <p class="clsDeleteButton-l"><span class="clsDeleteButton-r">
          <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                    tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onClick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['photolist_select_titles']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_photos_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['photolist_delete_confirmation']; ?>
','photoListForm','photo_id','myPlaylistPhotoDelete');" />
          </span></p>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritephotos'): ?>
        <p class="clsDeleteButton-l"><span class="clsDeleteButton-r">
          <input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit"
                  tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_delete_option']; ?>
" onClick="deleteMultiCheck('<?php echo $this->_tpl_vars['LANG']['photolist_select_titles']; ?>
','<?php echo $this->_tpl_vars['myobj']->my_photos_form['anchor']; ?>
','<?php echo $this->_tpl_vars['LANG']['photolist_favorite_delete_confirmation']; ?>
','photoListForm','photo_id','favorite_delete');" />
          </span></p>
        <?php endif; ?>
        <?php endif; ?> </div>
        <div id="clsMsgDisplay_playlist_success" class="clsDisplayNone clsPlaylistSuccess"></div>
      <?php endif; ?>
      <div class="clsViewBorder clsOverflow">
        <div class="clsThumbViewLeft"> <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'yes'): ?>
          <p class="clsDetailView"> <a class="<?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'yes'): ?> 'clsSearchActive' <?php else: ?> '' <?php endif; ?>" onclick="resetFormField('<?php echo $this->_tpl_vars['myobj']->showThumbDetailsLinks_arr['url']; ?>
?thumb=no<?php echo $this->_tpl_vars['myobj']->showThumbDetailsLinks_arr['query_string']; ?>
', 'no');" title="<?php echo $this->_tpl_vars['LANG']['common_photo_detail_view']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_detail_view']; ?>
</a> </p>
          <?php elseif ($this->_tpl_vars['myobj']->getFormField('thumb') == 'no'): ?>
          <p class="clsThumbView"> <a class="<?php if ($this->_tpl_vars['myobj']->getFormField('thumb') != 'yes'): ?> 'clsSearchActive' <?php else: ?> '' <?php endif; ?>" onclick="resetFormField('<?php echo $this->_tpl_vars['myobj']->showThumbDetailsLinks_arr['url']; ?>
?thumb=yes<?php echo $this->_tpl_vars['myobj']->showThumbDetailsLinks_arr['query_string']; ?>
', 'yes');" title="<?php echo $this->_tpl_vars['LANG']['common_photo_thumb_view']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_thumb_view']; ?>
</a> </p>
          <?php endif; ?> </div>
        <div class="clsSortByLinksContainer"> <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_photos_form')): ?>
          <div class="clsSortByPagination clsPhotoPaginationRight">
            <div class="clsPhotoPaging">
              <div class="clsPagingList"> <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?> </div>
            </div>
          </div>
        </div>
      </div>
      <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['myobj']->my_photos_form['anchor']; ?>
"></a> <?php if ($this->_tpl_vars['myobj']->isResultsFound): ?>
      <?php $this->assign('count', 1); ?>
      <?php $this->assign('song_id', 1); ?>
      <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'no'): ?>
      <div id="selDetailViewId">
      <?php endif; ?>
      <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'yes'): ?>
      <div id="selThumbViewId"> <?php endif; ?>
        <?php $_from = $this->_tpl_vars['photo_list_result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['photo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['photo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['result']):
        $this->_foreach['photo']['iteration']++;
?>
        <?php echo smarty_function_cycle(array('values' => 'clsOddListContents , clsEvenListContents ','assign' => 'CellCSS'), $this);?>

        <div class="<?php echo $this->_tpl_vars['CellCSS']; ?>
 clsListContents <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'yes'): ?><?php if ($this->_tpl_vars['count'] % 3 == 0): ?> clsThumbPhotoFinalRecord<?php endif; ?> <?php endif; ?>">
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          <div class="clsOverflow">
		  <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'no' && isMember ( ) && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
            <p class="clsListCheckBox">
              <input type="checkbox" name="checkbox[]" id="view_photo_checkbox_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" class="clsRadioButtonBorder" value="<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" onClick="disableHeading('photoListForm');"/>
            </p>
            <?php endif; ?>


            <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') == 'no'): ?>
            <div class="clsThumb">
              <div class="clsLargeThumbImageBackground clsNoLink" <?php if (isMember ( )): ?> onmouseover="showCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
');" onmouseout="hideCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
')" <?php endif; ?> >
                <div class="clsPhotoThumbImageOuter">
                  <?php if ($this->_tpl_vars['result']['img_src']): ?><?php if ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?> <a href="<?php echo $this->_tpl_vars['result']['view_photo_link']; ?>
" class="cls146x112 clsImageHolder clsImageBorderBg"><?php endif; ?><img src="<?php echo $this->_tpl_vars['result']['img_src']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['photo_title_word_wrap_not_highlight'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
" title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap_not_highlight']; ?>
" id="image_img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['result']['record']['t_width'],$this->_tpl_vars['result']['record']['t_height']); ?>
/><?php if ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?></a> <?php endif; ?><?php else: ?> <img src="<?php echo $this->_tpl_vars['album_photo_count_list'][$this->_tpl_vars['result']['photo_album_id']]['img_src']; ?>
"  <?php echo $this->_tpl_vars['album_photo_count_list'][$this->_tpl_vars['result']['photo_album_id']]['img_disp_image']; ?>
 alt="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap']; ?>
"   title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap']; ?>
" /> <?php endif; ?>
				  </div>
              </div>
			  <?php if ($this->_tpl_vars['result']['img_src']): ?>
              <div class="clsSlideTip">  <a href="javascript:;"  title="<?php echo $this->_tpl_vars['LANG']['common_zoom']; ?>
" id="img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" onclick="zoom('img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
','<?php echo $this->_tpl_vars['result']['slideshow_img_src']; ?>
','<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['photo_description_word_wrap_js'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50) : smarty_modifier_truncate($_tmp, 50)); ?>
')" class="clsPhotoVideoEditLinks clsIndexZoomImg"><?php echo $this->_tpl_vars['LANG']['photo_list_photo_view']; ?>
</a>  </div><?php endif; ?>
         <?php if (isMember ( )): ?>
			  <?php if ($this->_tpl_vars['result']['add_quickmix'] || ( ( $this->_tpl_vars['myobj']->getFormField('pg') == 'myphotos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending' || $this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] || isAdmin ( ) ) && $this->_tpl_vars['myobj']->getFormField('myfavoritephoto') != 'Yes' ) || $this->_tpl_vars['myobj']->getFormField('myfavoritephoto') == 'Yes' || ( $this->_tpl_vars['CFG']['admin']['photos']['add_photo_location'] && $this->_tpl_vars['result']['photo_status'] == 'Ok' && ( $this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] || isAdmin ( ) ) )): ?>
              <div class="clsGetEditDel"  style="display:none" id="hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" onmouseover="showCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
');" onmouseout="hideCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
')">
                <div> <?php if ($this->_tpl_vars['result']['add_quickmix']): ?>
                  <?php if ($this->_tpl_vars['result']['is_quickmix_added'] && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                  <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_remove_from_quickmix']; ?>
" ><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                  <p class="clsQuickMix" id="quick_mix_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_add_to_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                  <?php elseif ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                  <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_remove_from_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                  <p class="clsQuickMix" id="quick_mix_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_add_to_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                  <?php endif; ?>
                  <?php endif; ?> </div>

                <!-- movie maker queue start -->
                <div> <?php if ($this->_tpl_vars['result']['add_photo_movie_queue']): ?>
                <?php if ($this->_tpl_vars['result']['is_moviequeue_added'] && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                <p class="clsMovieQueue" id="movie_queue_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_remove_from_movie_queue']; ?>
" ><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                <p class="clsMovieQueue" id="movie_queue_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_add_to_movie_queue']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                <?php elseif ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                <p class="clsMovieQueue" id="movie_queue_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_remove_from_movie_queue']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                <p class="clsMovieQueue" id="movie_queue_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_add_to_movie_queue']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                <?php endif; ?>
                <?php endif; ?> </div>
                  <!-- movie maker queue end -->

                <div> <?php if (( $this->_tpl_vars['myobj']->getFormField('pg') == 'myphotos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending' || $this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] || isAdmin ( ) ) && $this->_tpl_vars['myobj']->getFormField('myfavoritephoto') != 'Yes'): ?>
                  <ul id="selPhotoLinks" class="clsContentEditLinks">
				    <?php if ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                    <li class="clsEdit"> <a href="<?php echo $this->_tpl_vars['result']['photoupload_url']; ?>
" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photolist_edit_photo']; ?>
"> </a> </li>
					<?php endif; ?>
                    <li class="clsDelete" id="anchor_myvid_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"> <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photolist_delete_photo']; ?>
"  onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'), Array('delete','<?php echo $this->_tpl_vars['result']['photo_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['delete_photo_title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myvid_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
');"> </a> </li>
                    <?php if ($this->_tpl_vars['CFG']['admin']['photos']['add_photo_location'] && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                    	<li class="clsGetCode">
							<a href="<?php echo $this->_tpl_vars['result']['location_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['photo_list_location_title']; ?>
" id="show_photo_location_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" class="clsPhotoVideoEditLinks"><?php echo $this->_tpl_vars['LANG']['photo_list_location']; ?>
</a>
						</li>
                    <?php endif; ?>
                  </ul>
                  <?php endif; ?> </div>
                <div> <?php if ($this->_tpl_vars['myobj']->getFormField('myfavoritephoto') == 'Yes'): ?>
                  <ul id="selPhotoLinks" class="clsContentEditLinks">
                    <li class="clsDelete" id="anchor_myfav_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"> <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photolist_delete_photo']; ?>
" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',                        Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'),                                           Array('favorite_delete','<?php echo $this->_tpl_vars['result']['photo_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo $this->_tpl_vars['result']['delete_photo_title']; ?>
'),                       Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfav_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
');"></a> </li>
                  </ul>
                  <?php endif; ?> </div>
              </div>
              <?php endif; ?>
	     <?php endif; ?>
			  </div>
            <div class="clsContentDetails clsOverflow">
              <div class="clsMoreInfoContent">
                <div class="clsMoreInfoContent-l">
                  <div>
                    <p class="clsHeading"><a  href="<?php echo $this->_tpl_vars['result']['view_photo_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap_not_highlight']; ?>
"><?php echo $this->_tpl_vars['result']['photo_title_word_wrap']; ?>
</a></p>
                  </div>
                  <div class="clsAddedUserDet">
                    <p class="clsLeft"><?php echo $this->_tpl_vars['LANG']['photo_list_addedby']; ?>
</p>
                    <p class="clsRight clsUserLink"><a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl[$this->_tpl_vars['result']['record']['user_id']]; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
</a>
                    <span class="clsLinkSeperator">|</span>
                    <span><?php echo $this->_tpl_vars['result']['date_added']; ?>
</span></p>
                  </div>
                 <!-- <div>
                    	<p class="clsLeft"><?php echo $this->_tpl_vars['LANG']['photo_list_added_date']; ?>
</p>
                      					<p class="clsRight"></p>
                  </div>-->
                  <?php if ($this->_tpl_vars['result']['location_recorded_word_wrap'] != ''): ?>
                  <div id="photoLocation_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
">
                    <p class="clsLeft"><?php echo $this->_tpl_vars['LANG']['photo_list_location']; ?>
</p>
                    <p class="clsRight clsLocationLink">
					<?php if ($this->_tpl_vars['result']['photo_location_lat'] != 0 && $this->_tpl_vars['result']['photo_location_lan'] != 0): ?>
						<a href="javascript:void(0)" id="list_photo_location_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" title="<?php echo $this->_tpl_vars['result']['location_recorded_word_wrap_not_highlight']; ?>
" onclick="showPhotosInLocation('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
', '<?php echo $this->_tpl_vars['result']['location_recorded_url']; ?>
');"><?php echo $this->_tpl_vars['result']['location_recorded_word_wrap']; ?>
</a>
					<?php else: ?>
						<?php echo $this->_tpl_vars['result']['location_recorded_word_wrap']; ?>

					<?php endif; ?>
					</p>
                  </div>
				  <?php else: ?>
				  <div id="photoLocation_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
"></div>
                  <?php endif; ?>
				  <div>
                    <p class="clsDescription"><span class="clsLabel"><?php echo $this->_tpl_vars['LANG']['photo_list_description']; ?>
:</span><span class='toolTipSpanClass clsDesFull' title="<?php echo $this->_tpl_vars['result']['photo_description_word_wrap_not_highlight']; ?>
">&nbsp;<?php echo $this->_tpl_vars['result']['photo_description_word_wrap']; ?>
</span></p>
                  </div>
				  </div>
                <div class="clsMoreInfoContent-r">
                  <div class="clsPhotoRating">
				  	<?php if ($this->_tpl_vars['result']['record']['allow_ratings'] == 'Yes'): ?>
                    	<?php if ($this->_tpl_vars['myobj']->populateRatingDetails($this->_tpl_vars['result']['rating'])): ?>
                    		<?php echo $this->_tpl_vars['myobj']->populatePhotoRatingImages($this->_tpl_vars['result']['rating'],'photo'); ?>

                    	<?php else: ?>
                    		<?php echo $this->_tpl_vars['myobj']->populatePhotoRatingImages(0,'photo'); ?>

                    	<?php endif; ?>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['result']['record']['allow_ratings'] != 'Yes'): ?>
						<span class="clsRatingDisabled"><span><?php echo $this->_tpl_vars['LANG']['photolist_rating_disabled']; ?>
</span></span>
					<?php else: ?>
                    	&nbsp;( <span><span><?php echo $this->_tpl_vars['result']['record']['rating_count']; ?>
</span></span> )
                    <?php endif; ?>
				  </div>
                  <div>
                    <p class="clsLeft"><?php echo $this->_tpl_vars['LANG']['photolist_views']; ?>
</p>
                    <p class="clsRight">: <span><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostviewed' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['result']['sum_total_views']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['result']['record']['total_views']; ?>
</span></p>
                  </div>
                  <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'featuredphotolist'): ?>
                  <div>
                    <p class="clsLeft"><?php echo $this->_tpl_vars['LANG']['photo_featured']; ?>
</p>
                    <p class="clsRight">: <span><?php echo $this->_tpl_vars['result']['record']['total_featured']; ?>
</span></p>
                  </div>
                  <?php endif; ?>
                  <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'featuredphotolist'): ?>
                  <div>
                    <p class="clsLeft"><?php echo $this->_tpl_vars['LANG']['photo_list_commented']; ?>
</p>
                    <p class="clsRight">: <span><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostdiscussed' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['result']['sum_total_comments']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['result']['record']['total_comments']; ?>
</span></p>
                  </div>
                  <?php endif; ?>
                  <div>
                    <p class="clsLeft"><?php echo $this->_tpl_vars['LANG']['photo_list_favorite']; ?>
</p>
                    <p class="clsRight">: <span><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostfavorite' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['result']['sum_total_favorite']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['result']['record']['total_favorites']; ?>
</span></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="clsContentDetails clsOverflow">
              <div class="clsContentPhotoTags"> <?php if ($this->_tpl_vars['myobj']->getFormField('photo_tags') != ''): ?>
                <?php $this->assign('photo_tag', $this->_tpl_vars['myobj']->getFormField('photo_tags')); ?>
                <?php elseif ($this->_tpl_vars['myobj']->getFormField('tags') != ''): ?>
                <?php $this->assign('photo_tag', $this->_tpl_vars['myobj']->getFormField('tags')); ?>
                <?php else: ?>
                <?php $this->assign('photo_tag', ''); ?>
                <?php endif; ?>
                <p><?php echo $this->_tpl_vars['LANG']['photo_list_tags']; ?>
:<?php if ($this->_tpl_vars['result']['record']['photo_tags'] != ''): ?> <?php echo $this->_tpl_vars['myobj']->getPhotoTagsLinks($this->_tpl_vars['result']['record']['photo_tags'],5,$this->_tpl_vars['photo_tag']); ?>
<?php endif; ?></p>
              </div>

            </div>
            <?php elseif ($this->_tpl_vars['myobj']->getFormField('thumb') == 'yes'): ?>
                <div class="clsLargeThumbImageBackground clsNoLink" <?php if (isMember ( )): ?>onmouseover="showCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
');" onmouseout="hideCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
')"<?php endif; ?> >
                      <div ><a id="<?php echo $this->_tpl_vars['result']['anchor']; ?>
"></a> <?php if ($this->_tpl_vars['result']['img_src']): ?> <?php if ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?><a href="<?php echo $this->_tpl_vars['result']['view_photo_link']; ?>
" class="cls146x112 clsImageHolder clsImageBorderBg"><?php endif; ?><img src="<?php echo $this->_tpl_vars['result']['img_src']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['photo_title_word_wrap_not_highlight'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
"  title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap_not_highlight']; ?>
" id="image_img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['result']['record']['t_width'],$this->_tpl_vars['result']['record']['t_height']); ?>
/><?php if ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?></a><?php endif; ?> <?php else: ?> <img src="<?php echo $this->_tpl_vars['album_photo_count_list'][$this->_tpl_vars['result']['photo_album_id']]['img_src']; ?>
"  <?php echo $this->_tpl_vars['album_photo_count_list'][$this->_tpl_vars['result']['photo_album_id']]['img_disp_image']; ?>
 alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['photo_title_word_wrap_not_highlight'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
"  title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap_not_highlight']; ?>
"/> <?php endif; ?> </div>
                </div>
               <?php if ($this->_tpl_vars['result']['img_src']): ?><div class="clsSlideTip">  <a href="javascript:;"  title="<?php echo $this->_tpl_vars['LANG']['common_zoom']; ?>
" id="img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" onclick="zoom('img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
','<?php echo $this->_tpl_vars['result']['slideshow_img_src']; ?>
','<?php echo $this->_tpl_vars['result']['photo_description_word_wrap_js']; ?>
')" class="clsPhotoVideoEditLinks clsIndexZoomImg"><?php echo $this->_tpl_vars['LANG']['photo_list_photo_view']; ?>
</a></div> <?php endif; ?>
                <?php if (isMember ( )): ?>
					 <?php if ($this->_tpl_vars['result']['add_quickmix'] || ( ( $this->_tpl_vars['myobj']->getFormField('pg') == 'myphotos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending' || $this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] || isAdmin ( ) ) && $this->_tpl_vars['myobj']->getFormField('myfavoritephoto') != 'Yes' ) || $this->_tpl_vars['myobj']->getFormField('myfavoritephoto') == 'Yes' || ( $this->_tpl_vars['CFG']['admin']['photos']['add_photo_location'] && $this->_tpl_vars['result']['photo_status'] == 'Ok' && ( $this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] || isAdmin ( ) ) )): ?>
		                <div class="clsGetEditDel"  style="display:none" id="hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" onmouseover="showCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
');" onmouseout="hideCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
')">
                  <div> <?php if ($this->_tpl_vars['result']['add_quickmix']): ?>
                    <?php if ($this->_tpl_vars['result']['is_quickmix_added'] && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                    <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_remove_from_quickmix']; ?>
" ><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                    <p class="clsQuickMix" id="quick_mix_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_add_to_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                    <?php elseif ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                    <p class="clsQuickMix" id="quick_mix_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="removePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsQuickMix-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_remove_from_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                    <p class="clsQuickMix" id="quick_mix_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="updatePhotosQuickMixCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsQuickMix-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photo_list_add_to_quickmix']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_quick_mix']; ?>
</a></p>
                    <?php endif; ?>
                    <?php endif; ?> </div>

                    <!-- movie maker queue start -->
                    <div> <?php if ($this->_tpl_vars['result']['add_photo_movie_queue']): ?>
                    <?php if ($this->_tpl_vars['result']['is_moviequeue_added'] && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                    <p class="clsMovieQueue" id="movie_queue_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_remove_from_movie_queue']; ?>
" ><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                    <p class="clsMovieQueue" id="movie_queue_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_add_to_movie_queue']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                    <?php elseif ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                    <p class="clsMovieQueue" id="movie_queue_added_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
" style="display:none"><a href="javascript:void(0)" onClick="removePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')"  class="clsMovieQueue-on clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_remove_from_movie_queue']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                    <p class="clsMovieQueue" id="movie_queue_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"><a href="javascript:void(0)" onClick="updatePhotosMovieQueueCount('<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" class="clsMovieQueue-off clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_photo_add_to_movie_queue']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_photo_movie_queue']; ?>
</a></p>
                    <?php endif; ?>
                    <?php endif; ?> </div>
                      <!-- movie maker queue end -->

                  <div> <?php if (( $this->_tpl_vars['myobj']->getFormField('pg') == 'myphotos' || $this->_tpl_vars['myobj']->getFormField('pg') == 'pending' || $this->_tpl_vars['result']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] || isAdmin ( ) ) && $this->_tpl_vars['myobj']->getFormField('myfavoritephoto') != 'Yes'): ?>
                    <ul id="selPhotoLinks" class="clsContentEditLinks">
					<?php if ($this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                      <li class="clsEdit"> <a href="<?php echo $this->_tpl_vars['result']['photoupload_url']; ?>
" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photolist_edit_photo']; ?>
"> </a> </li>
					 <?php endif; ?>
                      <li class="clsDelete" id="anchor_myvid_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"> <a href="javascript:void(0)" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photolist_delete_photo']; ?>
" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'), Array('delete','<?php echo $this->_tpl_vars['result']['photo_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo $this->_tpl_vars['result']['delete_photo_title']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myvid_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
');"> </a> </li>
                      <?php if ($this->_tpl_vars['CFG']['admin']['photos']['add_photo_location'] && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                      <li class="clsGetCode"> <a href="javascript:void(0);" title="<?php echo $this->_tpl_vars['LANG']['photo_list_location_title']; ?>
" onclick="javascript:myLightWindow.activateWindow( <?php echo '{'; ?>
type:'external',href:'<?php echo $this->_tpl_vars['result']['location_url']; ?>
',title:'<?php echo $this->_tpl_vars['LANG']['photolist_addlocation_title']; ?>
',width:525,height:420 <?php echo '}'; ?>
);" class="clsPhotoVideoEditLinks"><?php echo $this->_tpl_vars['LANG']['photo_list_location']; ?>
</a></li>
                      <?php endif; ?>
                    </ul>
                    <?php endif; ?> </div>
                  <div> <?php if ($this->_tpl_vars['myobj']->getFormField('myfavoritephoto') == 'Yes'): ?>
                    <ul id="selPhotoLinks" class="clsContentEditLinks">
                      <li class="clsGetCode" id="anchor_getcode_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"> <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photolist_get_code']; ?>
"  onClick="return getAjaxGetCode('<?php echo $this->_tpl_vars['result']['callAjaxGetCode_url']; ?>
', '<?php echo $this->_tpl_vars['result']['anchor']; ?>
','selEditPhotoComments','anchor_getcode_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
')" ></a> </li>
                      <li class="clsDelete" id="anchor_myfav_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
"> <a href="javascript:void(0)" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photolist_delete_photo']; ?>
" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform',                        Array('act','photo_id', 'selPhotoId', 'delete_photo_msg_id'),                                           Array('favorite_delete','<?php echo $this->_tpl_vars['result']['photo_id']; ?>
', '<?php echo $this->_tpl_vars['result']['img_src']; ?>
', '<?php echo $this->_tpl_vars['result']['delete_photo_title']; ?>
'),                       Array('value','value', 'src', 'innerHTML'), -100, -300,'anchor_myfav_<?php echo $this->_tpl_vars['result']['photo_id']; ?>
');"></a> </li>
                    </ul>
                    <?php endif; ?> </div>
                </div>
					<?php endif; ?>
                <?php endif; ?>
              <div class="clsContentThumbDetails">
              <div class="clsThumbTitles">
              <?php if (isMember ( ) && $this->_tpl_vars['result']['photo_status'] == 'Ok'): ?>
                <p class="clsListCheckBox">
                  <input type="checkbox" name="checkbox[]" id="view_photo_checkbox_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" class="clsRadioButtonBorder" value="<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" onClick="disableHeading('photoListForm');"/>
                </p>
                <?php endif; ?>
                <p class="clsHeading"><a class="clsNoPhotoLink" href="<?php echo $this->_tpl_vars['result']['view_photo_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap']; ?>
"><?php echo $this->_tpl_vars['result']['photo_title_word_wrap']; ?>
</a></p>
                </div>
                <div class="clsThumbViewDetail clsOverflow">
                  <div class="clsThumbUserDet">
                    <p class="clsLeft clsUserLink"><?php echo $this->_tpl_vars['LANG']['photo_list_by']; ?>
 <a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl[$this->_tpl_vars['result']['record']['user_id']]; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['result']['record']['user_name']; ?>
</a></p>
                    <p class="clsRight"><span class="clsLinkSeperator">|</span><span><?php echo $this->_tpl_vars['result']['date_added']; ?>
</span></p>
                  </div>
                  <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'phototoprated'): ?>
                  <div>
                  	<p class="clsLeft clsThumbViewValue"><?php echo $this->_tpl_vars['LANG']['photolist_views']; ?>
:
                    <span><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostviewed' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['result']['sum_total_views']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['result']['record']['total_views']; ?>
</span>
                    </p>
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'featuredphotolist'): ?>
                    <p class="clsRight clsThumbViewValue"><span class="clsLinkSeperator">|</span><?php echo $this->_tpl_vars['LANG']['photo_featured']; ?>
 <span><?php echo $this->_tpl_vars['result']['record']['total_featured']; ?>
</span></p>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostdiscussed' || ( $this->_tpl_vars['myobj']->getFormField('pg') != 'featuredphotolist' && $this->_tpl_vars['myobj']->getFormField('pg') != 'photomostfavorite' )): ?>
                    <p class="clsRight clsThumbViewValue"><span class="clsLinkSeperator">|</span><?php echo $this->_tpl_vars['LANG']['photo_list_commented']; ?>
: <span><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostdiscussed' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['result']['sum_total_comments']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['result']['record']['total_comments']; ?>
</span></p>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'photomostfavorite'): ?>
                    <p class="clsRight clsThumbViewValue">&nbsp;|&nbsp;<?php echo $this->_tpl_vars['LANG']['photo_list_favorite']; ?>
 <span><?php echo $this->_tpl_vars['result']['record']['total_favorites']; ?>
</span></p>
                    <?php endif; ?>

                  </div>
                  <?php else: ?>
                  <div class="clsPhotoRating"> <?php if ($this->_tpl_vars['result']['record']['allow_ratings'] == 'Yes'): ?>
                    <p class="clsLeft clsThumbViewValue clsTopRatedIcon">
                        <?php if ($this->_tpl_vars['myobj']->populateRatingDetails($this->_tpl_vars['result']['rating'])): ?>
                        <?php echo $this->_tpl_vars['myobj']->populatePhotoRatingImages($this->_tpl_vars['result']['rating'],'photo'); ?>

                        <?php else: ?>
                        <?php echo $this->_tpl_vars['myobj']->populatePhotoRatingImages(0,'photo'); ?>

                        <?php endif; ?>
                   <?php endif; ?>
                    </p>
                    <p class="clsRight clsThumbViewValue">&nbsp;(<span> <span><?php echo $this->_tpl_vars['result']['record']['rating_count']; ?>
</span> </span>)</p>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif; ?> </div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
        <?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
        <?php endforeach; endif; unset($_from); ?> </div>
      <?php else: ?>
      <div id="selMsgAlert">
        <p><?php echo $this->_tpl_vars['LANG']['common_photo_no_records_found']; ?>
</p>
      </div>
      <?php endif; ?>
      <?php endif; ?>
      <div class="clsPhotoPaging">
        <div class="clsPagingList">
          <ul>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </form>
  </div>
</div>
<!--<script src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
js/visuallightbox.js" type="text/javascript"></script>-->
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script>
$Jq(document).ready(function() {

	for(var i=0;i<photo_location_ids.length;i++)
	{
		$Jq(\'#show_photo_location_\'+photo_location_ids[i]).fancybox({
			\'width\'				: 539,
			\'height\'			: 430,
			\'padding\'			:  0,
			\'autoScale\'     	: false,
			\'transitionIn\'		: \'none\',
			\'transitionOut\'		: \'none\',
			\'type\'				: \'iframe\'
		});
	}

});
function showPhotosInLocation(divid,callurl)
{
	var did = \'#list_photo_location_\'+divid;
	$Jq.fancybox({
		\'orig\' : $Jq(did),
		\'href\'              : callurl,
		\'width\'				: 539,
		\'height\'			: 430,
		\'autoScale\'     	: false,
		\'transitionIn\'		: \'none\',
		\'transitionOut\'		: \'none\',
		\'type\'				: \'iframe\'
	});
}
</script>
'; ?>

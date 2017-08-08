<?php /* Smarty version 2.6.18, created on 2012-02-02 19:29:05
         compiled from peopleOnPhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'peopleOnPhoto.tpl', 76, false),array('modifier', 'truncate', 'peopleOnPhoto.tpl', 85, false),)), $this); ?>
<div class="clsPhotoListContainer clsOverflow">
  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <form id="searchAdvancedFilter" name="searchAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
  <input type="hidden" name="advanceFromSubmission" value="1"/>
  <div class="clsOverflow">
      <div class="clsMainBarHeading">
        <h3><?php echo $this->_tpl_vars['myobj']->pageTitle; ?>
</h3>
      </div>
  </div>
  <!-- Search Starts Here -->
      <div id="advanced_search">
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <div class="clsOverflow">
          <div class="clsAdvancedSearchBg">
          <table class="clsAdvancedFilterTable">
          <?php if ($this->_tpl_vars['myobj']->getFormField('tagged_by')): ?>
            <tr><td colspan="2"><input class="clsTextBox" type="text" name="advanced_people_name" id="advanced_people_name" value="<?php if ($this->_tpl_vars['myobj']->getFormField('people') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('people'); ?>
<?php elseif ($this->_tpl_vars['myobj']->getFormField('advanced_people_name') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('advanced_people_name'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['peopleonphoto_search_people_name']; ?>
<?php endif; ?>" onBlur="setOldValue('advanced_people_name')"  onfocus="clearValue('advanced_people_name')"/></td></tr>
          <?php elseif ($this->_tpl_vars['myobj']->getFormField('tagged_of')): ?>
            <tr>
              <td colspan="2">
                <input class="clsTextBox" type="text" name="advanced_tag_by_user" id="advanced_tag_by_user" value="<?php if ($this->_tpl_vars['myobj']->getFormField('advanced_tag_by_user') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('advanced_tag_by_user'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['peopleonphoto_search_tagged_by']; ?>
<?php endif; ?>" onBlur="setOldValue('advanced_tag_by_user')"  onfocus="clearValue('advanced_tag_by_user')"/>
              </td>
            </tr>
          <?php else: ?>
            <tr>
              <td colspan="2"><input class="clsTextBox" type="text" name="advanced_people_name" id="advanced_people_name" value="<?php if ($this->_tpl_vars['myobj']->getFormField('people') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('people'); ?>
<?php elseif ($this->_tpl_vars['myobj']->getFormField('tag_name') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('tag_name'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['peopleonphoto_search_people_name']; ?>
<?php endif; ?>" onBlur="setOldValue('advanced_people_name')"  onfocus="clearValue('advanced_people_name')"/></td>
                          </tr>
           <?php endif; ?>
            <tr>
              <td colspan="2" align="right" valign="middle"><div class="clsSearchButton-l"><span class="clsSearchButton-r">
                  <input type="submit" name="avd_search" id="avd_search"  onclick="document.searchAdvancedFilter.start.value = '0';" value="<?php echo $this->_tpl_vars['LANG']['peopleonphoto_search_submit']; ?>
" />
                  </span></div>
                <div class="clsResetButton-l"><span class="clsResetButton-r">
                  <input type="button" name="avd_reset" id="avd_reset"  value="<?php echo $this->_tpl_vars['LANG']['peopleonphoto_reset_submit']; ?>
" onclick="location.href='<?php echo $this->_tpl_vars['photoTagsRedirectUrl']; ?>
'"/>
                  </span></div></td>
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
  <!-- Search Ends Here -->
  </form>
  <div id="selLeftNavigation">
    <form name="peopleOnPhotoForm" id="peopleOnPhotoForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
     <?php echo $this->_tpl_vars['myobj']->populatePhotoListHidden($this->_tpl_vars['paging_arr']); ?>

	 <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photo_list')): ?>
      <div class="clsViewBorder clsOverflow">
        <div class="clsThumbViewLeft">
          <p class="clsThumbView">&nbsp;</p>
        </div>

        <div class="clsSortByLinksContainer">
          <div class="clsSortByPagination clsPhotoPaginationRight">
            <div class="clsPhotoPaging">
              <div class="clsPagingList">
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
        </div>
      </div>
      <a href="javascript:void(0)" id="<?php echo $this->_tpl_vars['myobj']->my_photos_form['anchor']; ?>
"></a>
      <?php $this->assign('count', 1); ?>
      <div id="selDetailViewId">
        <?php $_from = $this->_tpl_vars['photo_list_result']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['photo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['photo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['result']):
        $this->_foreach['photo']['iteration']++;
?>
        <input type="hidden" name="default" id="default" value="<?php echo $this->_tpl_vars['myobj']->getFormField('default'); ?>
" />
        <?php echo smarty_function_cycle(array('values' => 'clsOddListContents , clsEvenListContents ','assign' => 'CellCSS'), $this);?>

        <div class="<?php echo $this->_tpl_vars['CellCSS']; ?>
 clsListContents <?php if ($this->_tpl_vars['count'] % 3 == 0): ?> clsThumbPhotoFinalRecord<?php endif; ?>">
         <div class="clsPeopleOnPhoto">
          <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="clsOverflow">
            <div class="clsThumb">
              <div class="clsLargeThumbImageBackground clsNoLink" onmouseover="showCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
');" onmouseout="hideCaption('hideMenu_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
')">
                <div class="clsPhotoThumbImageOuter" >
					<a  href="<?php echo $this->_tpl_vars['result']['viewphoto_url']; ?>
" class="cls146x112 clsImageHolder clsImageBorderBg clsPointer"><img src="<?php echo $this->_tpl_vars['result']['img_src']; ?>
" title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap_js']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['photo_title_word_wrap_js'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 25) : smarty_modifier_truncate($_tmp, 25)); ?>
" id="image_img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['result']['t_width'],$this->_tpl_vars['result']['t_height']); ?>
/></a>
                </div>
              </div>
              <div class="clsSlideTip">  <a href="javascript:;"  title="<?php echo $this->_tpl_vars['LANG']['common_zoom']; ?>
" id="img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
" onclick="zoom('img_<?php echo $this->_tpl_vars['result']['record']['photo_id']; ?>
','<?php echo $this->_tpl_vars['result']['zoom_img_src']; ?>
','<?php echo $this->_tpl_vars['result']['photo_title_word_wrap_js']; ?>
')" class="clsPhotoVideoEditLinks clsIndexZoomImg"><?php echo $this->_tpl_vars['LANG']['peopleonphoto_photo_view']; ?>
</a>  </div>
             </div>
            <div class="clsContentDetails clsOverflow">
              <div class="clsMoreInfoContent">
                <div class="clsOverflow">
                  <div>
                    <p class="clsHeading"><a  href="<?php echo $this->_tpl_vars['result']['viewphoto_url']; ?>
" title="<?php echo $this->_tpl_vars['result']['photo_title_word_wrap']; ?>
"><?php echo $this->_tpl_vars['result']['photo_title_word_wrap']; ?>
</a></p>
                  </div>
                  <div class="clsOverflow">
                 <div class="clsPeopleOnThisPhoto">
                  	<?php if (isset ( $this->_tpl_vars['result']['tagged_by_href'] )): ?>
                      <div>
                    	<p class="clsPeoplePhotoLeft"><?php echo $this->_tpl_vars['LANG']['peopleonphoto_people_in_this_photo']; ?>
</p>
                      </div>
                      <div class="clsColon">:</div>
                      <div>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		<?php $_from = $this->_tpl_vars['result']['tagged_by_href']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['other_tags']):
?>
						  		<a href="<?php echo $this->_tpl_vars['other_tags']['viewlink']; ?>
"><?php echo $this->_tpl_vars['other_tags']['tagname']; ?>
</a>
						  	<?php endforeach; endif; unset($_from); ?>
                    	</p>
                      </div>
                    <?php elseif (isset ( $this->_tpl_vars['result']['all_tag_href'] )): ?>
                       <div>
                    	<p class="clsPeoplePhotoLeft"><?php echo $this->_tpl_vars['LANG']['peopleonphoto_people_in_this_photo']; ?>
</p>
                       </div>
                       <div class="clsColon">:</div>
                       <div>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		<?php $_from = $this->_tpl_vars['result']['all_tag_href']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['all_tags']):
?>
						  		<a href="<?php echo $this->_tpl_vars['all_tags']['viewlink']; ?>
"><?php echo $this->_tpl_vars['all_tags']['tagname']; ?>
</a>
						  	<?php endforeach; endif; unset($_from); ?>
                    	</p>
                       </div>
                    <?php elseif (isset ( $this->_tpl_vars['result']['tagged_of_href'] )): ?>
                      <div>
                    	<p class="clsPeoplePhotoLeft"><?php echo $this->_tpl_vars['LANG']['peopleonphoto_people_in_this_photo']; ?>
</p>
                      </div>
                      <div class="clsColon">:</div>
                      <div>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		<?php $_from = $this->_tpl_vars['result']['tagged_of_href']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['all_tags']):
?>
						  		<a href="<?php echo $this->_tpl_vars['all_tags']['viewlink']; ?>
"><?php echo $this->_tpl_vars['all_tags']['tagname']; ?>
</a>
						  	<?php endforeach; endif; unset($_from); ?>
                    	</p>
                      </div>
                    <?php endif; ?>
                    </div>
                  </div>
                  <div class="clsOverflow clsPeopleOnTags">
                    <p class="clsPeoplePhotoLeft"><?php echo $this->_tpl_vars['LANG']['peopleonphoto_tagged_by']; ?>
</p>
                    <div class="clsColon">:</div>
                    <?php if (! isset ( $this->_tpl_vars['result']['tag_by_profile_url'] ) && ! isset ( $this->_tpl_vars['result']['tag_of_profile_url'] ) && ! isset ( $this->_tpl_vars['result']['tag_user_profile_url'] )): ?>
                    	<p class="clsPeoplePhotoRight clsUserLink"><a href="<?php echo $this->_tpl_vars['result']['memberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['result']['tagged_user_name']; ?>
</a></p>
                    <?php elseif (isset ( $this->_tpl_vars['result']['tag_by_profile_url'] )): ?>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		<?php $_from = $this->_tpl_vars['result']['tag_by_profile_url']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['tag_by_user_profile']):
?>
				  				<a href="<?php echo $this->_tpl_vars['tag_by_user_profile']['viewlink']; ?>
" ><?php echo $this->_tpl_vars['tag_by_user_profile']['tagname']; ?>
</a>
					  		<?php endforeach; endif; unset($_from); ?>
						</p>
                    <?php elseif (isset ( $this->_tpl_vars['result']['tag_of_profile_url'] )): ?>
                    	<p class="clsPeoplePhotoRight clsUserLink">
                    		<?php $_from = $this->_tpl_vars['result']['tag_of_profile_url']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['tag_of_user_profile']):
?>
				  				<a href="<?php echo $this->_tpl_vars['tag_of_user_profile']['viewlink']; ?>
"><?php echo $this->_tpl_vars['tag_of_user_profile']['tagname']; ?>
</a>
					  		<?php endforeach; endif; unset($_from); ?>
						</p>
                    <?php elseif (isset ( $this->_tpl_vars['result']['tag_user_profile_url'] )): ?>
                    	<p class="clsPeoplePhotoRight clsUserLink">
							<?php $_from = $this->_tpl_vars['result']['tag_user_profile_url']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['tag_user_profile']):
?>
				  				<a href="<?php echo $this->_tpl_vars['tag_user_profile']['viewlink']; ?>
"><?php echo $this->_tpl_vars['tag_user_profile']['tagname']; ?>
</a>
					  		<?php endforeach; endif; unset($_from); ?>
					  	</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
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
        <?php endforeach; endif; unset($_from); ?> </div>
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
      <?php else: ?>
      <div id="selMsgAlert">
        <p><?php echo $this->_tpl_vars['LANG']['peopleonphoto_no_photos_found']; ?>
</p>
      </div>
      <?php endif; ?>
    </form>
  </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
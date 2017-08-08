<?php /* Smarty version 2.6.18, created on 2011-10-17 15:12:14
         compiled from index.tpl */ ?>
<div class="clsOverflow">
    <div class="clsIndexPhotoMainBar">
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_feartured_photolist')): ?>
      <?php echo $this->_tpl_vars['myobj']->populateFeaturedPhotolist(); ?>

      <?php endif; ?>
      

            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_photo_block')): ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexPhotoBlockHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
      
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_photo_channel_block')): ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <div class="clsIndexMainContainer"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexPhotoChannelBlockHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
      <?php endif; ?>
      
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_photo_slidelist_block')): ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <div class="clsIndexMainContainer"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexPhotoSlidelistBlockHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
      <?php endif; ?>
      
		        <div class="cls468pxBanner">
            <div><?php global $CFG; getAdvertisement('bottom_banner_468x60') ?></div>
        </div>
        	
		

                  
                                    
                  </div>

	<div class="clsIndexPhotoSideBar"> <?php echo $this->_tpl_vars['header']->displayLoginFormRightNavigation(); ?>


         <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_activity_block')): ?>
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <div class="clsWhatsGoingOnContainer"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "indexActivityHead.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
      <?php endif; ?>
  
    <?php if (ismember ( )): ?>
  <?php echo $this->_tpl_vars['myobj']->populateMemberDetail('photo'); ?>

  <?php endif; ?>
  
    <?php echo $this->_tpl_vars['myobj']->populateMemberDetail('slidelist'); ?>

  
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('sidebar_topcontributors_block')): ?>
  <?php echo $this->_tpl_vars['myobj']->topContributors(); ?>

  <?php endif; ?>
  
  
      <div class="clsSideBarContent clsCategoryHd">
      <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         <div class="clsOverflow">
            <h3 id="photoCategoryHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                <!--<a onClick="showPhotoSidebarTab('photoCategory','photoTags');">--><?php echo $this->_tpl_vars['LANG']['sidebar_genres_heading_label']; ?>
<!--</a>-->
            </h3>
        </div>
       <div  id="photoCategoryContent"> <?php echo $this->_tpl_vars['myobj']->populateGenres(); ?>
 </div>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'sidebar_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   </div>
  
     <div class="cls336pxBanner">
       <div><?php getAdvertisement('sidebanner1_336x280') ?></div>
   </div>
  
     <div class="clsSideBarContent clsCategoryHd">
        <div class="clsOverflow clsTagsHeading">
            <h3 id="photoTagsHeader" class="clsSideBarLeftTitle clsPaddingLeft5">
                <!--<a onClick="showPhotoSidebarTab('photoTags','photoCategory');">--><?php echo $this->_tpl_vars['LANG']['sidebar_photo_tags_heading_label']; ?>
<!--</a> -->
            </h3>
         </div>

       <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'phototags_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
             <div  id="photoTagsContent"> <?php echo $this->_tpl_vars['myobj']->populateSidebarClouds('photo','photo_tags',20); ?>
 </div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'phototags_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
     </div>

   <!-- <div class="clsSideCaroselContainer">
    </div>-->
   

    </div>
</div>
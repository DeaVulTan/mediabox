<?php /* Smarty version 2.6.18, created on 2012-02-02 14:07:08
         compiled from photoCategory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'photoCategory.tpl', 115, false),)), $this); ?>
<div id="selphotoCategory" class="clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="clsOverflow">
            <div class="clsHeadingLeft">
            <h2><span><?php echo $this->_tpl_vars['LANG']['photocategory_page_title']; ?>
</span></h2>
        </div>
		<div class="clsPhotoListHeadingRight clsMyCategroySubscription">
		   <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
					<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('mysubscription','?pg=category_subscription','category_subscription/',''); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_tag_my_subscriptions']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_tag_my_subscriptions']; ?>
</a>
		   <?php endif; ?>
	   </div>
    </div>
    <div class="clsBackToCategory"> 
            <?php if ($this->_tpl_vars['myobj']->getFormField('category_id') != ''): ?>
            <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photocategory','','','members','photo'); ?>
"><?php echo $this->_tpl_vars['LANG']['photocategory_back_to_category']; ?>
</a>
           <?php endif; ?>
     </div>
    <div id="topLinks">
      <div class="clsAudioPaging">
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
    <div class="clsLeftNavigation" id="selLeftNavigation">
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_category')): ?>
       <div class="clsOverflow">
     	  <div id="selShowAllShoutouts" class="clsDataTable clsCategoryNoPadding clsCategoryTable">
             <div summary="<?php echo $this->_tpl_vars['LANG']['photocategory_tbl_summary']; ?>
" id="selCategoryTable" class="cls5TdTable">
	        <?php if (! $this->_tpl_vars['myobj']->isResultsFound()): ?>
    	    <div><p><?php echo $this->_tpl_vars['LANG']['photocategory_no_category']; ?>
</p></div>
			<?php else: ?>
            <?php $this->assign('countt', 1); ?>
            <?php $this->assign('inc', 0); ?>
            <?php $this->assign('count', '0'); ?>
            <?php $_from = $this->_tpl_vars['myobj']->form_show_category; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categorylist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categorylist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['count'] => $this->_tpl_vars['result']):
        $this->_foreach['categorylist']['iteration']++;
?>
           	<?php echo $this->_tpl_vars['result']['open_tr']; ?>

            	<div id="selphotoGallery" class="clsphotoCategoryCell">
                  <div class="clsNewAlbumList <?php if ($this->_tpl_vars['countt'] % 3 == 0): ?> clsThumbPhotoFinalRecord<?php endif; ?>">
         			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                	  <div class="clsChannelLeftContent">
                            <div class="clsLargeThumbImageBackground">
                              <div class="clsPhotoThumbImageOuter">
							  <div class="cls146x112 clsImageHolder clsImageBorderBg clsPointer">
                              	<a href="<?php echo $this->_tpl_vars['result']['photo_link']; ?>
" class="cls146x112 clsImageHolder clsImageBorderBg clsPointer">
                                     <img border="0" src="<?php echo $this->_tpl_vars['result']['category_image']; ?>
" alt="<?php echo $this->_tpl_vars['result']['record']['photo_category_name']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['photo_category_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['CFG']['admin']['photos']['category_width'],$this->_tpl_vars['CFG']['admin']['photos']['category_height']); ?>
/></a>
									 </div>
                              </div>
                            </div>
                            </div>
					  <div id="selImageDet" class="clsPhotoCategoryList">
						<p class="clsHeading">
							<a href="<?php echo $this->_tpl_vars['result']['photo_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['photo_category_name']; ?>
">
								<?php echo $this->_tpl_vars['result']['record']['photo_category_name']; ?>

							</a>
						</p>
					<p><?php echo $this->_tpl_vars['LANG']['search_option_today']; ?>
: <span><?php echo $this->_tpl_vars['result']['today_category_count']; ?>
</span>&nbsp;|&nbsp;<?php echo $this->_tpl_vars['LANG']['photocategory_total']; ?>
<span><?php echo $this->_tpl_vars['result']['record']['photo_category_count']; ?>
</span></p>
					<?php if ($this->_tpl_vars['result']['content_filter']): ?>
					  <div class="clsOverflow">
                        <div class="clsSubCategory">
                          <ul>
							<li><?php if ($this->_tpl_vars['myobj']->getFormField('category_id') == ''): ?><a href="<?php echo $this->_tpl_vars['result']['record']['photo_sub_url']; ?>
"  class="clsSubCategoryIcon clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['photocategory_photo_subcategory']; ?>
"><?php echo $this->_tpl_vars['LANG']['photocategory_photo_subcategory']; ?>
</a></li>
                            <li class="clsGenereType">|</li><?php endif; ?>
                            <li class="clsGenereType"><?php echo $this->_tpl_vars['LANG']['genre_type']; ?>
:</li>
                            <li class="clsCategoryType"><?php echo $this->_tpl_vars['result']['record']['photo_category_type']; ?>
</li>
                           <!-- <li class="clsGenereType">|</li>-->
                          </ul>
                         </div>
							                            <?php if (chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
                              <div class="clsSubscribeList">
                                <ul>
                                    <?php if (isMember ( )): ?>
                                          <?php if (! $this->_tpl_vars['myobj']->chkIsUserSubscribedToCategory($this->_tpl_vars['result']['record']['photo_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page'])): ?>
                                               <li id="subscribe_<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
">
                                                   <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
, 'Yes', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
</a></span>
                                               </li>
                                                <li id="unsubscribe_<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
" style="display:none">
                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
, 'No', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
</a></span>
                                                </li>
                                          <?php else: ?>
                                                <li id="unsubscribe_<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
">
                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
, 'No', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
</a></span>
                                               </li>
                                                <li id="subscribe_<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
" style="display:none">
                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
, 'Yes', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
</a></span>
                                                </li>
                                          <?php endif; ?>
                                    <?php else: ?>
                                      <li>
                                          <span><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('photocategory','','','','photo'); ?>
" class="clsSubscribeIcon clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
</a></span>
                                      </li>
                                    <?php endif; ?>
                                   </ul>
                                 </div>
                                 <?php endif; ?>
                              						</div>
					<?php endif; ?>
					<?php if (chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
					   <p class="clsPhotoCategoryDesc"><?php echo $this->_tpl_vars['LANG']['common_totalsubscriptions']; ?>
: <span id="total_sub_<?php echo $this->_tpl_vars['result']['record']['photo_category_id']; ?>
"><?php echo $this->_tpl_vars['myobj']->getCategorySubscriptionCount($this->_tpl_vars['result']['record']['photo_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
</span></p>
					 <?php endif; ?>
					</div>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'listimage_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                  </div>
				</div>

			<?php echo $this->_tpl_vars['result']['end_tr']; ?>

            <?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

            <?php if ($this->_tpl_vars['count']%$this->_tpl_vars['CFG']['admin']['photos']['catergory_list_per_row'] == 0): ?>
            	<?php echo smarty_function_counter(array('start' => 0), $this);?>

            <?php endif; ?>
            <?php $this->assign('countt', $this->_tpl_vars['countt']+1); ?>
            <?php endforeach; endif; unset($_from); ?>
            <?php $this->assign('cols', $this->_tpl_vars['CFG']['admin']['photos']['catergory_list_per_row']-$this->_tpl_vars['count']); ?>
           <?php if ($this->_tpl_vars['count']): ?>
                <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['cols']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                    <p>&nbsp;</p>
                <?php endfor; endif; ?>
            <?php endif; ?>
			<?php endif; ?>
         	</div>
          </div>
       </div>
                <div class="clsOverflow clsSlideBorder">
                  <div id="bottomLinks"><div class="clsAudioPaging">
                   <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                  <?php endif; ?>
                  </div>
                </div>
           </div>
    <?php endif; ?>
	</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
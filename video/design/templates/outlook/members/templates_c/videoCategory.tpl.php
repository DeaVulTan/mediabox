<?php /* Smarty version 2.6.18, created on 2012-02-01 17:59:29
         compiled from videoCategory.tpl */ ?>
<div id="selVideoCategory">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="clsOverflow">
            <div class="clsVideoListHeading">
            <h2><span><?php echo $this->_tpl_vars['myobj']->LANG['videocategory_page_title']; ?>
</span></h2>
        </div>
        <div class="clsVideoListHeadingRight">
              <div class="clsMyCategroySubscription">
                   <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == ''): ?>
                        <a href="<?php echo $this->_tpl_vars['myobj']->my_subscription_url; ?>
"><?php echo $this->_tpl_vars['LANG']['common_category_my_subscriptions']; ?>
</a>
                      <?php else: ?>
                        <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videocategory','','','members','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_category_showall']; ?>
</a>
                      <?php endif; ?>
                   <?php endif; ?>
               </div>
        </div>
    </div>
     <div class="clsBackToCategory">
            <?php if ($this->_tpl_vars['myobj']->getFormField('category_id') != ''): ?>
            <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videocategory','','','members','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['videocategory_back_to_category']; ?>
</a>
           <?php endif; ?>
     </div>
    <div id="topLinks">
    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
    </div>
    <div class="clsLeftNavigation" id="selLeftNavigation">
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_category')): ?>
		<div id="selShowAllShoutouts" class="clsDataTable clsCategoryTable">
			<div id="">
	              <table summary="<?php echo $this->_tpl_vars['LANG']['videocategory_tbl_summary']; ?>
" id="selCategoryTable">
                    <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                        <?php $this->assign('inc', 0); ?>
                        <?php $_from = $this->_tpl_vars['myobj']->form_show_category; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categorylist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categorylist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['count'] => $this->_tpl_vars['result']):
        $this->_foreach['categorylist']['iteration']++;
?>
                              <?php if ($this->_tpl_vars['result']['open_tr']): ?>
                                    <tr>
                              <?php endif; ?>

                              <td id="selVideoGallery" class="clsVideoCategoryCell clsChannelList">
                                   <div class="clsChannelListCont">
                                    <div id="selPhotCategoryImageDisp" class="clsOverflow">
                                          <div id="selImageBorder">
                                                <div class="clsThumbImageLink ">
                                                    <a href="<?php echo $this->_tpl_vars['result']['video_link']; ?>
" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                                                      <img src="<?php echo $this->_tpl_vars['result']['category_image']; ?>
" border="0" alt="<?php echo $this->_tpl_vars['result']['record']['video_category_name']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['video_category_name']; ?>
" />
                                                     </a> 
                                                </div>
                                          </div>
                                    </div>
                                    <div id="selImageDet" class="clsChannelNameHd">
                                          <h3>
                                                <a href="<?php echo $this->_tpl_vars['result']['video_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['video_category_name']; ?>
">
                                                      <?php echo $this->_tpl_vars['result']['record']['video_category_name']; ?>

                                                </a>
                                          </h3>
                                          <p>
                                                <?php echo $this->_tpl_vars['LANG']['search_option_today']; ?>
:
                                                <span class="clsChannelCount"><?php echo $this->_tpl_vars['result']['today_category_count']; ?>
</span>
                                                &nbsp;|&nbsp;
                                                <?php echo $this->_tpl_vars['LANG']['videocategory_total']; ?>

                                                <span class="clsChannelCount"><?php echo $this->_tpl_vars['result']['record']['video_category_count']; ?>
</span>
                                          </p>

                                    </div>

                                         <div class="clsSubCategory">
                                            <ul><?php if ($this->_tpl_vars['CFG']['admin']['videos']['sub_category']): ?>
												   <?php if ($this->_tpl_vars['myobj']->getFormField('category_id') == ''): ?>
														<li>
															<span class="clsSubCategoryIcon"><?php if ($this->_tpl_vars['result']['sub_category_count'] > 0): ?>
															  <a href="<?php echo $this->_tpl_vars['result']['sub_category_url']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['videocategory_video_subcategory']; ?>
">Sub categories</a><?php endif; ?>
															</span>

														</li>
													<?php endif; ?>
												<?php endif; ?>
												<li> <?php if ($this->_tpl_vars['result']['content_filter']): ?>
                                                <p class="clsCategoryType"> |  </li><?php echo $this->_tpl_vars['result']['record']['video_category_type']; ?>
</p>
                                      <?php endif; ?></li>
                                        	</ul>
                                        </div>


                                                                                      <div class="clsSubscribeList">
                                        	<ul>
                                                 <?php if (chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
                                                    <?php if (isMember ( )): ?>
                                                          <?php if (! $this->_tpl_vars['myobj']->chkIsUserSubscribedToCategory($this->_tpl_vars['result']['record']['video_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page'])): ?>
                                                               <li id="subscribe_<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
">
                                                                   <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
, 'Yes', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsSubscribeIcon"><?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
</a></span>
                                                                   &nbsp;
                                                                   (<?php echo $this->_tpl_vars['myobj']->getCategorySubscriptionCount($this->_tpl_vars['result']['record']['video_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
)
                                                               </li>
                                                                <li id="unsubscribe_<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
" style="display:none">
                                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
, 'No', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsUnSubscribeIcon"><?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
</a></span>
                                                                     &nbsp;
                                                                   (<?php echo $this->_tpl_vars['myobj']->getCategorySubscriptionCount($this->_tpl_vars['result']['record']['video_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
)
                                                                </li>
                                                          <?php else: ?>
                                                                <li id="unsubscribe_<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
">
                                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
, 'No', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsUnSubscribeIcon"><?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
</a></span>
                                                                     &nbsp;
                                                                   (<?php echo $this->_tpl_vars['myobj']->getCategorySubscriptionCount($this->_tpl_vars['result']['record']['video_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
)
                                                               </li>
                                                                <li id="subscribe_<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
" style="display:none">
                                                                    <span><a href="javascript:void(0);" id="anchor_subscribe" onclick="subscription_sep_action(<?php echo $this->_tpl_vars['result']['record']['video_category_id']; ?>
, 'Yes', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Category');" class="clsSubscribeIcon"><?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
</a></span>
                                                                     &nbsp;
                                                                   (<?php echo $this->_tpl_vars['myobj']->getCategorySubscriptionCount($this->_tpl_vars['result']['record']['video_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
)
                                                                </li>
                                                          <?php endif; ?>
                                                    <?php else: ?>
                                                      <li>
                                                          <span><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('videocategory','','','members','video'); ?>
" class="clsSubscribeIcon"><?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
</a></span>
                                                           &nbsp;
                                                           (<?php echo $this->_tpl_vars['myobj']->getCategorySubscriptionCount($this->_tpl_vars['result']['record']['video_category_id'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
)
                                                      </li>
                                                    <?php endif; ?>

                                                 <?php endif; ?>
                                                                                          </ul>
                                        </div>
                                   </p>
                                   </div>
                              </td>
                        <?php if ($this->_tpl_vars['result']['end_tr']): ?>
                              </tr>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                        <?php if ($this->_tpl_vars['myobj']->category_list['extra_td_tr']): ?>
                              <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['myobj']->category_list['records_per_row']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                                    <td>&nbsp;</td>
                              <?php endfor; endif; ?>
                        <?php endif; ?>
                     <?php else: ?>
                      <tr>
                        <td>
                        	<?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( ) && $this->_tpl_vars['myobj']->getFormField('pg') != ''): ?>
                                    <?php echo $this->_tpl_vars['LANG']['videocategory_no_subscriptions']; ?>

                              <?php else: ?>
					   	<?php if ($this->_tpl_vars['myobj']->getFormField('category_id') != ''): ?>
                              		<?php echo $this->_tpl_vars['LANG']['videocategory_no_category']; ?>

                                    <?php else: ?>
                                    	<?php echo $this->_tpl_vars['LANG']['videocategory_no_sub_category']; ?>

                                    <?php endif; ?>
                              <?php endif; ?>
                        </td>
                       </tr>
                     <?php endif; ?>
                  </table>
                   </div>
                <div id="bottomLinks">
                <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
                </div>
		</div>
    <?php endif; ?>
	</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
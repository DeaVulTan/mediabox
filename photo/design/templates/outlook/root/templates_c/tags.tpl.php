<?php /* Smarty version 2.6.18, created on 2012-02-02 06:00:17
         compiled from tags.tpl */ ?>
<div class="clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'photomain_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selGroupCreate" class="clsOverflow">
  <div class="clsOverflow">
   <div class="clsHeadingLeft"><h2><span><?php echo $this->_tpl_vars['LANG']['page_playlist_title']; ?>
</span></h2></div>
   <div class="clsPhotoListHeadingRight clsMyCategroySubscription">
	   <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
		   <?php if ($this->_tpl_vars['myobj']->getFormField('action') == ''): ?>
				<a href="<?php echo $this->_tpl_vars['myobj']->my_subscription_url; ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_tag_my_subscriptions']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_tag_my_subscriptions']; ?>
</a>
		   <?php else: ?>
		 		<a href="<?php echo $this->_tpl_vars['myobj']->getUrl('tags','?pg=photos','photos/','members','photo'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['common_tag_showall']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_tag_showall']; ?>
</a>
		   <?php endif; ?>
	   <?php endif; ?>
   </div>
  </div>
  <div class="clsTags clsOverflow"><?php if ($this->_tpl_vars['myobj']->tag_arr['resultFound']): ?>
		<?php $_from = $this->_tpl_vars['myobj']->tag_arr['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
         <div class="clsFloatLeft clsMarginRight10">
		  <div class="<?php echo $this->_tpl_vars['tag']['class']; ?>
" >

				<?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
					<?php if ($this->_tpl_vars['myobj']->getFormField('action') == 'mysubscriptions'): ?>
					  <a id="photo_tag_<?php echo $this->_tpl_vars['tag']['name']; ?>
" onmouseover="showDefaultSubscriptionOption('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Tag', 'pos_<?php echo $this->_tpl_vars['tag']['change_title_name']; ?>
');" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
 title="<?php echo $this->_tpl_vars['tag']['name']; ?>
"><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
					<?php else: ?>
					  <a href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
 <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?> onmouseover="showSubscriptionDetail('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
');" <?php endif; ?> title="<?php echo $this->_tpl_vars['tag']['name']; ?>
"><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
					 <?php endif; ?>
				<?php else: ?>
					<a href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
 title="<?php echo $this->_tpl_vars['tag']['name']; ?>
"><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
				<?php endif; ?>
				<span id="photoPopUp_"><!----></span>
			     <span id="pos_<?php echo $this->_tpl_vars['tag']['change_title_name']; ?>
"><!----></span>
			 </div>
          <?php if (chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
	      <div id="photoPopUp_<?php echo $this->_tpl_vars['tag']['name']; ?>
" style="visibility:hidden;" class="clsTagStyleIcon" <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?> onmouseover="showTagDetail('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
');" onmouseout="hideTagDetail('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
');" <?php endif; ?>>
			<span class="clsSubscribeIcon"></span>
                <div style="display:none" id="taglist_<?php echo $this->_tpl_vars['tag']['name']; ?>
">
          <div class="clsPopSubscriptionInfo">
            <div class="clsPopUpSubsDivContainerTags">
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfotag_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        	   <div class="clsPopUpPaddingContent clsOverflow">
        		<p class="clsPopUpSubsContent">
         		  <span><?php echo $this->_tpl_vars['LANG']['common_totalsubscriptions']; ?>
: </span>
        		  <span id="total_tag_sub_<?php echo $this->_tpl_vars['tag']['name']; ?>
">(<?php echo $this->_tpl_vars['myobj']->getTagSubscriptionCount($this->_tpl_vars['tag']['name'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
)</span>
        		</p>
                <p class="clsSubscriptionBtn">
                 <span id="subscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" style="display:<?php if (! $this->_tpl_vars['tag']['subscription']): ?> block; <?php else: ?> none; <?php endif; ?>"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
', 'Yes', 'photo', 'Tag');" title="<?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
</a></span>
                 <span id="unsubscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" style="display:<?php if ($this->_tpl_vars['tag']['subscription']): ?> block; <?php else: ?> none; <?php endif; ?>"><a href="javascript:void(0);" id="anchor_subscribe"  onclick="subscription_sep_action('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
', 'No', 'photo', 'Tag');" title="<?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
</a></span>
                </p>
        	  </div>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popinfotag_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
           </div>
         </div>
        </div>
				</div>

        <?php endif; ?>
        <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
          <?php if ($this->_tpl_vars['myobj']->getFormField('action') == 'mysubscriptions'): ?>
            <span id="subscription_<?php echo $this->_tpl_vars['tag']['name']; ?>
" style="display:none;">
              <span id="unsubscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
"><a href="javascript:void(0);" class="clsUnSubscribeIcon clsPhotoVideoEditLinks" id="anchor_subscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" onclick="subscription_sep_action('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
', 'No', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Tag');" title="<?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
</a></span>
              <span id="subscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" style="display:none"><a href="javascript:void(0);" class="clsSubscribeIcon clsPhotoVideoEditLinks" id="anchor_subscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" onclick="subscription_sep_action('<?php echo $this->_tpl_vars['tag']['add_slash_name']; ?>
', 'Yes', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Tag');" title="<?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
</a></span>
           </span>
         <?php endif; ?>
       <?php endif; ?>

         </div>
		<?php endforeach; endif; unset($_from); ?>
     <?php else: ?>
     	<div id="selMsgAlert">
		    <?php echo $this->_tpl_vars['LANG']['no_tags_found']; ?>

        </div>
	<?php endif; ?>
</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'photomain_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
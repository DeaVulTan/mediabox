<?php /* Smarty version 2.6.18, created on 2011-12-28 20:34:55
         compiled from tags.tpl */ ?>
<div id="selGroupCreate">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsOverflow">
    	<div class="clsVideoListHeading">
        	<h2><span><?php echo $this->_tpl_vars['myobj']->LANG['page_video_title']; ?>
</span></h2>
        </div>
       <div class="clsVideoListHeadingRight clsMyCategroySubscription">
           <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
            <?php if ($this->_tpl_vars['myobj']->getFormField('action') == ''): ?>
                <a href="<?php echo $this->_tpl_vars['myobj']->my_subscription_url; ?>
"><?php echo $this->_tpl_vars['LANG']['common_tag_my_subscriptions']; ?>
</a>
              <?php else: ?>
                <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('tags','?pg=videos','videos/','members','video'); ?>
"><?php echo $this->_tpl_vars['LANG']['common_tag_showall']; ?>
</a>      
              <?php endif; ?>
           <?php endif; ?>   
       </div>   
   </div>
		<div class="clsVideoTags clsOverflow">
		  <?php if ($this->_tpl_vars['myobj']->tag_arr['resultFound']): ?>
			<?php $_from = $this->_tpl_vars['myobj']->tag_arr['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
         <div class="clsFloatLeft clsMarginRight10">
				<div class="<?php echo $this->_tpl_vars['tag']['class']; ?>
">
						<?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
							  <?php if ($this->_tpl_vars['myobj']->getFormField('action') == 'mysubscriptions'): ?>
								<a id="video_tag_<?php echo $this->_tpl_vars['tag']['name']; ?>
" onmouseover="showDefaultSubscriptionOption('<?php echo $this->_tpl_vars['tag']['name']; ?>
', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Tag', 'pos_<?php echo $this->_tpl_vars['tag']['name']; ?>
');" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
							  <?php else: ?>
								<a id="video_tag_<?php echo $this->_tpl_vars['tag']['name']; ?>
" onmouseover="getSubscriptionOption('<?php echo $this->_tpl_vars['tag']['name']; ?>
', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Tag', 'pos_<?php echo $this->_tpl_vars['tag']['name']; ?>
');" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
							  <?php endif; ?>
                                    <?php else: ?>
                                    	<a href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" <?php echo $this->_tpl_vars['tag']['fontSizeClass']; ?>
><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
						<?php endif; ?>
							 
					  <?php if (chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
						<span title="<?php echo $this->_tpl_vars['LANG']['common_totalsubscriptions']; ?>
">(<?php echo $this->_tpl_vars['myobj']->getTagSubscriptionCount($this->_tpl_vars['tag']['name'],$this->_tpl_vars['CFG']['site']['is_module_page']); ?>
)</span>
					  <?php endif; ?>
					  <span id="pos_<?php echo $this->_tpl_vars['tag']['name']; ?>
"><!----></span>
				</div>
					  <?php if (isMember ( ) && chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
							<?php if ($this->_tpl_vars['myobj']->getFormField('action') == 'mysubscriptions'): ?>
								 <span id="subscription_<?php echo $this->_tpl_vars['tag']['name']; ?>
" style="display:none;">
									   <span id="unsubscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
"><a href="javascript:void(0);" class="clsUnSubscribeIcon" id="anchor_subscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" onclick="subscription_sep_action('<?php echo $this->_tpl_vars['tag']['name']; ?>
', 'No', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Tag');"><?php echo $this->_tpl_vars['LANG']['common_unsubscribe']; ?>
</a></span>
									   <span id="subscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" style="display:none"><a href="javascript:void(0);" class="clsSubscribeIcon" id="anchor_subscribe_<?php echo $this->_tpl_vars['tag']['name']; ?>
" onclick="subscription_sep_action('<?php echo $this->_tpl_vars['tag']['name']; ?>
', 'Yes', '<?php echo $this->_tpl_vars['CFG']['site']['is_module_page']; ?>
', 'Tag');"><?php echo $this->_tpl_vars['LANG']['common_subscribe']; ?>
</a></span>
								 </span>
						   <?php endif; ?>
					  <?php endif; ?>
		</div>
			<?php endforeach; endif; unset($_from); ?>
		 <?php else: ?>
			<?php echo $this->_tpl_vars['LANG']['no_tags_found']; ?>

		<?php endif; ?>
		  </div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
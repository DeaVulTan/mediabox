<?php /* Smarty version 2.6.18, created on 2011-10-25 11:50:33
         compiled from indexLatestFeatured.tpl */ ?>
<?php if ($this->_tpl_vars['featuredContentTotal'] > 1): ?>
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/lib/jQuery_plugins/anythingslider/slider.css" type="text/css" media="screen" />

	<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/lib/jQuery_plugins/anythingslider/jquery.anythingslider.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/lib/jQuery_plugins/anythingslider/jquery.easing.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
js/anythingslider_config.js"></script>
<?php endif; ?>
<!-- START AnythingSlider -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'slider_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['featuredContentTotal'] > 1): ?>
<div class="anythingSlider">
<?php else: ?>
<div class="anythingSlider clsIndexSingleSlide">
<?php endif; ?>
	<div class="wrapper">
		<ul>
			<?php $_from = $this->_tpl_vars['featuredContent']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['content']):
?>
				<li>
                <?php if (is_array ( $this->_tpl_vars['content']['sidebar_content'] )): ?>
                    <div class="clsSiteContent">
                <?php else: ?>
                    <div class="clsCustomContent">
                 <?php endif; ?>
					<h2><?php echo $this->_tpl_vars['content']['glider_title']; ?>
</h2>
					<div class="clsLatestFeatureContent">
						<div class="clsImage">
							<?php if ($this->_tpl_vars['content']['rollover_text']): ?>
						    	<div class="clsTransparent" id="<?php echo $this->_tpl_vars['content']['selRollover']; ?>
" >
						            <p class="<?php echo $this->_tpl_vars['content']['clsRollover']; ?>
"><?php echo $this->_tpl_vars['content']['rollover_text']; ?>
</p>
						        </div>
							<?php endif; ?>
					    	<div>
					    		<?php if ($this->_tpl_vars['content']['target_url']): ?>
					    			<a class="clsImageContainer clsImageBorder4 cls368x277" href="<?php echo $this->_tpl_vars['content']['target_url']; ?>
"><img src="<?php echo $this->_tpl_vars['content']['image_src']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(366,275,$this->_tpl_vars['content']['image_width'],$this->_tpl_vars['content']['image_height']); ?>
/></a>
					    		<?php else: ?>
					    			<div class="clsImageContainer clsImageBorder4 cls368x277"><img src="<?php echo $this->_tpl_vars['content']['image_src']; ?>
" /></div>
					    		<?php endif; ?>
					        </div>
					    </div>
					    <div class="clsDetails">
					        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

					        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'featuredetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					        	<div class="clsFeatureDetailsContainer">
					            	<div class="clsFeatureDetailsContent" id="<?php echo $this->_tpl_vars['content']['selIndexGliderSidebarContent']; ?>
">
					            		<?php if (is_array ( $this->_tpl_vars['content']['sidebar_content'] )): ?>
						                	<h3><?php echo $this->_tpl_vars['content']['sidebar_content']['title']; ?>
</h3>
						                	<?php if ($this->_tpl_vars['content']['sidebar_content']['description']): ?>
						                		<p>
													<?php echo $this->_tpl_vars['content']['sidebar_content']['description']; ?>

													<?php if (strlen ( $this->_tpl_vars['content']['sidebar_content']['description'] ) > 74): ?>
														<a href="<?php echo $this->_tpl_vars['content']['sidebar_content']['target_url']; ?>
">..<?php echo $this->_tpl_vars['LANG']['common_more']; ?>
</a>
													<?php endif; ?>
												</p>
						                    <?php endif; ?>
						                    <p class="clsUserName"><?php echo $this->_tpl_vars['LANG']['common_by']; ?>
 <a href="<?php echo $this->_tpl_vars['content']['sidebar_content']['user_url']; ?>
"><?php echo $this->_tpl_vars['content']['sidebar_content']['user_name']; ?>
</a></p>

						                    <div class="clsSeperator"><!-- seperator line --></div>

						                    <div class="clsViewDetails">
						                    	<?php if ($this->_tpl_vars['content']['sidebar_content']['duration']): ?>
													<p><span class="clsLeft"><?php echo $this->_tpl_vars['LANG']['common_duration']; ?>
</span><span class="clsRight"><?php echo $this->_tpl_vars['content']['sidebar_content']['duration']; ?>
</span></p>
						                    	<?php endif; ?>
						                    	<p><span class="clsLeft"><?php echo $this->_tpl_vars['LANG']['common_views']; ?>
</span><span class="clsRight"><?php echo $this->_tpl_vars['content']['sidebar_content']['total_views']; ?>
</span></p>
						                    	<p><span class="clsLeft"><?php echo $this->_tpl_vars['LANG']['common_comments']; ?>
</span><span class="clsRight"><?php echo $this->_tpl_vars['content']['sidebar_content']['total_comments']; ?>
</span></p>
						                    </div>

						                    <div class="clsFeatureRating">
								            								                	<?php if ($this->_tpl_vars['myobj']->chkAllowRating($this->_tpl_vars['content']['media_type'],$this->_tpl_vars['content']['media_id'])): ?>
							                        <?php echo $this->_tpl_vars['myobj']->populateStaticRatingImages($this->_tpl_vars['content']['sidebar_content']['total_ratings'],$this->_tpl_vars['content']['media_type']); ?>

							                  	<?php endif; ?>
								                						                    	<span>(<?php echo $this->_tpl_vars['content']['sidebar_content']['total_ratings']; ?>
 <?php echo $this->_tpl_vars['content']['sidebar_content']['ratings_text']; ?>
)</span>
						                    </div>

						                    <div class="clsSeperator"><!-- seperator line --></div>

						                    <div class="clsWatchMore">
						                    	<a href="<?php echo $this->_tpl_vars['content']['target_url']; ?>
"><?php echo $this->_tpl_vars['content']['sidebar_content']['view_content_text']; ?>
</a>
						                    </div>
					            		<?php else: ?>
					            			<?php echo $this->_tpl_vars['content']['sidebar_content']; ?>

					            		<?php endif; ?>
					                </div>
					            </div>
					        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'featuredetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					    </div>
					</div>
				</div>
        		<?php if (! is_array ( $this->_tpl_vars['content']['sidebar_content'] )): ?>
        			<?php echo '
        				<script language="javascript" type="text/javascript">
        					$Jq('; ?>
"#<?php echo $this->_tpl_vars['content']['selIndexGliderSidebarContent']; ?>
"<?php echo ').jScrollPane({showArrows: true, scrollbarWidth: 10, scrollbarMargin: 10});
        				</script>
        			'; ?>

        		<?php endif; ?>
				</li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
</div> <!-- END AnythingSlider -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'slider_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php /* Smarty version 2.6.18, created on 2011-10-18 17:31:50
         compiled from populateFeaturedPhotoBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'populateFeaturedPhotoBlock.tpl', 23, false),)), $this); ?>
<?php if ($this->_tpl_vars['featured_record_count']): ?>
<div class="clsIndexPlayerContainer">
	<div class="clsIndexPlayerHeading">
        <h2 id="selSlideHead"></span></h2>
    </div>
    <div class="clsIndexPlayerContent clsOverflow">
    	<div class="clsIndexPlayer">
			<div id="gallery" class="content">
				<div class="slideshow-container">
					<div id="slideshow" class="slideshow"></div>
				</div>
			</div>
		</div>
		<div class="clsIndexPlayerDetailsContent">
			<div class="clsindexPlayerDetails">
				<div id="caption" class="caption-container"></div>
			</div>
			<div id="thumbs" class="navigation clsIndexPlayerImageContainer">
				<ul class="thumbs noscript">
        			<?php $_from = $this->_tpl_vars['populate_featured_photo_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genresKey'] => $this->_tpl_vars['photoValue']):
?>
            		<li class="clsActive">
            			<a href="#" id="thumbshash<?php echo $this->_tpl_vars['genresKey']; ?>
"></a>
                		<a class="thumb cls81x59 clsImageHolder ClsImageBorder3" href="<?php echo $this->_tpl_vars['photoValue']['photo_image_src_medium']; ?>
"><img src="<?php echo $this->_tpl_vars['photoValue']['photo_image_src_small']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photoTitle'])) ? $this->_run_mod_handler('truncate', true, $_tmp, $this->_tpl_vars['CFG']['admin']['photos']['photo_index_featured_title_length'], '..', true, true) : smarty_modifier_truncate($_tmp, $this->_tpl_vars['CFG']['admin']['photos']['photo_index_featured_title_length'], '..', true, true)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['photoValue']['photoTitle'])) ? $this->_run_mod_handler('truncate', true, $_tmp, $this->_tpl_vars['CFG']['admin']['photos']['photo_index_featured_title_length'], '..', true, true) : smarty_modifier_truncate($_tmp, $this->_tpl_vars['CFG']['admin']['photos']['photo_index_featured_title_length'], '..', true, true)); ?>
" imgattr='<?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(375,281,$this->_tpl_vars['photoValue']['record']['m_width'],$this->_tpl_vars['photoValue']['record']['m_height']); ?>
' slidehead="<?php echo $this->_tpl_vars['photoValue']['photo_slide_head']; ?>
" viewurl="<?php echo $this->_tpl_vars['photoValue']['photo_url']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(81,59,$this->_tpl_vars['photoValue']['record']['s_width'],$this->_tpl_vars['photoValue']['record']['s_height']); ?>
 /></a>
                		<div class="caption">
                			<div class="clsIndexPlayerDet">
			                	<div class="clsIndexPlayerInfo">
			                		<p class="clsIndexDes"><?php if ($this->_tpl_vars['photoValue']['photoCaption']): ?><?php echo $this->_tpl_vars['photoValue']['photoCaption']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['photo_no_description']; ?>
<?php endif; ?></p>
                                    
			                	</div>
	                        	<div class="clsIndexPlayerAddedby">
	                            	<p class="clsAddedUser">by <a class="clsUserNames" href="<?php echo $this->_tpl_vars['photoValue']['user_details']['profile_url']; ?>
"><?php echo $this->_tpl_vars['photoValue']['user_details']['display_name']; ?>
</a></p>
                                    <p><?php echo $this->_tpl_vars['photoValue']['record']['p_date_added']; ?>
</p>
	                        	</div>
		                	</div>
		                    	<div class="clsIndexPlayerCounts">
		                        	<div class="clsIndexPlayerViews"><p><?php echo $this->_tpl_vars['LANG']['index_views_label']; ?>
: <span class="clsViewCount"><?php echo $this->_tpl_vars['photoValue']['record']['total_views']; ?>
</span> <?php echo $this->_tpl_vars['LANG']['index_comments_label']; ?>
: <span><?php echo $this->_tpl_vars['photoValue']['record']['total_comments']; ?>
</span></p></div>
		                        	<div class="clsIndexPlayerRating clsOverflow">
                                    <p class="clsFloatLeft"><?php echo $this->_tpl_vars['LANG']['index_rating_label']; ?>
:<?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['photoValue']['record']['rating'],'','','','photo'); ?>
(<?php echo $this->_tpl_vars['photoValue']['record']['rating']; ?>
)</p>
                                    <p class="clsIndexMore clsOverflow clsFloatRight"><a href="<?php echo $this->_tpl_vars['photoValue']['photo_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['index_photo_view_label']; ?>
</a></p>
                                    </div>
		                    	</div>
						</div>
               		</li>
               		<?php endforeach; endif; unset($_from); ?>
            	</ul>
			</div>
			<?php echo '
				<script language="javascript">
					$Jq(\'#thumbs\').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
				</script>
			'; ?>

		</div>
	</div>
</div>
<?php endif; ?>
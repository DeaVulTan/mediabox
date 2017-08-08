<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileFeaturedmediaBlock.tpl */ ?>
<?php if (( chkAllowedModule ( array ( 'photo' ) ) ) || ( chkAllowedModule ( array ( 'music' ) ) ) || ( chkAllowedModule ( array ( 'video' ) ) )): ?>
<div class="clsFeaturedInformation clsFeaturedmediaTable">
 	<div class="clsIndexOtherBlocksContainer">
   		<div class="clsJQCarousel" id="recentFeaturedTabs">
		  <table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
>
				<tr>
				  <th <?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
> 
					  <ul class="clsJQCarouselFeaturedTabs clsOverflow clsOtherTabs">
						  <?php if (chkAllowedModule ( array ( 'photo' ) )): ?>
							  <li><a href="#idFeaturedPhotoContent"><?php echo $this->_tpl_vars['LANG']['myprofile_featured_photo']; ?>
</a></li>
						   <?php endif; ?>
						   <?php if (chkAllowedModule ( array ( 'music' ) )): ?>
							  <li><a href="#idFeaturedMusicContent"><?php echo $this->_tpl_vars['LANG']['myprofile_featured_music']; ?>
</a></li>
						   <?php endif; ?>
						  <?php if (chkAllowedModule ( array ( 'video' ) )): ?>              
							  <li><a href="#idFeaturedVideoContent"><?php echo $this->_tpl_vars['LANG']['myprofile_featured_video']; ?>
</a></li>
						  <?php endif; ?>
						</ul>
				   </th>
				</tr>
				<tr> 
				<td>						
					  <div id="idFeaturedPhotoContent">
							<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "profileMyfeaturedphotoBlock.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
					  </div> 
					  <div id="idFeaturedMusicContent">
							<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "profileFeaturedmusicBlock.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					  </div>
					  <div id="idFeaturedVideoContent">
							<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

							<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "profileFeaturedvideoBlock.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>           
					  </div>
			    </td>
    		</tr>
  		</table>
      </div>
	</div>
</div>
<script type="text/javascript">
	<?php echo '
	$Jq(window).load(function(){
		attachJqueryTabs(\'recentFeaturedTabs\');
	});
	'; ?>

</script>
<?php endif; ?>
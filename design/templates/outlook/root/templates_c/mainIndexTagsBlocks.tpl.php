<?php /* Smarty version 2.6.18, created on 2012-01-26 00:17:50
         compiled from mainIndexTagsBlocks.tpl */ ?>
 <?php if (chkAllowedModule ( array ( 'music' ) ) || chkAllowedModule ( array ( 'video' ) ) || chkAllowedModule ( array ( 'photo' ) )): ?>
	    

        <div class="clsTagsRightTab" id="cloudTabs">
            <div class="clsTagsHeading clsOverflow">
				<div class="clsTagsLeftHead">
					<h3>Теги</h3>
				</div>        
   	  		 </div>
            <ul class="clsOverflow">
            <?php if (chkAllowedModule ( array ( 'music' ) )): ?>
                <li><a href="index.php?cloud_tab=music"><?php echo $this->_tpl_vars['LANG']['myhome_cloud_music']; ?>
</a></li>
            <?php endif; ?>
            <?php if (chkAllowedModule ( array ( 'photo' ) )): ?>    
                <li><a href="index.php?cloud_tab=photo"><?php echo $this->_tpl_vars['LANG']['myhome_cloud_photo']; ?>
</a></li>
            <?php endif; ?>
            <?php if (chkAllowedModule ( array ( 'video' ) )): ?>
                <li><a href="index.php?cloud_tab=video"><?php echo $this->_tpl_vars['LANG']['myhome_cloud_video']; ?>
</a></li>
            <?php endif; ?>   
            </ul>
       </div>
        <script type="text/javascript">
			<?php echo '
			 	$Jq(window).load(function(){
					attachJqueryTabs(\'cloudTabs\');
				});
			'; ?>

        </script>
        <?php endif; ?>
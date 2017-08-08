<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileRecentblogarticleforumBlock.tpl */ ?>
<?php if (( chkAllowedModule ( array ( 'discussions' ) ) ) || ( chkAllowedModule ( array ( 'blog' ) ) ) || ( chkAllowedModule ( array ( 'article' ) ) )): ?>
<div class="clsSubscribersInformation clsRecentblogarticleforumTable">
	<div class="clsIndexOtherBlocksContainer">
    	<div class="clsJQCarousel" id="recentListTabs">
		  <table <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
>
			<tr>
			  <th <?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
> 
				 <ul class="clsJQCarouselInfoTabs clsOverflow clsOtherTabs">
					  <?php if (chkAllowedModule ( array ( 'discussions' ) )): ?>
					  <li><a href="#idDiscussionContent"><?php echo $this->_tpl_vars['LANG']['common_boards']; ?>
</a></li>
					  <?php endif; ?>
					  <?php if (chkAllowedModule ( array ( 'blog' ) )): ?>
					  <li><a href="#idBlogContent"><?php echo $this->_tpl_vars['LANG']['common_blogs']; ?>
</a></li>
					  <?php endif; ?>
					  <?php if (chkAllowedModule ( array ( 'article' ) )): ?>              
					  <li><a href="#idArticleContent"><?php echo $this->_tpl_vars['LANG']['common_article']; ?>
</a></li>
					  <?php endif; ?>
					</ul>
			  </th>
		   </tr>
	       <tr>  
              <td>            
				  <div id="idDiscussionContent">
						<?php echo $this->_tpl_vars['myobj']->populateRecent('recentboard'); ?>
    
				  </div> 
				  <div id="idBlogContent">
					<?php echo $this->_tpl_vars['myobj']->populateRecent('recentblog'); ?>
    
				  </div>
				  <div id="idArticleContent">
					<?php echo $this->_tpl_vars['myobj']->populateRecent('recentarticle'); ?>
           
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
		attachJqueryTabs(\'recentListTabs\');
	});
	'; ?>

</script>
<?php endif; ?>
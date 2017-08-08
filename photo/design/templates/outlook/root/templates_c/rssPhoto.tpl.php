<?php /* Smarty version 2.6.18, created on 2012-02-02 13:45:19
         compiled from rssPhoto.tpl */ ?>
<div id="selRss" class="clsOverflow">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	<div class="clsPageHeading">
    	<h2><?php echo $this->_tpl_vars['LANG']['page_title']; ?>
</h2>
    </div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('rssListBlock')): ?>		
		<div class="clsDataTable clsMembersBrowseTable">		
		  <p class="clsMemberDetailsTitle"><?php echo $this->_tpl_vars['LANG']['photo']; ?>
</p>
           <div class="clsBrowseMembersDetails">
            <table summary="<?php echo $this->_tpl_vars['LANG']['tbl_summary']; ?>
">
			<tr>
				<td class="clsSelectSmall"><?php echo $this->_tpl_vars['LANG']['recently_added']; ?>
</td>
				<td class="clsRssSmall"><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('recentlyAdded'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>	
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('recentlyAdded'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('recentlyAdded'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('recentlyAdded'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['top_favorites']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('topFavorites'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('topFavorites'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('topFavorites'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('topFavorites'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['top_rated']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('topRated'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('topRated'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('topRated'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('topRated'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
			</tr>
		</table>
           </div>
         </div>  
		<div class="clsDataTable clsMembersBrowseTable">
         <p class="clsMemberDetailsTitle"><?php echo $this->_tpl_vars['LANG']['most_viewed_photos']; ?>
</p>
          <div class="clsBrowseMembersDetails">
           <table summary="<?php echo $this->_tpl_vars['LANG']['tbl_summary']; ?>
">
			<tr>
				<td class="clsSelectSmall"><?php echo $this->_tpl_vars['LANG']['today']; ?>
</td>
				<td class="clsRssSmall"><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('todayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('todayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('todayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>			
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('todayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>                
                </tr>
			<tr>
			  <td><?php echo $this->_tpl_vars['LANG']['yesterday']; ?>
</td>
              
			  <td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('yesterdayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
              <?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
			  <td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('yesterdayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
              <?php endif; ?>
              <?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
			 <td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('yesterdayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
              <?php endif; ?>
              <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('yesterdayMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
		  </tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['this_week']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('thisWeekMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('thisWeekMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('thisWeekMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>			
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('thisWeekMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
                
                </tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['this_month']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('thisMonthMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('thisMonthMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('thisMonthMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>			
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('thisMonthMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
                </tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['this_year']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('thisYearMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('thisYearMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('thisYearMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>			
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('thisYearMostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
                </tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['all_time']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('mostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('mostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('mostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>	
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('mostViewed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
                		</tr>
		</table>
          </div>
        </div>
		<div class="clsDataTable clsMembersBrowseTable">
		 <p class="clsMemberDetailsTitle"><?php echo $this->_tpl_vars['LANG']['most_discussed_photos']; ?>
</p>
          <div class="clsBrowseMembersDetails">
           <table summary="<?php echo $this->_tpl_vars['LANG']['tbl_summary']; ?>
">
			<tr>
				<td class="clsSelectSmall"><?php echo $this->_tpl_vars['LANG']['today']; ?>
</td>
				<td class="clsRssSmall"><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('todayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('todayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('todayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>	                
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('todayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
                		</tr>
			<tr>
			  <td><?php echo $this->_tpl_vars['LANG']['yesterday']; ?>
</td>
			 <td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('yesterdayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
			 <?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('yesterdayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
			 <?php endif; ?>
             <?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
				 <td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('yesterdayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
             <?php endif; ?>
               <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('yesterdayMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
		  </tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['this_week']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('thisWeekMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('thisWeekMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('thisWeekMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>		
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('thisWeekMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
                	</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['this_month']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('thisMonthMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('thisMonthMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('thisMonthMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>	
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('thisMonthMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>		</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['this_year']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('thisYearMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('thisYearMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('thisYearMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>	
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('thisYearMostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
                		</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['LANG']['all_time']; ?>
</td>
				<td><a href="<?php echo $this->_tpl_vars['myobj']->getRssUrl('mostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/rss.gif" /></a></td>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['yahoo']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getYahooLink('mostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/yahoo.gif" /></a></td>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['CFG']['rss_display']['gmail']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getGoogleLink('mostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/google.gif" /></a></td>
				<?php endif; ?>	
                <?php if ($this->_tpl_vars['CFG']['rss_display']['itunes']): ?>
					<td><a href="<?php echo $this->_tpl_vars['myobj']->getItunesLink('mostDiscussed'); ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/button_itunes.gif" /></a></td>
				<?php endif; ?>
            </tr>
		</table>
  		  </div>
        </div>  
	<?php endif; ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
</div>	
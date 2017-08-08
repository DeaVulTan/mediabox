<?php /* Smarty version 2.6.18, created on 2011-10-17 15:12:54
         compiled from indexVideoBlock.tpl */ ?>
<?php if (chkAllowedModule ( array ( 'video' ) )): ?>
	<?php if ($this->_tpl_vars['CFG']['admin']['videos']['recentlyviewedvideo'] || $this->_tpl_vars['CFG']['admin']['videos']['recommendedvideo'] || $this->_tpl_vars['CFG']['admin']['videos']['newvideo'] || $this->_tpl_vars['CFG']['admin']['videos']['topratedvideo']): ?>
		   <script language="javascript" type="text/javascript">
			var module_name_js="video";
			</script>
         <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

         <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videos_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		 <div class="clsOverflow">
           <div class="clsFloatLeft">
                    <div class="clsVideoBlockTitleLeft"><h2 class="clsSideHeading clsTitleVideo"><?php echo $this->_tpl_vars['LANG']['index_page_videos']; ?>
</h2><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/foxLoader.gif" alt="" title="" id="loaderVideos" style="display:none" /> </div>
                </div>

<?php $this->assign('music_limit_per_page', 4); ?>
<div class="clsIndexAudioContainer">
 <div class="clsJQCarousel" id="musicListTabs">
    <ul class="clsJQCarouselTabs clsOverflow">
        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['newvideo']): ?>
        <li id="li_newvideo_Head" ><a href="indexVideoBlock.php?showtab=newvideo&limit=<?php echo $this->_tpl_vars['music_limit_per_page']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['index_page_random_videos_new_videos']; ?>
</span></a></li>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['CFG']['admin']['videos']['topratedvideo']): ?>
        <li id="li_topratedvideo_Head" ><a href="indexVideoBlock.php?showtab=topratedvideo&limit=<?php echo $this->_tpl_vars['music_limit_per_page']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['index_page_videos_top_rated_videos']; ?>
</span></a></li>
        <?php endif; ?>
    </ul>
</div>
</div>
</div>

<?php if (! isAjaxPage ( )): ?>
<div class="clsVideoIndexVideoBlock">
<?php endif; ?>
<div class="clsIndexVideoContainer">
       <div class="clsVideoPopUpClear" style="width:150px;"></div>
        </div>
 		 <?php if (! isAjaxPage ( )): ?>
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

        	 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videos_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
             </div>
         <?php endif; ?>
	  <?php endif; ?> <?php endif; ?>
<?php $this->assign('channel_limit_per_page', 3); ?>
	 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videos_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="clsVideoCarouselCategory">
<div class="clsIndexVideoContent">
<h2 class="clsSideHeading clsTitleVideo clsFloatLeft"><?php echo $this->_tpl_vars['LANG']['index_page_video_channels_title']; ?>
</h2>
 <div class="clsJQCarousel" id="channelListTabs">
    <ul class="clsJQCarouselTabs clsOverflow">
		<li id="li_recentlyviewedvideo"><a href="indexVideoBlock.php?show_catgeroy=video_category&video_limit=<?php echo $this->_tpl_vars['channel_limit_per_page']; ?>
"><!----></a></li>
    </ul>
</div>
</div>
</div>

 <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'videos_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
	var music_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
indexVideoBlock.php';

	<?php echo '
	function videocarousel_itemLoadCallback(carousel, state)
	{
		var block = carousel.blockName();
		//var block = carousel.options.block;
		var i = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(i)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start: i,
				limit: '; ?>
<?php echo $this->_tpl_vars['music_limit_per_page']; ?>
<?php echo ',
				block: block
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(i, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs(\'musicListTabs\');
	});
	'; ?>

</script>


<script type="text/javascript">
	var music_index_ajax_url = '<?php echo $this->_tpl_vars['CFG']['site']['video_url']; ?>
indexVideoBlock.php';

	<?php echo '
	function videoChannelCarousel_ItemLoadCallback(carousel, state)
	{

		var block_video = carousel.options.block_video;

		//var block = carousel.options.block;
		var video_item = carousel.first;

		// need not call ajax again if the carousel page is already fetched
        if (carousel.has(video_item)) {
            return;
        }

		jQuery.get(
			music_index_ajax_url,
			{
				start_video: video_item,
				video_limit: 3,
				block_video: block_video
			},
			function(data) {
				//add the returned response from the ajax call as the item
				carousel.add(video_item, data);
			}
		);
	};

	$Jq(window).load(function(){
		attachJqueryTabs(\'channelListTabs\');
	});
	'; ?>

</script>

	<div class="cls468pxBanner">
		<div><?php global $CFG; getAdvertisement('bottom_banner_468x60') ?></div>
	</div>
	
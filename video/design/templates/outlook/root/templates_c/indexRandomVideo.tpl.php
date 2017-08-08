<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:22
         compiled from indexRandomVideo.tpl */ ?>
<?php if ($this->_tpl_vars['videoIndexObj']->getrandomVideo_arr): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'featuredvideo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsVideoPlayerContainer">
<h2><?php echo $this->_tpl_vars['LANG']['index_title_featured_videos']; ?>
 - <span id="random_title" title="<?php echo $this->_tpl_vars['videoIndexObj']->randFirstTitle; ?>
"><?php echo $this->_tpl_vars['videoIndexObj']->randFirstTitle; ?>
</span></h2>
<table>
	<tr>
    	<td class="clsVideoPlayer" id="clsVideoPlayer">
              <?php echo $this->_tpl_vars['videoIndexObj']->populateFeaturedVideoPlayers($this->_tpl_vars['videoIndexObj']->getFormField('video_id')); ?>

        </td>
    	<td class="clsVideoPlayerInfo">
		<div class="clsIndexPlayerContent">
			<p class="clsUserSummaryIndex"><span id="video_caption"><?php echo $this->_tpl_vars['videoIndexObj']->randVideoCaption; ?>
</span></p>
			<div id="video_url_link" class="clsFloatRight"><a href="<?php echo $this->_tpl_vars['videoIndexObj']->videoUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['video_index_page_featured_view_more_link']; ?>
</a></div>
			<div class="clsUserNamePosted"><?php echo $this->_tpl_vars['LANG']['video_index_random_video_block_added_by_lbl']; ?>
 <span id="user_name"><a href="<?php echo $this->_tpl_vars['videoIndexObj']->randUserNameLink; ?>
" title="<?php echo $this->_tpl_vars['videoIndexObj']->randUserName; ?>
"><?php echo $this->_tpl_vars['videoIndexObj']->randUserName; ?>
</a></span><span class="clsBlackColorStrip">|</span><span class="clsFeaturedMinutes"></span><span id="date_added"><?php echo $this->_tpl_vars['videoIndexObj']->randVideoAdded; ?>
</span></div>
		</div>
		<div class="clsIndexPlayerViews">
			<table>
				<tr>
				    <td class="clsWidthTd"><?php echo $this->_tpl_vars['LANG']['video_index_random_video_block_view_lbl']; ?>
: <span id="views"><?php echo $this->_tpl_vars['videoIndexObj']->randVideoTotalViews; ?>
</span></td>
					<td><?php echo $this->_tpl_vars['LANG']['video_index_random_video_block_comments_lbl']; ?>
: <span id="total_comments"><?php echo $this->_tpl_vars['videoIndexObj']->randVideoTotalComments; ?>
</span></td>
					<td class="clsIndexPlayerRating"><?php echo $this->_tpl_vars['LANG']['video_index_random_video_block_rating_lbl']; ?>
: <span id="rating_image"><?php echo $this->_tpl_vars['videoIndexObj']->populateRatingImages($this->_tpl_vars['videoIndexObj']->randVideoRating,'video','','','video'); ?>
</span>
					(<span id="rating"><?php echo $this->_tpl_vars['videoIndexObj']->randVideoRating; ?>
</span>)</td>

				</tr>
			</table>
		</div>
		<h3 class="clsFeaturedViewMore"><?php echo $this->_tpl_vars['LANG']['video_index_random_video_block_more_videos_lbl']; ?>
</h3>
        <div class="clsListedFeaturedVideo">
        <?php $_from = $this->_tpl_vars['videoIndexObj']->getrandomVideo_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        	<div id="featured_video_info_<?php echo $this->_tpl_vars['inc']; ?>
" class="clsFeaturedVideoInfo<?php if ($this->_tpl_vars['inc'] == 0): ?> clsActiveFeaturedVideoInfo<?php endif; ?>">
            	<div class="">
						<a class="Cls93x70 ClsImageContainer ClsImageBorder5" onClick="toggleFeaturedListClass(<?php echo $this->_tpl_vars['inc']; ?>
);playThisVideo('<?php echo $this->_tpl_vars['value']['member_profile_url']; ?>
','<?php echo $this->_tpl_vars['value']['video_url']; ?>
','<?php echo $this->_tpl_vars['value']['record']['video_id']; ?>
','<?php echo $this->_tpl_vars['value']['video_title_full']; ?>
','<?php echo $this->_tpl_vars['value']['video_date_added']; ?>
','<?php echo $this->_tpl_vars['value']['rating']; ?>
','<?php echo $this->_tpl_vars['value']['total_views']; ?>
','<?php echo $this->_tpl_vars['value']['total_comments']; ?>
','<?php echo $this->_tpl_vars['value']['user_name']; ?>
');getMoreInfoBlockList('<?php echo $this->_tpl_vars['value']['video_caption']; ?>
','<?php echo $this->_tpl_vars['value']['record']['video_id']; ?>
');">
					  <img src="<?php echo $this->_tpl_vars['value']['image_url']; ?>
" width="93px" height="70px" />
					  </a> </div>
					  <div class="clsTime"><?php echo $this->_tpl_vars['value']['playing_time']; ?>
</div>

            </div>
        <?php endforeach; endif; unset($_from); ?>
        </div>
        </td>
    </tr>
</table>
      </div>

  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'featuredvideo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php echo '
<script type="text/javascript">
var total_featured_vidoes_list = '; ?>
<?php echo $this->_tpl_vars['inc']; ?>
<?php echo ';
function toggleFeaturedListClass(inc)
    {
          $Jq("#featured_video_info_"+inc).addClass("clsActiveFeaturedVideoInfo");

          for(var i=0;i<=total_featured_vidoes_list;i++)
                {
                      if(i != inc)
                            $Jq("#featured_video_info_"+i).removeClass("clsActiveFeaturedVideoInfo");
                }
    }
</script>
      '; ?>

<?php endif; ?>


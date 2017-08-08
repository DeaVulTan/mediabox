<?php /* Smarty version 2.6.18, created on 2011-10-18 15:30:22
         compiled from videoListIndexBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'videoListIndexBlock.tpl', 80, false),)), $this); ?>
<div class="clsInfoPopUpContainerDiv clsDisplayNone"  onmouseover="hideCurrentToolTip()">
</div>
<div class="clsInfoPopUp clsDisplayNone"  style="position:absolute;z-index:100000">

</div>
<?php if (! isAjaxPage ( )): ?>
	<div id="selProcess"></div>
    <p class="clsPageNo" id="selPageNo"></p>
                	<div  style="position:relative;margin-left:7px; width:645px;height:px;overflow-x:hidden;">
		<div class="clsVideoListCount" style="position:absolute;left:0px;top:0px;">
<?php endif; ?>
<?php if ($this->_tpl_vars['video_block_record_count']): ?>
<div class="ClsMusicListCarouselContainer">
    <div class="ClsMusicListCarousel">
<table class="clsCarouselList">

		<?php $this->assign('row_count', 4); ?>
	<?php $this->assign('break_count', 1); ?>
	<?php $_from = $this->_tpl_vars['populateCarousalVideoBlock_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
    <?php if ($this->_tpl_vars['break_count'] == 1): ?>
    <tr>
    <?php endif; ?>
    <td >

    <ul class="cls141x106PXThumbImage">
          <li id="videolist_videoli_<?php echo $this->_tpl_vars['block_type']; ?>
<?php echo $this->_tpl_vars['record_count']; ?>
<?php echo $this->_tpl_vars['inc']; ?>
" class="clsVideoListDisplayVideos">
     <div class="clsIndexVideoContent">
            <div class="clsListVideoThumbImage" id="videolist_video_thumb_image_<?php echo $this->_tpl_vars['block_type']; ?>
<?php echo $this->_tpl_vars['record_count']; ?>
<?php echo $this->_tpl_vars['inc']; ?>
" >
                <div class="clsListThumbImageContainer" id="videolist_thumb_image_container_<?php echo $this->_tpl_vars['block_type']; ?>
<?php echo $this->_tpl_vars['record_count']; ?>
<?php echo $this->_tpl_vars['inc']; ?>
">
                    <div class="clsThumbImageContainer">
                        <div>
                            <div onclick="Redirect2URL('<?php echo $this->_tpl_vars['value']['video_url']; ?>
')" class="clsPointer">
                                <span class="clsRunTime"><?php echo $this->_tpl_vars['value']['playing_time']; ?>
</span>
                                <div id="videolist_thumb_<?php echo $this->_tpl_vars['block_type']; ?>
<?php echo $this->_tpl_vars['record_count']; ?>
<?php echo $this->_tpl_vars['inc']; ?>
" class="Cls142x108 ClsImageBorder1 ClsImageContainer" <?php echo $this->_tpl_vars['value']['div_onmouseOverText']; ?>
 >
                                          <img src="<?php echo $this->_tpl_vars['value']['image_url']; ?>
" <?php echo $this->_tpl_vars['value']['div_onmouseOverText']; ?>
 <?php echo $this->_tpl_vars['videoIndexObj']->DISP_IMAGE(142,108,$this->_tpl_vars['value']['record']['t_width'],$this->_tpl_vars['value']['record']['t_height']); ?>
 />

                                </div>
                             </div>
                        </div>
                        <a href="javascript:void(0)" class="clsInfo clsDisplayNone" id="videolist_info_<?php echo $this->_tpl_vars['block_type']; ?>
<?php echo $this->_tpl_vars['record_count']; ?>
<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="show_thumb=true;this.className='clsDisplayNone';showVideoDetail(this)" title="<?php echo $this->_tpl_vars['value']['user_name']; ?>
"></a>
                        <!--<a href="javascript:void(0)" class="clsInfo_home clsDisplayNone"  onmouseover="show_thumb=true;this.className='clsDisplayNone';showVideoDetail(this)"></a> -->
                    </div>
                </div>

                    <div class="clsVideoDetailsInfo" id="videolist_selVideoDetails_<?php echo $this->_tpl_vars['block_type']; ?>
<?php echo $this->_tpl_vars['record_count']; ?>
<?php echo $this->_tpl_vars['inc']; ?>
" onmouseover="show_thumb=true;showVideoDetail(this)" onmouseout="show_thumb=false;hideVideoDetail(this)">
                        <div class="clsVideoDetailsInfoCont">
                           <div class=" clsVideoBackgroundInfo">
                        <a href="javascript:void(0)" id="clsInfo" class="clsInfo_inside" style="display:none"></a>
                       <div>
 
                      <p><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['value']['total_views']; ?>
</span></p>
                      <p><?php echo $this->_tpl_vars['LANG']['index_added']; ?>
:&nbsp;<span><?php echo $this->_tpl_vars['value']['video_date_added']; ?>
</span></p>
                       <p><?php echo $this->_tpl_vars['videoIndexObj']->populateRatingImages($this->_tpl_vars['value']['rating'],'video'); ?>
</p>                
                   </div>
              </div>
            </div>
			</div>
			</div>
            <div class="clsThumbImageTitle" >
                <pre><a href="<?php echo $this->_tpl_vars['value']['video_url']; ?>
" title="<?php echo $this->_tpl_vars['value']['record']['video_title']; ?>
"><?php echo $this->_tpl_vars['value']['record']['video_title']; ?>
</a></pre>
				<p class="clsUserNameDetails"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
:&nbsp;<a href="<?php echo $this->_tpl_vars['value']['user_url']; ?>
" title="<?php echo $this->_tpl_vars['value']['user_name']; ?>
"><?php echo $this->_tpl_vars['value']['user_name']; ?>
</a></p>
            </div>
			</div>
               </li>
           </ul>
    </td>
    <?php $this->assign('break_count', $this->_tpl_vars['break_count']+1); ?>
    <?php if ($this->_tpl_vars['break_count'] > $this->_tpl_vars['row_count']): ?>
    </tr>
    <?php $this->assign('break_count', 1); ?>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <?php if ($this->_tpl_vars['break_count'] != 1): ?>
        <td colspan="<?php echo smarty_function_math(array('equation' => "(".($this->_tpl_vars['row_count'])."+1)-".($this->_tpl_vars['break_count'])), $this);?>
">&nbsp;</td>
    </tr>
    <?php endif; ?>
  </table>
    </div>

</div>
<?php endif; ?>
<?php if (! isAjaxPage ( )): ?>
</div>
</div>
<?php endif; ?>
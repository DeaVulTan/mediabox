<?php /* Smarty version 2.6.18, created on 2012-01-05 22:17:23
         compiled from quickLinks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'quickLinks.tpl', 38, false),)), $this); ?>
<?php if (! isAjaxpage ( ) || $this->_tpl_vars['myobj']->showRoundedCorner): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['quickLink_arr']['display']): ?>

    <?php if (! $this->_tpl_vars['quickLink_arr']['video_id']): ?>
        <div class="clsQuickLinks">
            <h3 class="clsQuickListTitle"><?php echo $this->_tpl_vars['LANG']['view_video_quick_links_title']; ?>
</h3>
            <div id="selVideoQuickListDispManage">
                    <div class="clsOverflow clsPlayIconContainer">
                            <input type="checkbox" onclick="toggleOnViewClearQuickList(this);" name="clear_quick_list" id="clear_quick_list" value="1" <?php echo $this->_tpl_vars['myobj']->quickListChecked; ?>
 />
                            <label for="clear_quick_list"><?php echo $this->_tpl_vars['LANG']['clear_quick_list_msg']; ?>
</label>
                    </div>
                    <div class="clsVideoManageLinks clsOverflow">
                    	<div class="clsVideoManageLinksLeft">
                            <span class="clsPlayAllVideo"><?php echo $this->_tpl_vars['myobj']->getNextPlayListQuickLinks($this->_tpl_vars['quickLink_arr']['in_str'],true); ?>
</span>
                            <span class="clsPlayNextVideo"><?php echo $this->_tpl_vars['myobj']->getNextPlayListQuickLinks($this->_tpl_vars['quickLink_arr']['in_str']); ?>
</span>
                        </div>
                        <div class="clsVideoManageLinksRight">
                            <div class="clsManageLinksContainer">
                            	<a class="clsManage clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_manage']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->dashboardUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['view_video_quick_list_manage']; ?>
</a>
                              <a class="clsSave clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_save']; ?>
" href="<?php echo $this->_tpl_vars['myobj']->managePlaylistUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['view_video_quick_list_save']; ?>
</a>
                              <a class="clsClear clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['viewvideo_clear']; ?>
" onClick="clearQuickLinks()"><?php echo $this->_tpl_vars['LANG']['view_video_quick_list_clear']; ?>
</a>
                            </div>
                         </div>
                    </div>
            </div>
            <div id="selVideoQuickListDisp">
            <ul id="selQuickList">
    <?php endif; ?>
        <?php $_from = $this->_tpl_vars['quickLink_arr']['display']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['quicklink']):
?>
         <li id="quick_list_selected_<?php echo $this->_tpl_vars['quicklink']['record']['video_id']; ?>
" class="<?php echo $this->_tpl_vars['quicklink']['className']; ?>
" >

            <div class="clsQuickLinksContainer">
            <div class="clsQuickLinksLeft">
                    <a href="<?php echo $this->_tpl_vars['quicklink']['playlistUrl']; ?>
"  class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                	   <img src="<?php echo $this->_tpl_vars['quicklink']['imageSrc']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['quicklink']['record']['video_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
"  border="0"<?php echo $this->_tpl_vars['quicklink']['disp_image']; ?>
/>
                   </a>
                  <span class="clsRunTime"><?php echo $this->_tpl_vars['quicklink']['playing_time']; ?>
<a class="" onclick="deleteVideoQuickLinks('<?php echo $this->_tpl_vars['quicklink']['record']['video_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['videolist_delete_quicklist_tooltips']; ?>
"></a></span>
            </div>
            	<div class="clsQuickLinksMiddle">
                    <p id="selMemberName" class="clsFeaturedVideoThumbDetailsTitle">
                        <a href="<?php echo $this->_tpl_vars['quicklink']['playlistUrl']; ?>
">
                            <?php echo $this->_tpl_vars['quicklink']['video_title']; ?>

                        </a>
                    </p>
                    <p><span><?php echo $this->_tpl_vars['LANG']['common_from']; ?>
: </span><?php echo $this->_tpl_vars['myobj']->getUserDetail('user_id',$this->_tpl_vars['quicklink']['record']['user_id'],'user_name'); ?>
</p>
                    <p><span><?php echo $this->_tpl_vars['LANG']['views']; ?>
: </span><?php echo $this->_tpl_vars['quicklink']['record']['total_views']; ?>
</p>
                    <p class="clsCloseQuickLink"><a onclick="deleteVideoQuickLinks('<?php echo $this->_tpl_vars['quicklink']['record']['video_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['videolist_delete_quicklist_tooltips']; ?>
" class="clsPhotoVideoEditLinks"><?php echo $this->_tpl_vars['LANG']['viewvideo_remove_this_video']; ?>
</a></p>
            	</div>
           </div>
        </li>
        <?php endforeach; endif; unset($_from); ?>
        <?php if (! $this->_tpl_vars['quicklink']['video_id']): ?>
        </ul>
        <?php endif; ?>
        </div>
        </div>
        <?php if ($this->_tpl_vars['myobj']->sellAllVideo): ?>
          <p class="clsViewAllLinks clsSeeMoreQuickLinks"><a onclick="moreVideosQuickList()"><?php echo $this->_tpl_vars['LANG']['see_all_videos']; ?>
</a></p>
        <?php endif; ?>
 

<?php endif; ?>
<?php if (! isAjaxpage ( ) || $this->_tpl_vars['myobj']->showRoundedCorner): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','video'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'viewvideodetails_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
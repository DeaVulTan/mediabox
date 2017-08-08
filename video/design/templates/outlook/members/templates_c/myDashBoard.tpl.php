<?php /* Smarty version 2.6.18, created on 2011-10-31 10:08:59
         compiled from myDashBoard.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'myDashBoard.tpl', 70, false),)), $this); ?>
<?php if (! isAjax ( )): ?>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('videoMainBlock')): ?>
	<?php if (! isAjax ( )): ?>
		<div id="selMyDashBoard">
	<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->getFormField('block') == 'ql'): ?>
	<?php if (! isAjax ( )): ?>
    	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['mydash_board_title']; ?>
</h2></div>
    <?php endif; ?>
<?php else: ?>
	<?php if (! isAjax ( )): ?>
    	<div class="clsPageHeading"><h2><?php echo $this->_tpl_vars['LANG']['mydash_board_history_title']; ?>
</h2></div>
    <?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
    <div id="selMsgError">
        <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
     </div>
<?php endif; ?>

<?php if (! isAjax ( )): ?>
    <div id="selIndexVideoLink" class="clsTabNavigation">
    <ul>

    <?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_history_links']): ?>
    <li class="<?php echo $this->_tpl_vars['myobj']->activeblockcss_historyLinks; ?>
">        
            <a href="<?php echo $this->_tpl_vars['myobj']->html_url; ?>
?block=hst<?php echo $this->_tpl_vars['myobj']->query_str; ?>
"><span class="<?php echo $this->_tpl_vars['myobj']->activeRightblockcss_historyLinks; ?>
"><?php echo $this->_tpl_vars['LANG']['mydashboard_type_history_link']; ?>
</span></a>
    </li>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['CFG']['admin']['videos']['allow_quick_links']): ?>
    <li class="<?php echo $this->_tpl_vars['myobj']->activeblockcss_quickLinks; ?>
">        
            <a href="<?php echo $this->_tpl_vars['myobj']->html_url; ?>
?block=ql<?php echo $this->_tpl_vars['myobj']->query_str; ?>
"><span class="<?php echo $this->_tpl_vars['myobj']->activeRightblockcss_quickLinks; ?>
"><?php echo $this->_tpl_vars['LANG']['mydashboard_type_quick_link']; ?>
</span></a>
    </li>
    <?php endif; ?>
    </ul>
</div>
    <script>
        var subMenuClassName1='clsActiveTabNavigation';
        var hoverElement1  = '.clsTabNavigation li';
        loadChangeClass(hoverElement1,subMenuClassName1);
    </script>

    <div id="selSearchList">
    <div id="selVideoSearchListTitle">
<?php endif; ?>
    <?php if ($this->_tpl_vars['myobj']->getFormField('block') == 'ql'): ?>

        <?php if (isLoggedIn ( ) && $this->_tpl_vars['CFG']['admin']['videos']['allow_quick_links']): ?>

            <div id="selVideoQuickLinks">
            <?php if (! $this->_tpl_vars['myobj']->video_id): ?>
                                <div id="selVideoQuickListDisp">
                    <ul id="selQuickList" class="clsMyQuickLinks">
            <?php endif; ?>
            <?php $_from = $this->_tpl_vars['myobj']->quickLinkVideo; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['quickLinkItem']):
?>
                <li id="quick_list_selected_<?php echo $this->_tpl_vars['quickLinkItem']['record']['video_id']; ?>
" class="<?php echo $this->_tpl_vars['quickLinkItem']['className']; ?>
<?php if ($this->_tpl_vars['inc'] == 0): ?> clsNoBorder<?php endif; ?>" >
                    <div class="clsQuickVideoInformation">
                        <div class="clsRelVideoImg">
                            <p id="selImageBorder" class="clsViewThumbImage">
                                <div  class="clsThumbImageLink clsPointer">
                                
                                          	<a href="<?php echo $this->_tpl_vars['quickLinkItem']['viewVideoUrl']; ?>
" class="Cls107x80 ClsImageBorder1 ClsImageContainer">
		                                    <img border="0" src="<?php echo $this->_tpl_vars['quickLinkItem']['imageSrc']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['quickLinkItem']['record']['video_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 15) : smarty_modifier_truncate($_tmp, 15)); ?>
" <?php echo $this->_tpl_vars['quickLinkItem']['disp_image']; ?>
/>
                                            </a>
                                         
                                </div>
                            </p>
                        </div>
                        <div class="clsOuickVideoDetails">
                            <p id="selMemberName">
                            <a href="<?php echo $this->_tpl_vars['quickLinkItem']['viewVideoUrl']; ?>
"><?php echo $this->_tpl_vars['quickLinkItem']['wrap_video_title']; ?>
</a></p>
                            <p><?php echo $this->_tpl_vars['LANG']['common_from']; ?>
: <?php echo $this->_tpl_vars['myobj']->getUserDetail('user_id',$this->_tpl_vars['quickLinkItem']['record']['user_id'],'user_name'); ?>
</p>
                            <p><?php echo $this->_tpl_vars['LANG']['common_views']; ?>
: <?php echo $this->_tpl_vars['quickLinkItem']['record']['total_views']; ?>
</p>
                                 <p><?php echo $this->_tpl_vars['quickLinkItem']['record']['playing_time']; ?>

                                    <a class="" onclick="deleteVideoQuickLinks('<?php echo $this->_tpl_vars['quickLinkItem']['record']['video_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['videolist_delete_quicklist_tooltips']; ?>
"></a>
                                 </p>
                        </div>
                        <div class="clsDeleteVideo">
                               <div class="clsQuickLinksRight">
                                    <p><a onclick="deleteVideoQuickLinks('<?php echo $this->_tpl_vars['quickLinkItem']['record']['video_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['videolist_delete_quicklist_tooltips']; ?>
"><?php echo $this->_tpl_vars['LANG']['quicklink_remove_this_video']; ?>
</a></p>
                                </div>
                        </div>
                  </div>
                </li>
            <?php endforeach; endif; unset($_from); ?>

            <?php if ($this->_tpl_vars['myobj']->seeAllVideos): ?>
                <li class="clsViewAllFriends">
                    <p><a onclick="moreVideosQuickList()"><?php echo $this->_tpl_vars['LANG']['see_all_videos']; ?>
</a></p>
                </li>
            <?php endif; ?>

            <?php if (! $this->_tpl_vars['myobj']->video_id): ?>
                </ul>
                    <div class="clsVideoManageLinks clsOverflow" <?php if ($this->_tpl_vars['myobj']->quickLinkTip): ?> style="display:none" <?php endif; ?>>
                        <div class="clsVideoManageLinksLeft">
                              <input type="checkbox" onclick="toggleOnViewClearQuickList(this);" name="clear_quick_list" id="clear_quick_list" value="1"
                              <?php echo $this->_tpl_vars['myobj']->clear_quick_checked; ?>
 />
                              <label for="clear_quick_list"><?php echo $this->_tpl_vars['LANG']['clear_quick_list_msg']; ?>
</label>
                        </div>
                        <div class="clsVideoManageLinksRight">
                                <?php echo $this->_tpl_vars['myobj']->getNextPlayListQuickLinks($this->_tpl_vars['myobj']->in_str,true); ?>

                                    <a href="<?php echo $this->_tpl_vars['myobj']->videoManageplaylistUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['view_video_quick_list_save']; ?>
</a>
                                    <a onClick="clearQuickLinks()"><?php echo $this->_tpl_vars['LANG']['view_video_quick_list_clear']; ?>
</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        <?php endif; ?>

            <div id="selMsg" class="clsNoQuickLink"  <?php if (! $this->_tpl_vars['myobj']->quickLinkTip): ?> style="display:none" <?php endif; ?>>
            	<p><?php echo $this->_tpl_vars['LANG']['mydashboard_quick_links_no_records']; ?>
</p>
                <p class="clsNormal"><?php echo $this->_tpl_vars['LANG']['mydashboard_quick_links_tip']; ?>
</p></div>
            </div>

    <?php elseif ($this->_tpl_vars['myobj']->getFormField('block') == 'hst' && isLoggedIn ( ) && $this->_tpl_vars['myobj']->CFG['admin']['videos']['allow_history_links']): ?>
        <div id="selVideoHistoryLinks">
        <?php if ($this->_tpl_vars['myobj']->video_id): ?>
            <h3><?php echo $this->_tpl_vars['myobj']->LANG['view_video_quick_history_title']; ?>
</h3>
        <?php endif; ?>
        <div id="selVideoQuickListDisp">
            <ul id="selQuickList" class="clsMyQuickLinks">

                <?php if (! $this->_tpl_vars['myobj']->historyLinkTip): ?>

                    <?php $_from = $this->_tpl_vars['myobj']->historyVideos; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['viewingHistory']):
?>
                        <li id="quick_list_selected_<?php echo $this->_tpl_vars['viewingHistory']['record']['video_id']; ?>
" class="<?php if ($this->_tpl_vars['inc'] == 0): ?> clsNoBorder<?php endif; ?>" >
                            <div class="clsQuickVideoInformation">
                                <div class="clsRelVideoImg">
                                    <p id="selImageBorder" class="clsViewThumbImage">
                                         <div  class="clsThumbImageLink clsPointer">                                             
                                                      	<a href="<?php echo $this->_tpl_vars['viewingHistory']['viewVideoUrl']; ?>
" class="Cls107x80 ClsImageBorder1 ClsImageContainer">
                                                        <img src="<?php echo $this->_tpl_vars['viewingHistory']['imageSrc']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['viewingHistory']['record']['video_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 15) : smarty_modifier_truncate($_tmp, 15)); ?>
" border="0" <?php echo $this->_tpl_vars['viewingHistory']['disp_image']; ?>
 />
                                                        </a>
                                        	</div>
                                    </p>
                                </div>
                                <div class="clsOuickVideoDetails">
                                    <p id="selMemberName"><a href="<?php echo $this->_tpl_vars['viewingHistory']['viewVideoUrl']; ?>
"> <?php echo $this->_tpl_vars['viewingHistory']['wrap_video_title']; ?>
</a> </p>
                                    <p><?php echo $this->_tpl_vars['myobj']->LANG['from']; ?>
 <?php echo $this->_tpl_vars['myobj']->getUserDetail('user_id',$this->_tpl_vars['viewingHistory']['record']['user_id'],'user_name'); ?>
</p>
                                    <p><?php echo $this->_tpl_vars['myobj']->LANG['views']; ?>
 <?php echo $this->_tpl_vars['viewingHistory']['record']['total_views']; ?>
</p>
                                            <p><?php echo $this->_tpl_vars['viewingHistory']['record']['playing_time']; ?>

                                                <a class="" onclick="deleteVideoQuickHistoryLinks('<?php echo $this->_tpl_vars['viewingHistory']['record']['video_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['videolist_history_quicklist_tooltips']; ?>
">
                                                </a>
                                            </p>
                                </div>
                                <div class="clsDeleteVideo">
                                        <div class="clsQuickLinksRight">
                                            <p>
                                                <a onclick="deleteVideoQuickHistoryLinks('<?php echo $this->_tpl_vars['viewingHistory']['record']['video_id']; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['videolist_history_quicklist_tooltips']; ?>
">
                                                <?php echo $this->_tpl_vars['myobj']->LANG['histroyLinks_remove_this_video']; ?>

                                                </a>
                                            </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>

                    <?php if ($this->_tpl_vars['myobj']->seeAllHistoryVideos): ?>
                        <li class="clsViewAllFriends">
                        <p><a onclick="moreVideosQuickHistoryList()"><?php echo $this->_tpl_vars['LANG']['see_all_videos']; ?>
</a></p>

                    </li>
                    <?php endif; ?>
                    <li>
                    <h4><a onClick="clearQuickHistoryLinks();"><?php echo $this->_tpl_vars['LANG']['view_video_quick_clear_history']; ?>
</a></h4>
                    </li>

             </ul>
           		<div id="selMsgSuccess">
                             <p><?php echo $this->_tpl_vars['LANG']['mydashboard_quick_history_tip_msg']; ?>
</p>
            </div>
       	</div>


        <?php else: ?>
            <div id="selMsg"><?php echo $this->_tpl_vars['LANG']['mydashboard_quick_history_tip']; ?>
</div>
        <?php endif; ?>

      </div>
    <?php endif; ?>

<?php if (! isAjax ( )): ?>
    </div>
    </div>
<?php endif; ?>

<?php endif; ?>

<?php if (! isAjax ( )): ?>
</div>
</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
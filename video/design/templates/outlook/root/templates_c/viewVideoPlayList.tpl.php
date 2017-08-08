<?php /* Smarty version 2.6.18, created on 2012-06-26 01:35:12
         compiled from viewVideoPlayList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewVideoPlayList.tpl', 23, false),array('function', 'counter', 'viewVideoPlayList.tpl', 280, false),)), $this); ?>
<div id="selViewVideoPlayList">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsOverflow"><div class="clsVideoListHeading">
	<h2><?php echo $this->_tpl_vars['LANG']['videolist_title']; ?>
</h2>
    </div></div>
	    <!--- Delete Single Videos --->
    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmText"></p>
      <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
        <table summary="<?php echo $this->_tpl_vars['LANG']['videolist_tbl_summary']; ?>
" class="clsVideoListTable">
          <tr>
            <td id="selVideoGallery"><p id="selImageBorder" class="clsPlainImageBorder"><span id="selPlainCenterImage"><img id="selVideoId" border="0" /></span></p></td>
          </tr>
          <tr>
            <td><input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
              &nbsp;
              <input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
              <input type="hidden" name="act" id="act" />
              <input type="hidden" name="video_id" id="video_id" />
              <input type="hidden" name="playlist_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
" />
            </td>
          </tr>
        </table>
      </form>
    </div>
    <!--- Delete Multi Videos --->
    <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
      <p id="msgConfirmTextMulti"><?php echo $this->_tpl_vars['LANG']['videolist_multi_delete_confirmation']; ?>
</p>
      <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
        <table summary="<?php echo $this->_tpl_vars['LANG']['videolist_tbl_summary']; ?>
" class="clsVideoListTable">
          <tr>
            <td><input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
              &nbsp;
              <input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
              <input type="hidden" name="video_id" id="video_id" />
              <input type="hidden" name="act" id="act" />
              <input type="hidden" name="playlist_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('playlist_id'); ?>
" />
            </td>
          </tr>
        </table>
      </form>
    </div>

    <div id="selEditPhotoComments" class="clsPopupConfirmation" style="display:none;position:absolute;"> </div>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_videos_form')): ?>
    <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
        <div id="selVideoPlayLIsts" class="clsDataTable clsPlaylistDetailsTable">
            <table>
                <tr>
                   <td class="clsPlayListLeftTd">
                        <?php echo $this->_tpl_vars['LANG']['play_list_name']; ?>

                    </td>
                    <td>
                        <?php echo $this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['play_list_details_arr']['play_list_name']; ?>
&nbsp;
                        <!---->
                    </td>
                </tr>
                <tr>
                    <td class="clsPlayListLeftTd">
                        <?php echo $this->_tpl_vars['LANG']['play_list_description']; ?>

                    </td>
                    <td>
                        <?php echo $this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['wordWrap_play_list_description']; ?>

                    </td>
                </tr>
                <tr>
                    <td class="clsPlayListLeftTd">
                        <?php echo $this->_tpl_vars['LANG']['play_list_user_name']; ?>

                    </td>
                    <td>
                        <a href="<?php echo $this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['getMemberProfileUrl']; ?>
"><?php echo $this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['play_list_details_arr']['user_name']; ?>
</a>
                    </td>
                </tr>
                <tr>
                   <td class="clsPlayListLeftTd">
                        <?php echo $this->_tpl_vars['LANG']['play_list_tags']; ?>

                    </td>
                    <td>
                        <?php echo $this->_tpl_vars['myobj']->getTagLinks($this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['play_list_details_arr']['play_list_tags']); ?>

                    </td>
                </tr>
                <tr>
                    <td class="clsPlayListLeftTd">
                        <?php echo $this->_tpl_vars['LANG']['play_list_total_videos']; ?>

                    </td>
                    <td>
                        <?php echo $this->_tpl_vars['myobj']->getVideoCount($this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['play_list_details_arr']['playlist_id']); ?>

                    </td>
                </tr>
            </table>
                <!-- -->
                    <div class="clsPlayAllVideos">
                        <?php echo $this->_tpl_vars['myobj']->getNextPlayListLinks(); ?>

                    </div>
            <?php if ($this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['play_list_url_exists']): ?>
                <table>
                    <tr>
                        <th>
                            <?php echo $this->_tpl_vars['LANG']['play_list_urls_videos']; ?>

                        </th>
                        <td>
                            <input onClick="this.select();"  size="70"  type="text" name="play_list_url" value="<?php echo $this->_tpl_vars['myobj']->my_videos_form['listPlayListDetails_arr']['viewVideoPlayList_url']; ?>
" readonly />
                        </td>
                    </tr>
                                    </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <!-- top pagination start-->
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            <!-- top pagination end-->
            <form name="videoListForm" id="videoListForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                <!---->
                    <a href="#" id="<?php echo $this->_tpl_vars['myobj']->my_videos_form['anchor']; ?>
"></a>
                <?php $this->assign('videoPerRow', '4'); ?>
                <?php $this->assign('count', '0'); ?>
                <div class="clsDataTable clsViewVideoPlaylistTable" id="">
                	<table summary="videolist_tbl_summary" class="clsViewVideoPlaylistTable" id="selDisplayTable">

                    <?php $_from = $this->_tpl_vars['myobj']->my_videos_form['showVideoList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['svlvalue']):
?>
                        <?php if ($this->_tpl_vars['count']%$this->_tpl_vars['videoPerRow'] == 0): ?>
                            <tr class="<?php echo $this->_tpl_vars['myobj']->getCSSRowClass(); ?>
">
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['myobj']->IS_EDIT): ?>
                            <!--<td>
                                <span class="clsCheckItem">
                                    <input type="checkbox" class="clsCheckRadio" name="video_ids[]"  value="<?php echo $this->_tpl_vars['svlvalue']['record']['video_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['svlvalue']['checked']; ?>
/>
                                </span>
                            </td>-->
                        <?php endif; ?>
                        <td>
                        <?php if ($this->_tpl_vars['svlvalue']['record']['video_encoded_status'] != 'Yes'): ?>
                            <div class="clsCommonSearch">
                                <div class="clsOverflow">
                                      <div class="Cls142x108 ClsImageBorder ClsImageContainer">
                                        <img src="<?php echo $this->_tpl_vars['svlvalue']['video_img_path']; ?>
" alt="<?php echo $this->_tpl_vars['svlvalue']['record']['video_title']; ?>
" <?php echo $this->_tpl_vars['svlvalue']['video_DISP_IMAGE']; ?>
 />
                                 	  </div>
                                </div>
                                <div  class="clsSearchRight">
                                    <ul id="selVideoLinks" class="clsContentEditLinks">
                                        <!-- -->
                                        <li class="clsDelete">
                                            <a id="<?php echo $this->_tpl_vars['svlvalue']['anchor']; ?>
"  href="#" class="clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['delete_submit']; ?>
" onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','video_id', 'selVideoId', 'msgConfirmText'), Array('delete','<?php echo $this->_tpl_vars['svlvalue']['record']['video_id']; ?>
', '<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
images/notActivateVideo_T.jpg', '<?php echo $this->_tpl_vars['LANG']['videolist_delete_confirmation']; ?>
'), Array('value','value', 'src', 'innerHTML'), -100, -500);">
                                                <?php echo $this->_tpl_vars['LANG']['delete_submit']; ?>

                                            </a>
                                        </li>
                                    </ul>
                                    <h3 class="clsTitleLink">
                                        <?php echo $this->_tpl_vars['svlvalue']['wordWrap_video_title']; ?>

                                    </h3>
                                    <p class="clsAddedDate">
                                        <?php echo $this->_tpl_vars['LANG']['added']; ?>
 <?php echo $this->_tpl_vars['svlvalue']['record']['date_added']; ?>

                                    </p>
                                </div>
                            </div>

                        <?php elseif ($this->_tpl_vars['svlvalue']['record']['video_encoded_status'] == 'Yes' && $this->_tpl_vars['svlvalue']['record']['video_status'] == 'Locked'): ?>
                            <div class="clsCommonSearch">
                                <div class="clsOverflow">
                                     <div class="Cls142x108 ClsImageBorder ClsImageContainer">
                                          <img src="<?php echo $this->_tpl_vars['svlvalue']['video_img_path']; ?>
" alt="<?php echo $this->_tpl_vars['svlvalue']['record']['video_title']; ?>
" title="<?php echo $this->_tpl_vars['svlvalue']['record']['video_title']; ?>
" />                                     </div>
                                </div>
                                <div  class="clsSearchRight">
                                    <h3 class="clsTitleLink">
                                        <?php echo $this->_tpl_vars['svlvalue']['wordWrap_video_title']; ?>

                                    </h3>
                                    <p class="clsAddedDate">
                                        <?php echo $this->_tpl_vars['LANG']['added']; ?>
 <?php echo $this->_tpl_vars['svlvalue']['record']['date_added']; ?>

                                    </p>
                                </div>
                            </div>

                        <?php else: ?>
                            <div class="clsCommonSearch">
                                <div class="clsOverflow">
                                <a id="<?php echo $this->_tpl_vars['svlvalue']['anchor']; ?>
"></a>
                                        <div   class="clsThumbImageOuterContainer clsThumbImageLink">
                                            <a href="<?php echo $this->_tpl_vars['svlvalue']['view_video_link']; ?>
" class="Cls142x108 ClsImageBorder1 ClsImageContainer clsPointer">
                                           	 <img src="<?php echo $this->_tpl_vars['svlvalue']['video_img_path']; ?>
" border="0" alt="<?php echo $this->_tpl_vars['svlvalue']['record']['video_title']; ?>
" title="<?php echo $this->_tpl_vars['svlvalue']['record']['video_title']; ?>
" <?php echo $this->_tpl_vars['svlvalue']['video_DISP_IMAGE']; ?>
 />
                                            </a>
                                        </div>
                               </div>
                                <?php if ($this->_tpl_vars['myobj']->getFormField('thumb') != 'yes'): ?>
                                    <div  class="clsSearchRight">
                                        <h3 class="clsTitleLink">
                                            <a href="<?php echo $this->_tpl_vars['svlvalue']['view_video_link']; ?>
" title="<?php echo $this->_tpl_vars['svlvalue']['wordWrap_video_title']; ?>
">
                                                <?php echo $this->_tpl_vars['svlvalue']['wordWrap_video_title']; ?>

                                            </a>
                                        </h3>
                                        <div class="clsSearchInline">
                                            <p class="clsAddedDate">
                                                <?php echo $this->_tpl_vars['LANG']['added']; ?>

                                                <span>
                                                    <?php echo $this->_tpl_vars['svlvalue']['record']['date_added']; ?>

                                                </span>
                                            </p>
                                        </div>
                                        <div class="clsSearchInline">
                                            <p class="clsUserTitle">
                                                <?php echo $this->_tpl_vars['LANG']['from']; ?>

                                                    <a href="<?php echo $this->_tpl_vars['svlvalue']['getMemberProfileUrl']; ?>
" title="<?php echo $this->_tpl_vars['svlvalue']['name']; ?>
">
                                                    <span>
                                                        <?php echo $this->_tpl_vars['svlvalue']['name']; ?>

                                                    </span>
                                                    </a>
                                            </p>
                                            <p class="clsWatchedDate">
                                                <?php echo $this->_tpl_vars['LANG']['watched']; ?>

                                                <span>
                                                    <?php echo $this->_tpl_vars['svlvalue']['record']['video_last_view_date']; ?>

                                                </span>
                                            </p>
                                        <p class="clsUserViews">
                                            <?php echo $this->_tpl_vars['LANG']['views']; ?>

                                            <span>
                                                <?php echo $this->_tpl_vars['svlvalue']['record']['total_views']; ?>

                                            </span>
                                        </p>
                                    </div>
                                    <div class="clsSearchInline">
                                        <p class="clsUserViews">
                                            <?php echo $this->_tpl_vars['LANG']['playing_time']; ?>

                                            <span>
                                                <?php echo $this->_tpl_vars['svlvalue']['record']['playing_time']; ?>

                                            </span>
                                        </p>
                                        <!--<p>
                                                                                    </p>-->
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                         </td>
                        <?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

                        <?php if ($this->_tpl_vars['count']%$this->_tpl_vars['videoPerRow'] == 0): ?>
                            <?php echo smarty_function_counter(array('start' => 0), $this);?>

                            </tr>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php $this->assign('cols', $this->_tpl_vars['videoPerRow']-$this->_tpl_vars['count']); ?>
                     <?php if ($this->_tpl_vars['count']): ?>
                        <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['cols']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                            <td>&nbsp;</td>
                        <?php endfor; endif; ?>
                        <tr>
                    <?php endif; ?>
                        <!--<?php if ($this->_tpl_vars['myobj']->my_videos_form['showVideoList_arr']['found'] && $this->_tpl_vars['count'] && $this->_tpl_vars['count'] < $this->_tpl_vars['videoPerRow']): ?>
                            <td colspan="(<?php echo $this->_tpl_vars['videoPerRow']-$this->_tpl_vars['count']; ?>
)">
                            </td>
                        <?php endif; ?>
                    </tr>	-->

                </table>
                </div>
            </form>
             <!-- bottom pagination start-->
              <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <?php endif; ?>
             <!-- pagination end-->
        <?php else: ?>
              <div id="selMsgAlert">
                <p><?php echo $this->_tpl_vars['LANG']['videolist_no_records_found']; ?>
</p>
              </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </div>
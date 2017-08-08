<?php /* Smarty version 2.6.18, created on 2013-08-17 00:15:50
         compiled from manageLyrics.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'manageLyrics.tpl', 19, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMusicPlaylistManage" class="clsAudioContentContainer">
    <!-- heading -->
    <h3 class="clsH3Heading">
    	<?php echo $this->_tpl_vars['LANG']['managelyrics_title']; ?>

    </h3>
    <!-- information div -->
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <!-- Create playlist block -->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_lyrics_block')): ?>

    	 <!-- Single confirmation box -->
        <div id="selMsgConfirmSingle" class="clsPopupConfirmation" style="display:none;">
            <p id="confirmMessageSingle"></p>
            <form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
                <input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
                &nbsp;
                <input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onClick="return hideAllBlocks('selFormForums');" />
                <input type="hidden" name="music_lyric_id" id="music_lyric_id" />
                <input type="hidden" name="action" id="action" />
                <?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

            </form>
        </div>
        <!-- confirmation box-->
        <!-- music information -->
    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'musicInformation.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                    <div class="clsAudioPaging"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
            <?php endif; ?>
            <form id="selFormLyrics" name="selFormLyrics" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" class="clsDataTable">
                 <table>
                   <tr>
                     <th width="5%" align="center" valign="middle"><input type="checkbox" class="clsCheckRadio" name="check_all" id="check_all" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="CheckAll(document.selFormLyrics.name, document.selFormLyrics.check_all.name)"/></th>
                     <th width="30%" align="left" valign="middle"><?php echo $this->_tpl_vars['LANG']['managelyrics_lyrics']; ?>
</th>
                     <th width="20%" align="left" valign="top"><?php echo $this->_tpl_vars['LANG']['managelyrics_Post_by']; ?>
</th>
                     <th width="20%" align="left" valign="top"><?php echo $this->_tpl_vars['LANG']['managelyrics_best_lyrics']; ?>
</th>
                     <th width="10%"><?php echo $this->_tpl_vars['LANG']['managelyrics_status']; ?>
</th>
                     <th width="10%" align="left" valign="top"><?php echo $this->_tpl_vars['LANG']['managelyrics_delete']; ?>
</th>
                     <th width="15%" align="left" valign="top"><?php echo $this->_tpl_vars['LANG']['managelyrics_edit']; ?>
</th>
                   </tr>
                   <?php $_from = $this->_tpl_vars['myobj']->list_lyrics_block['displayLyrics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lyricsKey'] => $this->_tpl_vars['lyricsValue']):
?>
                       <tr>
                         <td width="5%" align="left" valign="middle"><input type="checkbox" class="clsCheckRadio" name="lyrics_ids[]" value="<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
" onClick="disableHeading('selFormLyrics');" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></td>
                         <td width="30%" align="left" valign="top"><p title="<?php echo $this->_tpl_vars['lyricsValue']['lyrics']; ?>
"><a href="<?php echo $this->_tpl_vars['lyricsValue']['viewLyrics_url']; ?>
"><?php echo $this->_tpl_vars['lyricsValue']['lyrics']; ?>
</a></p></td>
                         <td width="25%" align="left" valign="top"><a href="<?php echo $this->_tpl_vars['lyricsValue']['lyrics_post_user_url']; ?>
"><?php echo $this->_tpl_vars['lyricsValue']['record']['user_name']; ?>
</a></td>
                         <td width="20%" align="left" valign="top">
                         	<?php if ($this->_tpl_vars['lyricsValue']['record']['best_lyric'] == 'Yes'): ?>
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('remove_best_lyric', '<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['managelyrics_confirm_remove_lyrics']; ?>
'), Array('value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_remove_best_lyrics']; ?>
</a>
                            <?php else: ?>
	                        	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('best_lyric', '<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['managelyrics_confirm_best_lyrics']; ?>
'), Array('value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_set_best_lyrics']; ?>
</a>
                            <?php endif; ?>                         </td>
                         <td width="10%">
                         	<?php if ($this->_tpl_vars['lyricsValue']['record']['lyric_status'] == 'Yes'): ?>
                            	<?php echo $this->_tpl_vars['LANG']['managelyrics_active_status_label']; ?>
(<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Inactive', '<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['managelyrics_inactive_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_inactive']; ?>
</a>)
                            <?php elseif ($this->_tpl_vars['lyricsValue']['record']['lyric_status'] == 'No'): ?>
                            	<?php echo $this->_tpl_vars['LANG']['managelyrics_inactive_status_label']; ?>
(<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Active', '<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['managelyrics_active_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_active']; ?>
</a>)
                            <?php elseif ($this->_tpl_vars['lyricsValue']['record']['lyric_status'] == 'ToActivate'): ?>
                            	<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle' ,Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Active', '<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['managelyrics_approve_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_photo_approve']; ?>
</a>
                                /<a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Delete', '<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['managelyrics_disapprove_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_photo_disapprove']; ?>
</a>
                            <?php endif; ?>                         </td>
                         <td width="10%" align="left" valign="top"><a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle', Array('action', 'music_lyric_id', 'confirmMessageSingle'), Array('Delete', '<?php echo $this->_tpl_vars['lyricsValue']['record']['music_lyric_id']; ?>
', '<?php echo $this->_tpl_vars['LANG']['managelyrics_delete_confirm_message']; ?>
'), Array('value', 'value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['managelyrics_delete']; ?>
</a></td>
                         <td width="10%" align="left" valign="top"><a href="<?php echo $this->_tpl_vars['lyricsValue']['editLyrics_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['managelyrics_edit']; ?>
</a></td>
					   </tr>
                   <?php endforeach; endif; unset($_from); ?>
                   <tr>
                         <td colspan="6" align="left" valign="middle">
                         <p class="clsFloatLeft clsSelectAlign"><select name="action_val" id="action_val" tabindex="<?php echo smartyTabIndex(array(), $this);?>
">
                        	<option value=""><?php echo $this->_tpl_vars['LANG']['common_select_action']; ?>
</option>
                        	<?php echo $this->_tpl_vars['myobj']->generalPopulateArray($this->_tpl_vars['myobj']->list_lyrics_block['action_arr'],$this->_tpl_vars['myobj']->getFormField('action')); ?>

                        </select></p>
                        <span class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="action_button" class="clsSubmitButton" id="action_button" value="<?php echo $this->_tpl_vars['LANG']['managelyrics_submit']; ?>
" onClick="getMultiCheckBoxValue('selFormLyrics', 'check_all', '<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
');if(multiCheckValue!='') getAction();"/></span></span></td>
                   </tr>
                  </table>
  </form>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
                <div id="bottomLinks" class="clsAudioPaging">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
      	    <?php endif; ?>
      	<?php else: ?>
          <div id="selMsgAlert"><?php echo $this->_tpl_vars['LANG']['managelyrics_no_record_found']; ?>
</div>
       	<?php endif; ?>
	<?php endif; ?>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



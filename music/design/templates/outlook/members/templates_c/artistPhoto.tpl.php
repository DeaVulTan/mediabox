<?php /* Smarty version 2.6.18, created on 2011-12-14 00:51:35
         compiled from artistPhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'artistPhoto.tpl', 32, false),array('function', 'counter', 'artistPhoto.tpl', 118, false),)), $this); ?>

    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selMusicPlaylistManage" class="clsMainContainer">
  <h3 class="clsH3Heading">
  		<?php if ($this->_tpl_vars['myobj']->page_title != ''): ?>
        	<?php echo $this->_tpl_vars['myobj']->page_title; ?>

        <?php else: ?>
             <?php echo $this->_tpl_vars['LANG']['viewartist_artistphoto_label']; ?>

        <?php endif; ?>
  </h3>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <!-- information div -->
    <!-- Upload photo block Start-->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('upload_photo_block') && isMember ( )): ?>
    <div class="clsAdvancedFilterSearch clsshowhidefiltersblock clsOverflow clsMargintop10">
    	<a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')" class="clsShow"  id="show_link" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['viewartist_upload_artist_photo']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewartist_upload_artist_photo']; ?>
</span></a>
        <a onclick="divShowHide('upload_photo_block', 'show_link', 'hide_link')" class="clsHide"  style="display:none" id="hide_link" href="javascript:void(0)"><span><?php echo $this->_tpl_vars['LANG']['viewartist_upload_artist_photo']; ?>
</span></a>
    </div>
        <div id="upload_photo_block"  class="clsAdvancedFilterTable clsOverflow" <?php if (! $this->_tpl_vars['myobj']->flag): ?> style="display:none" <?php endif; ?>>
            <form action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" method="post"   enctype="multipart/form-data" name="musicPlayListManage" >

                <table class="">
                    <tr>
                        <td align="left" valign="top">
                            &nbsp; <label for="artist_photo">
                            <?php echo $this->_tpl_vars['LANG']['viewartist_upload_photo']; ?>
 <?php echo $this->_tpl_vars['myobj']->photosize_detail; ?>

                            </label>
                        </td>
                        <td align="left" valign="top">
                            <input type="file" class="clsFile" name="artist_photo" id="artist_photo" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                             <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('artist_photo'); ?>

                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('artist_photo','artist_photo'); ?>

                        </td>
                    </tr>
                   <!-- <tr>
                        <td align="left" valign="top">
                            <label for="image_caption">
                            <?php echo $this->_tpl_vars['LANG']['viewartist_photo_caption']; ?>

                            </label>
                        </td>
                        <td align="left" valign="top">
                            <textarea name="image_caption" id="image_caption" cols="45" rows="5" tabindex="<?php echo smartyTabIndex(array(), $this);?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('image_caption'); ?>
</textarea>
                            <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('image_caption'); ?>

                            <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('image_caption','image_caption'); ?>

                        </td>
                    </tr>-->
                    <tr>
                        <td>&nbsp;

                        </td>
                        <td><div class="clsSubmitButton-l">
								<span class="clsSubmitButton-r"><input type="submit" name="upload" id="upload" value="<?php echo $this->_tpl_vars['LANG']['viewartist_upload']; ?>
"/></span>
                             </div>
                       </td>
                    </tr>
                </table>

            </form>
        </div>
    <?php endif; ?>
    <?php if (! isMember ( )): ?>
    <div>
    <p class="clsArtistLoginlink"><a href="<?php echo $this->_tpl_vars['myobj']->getUrl('login'); ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewartist_login_msg']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewartist_login_msg']; ?>
</a></p>
    </div>
    <?php endif; ?>
    <!-- Upload photo block End-->
     <!-- Single confirmation box -->
    <div id="selMsgConfirmSingle" style="display:none;" class="clsMsgConfirm">
		<p id="confirmMessageSingle"></p>
		<form name="msgConfirmformSingle" id="msgConfirmformSingle" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
" autocomplete="off">
			<table summary="<?php echo $this->_tpl_vars['LANG']['viewartist_confirm_tbl_summary']; ?>
">
				<tr>
					<td>
                    	<img id="artistImg" border="0" src="" />
						<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
						&nbsp;
						<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onclick="return hideAllBlocks('selMsgConfirmSingle');" />
						<input type="hidden" name="music_artist_image" id="music_artist_image" />
						<input type="hidden" name="action" id="action" />
						<?php echo $this->_tpl_vars['myobj']->populateHidden($this->_tpl_vars['myobj']->hidden_arr); ?>

					</td>
				</tr>
			</table>
		</form>
	</div>
    <!-- confirmation box-->
    <!-- Photo list block start-->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('list_photo_block')): ?>
       	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                    <div class="clsAudioPaging">
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					</div>
            <?php endif; ?>
            <?php $this->assign('count', '0'); ?>
             <table class="cls5TdTable clsArtistProfileTable">
            <?php $_from = $this->_tpl_vars['myobj']->list_photo_block['showArtistImageList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['asKey'] => $this->_tpl_vars['saValue']):
?>
                 <?php if ($this->_tpl_vars['count'] == 0): ?>
                    <tr>
                    <?php endif; ?>
                        <td>

                                    <div class="clsNoLink">
                                      <div class="ClsImageContainer ClsImageBorder1 Cls90x90">
										  <img src="<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
" title="<?php echo $this->_tpl_vars['saValue']['record']['image_caption']; ?>
"/>
                                        </div>
                                    </div>
                            <?php if ($this->_tpl_vars['saValue']['record']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                <p class="clsDeleteThis"><!--<a href="#"><?php echo $this->_tpl_vars['LANG']['viewartist_edit']; ?>
</a>-->
                                    <a href="javascript:void(0);" onclick="return Confirmation('selMsgConfirmSingle', 'msgConfirmformSingle',Array('action', 'music_artist_image', 'artistImg', 'confirmMessageSingle'), Array('delete', '<?php echo $this->_tpl_vars['saValue']['music_artist_image']; ?>
', '<?php echo $this->_tpl_vars['saValue']['artist_image']; ?>
', '<?php echo $this->_tpl_vars['LANG']['viewartist_delete_confirmation']; ?>
'), Array('value', 'value', 'src', 'innerHTML'), -100, -500);" title="<?php echo $this->_tpl_vars['LANG']['viewartist_delete']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewartist_delete']; ?>
</a>
                                </p>
                            <?php endif; ?>
                            <!-- <p title="<?php echo $this->_tpl_vars['saValue']['record']['image_caption']; ?>
"><?php echo $this->_tpl_vars['saValue']['record']['image_caption']; ?>
</p> -->
                        </td>
                   <?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

                   <?php if ($this->_tpl_vars['count']%$this->_tpl_vars['CFG']['admin']['musics']['artist_image_cols'] == 0): ?>
                        <?php echo smarty_function_counter(array('start' => 0), $this);?>

                        </tr>
                    <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            <?php $this->assign('cols', $this->_tpl_vars['CFG']['admin']['musics']['artist_image_cols']-$this->_tpl_vars['count']); ?>
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
            </table>

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
            <div id="selMsgAlert">
                <p><?php echo $this->_tpl_vars['LANG']['viewartist_no_records_found']; ?>
</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
     <!-- Photo list block end-->
</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
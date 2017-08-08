<?php /* Smarty version 2.6.18, created on 2012-04-21 23:12:36
         compiled from addLyrics.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'addLyrics.tpl', 49, false),)), $this); ?>
<div id="selLyricsMsgError" class="clsErrorMessage" style="display:none">
</div>
<div id="selLyricsMsgSuccess" class="clsSuccessMessage" style="display:none">
</div>
<?php if ($this->_tpl_vars['myobj']->getFormField('light_window') == ''): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
<?php endif; ?>
<div id="selMusicPlaylistManage" class="clsAudioContentContainer">
	<?php if ($this->_tpl_vars['myobj']->getFormField('light_window') == ''): ?>
        <!-- heading -->
        <h3 class="clsH3Heading">
            <?php echo $this->_tpl_vars['LANG']['managelyrics_title']; ?>

        </h3>
        <?php endif; ?>    
        <!-- information div -->	
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


    <!-- Create playlist block -->
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('add_lyrics_block') && isMember ( )): ?>
  <!-- music information -->
  		<?php if ($this->_tpl_vars['myobj']->getFormField('light_window') == ''): ?>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'musicInformation.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          <?php endif; ?>  
            <form id="selFormLyrics" name="selFormLyrics" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
			  <table class="clsTable">
                  <tr>
                    <td class="clsLyricLabel"><label for="lyric"><?php echo $this->_tpl_vars['LANG']['managelyrics_lyrics_label']; ?>
</label></td>
                    <td>
                    	 
	                    	<textarea name="lyric" id="lyric" cols="60" rows="13"></textarea>
                                                <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('lyric'); ?>

                        <?php echo $this->_tpl_vars['myobj']->ShowHelpTip('lyric','lyric'); ?>
   
                    </td>
                  </tr>
                  <tr>
                    <td><!--&nbsp;--></td>
                    <td>
                    <?php if ($this->_tpl_vars['myobj']->getFormField('light_window') == ''): ?>
                    	 <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="submit" name="submit_button" id="submit_button" value="<?php echo $this->_tpl_vars['LANG']['managelyrics_submit']; ?>
" /></span></p>
                    	<?php if ($this->_tpl_vars['myobj']->chkIsAdminSide()): ?>
                         	<p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="submit_button" id="submit_button" value="<?php echo $this->_tpl_vars['LANG']['managelyrics_cancel']; ?>
"                       
                        		 onclick="Redirect2URL('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
admin/music/manageLyrics.php?music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
')"tabindex="<?php echo smartyTabIndex(array(), $this);?>
"/></span></p>
                         <?php endif; ?>	
                     <?php else: ?>
	                     <p class="clsSubmitButton-l"><span class="clsSubmitButton-r"><input type="button" name="submit_button" id="submit_button" value="<?php echo $this->_tpl_vars['LANG']['managelyrics_submit']; ?>
" 
                         
                         onclick="light_addMusiclyrics('<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/addLyrics.php?ajax_page=true&amp;music_id=<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
&amp;page=addlyrics')"/></span></p>
                    <?php endif; ?>	
                    <input type="hidden"  name="music_id" id="music_id" value="<?php echo $this->_tpl_vars['myobj']->getFormField('music_id'); ?>
" />
                    </td>
                  </tr>
                </table>
			</form>
	<?php endif; ?>
</div>
<?php if ($this->_tpl_vars['myobj']->getFormField('light_window') == ''): ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
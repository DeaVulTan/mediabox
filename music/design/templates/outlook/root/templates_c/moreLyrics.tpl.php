<?php /* Smarty version 2.6.18, created on 2014-04-24 21:41:44
         compiled from moreLyrics.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
<div id="selMusicPlaylistManage" class="clsAudioContentContainer">
    <!-- heading -->
    <h3 class="clsH3Heading">
    	<?php echo $this->_tpl_vars['LANG']['morelyrics_title']; ?>

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
    	<!-- music information -->
    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

    		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'musicInformation.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
                <form class="clsDataTable" id="selFormLyrics" name="selFormLyrics" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
                <table width="100%"  >
                <tr>
                
                <th width="35%" align="left" valign="middle"><?php echo $this->_tpl_vars['LANG']['morelyrics_lyrics']; ?>
</th>
                <th width="25%" align="left" valign="top"><?php echo $this->_tpl_vars['LANG']['morelyrics_Post_by']; ?>
</th>
                </tr>
                <?php $_from = $this->_tpl_vars['myobj']->list_lyrics_block['displayLyrics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lyricsKey'] => $this->_tpl_vars['lyricsValue']):
?>
                <tr>
                
                <td width="35%" align="left" valign="top"><p title="<?php echo $this->_tpl_vars['lyricsValue']['lyrics']; ?>
"><a href="<?php echo $this->_tpl_vars['lyricsValue']['viewLyrics_url']; ?>
" title="<?php echo $this->_tpl_vars['lyricsValue']['lyrics']; ?>
"><?php echo $this->_tpl_vars['lyricsValue']['lyrics']; ?>
</a></p></td>
                <td width="25%" align="left" valign="top"><a class="clsUsername" href="<?php echo $this->_tpl_vars['lyricsValue']['lyrics_post_user_url']; ?>
" title="<?php echo $this->_tpl_vars['lyricsValue']['record']['user_name']; ?>
"><?php echo $this->_tpl_vars['lyricsValue']['record']['user_name']; ?>
</a></td>
                </tr>
                <?php endforeach; endif; unset($_from); ?>  
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
          <div id="selMsgAlert"><?php echo $this->_tpl_vars['LANG']['morelyrics_no_record_found']; ?>
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
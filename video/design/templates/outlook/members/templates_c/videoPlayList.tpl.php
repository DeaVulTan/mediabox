<?php /* Smarty version 2.6.18, created on 2013-07-17 16:50:48
         compiled from videoPlayList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'videoPlayList.tpl', 6, false),)), $this); ?>
<div id="selVideoList">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <div id="selVideoTitle">
                 <div class="clsPageHeading">
           			 <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['videolist_playilst'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
</h2>
        		</div>
      </div>
        <?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
        <div id="selVideoListDisplay" class="clsLeftSideDisplayTable" style="clear:left">
            <div id="topLinks">
            <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            </div>
            <div>
            <ul class="clsViewPlaylist">
            <?php $this->assign('count', 0); ?>
            <?php $_from = $this->_tpl_vars['myobj']->showPlaylist['record']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['videoplaylist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['videoplaylist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['playlist']):
        $this->_foreach['videoplaylist']['iteration']++;
?>
            <li>
            	<div class="clsOverflow">
                <div class="clsViewPlaylistLeft">
                        <div class="clsThumbImageLink">
                            <a href="<?php echo $this->_tpl_vars['playlist']['url']; ?>
" class="ClsImageContainer ClsImageBorder Cls107x80 clsPointer">
                            <img border="0" src="<?php echo $this->_tpl_vars['playlist']['imageSrc']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(142,108,$this->_tpl_vars['playlist']['t_width'],$this->_tpl_vars['playlist']['t_height']); ?>
 />
                            </a>
                        </div>
                                            </div>
                <div class="clsViewPlaylistMiddle">
                            <p class="clsViewPlaylistTitle"><a href="<?php echo $this->_tpl_vars['playlist']['url']; ?>
"><?php echo $this->_tpl_vars['playlist']['playlist_name']; ?>
</a><span>(<?php echo $this->_tpl_vars['playlist']['total_videos']; ?>
 videos)</span>
                            </p>
                            <p><?php echo $this->_tpl_vars['LANG']['videolist_by']; ?>
 <a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl[$this->_tpl_vars['playlist']['user_id']]; ?>
"><?php echo $this->_tpl_vars['myobj']->getUserDetail('user_id',$this->_tpl_vars['playlist']['user_id'],'user_name'); ?>
</a></p>
                            <p><?php echo $this->_tpl_vars['playlist']['date_added']; ?>
</p>
                            <p><label><?php echo $this->_tpl_vars['LANG']['videolist_caption']; ?>
</label><?php echo $this->_tpl_vars['playlist']['playlist_description']; ?>
</p>
                        	<p><label><?php echo $this->_tpl_vars['LANG']['videolist_tags']; ?>
</label>
                        <?php $_from = $this->_tpl_vars['playlist']['playlist_tags']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
                            <a href="<?php echo $this->_tpl_vars['tag']['tag_url']; ?>
"><?php echo $this->_tpl_vars['tag']['tag']; ?>
</a>
                        <?php endforeach; endif; unset($_from); ?></p>
                </div>
                <div class="clsViewPlaylistRight">
                            <p class="clsPlayThisVideo"><?php echo $this->_tpl_vars['myobj']->getNextPlayListLinks($this->_tpl_vars['playlist']['playlist_id']); ?>
</p>
                </div>
                               </div>
             </li>
             <?php endforeach; endif; unset($_from); ?>
            </div>
             </div>
        </div>
        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
        <div id="bottomLinks">
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         </div>
        <?php endif; ?>
        <?php else: ?>
        <div id="selMsgAlert">
            <p><?php echo $this->_tpl_vars['LANG']['videolist_no_records_found']; ?>
</p>
        </div>
        <?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

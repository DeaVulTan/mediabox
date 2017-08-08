<?php /* Smarty version 2.6.18, created on 2011-10-24 16:56:26
         compiled from indexPopularPlaylistContent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'indexPopularPlaylistContent.tpl', 28, false),array('function', 'math', 'indexPopularPlaylistContent.tpl', 56, false),)), $this); ?>
<?php if ($this->_tpl_vars['playlist_block_record_count']): ?>
<table class="clsCarouselList">
		<?php $this->assign('row_count', 4); ?>
	<?php $this->assign('break_count', 1); ?>
    
    <script type="text/javascript"> 
		original_height = new Array();
		original_width = new Array();
	</script>
	<?php $this->assign('array_count', '1'); ?>
	<?php $_from = $this->_tpl_vars['showPlaylists_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['musicPlaylistKey'] => $this->_tpl_vars['musicplaylist']):
?>
    <?php if ($this->_tpl_vars['break_count'] == 1): ?>
    <tr>
    <?php endif; ?>
        <td class="clsFeaturedAlbumCaroselTd">        	
            <div class="clsFeaturedalbumComtainer">
				<div class="clsFeaturedAlbumMultipleImg" onclick="Redirect2URL('<?php echo $this->_tpl_vars['musicplaylist']['view_playlisturl']; ?>
');">                
                	<?php if ($this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['total_record'] > 0): ?>
                    <?php $_from = $this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['playlistImageDetailKey'] => $this->_tpl_vars['playlistImageDetailValue']):
?>
                   	<?php echo '
					<script language="javascript" type="text/javascript"> 
                        original_height['; ?>
<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo '] = \''; ?>
<?php echo $this->_tpl_vars['playlistImageDetailValue']['record']['thumb_height']; ?>
<?php echo '\';
                        original_width['; ?>
<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo ']  = \''; ?>
<?php echo $this->_tpl_vars['playlistImageDetailValue']['record']['thumb_width']; ?>
<?php echo '\';
                    </script>
                    '; ?>

                    <table><tr><td>
                    <img title="<?php echo $this->_tpl_vars['playlistImageDetailValue']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['playlistImageDetailValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3) : smarty_modifier_truncate($_tmp, 3)); ?>
" id="t<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" style="position:;z-index:999;display:none;" src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_thumb_path']; ?>
" onmouseout="playlistImageZoom('Shrink', 's<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
', 't<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
', <?php echo $this->_tpl_vars['array_count']; ?>
); return false;"/>
                    <img title="<?php echo $this->_tpl_vars['playlistImageDetailValue']['record']['music_title']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['playlistImageDetailValue']['record']['music_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3) : smarty_modifier_truncate($_tmp, 3)); ?>
" id="s<?php echo $this->_tpl_vars['array_count']; ?>
<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_id']; ?>
" src="<?php echo $this->_tpl_vars['playlistImageDetailValue']['playlist_path']; ?>
" />
                    </td></tr></table>
                    <?php $this->assign('array_count', $this->_tpl_vars['array_count']+1); ?>
                    <?php endforeach; endif; unset($_from); ?>
                    <?php if ($this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['total_record'] < 4): ?>
                    <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['musicplaylist']['getPlaylistImageDetail']['noimageCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                    <table><tr><td><img title="<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicplaylist']['record']['playlist_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3) : smarty_modifier_truncate($_tmp, 3)); ?>
" width="70" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_S.jpg" /></td></tr></table>
                    <?php endfor; endif; ?>	
                	<?php endif; ?>
                    <?php else: ?>    
                    <div class="clsSingleImage"><img title="<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['musicplaylist']['record']['playlist_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3) : smarty_modifier_truncate($_tmp, 3)); ?>
" src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
music/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImage_audio_T.jpg" /></div>
                    <?php endif; ?>
				</div>
			</div>
            <div class="clsFeaturedAlbumDetails">
                <a href="<?php echo $this->_tpl_vars['musicplaylist']['view_playlisturl']; ?>
" title="<?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
"><pre><?php echo $this->_tpl_vars['musicplaylist']['record']['playlist_name']; ?>
</pre></a>
                <p><?php echo $this->_tpl_vars['LANG']['myhome_total_tracks']; ?>
: <span><?php echo $this->_tpl_vars['musicplaylist']['record']['total_tracks']; ?>
</span></p>
            </div>
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
<?php else: ?>
<div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['sidebar_no_playlist_found_error_msg']; ?>
</div>
<?php endif; ?>
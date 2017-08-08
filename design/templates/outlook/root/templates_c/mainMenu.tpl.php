<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from mainMenu.tpl */ ?>
<div class="clsMainNavigation">
    <h3><?php echo $this->_tpl_vars['myobj']->LANG['header_top_menu_sub_navigation_links']; ?>
</h3>
    <div id="selNav">
        <ul class="clsMenu">
            <?php unset($this->_sections['sec']);
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['menu']['main']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec']['start'] = (int)0;
$this->_sections['sec']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['max'] = (int)$this->_tpl_vars['mainMenuMax'];
$this->_sections['sec']['show'] = true;
if ($this->_sections['sec']['max'] < 0)
    $this->_sections['sec']['max'] = $this->_sections['sec']['loop'];
if ($this->_sections['sec']['start'] < 0)
    $this->_sections['sec']['start'] = max($this->_sections['sec']['step'] > 0 ? 0 : -1, $this->_sections['sec']['loop'] + $this->_sections['sec']['start']);
else
    $this->_sections['sec']['start'] = min($this->_sections['sec']['start'], $this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] : $this->_sections['sec']['loop']-1);
if ($this->_sections['sec']['show']) {
    $this->_sections['sec']['total'] = min(ceil(($this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] - $this->_sections['sec']['start'] : $this->_sections['sec']['start']+1)/abs($this->_sections['sec']['step'])), $this->_sections['sec']['max']);
    if ($this->_sections['sec']['total'] == 0)
        $this->_sections['sec']['show'] = false;
} else
    $this->_sections['sec']['total'] = 0;
if ($this->_sections['sec']['show']):

            for ($this->_sections['sec']['index'] = $this->_sections['sec']['start'], $this->_sections['sec']['iteration'] = 1;
                 $this->_sections['sec']['iteration'] <= $this->_sections['sec']['total'];
                 $this->_sections['sec']['index'] += $this->_sections['sec']['step'], $this->_sections['sec']['iteration']++):
$this->_sections['sec']['rownum'] = $this->_sections['sec']['iteration'];
$this->_sections['sec']['index_prev'] = $this->_sections['sec']['index'] - $this->_sections['sec']['step'];
$this->_sections['sec']['index_next'] = $this->_sections['sec']['index'] + $this->_sections['sec']['step'];
$this->_sections['sec']['first']      = ($this->_sections['sec']['iteration'] == 1);
$this->_sections['sec']['last']       = ($this->_sections['sec']['iteration'] == $this->_sections['sec']['total']);
?>
                <?php if ($this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['target_type'] == 'popup'): ?>
                    <li class="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['clsActive']; ?>
 <?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['class_name']; ?>
 clsMenuLiLink" id="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['id']; ?>
"><a class="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['class_name']; ?>
 clsMenuALink" href="javascript:void(0)" onclick="openPopupWindow('<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['url']; ?>
')"><span class="clsMenuSpanLink"><?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['name']; ?>
</span></a></li>
                <?php else: ?>
                    <li class="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['clsActive']; ?>
 <?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['class_name']; ?>
 clsMenuLiLink" id="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['id']; ?>
"><a class="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['class_name']; ?>
 clsMenuALink" href="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['url']; ?>
" target="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['target_type']; ?>
"><span class="clsMenuSpanLink"><?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['name']; ?>
</span></a></li>
                <?php endif; ?>
            <?php endfor; endif; ?>
            
            <?php if ($this->_tpl_vars['menu_channel'] && ! $this->_tpl_vars['display_channel_in_row']): ?>
                <li id="channel_menu_anchor" class="selDropDownLink clsMainSubMenu">
                    <a class="clsMoreMenus"><span><?php echo $this->_tpl_vars['LANG']['common_channel']; ?>
</span></a>
                    <?php if ($this->_tpl_vars['menu_channel'] && ! $this->_tpl_vars['display_channel_in_row']): ?>
                        <ul class="clsMoreMainMenu">
                            <?php unset($this->_sections['channel_menu']);
$this->_sections['channel_menu']['loop'] = is_array($_loop=$this->_tpl_vars['menu_channel']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['channel_menu']['start'] = (int)0;
$this->_sections['channel_menu']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['channel_menu']['max'] = (int)$this->_tpl_vars['channelMenuMax'];
$this->_sections['channel_menu']['name'] = 'channel_menu';
$this->_sections['channel_menu']['show'] = true;
if ($this->_sections['channel_menu']['max'] < 0)
    $this->_sections['channel_menu']['max'] = $this->_sections['channel_menu']['loop'];
if ($this->_sections['channel_menu']['start'] < 0)
    $this->_sections['channel_menu']['start'] = max($this->_sections['channel_menu']['step'] > 0 ? 0 : -1, $this->_sections['channel_menu']['loop'] + $this->_sections['channel_menu']['start']);
else
    $this->_sections['channel_menu']['start'] = min($this->_sections['channel_menu']['start'], $this->_sections['channel_menu']['step'] > 0 ? $this->_sections['channel_menu']['loop'] : $this->_sections['channel_menu']['loop']-1);
if ($this->_sections['channel_menu']['show']) {
    $this->_sections['channel_menu']['total'] = min(ceil(($this->_sections['channel_menu']['step'] > 0 ? $this->_sections['channel_menu']['loop'] - $this->_sections['channel_menu']['start'] : $this->_sections['channel_menu']['start']+1)/abs($this->_sections['channel_menu']['step'])), $this->_sections['channel_menu']['max']);
    if ($this->_sections['channel_menu']['total'] == 0)
        $this->_sections['channel_menu']['show'] = false;
} else
    $this->_sections['channel_menu']['total'] = 0;
if ($this->_sections['channel_menu']['show']):

            for ($this->_sections['channel_menu']['index'] = $this->_sections['channel_menu']['start'], $this->_sections['channel_menu']['iteration'] = 1;
                 $this->_sections['channel_menu']['iteration'] <= $this->_sections['channel_menu']['total'];
                 $this->_sections['channel_menu']['index'] += $this->_sections['channel_menu']['step'], $this->_sections['channel_menu']['iteration']++):
$this->_sections['channel_menu']['rownum'] = $this->_sections['channel_menu']['iteration'];
$this->_sections['channel_menu']['index_prev'] = $this->_sections['channel_menu']['index'] - $this->_sections['channel_menu']['step'];
$this->_sections['channel_menu']['index_next'] = $this->_sections['channel_menu']['index'] + $this->_sections['channel_menu']['step'];
$this->_sections['channel_menu']['first']      = ($this->_sections['channel_menu']['iteration'] == 1);
$this->_sections['channel_menu']['last']       = ($this->_sections['channel_menu']['iteration'] == $this->_sections['channel_menu']['total']);
?>
                                <li onmouseover="allowChannelHide=false" onmouseout="allowChannelHide=true"><a href="<?php echo $this->_tpl_vars['menu_channel'][$this->_sections['channel_menu']['index']]['url']; ?>
" ><?php echo $this->_tpl_vars['menu_channel'][$this->_sections['channel_menu']['index']]['name']; ?>
</a></li>
                            <?php endfor; endif; ?>
                            <?php if ($this->_tpl_vars['channelMore']): ?>
                                <li onmouseover="allowChannelHide=false" onmouseout="allowChannelHide=true"><a href="<?php echo $this->_tpl_vars['channel_more_link']; ?>
" ><?php echo $this->_tpl_vars['LANG']['common_more']; ?>
</a></li>
                            <?php endif; ?>
                        </ul>
                    <?php endif; ?>   
                </li>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['mainmenu_more']): ?>
                <li id="menu_more_anchor" class="selDropDownLink clsMainSubMenu">
                   <p class=""><?php echo $this->_tpl_vars['LANG']['common_more']; ?>
</p>
                    <?php if ($this->_tpl_vars['mainmenu_more']): ?>
					   <ul class="clsMainSubMenuContainer" dropdownhide="musicselect,videoselect,articleselect,browse,photoselect,blogselect,comment_status,articlelistselect,musicplaylistselect,commentStatusForm">
                       <div>
                        <?php unset($this->_sections['sec']);
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['menu']['main']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec']['start'] = (int)$this->_tpl_vars['mainMenuMax'];
$this->_sections['sec']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['show'] = true;
$this->_sections['sec']['max'] = $this->_sections['sec']['loop'];
if ($this->_sections['sec']['start'] < 0)
    $this->_sections['sec']['start'] = max($this->_sections['sec']['step'] > 0 ? 0 : -1, $this->_sections['sec']['loop'] + $this->_sections['sec']['start']);
else
    $this->_sections['sec']['start'] = min($this->_sections['sec']['start'], $this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] : $this->_sections['sec']['loop']-1);
if ($this->_sections['sec']['show']) {
    $this->_sections['sec']['total'] = min(ceil(($this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] - $this->_sections['sec']['start'] : $this->_sections['sec']['start']+1)/abs($this->_sections['sec']['step'])), $this->_sections['sec']['max']);
    if ($this->_sections['sec']['total'] == 0)
        $this->_sections['sec']['show'] = false;
} else
    $this->_sections['sec']['total'] = 0;
if ($this->_sections['sec']['show']):

            for ($this->_sections['sec']['index'] = $this->_sections['sec']['start'], $this->_sections['sec']['iteration'] = 1;
                 $this->_sections['sec']['iteration'] <= $this->_sections['sec']['total'];
                 $this->_sections['sec']['index'] += $this->_sections['sec']['step'], $this->_sections['sec']['iteration']++):
$this->_sections['sec']['rownum'] = $this->_sections['sec']['iteration'];
$this->_sections['sec']['index_prev'] = $this->_sections['sec']['index'] - $this->_sections['sec']['step'];
$this->_sections['sec']['index_next'] = $this->_sections['sec']['index'] + $this->_sections['sec']['step'];
$this->_sections['sec']['first']      = ($this->_sections['sec']['iteration'] == 1);
$this->_sections['sec']['last']       = ($this->_sections['sec']['iteration'] == $this->_sections['sec']['total']);
?>
                            <?php if ($this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['target_type'] == 'popup'): ?>
                                <li onmouseover="allowMenuMoreHide=false" onmouseout="allowMenuMoreHide=true"><a href="javascript:void(0)" onclick="openPopupWindow('<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['url']; ?>
')"><?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['name']; ?>
</a></li>
                            <?php else: ?>
                                <li onmouseover="allowMenuMoreHide=false" onmouseout="allowMenuMoreHide=true"><a href="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['url']; ?>
" target="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['target_type']; ?>
"><?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['name']; ?>
</a></li>
                            <?php endif; ?>
                        <?php endfor; endif; ?>
                        </div>
                        </ul>
                    <?php endif; ?>
                </li>
             <?php endif; ?>
             
        </ul>
    </div>
</div>
<?php echo '
<script type="text/javascript">
$Jq(document).ready(function(){
	var menuLi=$Jq(\'.clsMenu li\');
	menuLi.each(function (li)
	{
		$Jq(this).bind(\'mouseover\', function()
		{
			$Jq(this).addClass(\'clsHoverMenu\');
		});
		$Jq(this).bind(\'mouseout\', function()
		{
			$Jq(this).removeClass(\'clsHoverMenu\');
		});
	});
	'; ?>

	<?php unset($this->_sections['sec']);
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['menu']['main']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec']['start'] = (int)0;
$this->_sections['sec']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['max'] = (int)$this->_tpl_vars['mainMenuMax'];
$this->_sections['sec']['show'] = true;
if ($this->_sections['sec']['max'] < 0)
    $this->_sections['sec']['max'] = $this->_sections['sec']['loop'];
if ($this->_sections['sec']['start'] < 0)
    $this->_sections['sec']['start'] = max($this->_sections['sec']['step'] > 0 ? 0 : -1, $this->_sections['sec']['loop'] + $this->_sections['sec']['start']);
else
    $this->_sections['sec']['start'] = min($this->_sections['sec']['start'], $this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] : $this->_sections['sec']['loop']-1);
if ($this->_sections['sec']['show']) {
    $this->_sections['sec']['total'] = min(ceil(($this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] - $this->_sections['sec']['start'] : $this->_sections['sec']['start']+1)/abs($this->_sections['sec']['step'])), $this->_sections['sec']['max']);
    if ($this->_sections['sec']['total'] == 0)
        $this->_sections['sec']['show'] = false;
} else
    $this->_sections['sec']['total'] = 0;
if ($this->_sections['sec']['show']):

            for ($this->_sections['sec']['index'] = $this->_sections['sec']['start'], $this->_sections['sec']['iteration'] = 1;
                 $this->_sections['sec']['iteration'] <= $this->_sections['sec']['total'];
                 $this->_sections['sec']['index'] += $this->_sections['sec']['step'], $this->_sections['sec']['iteration']++):
$this->_sections['sec']['rownum'] = $this->_sections['sec']['iteration'];
$this->_sections['sec']['index_prev'] = $this->_sections['sec']['index'] - $this->_sections['sec']['step'];
$this->_sections['sec']['index_next'] = $this->_sections['sec']['index'] + $this->_sections['sec']['step'];
$this->_sections['sec']['first']      = ($this->_sections['sec']['iteration'] == 1);
$this->_sections['sec']['last']       = ($this->_sections['sec']['iteration'] == $this->_sections['sec']['total']);
?>
	<?php echo '
		$Jq('; ?>
'#<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['id']; ?>
'<?php echo ').mouseover(function()
			{
			'; ?>

			<?php if ($this->_tpl_vars['mainmenu_more']): ?>
				<?php echo '
				allowMenuMoreHide=true;
				hideMenuMore();
				'; ?>

			<?php endif; ?>
			<?php if ($this->_tpl_vars['menu_channel']): ?>
				<?php echo '
				allowChannelHide=true;
				hideChannel();
				'; ?>

			<?php endif; ?>
			<?php echo '
			}
		);'; ?>

	<?php endfor; endif; ?>
<?php echo '
});
function openPopupWindow(url){
	window.open (url, "","status=0,toolbar=0,resizable=1,scrollbars=1");
}
</script>
'; ?>
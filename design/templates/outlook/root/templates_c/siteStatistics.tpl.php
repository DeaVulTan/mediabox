<?php /* Smarty version 2.6.18, created on 2011-10-17 14:52:37
         compiled from siteStatistics.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'siteStatistics.tpl', 8, false),)), $this); ?>
<div class="clsStatsContainer">
<div style="right:0">
    <div class="clsStatsRight">
        <div class="clsStatsLeft">
        	<div class="clsStatsContent">
                <?php /*?> by Ahmedov Abror
				<p class="clsStatsHeading"><?php echo $this->_tpl_vars['LANG']['index_site_statistics_title']; ?>:</p>
				<?php */?>
                <p class="clsStatsHeading">&nbsp;</p>                
                                <?php $this->assign('stats_count', count($this->_tpl_vars['statistics'])); ?>
                <?php unset($this->_sections['count']);
$this->_sections['count']['name'] = 'count';
$this->_sections['count']['loop'] = is_array($_loop=$this->_tpl_vars['statistics']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['count']['show'] = true;
$this->_sections['count']['max'] = $this->_sections['count']['loop'];
$this->_sections['count']['step'] = 1;
$this->_sections['count']['start'] = $this->_sections['count']['step'] > 0 ? 0 : $this->_sections['count']['loop']-1;
if ($this->_sections['count']['show']) {
    $this->_sections['count']['total'] = $this->_sections['count']['loop'];
    if ($this->_sections['count']['total'] == 0)
        $this->_sections['count']['show'] = false;
} else
    $this->_sections['count']['total'] = 0;
if ($this->_sections['count']['show']):

            for ($this->_sections['count']['index'] = $this->_sections['count']['start'], $this->_sections['count']['iteration'] = 1;
                 $this->_sections['count']['iteration'] <= $this->_sections['count']['total'];
                 $this->_sections['count']['index'] += $this->_sections['count']['step'], $this->_sections['count']['iteration']++):
$this->_sections['count']['rownum'] = $this->_sections['count']['iteration'];
$this->_sections['count']['index_prev'] = $this->_sections['count']['index'] - $this->_sections['count']['step'];
$this->_sections['count']['index_next'] = $this->_sections['count']['index'] + $this->_sections['count']['step'];
$this->_sections['count']['first']      = ($this->_sections['count']['iteration'] == 1);
$this->_sections['count']['last']       = ($this->_sections['count']['iteration'] == $this->_sections['count']['total']);
?>
                    <p>
                        <span><?php echo $this->_tpl_vars['statistics'][$this->_sections['count']['index']]['value']; ?>
</span> <?php echo $this->_tpl_vars['statistics'][$this->_sections['count']['index']]['lang']; ?>

						<?php if (( ( $this->_tpl_vars['stats_count']-1 ) != $this->_sections['count']['index'] )): ?>,&nbsp;<?php endif; ?>
                    </p>
                <?php endfor; endif; ?>
            </div>
        </div>
    </div>
	</div>
</div>
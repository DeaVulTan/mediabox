<?php /* Smarty version 2.6.18, created on 2011-10-19 22:18:00
         compiled from populatePhotoRatingImages.tpl */ ?>
<?php unset($this->_sections['rating']);
$this->_sections['rating']['name'] = 'rating';
$this->_sections['rating']['start'] = (int)1;
$this->_sections['rating']['loop'] = is_array($_loop=$this->_tpl_vars['populateRatingImages_arr']['rating']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['rating']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['rating']['show'] = true;
$this->_sections['rating']['max'] = $this->_sections['rating']['loop'];
if ($this->_sections['rating']['start'] < 0)
    $this->_sections['rating']['start'] = max($this->_sections['rating']['step'] > 0 ? 0 : -1, $this->_sections['rating']['loop'] + $this->_sections['rating']['start']);
else
    $this->_sections['rating']['start'] = min($this->_sections['rating']['start'], $this->_sections['rating']['step'] > 0 ? $this->_sections['rating']['loop'] : $this->_sections['rating']['loop']-1);
if ($this->_sections['rating']['show']) {
    $this->_sections['rating']['total'] = min(ceil(($this->_sections['rating']['step'] > 0 ? $this->_sections['rating']['loop'] - $this->_sections['rating']['start'] : $this->_sections['rating']['start']+1)/abs($this->_sections['rating']['step'])), $this->_sections['rating']['max']);
    if ($this->_sections['rating']['total'] == 0)
        $this->_sections['rating']['show'] = false;
} else
    $this->_sections['rating']['total'] = 0;
if ($this->_sections['rating']['show']):

            for ($this->_sections['rating']['index'] = $this->_sections['rating']['start'], $this->_sections['rating']['iteration'] = 1;
                 $this->_sections['rating']['iteration'] <= $this->_sections['rating']['total'];
                 $this->_sections['rating']['index'] += $this->_sections['rating']['step'], $this->_sections['rating']['iteration']++):
$this->_sections['rating']['rownum'] = $this->_sections['rating']['iteration'];
$this->_sections['rating']['index_prev'] = $this->_sections['rating']['index'] - $this->_sections['rating']['step'];
$this->_sections['rating']['index_next'] = $this->_sections['rating']['index'] + $this->_sections['rating']['step'];
$this->_sections['rating']['first']      = ($this->_sections['rating']['iteration'] == 1);
$this->_sections['rating']['last']       = ($this->_sections['rating']['iteration'] == $this->_sections['rating']['total']);
?>
	<img src="<?php echo $this->_tpl_vars['populateRatingImages_arr']['bulet_star']; ?>
" />
<?php endfor; endif; ?>
<?php if ($this->_tpl_vars['populateRatingImages_arr']['condition']): ?>
	<a href="<?php echo $this->_tpl_vars['populateRatingImages_arr']['url']; ?>
" id="ratingLink">
<?php endif; ?>
<?php unset($this->_sections['unrating']);
$this->_sections['unrating']['name'] = 'unrating';
$this->_sections['unrating']['start'] = (int)$this->_tpl_vars['populateRatingImages_arr']['rating'];
$this->_sections['unrating']['loop'] = is_array($_loop=$this->_tpl_vars['populateRatingImages_arr']['rating_total']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['unrating']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['unrating']['show'] = true;
$this->_sections['unrating']['max'] = $this->_sections['unrating']['loop'];
if ($this->_sections['unrating']['start'] < 0)
    $this->_sections['unrating']['start'] = max($this->_sections['unrating']['step'] > 0 ? 0 : -1, $this->_sections['unrating']['loop'] + $this->_sections['unrating']['start']);
else
    $this->_sections['unrating']['start'] = min($this->_sections['unrating']['start'], $this->_sections['unrating']['step'] > 0 ? $this->_sections['unrating']['loop'] : $this->_sections['unrating']['loop']-1);
if ($this->_sections['unrating']['show']) {
    $this->_sections['unrating']['total'] = min(ceil(($this->_sections['unrating']['step'] > 0 ? $this->_sections['unrating']['loop'] - $this->_sections['unrating']['start'] : $this->_sections['unrating']['start']+1)/abs($this->_sections['unrating']['step'])), $this->_sections['unrating']['max']);
    if ($this->_sections['unrating']['total'] == 0)
        $this->_sections['unrating']['show'] = false;
} else
    $this->_sections['unrating']['total'] = 0;
if ($this->_sections['unrating']['show']):

            for ($this->_sections['unrating']['index'] = $this->_sections['unrating']['start'], $this->_sections['unrating']['iteration'] = 1;
                 $this->_sections['unrating']['iteration'] <= $this->_sections['unrating']['total'];
                 $this->_sections['unrating']['index'] += $this->_sections['unrating']['step'], $this->_sections['unrating']['iteration']++):
$this->_sections['unrating']['rownum'] = $this->_sections['unrating']['iteration'];
$this->_sections['unrating']['index_prev'] = $this->_sections['unrating']['index'] - $this->_sections['unrating']['step'];
$this->_sections['unrating']['index_next'] = $this->_sections['unrating']['index'] + $this->_sections['unrating']['step'];
$this->_sections['unrating']['first']      = ($this->_sections['unrating']['iteration'] == 1);
$this->_sections['unrating']['last']       = ($this->_sections['unrating']['iteration'] == $this->_sections['unrating']['total']);
?>
	<img src="<?php echo $this->_tpl_vars['populateRatingImages_arr']['bulet_star_empty']; ?>
" />
<?php endfor; endif; ?>
<?php if ($this->_tpl_vars['populateRatingImages_arr']['condition']): ?>
</a>
<?php endif; ?>
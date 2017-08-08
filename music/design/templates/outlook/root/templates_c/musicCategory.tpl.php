<?php /* Smarty version 2.6.18, created on 2012-02-02 14:12:51
         compiled from musicCategory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'musicCategory.tpl', 45, false),array('function', 'counter', 'musicCategory.tpl', 83, false),)), $this); ?>
<div id="selMusicCategory">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'audioindex_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="clsOverflow">
            <div class="clsHeadingLeft">                        
            <h2><span><?php echo $this->_tpl_vars['LANG']['musiccategory_page_title']; ?>
</span></h2>
        </div>
        <div class="clsHeadingRight">
            	<div class="clsBackToCategory"> 
            <?php if ($this->_tpl_vars['myobj']->getFormField('category_id') != ''): ?>
            <a href="<?php echo $this->_tpl_vars['myobj']->getUrl('musiccategory','','','members','music'); ?>
"><?php echo $this->_tpl_vars['LANG']['musiccategory_back_to_category']; ?>
</a>
           <?php endif; ?>
     </div>
        </div>
    </div>

    <div id="topLinks">
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
    </div>
    <div class="clsLeftNavigation" id="selLeftNavigation">
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_category')): ?>
		<div id="selShowAllShoutouts" class="clsDataTable clsCategoryTable">
			<div id="">
            <table summary="<?php echo $this->_tpl_vars['LANG']['musiccategory_tbl_summary']; ?>
" id="selCategoryTable" class="cls5TdTable">
	        <?php if (! $this->_tpl_vars['myobj']->isResultsFound()): ?>
    	    <tr>
				<td><?php echo $this->_tpl_vars['LANG']['musiccategory_no_category']; ?>
</td>
			</tr>
            <?php else: ?>
				<?php $this->assign('inc', 0); ?>
				<?php $this->assign('count', '0'); ?> 
				<?php $_from = $this->_tpl_vars['myobj']->form_show_category; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categorylist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categorylist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['count'] => $this->_tpl_vars['result']):
        $this->_foreach['categorylist']['iteration']++;
?>
				<?php echo $this->_tpl_vars['result']['open_tr']; ?>

					<td id="selMusicGallery" class="clsMusicCategoryCell">
								<div class="clsChannelLeftContent">
								<div class="clsLargeThumbImageBackground">
								  <a href="<?php echo $this->_tpl_vars['result']['music_link']; ?>
" class="ClsImageContainer ClsImageBorder1 Cls132x88">
										<img src="<?php echo $this->_tpl_vars['result']['category_image']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['record']['music_category_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(132,88,$this->_tpl_vars['CFG']['admin']['musics']['category_width'],$this->_tpl_vars['CFG']['admin']['musics']['category_height']); ?>
 />
								  </a>
								</div>
								</div>
						<div id="selImageDet" class="clsChannelRightContent">
							<h3>
								<a href="<?php echo $this->_tpl_vars['result']['music_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['music_category_name']; ?>
">
									<?php echo $this->_tpl_vars['result']['record']['music_category_name']; ?>

								</a>
							</h3>
							<p>
								<span class="clsBold"><?php echo $this->_tpl_vars['LANG']['search_option_today']; ?>
: </span>
								<?php echo $this->_tpl_vars['result']['today_category_count']; ?>

								&nbsp;|&nbsp;
								<span class="clsBold"><?php echo $this->_tpl_vars['LANG']['musiccategory_total']; ?>
</span>
								<?php echo $this->_tpl_vars['result']['record']['music_category_count']; ?>

							</p>
						<?php if ($this->_tpl_vars['result']['content_filter']): ?>
						  <div class="clsOverflow">
							<div class="clsSubCategory">
							  <ul>
								<li><?php if ($this->_tpl_vars['myobj']->getFormField('category_id') == ''): ?><a href="<?php echo $this->_tpl_vars['result']['record']['music_sub_url']; ?>
"  class="clsSubCategoryIcon clsPhotoVideoEditLinks" title="<?php echo $this->_tpl_vars['LANG']['musiccategory_music_subcategory']; ?>
"><?php echo $this->_tpl_vars['LANG']['musiccategory_music_subcategory']; ?>
</a></li>
								<li class="clsGenereType">|</li><?php endif; ?>
								<li class="clsGenereType"><?php echo $this->_tpl_vars['LANG']['genre_type']; ?>
:</li>
								<li class="clsCategoryType"><?php echo $this->_tpl_vars['result']['record']['music_category_type']; ?>
</li>
							  </ul>
							 </div>
																				  							</div>
						<?php endif; ?>
						</div>
						  <!-- <p><span class="clsBold"><?php echo $this->_tpl_vars['LANG']['genre_description']; ?>
</span>:</p>
						   <p class="clsDesc"><?php echo $this->_tpl_vars['result']['record']['music_category_description']; ?>
</p>-->
						</div>						
					</td>
							   
				<?php echo $this->_tpl_vars['result']['end_tr']; ?>

				<?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

				<?php if ($this->_tpl_vars['count']%$this->_tpl_vars['CFG']['admin']['musics']['catergory_list_per_row'] == 0): ?>
					<?php echo smarty_function_counter(array('start' => 0), $this);?>

				<?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            <?php $this->assign('cols', $this->_tpl_vars['CFG']['admin']['musics']['catergory_list_per_row']-$this->_tpl_vars['count']); ?>
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
            <?php endif; ?>
            <?php endif; ?>
			</table>
			</div>
                <div id="bottomLinks">
    <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
        <div class="clsAudioPaging">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
    <?php endif; ?>
    </div>

		</div>
    <?php endif; ?>
	</div>

<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','music'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'audioindex_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
</div>
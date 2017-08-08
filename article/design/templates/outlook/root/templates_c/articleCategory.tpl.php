<?php /* Smarty version 2.6.18, created on 2012-02-02 14:07:25
         compiled from articleCategory.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'articleCategory.tpl', 44, false),)), $this); ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="selmyobj">
	<div class="clsPageHeading">
    	<h2><span><?php echo $this->_tpl_vars['LANG']['articlecategory_page_title']; ?>
</span></h2>
  	</div>
  	<div class="clsLeftNavigation" id="selLeftNavigation">
   		<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_category')): ?>
    		<div id="selShowAllShoutouts">
	 			<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
	 				<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
    						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

          					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          			<?php endif; ?>
      				<div class="clsDataTable clsCategoryTable">
        				<table border="1" cellspacing="0" summary="<?php echo $this->_tpl_vars['LANG']['articlecategory_tbl_summary']; ?>
" id="selCategoryTable">
					    <?php $this->assign('countt', 1); ?>
					    <?php $this->assign('inc', 0); ?>
					    <?php $this->assign('count', '0'); ?>
          				<?php $_from = $this->_tpl_vars['myobj']->form_show_category; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['categorylist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['categorylist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['count'] => $this->_tpl_vars['result']):
        $this->_foreach['categorylist']['iteration']++;
?>
           					<?php echo $this->_tpl_vars['result']['open_tr']; ?>

                  				<td id="selArticleGallery" class="clsArticleCategoryCell">
                        			<div class="clsArticleListCont">
                          				<div class="clsOverflow" id="selPhotCategoryImageDisp">
                            				<div id="selImageBorder">
                              					<div class="clsThumbImageLink">
                                					<a href="Redirect2URL('<?php echo $this->_tpl_vars['result']['article_link']; ?>
')" class="ClsImageContainer ClsImageBorder1 Cls132x100 clsPointer">
                                    							<img src="<?php echo $this->_tpl_vars['result']['category_image']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['article_category_name']; ?>
" alt="<?php echo $this->_tpl_vars['result']['record']['article_category_name']; ?>
"/>
                              						</a>
                            					</div>
                          					</div>
                      						<div id="selImageDet" class="clsArticleNameHd">
                        						<h3><a href="<?php echo $this->_tpl_vars['result']['article_link']; ?>
" title="<?php echo $this->_tpl_vars['result']['record']['article_category_name']; ?>
"><?php echo $this->_tpl_vars['result']['record']['article_category_name']; ?>
</a></h3>
                        						<p><span class=""><?php echo $this->_tpl_vars['LANG']['articlecategory_today']; ?>
</span><?php echo $this->_tpl_vars['result']['today_category_count']; ?>
&nbsp;|&nbsp;<span class=""><?php echo $this->_tpl_vars['LANG']['articlecategory_total']; ?>
</span><?php echo $this->_tpl_vars['result']['record']['article_category_count']; ?>
</p>
    						                </div>
                      						<?php if ($this->_tpl_vars['result']['content_filter']): ?>
												<p><?php echo $this->_tpl_vars['LANG']['genre_type']; ?>
:<span> <?php echo $this->_tpl_vars['result']['record']['article_category_type']; ?>
</span></p>
											<?php endif; ?>
                      						                      					</div>
                      				</div>
                				</td>
            				<?php echo $this->_tpl_vars['result']['end_tr']; ?>

            				<?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

            				<?php if ($this->_tpl_vars['count']%$this->_tpl_vars['CFG']['admin']['articles']['catergory_list_per_row'] == 0): ?>
            					<?php echo smarty_function_counter(array('start' => 0), $this);?>

            				<?php endif; ?>
            				<?php $this->assign('countt', $this->_tpl_vars['countt']+1); ?>
            			<?php endforeach; endif; unset($_from); ?>
            			<?php $this->assign('cols', $this->_tpl_vars['CFG']['admin']['articles']['catergory_list_per_row']-$this->_tpl_vars['count']); ?>
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
        				</table>
      				</div>
      				<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
    					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

      					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      				<?php endif; ?>
      			<?php else: ?>
      				<div id="selMsgError" class="clsNoArticlesFound">
        				<p><?php echo $this->_tpl_vars['LANG']['articlecategory_no_category']; ?>
<p>
      				</div>
      			<?php endif; ?>
			</div>
    	<?php endif; ?>
	</div>
</div>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
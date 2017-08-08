<?php /* Smarty version 2.6.18, created on 2012-12-17 16:38:16
         compiled from photosInSlideList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'photosInSlideList.tpl', 31, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('photolist_block')): ?>
	<?php if ($this->_tpl_vars['displayPhotoList_arr']['record_count']): ?>
    <div class="clsDataTable clsPopupContent">
    <table >
        <tr>
            <th class="clsSerialNo"><?php echo $this->_tpl_vars['LANG']['photo_playlist_id']; ?>
</th>
            <th><?php echo $this->_tpl_vars['LANG']['photo_playlist_phototitle']; ?>
</th>
        </tr>
        <?php $_from = $this->_tpl_vars['displayPhotoList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['photoListKey'] => $this->_tpl_vars['photoListValue']):
?>
         <tr>
            <td><?php echo $this->_tpl_vars['photoListKey']; ?>
</td>
            <td>

                <p>
                	<img src="<?php echo $this->_tpl_vars['photoListValue']['photo_img_src']; ?>
"/>
                </p>
            </td>
         </tr>
        <?php endforeach; endif; unset($_from); ?>
    </table></div>
    <?php else: ?>
           <div class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['photoplaylist_admin_photolist_norecords_found']; ?>
</div>
    <?php endif; ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['displayPhotoList_arr']['record_count']): ?>
                <?php $this->assign('count', '1'); ?>
                  <div class="clsPhotoListDetails">
	                  <div class="clsMultipleImage clsPointer">
                      	<?php if ($this->_tpl_vars['displayPhotoList_arr']['total_record'] > 0): ?>
                        <?php $_from = $this->_tpl_vars['displayPhotoList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['photoListKey'] => $this->_tpl_vars['photoListValue']):
?>
                            <?php echo smarty_function_counter(array('assign' => 'count'), $this);?>

                                <table <?php if ($this->_tpl_vars['photoListKey'] % 2 == 0): ?>class="clsSlidelistFinalRecord"<?php endif; ?>>
                                	<tr>
                                    	<td>
                                          <div>
											<a href="<?php echo $this->_tpl_vars['photoplaylist']['view_playlisturl']; ?>
"  title="<?php echo $this->_tpl_vars['photoListValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
">
                                            	<img src="<?php echo $this->_tpl_vars['photoListValue']['photo_img_src']; ?>
" alt="<?php echo $this->_tpl_vars['photoListValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
" alt="<?php echo $this->_tpl_vars['photoListValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
" title="<?php echo $this->_tpl_vars['photoListValue']['wordWrap_mb_ManualWithSpace_photo_title']; ?>
"/>
                                            </a>
                                          </div>
                                        </td>
                                    </tr>
                                 </table>

                        <?php endforeach; endif; unset($_from); ?>
                        <?php if ($this->_tpl_vars['displayPhotoList_arr']['total_record'] < 4): ?>
                            <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)0;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['displayPhotoList_arr']['noimageCount']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                            <?php $this->assign('countNoImage', $this->_sections['foo']['index']); ?>
                                                            <table <?php if ($this->_tpl_vars['displayPhotoList_arr']['noimageCount'] == 4): ?>
											<?php if ($this->_tpl_vars['countNoImage'] % 2 == 0): ?>class="clsSlidelistFinalRecord"<?php endif; ?>
										<?php elseif ($this->_tpl_vars['displayPhotoList_arr']['noimageCount'] == 3): ?>
											<?php if ($this->_tpl_vars['countNoImage'] == 0 || $this->_tpl_vars['countNoImage'] == 2): ?>class="clsSlidelistFinalRecord"<?php endif; ?>
										<?php elseif ($this->_tpl_vars['displayPhotoList_arr']['noimageCount'] == 2): ?>
											<?php if ($this->_tpl_vars['countNoImage'] == 1): ?>class="clsSlidelistFinalRecord"<?php endif; ?>
										<?php elseif ($this->_tpl_vars['displayPhotoList_arr']['noimageCount'] == 1): ?>
											class="clsSlidelistFinalRecord"
										<?php endif; ?>>
                                	<tr>
                                    	<td>
                                        	<img  src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/noImageSlieList.jpg" />
                                        </td>
                                    </tr>
                                </table>
                            <?php endfor; endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                      </div>
                  </div>

    <?php else: ?>

    	    <div class="clsPhotoListDetails">
	    	    <div class="clsPhotoSlideListNoImage">
           			<img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/no_image/icon-noImageSlieList.jpg" />
                </div>
            </div>

     <?php endif; ?>
<?php endif; ?>
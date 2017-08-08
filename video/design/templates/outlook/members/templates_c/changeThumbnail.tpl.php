<?php /* Smarty version 2.6.18, created on 2013-07-04 12:57:58
         compiled from changeThumbnail.tpl */ ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="clsChangeThumbnailPage">
	<div class="clsOverflow">
    <div class="clsVideoListHeading"><h2><?php echo $this->_tpl_vars['LANG']['change_thumbnail']; ?>
</h2></div>
	<div class="clsVideoListHeadingRight">
    <h3><a href="<?php echo $this->_tpl_vars['myobj']->editVideoUrl; ?>
"><?php echo $this->_tpl_vars['LANG']['back_to_edit_video']; ?>
</a></h3>
    </div>
    </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "information.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('display_image')): ?>
	<div class="clsOverflow clsChangeThumbnailContent">
    	<h3><?php echo $this->_tpl_vars['LANG']['current_thumbnail']; ?>
</h3>
        <p class="clsViewThumbImage">
			<span><img src="<?php echo $this->_tpl_vars['myobj']->currentThumb; ?>
?<?php echo time(); ?>" /></span>
        </p>
	</div>
	<div>
    	<div class="clsAvailableThumbnailContent">
            <h3><?php echo $this->_tpl_vars['LANG']['available_thumbnail']; ?>
</h3>
            <p><?php echo $this->_tpl_vars['LANG']['available_thumbnail_description']; ?>
</p>
        <div class="clsDataTable clsViewVideoPlaylistTable">
			<table>
                <?php $_from = $this->_tpl_vars['myobj']->image; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['thumbnail']):
?>
                <?php if ($this->_tpl_vars['thumbnail']['opentr']): ?>
                <tr>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['thumbnail']['path']): ?>
                   <td>
                        <p class="clsViewThumbImage">
                            <a href="<?php echo $this->_tpl_vars['thumbnail']['changeThumbUrl']; ?>
"><img src="<?php echo $this->_tpl_vars['thumbnail']['path']; ?>
" width="<?php echo $this->_tpl_vars['thumbnail']['width']; ?>
" height="<?php echo $this->_tpl_vars['thumbnail']['height']; ?>
"/></a>
                        </p>
                   </td>
                <?php else: ?>
                   <td></td>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['thumbnail']['closetr']): ?>
       			</tr>
        <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		</table>
        </div>
        </div>
	</div>
	<div class="clsOverflow clsChangeThumbnailContent">
		<h3><?php echo $this->_tpl_vars['LANG']['upload_thumbnail']; ?>
</h3>
		<form action="<?php echo $this->_tpl_vars['myobj']->uploadThumbUrl; ?>
" method="post" enctype="multipart/form-data">
        	<div>
                <label for="thumbfile"><?php echo $this->_tpl_vars['LANG']['upload_thumbnail_label']; ?>
</label> <?php echo $this->_tpl_vars['myobj']->getFormFieldErrorTip('thumbfile'); ?>

                <input type="file" name="thumbfile" id="thumbfile" />
            </div>        
           <div class="clsOverflow">
               <div class="clsGreyButtonLeft">
                    <div class="clsGreyButtonRight">
                        <input type="submit" value="<?php echo $this->_tpl_vars['LANG']['upload_button']; ?>
" name="upload">
                    </div>
                </div>
            </div>
			</form>
    </div>
<?php endif; ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'display_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
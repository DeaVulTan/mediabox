<?php /* Smarty version 2.6.18, created on 2012-02-17 06:23:42
         compiled from selRelatedContent_res.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'selRelatedContent_res.tpl', 14, false),)), $this); ?>
<?php if ($this->_tpl_vars['myobj']->tagRelatedVideo['total_records']): ?>
       <form name="selected_video_form1" id="selected_video_form1" action="<?php echo $this->_tpl_vars['myobj']->relatedViewVideoUrl; ?>
" method="post" >
        <div id="selVideoDisp">
            <div class="clsOverflow">
				<table>
            <tr>
                <td>
                    <table>
                    <?php $_from = $this->_tpl_vars['myobj']->tagRelatedVideo['display']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
                    <tr class="clsVideoSepartor">
                        <td class="clsPopupVideoImage">
                            <p id="selImageBorder">
                            <a href="<?php echo $this->_tpl_vars['result']['videoLink']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['result']['imageSrc']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['result']['record']['video_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10) : smarty_modifier_truncate($_tmp, 10)); ?>
" <?php echo $this->_tpl_vars['result']['disp_image']; ?>
 />
                            </a>
							<span class="clsRunTime"><?php echo $this->_tpl_vars['result']['playing_time']; ?>
</span>
                            <div class="clsAddQuickVideoImg">
                            </div>
                            </p>
                        </td>
                        <td class="clsPopupVideoImageDetails">
                            <p id="selMemberName">
                                <a href="<?php echo $this->_tpl_vars['result']['videoLink']; ?>
"><?php echo $this->_tpl_vars['result']['video_title']; ?>
</a>
                            </p>                            
                            <p><?php echo $this->_tpl_vars['LANG']['common_from']; ?>
: <?php echo $this->_tpl_vars['result']['name']; ?>
</p>
                            <p><?php echo $this->_tpl_vars['LANG']['views']; ?>
 <?php echo $this->_tpl_vars['result']['record']['total_views']; ?>
</p>
							<div class="clsSelectPreview">
                            
                                <input class="clsVideoPreviewButton" type="submit" name="select_response_video[<?php echo $this->_tpl_vars['result']['record']['video_id']; ?>
]" 
                                id="select_video" value="<?php echo $this->_tpl_vars['LANG']['select_this_video']; ?>
" />
                            
                                <input class="clsVideoPreviewButton" type="button" 
                                onclick="videoSlideShow_res('<?php echo $this->_tpl_vars['result']['record']['video_id']; ?>
','<?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['pg']; ?>
')" value="<?php echo $this->_tpl_vars['LANG']['preview_this_video']; ?>
" />
                            
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                    </table>
                </td>
                <td>
                    <table>
                    <tr>
                        <td class="clsPreviewPopup">
                            <div id="slideShowBlock_<?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['pg']; ?>
">
                            </div>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            </table>
			</div>
            <div id="selNextPrev" class="clsPopUpPrevNext clsOverflow">
                <input type="button" <?php if ($this->_tpl_vars['myobj']->tagRelatedVideo['leftButtonExist']): ?> onclick="moveVideoSetToLeft_res(this, '<?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['pg']; ?>
')" <?php endif; ?>                 value="" id="videoPrevButton_<?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['pg']; ?>
" class="clsPrevButton <?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['leftButtonClass']; ?>
"/>
                <input type="button" <?php if ($this->_tpl_vars['myobj']->tagRelatedVideo['rightButtonExists']): ?> onclick="moveVideoSetToRight_res(this, '<?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['pg']; ?>
')" <?php endif; ?> value="" 
                id="videoNextButton_<?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['pg']; ?>
" class="clsNextButton <?php echo $this->_tpl_vars['myobj']->tagRelatedVideo['rightButtonClass']; ?>
" />
            </div>
        </div>
        </form>
<?php else: ?>
    <div class="selVideoDisp">
        <div class="clsNoDatas">
                <p><?php echo $this->_tpl_vars['LANG']['no_related_videos_found']; ?>

                </p>
        </div>
    </div>
<?php endif; ?>
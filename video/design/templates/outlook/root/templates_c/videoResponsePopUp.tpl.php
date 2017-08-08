<?php /* Smarty version 2.6.18, created on 2012-02-17 06:23:42
         compiled from videoResponsePopUp.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'videoResponsePopUp.tpl', 18, false),)), $this); ?>
<?php if (isAjax ( )): ?>
<div class="clsVideoResponsePopup">
<?php endif; ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('msg_form_error')): ?>
<div id="selMsgError">
     <p><?php echo $this->_tpl_vars['myobj']->getCommonErrorMsg(); ?>
</p>
</div>
<?php endif; ?>
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupvideo_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('videoMainBlock')): ?>
<div id="selVideoResponsePopUp">
	<div class="clsOverflow clsPopUpWindowHeadingContainer">
        <div class="clsVideoHeading clsPopUpWindowHeading">
        <h2><?php echo $this->_tpl_vars['LANG']['video_resp_title']; ?>
</h2>
        </div>
        <!--<div class="clsVideoPaging clsCloseWindowContainer">
            <input type="button" class="clsCloseWindow" name="no" id="no" title="<?php echo $this->_tpl_vars['LANG']['no_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onClick="return hideAllBlocks()" />
        </div>-->
    </div>
    <table><tr><td>
    <table>
        <tr>
            <td class="clsPopupVideoImage">
				<p id="selImageBorder">
					<a href="<?php echo $this->_tpl_vars['myobj']->videoDetail['videoLink']; ?>
">
						<img src="<?php echo $this->_tpl_vars['myobj']->videoDetail['imageSrc']; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->getFormField('video_title|truncate:10'); ?>
" <?php echo $this->_tpl_vars['myobj']->videoDetail['disp_image']; ?>
 />
					</a>
				</p>
            </td>
            <td class="clsPopupVideoImageDetails">
            	<p><?php echo $this->_tpl_vars['LANG']['video_resp_resp_to']; ?>
</p>
                <p>
                    <a href="<?php echo $this->_tpl_vars['myobj']->videoDetail['videoLink']; ?>
">
	                    <?php echo $this->_tpl_vars['myobj']->video_title_wordWrap; ?>

                    </a>
				</p>
            </td>
        </tr>
    </table>
    </td></tr></table>
    <a href="#" id="anchor"></a>
    	<div class="clsOverflow">
	<div class="clsFloatLeft">
<!--    <div class="clsIndexLinkMiddle">
        <div class="clsIndexLinkRight">
            <div class="clsIndexLinkLeft"> -->
                <div id="">
                    <ul class="clsMoreVideosNav">
                        <li class="clsActiveIndexLink clsFirstLink clsActiveFirstLink" id="selHeaderVideoUser_res">                            
                          <span><a class="" href="javascript:void(0)" onClick="hideDiv('selRelatedContent_res');hideDiv('selTopContent_res');showDiv('selUserContent_res'); 
                          setClass('selHeaderVideoUser_res','clsFirstLink clsActiveIndexLink clsActiveFirstLink');setClass('selHeaderVideoRel_res','');
                          setClass('selHeaderVideoTop_res','');return false;"><?php echo $this->_tpl_vars['LANG']['view_videos_more_my_videos']; ?>
</a></span></li>
                        <li id="selHeaderVideoRel_res">                            
                          <span><a href="javascript:void(0)" onClick="hideDiv('selUserContent_res');hideDiv('selTopContent_res');showDiv('selRelatedContent_res'); 
                          setClass('selHeaderVideoUser_res','clsFirstLink');setClass('selHeaderVideoRel_res','clsActiveIndexLink');
                          setClass('selHeaderVideoTop_res',''); return false;"><?php echo $this->_tpl_vars['LANG']['view_videos_more_videos_my_fav']; ?>
</a></span></li>
                        <li id="selHeaderVideoTop_res">                            
                           <span><a href="javascript:void(0)" onClick="hideDiv('selUserContent_res');hideDiv('selRelatedContent_res'); 
                          setClass('selHeaderVideoUser_res','clsFirstLink');setClass('selHeaderVideoRel_res','');
                          setClass('selHeaderVideoTop_res','clsActiveIndexLink'); showDiv('selTopContent_res'); return false;"><?php echo $this->_tpl_vars['LANG']['view_videos_more_qucick_capture']; ?>
</a></span></li>
                    </ul>
              <!--  </div>
            </div>
        </div> -->
	</div>
	</div>
	</div>
	    <div id="clsMoreVideosContent_res" class="clsMoreVideosContent_res clsOverflow">
		<div class="clsTopContent" id="selTopContent_res" style="display:none">
            <form name="quickCaptureForm" id="quickCaptureform" method="post" action="<?php echo $this->_tpl_vars['myobj']->quickCaptureUrl; ?>
">
            <input type="hidden" name="use_vid" value="<?php echo $this->_tpl_vars['myobj']->getFormField('video_id'); ?>
" />
            <div class="clsNoDatas">
            	<p><?php echo $this->_tpl_vars['LANG']['use_this_link_video_response']; ?>
</p>
			</div>
            <p><input class="clsVideoCaptureButton" type="submit" name="video_upload_submit" id="video_upload_submit" value="<?php echo $this->_tpl_vars['LANG']['upload_capture_video']; ?>
" /></p>
            
            </form>
        </div>
    </div>
	    
        <div class="clsRelatedContent" id="selRelatedContent_res"  style="display:none">
       <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('members/','video'); ?>

 		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'selRelatedContent_res.tpl', 'smarty_include_vars' => array('opt' => '')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
	   
    
         <div class="clsUserContent" id="selUserContent_res">
     	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('members/','video'); ?>

 		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'selUserContent_res.tpl', 'smarty_include_vars' => array('opt' => '')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
    </div>
<?php endif; ?>
<?php if (isAjax ( )): ?>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupvideo_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php endif; ?>
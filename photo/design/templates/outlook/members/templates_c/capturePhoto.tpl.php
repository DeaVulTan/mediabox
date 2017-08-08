<?php /* Smarty version 2.6.18, created on 2011-10-17 14:53:22
         compiled from capturePhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'capturePhoto.tpl', 51, false),)), $this); ?>
<?php if (isAjaxPage ( )): ?>	
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_capture_form')): ?> 
	<div class="clsStepsBg">
        <div class="clsStepOneLeft">
        	<div class="clsStepOneRight">
                <span><?php echo $this->_tpl_vars['LANG']['photoupload_step']; ?>
:<strong> <?php echo $this->_tpl_vars['LANG']['photoupload_step_info']; ?>
</strong></span>
            </div>
        </div>       
    </div>
    
	<div class="clsEmptyProgressBar">
        <h3><?php echo $this->_tpl_vars['LANG']['photoupload_external_upload']; ?>
</h3>
    </div>
    <div class="clsPhotoListMenu">
    <div class="clsFieldContainer clsNotesDesgin">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div class="clsNote">
          <span class="clsNotes"><?php echo $this->_tpl_vars['LANG']['common_photo_note']; ?>
: </span>
          <div class="clsNotesDet">
              <div class="clsMaxUpload">
                <p>[<?php echo $this->_tpl_vars['LANG']['photoupload_max_file_size']; ?>
:&nbsp;<?php echo $this->_tpl_vars['CFG']['admin']['photos']['max_size']; ?>
&nbsp;<?php echo $this->_tpl_vars['LANG']['common_megabyte']; ?>
]</p>
                <p>[<?php echo $this->_tpl_vars['LANG']['photoupload_allowed_formats']; ?>
:&nbsp;<?php echo $this->_tpl_vars['myobj']->photo_format; ?>
]</p>
                <p>[<?php echo $this->_tpl_vars['LANG']['photoupload_external_upload_info']; ?>
:&nbsp;http://www.example.com/test/test.jpg]</p>
			</div>
          </div>
        </div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>

    </div>
    
    
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="selEditPersonalProfile">
        <div>
            <h2><?php echo $this->_tpl_vars['LANG']['profileavatar_title_basic']; ?>
</h2>
        </div>
  		<div id="selLeftNavigation">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
			  <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
				<p id="confirmMessage"></p>
					<!-- clsFormSection - starts here -->
				<table>
				 <tr>
                    <td class="clsFormLabelCellDefault">
                      <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                      &nbsp;
                      <input type="button" class="clsSubmitButton clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
                      <input type="hidden" name="action" />
                    </td>
                  </tr>
                </table>
				<!-- clsFormSection - ends here -->
			  </form>
			</div> 
     	<div class="clsDataTable" align="center"><p id='avatarChange'></p></div> 
     	<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">    
            <div class="clsMugshotContainer">
		    	<div class="clsOverflow">
        			<div class="">
            			<p><?php echo $this->_tpl_vars['LANG']['profileavatar_captured_images_desc']; ?>
</p>
        		    </div>
	        		
					
		        </div>
				<div id="displayLoderImage" style="display:none"> </div>                           
						
        		<div class="clsMugShot clsOverflow">
                  
                        <div class="clsMugShotCapture">
                            <?php if ($this->_tpl_vars['myobj']->mugshotVersion == 'mugshot_lite'): ?>
                                <embed src="<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
index_new.swf?xmlfile=<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
config.xml&xmlfiletype=Default&licensexml=<?php echo $this->_tpl_vars['myobj']->mugshotLicensePath; ?>
license.xml&licensephp=<?php echo $this->_tpl_vars['myobj']->mugshotLicensePath; ?>
flashLicense.php&imageFolderPath=<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
images"quality="high" bgcolor="#ffffff" width="482"height="442" name="SnapShot" align="middle" allowScriptAccess="sameDomain" wmode="transparent" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
							<?php elseif ($this->_tpl_vars['myobj']->mugshotVersion == 'mugshot_pro'): ?>
								<iframe src="<?php echo $this->_tpl_vars['CFG']['site']['photo_url']; ?>
members/capturePhotoAjax.php" height="500px" width="600px" frameborder="0"></iframe>
				
							 
                            <?php endif; ?>
                            <!--img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/screen_grey/mugshot.gif" /-->
                        </div>
                        <div id="displayProfileImage" style="float:right">                            
						</div>
						<div>
							<input type="hidden" value="Capture" name="photo_upload_type"/>
							<!--input id="upload_photo_capture" type="submit" disabled="disabled" value="Next" tabindex="1005" name="upload_photo_capture"/-->
						</div>
                </div>
            </div>
          </form>
            </div>
         <?php endif; ?>			
           </div>
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'fieldset_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_photoupload_capture_form')): ?> 
	<div class="clsStepsBg">
        <div class="clsStepOneLeft">
        	<div class="clsStepOneRight">
                <span><?php echo $this->_tpl_vars['LANG']['photoupload_step']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['photoupload_step_info']; ?>
</strong></span>
            </div>
       </div>
       <div class="clsStepDisableLeft">
        	<div class="clsStepDisableRight">
     	 	  <span><?php echo $this->_tpl_vars['LANG']['photoupload_step2']; ?>
: <strong><?php echo $this->_tpl_vars['LANG']['photoupload_step2_info']; ?>
</strong></span>
           </div>
        </div>
    </div>
    
	<div class="clsEmptyProgressBar">
        <h3><?php echo $this->_tpl_vars['LANG']['photoupload_external_upload']; ?>
</h3>
    </div>
    
	<div id="selEditPersonalProfile">
        <div class="clsStepsBg">
            <div class="clsPhotoListMenu">
                <div class="clsFieldContainer clsNotesDesgin">
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    <div class="clsNote">
                      <span class="clsNotes"><?php echo $this->_tpl_vars['LANG']['common_photo_note']; ?>
: </span>
                      <div class="clsNotesDet">
                           <p><?php echo $this->_tpl_vars['LANG']['profileavatar_title_basic']; ?>
</p>
                           <p><?php echo $this->_tpl_vars['LANG']['profileavatar_captured_images_desc']; ?>
</p>
                      </div>
                    </div>
                <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'notesupload_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                </div>
       		 </div>
        </div>
  		<div id="selLeftNavigation">
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

 	  		 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			  <form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(true); ?>
">
				<p id="confirmMessage"></p>
					<!-- clsFormSection - starts here -->
				<table>
				 <tr>
                    <td class="clsFormLabelCellDefault">
                      <input type="submit" class="clsPopUpButtonSubmit" name="confirm" id="confirm" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
                      &nbsp;
                      <input type="button" class="clsPopUpButtonReset" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
                      <input type="hidden" name="action" />
                    </td>
                  </tr>
                </table>
				<!-- clsFormSection - ends here -->
			  </form>
			  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

             <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'popupbox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
			</div> 
     	<div class="clsDataTable" align="center"><p id='avatarChange'></p></div> 
     	<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">    
            <div class="clsMugshotContainer">
				<div id="displayLoderImage" style="display:none"> </div>  
        		<div class="clsMugShot clsOverflow">
                        <div class="clsMugShotCapture">
                            <?php if ($this->_tpl_vars['myobj']->mugshotVersion == 'mugshot_lite'): ?>
                                <embed src="<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
index_new.swf?xmlfile=<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
config.xml&xmlfiletype=Default&licensexml=<?php echo $this->_tpl_vars['myobj']->mugshotLicensePath; ?>
license.xml&licensephp=<?php echo $this->_tpl_vars['myobj']->mugshotLicensePath; ?>
flashLicense.php&imageFolderPath=<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
images"quality="high" bgcolor="#ffffff" width="482"height="442" name="SnapShot" align="middle" allowScriptAccess="sameDomain" wmode="transparent" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
							<?php elseif ($this->_tpl_vars['myobj']->mugshotVersion == 'mugshot_pro'): ?>
                            	<script type="text/javascript" src="<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
swfobject.js"></script>
								<script type="text/javascript">
									var flashvars = <?php echo '{'; ?>
<?php echo '}'; ?>
;
									flashvars.filePath = "<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
config.xml";
									flashvars.swfPath = "<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
webcamEffects_watermark_40.swf";
									flashvars.licensexml = "<?php echo $this->_tpl_vars['myobj']->mugshotLicensePath; ?>
license.xml";
									flashvars.licensephp = "<?php echo $this->_tpl_vars['myobj']->mugshotLicensePath; ?>
flashLicense.php";
									flashvars.imagesDirectory = "<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
images";			
									var params = <?php echo '{'; ?>
<?php echo '}'; ?>
;
									params.wmode = "transparent";
									var attributes = <?php echo '{'; ?>
<?php echo '}'; ?>
;
									swfobject.embedSWF("<?php echo $this->_tpl_vars['myobj']->mugshotPath; ?>
preloader.swf", "flashDiv", "482", "423", "9.0.0", false, flashvars, params, attributes);
								</script>
                                <div id="flashDiv">
                                    <a href="http://www.adobe.com/go/getflashplayer">
                                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                                    </a>
                                </div>
                            <?php endif; ?>
                            <!--img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/screen_grey/mugshot.gif" /-->
                        </div>
                        <div id="displayProfileImage" style="float:right">                            
						</div>
						<div>
							<input type="hidden" value="Capture" name="photo_upload_type"/>
							<!--input id="upload_photo_capture" type="submit" disabled="disabled" value="Next" tabindex="1005" name="upload_photo_capture"/-->
						</div>
                </div>
            </div>
          </form>
            </div>
         <?php endif; ?>			
           </div>
<?php endif; ?>
      
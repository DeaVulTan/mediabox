{if isAjaxPage()}	
	{if $myobj->isShowPageBlock('block_photoupload_capture_form')} 
	<div class="clsStepsBg">
        <div class="clsStepOneLeft">
        	<div class="clsStepOneRight">
                <span>{$LANG.photoupload_step}:<strong> {$LANG.photoupload_step_info}</strong></span>
            </div>
        </div>       
    </div>
    
	<div class="clsEmptyProgressBar">
        <h3>{$LANG.photoupload_external_upload}</h3>
    </div>
    <div class="clsPhotoListMenu">
    <div class="clsFieldContainer clsNotesDesgin">
	{$myobj->setTemplateFolder('general/', 'photo')}
    {include file="box.tpl" opt="notesupload_top"}
        <div class="clsNote">
          <span class="clsNotes">{$LANG.common_photo_note}: </span>
          <div class="clsNotesDet">
              <div class="clsMaxUpload">
                <p>[{$LANG.photoupload_max_file_size}:&nbsp;{$CFG.admin.photos.max_size}&nbsp;{$LANG.common_megabyte}]</p>
                <p>[{$LANG.photoupload_allowed_formats}:&nbsp;{$myobj->photo_format}]</p>
                <p>[{$LANG.photoupload_external_upload_info}:&nbsp;http://www.example.com/test/test.jpg]</p>
			</div>
          </div>
        </div>
	{$myobj->setTemplateFolder('general/', 'photo')}
    {include file="box.tpl" opt="notesupload_bottom"}
    </div>

    </div>
    
    
	{$myobj->setTemplateFolder('general/', 'photo')}
    {include file="box.tpl" opt="fieldset_top"}
	<div id="selEditPersonalProfile">
        <div>
            <h2>{$LANG.profileavatar_title_basic}</h2>
        </div>
  		<div id="selLeftNavigation">
		{$myobj->setTemplateFolder('general/', 'photo')}
		{include file='information.tpl'}
			<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
			  <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
				<p id="confirmMessage"></p>
					<!-- clsFormSection - starts here -->
				<table>
				 <tr>
                    <td class="clsFormLabelCellDefault">
                      <input type="submit" class="clsSubmitButton" name="confirm" id="confirm" value="{$LANG.common_confirm}" tabindex="{smartyTabIndex}" />
                      &nbsp;
                      <input type="button" class="clsSubmitButton clsCancelButton" name="cancel" id="cancel" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
                      <input type="hidden" name="action" />
                    </td>
                  </tr>
                </table>
				<!-- clsFormSection - ends here -->
			  </form>
			</div> 
     	<div class="clsDataTable" align="center"><p id='avatarChange'></p></div> 
     	<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">    
            <div class="clsMugshotContainer">
		    	<div class="clsOverflow">
        			<div class="">
            			<p>{$LANG.profileavatar_captured_images_desc}</p>
        		    </div>
	        		
					
		        </div>
				<div id="displayLoderImage" style="display:none"> </div>                           
						
        		<div class="clsMugShot clsOverflow">
                  
                        <div class="clsMugShotCapture">
                            {if $myobj->mugshotVersion == 'mugshot_lite'}
                                <embed src="{$myobj->mugshotPath}index_new.swf?xmlfile={$myobj->mugshotPath}config.xml&xmlfiletype=Default&licensexml={$myobj->mugshotLicensePath}license.xml&licensephp={$myobj->mugshotLicensePath}flashLicense.php&imageFolderPath={$myobj->mugshotPath}images"quality="high" bgcolor="#ffffff" width="482"height="442" name="SnapShot" align="middle" allowScriptAccess="sameDomain" wmode="transparent" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
							{elseif $myobj->mugshotVersion == 'mugshot_pro'}
								<iframe src="{$CFG.site.photo_url}members/capturePhotoAjax.php" height="500px" width="600px" frameborder="0"></iframe>
				
							 
                            {/if}
                            <!--img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/screen_grey/mugshot.gif" /-->
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
         {/if}			
           </div>
	{$myobj->setTemplateFolder('general/', 'photo')}
    {include file="box.tpl" opt="fieldset_bottom"}
{else}
	{if $myobj->isShowPageBlock('block_photoupload_capture_form')} 
	<div class="clsStepsBg">
        <div class="clsStepOneLeft">
        	<div class="clsStepOneRight">
                <span>{$LANG.photoupload_step}: <strong>{$LANG.photoupload_step_info}</strong></span>
            </div>
       </div>
       <div class="clsStepDisableLeft">
        	<div class="clsStepDisableRight">
     	 	  <span>{$LANG.photoupload_step2}: <strong>{$LANG.photoupload_step2_info}</strong></span>
           </div>
        </div>
    </div>
    
	<div class="clsEmptyProgressBar">
        <h3>{$LANG.photoupload_external_upload}</h3>
    </div>
    
	<div id="selEditPersonalProfile">
        <div class="clsStepsBg">
            <div class="clsPhotoListMenu">
                <div class="clsFieldContainer clsNotesDesgin">
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_top"}
                    <div class="clsNote">
                      <span class="clsNotes">{$LANG.common_photo_note}: </span>
                      <div class="clsNotesDet">
                           <p>{$LANG.profileavatar_title_basic}</p>
                           <p>{$LANG.profileavatar_captured_images_desc}</p>
                      </div>
                    </div>
                {$myobj->setTemplateFolder('general/', 'photo')}
                {include file="box.tpl" opt="notesupload_bottom"}
                </div>
       		 </div>
        </div>
  		<div id="selLeftNavigation">
		{$myobj->setTemplateFolder('general/', 'photo')}
		{include file='information.tpl'}
			<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
            {$myobj->setTemplateFolder('general/','photo')}
 	  		 {include file='box.tpl' opt='popupbox_top'}
			  <form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
				<p id="confirmMessage"></p>
					<!-- clsFormSection - starts here -->
				<table>
				 <tr>
                    <td class="clsFormLabelCellDefault">
                      <input type="submit" class="clsPopUpButtonSubmit" name="confirm" id="confirm" value="{$LANG.common_confirm}" tabindex="{smartyTabIndex}" />
                      &nbsp;
                      <input type="button" class="clsPopUpButtonReset" name="cancel" id="cancel" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
                      <input type="hidden" name="action" />
                    </td>
                  </tr>
                </table>
				<!-- clsFormSection - ends here -->
			  </form>
			  {$myobj->setTemplateFolder('general/','photo')}
             {include file='box.tpl' opt='popupbox_bottom'} 
			</div> 
     	<div class="clsDataTable" align="center"><p id='avatarChange'></p></div> 
     	<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">    
            <div class="clsMugshotContainer">
				<div id="displayLoderImage" style="display:none"> </div>  
        		<div class="clsMugShot clsOverflow">
                        <div class="clsMugShotCapture">
                            {if $myobj->mugshotVersion == 'mugshot_lite'}
                                <embed src="{$myobj->mugshotPath}index_new.swf?xmlfile={$myobj->mugshotPath}config.xml&xmlfiletype=Default&licensexml={$myobj->mugshotLicensePath}license.xml&licensephp={$myobj->mugshotLicensePath}flashLicense.php&imageFolderPath={$myobj->mugshotPath}images"quality="high" bgcolor="#ffffff" width="482"height="442" name="SnapShot" align="middle" allowScriptAccess="sameDomain" wmode="transparent" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
							{elseif $myobj->mugshotVersion == 'mugshot_pro'}
                            	<script type="text/javascript" src="{$myobj->mugshotPath}swfobject.js"></script>
								<script type="text/javascript">
									var flashvars = {literal}{{/literal}{literal}}{/literal};
									flashvars.filePath = "{$myobj->mugshotPath}config.xml";
									flashvars.swfPath = "{$myobj->mugshotPath}webcamEffects_watermark_40.swf";
									flashvars.licensexml = "{$myobj->mugshotLicensePath}license.xml";
									flashvars.licensephp = "{$myobj->mugshotLicensePath}flashLicense.php";
									flashvars.imagesDirectory = "{$myobj->mugshotPath}images";			
									var params = {literal}{{/literal}{literal}}{/literal};
									params.wmode = "transparent";
									var attributes = {literal}{{/literal}{literal}}{/literal};
									swfobject.embedSWF("{$myobj->mugshotPath}preloader.swf", "flashDiv", "482", "423", "9.0.0", false, flashvars, params, attributes);
								</script>
                                <div id="flashDiv">
                                    <a href="http://www.adobe.com/go/getflashplayer">
                                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                                    </a>
                                </div>
                            {/if}
                            <!--img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/screen_grey/mugshot.gif" /-->
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
         {/if}			
           </div>
{/if}
{*<!--#############	CAPTURE PHOTO UPLOAD FORM ENDS  HERE     #############-->*}      
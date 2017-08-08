{if !isAjaxPage()}
	{$myobj->setTemplateFolder('general/')}
	{include file='box.tpl' opt='display_top'}
	<div id="selEditPersonalProfile">
    	<div class="clsPageHeading">
        	<h2>{$LANG.profileavatar_title_basic}</h2>
        </div>
	  	<div id="selLeftNavigation">
			{$myobj->setTemplateFolder('general/')}
			{include file='information.tpl'}
			<div id="selMsgConfirm" class="clsPopupAlert" style="display:none;">
	        	{$myobj->setTemplateFolder('general/')}
	 			{include file='box.tpl' opt='popupbox_top'}
				<form name="msgConfirmform" id="msgConfirmform" method="post" action="{$myobj->getCurrentUrl(true)}">
				<p id="confirmMessage"></p>
				<!-- clsFormSection - starts here -->
					<input type="submit" class="clsPopUpButtonSubmit" name="confirm" id="confirm" value="{$LANG.common_confirm}" tabindex="{smartyTabIndex}" />&nbsp;
					<input type="button" class="clsPopUpButtonReset" name="cancel" id="cancel" value="{$LANG.common_cancel}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks();" />
	                <input type="hidden" name="action" />
				<!-- clsFormSection - ends here -->
				</form>
	     		{include file='box.tpl' opt='popupbox_bottom'}
	   		</div>
{/if}
{if !isAjaxPage()}
	{if $myobj->isShowPageBlock('form_editprofile')}
    	<div class="clsDataTable" align="center"><p id='avatarChange'></p></div>
     		<form name="selFormEditPersonalProfile" id="selFormEditPersonalProfile" enctype="multipart/form-data" method="post" action="{$myobj->getCurrentUrl()}" autocomplete="off">
            	<div class="clsMugshotContainer">
		    		<div class="clsOverflow">
        				<div class="clsMugshotContent">
            				<p>{$LANG.profileavatar_captured_images_desc} <br /><strong>Note:-</strong>{$myobj->profileavatar_note}</p>
                        	<p><strong>{$myobj->profileavatar_upload_images}</strong></p>
        		    	</div>
	        			<div class="clsCurrentAvatarImage" id="displayProfileImage">
							{if $noimage =='No'}
		            			<p><a onClick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('action', 'confirmMessage'), Array('delete_avatar', '{$LANG.profileavatar_delete_confirmation}'), Array('value', 'innerHTML'))">{$LANG.profileavatar_delete_image}</a></p>
							{/if}
        		         	<div class="ClsImageContainer ClsImageBorder2 Cls90x90">
								<img src="{$myobj->icon.t_url}?{php}echo time(){/php}" alt="{$CFG.user.user_name|truncate:9}" title="{$CFG.user.user_name}" border="0"
								{$myobj->DISP_IMAGE(#image_thumb_width#, #image_thumb_height#, $myobj->icon.t_width, $myobj->icon.t_height)}/>
							</div>
        		    	</div>
		        	</div>
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
                        <div class="clsProfileAvatarImages" style="float:right">
                        	<div class="clsCapturedImages">
                            	<div class="clsCaptureImagesHeadingLeft">
                                	<div class="clsCaptureImagesHeadingRight">
                                    	{$LANG.profileavatar_captured_images}
                                    </div>
                                </div>
                               	<div id="camImagesProcess"></div>
                                <div class="clsMugShotCapturedImages" id="camImages">

		{/if}
{/if}
{if isAjaxPage()}
	{if $capture_images != ''}
    	<div class="ClsRecentVisitorCarouselContainer">
     		<div class="ClsRecentVisitorCarousel">
     			<ul id="carouselMughsotCapturedImages" class="jcarousel-skin-tango">
            		{foreach key=inc item=capturedImages from=$capture_images}
               			<li>
                			{if $capturedImages.imageSrc}
	                    		<div class="cls66PXthumbImage clsThumbImageOuter">
	                        		<div class="clsrThumbImageMiddle">
	                            		<div class="clsThumbImageInner">
	                                		<img src="{$capturedImages.imageSrc}"  onclick="makeProfileImage('{$capturedImages.profile_cam_image_id}','{$capturedImages.profile_image_name}','{$capturedImages.profile_image_extension}')"/>
	                            		</div>
	                        		</div>
	                    		</div>
	                    		<div class="clsMaxCapturedImage" id="profileImageEdit_{$capturedImages.profile_cam_image_id}">
	                        		<a href="javascript:void(0);" onclick="javascript: myLightWindow.activateWindow( {literal} { {/literal} type:'external',href:'{$capturedImages.imageLargeSrc}',title:'Captured Images',width:480,height:360 {literal} } {/literal} );"
	                                    title="Maximize">
	                                <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/bg-Maxcapturedimage.jpg" />
	                            	</a>
	                    		</div>
	                    		<div class="clsDeleteCapturedImage" id="profileImageDel_{$capturedImages.profile_cam_image_id}">
	                            	<a onclick="deleteImage('{$capturedImages.profile_cam_image_id}','{$capturedImages.profile_image_name}');" title="Delete">
	                                	<img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/{$CFG.html.stylesheet.screen.default}/bg-deletecapturedimage.gif" />
	                            	</a>
	                    		</div>
                			{/if}
               			</li>
            		{/foreach}
        		</ul>
      		</div>
     	</div>
        {literal}
	        <script type="text/javascript">
	        // <![CDATA[
	          	jQuery(document).ready(function() {
			    jQuery('#carouselMughsotCapturedImages').jcarousel({
			        vertical: true,
			        scroll: 2
			    });
			});
	        // ]]>
	        </script>
    	{/literal}
    {/if}
{/if}
{if !isAjaxPage()}
	</div>
	<div id="nav_capturedImages" class="clsMugShotPaging"></div>
    </div>
    </div>
</div>
</div>
</form>
</div>
</div>
{include file='box.tpl' opt='display_bottom'}
{/if}

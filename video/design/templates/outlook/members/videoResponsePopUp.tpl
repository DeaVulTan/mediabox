{if isAjax()}
<div class="clsVideoResponsePopup">
{/if}
{if $myobj->isShowPageBlock('msg_form_error')}
<div id="selMsgError">
     <p>{$myobj->getCommonErrorMsg()}</p>
</div>
{/if}
{$myobj->setTemplateFolder('general/')}
 {include file='box.tpl' opt='popupvideo_top'}
{if $myobj->isShowPageBlock('videoMainBlock')}
<div id="selVideoResponsePopUp">
	<div class="clsOverflow clsPopUpWindowHeadingContainer">
        <div class="clsVideoHeading clsPopUpWindowHeading">
        <h2>{$LANG.video_resp_title}</h2>
        </div>
        <!--<div class="clsVideoPaging clsCloseWindowContainer">
            <input type="button" class="clsCloseWindow" name="no" id="no" title="{$LANG.no_cancel}" tabindex="{smartyTabIndex}" onClick="return hideAllBlocks()" />
        </div>-->
    </div>
    <table><tr><td>
    <table>
        <tr>
            <td class="clsPopupVideoImage">
				<p id="selImageBorder">
					<a href="{$myobj->videoDetail.videoLink}">
						<img src="{$myobj->videoDetail.imageSrc}" alt="{$myobj->getFormField('video_title|truncate:10')}" {$myobj->videoDetail.disp_image} />
					</a>
				</p>
            </td>
            <td class="clsPopupVideoImageDetails">
            	<p>{$LANG.video_resp_resp_to}</p>
                <p>
                    <a href="{$myobj->videoDetail.videoLink}">
	                    {$myobj->video_title_wordWrap}
                    </a>
				</p>
            </td>
        </tr>
    </table>
    </td></tr></table>
    <a href="#" id="anchor"></a>
    {* Response Video Menu *}
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
                          setClass('selHeaderVideoTop_res','');return false;">{$LANG.view_videos_more_my_videos}</a></span></li>
                        <li id="selHeaderVideoRel_res">                            
                          <span><a href="javascript:void(0)" onClick="hideDiv('selUserContent_res');hideDiv('selTopContent_res');showDiv('selRelatedContent_res'); 
                          setClass('selHeaderVideoUser_res','clsFirstLink');setClass('selHeaderVideoRel_res','clsActiveIndexLink');
                          setClass('selHeaderVideoTop_res',''); return false;">{$LANG.view_videos_more_videos_my_fav}</a></span></li>
                        <li id="selHeaderVideoTop_res">                            
                           <span><a href="javascript:void(0)" onClick="hideDiv('selUserContent_res');hideDiv('selRelatedContent_res'); 
                          setClass('selHeaderVideoUser_res','clsFirstLink');setClass('selHeaderVideoRel_res','');
                          setClass('selHeaderVideoTop_res','clsActiveIndexLink'); showDiv('selTopContent_res'); return false;">{$LANG.view_videos_more_qucick_capture}</a></span></li>
                    </ul>
              <!--  </div>
            </div>
        </div> -->
	</div>
	</div>
	</div>
	{* Quick Capture Begins *}
    <div id="clsMoreVideosContent_res" class="clsMoreVideosContent_res clsOverflow">
		<div class="clsTopContent" id="selTopContent_res" style="display:none">
            <form name="quickCaptureForm" id="quickCaptureform" method="post" action="{$myobj->quickCaptureUrl}">
            <input type="hidden" name="use_vid" value="{$myobj->getFormField('video_id')}" />
            <div class="clsNoDatas">
            	<p>{$LANG.use_this_link_video_response}</p>
			</div>
            <p><input class="clsVideoCaptureButton" type="submit" name="video_upload_submit" id="video_upload_submit" value="{$LANG.upload_capture_video}" /></p>
            
            </form>
        </div>
    </div>
	{* Quick Capture ends *}
    
    {* Tag Related Video begins*}
    <div class="clsRelatedContent" id="selRelatedContent_res"  style="display:none">
       {$myobj->setTemplateFolder('members/', 'video')}
 		{include file='selRelatedContent_res.tpl' opt=''}
    </div>
	{* Tag Related Video ends*}   
    
    {* User Related Video begins*}
     <div class="clsUserContent" id="selUserContent_res">
     	{$myobj->setTemplateFolder('members/', 'video')}
 		{include file='selUserContent_res.tpl' opt=''}
    </div>
    {* User Related Video ends*}
</div>
{/if}
{if isAjax()}
	{$myobj->setTemplateFolder('general/')}
	{include file='box.tpl' opt='popupvideo_bottom'}
</div>
{/if}
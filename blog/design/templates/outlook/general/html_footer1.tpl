{if $header->chkIsProfilePage()}
</div>
{/if}

<!-- Main  ends-->
</div>
</div>
<!--body content ends-->
</div>
</div>
</div>
<!-- Footer starts -->
<div id="footer">
	<div class="clsFooterMidddleBG">
        <div class="clsFooterContentBG">
            <div class="clsFooterCenterBg">
                <div class="clsFooterRightBG">
                    <div class="clsFooterLeftBG">
                        <div class="clsFooterContent">
                            {*CONFIRMATION BOX FOR NAVIGATING TO LOGIN PAGE FOR NON MEMBERS STARTS HERE*}
                                <div id="selMsgLoginConfirmMulti" class="clsPopupConfirmation" style="display:none;">
                                    <p id="selAlertLoginMessage"></p>
                                    <form name="msgConfirmformMulti1" id="msgConfirmformMulti1" method="post" action="">
                                    <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
                                    <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
                                    </form>
                                </div>
                            {*CONFIRMATION BOX FOR NAVIGATING TO LOGIN PAGE FOR NON MEMBERS ENDS HERE*}
                            {*CONFIRMATION BOX STARTS HERE*}
                                <div id="selMsgConfirmCommon" class="clsPopupConfirmation clsSubscriptionConfirm" style="display:none;">
                                    <div id="msgConfirmTextCommon"></div>
                                    <form name="msgConfirmformCommon" id="msgConfirmformCommon" method="post" action="{$myobj->getCurrentUrl()}">
                                    <input type="submit" class="clsSubmitButton" name="common_confirm_yes" id="common_confirm_yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" /> &nbsp;
                                    <input type="button" class="clsSubmitButton" name="common_confirm_no" id="common_confirm_no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hideAllBlocks()" />
                                    <input type="hidden" name="action" id="action" />
                                    </form>
                                </div>
                            {*CONFIRMATION BOX ENDS HERE*}                            
                           
                            
                            <div id="selSubFooter"> 
                                <h2><span>{$LANG.header_miscellanious_nav_links}</span></h2>
                            </div>
                            
                            <div class="clsFooterContentList">
                                    {if $header->headerBlock.is_footer_links}
                                        {foreach key=k  item=footermodule from=$header->headerBlock.footer_module_links_arr}
                                            <ul>
                                                <li><h2>{$footer_module_head_arr.$k}</h2></li>
                                                {foreach key=item item=footerlink from=$footermodule}
                                                    {if $footerlink}
                                                        <li><a href="{$footerlink.link_url}">{$footerlink.link_name|capitalize}</a></li>
                                                    {/if}
                                                {/foreach}
                                            </ul>
                                        {/foreach}
                                    {/if}

                                    <ul>
                                        <li><h2>{$LANG.header_title_help_info}</h2></li>
                                        <li><a href="{$header->getUrl('static', '?pg=faq', 'faq/', '')}">{$LANG.header_title_help_center}</a></li>
                                        <li><a href="{$header->getUrl('contactus')}">{$LANG.header_contact}</a></li>
                                        <li><a href="{$header->getUrl('reportbugs')}">{$LANG.header_reportbugs}</a></li>
                                    </ul>
                                    <ul>
                                        <li><h2>{$LANG.header_terms_legal_terms}</h2></li>
                                        <li><a href="{$header->getUrl('static', '?pg=useterms', 'useterms/', '')}">{$LANG.header_terms_of_use_link}</a></li>
                                        <li><a href="{$header->getUrl('static', '?pg=privacy', 'privacy/', '')}">{$LANG.header_privacy_policy_link}</a></li>
                                        <li><a href="{$header->getUrl('static', '?pg=prohibitedcontent', 'prohibitedcontent/', '')}">{$LANG.header_prohibited_content}</a></li>
                                        <li><a href="{$header->getUrl('static', '?pg=copyright', 'copyright/', '')}">{$LANG.header_copyright_notification}</a></li>
                                    </ul>


                            </div>
                            
                            <div class="clsCopyrightContent">
                                <span class="clsCopyrightLogo">&copy; {$CFG.admin.coppy_rights_year} {$CFG.site.name}. {$LANG.header_allrights_reserved}.</span>
                                <span class="clsPoweredText">{$LANG.header_powered_by} <a href="{$CFG.dev.url}">{$CFG.dev.name}</a></span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer ends -->

<!-- selpagebody ends-->


<!--bodybackground ends-->
</div>

{php}if(isset($this->bodyBackgroundImage) && $this->bodyBackgroundImage){{/php}
</div>
{php}}{/php}

{* end tag - Profile page background applied by member -start *}
{if $myobj->profile_background}
</div>
{/if}
{* end tag - Profile page background applied by member -end *}

{* Hack for ie6 issues caused by lightwindow - start *}
{if $CFG.admin.light_window_page}
</div>
{/if}
{* Hack for ie6 issues caused by lightwindow - end *}


{if $menu_channel and !$display_channel_in_row}
<div class="clsSubMenuList" style="display:none;" id="channelMoreContent">
  <ul onmouseover="allowChannelHide=false" onmouseout="allowChannelHide=true">
    {section loop=$menu_channel start=0 step=1 max=$channelMenuMax name=channel_menu}
    <li onmouseover="allowChannelHide=false" onmouseout="allowChannelHide=true"><a href="{$menu_channel[channel_menu].url}" >{$menu_channel[channel_menu].name}</a></li>
    {/section}
    {if $channelMore}
    <li onmouseover="allowChannelHide=false" onmouseout="allowChannelHide=true"><a href="{$channel_more_link}" >{$LANG.common_more}</a></li>
    {/if}
  </ul>
</div>
{/if}
{if $mainmenu_more}
<div class="clsSubMenuList" style="display:none;" id="menuMoreContent">
  <ul onmouseover="allowMenuMoreHide=false" onmouseout="allowMenuMoreHide=true">
    {section loop=$menu.main start=$mainMenuMax step=1 name=sec}
    <li onmouseover="allowMenuMoreHide=false" onmouseout="allowMenuMoreHide=true"><a href="{$menu.main[sec].url}" >{$menu.main[sec].name}</a></li>
    {/section}
  </ul>
</div>
{/if}
<iframe id="selBackgroundIframe" frameborder="0" style="display:none;"></iframe>
{literal}
<script language="javascript" type="text/javascript">
/*Event.observe(window, 'load', function() {
	{/literal}
	{if $populateSearchModules_arr}
	{literal}
	if($Jq('#show_hide_theme_anchor'))
		listen('click', $Jq('#show_hide_theme_anchor'), function() { allowHeaderSearchHide=true;hideHeaderSearchModule();});
	if($Jq('#main'))
		{
			listen('mouseover', $Jq('#main'), function() { allowHeaderSearchHide=true;hideHeaderSearchModule();});
			listen('mouseover', $Jq('#main'), function() { allowFooterSearchHide=true;hideFooterSearchModule();});
		}
	if($Jq('#selAccount'))
		listen('mouseover', $Jq('#selAccount'), function() { allowFooterSearchHide=true;hideFooterSearchModule();});
	{/literal}{/if}{literal}
	if($Jq('#main'))
		listen('mouseover', $Jq('#main'), function() { allowShortcutsHide=true;hideShortcutTarget();});

});*/
</script>
{/literal}
</body></html>
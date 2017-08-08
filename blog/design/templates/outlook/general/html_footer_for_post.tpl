
</div>
</div>
</div>
{*CONFIRMATION BOX FOR NAVIGATING TO LOGIN PAGE FOR NON MEMBERS STARTS HERE*}
                    <div id="selMsgLoginConfirmMulti" class="clsPopupConfirmation" style="display:none;">
                      <p id="selAlertLoginMessage">{$LANG.common_sidebar_login_err_msg}</p>
                      <form name="msgConfirmformMulti1" id="msgConfirmformMulti1" method="post" action="" autocomplete="off">
                        <input type="submit" class="clsSubmitButton" name="yes" value="{$LANG.common_yes_option}" tabindex="{smartyTabIndex}" />
                        &nbsp;
                        <input type="button" class="clsSubmitButton" name="no" value="{$LANG.common_no_option}" tabindex="{smartyTabIndex}" onclick="return hidingBlocks()" />
                      </form>
                    </div>
{*CONFIRMATION BOX FOR NAVIGATING TO LOGIN PAGE FOR NON MEMBERS ENDS HERE*}
</div>

<!-- Footer -->
 <div id="footer">
	<div class="clsFooterMidddleBG">
        <div class="clsFooterContentBG">
            <div class="clsFooterCenterBg">
                <div class="clsFooterRightBG">
                    <div class="clsFooterLeftBG">
                        <div class="clsFooterContent">
                            <div class="clsCopyrightContent">
                                <span class="clsCopyrightLogo">&copy; 2011-2012 {$CFG.site.name}. {$LANG.header_allrights_reserved}.</span>
                                <!--<span class="clsPoweredText">{$LANG.header_powered_by} <a href="{$CFG.dev.url}">{$CFG.dev.name}</a></span>-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_top'}
<div id="selForgotPassword">
  	<div class="clsPageHeading"><h2>{$LANG.external_title}</h2></div>

  {if $myobj->isShowPageBlock('block_Openid')}
    <!-- clsFormSection - starts here -->
        <div class="clsTabNavigation clsMarginBottom5">
            <ul>
            {if $CFG.admin.external_login.openid}
                <li id="selHeaderOpenId"><span><a href="javascript:void(0);" onclick="getExLoginMoreContent('selOpenIdContent', 'selHeaderOpenId');">{$LANG.external_title_openid}</a></span></li>
            {/if}
            {if $CFG.admin.external_login.imap}
                <li id="selHeaderImap"><span><a href="javascript:void(0);" onclick="getExLoginMoreContent('selImapContent', 'selHeaderImap');">{$LANG.external_title_imap}</a></span></li>
            {/if}
            {if $CFG.admin.external_login.pop3}
                <li id="selHeaderPop3"><span><a href="javascript:void(0);" onclick="getExLoginMoreContent('selPop3Content', 'selHeaderPop3');">{$LANG.external_title_pop3}</a></span></li>
            {/if}
            {if $CFG.admin.external_login.facebook}
                {if $facebook_support_browser}
                    <li>
                    	<div id="facebookLogin">
                        	<fb:login-button onlogin="facebook_onlogin_ready();"></fb:login-button>
	                    </div>
                    </li>
                {else}
	                <li id="selHeaderFacebook"><span><a href="javascript:void(0);" onclick="getExLoginMoreContent('selFacebookContent', 'selHeaderFacebook');">{$LANG.external_title_facebook}</a></span></li>
                {/if}
            {/if}
            </ul>
		</div>
		<script type="text/javascript">
			var subMenuClassName1='clsActiveTabNavigation';
			var hoverElement1  = '.clsTabNavigation li';
			loadChangeClass(hoverElement1,subMenuClassName1);
        </script>

        {include file='../general/information.tpl'}

        {if $myobj->isShowPageBlock('form_error')}
            <div id="selMsgError">
                <form name="errorForm" id="errorForm" method="post" action="{$myobj->getUrl('externallogin')}" autocomplete="off">
                    {$myobj->populateHidden($myobj->form_error.hidden_arr)}
                    <input type="hidden" name="code" id="code" value="true" />
                    <p>{$LANG.authorization_failure} {$myobj->getCommonErrorMsg()}</p>
                </form>
            </div>
        {/if}

		<div>
            {if $CFG.admin.external_login.openid}
                <div id="selOpenIdContent" style="display:none">
                    <h2 class="clsLoginInsideHeading">{$LANG.external_title_openid}</h2>
                 <form name="form_Openid" id="form_Openid"  method="post" action="{$myobj->getUrl('externallogin')}">
                    <div class="clsDataTable">
                    <table summary="{$LANG.login_tbl_summary}" class="clsTwoColumnTbl">
                        <tr>
                            <td class="clsLoginLabel"><label for="openid_identifier">{$LANG.openid_identifier}</label></td>
                            <td class="clsLoginTextField"><input type="text" class="clsTextBox" id="openid_identifier" name="openid_identifier" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('openid_identifier')}" />{$myobj->getFormFieldErrorTip('openid_identifier')}
                            {*$myobj->ShowHelpTip('openid_identifier')*}
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('submit')}"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="verify" id="verify" tabindex="{smartyTabIndex}" value="{$LANG.external_submit}" /></div></div>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                    </div>
                    </form>
                </div>
            {/if}
            {if $CFG.admin.external_login.imap}
                <div id="selImapContent" style="display:none">
                    <h2 class="clsLoginInsideHeading">{$LANG.external_title_imap}</h2>

                 <form name="form_imap" id="form_imap"  method="post" action="{$myobj->getCurrentUrl()}">
                    <div class="clsDataTable"><table summary="{$LANG.login_tbl_summary}" class="clsTwoColumnTbl">
                        <tr>
                            <td class="clsLoginLabel"><label for="imap_user_name">{$LANG.common_username}</label></td>
                            <td class="clsExternalLoginTextField"><input type="text" class="clsTextBox" name="imap_user_name" id="imap_user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('imap_user_name')}" />{$myobj->getFormFieldErrorTip('imap_user_name')}
                            {$myobj->ShowHelpTip('email','imap_user_name')}
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('imap_server_name')}">@
                                    <select name="imap_server_name" id="imap_server_name">
                                        <option value="">{$LANG.common_select_option}</option>
                                        {foreach key=key item=value from=$CFG.admin.imap.format_arr}
                                        <option value="{$key}"{if $key == $myobj->getFormField('imap_server_name')} selected="selected"{/if}>{$key}</option>
                                        {/foreach}
                                    </select>{$myobj->getFormFieldErrorTip('imap_server_name')}
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('imap_password')}"><label for="imap_password">{$LANG.common_password}</label></td>
                            <td class="{$myobj->getCSSFormFieldCellClass('imap_password')}"><input type="password" class="clsTextBox" name="imap_password" id="imap_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('imap_password')}" />{$myobj->getFormFieldErrorTip('imap_password')}
                            {$myobj->ShowHelpTip('password','imap_password')}
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('submit')}" ></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="imap_verify" id="imap_verify" tabindex="{smartyTabIndex}" value="{$LANG.external_submit}" /></div></div>
                            </td>
                            <td></td>
                        </tr>
                    </table></div>
                </form>
                </div>
            {/if}
            {if $CFG.admin.external_login.pop3}
                <div id="selPop3Content" style="display:none">
                    <h2 class="clsLoginInsideHeading">{$LANG.external_title_pop3}</h2>

                 <form name="form_pop3" id="form_pop3"  method="post" action="{$myobj->getCurrentUrl()}">
                    <div class="clsDataTable"><table summary="{$LANG.login_tbl_summary}" class="clsTwoColumnTbl">
                        <tr>
                            <td class="clsLoginLabel"><label for="pop3_user_name">{$LANG.common_username}</label></td>
                            <td class="clsExternalLoginTextField"><input type="text" class="clsTextBox" name="pop3_user_name" id="pop3_user_name" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('pop3_user_name')}" />{$myobj->getFormFieldErrorTip('pop3_user_name')}
                            {$myobj->ShowHelpTip('email','pop3_user_name')}
                            </td>
                            <td class="{$myobj->getCSSFormFieldCellClass('pop3_server_name')}">@
                                <select name="pop3_server_name" id="pop3_server_name" >
                                    <option value="">{$LANG.common_select_option}</option>
                                    {foreach key=key item=value from=$CFG.admin.pop3.format_arr}
                                        <option value="{$key}"{if $key == $myobj->getFormField('pop3_server_name')} selected="selected"{/if}>{$key}</option>
                                    {/foreach}
                                </select>{$myobj->getFormFieldErrorTip('pop3_server_name')}
                            </td>
                        </tr>
                        <tr>
                            <td class="{$myobj->getCSSFormLabelCellClass('pop3_password')}"><label for="pop3_password">{$LANG.common_password}</label></td>
                            <td colspan="2" class="{$myobj->getCSSFormFieldCellClass('pop3_password')}"><input type="password" class="clsTextBox" name="pop3_password" id="pop3_password" tabindex="{smartyTabIndex}" value="{$myobj->getFormField('pop3_password')}" />{$myobj->getFormFieldErrorTip('pop3_password')}
                            {$myobj->ShowHelpTip('password','pop3_password')}
                            </td>
                        </tr>
                        <tr>
                        	<td></td>
                            <td class="{$myobj->getCSSFormFieldCellClass('submit')}" ><div class="clsSubmitLeft"><div class="clsSubmitRight"><input type="submit" class="clsSubmitButton" name="pop3_verify" id="pop3_verify" tabindex="{smartyTabIndex}" value="{$LANG.external_submit}" /></div></div></td><td></td>
                        </tr>
                    </table></div>
                </form>
                </div>
            {/if}
            <div class="clsLogin">
            {if $CFG.admin.external_login.facebook}
              <div id="selFacebookContent" style="display:none">
                <h2 class="clsLoginInsideHeading">{$LANG.external_title_facebook}</h2>
                {if $facebook_support_browser}
                        <div id="facebookLogin">
                            <fb:login-button onlogin="facebook_onlogin_ready();"></fb:login-button>
                        </div>
                        <div id="facebookImage" style="display:none">
                            <img src="{$CFG.site.url}design/templates/{$CFG.html.template.default}/root/images/screen_blue/icon-facebook.gif" />
                        </div>
                    {else}
                        <p>{$LANG.fabcebook_opera_issue}</p>
                {/if}
                </div>
             {/if}
            </div>
        </div>
    <!-- clsFormSection - ends here -->
  </form>
  {/if} </div>
{$myobj->setTemplateFolder('general/')}
{include file='box.tpl' opt='display_bottom'}
<div class="clsSideBarLinks" id="selSideBarLogin">
 <div class="lbmember">
  <div class="rbmember">
    <div class="bbmember">
      <div class="blcmember">
        <div class="brcmember">
          <div class="tbmember">
            <div class="tlcmember">
              <div class="trcmember">
 				 <div class="clsHeaderMemberLogin">{* <h3>{$LANG.header_nav_login_title}</h3> *}
                  <form id="formIndexLogin" name="formIndexLogin" method="post" action="{$myobj->getUrl('login')}">
                    <table align="right">
                      <tr>
                        <td><label for="login_user_name">{$displayLoginFormRightNavigation_arr.header_nav_login_login_field}</label></td>
                        <td><label for="login_password">{$LANG.common_password}</label></td>
                        <td rowspan="2"><div class="clsGoLeft"><div class="clsGoRight"><input type="submit" class="" name="login_submit" id="login_submit" value="{$LANG.header_nav_login_login}" /></div></div></td>
                      </tr>
                      <tr>
                        <td><input type="text" class="clsHeaderTextBox" name="user_name" value="{$displayLoginFormRightNavigation_arr.user_login_details_arr.user_name}" id="login_user_name" size="10" maxlength="{$CFG.fieldsize.username.max}" tabindex="{smartyTabIndex}"/></td>
                        <td><input type="password" class="clsHeaderTextBox" name="password" value="{$displayLoginFormRightNavigation_arr.user_login_details_arr.password}" id="login_password" size="10" maxlength="{$CFG.fieldsize.password.max}" tabindex="{smartyTabIndex}"/></td>
                      </tr>
                      <tr>
                        <td colspan="3"><input type="checkbox" class="" name="remember" id="remember" value="1"  tabindex="{smartyTabIndex}"/> <label for="remember">{$LANG.header_nav_remember_login}</label>
                        <a id="selForgotPwd" href="{$myobj->getUrl('forgotpassword')}">{$LANG.header_nav_login_forgot_password}</a>&nbsp;
                            {if $displayLoginFormRightNavigation_arr.chkAllowedModule_registration} 
                                <a id="selSignUpLink" href="{$myobj->getUrl('signup')}">{$LANG.header_nav_login_signup}</a> 
                            {/if}
                        </td>
                      </tr>
                    </table>
                  </form>
                 </div>
			  </div>
  			 </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
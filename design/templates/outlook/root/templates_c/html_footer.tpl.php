<?php /* Smarty version 2.6.18, created on 2012-02-03 02:19:51
         compiled from html_footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'html_footer.tpl', 23, false),array('modifier', 'capitalize', 'html_footer.tpl', 51, false),)), $this); ?>
<?php if ($this->_tpl_vars['header']->chkIsProfilePage()): ?>
</div>
<?php endif; ?>

<!-- Main  ends-->
</div>

<!--body content ends-->
</div>

<!-- Footer starts -->
<div id="footer">
	<div class="clsFooterMidddleBG">
        <div class="clsFooterContentBG">
            <div class="clsFooterCenterBg">
                <div class="clsFooterRightBG">
                    <div class="clsFooterLeftBG">
                        <div class="clsFooterContent">
                                                            <div id="selMsgLoginConfirmMulti" class="clsPopupConfirmation" style="display:none;">
                                    <p id="selAlertLoginMessage"></p>
                                    <form name="msgConfirmformMulti1" id="msgConfirmformMulti1" method="post" action="">
                                    <input type="submit" class="clsSubmitButton" name="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                                    <input type="button" class="clsSubmitButton" name="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
                                    </form>
                                </div>
                                                                                        <div id="selMsgConfirmCommon" class="clsPopupConfirmation clsSubscriptionConfirm" style="display:none;">
                                    <div id="msgConfirmTextCommon"></div>
                                    <form name="msgConfirmformCommon" id="msgConfirmformCommon" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
                                    <input type="submit" class="clsSubmitButton" name="common_confirm_yes" id="common_confirm_yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" /> &nbsp;
                                    <input type="button" class="clsSubmitButton" name="common_confirm_no" id="common_confirm_no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
                                    <input type="hidden" name="action" id="action" />
                                    </form>
                                </div>
                                                      

                            <div id="selSubFooter">
                                <h2><span><?php echo $this->_tpl_vars['LANG']['header_miscellanious_nav_links']; ?>
</span></h2>
                            </div>

                            <div class="clsFooterContentList">
                                    <?php if ($this->_tpl_vars['header']->headerBlock['is_footer_links']): ?>
                                    	<?php if (( isset ( $this->_tpl_vars['header']->headerBlock['footer_module_links_arr'] ) )): ?>
                                        <?php $_from = $this->_tpl_vars['header']->headerBlock['footer_module_links_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['footermodule']):
?>
                                            <ul>
                                                <li><h2><?php echo $this->_tpl_vars['footer_module_head_arr'][$this->_tpl_vars['k']]; ?>
</h2></li>
                                                <?php $_from = $this->_tpl_vars['footermodule']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['footerlink']):
?>
                                                    <?php if ($this->_tpl_vars['footerlink']): ?>
                                                        <li><a href="<?php echo $this->_tpl_vars['footerlink']['link_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['footerlink']['link_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a></li>
                                                    <?php endif; ?>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </ul>
                                        <?php endforeach; endif; unset($_from); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <ul>
                                        <li><h2><?php echo $this->_tpl_vars['LANG']['header_title_help_info']; ?>
</h2></li>
                                       <!-- <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=faq','faq/',''); ?>
"><?php echo $this->_tpl_vars['LANG']['header_title_help_center']; ?>
</a></li>-->
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=useterms','useterms/',''); ?>
"><?php echo $this->_tpl_vars['LANG']['header_terms_of_use_link']; ?>
</a></li>
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('contactus'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_contact']; ?>
</a></li>
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('reportbugs'); ?>
"><?php echo $this->_tpl_vars['LANG']['header_reportbugs']; ?>
</a></li>
                                    </ul>
                                    <ul>
                                        <li><h2><?php echo $this->_tpl_vars['LANG']['header_terms_legal_terms']; ?>
</h2></li>
                                        <!--<li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=useterms','useterms/',''); ?>
"><?php echo $this->_tpl_vars['LANG']['header_terms_of_use_link']; ?>
</a></li>
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=privacy','privacy/',''); ?>
"><?php echo $this->_tpl_vars['LANG']['header_privacy_policy_link']; ?>
</a></li>
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=prohibitedcontent','prohibitedcontent/',''); ?>
"><?php echo $this->_tpl_vars['LANG']['header_prohibited_content']; ?>
</a></li>
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=copyright','copyright/',''); ?>
"><?php echo $this->_tpl_vars['LANG']['header_copyright_notification']; ?>
</a></li>-->
                                        <li><noindex><a rel="nofollow" href="http://uztelecom.uz">АК "Узбектелеком"</a></noindex></li>
                                        <li><noindex><a rel="nofollow" href="http://uzonline.uz">Узонлайн</a></noindex></li>
                                        <li><noindex><a rel="nofollow" href="http://uzdc.uz">Дата-Центр</a></noindex></li>
                                    </ul>


                            </div>

                            <div class="clsCopyrightContent">
                                <span class="clsCopyrightLogo">&copy; 2011-2012 <?php echo $this->_tpl_vars['CFG']['site']['name']; ?>
. <?php echo $this->_tpl_vars['LANG']['header_allrights_reserved']; ?>
.</span>
                                <!--<span class="clsPoweredText"><?php echo $this->_tpl_vars['LANG']['header_powered_by']; ?>
 <a href="<?php echo $this->_tpl_vars['CFG']['dev']['url']; ?>
"><?php echo $this->_tpl_vars['CFG']['dev']['name']; ?>
</a></span>-->
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
</div>

<!--bodybackground ends-->
</div>

<?php if(isset($this->bodyBackgroundImage) && $this->bodyBackgroundImage){ ?>
</div>
<?php } ?>

<?php if ($this->_tpl_vars['myobj']->profile_background): ?>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['CFG']['admin']['light_window_page']): ?>
</div>
<?php endif; ?>

<?php echo '
<script type="text/javascript">
initShowHideDivs();
</script>
'; ?>



<div id="subscriptionOption" class="clsSubscriptionToolTip" style="display:none;position:absolute;" onmouseover="javascript:subscription_hover=true;this.show()" onmouseout="subscription_hover=false;hideSubscriptionOption();"></div>
<iframe id="selBackgroundIframe" frameborder="0" style="display:none;"></iframe>

<!--google analytics by abror ahmedov-->
<div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29065560-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</div>
<!--google analytics by abror ahmedov-->

</body></html>
<?php /* Smarty version 2.6.18, created on 2012-01-31 22:13:27
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

                                    <ul>
                                        <li><h2><?php echo $this->_tpl_vars['LANG']['header_title_help_info']; ?>
</h2></li>
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=faq','faq/',''); ?>
"><?php echo $this->_tpl_vars['LANG']['header_title_help_center']; ?>
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
                                        <li><a href="<?php echo $this->_tpl_vars['header']->getUrl('static','?pg=useterms','useterms/',''); ?>
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
</a></li>
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



<?php echo $this->_tpl_vars['myobj']->getQuickMixLastImg(); ?>

<?php if ($this->_tpl_vars['display_stach_block']): ?>
<?php echo '
<script type="text/javascript">
photo_stack = { "photo_ids":['; ?>
<?php echo $this->_tpl_vars['photo_ids']; ?>
],"url":"<?php echo $this->_tpl_vars['session_last_img_url']; ?>
","hide_tip":true <?php echo '};
$Jq(document).ready(function(){ updatePhotoStack(true);});
</script>
'; ?>

<?php endif; ?>


<?php if ($this->_tpl_vars['menu_channel'] && ! $this->_tpl_vars['display_channel_in_row']): ?>
<div class="clsSubMenuList" style="display:none;" id="channelMoreContent">
<ul onMouseOver="allowChannelHide=false" onMouseOut="allowChannelHide=true">
<?php unset($this->_sections['channel_menu']);
$this->_sections['channel_menu']['loop'] = is_array($_loop=$this->_tpl_vars['menu_channel']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['channel_menu']['start'] = (int)0;
$this->_sections['channel_menu']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['channel_menu']['max'] = (int)$this->_tpl_vars['channelMenuMax'];
$this->_sections['channel_menu']['name'] = 'channel_menu';
$this->_sections['channel_menu']['show'] = true;
if ($this->_sections['channel_menu']['max'] < 0)
    $this->_sections['channel_menu']['max'] = $this->_sections['channel_menu']['loop'];
if ($this->_sections['channel_menu']['start'] < 0)
    $this->_sections['channel_menu']['start'] = max($this->_sections['channel_menu']['step'] > 0 ? 0 : -1, $this->_sections['channel_menu']['loop'] + $this->_sections['channel_menu']['start']);
else
    $this->_sections['channel_menu']['start'] = min($this->_sections['channel_menu']['start'], $this->_sections['channel_menu']['step'] > 0 ? $this->_sections['channel_menu']['loop'] : $this->_sections['channel_menu']['loop']-1);
if ($this->_sections['channel_menu']['show']) {
    $this->_sections['channel_menu']['total'] = min(ceil(($this->_sections['channel_menu']['step'] > 0 ? $this->_sections['channel_menu']['loop'] - $this->_sections['channel_menu']['start'] : $this->_sections['channel_menu']['start']+1)/abs($this->_sections['channel_menu']['step'])), $this->_sections['channel_menu']['max']);
    if ($this->_sections['channel_menu']['total'] == 0)
        $this->_sections['channel_menu']['show'] = false;
} else
    $this->_sections['channel_menu']['total'] = 0;
if ($this->_sections['channel_menu']['show']):

            for ($this->_sections['channel_menu']['index'] = $this->_sections['channel_menu']['start'], $this->_sections['channel_menu']['iteration'] = 1;
                 $this->_sections['channel_menu']['iteration'] <= $this->_sections['channel_menu']['total'];
                 $this->_sections['channel_menu']['index'] += $this->_sections['channel_menu']['step'], $this->_sections['channel_menu']['iteration']++):
$this->_sections['channel_menu']['rownum'] = $this->_sections['channel_menu']['iteration'];
$this->_sections['channel_menu']['index_prev'] = $this->_sections['channel_menu']['index'] - $this->_sections['channel_menu']['step'];
$this->_sections['channel_menu']['index_next'] = $this->_sections['channel_menu']['index'] + $this->_sections['channel_menu']['step'];
$this->_sections['channel_menu']['first']      = ($this->_sections['channel_menu']['iteration'] == 1);
$this->_sections['channel_menu']['last']       = ($this->_sections['channel_menu']['iteration'] == $this->_sections['channel_menu']['total']);
?>
<li onMouseOver="allowChannelHide=false" onMouseOut="allowChannelHide=true"><a href="<?php echo $this->_tpl_vars['menu_channel'][$this->_sections['channel_menu']['index']]['url']; ?>
" ><?php echo $this->_tpl_vars['menu_channel'][$this->_sections['channel_menu']['index']]['name']; ?>
</a></li>
<?php endfor; endif; ?>
<?php if ($this->_tpl_vars['channelMore']): ?>
<li onMouseOver="allowChannelHide=false" onMouseOut="allowChannelHide=true"><a href="<?php echo $this->_tpl_vars['channel_more_link']; ?>
" ><?php echo $this->_tpl_vars['LANG']['common_more']; ?>
</a></li>
<?php endif; ?>
</ul>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['mainmenu_more']): ?>
<div class="clsSubMenuList" style="display:none;" id="menuMoreContent">
<ul onMouseOver="allowMenuMoreHide=false" onMouseOut="allowMenuMoreHide=true">
<?php unset($this->_sections['sec']);
$this->_sections['sec']['loop'] = is_array($_loop=$this->_tpl_vars['menu']['main']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec']['start'] = (int)$this->_tpl_vars['mainMenuMax'];
$this->_sections['sec']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['sec']['name'] = 'sec';
$this->_sections['sec']['show'] = true;
$this->_sections['sec']['max'] = $this->_sections['sec']['loop'];
if ($this->_sections['sec']['start'] < 0)
    $this->_sections['sec']['start'] = max($this->_sections['sec']['step'] > 0 ? 0 : -1, $this->_sections['sec']['loop'] + $this->_sections['sec']['start']);
else
    $this->_sections['sec']['start'] = min($this->_sections['sec']['start'], $this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] : $this->_sections['sec']['loop']-1);
if ($this->_sections['sec']['show']) {
    $this->_sections['sec']['total'] = min(ceil(($this->_sections['sec']['step'] > 0 ? $this->_sections['sec']['loop'] - $this->_sections['sec']['start'] : $this->_sections['sec']['start']+1)/abs($this->_sections['sec']['step'])), $this->_sections['sec']['max']);
    if ($this->_sections['sec']['total'] == 0)
        $this->_sections['sec']['show'] = false;
} else
    $this->_sections['sec']['total'] = 0;
if ($this->_sections['sec']['show']):

            for ($this->_sections['sec']['index'] = $this->_sections['sec']['start'], $this->_sections['sec']['iteration'] = 1;
                 $this->_sections['sec']['iteration'] <= $this->_sections['sec']['total'];
                 $this->_sections['sec']['index'] += $this->_sections['sec']['step'], $this->_sections['sec']['iteration']++):
$this->_sections['sec']['rownum'] = $this->_sections['sec']['iteration'];
$this->_sections['sec']['index_prev'] = $this->_sections['sec']['index'] - $this->_sections['sec']['step'];
$this->_sections['sec']['index_next'] = $this->_sections['sec']['index'] + $this->_sections['sec']['step'];
$this->_sections['sec']['first']      = ($this->_sections['sec']['iteration'] == 1);
$this->_sections['sec']['last']       = ($this->_sections['sec']['iteration'] == $this->_sections['sec']['total']);
?>
<li onMouseOver="allowMenuMoreHide=false" onMouseOut="allowMenuMoreHide=true"><a href="<?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['url']; ?>
" ><?php echo $this->_tpl_vars['menu']['main'][$this->_sections['sec']['index']]['name']; ?>
</a></li>
<?php endfor; endif; ?>
</ul>
</div>
<?php endif; ?>
<!--  @todo commented this to fix the js issues temporarily
<div id="subscriptionOption" class="clsSubscriptionToolTip" style="display:none;position:absolute;" onmouseover="javascript:subscription_hover=true;this.show()" onmouseout="subscription_hover=false;hideSubscriptionOption();"></div>
-->
<iframe id="selBackgroundIframe" frameborder="0" style="display:none;"></iframe>
<?php echo '
<script language="javascript" type="text/javascript">
/*Event.observe(window, \'load\', function() {
'; ?>

<?php if ($this->_tpl_vars['populateSearchModules_arr']): ?>
<?php echo '
if($(\'show_hide_theme_anchor\'))
listen(\'click\', $(\'show_hide_theme_anchor\'), function() { allowHeaderSearchHide=true;hideHeaderSearchModule();});
if($(\'main\'))
{
listen(\'mouseover\', $(\'main\'), function() { allowHeaderSearchHide=true;hideHeaderSearchModule();});
listen(\'mouseover\', $(\'main\'), function() { allowFooterSearchHide=true;hideFooterSearchModule();});
}
if($(\'selAccount\'))
listen(\'mouseover\', $(\'selAccount\'), function() { allowFooterSearchHide=true;hideFooterSearchModule();});
'; ?>
<?php endif; ?><?php echo '
if($(\'main\'))
listen(\'mouseover\', $(\'main\'), function() { allowShortcutsHide=true;hideShortcutTarget();});

}); */
</script>
'; ?>

</body></html>
<?php /* Smarty version 2.6.18, created on 2012-02-15 17:53:10
         compiled from viewPhoto.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewPhoto.tpl', 168, false),array('modifier', 'truncate', 'viewPhoto.tpl', 257, false),)), $this); ?>
<?php echo '
<style type="text/css">
 .clsPhotoBalloon{
	margin-left:-110px !important;
	width:97px !important;
}
</style>
'; ?>

<div id="selViewPhoto">
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_flagged_form')): ?>
    <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="flaggedForm" class="clsFlaggedForm">
            <p class="clsFlaggedForm"><?php echo $this->_tpl_vars['LANG']['viewphoto_flagged_msg']; ?>
</p>
           <div class="clsOverflow">
            <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="<?php echo $this->_tpl_vars['myobj']->flaggedPhotoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_flagged']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_flagged']; ?>
</a></div></div>
           </div>
        </div>
	  <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'listimage_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('confirmation_adult_form')): ?>
     <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'listimage_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="selAdultUserForm">
            <p class="clsFlaggedForm"><?php echo $this->_tpl_vars['myobj']->replaceAdultText($this->_tpl_vars['LANG']['confirmation_alert_text']); ?>
</p>
         <div class="clsOverflow">
            <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="<?php echo $this->_tpl_vars['myobj']->acceptAdultPhotoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_accept']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_accept']; ?>
</a></div></div>
            <div class="clsSubmitButton-l"><div class="clsSubmitButton-r"><a href="<?php echo $this->_tpl_vars['myobj']->acceptThisAdultPhotoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_accept_this_page_only']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_accept_this_page_only']; ?>
</a></div></div>
            <div class="clsDeleteButton-l"><div class="clsDeleteButton-r"><a href="<?php echo $this->_tpl_vars['myobj']->rejectAdultPhotoUrl; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_reject']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_reject']; ?>
</a></div></div>
         </div>
        </div>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'listimage_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
  <div class="clsOverflow">
	<div class="clsViewPhotoLeft">
    <?php if ($this->_tpl_vars['CFG']['admin']['photos']['photo_next_prev']): ?>
      <div class="clsViewPhotoPrevNext">
		 <div class="clsViewPhotoPrevTab"><a class="<?php if ($this->_tpl_vars['myobj']->previous_photo_link != ''): ?>clsViewPreviousPhoto<?php else: ?>clsInactivePreviousPhoto<?php endif; ?>" href="<?php if ($this->_tpl_vars['myobj']->previous_photo_link != ''): ?><?php echo $this->_tpl_vars['myobj']->previous_photo_link; ?>
<?php else: ?>javascript:;<?php endif; ?>" title="<?php echo $this->_tpl_vars['myobj']->prev_photo_title; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_prev']; ?>
</a></div>
         <div class="clsViewPhotoNextTab"><a class="<?php if ($this->_tpl_vars['myobj']->next_photo_link != ''): ?>clsViewNextPhoto<?php else: ?>clsInactiveNextPhoto<?php endif; ?>" href="<?php if ($this->_tpl_vars['myobj']->next_photo_link != ''): ?><?php echo $this->_tpl_vars['myobj']->next_photo_link; ?>
<?php else: ?>javascript:;<?php endif; ?>" title="<?php echo $this->_tpl_vars['myobj']->next_photo_title; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_next']; ?>
</a></div>
      </div>
		 <?php endif; ?>
         <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_photo')): ?>
         <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

         <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sharephoto_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         	<div class="clsOverflow">
            	<h2 class="clsSharePhotoHeadingLeft"><span><?php echo $this->_tpl_vars['myobj']->statistics_photo_title; ?>
</span></h2>


                            <div class="clsSharePhotoHeadingRight">
                <?php if ($this->_tpl_vars['myobj']->chkAllowRating()): ?>
                          <div id="ratingForm">
                        <!-- <p class="clsRateThisHd"> <?php echo $this->_tpl_vars['LANG']['viewphoto_rate_this_label']; ?>
:</p>-->
                           <?php $this->assign('tooltip', ""); ?>
                          <?php if (! isLoggedIn ( )): ?>
                                 <?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['myobj']->photo_rating,'photo',$this->_tpl_vars['LANG']['viewphoto_login_message'],$this->_tpl_vars['myobj']->memberviewPhotoUrl,'photo'); ?>

                                 <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewphoto_login_message']); ?>
                          <?php else: ?>
                              <div id="selRatingPhoto" class="clsPhotoRating clsViewPhotoRating clsOverflow">
                                  <?php if (isMember ( ) && $this->_tpl_vars['myobj']->rankUsersRayzz): ?>
                                          <?php echo $this->_tpl_vars['myobj']->populateRatingImagesForAjax($this->_tpl_vars['myobj']->photo_rating,'photo'); ?>

                                  <?php else: ?>
                                      <?php echo $this->_tpl_vars['myobj']->populateRatingImages($this->_tpl_vars['myobj']->photo_rating,'photo',$this->_tpl_vars['LANG']['viewphoto_rate_yourself'],'#','photo'); ?>

                                      <?php $this->assign('tooltip', $this->_tpl_vars['LANG']['viewphoto_rate_yourself']); ?>
                                  <?php endif; ?>
                                &nbsp;(<span><span><?php echo $this->_tpl_vars['myobj']->getFormField('rating_count'); ?>
</span></span>)
                               </div>
                          <?php endif; ?>
                          <script type="text/javascript">
							  <?php echo '
							  $Jq(document).ready(function(){
							    $Jq(\'#ratingLink\').attr(\'title\',\''; ?>
<?php echo $this->_tpl_vars['tooltip']; ?>
<?php echo '\');
							  	$Jq(\'#ratingLink\').tooltip({
														track: true,
														delay: 0,
														showURL: false,
														showBody: " - ",
														extraClass: "clsToolTip",
														top: -10
													});
									});
								'; ?>

                          </script>
                         </div>
                  <?php endif; ?>
              </div>
             </div>
                
                        
            <div class="clsOverflow clsEmbedCountOrgSize">
                <div class="clsPhotoStatRight">
                          <div class="clsStatisticsMiddle">
                             <div class="clsStatisticsLeft">
                                <div class="clsStatisticsRight clsOverflow">
                                	<ul>

                                     <li><span><?php echo $this->_tpl_vars['LANG']['viewphoto_total_views']; ?>
:</span><span class="clsEmberRatingLeft"> <span class="clsEmberRatingRight"><?php echo $this->_tpl_vars['myobj']->getFormField('total_views'); ?>
</span></span></li>
                                     <li><span><?php echo $this->_tpl_vars['LANG']['viewphoto_total_comments']; ?>
:</span><span class="clsEmberRatingLeft"> <span class="clsEmberRatingRight"><?php echo $this->_tpl_vars['myobj']->getFormField('total_comments'); ?>
</span></span></li>

                                     <li><span><?php echo $this->_tpl_vars['LANG']['viewphoto_total_favourites']; ?>
:</span><span class="clsEmberRatingLeft"> <span class="clsEmberRatingRight"><?php echo $this->_tpl_vars['myobj']->getFormField('total_favorites'); ?>
</span></span></li>
                                     

                                                                          </ul>
                                </div>
                             </div>
                          </div>
                       </div>

                <?php $this->assign('photoContainerMaxWidth', 591); ?>
                <?php $this->assign('photoContainerHight', $this->_tpl_vars['myobj']->large_height); ?>
                <?php $this->assign('photoContainerWidth', $this->_tpl_vars['photoContainerMaxWidth']-$this->_tpl_vars['myobj']->large_width); ?>
                <?php $this->assign('photoContainerWidth', $this->_tpl_vars['photoContainerWidth']/2); ?>
                <!--<?php if ($this->_tpl_vars['myobj']->show_original_photo): ?> by ahmedov abror -->
                <div class="clsViewOriginalImageSize">
                    <div class="clsViewOriginalSize">
                        <a class="clsViewOriginalSizeIcon" href="<?php echo $this->_tpl_vars['myobj']->original_photo_path; ?>
" id="img_<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
">
                        	<span><?php echo $this->_tpl_vars['LANG']['viewphoto_view_original_photo']; ?>
</span>
                        </a>
                    </div>
                </div>
                <!--<?php endif; ?>-->
            </div>
            <div class="clsViewPhotoImg">
                <div class="cls591x444 clsViewPhotoThumbImageOuter clsViewUserThumbImageOuter">
                    <div class="clsPhotoThumbImageMiddle">
                        <div class="clsPhotoThumbImageInner">
                        <?php if ($this->_tpl_vars['photoContainerMaxWidth'] > $this->_tpl_vars['myobj']->large_width): ?>
                            <div style="width:<?php echo $this->_tpl_vars['photoContainerWidth']; ?>
px;height:<?php echo $this->_tpl_vars['photoContainerHight']; ?>
px;float:left;"></div>
                        <?php endif; ?>
                            <div id="photo-area" style="float:left;">
                            <img src="<?php echo $this->_tpl_vars['myobj']->photo_path; ?>
" <?php echo $this->_tpl_vars['myobj']->photo_disp; ?>
 title="<?php echo $this->_tpl_vars['myobj']->statistics_photo_title; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->statistics_photo_title; ?>
" id="photo_<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
" >
                            </div>
                            <?php if ($this->_tpl_vars['photoContainerMaxWidth'] > $this->_tpl_vars['myobj']->large_width): ?>
                            <div style="width:<?php echo $this->_tpl_vars['photoContainerWidth']; ?>
px;height:<?php echo $this->_tpl_vars['photoContainerHight']; ?>
px;float:left;"></div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

                        <div class="clsPhotoBookmarkIcons">
	         <div class="clsOverflow">
                         <div class="clsOverflow clsPhotoUrlLeft">
                                                   <div class="clsPhotoUrlInputBg">
                            <input type="text" name="photo_url" id="photo_url"
                        value="<?php echo $this->_tpl_vars['myobj']->viewPhotoEmbedUrl; ?>
" size="52" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" class="clsPhotoUrlTextBox" onFocus="this.select()" onClick="this.select()" READONLY  />
                        </div>
					   </div>
                                                <?php if ($this->_tpl_vars['myobj']->allow_embed == 'Yes' && $this->_tpl_vars['CFG']['admin']['photos']['embedable']): ?>
                         <div class="clsOverflow clsEmbedUrlLeft">
                                                   <p class="clsEmbedUrlInputBg">
                                    <input type="text" size="52" class="clsEmbedUrlTextBox" name="image_code" id="image_code" READONLY onFocus="this.select()" onClick="this.select()" value="<?php echo $this->_tpl_vars['myobj']->embeded_code; ?>
" /></p><p class="clsEmbedUrlIcon"><a id="embed_options_key" href="javascript:void(0)" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_customize_tooltip']; ?>
"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-embedurl.gif" alt="<?php echo $this->_tpl_vars['LANG']['viewphoto_embed_label']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_embed_label']; ?>
"></a></p>
                         </div>
                        <?php endif; ?>

                            <?php if ($this->_tpl_vars['myobj']->allow_embed == 'Yes' && $this->_tpl_vars['CFG']['admin']['photos']['embedable']): ?>
                 <div id="customize_embed_size" class="clsCustomizeEmbedDrop" style="display:none;">
                       <div class="clsEmbededDropDown">
                            <div  class="clsEmbededDropDownArrow">
                               <p><span><?php echo $this->_tpl_vars['LANG']['viewphoto_customize_note']; ?>
:</span>&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['viewphoto_customize_embed']; ?>
</p>
                             </div>
                             <div>
                                <div id="embed_error_msg" class="clsEmbededError" style="display:none"></div>
                                <form name="form_customize_embed" id="form_customize_embed" autocomplete="off">
                                <div class="clsOverflow">
                                    <div class="clsEmedWidthLeft"><span>&nbsp;<label for="embed_width"><?php echo $this->_tpl_vars['LANG']['viewphoto_customize_width']; ?>
</label>:</span>
                                        <input type="text" name="embed_width" id="embed_width" class="validate-embed validate-embed-num" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="4" />
                                    </div>
                                    <div class="clsEmedHeightRight"><span><label for="embed_height"><?php echo $this->_tpl_vars['LANG']['viewphoto_customize_height']; ?>
</label>:</span>&nbsp;
                                        <input type="text" name="embed_height" id="embed_height" class="validate-embed validate-embed-num" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" maxlength="4" />
                                    </div>
                                </div>
                              <div class="clsOverflow clsEmbedBtns">
                                <div class="clsEmbdButtonLeft"><div class="clsEmbdButtonRight">
                                 <a href="javascript:;" name="change_embed_code" id="change_embed_code" onclick="customizeEmbedOptions();" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_customize_apply']; ?>
"/><?php echo $this->_tpl_vars['LANG']['viewphoto_customize_apply']; ?>
</a>
                                </div></div>
                              <div class="clsEmbdButtonLeftdefault"><div class="clsEmbdButtonRightdefault">
                                    <a href="javascript:void(0)" onclick="customizeEmbedOptions('default')" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_customize_default_size']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_customize_default_size']; ?>
</a>
                               </div></div>
                                <a class="clsEmbdClose" href="javascript:void(0)" id="close_embed_options" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_customize_close']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_customize_close']; ?>
</a>
                              </div>
                            </form>
                          </div>
                        </div>
                    </div>
                 <?php endif; ?>
            

                              </div>
            </div>

			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

		 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'sharephoto_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
      </div>

	 <div class="clsViewPhotoRight">
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_viewphoto_photodetails')): ?>
       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'userurl_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       <div id=" " class="clsViewPhotoUserDetailsContent">
       		<?php if (! empty ( $this->_tpl_vars['myobj']->statistics_photo_caption )): ?>
	        	<div class="clsPhotoDescription" >
	            	<h3><?php echo $this->_tpl_vars['LANG']['viewphoto_photo_desc']; ?>
</h3>
	                <p id="photoCaptionContent" class="clsPhotoDes"><?php echo $this->_tpl_vars['myobj']->statistics_photo_caption; ?>
</p>
	           	</div>
	         <?php else: ?>
			   	<div class="clsPhotoDescription" >
	           		<h3><?php echo $this->_tpl_vars['LANG']['viewphoto_no_description']; ?>
</h3>
	           	</div>
	         <?php endif; ?>
             <div class="clsOverflow clsLocations" id="selLocationDiv" style="display:<?php if ($this->_tpl_vars['myobj']->getFormField('location') != ''): ?> block <?php else: ?> none <?php endif; ?>">
                 <p><?php echo $this->_tpl_vars['LANG']['viewphoto_location']; ?>
 :
                	 <span class="" id="selLocationValue"><?php echo $this->_tpl_vars['myobj']->getFormField('location'); ?>
</span>
                 </p>
             </div>
           <div class="clsTags">
		   	<p><?php echo $this->_tpl_vars['LANG']['viewphoto_photo_tags']; ?>
:
		   		<?php $_from = $this->_tpl_vars['subscription_tag_list']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tag']):
?>
		   			<a id="photo_tag_<?php echo $this->_tpl_vars['tag']['name']; ?>
" href="<?php echo $this->_tpl_vars['tag']['url']; ?>
" title="<?php echo $this->_tpl_vars['tag']['name']; ?>
"><?php echo $this->_tpl_vars['tag']['name']; ?>
</a>
		   		<?php endforeach; endif; unset($_from); ?>
		   	</p>
		   </div>
           <div class="clsViewPhotoDetails">
             <div class="clsOverflow">
               <div class="clsUserIcon">
                        <a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl; ?>
" class="Cls45x45 clsImageHolder clsUserThumbImageOuter">
                            <img src="<?php echo $this->_tpl_vars['myobj']->memberProfileImgSrc['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->getFormField('user_name'))) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['myobj']->getFormField('user_name'); ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['myobj']->getFormField('small_width'),$this->_tpl_vars['myobj']->getFormField('small_height')); ?>
>
                        </a>
                    </div>
                <div class="clsOverflow clsFloatRight clsPhotoUserDetails">
                	  <div class="clsOverflow">
                          <div class="clsUserDetails">
                              <div class="clsOverflow">
                                 <p class="clsAddedBy"><?php echo $this->_tpl_vars['LANG']['viewphoto_added_by']; ?>
 <span><a href="<?php echo $this->_tpl_vars['myobj']->memberProfileUrl; ?>
" title="<?php echo $this->_tpl_vars['myobj']->getFormField('photo_added_by'); ?>
"><?php echo $this->_tpl_vars['myobj']->getFormField('photo_added_by'); ?>
</a></span></p>
                                 <p class="clsAddedDate"><?php echo $this->_tpl_vars['LANG']['viewphoto_date']; ?>
 <span><?php echo $this->_tpl_vars['myobj']->getFormField('date_added'); ?>
</span></p>
                              </div>
                          </div>
                      </div>
                      <p class="clsAlbum"><?php echo $this->_tpl_vars['LANG']['viewphoto_album_title']; ?>
: <span><?php echo $this->_tpl_vars['myobj']->statistics_album_title; ?>
</span></p>
                      <div class="clsOverflow">
											   	                           <?php if (chkIsSubscriptionEnabled ( ) && chkIsSubscriptionEnabledForModule ( )): ?>
					<?php if (isMember ( )): ?>
                              	<?php if ($this->_tpl_vars['myobj']->getFormField('user_id') != $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                     <p class="clsSubscriptionBtn">
                                          <a href="javascript:void(0);" id="anchor_subscribe" onclick="get_subscription_options(<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
, 50, -300, 'anchor_subscribe');"  title="<?php echo $this->_tpl_vars['LANG']['common_click_subscribe']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
</a>
                                     </p>
                                    <?php endif; ?>
                              <?php else: ?>
                                     <p class="clsSubscriptionBtn">
                                 		   <a href="javascript:void(0)" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['common_photo_subscribe_subscribe_msg']; ?>
', '<?php echo $this->_tpl_vars['myobj']->memberviewPhotoUrl; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
</a>
 	                                </p>
                              <?php endif; ?>
                           <?php endif; ?>
				                       						 	<?php if ($this->_tpl_vars['myobj']->photoOwner): ?>
                            <div class="clsPhotoViewCustomize">
                        		<p class="clsEmbededDropContainer clsViewCustomize">
                                	<a class="clsEmbededDrop" href="<?php echo $this->_tpl_vars['myobj']->managephoto_url; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_edit_photo_link']; ?>
">
                                    	<span><?php echo $this->_tpl_vars['LANG']['viewphoto_edit_photo_link']; ?>
</span>
                                    </a>
                                </p>
                        	</div>
                            <?php endif; ?>
                                                                                          		  </div>
                  </div>
            	</div>
           </div>
       </div>
       <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'userurl_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       <?php endif; ?>        

    	    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_people_on_photos') && $this->_tpl_vars['myobj']->is_peole_photo_tag): ?>
     <div class="clsStatisticsContent">
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'peopleinthisphoto_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        	<?php if ($this->_tpl_vars['myobj']->large_width >= $this->_tpl_vars['CFG']['admin']['photos']['canvas_add_tag_allowed_width']): ?>
	    		<div class="clsOverflow">
	        		<h3 class="clsViewPhotoHeading clsFloatLeft"><?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_label']; ?>
</h3>
	        		<p class="clsFloatRight clsHighlightall" id="selHighlightLink" <?php if (! $this->_tpl_vars['myobj']->populatePeopleOnPhoto_arr): ?>style="display:none"<?php endif; ?>>
						<a id="idt-highlight-link" href="javascript:;" onclick="tag.photo.toggleAllTaggedIdentities(event);" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_highlight_all']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_highlight_all']; ?>
</a>
					</p>
	        	</div>
            <?php endif; ?>

            <div id="photo_response_text"></div>
            <?php if ($this->_tpl_vars['myobj']->large_width >= $this->_tpl_vars['CFG']['admin']['photos']['canvas_add_tag_allowed_width']): ?>
            <ul id="idt-tag-list">
                    <?php $this->assign('highlight', 0); ?>
                    <?php $_from = $this->_tpl_vars['myobj']->populatePeopleOnPhoto_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tagKey'] => $this->_tpl_vars['tagValue']):
?>
                   <li  id="idt-tag-id_<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
" onmouseover="tag.photo.highlightIdentityTag(<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
);" onmouseout="tag.photo.unhighlightIdentityTag(<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
);">
                        <div class="relative">
                            <a title="<?php echo $this->_tpl_vars['tagValue']['tag_name']; ?>
" id="tag_canvas_img_<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
" href="<?php echo $this->_tpl_vars['tagValue']['tagging_href']; ?>
">
                            <?php if ($this->_tpl_vars['tagValue']['default_icon']): ?>
                              <canvas id="canvas_<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
" class="idt-photo" width="<?php echo $this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_width']; ?>
" height="<?php echo $this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_height']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(43,43,$this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_width'],$this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_height']); ?>
></canvas>
                            <?php else: ?>
                             <img src="<?php echo $this->_tpl_vars['tagValue']['tagged_icon']['s_url']; ?>
" class="idt-photo" width="<?php echo $this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_width']; ?>
" height="<?php echo $this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_height']; ?>
" alt="<?php echo $this->_tpl_vars['tagValue']['tag_name']; ?>
" title="<?php echo $this->_tpl_vars['tagValue']['tag_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(43,43,$this->_tpl_vars['tagValue']['width'],$this->_tpl_vars['tagValue']['height']); ?>
/>
                            <?php endif; ?>
                            </a>
                            <?php if (isMember ( ) && ( $this->_tpl_vars['tagValue']['user_name'] || $this->_tpl_vars['tagValue']['tagged_by_user_id'] == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>
                            <div class="clsPeoplePhoto" style="display:none" id="delete_canvas_link_<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
">
                                <?php if ($this->_tpl_vars['tagValue']['user_name']): ?>
                                <div class="idt-associate-remove-link">
                                <a href="javascript:;" class="clsPhotoVideoEditLinks" onclick="tag.photo.removeAssociate(<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
, <?php echo $this->_tpl_vars['tagValue']['tagged_by_user_id']; ?>
, '<?php echo time(); ?>')" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_annotation_remove_associate']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/canvas/trash.gif">
                                </a>
                                </div>
                                <?php endif; ?>
                                <div class="idt-quick-link-del">
                                <a href="javascript:;" class="clsPhotoVideoEditLinks" onclick="tag.photo.removeIdentityTag(<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
, <?php echo $this->_tpl_vars['tagValue']['tagged_by_user_id']; ?>
, '<?php echo time(); ?>')" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_annotation_delete']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/canvas/delete.gif">
                                </a>
                                </div>
                           </div>
                        <?php endif; ?>
                        </div>
					</li>
                    <?php $this->assign('highlight', 1); ?>
                   <?php endforeach; endif; unset($_from); ?>
                   <?php if (isMember ( ) && ( $this->_tpl_vars['myobj']->getFormField('allow_tags') == 'Yes' || $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id'] )): ?>
	                    <li id="add-identity-tag">
	                        <div class="relative">
	                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/canvas/add_identity.gif" style="width:<?php echo $this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_width']; ?>
px;height:<?php echo $this->_tpl_vars['CFG']['admin']['photos']['canvas_tag_height']; ?>
px;" alt="<?php echo $this->_tpl_vars['LANG']['viewphoto_add_people']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_add_people']; ?>
">
	                            <div class="idt-quick-link">
	                               <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/canvas/add.gif" alt="<?php echo $this->_tpl_vars['LANG']['viewphoto_annotation_add']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_annotation_add']; ?>
">
	                            </div>
	                        </div>
	                    </li>
                   <?php endif; ?>
               </ul>
			<input type="hidden" id="idt-tagged-users" value="<?php echo $this->_tpl_vars['myobj']->photo_tag_ids; ?>
"/>
            <?php else: ?>
            	<div class="clsOverflow">
	        		<h3 class="clsViewPhotoHeading clsFloatLeft"><?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_label']; ?>
</h3>
				</div>
             	<div class="clsNoRecordsFound">
            		<?php echo $this->_tpl_vars['myobj']->viewphoto_canvas_error_message; ?>

              	</div>
            <?php endif; ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'peopleinthisphoto_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      </div>
      <?php elseif ($this->_tpl_vars['myobj']->getFormField('allow_tags') != 'Yes' && ! $this->_tpl_vars['myobj']->isShowPageBlock('confirmation_flagged_form')): ?>
      	<div class="clsStatisticsContent">
	        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'peopleinthisphoto_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        <div class="clsOverflow">
		    	<h3 class="clsViewPhotoHeading"><?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_label']; ?>
</h3>
			  	<p class="clsAddErrorMsg"><?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_tagging_disabled']; ?>
</p>
			</div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'peopleinthisphoto_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    </div>
	  <?php elseif (! $this->_tpl_vars['myobj']->isShowPageBlock('confirmation_flagged_form')): ?>
	  	<div class="clsStatisticsContent">
	        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'peopleinthisphoto_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	        <div class="clsOverflow">
		    	<h3 class="clsViewPhotoHeading"><?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_label']; ?>
</h3>
			  	<p class="clsNoRecordsFound"><?php echo $this->_tpl_vars['LANG']['viewphoto_people_on_photo_no_people_found']; ?>
</p>
			</div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

	        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'peopleinthisphoto_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    </div>
      <?php endif; ?>

    


          <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_add_location') && $this->_tpl_vars['CFG']['admin']['photos']['add_photo_location']): ?>
        <div class="clsViewPhotoGoogle">
            <div class="clsOverflow clsLocationHeader">
            <div class="clsUpdateLocationLeft"><?php echo $this->_tpl_vars['LANG']['viewphoto_location_title']; ?>
</div>
            <?php if (isMember ( ) && ( $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id'] || isAdmin ( ) )): ?>
               <div class="clsUpdateLocation">
               		<a id="updatePhotoLocation" class="clsVideoVideoEditLinks clsPhotoVideoEditLinks" href="javascript:;" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_update_location']; ?>
"></a>
               </div>
            <?php endif; ?>
           </div>
            <div id="map_canvas" class="clsViewPhotoGoogleMap"></div>
            <div class="clsViewPhotoSelectedArea">
              <div id="selSeletedArea" class="clsSelectedArea"><?php echo $this->_tpl_vars['myobj']->getFormField('location'); ?>
</div>
            </div>
        <?php echo '
          <script language="javascript">
           $Jq(document).ready(function() {
            initialize();
           });
          </script>
        '; ?>

     </div>
  	<?php elseif (! $this->_tpl_vars['myobj']->isShowPageBlock('confirmation_flagged_form')): ?>
	   <div><?php getAdvertisement('sidebanner2_234x60') ?></div>
  	<?php endif; ?>
    


	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_viewphoto_action_tabs')): ?>
	<!-- quick slide, flag, add to slide list stats -->
    <div class="clsViewPhotoPageListMenu clsViewPhotoMenuBorder clsOverflow">
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewshare_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="viewPhotoTabs">
            <ul class="clsOverflow">
                <?php if ($this->_tpl_vars['myobj']->allow_quickmixs): ?>
                <li id="selHeaderQuickslide" onmouseover="tabChange('selHeaderQuickslide', 'over')" onmouseout="tabChange('selHeaderQuickslide', 'out')"><span><a href="#viewPhotoQuickSlide" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_quickslide']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_quickslide']; ?>
</a></span></li>
                <?php endif; ?>
                <li id="selHeaderFlag" onmouseover="tabChange('selHeaderFlag', 'over')" onmouseout="tabChange('selHeaderFlag', 'out')"><span><a href="#viewPhotoFlag" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_flag']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_flag']; ?>
</a></span></li>
                <li id="selHeaderSlidelist" onmouseover="tabChange('selHeaderSlidelist', 'over')" onmouseout="tabChange('selHeaderSlidelist', 'out')"><span><a href="#viewPhotoSlidelist" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_slidelist']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_slidelist']; ?>
</a></span></li>
            </ul>
            <div id="viewPhotoQuickSlide">
            	<?php if ($this->_tpl_vars['myobj']->allow_quickmixs): ?>
            	<?php if (! isMember ( )): ?>
            	<div id="quick_mix_<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
">
                    <span><a class="quickslide" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_quickslide_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewPhotoUrl; ?>
'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_quickslide']; ?>
"><span class="clsQuickslideAdd"><?php echo $this->_tpl_vars['LANG']['viewphoto_quickslide']; ?>
</span></a></span>
                </div>
                <?php else: ?>
            	<div id="quick_mix_<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
"<?php if ($this->_tpl_vars['myobj']->is_quickmix_added): ?> style="display:none"<?php endif; ?>>
                    <span><a class="quickslide" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Quickslide');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_add_to_quickslide']; ?>
"><span class="clsQuickslideAdd"><?php echo $this->_tpl_vars['LANG']['viewphoto_add_to_quickslide']; ?>
</span></a></span>
                </div>
                <div id="quick_mix_added_<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
"<?php if (! $this->_tpl_vars['myobj']->is_quickmix_added): ?> style="display:none"<?php endif; ?>>
                    <span><a class="quickslide" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Quickslide', 'remove');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_remove_from_quickslide']; ?>
"><span class="clsQuickslideRemove"><?php echo $this->_tpl_vars['LANG']['viewphoto_remove_from_quickslide']; ?>
</span></a></span>
                </div>
                <div id="quick_mix_saving_<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
" style="display:none">
                	<span><a class="quickslide"><span class="clsQuickslideSaving" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_saving']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_saving']; ?>
</span></a></span>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php echo $this->_tpl_vars['myobj']->populateFlagContent(); ?>

            <div id="viewPhotoSlidelist">
            <?php echo $this->_tpl_vars['myobj']->populateSlideListContent(); ?>

            </div>
        </div>
        <script type="text/javascript">$Jq("#viewPhotoTabs").tabs();</script>
    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewshare_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
    <!-- quick slide, flag, add to slide list ends -->

                            <div class="clsOverflow clsFeauredShare">
                            <ul>
                            <?php if (isMember ( )): ?>
                                <li id="selHeaderSharePhoto">
                                   <a class="sharephoto clsSharePhoto" onclick="showShareDiv('<?php echo $this->_tpl_vars['myobj']->share_url; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_share_photo']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_share_photo']; ?>
</span></a>
                                </li>
                                <li id="selHeaderFeatured" onmouseover="tabChange('selHeaderFeatured', 'over')" onmouseout="tabChange('selHeaderFeatured', 'out')">
                                        <div id="add_featured"<?php if ($this->_tpl_vars['myobj']->featured['added']): ?> style="display:none"<?php endif; ?>>
                                              <a class="feature clsFeature" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Featured');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_feature']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_feature']; ?>
</span></a>
                                         </div>
                                         <div id="added_featured"<?php if (! $this->_tpl_vars['myobj']->featured['added']): ?> style="display:none"<?php endif; ?>>
                                            <a class="featured clsFeatured" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Featured', 'remove');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_featured']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_featured']; ?>
</span></a>
                                         </div>
                                            <div id="featured_saving" style="display:none"><a class="featured clsFeatured" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_saving']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_saving']; ?>
</span></a></div>

	                            </li>
                                <li id="selHeaderFavorites"  onmouseover="tabChange('selHeaderFavorites', 'over')" onmouseout="tabChange('selHeaderFavorites', 'out')">
                                        <div id="add_favorite"<?php if ($this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
                                             <span><a class="favorites clsFavourites" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Favorites');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_favorites']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_favorites']; ?>
</span></a></span>
                                        </div>
                                         <div id="added_favorite"<?php if (! $this->_tpl_vars['myobj']->favorite['added']): ?> style="display:none"<?php endif; ?>>
                                              <span><a class="favorited clsFavourited" href="javascript:void(0);" onclick="getViewPhotoMoreContent('Favorites','remove');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_favorited']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_favorited']; ?>
</span></a></span>
                                         </div>
                                         <div id="favorite_saving" style="display:none"><a class="favorited clsFavourited" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_saving']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_saving']; ?>
</span></a></div>
                                </li>
                             <?php else: ?>
                                 <li id="selHeaderSharePhoto">
                                    <a class="sharephoto clsSharePhoto" onclick="showShareDiv('<?php echo $this->_tpl_vars['myobj']->share_url; ?>
')" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_share_photo']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_share_photo']; ?>
</span></a>
                                </li>
                                 <li id="selHeaderFeatured" onmouseover="tabChange('selHeaderFeatured', 'over')" onmouseout="tabChange('selHeaderFeatured', 'out')">
                                       <a class="feature clsFeature" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_featured_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewPhotoUrl; ?>
'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_feature']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_feature']; ?>
</span></a>
                                  </li>
                                 <li id="selHeaderFavorites" onmouseover="tabChange('selHeaderFavorites', 'over')" onmouseout="tabChange('selHeaderFavorites', 'out')">
                                        <a class="favorites clsFavourites" href="javascript:void(0);" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_favorite_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->memberviewPhotoUrl; ?>
'); return false;" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_favorites']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_favorites']; ?>
</span></a>
                                 </li>
                            <?php endif; ?>
                            </ul>
                            </div>
							<div id="selSharePhotoContent" style="display:none"></div>


    	<?php endif; ?>
   </div>
  </div>

     <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphotocomment_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div class="clsOverflow">
     <div class="clsViewCommentLeft">
                     

              <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('photo_comments_block')): ?>
       		<div class="clsOverflow">
            	<div class="clsViewPhotoCommentHeading">
                	<h3><?php echo $this->_tpl_vars['LANG']['viewphoto_comments_label']; ?>
&nbsp;(<span id="total_comments"><?php echo $this->_tpl_vars['myobj']->getFormField('total_comments'); ?>
</span>)</h3>
                                    </div>
            </div>

	   <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphoto_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php echo $this->_tpl_vars['myobj']->populateCommentOptionsPhoto(); ?>

            <div id="selMsgSuccess" style="display:none">
                <p id="kindaSelMsgSuccess"></p>
            </div>
			<div id="selMsgConfirmWindow" class="clsMsgConfirmWindow" style="display:none;">
				<p id="confirmationMsg"></p>
                &nbsp;
				<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
			      	<input type="button" class="clsSubmitButton" name="confirm_action" id="confirm_action" onclick="deleteCommandOrReply();" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />
			      	&nbsp;
			      	<input type="button" class="clsCancelButton" name="cancel" id="cancel" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks();" />
			      	<input type="hidden" name="comment_id" id="comment_id" />
			      	<input type="hidden" name="maincomment_id" id="maincomment_id" />
			      	<input type="hidden" name="commentorreply" id="commentorreply" />
				</form>
			</div>

        	<div class="clsOverflow">
                <div class="clsViewPhotoCommentHeadingRight">
                	<?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda' || $this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Yes'): ?>
		                <?php if (isMember ( )): ?>
                        	<div class="clsOverflow">
                                <span id="selViewPostComment" class="clsViewPostComment">
                                    <a href="javascript:void(0);" class="clsCommentBgLeft" onclick="$Jq('#photo_comment_add_block').toggle('slow');"
                                            title="<?php echo $this->_tpl_vars['LANG']['viewphoto_post_comment']; ?>
" id="add_comment"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_post_comment']; ?>
</span> </a>

                                     <a href="javascript:void(0);" class="clsCommentBgLeft" onclick="showCancelPhotoComment()"
                                     id="cancel_comment" style="display:none;"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_cancel_comments_label']; ?>
</span> <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>(<?php echo $this->_tpl_vars['LANG']['viewphoto_approval']; ?>
)<?php endif; ?></a>
                                </span>
                            </div>
                        <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?> <p class="clsApproval">(<?php echo $this->_tpl_vars['LANG']['viewphoto_approval']; ?>
)</p><?php endif; ?>
		                <?php else: ?>
		                	<span id="selViewPostComment" class="clsViewPostComment">
		                        <a href="javascript:void(0);" class="clsCommentBgLeft" onclick="memberBlockLoginConfirmation('<?php echo $this->_tpl_vars['LANG']['sidebar_login_comment_post_err_msg']; ?>
','<?php echo $this->_tpl_vars['myobj']->commentUrl; ?>
');return false;">
		                    	   <span><?php echo $this->_tpl_vars['LANG']['viewphoto_post_comment']; ?>
</span> <?php if ($this->_tpl_vars['myobj']->getFormField('allow_comments') == 'Kinda'): ?>(<?php echo $this->_tpl_vars['LANG']['viewphoto_approval']; ?>
)<?php endif; ?>
		                        </a>
		                    </span>
		                <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "addComments.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div id="selCommentBlock" class="clsViewPhotoDetailsContent">
                <?php echo $this->_tpl_vars['myobj']->populateCommentOfThisPhoto(); ?>

            </div>
	   <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

       <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphoto_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
       <?php endif; ?>
         </div>
     <div class="clsViewRelatedPhotosRight">
     		      <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_photo_more_photos')): ?>
                    <div class="clsIndexphotoContainer">
                    	<div class="clsOverflow">
                        	<div class="clsMorePhotos">
                            	<h3><?php echo $this->_tpl_vars['LANG']['viewphoto_more_photos']; ?>
</h3>
                            </div>
	                        <div class="clsViewPhotoListMenu">
                            <ul>
                                <li id="selHeaderPhotoRel">
                                        <a onClick="getRelatedPhoto('tag')" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_related_label']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_related_label']; ?>
</span></a>
                                </li>
                                 <li id="selHeaderPhotoUser">
                                        <a onClick="getRelatedPhoto('user');" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_user_label']; ?>
"><span><?php echo $this->_tpl_vars['LANG']['viewphoto_user_label']; ?>
</span></a>
                                </li>
                            </ul>
                        </div>
                        </div>
                  <div class="clsViewPhotoCarosel">
	  				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphoto_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <div class="clsSideCaroselContainer">
                            <div id="relatedPhotoContent" class="clsMorePhotoContainer">
                            </div>
                            <!--<div class="clsDisplayNone" id="loaderPhotos" align="center">
	                            <img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
photo/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/loader.gif" alt="<?php echo $this->_tpl_vars['LANG']['viewphoto_loading']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['viewphoto_loading']; ?>
"><?php echo $this->_tpl_vars['LANG']['viewphoto_loading']; ?>

                            </div>-->
                        </div>
                    </div>
                   <!--<div class="clsOverflow">
                    <div id="selNextPrev_top" class="clsPhotoCarouselPaging"> </div>
                   </div>-->
                   <script type="text/javascript">
                              var subMenuClassName1='clsActiveMorePhotos';
                              var hoverElement1  = '.clsMorePhotoNav li';
                              loadChangeClass(hoverElement1,subMenuClassName1);
                    </script>
					<script type="text/javascript">
                          var relatedUrl="<?php echo $this->_tpl_vars['myobj']->relatedUrl; ?>
";
                          getRelatedPhoto('tag');
                    </script>
					<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphoto_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                 </div>
	<?php endif; ?>
    
          <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('block_view_photo_meta_details')): ?>
        <div class="clsIndexphotoContainer clsPhotoMetaDetailsBg">
            <h3 class="clsViewPhotoHeading"><?php echo $this->_tpl_vars['LANG']['viewphoto_meta_details_label']; ?>
</h3>
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphoto_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                         <div id="photoMetaDataContent">
                            <?php $_from = $this->_tpl_vars['myobj']->meta_details_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['metadata']):
?>
                                <div class="clsPhotoMetaDetails clsOverflow">
                                    <div class="clsPhotoMetaResultleft">
                                    <?php echo $this->_tpl_vars['metadata']['label']; ?>
</div><div class="clsColon">:</div>
                                    <div class="clsPhotoMetaResultRight"><?php echo $this->_tpl_vars['metadata']['value']; ?>
</div>
                                </div>
                            <?php endforeach; endif; unset($_from); ?>
                         </div>
              <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphoto_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         </div>
	<?php endif; ?>
    
     </div>

  </div>
     <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','photo'); ?>

     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "box.tpl", 'smarty_include_vars' => array('opt' => 'viewphotocomment_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

 </div>
<?php if ($this->_tpl_vars['myobj']->large_width >= $this->_tpl_vars['CFG']['admin']['photos']['canvas_add_tag_allowed_width']): ?>
<script type="text/javascript">
	tag.photo.id = <?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
;
	<?php $_from = $this->_tpl_vars['myobj']->populatePeopleOnPhoto_arr; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tagKey'] => $this->_tpl_vars['tagValue']):
?>
		tag.photo.contactAnnotations.push(new ContactAnnotation('photo-area', <?php echo '{'; ?>
 "width":"<?php echo $this->_tpl_vars['tagValue']['width']; ?>
","height":"<?php echo $this->_tpl_vars['tagValue']['height']; ?>
","top":"<?php echo $this->_tpl_vars['tagValue']['top']; ?>
","left":"<?php echo $this->_tpl_vars['tagValue']['left']; ?>
"<?php echo '}'; ?>
, <?php echo '{'; ?>
 "id":"<?php echo $this->_tpl_vars['tagValue']['photo_people_tag_id']; ?>
","hidden":true<?php echo '}'; ?>
, <?php echo '{'; ?>
 "id":"<?php echo $this->_tpl_vars['tagValue']['tagged_by_user_id']; ?>
","name":"<?php echo $this->_tpl_vars['tagValue']['tag_name']; ?>
"<?php echo '}'; ?>
));
	<?php endforeach; endif; unset($_from); ?>
</script>
<?php endif; ?>

<script>
<?php echo '
	$Jq(document).ready(function() {
		$Jq(\'#img_'; ?>
<?php echo $this->_tpl_vars['myobj']->getFormField('photo_id'); ?>
<?php echo '\').fancybox({
			\'width\'				: \'90%\',
			\'height\'			: \'90%\',
			\'autoScale\'     	: false,
			\'transitionIn\'		: \'none\',
			\'transitionOut\'		: \'none\',
			\'type\'				: \'iframe\'
		});

		$Jq(\'#updatePhotoLocation\').fancybox({
			\'width\'				: 539,
			\'height\'			: 430,
			\'autoScale\'     	: false,
			\'href\'              : \''; ?>
<?php echo $this->_tpl_vars['myobj']->location_url; ?>
<?php echo '\',
			\'transitionIn\'		: \'none\',
			\'transitionOut\'		: \'none\',
			\'type\'				: \'iframe\'
		});
	});
	if ($Jq(\'#add-identity-tag\')) { $Jq(\'#add-identity-tag\').bind(\'click\', tag.photo.addIdentityTag); }
	if ($Jq(\'#embed_options_key\')) { $Jq(\'#embed_options_key\').bind(\'click\', toggleEmbedCustomize); }
	if ($Jq(\'#close_embed_options\')) { $Jq(\'#close_embed_options\').bind(\'click\', toggleEmbedCustomize); }
	'; ?>

	<?php if (! empty ( $this->_tpl_vars['myobj']->statistics_photo_caption )): ?>
		<?php echo '$Jq(\'#photoCaptionContent\').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true}); '; ?>

	<?php endif; ?>
	<?php echo '
	$Jq(\'#photoMetaDataContent\').jScrollPane({scrollbarWidth:10, scrollbarMargin:10,showArrows:true});
'; ?>

</script>
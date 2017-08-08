<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from viewProfile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'smartyTabIndex', 'viewProfile.tpl', 10, false),array('modifier', 'date_format', 'viewProfile.tpl', 46, false),array('modifier', 'truncate', 'viewProfile.tpl', 84, false),)), $this); ?>
<div<?php if ($this->_tpl_vars['myobj']->profile_background && $this->_tpl_vars['myobj']->background_offset): ?> style="margin-top:<?php echo $this->_tpl_vars['myobj']->background_offset; ?>
px;"<?php endif; ?>>
	<div class="clsViewProfileContent">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_profile')): ?>

		    <!-- confirmation box -->
		    <div id="selMsgConfirm" style="display:none;">
				<p id="confirmMessage"></p>
				<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
					<input type="submit" class="clsSubmitButton" name="confirm_action" id="confirm_action" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_confirm']; ?>
" />
					&nbsp;
					<input type="button" class="clsCancelButton" name="cancel" id="cancel" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['common_cancel']; ?>
"  onclick="$Jq('#selMsgConfirm').dialog('close');" />
					<input type="hidden" name="block_id" id="block_id" />
					<input type="hidden" name="action" id="action" />
				</form>
			</div>
		    <!-- confirmation box-->

        	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'profilebox_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        		<div class="clsOverflow">
				
				    <div class="clsProfileTopContent">					
					  <div class="clsProfileTopLeftContent">
						<div class="clsViewProfileTitle">
                        	<div style="display:none" id="userLayout">
                           		<?php echo $this->_tpl_vars['myobj']->form_show_profile['style']; ?>

                        		</div>
                        		<span class="clsUserProfileName"><?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name']; ?>
</span>

								                           		<?php if (chkIsSubscriptionEnabled ( )): ?>
									<?php if (isMember ( )): ?>
                              			<?php if ($this->_tpl_vars['myobj']->getFormField('user_id') != $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                          	<p class="clsSubscriptionBtn">
                                          		<a href="javascript:void(0);" id="anchor_subscribe" onclick="get_subscription_options(<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
, 50, -10, 'anchor_subscribe');"><?php echo $this->_tpl_vars['LANG']['common_subscriptions']; ?>
</a>
                                          	</p>
                                    	<?php endif; ?>
                              		<?php endif; ?>
                           		<?php endif; ?>
				   				                          	
                     	</div>
					  </div>
					  
					  <div class="clsProfileTopRightContent">	
					   <div class="clsLoginDate">				
						<span><?php echo $this->_tpl_vars['LANG']['user_details_since']; ?>
 <span class="clsBold"><?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['doj'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</span>
						 <span>&nbsp; | &nbsp;</span>
						 <?php echo $this->_tpl_vars['LANG']['myprofile_last_logged']; ?>
: 
						<span>
						 <?php if ($this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['last_logged'] != '0000-00-00 00:00:00'): ?>
						   <?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['last_logged'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>

						<?php else: ?>
						  <?php echo $this->_tpl_vars['LANG']['myprofile_first_logged']; ?>

						<?php endif; ?>
					     </span>
						</span>
						<?php if (isMember ( ) && $this->_tpl_vars['myobj']->form_show_profile['currentAccount']): ?>
						  <span class="clsViewProfileEdit">
							<span><a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['displayBasicEditLink']; ?>
" ><?php echo $this->_tpl_vars['LANG']['viewProfile_edit_profile_basic_link']; ?>
</a></span>
							   <span>&nbsp; | &nbsp;</span>
							<span><a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['displayAvatarEditLink']; ?>
" ><?php echo $this->_tpl_vars['LANG']['viewProfile_edit_profile_avatar_link']; ?>
</a></span>
						  </span> 
						<?php endif; ?>
					  </div>
					  	
					<?php if (! $this->_tpl_vars['myobj']->form_show_profile['currentAccount']): ?>
					   <span id="selProfileLinks">
						<?php if (! $this->_tpl_vars['myobj']->form_show_profile['NextProfile']): ?>
						  <span id="selProfileNext" class="clsNextProfile"><a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['NextProfileUrl']; ?>
"><?php echo $this->_tpl_vars['LANG']['profile_navi_next_profile']; ?>
</a></span>
						<?php endif; ?>
					   </span>
				   <?php endif; ?>	
						
				  </div>	
				
				</div>
				
				<div class="clsProfileMainBarContent">
       		 		<div class="clsProfileLeftContent">
             			<div class="clsViewProfileImage">
                      		<p id="selImageBorder">
                        		<span id="selPlainCenterImage">
                        			<a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['profile_url']; ?>
" class="ClsProfileImageContainer ClsProfileImageBorder ClsProfile90x90">
                            			<img src="<?php echo $this->_tpl_vars['myobj']->form_show_profile['userIcon']['t_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 9) : smarty_modifier_truncate($_tmp, 9)); ?>
" border="0" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['myobj']->form_show_profile['userIcon']['t_width'],$this->_tpl_vars['myobj']->form_show_profile['userIcon']['t_height']); ?>
 />
                            		</a>
                        		</span>
                      		</p>
             			</div>

                		<div class="clsUserProfileDetails">
                    		<?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>

                    		<div class="clsUserDetailLinks clsUserDetailLinksBg">
                    			<ul>
                    				<?php if (! empty ( $this->_tpl_vars['myobj']->form_show_profile['myprofile_age'] )): ?>
                    					<li><?php echo $this->_tpl_vars['myobj']->form_show_profile['myprofile_age']['caption']; ?>
:&nbsp; <span><?php echo $this->_tpl_vars['myobj']->form_show_profile['myprofile_age']['text']; ?>
</span></li>
                    				<?php endif; ?>
                    				<?php if (! empty ( $this->_tpl_vars['myobj']->form_show_profile['gender'] )): ?>
                    					<li><?php echo $this->_tpl_vars['myobj']->form_show_profile['gender']['caption']; ?>
:&nbsp; <span class="<?php echo $this->_tpl_vars['myobj']->form_show_profile['gender_class']; ?>
" id="<?php echo $this->_tpl_vars['myobj']->form_show_profile['gender_id']; ?>
"><?php echo $this->_tpl_vars['myobj']->form_show_profile['gender']['text']; ?>
</span></li>
                    				<?php endif; ?>
                    				<?php if ($this->_tpl_vars['myobj']->form_show_profile['show_dob']): ?>
                    					<li><?php echo $this->_tpl_vars['LANG']['myprofile_birthday']; ?>
:&nbsp; <span id="<?php echo $this->_tpl_vars['myobj']->form_show_profile['birthday_id']; ?>
" class="<?php echo $this->_tpl_vars['myobj']->form_show_profile['birthday_class']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['dob'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date'])); ?>
</span></li>
                    				<?php endif; ?>
								</ul>
                    		</div>
                    		<div class="clsUserDetailLinks clsUserDetailLinksMore">
								<ul>
                    				<?php if (! empty ( $this->_tpl_vars['myobj']->form_show_profile['myprofile_country'] )): ?>
                    					<li><?php echo $this->_tpl_vars['myobj']->form_show_profile['myprofile_country']['caption']; ?>
:&nbsp; <span class="<?php echo $this->_tpl_vars['myobj']->form_show_profile['country_class']; ?>
" id="<?php echo $this->_tpl_vars['myobj']->form_show_profile['country_id']; ?>
"><?php echo $this->_tpl_vars['myobj']->form_show_profile['myprofile_country']['text']; ?>
</span></li>
                    				<?php endif; ?>
                    				<?php if (! empty ( $this->_tpl_vars['myobj']->form_show_profile['myprofile_relation_status'] )): ?>
                    					<li><?php echo $this->_tpl_vars['myobj']->form_show_profile['myprofile_relation_status']['caption']; ?>
:&nbsp; <span class="<?php echo $this->_tpl_vars['myobj']->form_show_profile['relation_class']; ?>
" id="<?php echo $this->_tpl_vars['myobj']->form_show_profile['relation_id']; ?>
"><?php echo $this->_tpl_vars['myobj']->form_show_profile['myprofile_relation_status']['text']; ?>
</span></li>
                    				<?php endif; ?>
									<?php if ($this->_tpl_vars['myobj']->form_show_profile['show_dob']): ?>
                    					<li><?php echo $this->_tpl_vars['LANG']['myprofile_zodiac']; ?>
:&nbsp; <span><?php echo $this->_tpl_vars['myobj']->form_show_profile['dob_zodiac']; ?>
</span></li>
                    				<?php endif; ?>
                    			</ul>
                    		</div>
                		</div>
             		</div>

             		<div class="clsProfileRightContent">                    	
                    	<div class="clsUrlTitleContainer">
                        	<table class="clsURLTable">
								<tr>
									<th><span class="clsUrlTitle"><?php echo $this->_tpl_vars['LANG']['myprofile_url']; ?>
</span></th>
                        			<td><div class="clsUrlTextBox" id="purl" onclick="fnSelect('purl')" ><?php echo $this->_tpl_vars['myobj']->form_show_profile['myProfileUrl']; ?>
</div></td>
								</tr>
								<?php if ($this->_tpl_vars['myobj']->form_show_profile['myweburl']): ?>
							         <tr>
							          <th><span class="clsUrlTitle"><?php echo $this->_tpl_vars['LANG']['myprofile_web_url']; ?>
</span></th>
							          <td><div class="clsUrlTextBox <?php echo $this->_tpl_vars['myobj']->form_show_profile['myweburl_class']; ?>
" id="<?php echo $this->_tpl_vars['myobj']->form_show_profile['myweburl_id']; ?>
"><?php echo $this->_tpl_vars['myobj']->form_show_profile['myweburl']; ?>
</div></td>
							        </tr>
							    <?php endif; ?>
							</table>
                    	</div>
						<?php if (! $this->_tpl_vars['myobj']->form_show_profile['currentAccount']): ?>
            			<div class="clsCurrentUserLinks">
                			<div class="clsProfileLinksMain">
                        			<ul class="clsUserActionsLinks">
                        				<?php if (chkAllowedModule ( array ( 'community' , 'groups' ) )): ?>
                            				<li id="selAddGp"><a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['profileAddToGroup']; ?>
" id="selAddToGroupLinkId" ><?php echo $this->_tpl_vars['LANG']['profile_navi_add_to_group']; ?>
</a></li>
                        				<?php endif; ?>
                         				<?php if (isLoggedIn ( ) && ! $this->_tpl_vars['myobj']->chkAlreadyBlock()): ?>
                            				<li id="selAddBlock" class="clsBlockUser <?php if (! chkAllowedModule ( array ( 'mail' ) )): ?>clsViewProfileNoBorder<?php endif; ?>" ><a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" id="selBlockLinkId" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array(<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
, 'Block', '<?php echo $this->_tpl_vars['LANG']['viewprofile_block_confirm_message']; ?>
'), Array('value', 'value', 'html'));"><?php echo $this->_tpl_vars['LANG']['profile_navi_block_user']; ?>
</a></li>
                         				<?php endif; ?>
                         				<?php if (isLoggedIn ( ) && $this->_tpl_vars['myobj']->chkAlreadyBlock()): ?>
                            				<li id="selAddBlock" class="clsBlockUser <?php if (! chkAllowedModule ( array ( 'mail' ) )): ?>clsViewProfileNoBorder<?php endif; ?>" ><a href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" id="selUnblockLinkId" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('block_id', 'action', 'confirmMessage'), Array(<?php echo $this->_tpl_vars['myobj']->getFormField('user_id'); ?>
, 'Unblock', '<?php echo $this->_tpl_vars['LANG']['viewprofile_unblock_confirm_message']; ?>
'), Array('value', 'value', 'html'));"><?php echo $this->_tpl_vars['LANG']['profile_navi_un_block_user']; ?>
</a></li>
                         				<?php endif; ?>
                         				<?php if (isLoggedIn ( )): ?>
                         				<li><a href="javascript:void(0);" onclick="return openAjaxWindow('true', 'ajaxupdate', 'reportUser', '<?php echo $this->_tpl_vars['myobj']->reportLink; ?>
');"><?php echo $this->_tpl_vars['LANG']['report_user']; ?>
</a></li>
                         				<?php endif; ?>
                        				<?php if (chkAllowedModule ( array ( 'mail' ) )): ?>
                            				<li id="selForward" class="clsForwardToFriend"><a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['profileMailCompose']; ?>
" id="selForwardLinkId"><?php echo $this->_tpl_vars['LANG']['profile_navi_forward_to_friend']; ?>
</a></li>
                        				<?php endif; ?>
										
                           				<?php if (! $this->_tpl_vars['myobj']->form_show_profile['AlreadyFriend']): ?>
                           					<li id="selProfileAddFriend" class="clsAddToFriends"><a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['AddFriendUrl']; ?>
" id="selAddFriendLinkId"><?php echo $this->_tpl_vars['LANG']['profile_navi_add_to_friends']; ?>
</a></li>
                           				<?php endif; ?>
                           				<li id="selProfileSendMail" class="clsSendMessage clsViewProfileNoBorder"><a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['SendMessage']; ?>
" id="selSendMessageLinkId"><?php echo $this->_tpl_vars['LANG']['profile_navi_send_message']; ?>
</a></li>
                  					</ul>
                				</div>
            			</div>
        			<?php endif; ?>
				 
				
					<form name="form_profile_block" id="form_profile_block" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
">
	        		<?php if ($this->_tpl_vars['CFG']['profile_block']['re_order'] && isMember ( ) && $this->_tpl_vars['myobj']->form_show_profile['currentAccount'] && $this->_tpl_vars['myobj']->isMyProfilPage): ?>
					  <div class="clsUpdateOrder">
	        			<div id="user_actions" class="clsFloatLeft">
	        				<input id="left"  type="hidden" name="left" />
	        				<input id="right"  type="hidden" name="right" />
							<input id="showButton" value="<?php echo $this->_tpl_vars['LANG']['viewprofile_update_order']; ?>
" name="update_order" type="submit" />
	        			</div>
	        			<div class="clsUpdateOrderContent"><?php echo $this->_tpl_vars['LANG']['viewprofile_reorder_block_user_message']; ?>
</div>
					 </div>
	        		<?php endif; ?>
	        	</form>
				
			</div>
				</div>				
					
        		</div>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'profilebox_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	        	
	        <div>

		        <div class="clsProfilePageLeftContent">
		          	<ul id="ul1" class="clsDraglist">
		          		<?php if ($this->_tpl_vars['myobj']->left_arr): ?>
		               		<?php $_from = $this->_tpl_vars['myobj']->show_profile_block['profile_block']['left']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['Lvalue']):
?>
		                 		<?php if ($this->_tpl_vars['Lvalue']['include_filename'] != ''): ?>
		                     		<?php if ($this->_tpl_vars['Lvalue']['module_folder'] == 'default'): ?>
		                     			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

		                     		<?php else: ?>
		                     			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',$this->_tpl_vars['Lvalue']['module_folder']); ?>

		                     		<?php endif; ?>
		                 			<li id="<?php echo $this->_tpl_vars['Lvalue']['block_name']; ?>
"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Lvalue']['include_filename'], 'smarty_include_vars' => array('selected_category' => $this->_tpl_vars['Lvalue']['sel_category'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></li>
		                  		<?php endif; ?>
		               		<?php endforeach; endif; unset($_from); ?>
		          		<?php endif; ?>
		          	</ul>
		        </div>

		        <div class="clsProfilePageRightContent">
		          	<ul id="ul2" class="clsDraglist">
		          		<?php if ($this->_tpl_vars['myobj']->right_arr): ?>
		               		<?php $_from = $this->_tpl_vars['myobj']->show_profile_block['profile_block']['right']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['Rvalue']):
?>
		                 		<?php if ($this->_tpl_vars['Rvalue']['include_filename'] != ''): ?>
		                 			<?php if ($this->_tpl_vars['Rvalue']['module_folder'] == 'default'): ?>
		                 				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/'); ?>

		                 			<?php else: ?>
		                 				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/',$this->_tpl_vars['Rvalue']['module_folder']); ?>

		                 			<?php endif; ?>
		                			<li id="<?php echo $this->_tpl_vars['Rvalue']['block_name']; ?>
"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['Rvalue']['include_filename'], 'smarty_include_vars' => array('selected_category' => $this->_tpl_vars['Rvalue']['sel_category'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></li>
		                 		<?php endif; ?>
		               		<?php endforeach; endif; unset($_from); ?>
		          		<?php endif; ?>
		          	</ul>
        		</div>
    		</div>
        <?php endif; ?>    </div>
</div>
<?php /* Smarty version 2.6.18, created on 2012-02-02 18:35:28
         compiled from viewProfile.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'viewProfile.tpl', 100, false),)), $this); ?>
<h2><?php echo $this->_tpl_vars['LANG']['viewprofile_title']; ?>
</h2>
<p class="clsBackLink"><a href="memberManage.php"><?php echo $this->_tpl_vars['LANG']['common_back']; ?>
</a></p>
<!-- information div -->
<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('admin/'); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_profile')): ?>
	<div id="actionBlock">
		<?php if ($this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['usr_status'] == 'Ok'): ?>
	        <p class="clsPageLink">
	        	<a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['userProfileLink']; ?>
" target="_blank">
	            	<?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name']; ?>

	            </a><?php echo $this->_tpl_vars['LANG']['myprofile_view_profile']; ?>

	        </p>
	        <p>
	        	<a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['userProfileLink']; ?>
" >
	            	<?php echo $this->_tpl_vars['myobj']->form_show_profile['userProfileLink']; ?>

	            </a>
	        </p>
		<?php else: ?>
			<p class="clsPageLink">
				<?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name']; ?>

			</p>
		<?php endif; ?>
	</div>
    <table class="clsWithoutBorder">
    	<tr>
    		<td class="clsWithoutBorder clsProfileDatas">
           		<table id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['profile_icon']; ?>
" cellspacing="0" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultTableBgColor']; ?>
 >
                    <tr>
                        <td rowspan="2">
                          	<p id="selImageBorder" class="clsPlainImageBorder">
                                <span id="selPlainCenterImage">
                                	<a href="<?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['profile_url']; ?>
">
                                    	<img src="<?php echo $this->_tpl_vars['myobj']->form_show_profile['userIcon']['t_url']; ?>
" alt="<?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name']; ?>
" border="0" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['myobj']->form_show_profile['userIcon']['t_width'],$this->_tpl_vars['myobj']->form_show_profile['userIcon']['t_height']); ?>
" />
                                    </a>
                               </span>
                          	</p>
                        </td>
                        <td>
                            <table class="clsNoBorder clsNoMargin">
                                <tr>
                                    <th class="text clsProfileTitle">
                                        <span class="whitetext12">
                                            <?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name']; ?>

                                        </span>
                                    </th>
                                    <td>&nbsp;

                                    </td>
                                </tr>
                                <?php if ($this->_tpl_vars['myobj']->form_show_profile['currentStatus']): ?>
                                    <tr>
                                        <td colspan="2" class="text clsTextBox">
                                            <span class="<?php echo $this->_tpl_vars['myobj']->form_show_profile['onlineStatusClass']; ?>
">
                                                <?php echo $this->_tpl_vars['myobj']->form_show_profile['currentStatus']; ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                        	</table>
                        </td>
                    </tr>
                    <tr>
                        <td class="text clsTextBox clsProfilePadding" id="selUserProfileDetailTable" >
                            <div id="selDet" >
                                <p>
                                    <?php echo $this->_tpl_vars['myobj']->form_show_profile['details']; ?>

                                </p>
                                <p class="clsProfileViews">
                                    <?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['profile_hits']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['LANG']['myprofile_navi_profile_views']; ?>

                                </p>
                             </div>
                        </td>
                    </tr>
           		</table>

           		<table id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['table_all_stats']; ?>
" cellspacing="0" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultTableBgColor']; ?>
>
                    <tr>
                        <td class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
>
                        	<span class="whitetext12">
                            	<?php echo $this->_tpl_vars['LANG']['myprofile_title_all_stats']; ?>

                            </span>
                        </td>
                        <td <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
>
                        	&nbsp;
                        </td>
                    </tr>
                    <?php echo $this->_tpl_vars['myobj']->displayRecord($this->_tpl_vars['LANG']['myprofile_age'],$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['age']); ?>

                    <?php echo $this->_tpl_vars['myobj']->displayRecord($this->_tpl_vars['LANG']['myprofile_gender'],$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['sex']); ?>

                    <?php echo $this->_tpl_vars['myobj']->displayRecord($this->_tpl_vars['LANG']['myprofile_country'],$this->_tpl_vars['myobj']->form_show_profile['country']); ?>

                    <?php echo $this->_tpl_vars['myobj']->displayRecord($this->_tpl_vars['LANG']['myprofile_user_type'],$this->_tpl_vars['myobj']->form_show_profile['usr_type']); ?>

                    <?php echo $this->_tpl_vars['myobj']->displayRecord($this->_tpl_vars['LANG']['myprofile_relation_status'],$this->_tpl_vars['myobj']->form_show_profile['relation']); ?>


                    <?php if ($this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['show_dob']): ?>
                    	<tr>
                            <td class="text clsProfileSideTitle">
                            	<?php echo $this->_tpl_vars['LANG']['myprofile_birthday']; ?>

                            </td>
                        	<td>
                            	<?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['birthday'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date'])); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="text clsProfileSideTitle">
                            	<?php echo $this->_tpl_vars['LANG']['myprofile_zodiac']; ?>

                            </td>
                            <td>
                            	<?php echo $this->_tpl_vars['myobj']->getZodiacSign($this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['dob_zodiac']); ?>

                            </td>
                        </tr>
                	<?php endif; ?>
           		</table>
                <?php if ($this->_tpl_vars['myobj']->form_show_profile['module_statistics_arr']['row']): ?>
                     <table  <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultTableBgColor']; ?>
>
                        <tr>
                        	<td class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
 >&nbsp;</th>
                            <td class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
 ><?php echo $this->_tpl_vars['LANG']['viewprofile_uploaded']; ?>
</td>
                            <td class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
 ><?php echo $this->_tpl_vars['LANG']['viewprofile_views']; ?>
</td>
                        </tr>

                        <?php $_from = $this->_tpl_vars['myobj']->form_show_profile['module_statistics_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module_value']):
?>
                            <tr>
                                <td><?php echo $this->_tpl_vars['module_value']['lang']; ?>
</td>
                                <td><?php echo $this->_tpl_vars['module_value']['total_uploaded']; ?>
</td>
                                <td><?php echo $this->_tpl_vars['module_value']['total_views']; ?>
</td>
                           </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </table>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['personal_info_arr'] != 0): ?>
                	<div class="clsPersonalInfoTable">
                      	<table >
                        	<tr>
                          		<th colspan="2" class="text clsProfileTitle" ><span class="whitetext12"><?php echo $this->_tpl_vars['LANG']['myprofile_personal_info']; ?>
</span></th>
                        	</tr>
                            <tr>
                          		<td colspan="2">
                            		<div class="clsProfileTableInfo">
                                		<table class="clsNoBorder clsNoMargin">
                                     		<?php $_from = $this->_tpl_vars['personal_info_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
                                     			<?php if ($this->_tpl_vars['value']['answer_result'] != $this->_tpl_vars['CFG']['profile']['question_no_answer'] && $this->_tpl_vars['value']['answer_result'] != ''): ?>
                                     				<tr>
                                     					<td class="text clsProfileSideTitle"><p class="clsListing"><?php echo $this->_tpl_vars['value']['question']; ?>
</p></td>
				                                    	<td class="clsAnswerSection"><p class="clsListing"><?php echo $this->_tpl_vars['value']['answer_result']; ?>
</p></td>
				                                    </tr>
			                                    <?php endif; ?>
		                                    <?php endforeach; endif; unset($_from); ?>
                            			</table>
                             		</div>
                            	</td>
                         	</tr>
                      	</table>
                	</div>
				<?php endif; ?>
           		<!-- -->
           	</td>
            <td class="clsWithoutBorder" rowspan="2">
           		<table id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['table_vital_info']; ?>
" cellspacing="0" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultTableBgColor']; ?>
>
                    <tr>
                        <td class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
>
                            <span class="whitetext12">
                                <?php echo $this->_tpl_vars['LANG']['myprofile_title_vital_info']; ?>

                            </span>
                        </td>
                        <td <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
>
                            &nbsp;
                        </td>
                    </tr>
                    <?php if ($this->_tpl_vars['myobj']->form_show_profile['about_me'] || $this->_tpl_vars['myobj']->isEditableLinksAllowed()): ?>
                        <tr>
                            <td class="text clsProfileSideTitle" >
                                <?php echo $this->_tpl_vars['LANG']['myprofile_about_me']; ?>

                            </td>
                            <td>
                                <?php echo $this->_tpl_vars['myobj']->form_show_profile['about_me']; ?>

                            </td>
                        </tr>
                    <?php endif; ?>
	                <tr>
	                    <td class="text clsProfileSideTitle" >
	                        <?php echo $this->_tpl_vars['LANG']['myprofile_member_since']; ?>

	                    </td>
	                    <td>
	                        <?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['doj'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

	                    </td>
	                </tr>
	                <tr>
	                    <td class="text clsProfileSideTitle" >
	                        <?php echo $this->_tpl_vars['LANG']['myprofile_last_active']; ?>

	                    </td>
	                    <td>
	                    	<?php if ($this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['last_active'] == '0000-00-00 00:00:00'): ?>
	                    		-
	                    	<?php else: ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['last_active'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>

	                    	<?php endif; ?>
	                    </td>
	                </tr>
           		</table>
				
                           		<table cellspacing="0" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultTableBgColor']; ?>
>
	        		<tr>
	              		<td colspan="2" class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
><span class="whitetext12"><?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name']; ?>
's <?php echo $this->_tpl_vars['LANG']['myprofile_shelf_friends']; ?>
</span></td>
	            	</tr>
		            <?php if (! $this->_tpl_vars['myobj']->form_show_profile['hasFriends']): ?>
		                <tr>
		                	<td colspan="2">
		                  		<div id="selMsgAlert">
		                      		<p><?php echo $this->_tpl_vars['LANG']['viewprofile_friends_no_msg']; ?>
</p>
		                    	</div>
		                  	</td>
		                </tr>
		            <?php else: ?>
		                <tr><td colspan="2">
		                    <table id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['friends_list']; ?>
">
		                    	<tr>
		                            <?php $_from = $this->_tpl_vars['myobj']->form_show_profile['displayMyFriends']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dmfKey'] => $this->_tpl_vars['dmfValue']):
?>
		                                <td><p id="selImageBorder">
		                                	<a href="<?php echo $this->_tpl_vars['dmfValue']['userDetails']['profile_url']; ?>
">
										 	<img src="<?php echo $this->_tpl_vars['dmfValue']['icon']['t_url']; ?>
" alt="<?php echo $this->_tpl_vars['dmfValue']['friendName']; ?>
" title="<?php echo $this->_tpl_vars['dmfValue']['friendName']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['dmfValue']['icon']['t_width'],$this->_tpl_vars['dmfValue']['icon']['t_height']); ?>
" />
											</a>
										 </p></td>
		                            <?php endforeach; endif; unset($_from); ?>
		                    	</tr>
		                    </table>
		                </td></tr>
		            <?php endif; ?>
           		</table>
                <table cellspacing="0" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultTableBgColor']; ?>
>
	            	<tr>
	                    <td colspan="2" class="text clsProfileTitle" <?php echo $this->_tpl_vars['myobj']->form_show_profile['defaultBlockTitle']; ?>
>
	                        <span class="whitetext12">
	                            <?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_name']; ?>
's <?php echo $this->_tpl_vars['LANG']['myprofile_shelf_scraps']; ?>

	                        </span>
	                   </td>
	                </tr>
	                <tr>
	                    <td colspan="2" id="profileCommentsSection">
	                     	<?php if ($this->_tpl_vars['myobj']->form_show_profile['displayProfileComments']['totalResults'] > 0): ?>
	                        	<table width="100%" class="clsNoBorder" cellspacing="0" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['scraps_list']; ?>
">
	                            	<?php $_from = $this->_tpl_vars['myobj']->form_show_profile['displayProfileComments']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dpcKey'] => $this->_tpl_vars['dpcValue']):
?>
		                                <tr>
		                                    <td class="clsImageWidth" id="selProfileComment"><p id="selImageBorder"><a href="<?php echo $this->_tpl_vars['dpcValue']['commentorProfileUrl']; ?>
"  <?php echo $this->_tpl_vars['dpcValue']['online']; ?>
><img src="<?php echo $this->_tpl_vars['dpcValue']['profileIcon']['s_url']; ?>
" alt="<?php echo $this->_tpl_vars['dpcValue']['record']['user_name']; ?>
" title="<?php echo $this->_tpl_vars['dpcValue']['record']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE($this->_config[0]['vars']['image_thumb_width'],$this->_config[0]['vars']['image_thumb_height'],$this->_tpl_vars['dpcValue']['profileIcon']['t_width'],$this->_tpl_vars['dpcValue']['profileIcon']['t_height']); ?>
" /></a></p></td>
		                                    <td>
		                                    	<p class="clsUserName"><?php echo ((is_array($_tmp=$this->_tpl_vars['dpcValue']['record']['display_date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_date_year']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_date_year'])); ?>
<?php echo $this->_tpl_vars['LANG']['viewprofile_comment_by']; ?>
<a href="<?php echo $this->_tpl_vars['dpcValue']['commentorProfileUrl']; ?>
"><?php echo $this->_tpl_vars['dpcValue']['record']['user_name']; ?>
</a></p>
		                                    	<p><?php echo $this->_tpl_vars['dpcValue']['record']['comment']; ?>
</p>
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td style="font: normal 11px tahoma"></td>
		                                </tr>
	                            	<?php endforeach; endif; unset($_from); ?>
	                        	</table>
	                       	<?php else: ?>
	                            <div id="selMsgAlert">
	                            	<p><?php echo $this->_tpl_vars['LANG']['viewprofile_comments_no_msg']; ?>
</p>
	                            </div>
	                        <?php endif; ?>
                        </td>
                    </tr>
           		</table>
            </td>
        </tr>
    </table>
<?php endif; ?>
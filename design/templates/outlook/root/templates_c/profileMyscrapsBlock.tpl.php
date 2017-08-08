<?php /* Smarty version 2.6.18, created on 2011-10-18 15:28:01
         compiled from profileMyscrapsBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'profileMyscrapsBlock.tpl', 54, false),array('modifier', 'date_format', 'profileMyscrapsBlock.tpl', 58, false),)), $this); ?>
<div class="clsScrapBookTable">
 <table cellspacing="0" <?php echo $this->_tpl_vars['myobj']->defaultTableBgColor; ?>
>
   <tr>
	  <th <?php echo $this->_tpl_vars['myobj']->defaultBlockTitle; ?>
>
	    <div class="clsScrapBookTitle"><?php echo $this->_tpl_vars['LANG']['myprofile_shelf_scraps']; ?>
</div>
		  <?php if ($this->_tpl_vars['defaulBlockObj']->form_show_profile['addcomment'] && ! $this->_tpl_vars['defaulBlockObj']->form_show_profile['is_blocked_user']): ?>
		   <p class="clsAddScrap"><a href="#" onclick="addProfileComment(this);return false;" id="anchorAddProfileComment"><?php echo $this->_tpl_vars['LANG']['viewprofile_msg_comment_post_link']; ?>
</a></p>			
		  <?php endif; ?>	          	
	   </th>	
	 </tr>  
	   <?php if ($this->_tpl_vars['defaulBlockObj']->form_show_profile['addcomment'] && ! $this->_tpl_vars['defaulBlockObj']->form_show_profile['is_blocked_user']): ?>
	  <tr>
	   <td>
        <div id="profileCommentLoader" style="display:none" class="clsAddScrapLoader"><img src="<?php echo $this->_tpl_vars['CFG']['site']['url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/images/loader.gif" alt="" title="" /></div>       	
	    <div id="commentHolder" class="clsScrapTextarea" style="display:none;">
			<textarea class="selInputLimiter" rows="4" cols="50" id="profileCommentTextArea" name="profileCommentTextArea" maxlimit="<?php echo $this->_tpl_vars['myobj']->CFG['profile']['scraps_total_length']; ?>
"></textarea>
            <label style="display:none" id="scrap_error_msg" for="profileCommentTextArea" generated="true" class="error"></label>
            <div class="clsScrapTextareaHelp"><?php echo $this->_tpl_vars['defaulBlockObj']->LANG['common_allowed_char_limit']; ?>
</div>                        
			<div class="clsProfileOverflow">
				<div class="clsListSubmitLeft">
				  <div class="clsListSubmitRight">
				    <input type="button" onclick="addScrap()" value="<?php echo $this->_tpl_vars['LANG']['viewprofile_ajax_comments_button_add']; ?>
" id="scrapAddAjax" />
				  </div>
				</div>
				<div class="clsListCancelLeft">
				  <div class="clsListCancelRight">
				    <input type="button" onclick="discardScrap()" value="<?php echo $this->_tpl_vars['LANG']['viewprofile_ajax_comments_button_cancel']; ?>
" />
			      </div>
				</div>
			  </div>
			</div>
	   </td>
	  </tr>	
	   <?php endif; ?>
	    <?php if ($this->_tpl_vars['comment_arr'] == 0): ?>
	    	<tr>
	        	<td>
					<div id="profileCommentsResponse"><div class="clsProfileTableInfo"><div id="selMsgAlert" class="">
	              		<p><?php echo $this->_tpl_vars['LANG']['viewprofile_comments_no_msg']; ?>
</p>
	            	</div></div></div>
				</td>
	        </tr>
	    <?php else: ?>
	        <tr>
	          	<td id="profileCommentsSection">
	          		<div id="profileCommentsResponse">
	                	<table class="clsScrapBook" id="<?php echo $this->_tpl_vars['CFG']['profile_box_id']['scraps_list']; ?>
">
	                 	<?php $_from = $this->_tpl_vars['comment_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item'] => $this->_tpl_vars['value']):
?>
	                  		<tr>
	                    		<td class="selProfileComment">
	                        		<div class="clsScrapBookContent">
	                            		<div class="clsFrameScrapBookThumb">
											<a class="ClsProfileImageContainer ClsProfileImageBorder1 ClsProfile45x45" href="<?php echo $this->_tpl_vars['value']['commentorProfileUrl']; ?>
" <?php echo $this->_tpl_vars['value']['online']; ?>
>
												<img onclick="Redirect2URL('<?php echo $this->_tpl_vars['value']['commentorProfileUrl']; ?>
')" src="<?php echo $this->_tpl_vars['value']['profileIcon']['s_url']; ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['user_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 5) : smarty_modifier_truncate($_tmp, 5)); ?>
" title="<?php echo $this->_tpl_vars['value']['user_name']; ?>
" <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(45,45,$this->_tpl_vars['value']['profileIcon']['s_width'],$this->_tpl_vars['value']['profileIcon']['s_height']); ?>
/>
											</a>
	                            		</div>
	                            		<div class="clsScrapBookThumbDetails">
											<p><a href="<?php echo $this->_tpl_vars['value']['commentorProfileUrl']; ?>
"><?php echo $this->_tpl_vars['value']['user_name']; ?>
</a> <span><?php echo ((is_array($_tmp=$this->_tpl_vars['value']['display_date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['format_datetime']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['format_datetime'])); ?>
</span></p>
	                                		<p><?php echo $this->_tpl_vars['value']['comment']; ?>
</p>
										</div>
	                        		</div>
	                    		</td>
	                  		</tr>
	                  	<?php endforeach; endif; unset($_from); ?>
	                	</table>
	                </div>
	          	</td>
	    	</tr>
	    <?php endif; ?>		   <tr>
	       	<td colspan="2" class="clsMoreBgCols">
	          <div id="profileTotalScrapsBlock" class="clsRootViewMoreLink" <?php if (! ( $this->_tpl_vars['defaulBlockObj']->form_show_profile['listcomment'] && $this->_tpl_vars['totalResults'] != 0 )): ?>style="display:none;"<?php endif; ?>>
			    <a href="<?php echo $this->_tpl_vars['profileCommentURL']; ?>
" ><?php echo $this->_tpl_vars['LANG']['viewprofile_link_view_all_comments']; ?>
 (<span id="spanMemberProfileTotalComments"> <?php echo $this->_tpl_vars['totalResults']; ?>
 </span>)</a>
			  </div>
			</td>
	      </tr>
	</table>
</div>
<?php if ($this->_tpl_vars['defaulBlockObj']->form_show_profile['addcomment'] && ! $this->_tpl_vars['defaulBlockObj']->form_show_profile['is_blocked_user']): ?>
	<?php echo '
		<script type="text/javascript" language="javascript">
			var scrapHolder = $Jq(\'#commentHolder\');
			var uid = \''; ?>
<?php echo $this->_tpl_vars['myobj']->form_show_profile['user_details_arr']['user_id']; ?>
<?php echo '\';
			var scraps = "&nbsp;";
			var anchorAdd = \'anchorAddProfileComment\';
			function addProfileComment(){
				$Jq(\'#scrap_error_msg\').css(\'display\', \'none\');
				if(scrapHolder.css(\'display\') == \'\'){
					scrapHolder.hide();
					$Jq(\'#profileCommentTextArea\').val(\'\');
				}else{
					scrapHolder.show()
					$Jq(\'#scrapAddAjax\').focus()
					$Jq(\'#profileCommentTextArea\').focus();
				}
			};
			function addScrap(){
				txt = Trim($Jq(\'#profileCommentTextArea\').val());
				txt = encodeURIComponent(txt);
				if(txt.length > 0){
					openAjaxWindow(\'true\', \'ajaxupdate\', \'updateCommentsAndCommentSection\', txt);
					//updateCommentsAndCommentSection(txt);
					$Jq(\'#scrap_error_msg\').hide();
					discardScrap();
					showCommentLoader();
				} else {
					$Jq(\'#profileCommentTextArea\').val(\'\');
					$Jq(\'#scrap_error_msg\').html(\''; ?>
<?php echo $this->_tpl_vars['LANG']['profile_add_comment_error_message']; ?>
<?php echo '\');
					$Jq(\'#scrap_error_msg\').show();
				}
			};
			function discardScrap(){
			   $Jq(\'#scrap_error_msg\').css(\'display\', \'none\');
				scrapHolder.hide();
				$Jq(\'#profileCommentTextArea\').val(\'\');
			};
			function showCommentLoader(){
				$Jq(\'#profileCommentLoader\').show();
				$Jq("#"+anchorAdd).hide();
			};
			function hideCommentLoader(){
				$Jq(\'#profileCommentLoader\').hide();
				$Jq("#"+anchorAdd).show();
			};
			function updateCommentsAndCommentSection(){
				//assign the txt value from global array callBackArguments
				txt = callBackArguments[0];
				var query = \'\';
				pars = \'ajxComment=1&u=\'+uid+\'&comment=\'+txt;
				url = cfg_site_url + \'profileCommentsResponse.php\';

				$Jq.ajax({
					type: "POST",
				   	url: url,
				   	data: pars,
				   	success: function(originalRequest){
						    	commentsUpdated(originalRequest);
						   	}
				});
			};
			function commentsUpdated(originalRequest){
				data = originalRequest;
				hideCommentLoader();
				$Jq(\'#profileCommentsResponse\').html(data);

				pars = \'ajxUpdateCommentCount=1&u=\'+uid;
				url = cfg_site_url + \'profileCommentsResponse.php\';
				$Jq.ajax({
					type: "POST",
				   	url: url,
				   	data: pars,
				   	success: function(originalRequest){
						    	$Jq(\'#spanMemberProfileTotalComments\').html(originalRequest);
								$Jq(\'#profileTotalScrapsBlock\').show();
						   	}
				});
			}; //function
		</script>
	'; ?>

<?php endif; ?>
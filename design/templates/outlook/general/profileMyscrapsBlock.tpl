<div class="clsScrapBookTable">
 <table cellspacing="0" {$myobj->defaultTableBgColor}>
   <tr>
	  <th {$myobj->defaultBlockTitle}>
	    <div class="clsScrapBookTitle">{$LANG.myprofile_shelf_scraps}</div>
		  {if $defaulBlockObj->form_show_profile.addcomment && !$defaulBlockObj->form_show_profile.is_blocked_user}
		   <p class="clsAddScrap"><a href="#" onclick="addProfileComment(this);return false;" id="anchorAddProfileComment">{$LANG.viewprofile_msg_comment_post_link}</a></p>			
		  {/if}	          	
	   </th>	
	 </tr>  
	   {if $defaulBlockObj->form_show_profile.addcomment && !$defaulBlockObj->form_show_profile.is_blocked_user}
	  <tr>
	   <td>
        <div id="profileCommentLoader" style="display:none" class="clsAddScrapLoader"><img src="{$CFG.site.url}/design/templates/{$CFG.html.template.default}/images/loader.gif" alt="" title="" /></div>       	
	    <div id="commentHolder" class="clsScrapTextarea" style="display:none;">
			<textarea class="selInputLimiter" rows="4" cols="50" id="profileCommentTextArea" name="profileCommentTextArea" maxlimit="{$myobj->CFG.profile.scraps_total_length}"></textarea>
            <label style="display:none" id="scrap_error_msg" for="profileCommentTextArea" generated="true" class="error"></label>
            <div class="clsScrapTextareaHelp">{$defaulBlockObj->LANG.common_allowed_char_limit}</div>                        
			<div class="clsProfileOverflow">
				<div class="clsListSubmitLeft">
				  <div class="clsListSubmitRight">
				    <input type="button" onclick="addScrap()" value="{$LANG.viewprofile_ajax_comments_button_add}" id="scrapAddAjax" />
				  </div>
				</div>
				<div class="clsListCancelLeft">
				  <div class="clsListCancelRight">
				    <input type="button" onclick="discardScrap()" value="{$LANG.viewprofile_ajax_comments_button_cancel}" />
			      </div>
				</div>
			  </div>
			</div>
	   </td>
	  </tr>	
	   {/if}
	    {if $comment_arr==0}
	    	<tr>
	        	<td>
					<div id="profileCommentsResponse"><div class="clsProfileTableInfo"><div id="selMsgAlert" class="">
	              		<p>{$LANG.viewprofile_comments_no_msg}</p>
	            	</div></div></div>
				</td>
	        </tr>
	    {else}
	        <tr>
	          	<td id="profileCommentsSection">
	          		<div id="profileCommentsResponse">
	                	<table class="clsScrapBook" id="{$CFG.profile_box_id.scraps_list}">
	                 	{foreach key=item item=value from=$comment_arr}
	                  		<tr>
	                    		<td class="selProfileComment">
	                        		<div class="clsScrapBookContent">
	                            		<div class="clsFrameScrapBookThumb">
											<a class="ClsProfileImageContainer ClsProfileImageBorder1 ClsProfile45x45" href="{$value.commentorProfileUrl}" {$value.online}>
												<img onclick="Redirect2URL('{$value.commentorProfileUrl}')" src="{$value.profileIcon.s_url}" alt="{$value.user_name|truncate:5}" title="{$value.user_name}" {$myobj->DISP_IMAGE(45, 45, $value.profileIcon.s_width, $value.profileIcon.s_height)}/>
											</a>
	                            		</div>
	                            		<div class="clsScrapBookThumbDetails">
											<p><a href="{$value.commentorProfileUrl}">{$value.user_name}</a> <span>{$value.display_date_added|date_format:#format_datetime#}</span></p>
	                                		<p>{$value.comment}</p>
										</div>
	                        		</div>
	                    		</td>
	                  		</tr>
	                  	{/foreach}
	                	</table>
	                </div>
	          	</td>
	    	</tr>
	    {/if}{* comment_arr condition closed *}
		   <tr>
	       	<td colspan="2" class="clsMoreBgCols">
	          <div id="profileTotalScrapsBlock" class="clsRootViewMoreLink" {if !($defaulBlockObj->form_show_profile.listcomment && $totalResults neq 0)}style="display:none;"{/if}>
			    <a href="{$profileCommentURL}" >{$LANG.viewprofile_link_view_all_comments} (<span id="spanMemberProfileTotalComments"> {$totalResults} </span>)</a>
			  </div>
			</td>
	      </tr>
	</table>
</div>
{if $defaulBlockObj->form_show_profile.addcomment && !$defaulBlockObj->form_show_profile.is_blocked_user}
	{literal}
		<script type="text/javascript" language="javascript">
			var scrapHolder = $Jq('#commentHolder');
			var uid = '{/literal}{$myobj->form_show_profile.user_details_arr.user_id}{literal}';
			var scraps = "&nbsp;";
			var anchorAdd = 'anchorAddProfileComment';
			function addProfileComment(){
				$Jq('#scrap_error_msg').css('display', 'none');
				if(scrapHolder.css('display') == ''){
					scrapHolder.hide();
					$Jq('#profileCommentTextArea').val('');
				}else{
					scrapHolder.show()
					$Jq('#scrapAddAjax').focus()
					$Jq('#profileCommentTextArea').focus();
				}
			};
			function addScrap(){
				txt = Trim($Jq('#profileCommentTextArea').val());
				txt = encodeURIComponent(txt);
				if(txt.length > 0){
					openAjaxWindow('true', 'ajaxupdate', 'updateCommentsAndCommentSection', txt);
					//updateCommentsAndCommentSection(txt);
					$Jq('#scrap_error_msg').hide();
					discardScrap();
					showCommentLoader();
				} else {
					$Jq('#profileCommentTextArea').val('');
					$Jq('#scrap_error_msg').html('{/literal}{$LANG.profile_add_comment_error_message}{literal}');
					$Jq('#scrap_error_msg').show();
				}
			};
			function discardScrap(){
			   $Jq('#scrap_error_msg').css('display', 'none');
				scrapHolder.hide();
				$Jq('#profileCommentTextArea').val('');
			};
			function showCommentLoader(){
				$Jq('#profileCommentLoader').show();
				$Jq("#"+anchorAdd).hide();
			};
			function hideCommentLoader(){
				$Jq('#profileCommentLoader').hide();
				$Jq("#"+anchorAdd).show();
			};
			function updateCommentsAndCommentSection(){
				//assign the txt value from global array callBackArguments
				txt = callBackArguments[0];
				var query = '';
				pars = 'ajxComment=1&u='+uid+'&comment='+txt;
				url = cfg_site_url + 'profileCommentsResponse.php';

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
				$Jq('#profileCommentsResponse').html(data);

				pars = 'ajxUpdateCommentCount=1&u='+uid;
				url = cfg_site_url + 'profileCommentsResponse.php';
				$Jq.ajax({
					type: "POST",
				   	url: url,
				   	data: pars,
				   	success: function(originalRequest){
						    	$Jq('#spanMemberProfileTotalComments').html(originalRequest);
								$Jq('#profileTotalScrapsBlock').show();
						   	}
				});
			}; //function
		</script>
	{/literal}
{/if}
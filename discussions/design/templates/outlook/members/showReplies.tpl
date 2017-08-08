<div id="showRepliesDiv">
     <div class="clsShowReplies">
    					<!-- tabs start -->
        <table summary="{$LANG.board_details_tbl}" class="clsSolutionTable">
			<tr class="">
            	<td>
				<table class="clsSolutionFirstColTable">
					<tr class="clsViewBestRow">
						<td class="clsSolutionFirtCol">
							<div class="clsSolnUserDetails">
		                        <p class="clsSolnUserInfo">
		                        <span class="clsSolnUserName">
		                        <a href="{$myobj->form_board.displayBoardDetails_arr.mysolutions.url}">{$myobj->form_board.displayBoardDetails_arr.asked_by_manual}</a></span>
		                        </p>
		                        <p class="clsSolnUserInfo">{$LANG.discuzz_common_solutions}: <span class="clsValue">{$myobj->form_board.displayBoardDetails_arr.total_posts}</span></p>
		                    	<p class="clsSolnUserInfo clsDateFixedWidth">{$LANG.solutions_joined_on}: <span class="clsValue">{$myobj->form_board.displayBoardDetails_arr.user_doj}</span></p>
		                    </div>
						</td>
						<td class="clsSolutionSecondCol">
		                	<div class="">
		                        <div class="clsReplayHeading">
		                        	<div>
			                        <p class="clsQuestionBox">{$myobj->board_details.board_wrap}</p>
			                        <div class="clsClearFix">
		                            <p class="clsQuestionDescription">{$myobj->form_board.displayBoardDetails_arr.description_manual}</p>
		                            </div>
		                        </div>
		                    </div>
		               	    <!--start attachment-->
		                    <div id="allAttachments">
		                        <div class="clsReplies">
		                            {if $myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments}
		                                <div class="clsViewReplies clsClearFix">
								  		{foreach key=fAqkey item=fAqvalue  from=$myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments}
								  			{if (in_array($fAqvalue.extern, $CFG.admin.attachments.image_formats))}
							               <div class="cls90x90thumbImage clsThumbImageOuter clsAttachContainer clsPointer">
		                                    	<div class="clsThumbImageMiddle">
		                                        	<div class="clsThumbImageInner">
		                                  				<a href="{$fAqvalue.attachment_path}" class="lightwindow" rel="gallery['{$fAqvalue.gallery}']" ><img src="{$fAqvalue.image_path}" alt="" /></a>
		                                  			</div>
		                              			</div>
		                                  </div>
		                                  	{/if}
								  		{/foreach}
										{foreach key=fAqkey item=fAqvalue  from=$myobj->form_board.displayBoardDetails_arr.fetchMoreAttachments}
											<ul>
											{if (!in_array($fAqvalue.extern, $CFG.admin.attachments.image_formats))}
												<li class="clsDocText"><a href="{$fAqvalue.attachment_original_path}" target="_blank">{$fAqvalue.attachment_name}</a></li>
											{/if}
											</ul>
							          	{/foreach}
								  </div>
		                            {/if}
		                        </div>
		                    </div>
		                    <!--end attachments -->
		                </td>
					</tr>
				</table>
      		</td>
		</tr>
{if $myobj->isResultsFound()}
		<tr>
			<td>
			<div class="clsClearFix clsSolutionListingReplied">
				<div class="clsFloatLeft"><p class="clsSolutionReplied">Replied</p></div>
				<div class="clsFloatRight">{include file='../general/pagination.tpl'}</div>
			</div>
			</td>
		</tr>
		{foreach key=fAkey item=fAvalue  from=$showReplies_arr.displayAllSolutions_arr}
        	<tr class="">
            	<td class="clsSolutionTableHeader">
				<table>
			<tr class="{$fAvalue.row_class}">
            	<td class="clsSolutionFirtCol">
                    <div class="clsSolnUserDetails">
                    <p class="clsSolnUserInfo">
						<span class="clsSolnUserName">
							<a href="{$fAvalue.mysolutions.url}">{$fAvalue.row_solutioned_by_manual}</a>
						</span>
					</p>
					<p class="clsSolnUserInfo">{$LANG.discuzz_common_solutions}: <span class="clsValue">{$fAvalue.total_posts}</span></p>
                    <p class="clsSolnUserInfo clsDateFixedWidth">{$LANG.solutions_joined_on}: <span class="clsValue">{$fAvalue.user_doj}</span></p>
                    </div>
				</td>
				<td class="clsSolutionSecondCol">
                	<div class="clsReplayHeading">
                    	<!-- solutionmore div start-->
                    	<div id="solutionmore{$fAvalue.ansId}">
                        	<div class="">
                                <div class="">
										<p class="clsSolutionDescription">
											{$fAvalue.row_solution_manual}
										</p>
										<a href="{$myobj->getCurrentUrl()}" id="{$fAvalue.anchor}"></a>
										{if $fAvalue.fetchMoreAttachments}
										<div class="clsClearFix">
											{foreach key=fAkey item=fAavalue  from=$fAvalue.fetchMoreAttachments}
												{if (in_array($fAavalue.extern, $CFG.admin.attachments.image_formats))}
										            <div class="cls90x90thumbImage clsThumbImageOuter clsAttachContainer clsPointer">
				                                    	<div class="clsThumbImageMiddle">
				                                        	<div class="clsThumbImageInner">
																<a href="{$fAavalue.attachment_path}" class="lightwindow" rel="gallery['{$fAavalue.gallery}']" ><img src="{$fAavalue.image_path}" alt="" /></a>
															</div>
														</div>
													</div>
												{/if}
								          	{/foreach}
											{foreach key=fAkey item=fAavalue  from=$fAvalue.fetchMoreAttachments}
												<ul>
												{if (!in_array($fAavalue.extern, $CFG.admin.attachments.image_formats))}
													<li class="clsDocText"><a href="{$fAavalue.attachment_original_path}" target="_blank">{$fAavalue.attachment_name}</a></li>
												{/if}
												</ul>
								          	{/foreach}
											</div>
									  	{/if}
						 			</div>
                     			</div>
                        </div>
						<!-- solutionmore div end-->
						<div id="{$fAvalue.commentSpanIDId}" class="clsNoBorder"></div>
									{if $CFG.admin.solutions_comment.allowed}
										<div class="clsBubInfoTitle " id="msg{$fAvalue.commentSpanIDId}">
											{if $fAvalue.populateCommentList}
												{foreach key=farlkey item=farlvalue from=$fAvalue.populateCommentList}
													<div class="clsSolutionCommentDetails clsCommentSolutionDisplay">
														<div class="clsUserThumbDetails">
															<div class="clsUserDetails clsClearFix">
																<p class="clsSolutionPost">
																	<span class="">
																		{$LANG.solutions_comment_replied_by}: <span class="clsUserName"><a href="{$farlvalue.mysolutions.url}">{$farlvalue.user_details.display_name}</a></span>
																	</span>
																	<span>{$LANG.discuzz_common_date_added}: {$farlvalue.record.date_added}</span>
																</p>
																<p class="clsCommentText"><span class="">{$farlvalue.record.comment}</span></p>
													  	   	</div>
												  		</div>
													</div>
		                                	  	{/foreach}
											{/if}
	                              	 	</div>
								   	{/if}
				 				</div>
				 			</div>
             			</div>
                    </div>
					<!-- solutions div end-->
                </td>
            </tr>
				</table>
				</td>
					</tr>
        {/foreach}
    	</table>
    {else}
     		<tr>
			<tr class="clsNoBorder">
            	<td class="clsSolutionTableHeader">
				<table>
     			<td colspan="3">
				    <div id="selMsgAlert">
		              <p>{$LANG.solutions_not_added}.
					  </p>
		            </div>
		        </td>
		    </tr>
				</table>
				</td>
			</tr>
		</table>
	{/if}
	</table>
</div>
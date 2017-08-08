<div class="clsCommonIndexRoundedCorner">
  <!--rounded corners-->
{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_top'}
					<!-- tabs start -->
                    <div id="selQuickLinks"  class="clsBoardsLink">
                        <h3>
							<span>{$LANG.related_boards_title}</span>
                        </h3>
                    </div>
                    <!-- tabs end -->
					 <div class="clsCommonTableContainer" id = "popular_boards" style="display:block;">
                    <table cellspacing="0" cellpadding="0" class="clsCommonTable">
                     {if $myobj->form_board.displayRelatedBoards_arr}
						  <tr>
		                    <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
		                    <th class="clsStartByTittle">{$LANG.boards_title}</th>
		                    <th class="clsLastPostTittle">{$LANG.startedby}</th>
		                    <th class="clsLastPostTittle">{$LANG.index_last_posts}</th>
		                    <th class="clsRepliesTittle">{$LANG.discuzz_common_solutions}</th>
		                    <th class="clsViewsTittle">{$LANG.index_views}</th>
		                    <th class="clsRatingTittle"><span class="clsRatingStar">{$LANG.index_ratings}</span></th>
		                  </tr>

						{foreach key=daqkey item=daqvalue from=$myobj->form_board.displayRelatedBoards_arr}
						      <tr class="{if $iteration eq 0}clsOdd{assign var="iteration" value="1"}{elseif $iteration eq 1}clsEven{assign var="iteration" value="0"}{/if}"> 
                                <td class="clsIconValue {$daqvalue.appendIcon}"><div class="{$daqvalue.legendIcon}"></div></td>
                                <td class="clsStartByValue">
									<p class="clsBoardLink"><span><a href="{$daqvalue.solution.url}">{$daqvalue.row_board_manual}</a>&nbsp;{$daqvalue.bestIcon}</span></p>
                                </td>
                                <td>
									<p class="clsAskBy">
										<a href="{$daqvalue.mysolutions.url}">{$daqvalue.row_asked_by_manual}</a>
                                    </p>
                                </td>
                                <td class="clsLastPostValue">
                                	{if $daqvalue.last_post_by neq ''}
										<span class="clsLatPostTime">{$daqvalue.last_post_on}</span>
										<p class="clsAskBy"><span class="clsLastAskby">{$LANG.index_by} </span> {$daqvalue.last_post_by}</p>
									{/if}
								</td>
                                <td class="clsRepliesValue">{$daqvalue.record.total_solutions}</td>
                                <td  class="clsViewsValue">{$daqvalue.record.total_views}</td>
                                <td class="clsRatingValue">{$daqvalue.record.total_stars}</td>
                              </tr>
			              {/foreach}

			              {else}
			              	<div id="selMsgAlert">
			                	<p>{$LANG.boards_no_records}</p>
			            	</div>
			              {/if}
					</table>
					{if $myobj->form_board.related_more_link neq ''}
						<div class="clsMoreGreen"><span><a href="{$myobj->form_board.related_more_link}">{$LANG.common_more}</a></span></div>
					{/if}
					</div>
		{$myobj->setTemplateFolder('general/', 'discussions')}
                {include file='box.tpl' opt='topanalyst_bottom'}		
  <!--end of rounded corners-->
</div>
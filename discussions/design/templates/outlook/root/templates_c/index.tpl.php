<?php /* Smarty version 2.6.18, created on 2011-12-16 01:21:07
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'index.tpl', 35, false),)), $this); ?>
<?php $this->assign('iteration', '0'); ?>
<?php if (! isAjax ( )): ?>
<div id="selIndex">
<?php endif; ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_best_solution')): ?>
		<div id="selWidget">
		   	<div class="clsCommonIndexRoundedCorner"> <!--rounded corners-->
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'bestsolution_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                	<!-- tabs start -->
					<div class="clsBestBoardLink">
						<h3>
							<span id="selBestBoardsLI" class="clsBestSolutions"><?php echo $this->_tpl_vars['LANG']['discuzz_common_best_boards']; ?>
</span>
						</h3><span id="paginate-slider1" class="pagination" ></span>
					</div>
					<!-- tabs end -->
 					<div class="clsIndexPopular">
  						<div class="" id="sliderbestSolutions">
							<?php if ($this->_tpl_vars['myobj']->form_best_solution['displayBestSolutions']['recent_boards']): ?>

								<div id="slider1" class="sliderwrapper">
									<div class="contentdiv">
									<?php $_from = $this->_tpl_vars['myobj']->form_best_solution['displayBestSolutions']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
									<?php if (isset ( $this->_tpl_vars['value']['boardDetails'] )): ?>
											<div class="clsBestSolutionContainer">
												<div class="clsBestSolutionContent">
											  		<p class="clsPNGImage"><span class="clsBestLink"><?php echo $this->_tpl_vars['value']['boardDetails']['best_board_link']; ?>
</span> -
													  <span class="clsBestPostedBy"><?php echo $this->_tpl_vars['LANG']['index_posted_by']; ?>
 <?php echo $this->_tpl_vars['value']['boardDetails']['asked_by_link']; ?>
</span>
 													  <span class="clsRatingBlock"><?php echo $this->_tpl_vars['discussion']->populateBoardRatingImages($this->_tpl_vars['value']['boardDetails']['rating_count'],'board','','#','discussions'); ?>
<?php echo $this->_tpl_vars['value']['boardDetails']['rating_count']; ?>
 <?php echo $this->_tpl_vars['LANG']['index_ratings']; ?>
</span>
                                                      <!--<span class="clsRatingDefault"></span>-->
													</p>


													<p class="clsSolutionContainer"><span class="clsSolution"><?php echo $this->_tpl_vars['LANG']['index_solution']; ?>
:</span> <?php echo ((is_array($_tmp=$this->_tpl_vars['value']['wordWrapManual_solution'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 70) : smarty_modifier_truncate($_tmp, 70)); ?>
<span class="clsSolutionMore"> <a href="<?php echo $this->_tpl_vars['value']['solution_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['common_more']; ?>
</a></span></p>
													<p class="">
                                                    <span class="clsAddedBy"><?php echo $this->_tpl_vars['LANG']['index_added_by']; ?>
 <?php echo $this->_tpl_vars['value']['solutionDetails']['solutioned_by_link']; ?>
 <?php echo $this->_tpl_vars['LANG']['index_on']; ?>

                                                    <?php echo $this->_tpl_vars['myobj']->getTimeDiffernceFormat($this->_tpl_vars['value']['solutionDetails']['solution_added']); ?>
</span>
                                                    <span class="clsRatingBlock"><?php echo $this->_tpl_vars['discussion']->populateSolutionRatingImages($this->_tpl_vars['value']['solutionDetails']['rating_count'],'solution','','#','discussions',$this->_tpl_vars['value']['solutionDetails']['solution_id']); ?>
<?php echo $this->_tpl_vars['value']['solutionDetails']['rating_count']; ?>
 <?php echo $this->_tpl_vars['LANG']['index_ratings']; ?>
</span>
                                                   <!-- <span class="clsRatingGreen"></span>-->

                                                    </p>
												</div>

                                            </div>
								  		<?php if ($this->_tpl_vars['value']['incr'] % $this->_tpl_vars['CFG']['admin']['index']['best_ans_boards_display_count'] == '0'): ?>
								  			<?php if ($this->_tpl_vars['myobj']->form_best_solution['displayBestSolutions']['total_recs'] > $this->_tpl_vars['value']['incr']): ?>
										  		</div>
												<div class="contentdiv">
											<?php endif; ?>
										<?php endif; ?>
									<?php endif; ?>
						 			<?php endforeach; endif; unset($_from); ?>
						 				</div>
								</div>
								<div id="pag" class="pagination"></div>
								<?php if ($this->_tpl_vars['myobj']->form_best_solution['displayBestSolutions']['have_boards']): ?>
									<div class="clsMoreGreen"> <span><a href="<?php echo $this->_tpl_vars['myobj']->form_best_solution['displayBestSolutions']['boards_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_more_best_solutions']; ?>
</a></span>
                                    </div>
								<?php endif; ?>
							<?php endif; ?>
							<?php if (! $this->_tpl_vars['myobj']->form_best_solution['displayBestSolutions']['have_boards']): ?>
								<div class="clsNoRecords"><p><?php echo $this->_tpl_vars['LANG']['discuzz_common_no_best_boards']; ?>
</p></div>
							<?php endif; ?>
						</div>
					</div>
				<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'bestsolution_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		   	</div> <!--end of rounded corners-->
		</div>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_top_discussion')): ?>
	<div class="clsCommonIndexRoundedCorner clsClearFix">
	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

     <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'topanalyst_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="clsBoardsLink">
		<h3>
			<a id="selTopDiscussionsLI" href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" onclick="$Jq('#selTopDiscussions').toggle('slow'); return false;" title="<?php echo $this->_tpl_vars['LANG']['click_here_show_hide']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_top_discussions_title']; ?>
</a>
		</h3>
	</div>
	<div id="selTopDiscussions" class="clsCommonIndexSection" <?php echo $this->_tpl_vars['myobj']->form_top_discussion['topdiscussionQStyle']; ?>
>
		<div id="selWidgetTopdiscussions" class="">
			<?php if ($this->_tpl_vars['myobj']->form_top_discussion['displayTopDiscussions']): ?>
                <div class="clsCommonTableContainer" id="top_discussions" style="display: block;">
                <table cellspacing="0" cellpadding="0" class="clsCommonTable">
					  <tr>
	                    <th class="clsIconTittle"><div class="clsIconDiscussion"></div></th>
	                    <th class="clsStartByTittle"><?php echo $this->_tpl_vars['LANG']['index_startedby']; ?>
</th>
	                    <th  class="clsLastPostTittle"><?php echo $this->_tpl_vars['LANG']['index_last_posts']; ?>
</th>
	                    <th  class="clsViewsTittle"><?php echo $this->_tpl_vars['LANG']['discuzz_common_boards']; ?>
</th>
	                    <th  class="clsRepliesTittle"><?php echo $this->_tpl_vars['LANG']['discuzz_common_solutions']; ?>
</th>
	                  </tr>
					<?php $_from = $this->_tpl_vars['myobj']->form_top_discussion['displayTopDiscussions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                       <tr class="<?php if ($this->_tpl_vars['iteration'] == 0): ?>clsOdd<?php $this->assign('iteration', '1'); ?><?php elseif ($this->_tpl_vars['iteration'] == 1): ?>clsEven<?php $this->assign('iteration', '0'); ?><?php endif; ?>">
							<td class="clsIconValue"><div class="clsIconDiscussion"></div></td>
    	                    <td class="clsStartByValue"><p class="clsBoardLink"><span class=""><a href="<?php echo $this->_tpl_vars['value']['discussionBoards']['url']; ?>
"> <?php echo $this->_tpl_vars['value']['discussionBoards']['title']; ?>
</a>&nbsp;</span></p>
                          	<p class="clsAskBy"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['value']['myanswers']['url']; ?>
"><?php echo $this->_tpl_vars['value']['post_name']; ?>
</a></p>
                            </td>
                            <td class="clsLastPostValue">
                            <?php if ($this->_tpl_vars['value']['last_post_user'] != ''): ?>
                              <span class="clsLastPostDate"><?php echo $this->_tpl_vars['value']['last_post_date_only']; ?>
,</span>
							  <span class="clsLatPostTime"><?php echo $this->_tpl_vars['value']['last_post_time_only']; ?>
</span>
							  <p class="clsAskBy"><span class="clsLastAskby"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 </span> <a href="<?php echo $this->_tpl_vars['value']['lastPost']['url']; ?>
"><?php echo $this->_tpl_vars['value']['last_post_user']; ?>
</a></p>
							<?php endif; ?>
							</td>
                            <td class="clsViewsValue"><?php echo $this->_tpl_vars['value']['total_boards']; ?>
</td>
							<td class="clsRepliesValue"><?php echo $this->_tpl_vars['value']['total_solutions']; ?>
</td>
                        </tr>
					<?php endforeach; endif; unset($_from); ?>
 				</table>
					<?php if ($this->_tpl_vars['myobj']->form_top_discussion['displayTopDiscussions']): ?>
                        <div class="clsMoreGreen"><span><a href="<?php echo $this->_tpl_vars['myobj']->form_top_discussion['discussions_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_more_top_discussion']; ?>
</a></span></div>
					<?php endif; ?>
                    </div>
				<?php endif; ?>
				<?php if (! $this->_tpl_vars['myobj']->form_top_discussion['displayTopDiscussions']): ?>
             		<div class="clsNoRecords"><p><?php echo $this->_tpl_vars['LANG']['discuzz_common_no_dicussions_added']; ?>
</p>
					</div>
				<?php endif; ?>
            </div>
		</div>
		<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'topanalyst_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recent_boards')): ?>
		<?php if (! isAjax ( )): ?>
        	<div class="clsCommonIndexRoundedCorner clsClearFix clsIndexBoardContainer">
          	<!--rounded corners-->
    			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'topanalyst_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<!-- tabs start -->
					<div class="clsBoardsLink clsIndexBoardsHead">
						<h3>
							<a id="selRecentBoardsLI" href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" onclick="$Jq('#selRecentBoards').toggle('slow'); return false;" title="<?php echo $this->_tpl_vars['LANG']['click_here_show_hide']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_recent_board_title']; ?>
</a>
						</h3>
					</div>
					<!-- tabs end -->
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recent_boards') || $this->_tpl_vars['myobj']->isShowPageBlock('form_popular_boards')): ?>
		<div id="selRecentBoards" class="clsCommonIndexSection" <?php echo $this->_tpl_vars['myobj']->form_recent_boards['recentQStyle']; ?>
>
                <ul class="clsJQCarouselTabs clsOverflow clsOtherTabs clsIndexBoardsTab">
                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recent_boards')): ?>
                    <li><a href="#selWidgetRecentBoards"><span class="clsOuter"><span class="clsForums"><?php echo $this->_tpl_vars['LANG']['discuzz_common_recent_board_title']; ?>
</span></span></a></li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_popular_boards')): ?>
                    <li><a href="#selWidgetPopularBoards"><span class="clsOuter"><span class="clsBlogs"><?php echo $this->_tpl_vars['LANG']['discuzz_common_popular_board_title']; ?>
</span></span></a></li>
                    <?php endif; ?>
                </ul>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recent_boards')): ?>
                    <div id="selWidgetRecentBoards" class="clsClearLeft">
                        <?php if ($this->_tpl_vars['myobj']->form_recent_boards['displayRecentBoards']['recent_boards']): ?>
                        <div class="clsCommonTableContainer" id="recent_board" style="display: block;">
                        <table cellspacing="0" cellpadding="0" class="clsCommonTable">
                              <tr>
                            <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                            <th class="clsStartByTittle"><?php echo $this->_tpl_vars['LANG']['index_startedby']; ?>
</th>
                            <th  class="clsLastPostTittle"><?php echo $this->_tpl_vars['LANG']['index_last_posts']; ?>
</th>
                            <th  class="clsRepliesTittle"><?php echo $this->_tpl_vars['LANG']['discuzz_common_solutions']; ?>
</th>
                            <th  class="clsViewsTittle"><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
</th>
                            <th  class="clsRatingTittle"><span class="clsRatingStar"><?php echo $this->_tpl_vars['LANG']['index_ratings']; ?>
</span></th>
                          </tr>
        
                                    <?php $_from = $this->_tpl_vars['myobj']->form_recent_boards['displayRecentBoards']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        
                                              <tr class="<?php if ($this->_tpl_vars['iteration'] == 0): ?>clsOdd<?php $this->assign('iteration', '1'); ?><?php elseif ($this->_tpl_vars['iteration'] == 1): ?>clsEven<?php $this->assign('iteration', '0'); ?><?php endif; ?>">
                                        <td class="clsIconValue <?php echo $this->_tpl_vars['value']['boardDetails']['appendIcon']; ?>
"><div class="<?php echo $this->_tpl_vars['value']['boardDetails']['legendIcon']; ?>
"></div></td>
                                        <td class="clsStartByValue"><p class="clsBoardLink"><span  class=""><?php echo $this->_tpl_vars['value']['boardDetails']['board_link']; ?>
&nbsp;<?php echo $this->_tpl_vars['value']['boardDetails']['bestIcon']; ?>
</span></p>
                                                                    <p class="clsAskBy"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 <?php echo $this->_tpl_vars['value']['boardDetails']['asked_by_link']; ?>
</p>
                                        </td>
                                        <td class="clsLastPostValue">
                                                <?php if ($this->_tpl_vars['value']['boardDetails']['last_post_by'] != ''): ?>
                                                 <span class="clsLastPostDate"><?php echo $this->_tpl_vars['value']['boardDetails']['last_post_date_only']; ?>
,</span>
                                                 <span class="clsLatPostTime"><?php echo $this->_tpl_vars['value']['boardDetails']['last_post_time_only']; ?>
</span>
                                                 <p class="clsAskBy"><span class="clsLastAskby"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 </span> <?php echo $this->_tpl_vars['value']['boardDetails']['last_post_by']; ?>
</p>
                                                <?php endif; ?></td>
                                        <td class="clsRepliesValue"><?php echo $this->_tpl_vars['value']['boardDetails']['total_solutions']; ?>
</td>
                                        <td  class="clsViewsValue"><?php echo $this->_tpl_vars['value']['boardDetails']['total_views']; ?>
</td>
                                        <td class="clsRatingValue"><?php echo $this->_tpl_vars['value']['boardDetails']['rating_count']; ?>
</td>
                                      </tr>
                                    <?php endforeach; endif; unset($_from); ?>
                        </table>
        
                            <?php if ($this->_tpl_vars['myobj']->form_recent_boards['displayRecentBoards']['have_boards']): ?>
        
                                        <div class="clsMoreGreen"><span><a href="<?php echo $this->_tpl_vars['myobj']->form_recent_boards['displayRecentBoards']['boards_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_more_recent_boards']; ?>
</a></span></div>
                            <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (! $this->_tpl_vars['myobj']->form_recent_boards['displayRecentBoards']['have_boards']): ?>
                            <div class="clsNoRecords"><p><?php echo $this->_tpl_vars['LANG']['discuzz_common_no_recent_boards']; ?>
</p>
                            </div>
                        <?php endif; ?>
        
        
                    </div>
            	<?php endif; ?>
                <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_popular_boards')): ?>
                    <div id="selWidgetPopularBoards" class="clsClearLeft">
                            <?php if ($this->_tpl_vars['myobj']->form_popular_boards['displayPopularBoards']['popular_boards']): ?>
                            <div class="clsCommonTableContainer" id = "popular_boards" style="display:block;">
                            <table cellspacing="0" cellpadding="0" class="clsCommonTable">
                                  <tr>
                            <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                            <th class="clsStartByTittle"><?php echo $this->_tpl_vars['LANG']['index_startedby']; ?>
</th>
                            <th  class="clsLastPostTittle"><?php echo $this->_tpl_vars['LANG']['index_last_posts']; ?>
</th>
                            <th  class="clsRepliesTittle"><?php echo $this->_tpl_vars['LANG']['discuzz_common_solutions']; ?>
</th>
                            <th  class="clsViewsTittle"><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
</th>
                            <th  class="clsRatingTittle"><span class="clsRatingStar"><?php echo $this->_tpl_vars['LANG']['index_ratings']; ?>
</span></th>
                          </tr>
        
        
                                    <?php $_from = $this->_tpl_vars['myobj']->form_popular_boards['displayPopularBoards']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
        
                                        <tr class="<?php if ($this->_tpl_vars['iteration'] == 0): ?>clsOdd<?php $this->assign('iteration', '1'); ?><?php elseif ($this->_tpl_vars['iteration'] == 1): ?>clsEven<?php $this->assign('iteration', '0'); ?><?php endif; ?>">
										
                                        <td class="clsIconValue <?php echo $this->_tpl_vars['value']['boardDetails']['appendIcon']; ?>
"><div class="<?php echo $this->_tpl_vars['value']['boardDetails']['legendIcon']; ?>
"></div></td>
                                        <td class="clsStartByValue"><p class="clsBoardLink"><span><?php echo $this->_tpl_vars['value']['boardDetails']['board_link']; ?>
&nbsp;<?php echo $this->_tpl_vars['value']['boardDetails']['bestIcon']; ?>
</span></p>
                                                                    <p class="clsAskBy"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 <?php echo $this->_tpl_vars['value']['boardDetails']['asked_by_link']; ?>
</p>
                                        </td>
                                        <td class="clsLastPostValue">
                                                <?php if ($this->_tpl_vars['value']['boardDetails']['last_post_by'] != ''): ?>
                                                <span class="clsLastPostDate"><?php echo $this->_tpl_vars['value']['boardDetails']['last_post_date_only']; ?>
,</span>
                                                 <span class="clsLatPostTime"><?php echo $this->_tpl_vars['value']['boardDetails']['last_post_time_only']; ?>
</span>
                                                 <p class="clsAskBy"><span class="clsLastAskby"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 </span> <?php echo $this->_tpl_vars['value']['boardDetails']['last_post_by']; ?>
</p>
                                                <?php endif; ?></td>
                                        <td class="clsRepliesValue"><?php echo $this->_tpl_vars['value']['boardDetails']['total_solutions']; ?>
</td>
                                        <td  class="clsViewsValue"><?php echo $this->_tpl_vars['value']['boardDetails']['total_views']; ?>
</td>
                                        <td class="clsRatingValue"><?php echo $this->_tpl_vars['value']['boardDetails']['rating_count']; ?>
</td>
                                      </tr>
        
                                    <?php endforeach; endif; unset($_from); ?>
                                    </table>
        
                                <?php if ($this->_tpl_vars['myobj']->form_popular_boards['displayPopularBoards']['found']): ?>
                                  <div class="clsMoreGreen"><span class="clsMoreLink"><a href="<?php echo $this->_tpl_vars['myobj']->form_popular_boards['displayPopularBoards']['boards_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_more_popular_boards']; ?>
</a></span></div>
        
                                <?php endif; ?>
                                </div>
                            <?php endif; ?>
        
                            <?php if (! $this->_tpl_vars['myobj']->form_popular_boards['displayPopularBoards']['found']): ?>
                                <div class="clsNoRecords"><p><?php echo $this->_tpl_vars['LANG']['discuzz_common_no_popular_boards']; ?>
</p></div>
        
                            <?php endif; ?>
        
        
                    </div>
            	<?php endif; ?>
		</div>
        <script type="text/javascript">
			<?php echo '
				$Jq(window).load(function(){
					 attachJqueryTabs(\'selRecentBoards\');
				});
			'; ?>

		</script>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recent_boards')): ?>
		<?php if (! isAjax ( )): ?>
            	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'topanalyst_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    		<!--end of rounded corners-->
    		</div>
		<?php endif; ?>
	<?php endif; ?>

	<!-- code for third -->
	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recently_solutioned_boards')): ?>
		<?php if (! isAjax ( )): ?>
        	<div class="clsCommonIndexRoundedCorner clsClearFix">
          	<!--rounded corners-->
    			<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'topanalyst_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

					<!-- tabs start -->
					<div class="clsBoardsLink">
						<h3>
							<a id="selRecentlySolutionedLI" href="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" onclick="$Jq('#selRecentlySolutioned').toggle('slow'); return false;" title="<?php echo $this->_tpl_vars['LANG']['click_here_show_hide']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_recently_solutioned_board_title']; ?>
</a>
						</h3>
					</div>
					<!-- tabs end -->
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recently_solutioned_boards')): ?>
		<?php if (! isAjax ( )): ?>
			<div id="selRecentlySolutioned" class="clsCommonIndexSection" <?php echo $this->_tpl_vars['myobj']->form_recently_solutioned_boards['recentSolutionedQStyle']; ?>
>
		<?php endif; ?>
		<?php if (! $this->_tpl_vars['myobj']->form_recently_solutioned_boards['recentSolutionedQStyle']): ?>
		  <div id="selWidgetRecentlySolutioned" class="">

				<?php if ($this->_tpl_vars['myobj']->form_recently_solutioned_boards['displayRecentlySolutionedBoards']['recently_solutioned']): ?>
                <div class="clsCommonTableContainer" id="recently_solutioned" style="display: block;">
                 <table cellspacing="0" cellpadding="0" class="clsCommonTable">
                  <tr>
                    <th class="clsIconTittle"><div class="clsIconNewThread"></div></th>
                    <th class="clsStartByTittle"><?php echo $this->_tpl_vars['LANG']['index_startedby']; ?>
</th>
                    <th  class="clsLastPostTittle"><?php echo $this->_tpl_vars['LANG']['index_last_posts']; ?>
</th>
                    <th  class="clsRepliesTittle"><?php echo $this->_tpl_vars['LANG']['discuzz_common_solutions']; ?>
</th>
                    <th  class="clsViewsTittle"><?php echo $this->_tpl_vars['LANG']['index_views']; ?>
</th>
                    <th  class="clsRatingTittle"><span class="clsRatingStar"><?php echo $this->_tpl_vars['LANG']['index_ratings']; ?>
</span></th>
                  </tr>
							<?php $_from = $this->_tpl_vars['myobj']->form_recently_solutioned_boards['displayRecentlySolutionedBoards']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inc'] => $this->_tpl_vars['value']):
?>
                             <tr class="<?php if ($this->_tpl_vars['iteration'] == 0): ?>clsOdd<?php $this->assign('iteration', '1'); ?><?php elseif ($this->_tpl_vars['iteration'] == 1): ?>clsEven<?php $this->assign('iteration', '0'); ?><?php endif; ?>"> 
                                <td class="clsIconValue <?php echo $this->_tpl_vars['value']['boardDetails']['appendIcon']; ?>
"><div class="<?php echo $this->_tpl_vars['value']['boardDetails']['legendIcon']; ?>
"></div></td>
                                <td class="clsStartByValue"><p class="clsBoardLink"><span><?php echo $this->_tpl_vars['value']['boardDetails']['board_link']; ?>
&nbsp;<?php echo $this->_tpl_vars['value']['boardDetails']['bestIcon']; ?>
</span></p>
                                							<p class="clsAskBy"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 <?php echo $this->_tpl_vars['value']['boardDetails']['asked_by_link']; ?>
</p>
                                </td>
                                <td class="clsLastPostValue">
                                		<?php if ($this->_tpl_vars['value']['boardDetails']['last_post_by'] != ''): ?>
                                        <span class="clsLastPostDate"><?php echo $this->_tpl_vars['value']['boardDetails']['last_post_date_only']; ?>
,</span>
										 <span class="clsLatPostTime"><?php echo $this->_tpl_vars['value']['boardDetails']['last_post_time_only']; ?>
</span>
										 <p class="clsAskBy"><span class="clsLastAskby"><?php echo $this->_tpl_vars['LANG']['index_by']; ?>
 </span> <?php echo $this->_tpl_vars['value']['boardDetails']['last_post_by']; ?>
</p>
										<?php endif; ?></td>
                                <td class="clsRepliesValue"><?php echo $this->_tpl_vars['value']['boardDetails']['total_solutions']; ?>
</td>
                                <td  class="clsViewsValue"><?php echo $this->_tpl_vars['value']['boardDetails']['total_views']; ?>
</td>
                                <td class="clsRatingValue"><?php echo $this->_tpl_vars['value']['boardDetails']['rating_count']; ?>
</td>
                              </tr>
							<?php endforeach; endif; unset($_from); ?>
                            </table>

					<?php if ($this->_tpl_vars['myobj']->form_recently_solutioned_boards['displayRecentlySolutionedBoards']['have_recently_solutioned']): ?>
                      <div class="clsMoreGreen"><span><a href="<?php echo $this->_tpl_vars['myobj']->form_recently_solutioned_boards['displayRecentlySolutionedBoards']['boards_url']; ?>
"><?php echo $this->_tpl_vars['LANG']['discuzz_common_more_recent_solutions']; ?>
</a></span></div>

					<?php endif; ?>
                   </div>
				<?php endif; ?>
				<?php if (! $this->_tpl_vars['myobj']->form_recently_solutioned_boards['displayRecentlySolutionedBoards']['have_recently_solutioned']): ?>
					 		<div class="clsNoRecords"><p><?php echo $this->_tpl_vars['LANG']['discuzz_common_no_boards_with_recent_solutions']; ?>
</p>
					</div>

				<?php endif; ?>

		  </div>
		<?php endif; ?>
		<?php if (! isAjax ( )): ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_recently_solutioned_boards')): ?>
		<?php if (! isAjax ( )): ?>
            	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','discussions'); ?>

                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'topanalyst_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    		<!--end of rounded corners-->
    		</div>
		<?php endif; ?>
	<?php endif; ?>
	
<?php if (! isAjax ( )): ?>
</div>
<?php endif; ?>
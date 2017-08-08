<?php /* Smarty version 2.6.18, created on 2012-02-02 04:22:42
         compiled from articleList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'articleList.tpl', 15, false),array('modifier', 'truncate', 'articleList.tpl', 350, false),array('function', 'smartyTabIndex', 'articleList.tpl', 156, false),)), $this); ?>
<div id="selArticleList">
	<!--rounded corners-->
  	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_list_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<form id="seachAdvancedFilter" name="seachAdvancedFilter" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
		<input type="hidden" name="advanceFromSubmission" value="1"/>
    	<?php echo $this->_tpl_vars['myobj']->populateArticleListHidden($this->_tpl_vars['paging_arr']); ?>

    	<div class="clsOverflow">
      		<div class="clsArticleListHeading">
        		<h2><span>
                	<?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'userarticlelist'): ?>
          				<?php echo $this->_tpl_vars['LANG']['articlelist_title']; ?>

          			<?php else: ?>
          				<?php echo ((is_array($_tmp=$this->_tpl_vars['LANG']['articlelist_title'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>

          			<?php endif; ?>
                    </span>
                </h2>
      		</div>
      		<div class="clsArticleListHeadingRight">
        		<input type="hidden" name="default" id="default" value="<?php echo $this->_tpl_vars['myobj']->getFormField('default'); ?>
" />
        		<select id="articlelistselect" name="select" onchange="loadUrl(this)">
	      			<option value="<?php  echo getUrl('articlelist','?pg=articlenew','articlenew/','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == ''): ?> selected <?php endif; ?> >
                    	<?php echo $this->_tpl_vars['LANG']['header_nav_article_article_all']; ?>

                    </option>
          			<option value="<?php  echo getUrl('articlelist','?pg=articlerecent','articlerecent/','','article') ?>"<?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlerecent'): ?> selected <?php endif; ?> >
          				<?php echo $this->_tpl_vars['LANG']['header_nav_article_article_new']; ?>

                    </option>
          			<option value="<?php  echo getUrl('articlelist','?pg=articletoprated','articletoprated/','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articletoprated'): ?> selected <?php endif; ?> >
			          <?php echo $this->_tpl_vars['LANG']['header_nav_article_top_rated']; ?>

                    </option>
          			<option value="<?php  echo getUrl('articlelist','?pg=articlemostviewed','articlemostviewed/','','article') ?>"<?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostviewed'): ?> selected <?php endif; ?> >
          				<?php echo $this->_tpl_vars['LANG']['header_nav_article_most_viewed']; ?>

                    </option>
          			<option value="<?php  echo getUrl('articlelist','?pg=articlemostdiscussed','articlemostdiscussed/','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostdiscussed'): ?> selected <?php endif; ?> >
          				<?php echo $this->_tpl_vars['LANG']['header_nav_article_most_discussed']; ?>

                    </option>
          			<option value="<?php  echo getUrl('articlelist','?pg=articlemostfavorite','articlemostfavorite/','','article') ?>" <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostfavorite'): ?> selected <?php endif; ?> >
				       <?php echo $this->_tpl_vars['LANG']['header_nav_article_most_favorite']; ?>

                    </option>
        		</select>
      		</div>
    	</div>
    	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

    	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../general/information.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    	<?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostviewed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostdiscussed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostfavorite'): ?>
	    	<div class="clsArtilceTabs">
	      		<ul class="clsSubMenu clsArticleLinks">
	        		<li <?php echo $this->_tpl_vars['articleActionNavigation_arr']['articleMostViewed_0']; ?>
><a href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['articleActionNavigation_arr']['article_list_url_0']; ?>
');"><span><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_all_time']; ?>
</span></span></a></li>
	                <li <?php echo $this->_tpl_vars['articleActionNavigation_arr']['articleMostViewed_1']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['articleActionNavigation_arr']['article_list_url_1']; ?>
');"><span><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_today']; ?>
</span></span></a></li>
	                <li <?php echo $this->_tpl_vars['articleActionNavigation_arr']['articleMostViewed_2']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['articleActionNavigation_arr']['article_list_url_2']; ?>
');"><span><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_yesterday']; ?>
</span></span></a></li>
	                <li <?php echo $this->_tpl_vars['articleActionNavigation_arr']['articleMostViewed_3']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['articleActionNavigation_arr']['article_list_url_3']; ?>
');"><span><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_week']; ?>
</span></span></a></li>
	                <li <?php echo $this->_tpl_vars['articleActionNavigation_arr']['articleMostViewed_4']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['articleActionNavigation_arr']['article_list_url_4']; ?>
');"><span><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_month']; ?>
</span></span></a></li>
	                <li <?php echo $this->_tpl_vars['articleActionNavigation_arr']['articleMostViewed_5']; ?>
><a  href="javascript:void(0)" onclick="jumpAndSubmitForm('<?php echo $this->_tpl_vars['articleActionNavigation_arr']['article_list_url_5']; ?>
');"><span><span><?php echo $this->_tpl_vars['LANG']['header_nav_members_this_year']; ?>
</span></span></a></li>
			    </ul>
    		</div>
        	<?php echo '
	        <script type="text/javascript">
                function jumpAndSubmitForm(url)
                  {
                    document.seachAdvancedFilter.start.value = \'0\';
                    document.seachAdvancedFilter.action=url;
                    document.seachAdvancedFilter.submit();
                  }
                var subMenuClassName1=\'clsArticleListMenu\';
                var hoverElement1  = \'.clsArticleListMenu li\';
                loadChangeClass(hoverElement1,subMenuClassName1);
	        </script>
	        '; ?>

    	<?php endif; ?>

        <div id="advanced_search" class="clsAdvancedSearch">
        	<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

      	    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      		<div class="clsAdvancedSearchBg clsOverflow">
            <div class="clsAdvancedSearchField">
      			<table class="clsAdvancedFilterTable">
        			<tr>
                    	<td>
                        	<input class="clsTextBox" type="text" name="article_keyword" id="article_keyword" value="<?php if ($this->_tpl_vars['myobj']->getFormField('article_keyword') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('article_keyword'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['articlelist_keyword_field']; ?>
<?php endif; ?>" onblur="setOldValue('article_keyword')" onfocus="clearValue('article_keyword')"/>
                        </td>
                    </tr>
                    <tr>
                        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') != 'myarticles' && $this->_tpl_vars['myobj']->getFormField('pg') != 'toactivate' && $this->_tpl_vars['myobj']->getFormField('pg') != 'notapproved' && $this->_tpl_vars['myobj']->getFormField('pg') != 'draftarticle' && $this->_tpl_vars['myobj']->getFormField('pg') != 'infuturearticle' && $this->_tpl_vars['myobj']->getFormField('pg') != 'publishedarticle'): ?>
                        	<td><input class="clsTextBox" type="text" name="article_owner" id="article_owner" value="<?php if ($this->_tpl_vars['myobj']->getFormField('article_owner') != ''): ?><?php echo $this->_tpl_vars['myobj']->getFormField('article_owner'); ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['articlelist_article_created_by']; ?>
<?php endif; ?>" onblur="setOldValue('article_owner')"  onfocus="clearValue('article_owner')"/></td>
						<?php endif; ?>
                    </tr>
             </table>
             </div>
             <div class="clsAdvancedSearchBtn">
             <table>
                    <tr>
                    	<td colspan="2">
                        	<div class="clsSubmitLeft">
                            	<span class="clsSubmitRight">
                                	<input type="submit" name="avd_search" id="avd_search"  onclick="document.seachAdvancedFilter.start.value = '0';" value="<?php echo $this->_tpl_vars['LANG']['articlelist_search_categories_articles_submit']; ?>
" />
                               	</span>
                           	</div>
                   		</td>
                    </tr>
                    <tr>
                  	     <td>
                            <div class="clsCancelLeft">
                            	<span class="clsCancelRight">
                                	<?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlenew' && ! $this->_tpl_vars['myobj']->getFormField('cid') && ! $this->_tpl_vars['myobj']->getFormField('sid')): ?>
                                  		<input type="button" name="avd_reset" id="avd_reset" onclick="location.href='<?php echo $this->_tpl_vars['myobj']->getUrl('articlelist','?pg=articlenew','articlenew/','','article'); ?>
'" value="<?php echo $this->_tpl_vars['LANG']['articlelist_reset_submit']; ?>
" />
                                  	<?php else: ?>
                                  		<input type="submit" name="avd_reset" id="avd_reset" onclick="document.seachAdvancedFilter.start.value = '0';" value="<?php echo $this->_tpl_vars['LANG']['articlelist_reset_submit']; ?>
" />
                                  	<?php endif; ?>
                                </span>
                            </div>
                        </td>
                    </tr>
		        </table>
                </div>
      		</div>
            <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

      		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'form_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
  	</form>

    <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('form_show_sub_category')): ?>
    	<div class="clsAdvancedFilterSearch clsShowHideFilter" id="">
        	<a href="javascript:void(0)" id="show_link" class="clsShow clsShowFilterSearch"  <?php if ($this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> onclick="divShowHide('showHideSubCategory', 'show_link', 'hide_link')"><?php echo $this->_tpl_vars['LANG']['articlelist_showarticle_subcategory']; ?>
</a>
            <a href="javascript:void(0)" id="hide_link" <?php if (! $this->_tpl_vars['myobj']->chkAdvanceResultFound()): ?>  style="display:none" <?php endif; ?> class="clsHide clsHideFilterSearch"  onclick="divShowHide('showHideSubCategory', 'show_link', 'hide_link')"><?php echo $this->_tpl_vars['LANG']['articlelist_hidearticle_subcategory']; ?>
</a>
        </div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

     	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_content_top')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    	<div class="clsArticlesSubcategoryContent" id="showHideSubCategory" style="display:none"><h2><span><?php echo $this->_tpl_vars['LANG']['articlelist_category_title']; ?>
</span></h2>
        	<div id="selShowAllShoutouts">
            	<?php $_from = $this->_tpl_vars['populateSubCategories_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['scKey'] => $this->_tpl_vars['scValue']):
?>
               		<div>
                    	<ul class="clsArticlesSubCategory">
                        	<li><a href="<?php echo $this->_tpl_vars['scValue']['article_list_url']; ?>
" title="<?php echo $this->_tpl_vars['scValue']['article_category_name_manual']; ?>
"><?php echo $this->_tpl_vars['scValue']['article_category_name_manual']; ?>
</a></li>
                        </ul>
                     </div>
            	<?php endforeach; else: ?>
                	<div id="selMsgError">
                    	<p>
                        	<?php echo $this->_tpl_vars['LANG']['articlelist_no_sub_categories_found']; ?>

                    	</p>
                	</div>
            	<?php endif; unset($_from); ?>
        	</div>
		</div>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

 		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_content_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>

	<div id="selLeftNavigation">
		<!-- Delete Single Articles -->
	    <div id="selMsgConfirm" class="clsPopupConfirmation" style="display:none;">
	    	<p id="msgConfirmText"></p>
	      	<form name="msgConfirmform" id="msgConfirmform" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
				<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;
			    <input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
			    <input type="hidden" name="act" id="act" />
			    <input type="hidden" name="article_id" id="article_id" />
	      	</form>
	    </div>
        <!-- Delete Multi Articles -->
        <div id="selMsgConfirmMulti" class="clsPopupConfirmation" style="display:none;">
          <p id="msgConfirmTextMulti"><?php echo $this->_tpl_vars['LANG']['articlelist_multi_delete_confirmation']; ?>
</p>
          <form name="msgConfirmformMulti" id="msgConfirmformMulti" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
		  	<input type="submit" class="clsSubmitButton" name="yes" id="yes" value="<?php echo $this->_tpl_vars['LANG']['common_yes_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" />&nbsp;
	        <input type="button" class="clsSubmitButton" name="no" id="no" value="<?php echo $this->_tpl_vars['LANG']['common_no_option']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" onclick="return hideAllBlocks()" />
	        <input type="hidden" name="article_id" id="article_id" />
	        <input type="hidden" name="act" id="act" />
          </form>
        </div>

        <div id="selEditArticleComments" class="clsPopupConfirmation" style="display:none;"> </div>
            <?php if ($this->_tpl_vars['myobj']->isShowPageBlock('my_articles_form')): ?>
            	<div id="selArticleListDisplay" class="clsLeftSideDisplayTable">
                	<?php if ($this->_tpl_vars['myobj']->isResultsFound()): ?>
                    	<?php if ($this->_tpl_vars['CFG']['admin']['navigation']['top']): ?>
    						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                         	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    	<?php endif; ?>
                        <form name="articleListForm" id="articleListForm" method="post" action="<?php echo $this->_tpl_vars['myobj']->getCurrentUrl(); ?>
" autocomplete="off">
                        	<?php if (isMember ( ) && ( ( $this->_tpl_vars['myobj']->getFormField('user_id') == 0 && $this->_tpl_vars['CFG']['user']['user_id'] ) || ( $this->_tpl_vars['myobj']->getFormField('user_id') == $this->_tpl_vars['CFG']['user']['user_id'] ) )): ?>
		                        <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myarticles' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritearticles' || $this->_tpl_vars['myobj']->getFormField('pg') == 'toactivate' || $this->_tpl_vars['myobj']->getFormField('pg') == 'notapproved' || $this->_tpl_vars['myobj']->getFormField('pg') == 'draftarticle' || $this->_tpl_vars['myobj']->getFormField('pg') == 'infuturearticle' || $this->_tpl_vars['myobj']->getFormField('pg') == 'publishedarticle'): ?>
                                    <div class="clsOverflow clsCheckAllItems">
	                            	<div id="selCheckAllItems" class="clsFloatLeft">
                                    <span class="clsCheckItem">
	                                	<input type="checkbox" class="clsCheckRadio" name="check_all" onclick="CheckAll(document.articleListForm.name, document.articleListForm.check_all.name)" />
	                                  	<input type="button" class="clsSubmitButton" name="delete_submit" id="delete_submit" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" value="<?php echo $this->_tpl_vars['LANG']['articlelist_delete_submit']; ?>
" onclick="if(getMultiCheckBoxValue('articleListForm', 'check_all', '<?php echo $this->_tpl_vars['LANG']['common_check_atleast_one']; ?>
', '<?php echo $this->_tpl_vars['myobj']->anchor; ?>
', -100, -500)) Confirmation('selMsgConfirmMulti', 'msgConfirmformMulti', Array('article_id','act', 'msgConfirmTextMulti'), Array(multiCheckValue, 'delete', '<?php echo $this->_tpl_vars['LANG']['articlelist_multi_delete_confirmation']; ?>
'), Array('value','value', 'innerHTML'), 0, 0);" />
                                        </span>
	                                </div>
                                    </div>
	                            <?php endif; ?>
                            <?php endif; ?>

                            <p><a href="#" id="<?php echo $this->_tpl_vars['myobj']->anchor; ?>
"></a></p>
                            <div id="selDisplayTable">
                            	<?php $_from = $this->_tpl_vars['showArticleList_arr']['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['salKey'] => $this->_tpl_vars['salValue']):
?>
                                	<div class="clsArticleListContent">
                                    	<a href="#" id="<?php echo $this->_tpl_vars['salValue']['anchor']; ?>
"></a>
                                        <?php if ($this->_tpl_vars['salValue']['record']['article_status'] == 'Locked'): ?>
                                            <div class="clsHomeDispContent">
                                              <h3 class="clsTitleLink"><?php echo $this->_tpl_vars['salValue']['row_article_title_manual']; ?>
</h3>
                                              <!--<p><?php echo $this->_tpl_vars['salValue']['row_article_caption_manual']; ?>
</p>-->
                                              <p class="clsAddedDate"><?php echo $this->_tpl_vars['LANG']['articlelist_added']; ?>
&nbsp;<?php echo $this->_tpl_vars['salValue']['record']['date_added']; ?>
</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="clsHomeDispContent">
                                            	
												
												<div class="clsOverflow <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlenew' || $this->_tpl_vars['myobj']->getFormField('pg') == '' || $this->_tpl_vars['myobj']->getFormField('pg') == 'userarticlelist' || $this->_tpl_vars['myobj']->getFormField('pg') == 'articlerecent' || $this->_tpl_vars['myobj']->getFormField('pg') == 'articletoprated' || $this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostviewed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostdiscussed' || $this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostfavorite' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritearticles'): ?>clsAllArticles<?php endif; ?>">
													<?php if (isMember ( ) && $this->_tpl_vars['salValue']['record']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
														<?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'myarticles' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myfavoritearticles' || $this->_tpl_vars['myobj']->getFormField('pg') == 'toactivate' || $this->_tpl_vars['myobj']->getFormField('pg') == 'notapproved' || $this->_tpl_vars['myobj']->getFormField('pg') == 'draftarticle' || $this->_tpl_vars['myobj']->getFormField('pg') == 'infuturearticle' || $this->_tpl_vars['myobj']->getFormField('pg') == 'publishedarticle'): ?>
                                                				<div class="clsFloatLeft clsChkBox clsListChkBox">
																	<input type="checkbox" class="clsCheckRadio" name="article_ids[]"  value="<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
" tabindex="<?php echo smartyTabIndex(array(), $this);?>
" <?php echo $this->_tpl_vars['salValue']['article_ids_checked']; ?>
/>
                                                     			</div>
                                                     	<?php endif; ?>
                                                     <?php endif; ?>
													<div class="clsFloatLeft clsListTitle">
													<h3 class="clsTitleLink">
																												<?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'publishedarticle'): ?>
					                                    	<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-published.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_publishedarticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_publishedarticle_title']; ?>
"/>
						                                <?php elseif ($this->_tpl_vars['myobj']->getFormField('pg') == 'toactivate'): ?>
					                                    	<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-toactivate.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_toactivatearticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_toactivatearticle_title']; ?>
"/>
						                                <?php elseif ($this->_tpl_vars['myobj']->getFormField('pg') == 'draftarticle'): ?>
					                                    	<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-draft.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_draftarticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_draftarticle_title']; ?>
"/>
						                                <?php elseif ($this->_tpl_vars['myobj']->getFormField('pg') == 'infuturearticle'): ?>
					                                    	<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-infuture.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_infuturearticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_infuturearticle_title']; ?>
"/>
						                                <?php elseif ($this->_tpl_vars['myobj']->getFormField('pg') == 'notapproved'): ?>
					                                    	<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-notapproved.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_notapprovedarticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_notapprovedarticle_title']; ?>
"/>
					                                    <?php elseif ($this->_tpl_vars['myobj']->getFormField('pg') == 'myarticles'): ?>
					                                    	<?php if ($this->_tpl_vars['salValue']['record']['article_status'] == 'Ok'): ?>
	                                							<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-published.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_publishedarticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_publishedarticle_title']; ?>
"/>
															<?php elseif ($this->_tpl_vars['salValue']['record']['article_status'] == 'ToActivate'): ?>
	                                							<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-toactivate.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_toactivatearticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_toactivatearticle_title']; ?>
"/>
	                                						<?php elseif ($this->_tpl_vars['salValue']['record']['article_status'] == 'Draft'): ?>
	                                							<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-draft.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_draftarticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_draftarticle_title']; ?>
"/>
	                                						<?php elseif ($this->_tpl_vars['salValue']['record']['article_status'] == 'InFuture'): ?>
	                                							<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-infuture.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_infuturearticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_infuturearticle_title']; ?>
"/>
	                                						<?php elseif ($this->_tpl_vars['salValue']['record']['article_status'] == 'Not Approved'): ?>
	                                							<img src="<?php echo $this->_tpl_vars['CFG']['site']['article_url']; ?>
/design/templates/<?php echo $this->_tpl_vars['CFG']['html']['template']['default']; ?>
/root/images/<?php echo $this->_tpl_vars['CFG']['html']['stylesheet']['screen']['default']; ?>
/icon-notapproved.gif" alt="<?php echo $this->_tpl_vars['LANG']['articlelist_notapprovedarticle_title']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_notapprovedarticle_title']; ?>
"/>
	                                						<?php endif; ?>
					                                    <?php endif; ?>
														<a href="<?php echo $this->_tpl_vars['salValue']['view_article_link']; ?>
" title="<?php echo $this->_tpl_vars['salValue']['row_article_title']; ?>
"><?php echo $this->_tpl_vars['salValue']['row_article_title_manual']; ?>
</a>&nbsp;&nbsp;
													</h3>
													</div>
                                                </div>

	                                        	<div class="clsArticleDetails">
                                                <p>
                                                  <?php if ($this->_tpl_vars['salValue']['record']['article_status'] == 'Ok'): ?>
                                                                <span class="clsDateRecord"><?php echo $this->_tpl_vars['LANG']['articlelist_date_published']; ?>
&nbsp;<?php echo $this->_tpl_vars['salValue']['record']['date_published']; ?>
</span>
                                                            <?php else: ?>
                                                                <span class="clsDateRecord"><?php echo $this->_tpl_vars['LANG']['articlelist_date_added']; ?>
&nbsp;<?php echo $this->_tpl_vars['salValue']['record']['date_added']; ?>
</span>
                                                            <?php endif; ?>
                                                            <?php if (isMember ( ) && $this->_tpl_vars['salValue']['record']['user_id'] == $this->_tpl_vars['CFG']['user']['user_id']): ?>
                                                                <span class="clsArticleEdit">
                                                               		<a href="<?php echo $this->_tpl_vars['salValue']['article_writing_url_ok']; ?>
" title="<?php echo $this->_tpl_vars['LANG']['articlelist_edit_article']; ?>
"><?php echo $this->_tpl_vars['LANG']['articlelist_edit_article']; ?>
</a>
                                                                </span>
                                                                <span class="clsArticleDelete">
                                                                    <a href="#" class="" title="<?php echo $this->_tpl_vars['LANG']['articlelist_delete_submit']; ?>
" onclick="return Confirmation('selMsgConfirm', 'msgConfirmform', Array('act','article_id', 'msgConfirmText'), Array('delete','<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
','<?php echo $this->_tpl_vars['LANG']['articlelist_delete_confirmation']; ?>
'), Array('value','value', 'innerHTML'), -100, -500);"><?php echo $this->_tpl_vars['LANG']['articlelist_delete_submit']; ?>
</a>
                                                                </span>
                                                            <?php endif; ?>
                                                     </p>
													<div id="articleUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
" class="clsCoolMemberActive"  style="display:none;" onmouseover="showUserInfoPopup('<?php echo $this->_tpl_vars['myobj']->getUrl('userdetail'); ?>
', '<?php echo $this->_tpl_vars['salValue']['record']['user_id']; ?>
', 'articleUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
');" onmouseout="hideUserInfoPopup('articleUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
')"></div>
	                                    			<p>
	                                    				<a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
"><span class="clsUserProfileImage" onmouseover="showUserInfoPopup('<?php echo $this->_tpl_vars['myobj']->getUrl('userdetail'); ?>
',
															'<?php echo $this->_tpl_vars['salValue']['record']['user_id']; ?>
', 'articleUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
');" onmouseout="hideUserInfoPopup('articleUserProfile_<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
')"></span></a>
													</p>

	                                    			<p class="clsViewTagsLink"><?php echo $this->_tpl_vars['salValue']['row_article_caption_manual']; ?>

                                                                                                        </p>
                                                    <div class="clsOverflow">
                                                        <p class="clsArticleTagDetails clsArticleTag">
                                                            <?php if ($this->_tpl_vars['myobj']->getFormField('article_tags') != ''): ?>
                                                                <?php $this->assign('article_tag', $this->_tpl_vars['myobj']->getFormField('article_tags')); ?>
                                                            <?php elseif ($this->_tpl_vars['myobj']->getFormField('tags') != ''): ?>
                                                                <?php $this->assign('article_tag', $this->_tpl_vars['myobj']->getFormField('tags')); ?>
                                                            <?php else: ?>
                                                                <?php $this->assign('article_tag', ''); ?>
                                                            <?php endif; ?>
                                                            <span><?php echo $this->_tpl_vars['LANG']['articlelist_search_article_tags']; ?>
:</span><?php if ($this->_tpl_vars['salValue']['record']['article_tags'] != ''): ?> <?php echo $this->_tpl_vars['myobj']->getArticleTagsLinks($this->_tpl_vars['salValue']['record']['article_tags'],13,$this->_tpl_vars['article_tag']); ?>
<?php endif; ?>
                                                        </p>
                                                        <p class="clsArticleViewDetails clsArticleCategegory">
                                                            <?php echo $this->_tpl_vars['LANG']['articlelist_article_category_name']; ?>
<?php echo $this->_tpl_vars['showArticleList_arr']['separator']; ?>
<span><?php echo $this->_tpl_vars['salValue']['row_article_category_name_manual']; ?>
</span>
                                                        </p>
                                                    </div>
                                                    <?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'notapproved' || $this->_tpl_vars['myobj']->getFormField('pg') == 'myarticles'): ?>
	                                    				<?php if ($this->_tpl_vars['salValue']['record']['article_status'] == 'Not Approved'): ?>
	                                    					<p class="clsViewAdminComment"><a id="adminComments<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
"  title="Admin Comments" href="#showAdminComments<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
"><?php echo $this->_tpl_vars['LANG']['articlelist_view_admin_comments']; ?>
</a></p>
                                                                  <div style="display: none;">
                                                                    <div id="showAdminComments<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
" class="clsArticleComments">
                                                                     <h2><?php echo $this->_tpl_vars['LANG']['articlelist_admin_comments_title']; ?>
</h2>
                                                                     <p><?php echo $this->_tpl_vars['salValue']['record']['article_admin_comments']; ?>
</p>																				                                                  					</div>
																																<?php echo '
																	<script type="text/javascript">
																		$Jq(document).ready(function() {
																		$Jq("#adminComments'; ?>
<?php echo $this->_tpl_vars['salValue']['record']['article_id']; ?>
<?php echo '").fancybox({
																		\'titlePosition\'		: \'inside\',
																		\'transitionIn\'		: \'none\',
																		\'transitionOut\'		: \'none\'
																		});
																		});
																	</script>
																'; ?>

															</div>
														<?php endif; ?>
													<?php endif; ?>

                                            <div class="clsArticleDetMiddle">
                                                <div class="clsArticleDetLeft">
                                                    <div class="clsArticleDetRight clsOverflow">
                                                    <div class="clsArticleUser">
                                                        <p class="">
                                                        	 <?php echo $this->_tpl_vars['LANG']['articlelist_added_by']; ?>

                                                             <a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
" class="cls15x15 clsImageBorder ClsImageContainer">
                                                        	 <img src="<?php echo $this->_tpl_vars['salValue']['member_image']['s_url']; ?>
" border="0" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['salValue']['name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 2) : smarty_modifier_truncate($_tmp, 2)); ?>
" title="<?php echo $this->_tpl_vars['salValue']['name']; ?>
"  <?php echo $this->_tpl_vars['myobj']->DISP_IMAGE(15,15,$this->_tpl_vars['salValue']['member_image']['s_width'],$this->_tpl_vars['salValue']['member_image']['s_height']); ?>
/></a>
                                                            <a href="<?php echo $this->_tpl_vars['salValue']['member_profile_url']; ?>
" title="<?php echo $this->_tpl_vars['salValue']['name']; ?>
"> <?php echo $this->_tpl_vars['salValue']['name']; ?>
</a>
                                                        </p>
                                                     </div>
                                                     <div class="clsArticleListDetails">
                                                        	<ul>
                                                            	<li>
                                                                    <span class="clsTotalComment"><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostdiscussed' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['salValue']['sum_total_comments']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['salValue']['record']['total_comments']; ?>
</span>
                                                                    <?php if ($this->_tpl_vars['salValue']['record']['total_comments'] > 1): ?><?php echo $this->_tpl_vars['LANG']['articlelist_comments']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['articlelist_comment']; ?>
<?php endif; ?>
                                                                </li>
                                                                <li>
                                                                    <span><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostviewed' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['salValue']['sum_total_views']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['salValue']['record']['total_views']; ?>
</span>
                                                                    <?php if ($this->_tpl_vars['salValue']['record']['total_views'] > 1): ?><?php echo $this->_tpl_vars['LANG']['articlelist_views']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['articlelist_view']; ?>
<?php endif; ?>
                                                                </li>
                                                                <li>
                                                                    <span><?php if ($this->_tpl_vars['myobj']->getFormField('pg') == 'articlemostfavorite' && $this->_tpl_vars['myobj']->getFormField('action') != '' && $this->_tpl_vars['myobj']->getFormField('action') != 0): ?><?php echo $this->_tpl_vars['salValue']['sum_total_favorites']; ?>
/<?php endif; ?><?php echo $this->_tpl_vars['salValue']['record']['total_favorites']; ?>
</span>
                                                                    <?php if ($this->_tpl_vars['salValue']['record']['total_favorites'] > 1): ?><?php echo $this->_tpl_vars['LANG']['articlelist_favorites']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['articlelist_favorite']; ?>
<?php endif; ?>
                                                                </li>
                                                                <?php if ($this->_tpl_vars['salValue']['record']['article_attachment']): ?>
                                                                    <li>
                                                                        <span><?php echo $this->_tpl_vars['salValue']['record']['total_downloads']; ?>
&nbsp;</span>
                                                                        <?php if ($this->_tpl_vars['salValue']['record']['total_downloads'] > 1): ?><?php echo $this->_tpl_vars['LANG']['articlelist_downloads']; ?>
<?php else: ?><?php echo $this->_tpl_vars['LANG']['articlelist_download']; ?>
<?php endif; ?>
                                                                    </li>
                                                                <?php endif; ?>
                                                               	<li class="clsRatingDisplay">
                                                                <?php if ($this->_tpl_vars['myobj']->populateRatingDetails($this->_tpl_vars['salValue']['record']['rating'])): ?>
                                                                    <?php echo $this->_tpl_vars['myobj']->populateArticleRatingImages($this->_tpl_vars['salValue']['record']['rating'],'article'); ?>

                                                                <?php else: ?>
                                                                   <?php echo $this->_tpl_vars['myobj']->populateArticleRatingImages(0,'article'); ?>

                                                                <?php endif; ?>
                                                                (<span><?php echo $this->_tpl_vars['salValue']['record']['rating_count']; ?>
</span>)
                                                            </li>
                                                          </ul>
                                                        </div>
                                                    </div>
                                                 </div>
                                            </div>

                                        		</div>
                                        	</div>
                                       	<?php endif; ?>
                                    </div>
								<?php endforeach; endif; unset($_from); ?>
                                <?php if ($this->_tpl_vars['showArticleList_arr']['extra_td_tr']): ?>
                                	<div>&nbsp;</div>
                                <?php endif; ?>
                            </div>
                         </form>
                        <?php if ($this->_tpl_vars['CFG']['admin']['navigation']['bottom']): ?>
    						<?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

                            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'pagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <?php endif; ?>
                	<?php else: ?>
                    	<div id="selMsgAlert" class="clsNoArticlesFound">
                        	<p><?php echo $this->_tpl_vars['LANG']['articlelist_no_records_found']; ?>
</p>
                      	</div>
                	<?php endif; ?>
                </div>
            <?php endif; ?>
        <?php echo $this->_tpl_vars['myobj']->setTemplateFolder('general/','article'); ?>

       	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'box.tpl', 'smarty_include_vars' => array('opt' => 'article_list_bottom')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    	<!--end of rounded corners-->
	</div>
</div>